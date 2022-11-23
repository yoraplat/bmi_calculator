<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/reset.css">
    <link rel="stylesheet" href="../../Styles/stylesheet.css">
    <title>BMI Calculator</title>
</head>

<body>
    <?php require './Includes/navigation.php' ?>
    <div class="page_content">
        <h1 class="page_title">Login</h1>
        <form id="login_form" action="">
            <div>
                <!-- <label for="username">Gebruikersnaam</label> -->
                <input type="text" name="username" placeholder="Gebruikersnaam">
                <p id="username-error" class="error-msg"></p>
            </div>
            <div>
                <!-- <label for="password">Wachtwoord</label> -->
                <input type="password" name="password" placeholder="Wacthwoord">
                <p id="password-error" class="error-msg"></p>
            </div>
            <p id="login-error" class="error-msg"></p>
            <button>submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $("#login_form").submit(function(event) {
            event.preventDefault();

            let input = $(this).serialize()

            $.ajax({
                url: "<?php echo $_ENV['HOST'] ?>" + '/api/login',
                type: 'post',
                dataType: 'json',
                data: input,
                success: function(data) {
                    data = JSON.parse(data)
                    // Clear errors
                    $('.error-msg').empty()
                    if (data.errors) {
                        displayErrors(data)
                    } else if (data.auth) {
                        // Return homepage
                        window.location.href = "<?php echo $_ENV['HOST'] ?>" + data.redirect_to;
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        });

        function displayErrors(errors) {
            $.each(errors.errors, function(index, error) {
                $('#' + index + '-error').html(error)
            })
        }
    </script>
</body>

</html>