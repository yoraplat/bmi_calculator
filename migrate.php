<?php

$mysql_host = "localhost";
$mysql_database = "bmi_calculator";
$mysql_user = "root";
$mysql_password = "Test123!";

# MySQL with PDO_MYSQL  
$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);

$query = file_get_contents("./migration_1.sql");

$stmt = $db->prepare($query);

if ($stmt->execute())
    echo "Success";
else
    echo "Fail";
