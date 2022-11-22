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
        while ($result = mysqli_fetch_array($user_results)) {
            $results[] = $result;
        }
        return $results;
    }
}
