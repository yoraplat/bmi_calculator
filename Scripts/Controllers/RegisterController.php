<?php

namespace Scripts\Controllers;

use Scripts\Database\DatabaseService;
use Scripts\Services\SessionService;

class RegisterController
{
    public static function index()
    {
        return file_get_contents(include './Scripts/Pages/register.php');
    }

    public static function post()
    {
        // Validate input
        $validated = self::validatePost($_POST);
        if (!empty($validated['errors'])) {
            return json_encode($validated);
        } else {
            $db = new DatabaseService();
            $user_found = $db->getUserByUsername($validated['data']['username']);
            if (!empty($user_found->num_rows) > 0) {
                return json_encode([
                    'errors' => ['username' => 'Gebruikersnaam is al in gebruik'],
                ]);
            }

            // Insert user into database
            $user_id = $db->insertUser([
                'firstname' => $validated['data']['firstname'],
                'lastname'  => $validated['data']['lastname'],
                'username'  => $validated['data']['username'],
                'gender'    => $validated['data']['gender'],
                'password'  => $validated['data']['password'],
            ])->insert_id;

            $session_service = new SessionService();
            $session_service->createAuthSession($user_id, $validated['data']['username']);

            return json_encode([
                'auth' => true,
                'redirect_to' => '/'
            ]);
        }
    }

    private function validatePost($request): array
    {
        // Sanitize input
        $firstname = htmlspecialchars($request['firstname']);
        $lastname = htmlspecialchars($request['lastname']);
        $username = htmlspecialchars($request['username']);
        $gender = htmlspecialchars($request['gender']);
        $password = htmlspecialchars($request['password']);

        $data_arr = [];
        $error_arr = [];
        // firstname required
        if (!empty($firstname)) {
            $data_arr['firstname'] = $firstname;
        } else {
            $error_arr['firstname'] = "Voornaam is verplicht";
        }
        // lastname required
        if (!empty($lastname)) {
            $data_arr['lastname'] = $lastname;
        } else {
            $error_arr['lastname'] = "Achternaam is verplicht";
        }
        // username required
        if (!empty($username)) {
            $data_arr['username'] = $username;
        } else {
            $error_arr['username'] = "Gebruikersnaam is verplicht";
        }
        // password required
        if (!empty($password)) {
            $data_arr['password'] = $password;
        } else {
            $error_arr['password'] = "Wachtwoord is verplicht";
        }
        // gender required
        $gender_types = ['male', 'female'];
        if (!empty($gender) && in_array($gender, $gender_types)) {
            $data_arr['gender'] = $gender;
        } else {
            $error_arr['gender'] = "Geslacht is verplicht";
        }

        if (!empty($error_arr)) {
            return ['errors' => $error_arr];
        } else {
            return ['data' => $data_arr];
        }
    }
}
