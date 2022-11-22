<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
</head>

<body>
    <?php require './Includes/navigation.php' ?>
    <h1>Register</h1>
    <form id="register_form" action="">
        <div>
            <label for="firstname">Voornaam</label>
            <input type="text" name="firstname" placeholder="Voornaam">
            <p id="firstname-error" class="error-msg"></p>
        </div>
        <div>
            <label for="lastname">Achternaam</label>
            <input type="text" name="lastname" placeholder="Achternaam">
            <p id="lastname-error" class="error-msg"></p>
        </div>
        <div>
            <label for="username">Gebruikersnaam</label>
            <input type="text" name="username" placeholder="Gebruikersnaam">
            <p id="username-error" class="error-msg"></p>
        </div>
        <div>
            <label for="gender">Geslacht</label>
            <select name="gender" id="gender">
                <option value="male">Man</option>
                <option value="female">Vrouw</option>
            </select>
            <p id="gender-error" class="error-msg"></p>
        </div>
        <div>
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" placeholder="Wachtwoord">
            <p id="password-error" class="error-msg"></p>
        </div>
        <button>submit</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $("#register_form").submit(function(event) {
            event.preventDefault();

            let input = $(this).serialize()

            $.ajax({
                url: 'http://localhost:5050/api/register',
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
                        window.location.href = "http://localhost:5050" + data.redirect_to;
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