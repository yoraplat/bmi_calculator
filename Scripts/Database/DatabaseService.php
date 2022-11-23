<?php

namespace Scripts\Database;

use mysqli;

class DatabaseService
{
    public function insertUser(array $data)
    {
        // Create connection
        $conn = new mysqli($_ENV['servername'], $_ENV['serveruser'], $_ENV['serverpass'], $_ENV['dbname']);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, gender, password) VALUES(?, ?, ?, ?, ?);");

        // Check if preparing is successful
        if (!$stmt) {
            die('Preparing statement failed');
        }

        $stmt->bind_param("sssss", $firstname, $lastname, $username, $gender, $password);

        // set parameters and execute
        $firstname = $data['firstname'];
        $lastname  = $data['lastname'];
        $username  = $data['username'];
        $gender    = $data['gender'];
        $password  = crypt($data['password'], 'qsdqsd');
        $stmt->execute();

        return $stmt;

        $stmt->close();
        $conn->close();
    }

    public function insertResult(array $data)
    {
        // Create connection
        $conn = new mysqli($_ENV['servername'], $_ENV['serveruser'], $_ENV['serverpass'], $_ENV['dbname']);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO results (age, mass, length, result, date, bmi, user_id) VALUES(?, ?, ?, ?, ?, ?, ?);");

        // Check if preparing is successful
        if (!$stmt) {
            die('Preparing statement failed');
        }

        $stmt->bind_param("sssssss", $age, $mass, $length, $result, $date, $bmi, $user_id);

        // set parameters and execute
        $age     = $data['age'];
        $mass    = $data['mass'];
        $length  = $data['length'];
        $result  = $data['result'];
        $date    = $data['date'];
        $bmi    = $data['bmi'];
        $user_id = $_SESSION['user_id'];
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }

    public function getUserByUsername(string $username)
    {
        // Create connection
        $conn = new mysqli($_ENV['servername'], $_ENV['serveruser'], $_ENV['serverpass'], $_ENV['dbname']);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");

        // Check if preparing is successful
        if (!$stmt) {
            die('Preparing statement failed');
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result();

        $stmt->close();
        $conn->close();
    }

    public function getUserHistory(string $user_id)
    {
        // Create connection
        $conn = new mysqli($_ENV['servername'], $_ENV['serveruser'], $_ENV['serverpass'], $_ENV['dbname']);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM results WHERE user_id=?");

        // Check if preparing is successful
        if (!$stmt) {
            die('Preparing statement failed');
        }

        $stmt->bind_param("s", $user_id);
        $stmt->execute();

        return $stmt->get_result();

        $stmt->close();
        $conn->close();
    }
}
