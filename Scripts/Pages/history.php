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
            <canvas id="chart" width="1000" height="200"></canvas>
            <?php

            use Scripts\Controllers\HistoryController;

            $results = HistoryController::userHistory();

            foreach ($results['results'] as $result) {
                echo '
        <div class="history-element">
            <p class="strong">' . $result['date'] . '</p>
            <p>Gewicht: ' . $result['mass'] . 'kg</p>
            <p>Lengte: ' . $result['length'] . 'cm</p>
            <p style="margin-top:10px">Resultaat: <span class="strong">' . $result['result'] . '</span></p>
        </div>
        ';
            }

            if (count($results['results']) < 1) {
                echo '<p>Er zijn nog geen resultaten</p>';
            }
            ?>
        </div>
    </div>

    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        const data = <?php echo json_encode($results['chart_data']) ?>;
        console.log(data)
        const ctx = document.getElementById('chart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                // labels: data,
                datasets: [{
                    label: 'Evolutie BMI',
                    data: data,
                    tension: 0.3
                }, ],
            },
        });
    </script>
</body>

</html>