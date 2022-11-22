<?php

namespace Scripts\Controllers;

use DateTime;
use Scripts\Database\DatabaseService;

class PageController
{
    public static function index()
    {
        return file_get_contents(include './Scripts/Pages/homepage.php');
    }

    public static function post()
    {
        // Validate input
        $validated = self::validatePost($_POST);

        if (isset($validated['errors'])) {
            return json_encode($validated);
        } else {
            // Calculate bmi
            $bmi = self::calculateBMI($validated['data']['weight'], $validated['data']['length'], $validated['data']['age']);

            if (isset($bmi['errors'])) {
                return json_encode($bmi);
            }

            $date = new DateTime();
            $database_service = new DatabaseService();
            $database_service->insertResult([
                'age'     => 1,
                'mass'    => $validated['data']['weight'],
                'length'  => $validated['data']['length'],
                'result'  => $bmi,
                'date'    => $date->format('Y-m-d H:i:s'),
                'user_id' => $_SESSION['user_id'],
            ]);

            return json_encode($bmi);
        }
    }

    private function calculateBMI(int $weight, int $length, int $age)
    {
        $bmi = ($weight / $length / $length) * 10000;

        $result = self::BMIByAge($age, $bmi);

        return $result;
    }

    private function BMIByAge(int $age, int $bmi)
    {
        switch ($age) {
            case $age >= 18 && $age <= 69:
                switch ($bmi) {
                    case $bmi < 18.5:
                        return 'Ondergewicht';
                        break;
                    case $bmi >= 18.5 && $bmi <= 25:
                        return 'Gezond gewicht';
                        break;
                    case $bmi > 25 && $bmi < 30:
                        return 'Overgewicht';
                        break;
                    case $bmi > 30:
                        return 'Ernstig overgewicht';
                        break;
                }
                break;
            case $age >= 70:
                switch ($bmi) {
                    case $bmi < 22:
                        return 'Ondergewicht';
                        break;
                    case $bmi >= 22 && $bmi >= 28:
                        return 'Gezond gewicht';
                        break;
                    case $bmi > 28 && $bmi < 30:
                        return 'Overgewicht';
                        break;
                    case $bmi > 30:
                        return 'Ernstig overgewicht';
                        break;
                }
                break;
        }
    }

    private function validatePost($request): array
    {
        // Sanitize input
        $weight = htmlspecialchars($request['weight']);
        $length = htmlspecialchars($request['length']);
        $age    = htmlspecialchars($request['age']);

        $data_arr = [];
        $error_arr = [];

        // Weight required
        if (isset($weight) && filter_var($weight, FILTER_VALIDATE_INT)) {
            $data_arr['weight'] = $weight;
        } else {
            $error_arr['weight'] = "Gewicht is verplicht";
        }

        // Length required
        if (isset($length) && filter_var($length, FILTER_VALIDATE_INT)) {
            $data_arr['length'] = $length;
        } else {
            $error_arr['length'] = "Lengte is verplicht";
        }

        // Age required
        if (isset($age) && filter_var($age, FILTER_VALIDATE_INT) && $age >= 18) {
            $data_arr['age'] = $age;
        } else {
            $error_arr['age'] = "Leeftijd is verplicht (18j of hoger)";
        }

        if (!empty($error_arr)) {
            return ['errors' => $error_arr];
        } else {
            return ['data' => $data_arr];
        }
    }
}
