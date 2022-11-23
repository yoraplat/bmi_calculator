<?php

namespace Scripts\Controllers;

use Scripts\Database\DatabaseService;

class HistoryController
{
    public static function index()
    {
        return file_get_contents(include './Scripts/Pages/history.php');
    }

    public static function userHistory()
    {
        $db = new DatabaseService();
        $user_results = $db->getUserHistory($_SESSION['user_id']);

        $results = [];
        while ($result = $user_results->fetch_assoc()) {
            $results[] = $result;
        }

        $chart_data = array_combine(array_column($results, 'id'), array_column($results, 'bmi'));

        return [
            'chart_data' => $chart_data,
            'results' => $results,
        ];
    }
}
