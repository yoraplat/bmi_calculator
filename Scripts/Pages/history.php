<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <link rel="stylesheet" href="../../Styles/reset.css">
    <link rel="stylesheet" href="../../Styles/stylesheet.css">
</head>

<body>
    <?php require './Includes/navigation.php' ?>
    <div class="page_content">
        <h1 class="page_title">Geschiedenis</h1>
        <div class="history">
            <?php

            use Scripts\Controllers\HistoryController;

            $results = HistoryController::userHistory();

            foreach ($results as $result) {
                echo '
        <div class="history-element">
            <p class="strong">' . $result['date'] . '</p>
            <p>Gewicht: ' . $result['mass'] . 'kg</p>
            <p>Lengte: ' . $result['length'] . 'cm</p>
            <p style="margin-top:10px">Resultaat: <span class="strong">' . $result['result'] . '</span></p>
        </div>
        ';
            }

            if (count($results) < 1) {
                echo '<p>Er zijn nog geen resultaten</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</body>

</html>