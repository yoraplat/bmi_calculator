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
    <?php include './Includes/navigation.php' ?>
    <div class="page_content">
        <h1 class="page_title">Welkom <?php echo $_SESSION['username'] ?></h1>
        <form id="calculator_form" action="" method="POST">
            <div class="form-input">
                <!--<label for="weight">Gewicht (kg)</label>-->
                <input type="number" min="1" name="weight" placeholder="Gewicht (kg)">
                <p id="weight-error" class="error-msg"></p>
            </div>
            <div>
                <!--<label for="length">Lengthe (cm)</label>-->
                <input type="number" min="1" name="length" placeholder="Lengthe (cm)">
                <p id="length-error" class="error-msg"></p>
            </div>
            <div>
                <!--<label for="age">Leeftijd (jaar)</label>-->
                <input type="number" min="1" name="age" placeholder="Leeftijd (jaar)">
                <p id="age-error" class="error-msg"></p>
            </div>

            <input type="submit" value="Bereken BMI">
        </form>

        <h2 id="bmi"></h2>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $("#calculator_form").submit(function(event) {
            event.preventDefault();

            let input = $(this).serialize()

            $.ajax({
                url: "<?php echo $_ENV['HOST'] ?>" + '/api/calculate',
                type: 'post',
                dataType: 'json',
                data: input,
                success: function(data) {
                    // Clear errors
                    $('.error-msg').empty()
                    if (data.errors) {
                        displayErrors(data)
                    } else {
                        displayBMI(data);
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        });

        function displayBMI(bmi) {
            $('#bmi').html(bmi)
        }

        function displayErrors(errors) {
            $.each(errors.errors, function(index, error) {
                $('#' + index + '-error').html(error)
            })
        }
    </script>
</body>

</html>