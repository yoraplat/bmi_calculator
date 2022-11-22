# Setup

Maak een database aan met de naam "bmi_calculator"

Voer uit in terminal:
- php migrate.php

# Host het project
Check dat $_ENV['PORT'] & $_ENV['HOST'] in index.php gelijk zijn aan de host en port waarop het project wordt gehost

# Opmerkingen

in index op lijn 27 heb ik error_reporting(1) geplaatst omdat ik steeds "file_get_contents(1): Failed to open stream: No such file or directory" kreeg
terwijl de file wel ingeladen is