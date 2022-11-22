<?php

namespace Scripts\Controllers;

use Scripts\Database\DatabaseService;
use Scripts\Services\SessionService;

class LoginController
{
    public static function index()
    {
        return file_get_contents(include './Scripts/Pages/login.php');
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

            $is_success = false;
            while ($row = $user_found->fetch_assoc()) {
                // Should only contain one row
                if (!empty($row)) {
                    $hashed_password = $row["password"];
                    $username = $row["username"];
                    $user_id = $row["id"];
                    if (password_verify($validated['data']["password"], $hashed_password)) {
                        $is_success = true;
                    }
                }
            }

            if ($is_success) {
                $session_service = new SessionService();
                $session_service->createAuthSession($user_id, $username);
                return json_encode([
                    'auth' => true,
                    'redirect_to' => '/'
                ]);
            } else {
                return json_encode(['data' => 'Gebruikersnaam en/of wachtwoord komen niet overeen']);
            }
        }
    }

    private function validatePost($request): array
    {
        // Sanitize input
        $username = htmlspecialchars($request['username']);
        $password = htmlspecialchars($request['password']);

        $data_arr = [];
        $error_arr = [];

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

        if (!empty($error_arr)) {
            return ['errors' => $error_arr];
        } else {
            return ['data' => $data_arr];
        }
    }
}
