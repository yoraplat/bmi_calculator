<div class="nav">
    <?php

    use Scripts\Services\SessionService;

    $session_service = new SessionService;
    if ($session_service->isAuthenticated()) {
        echo '
        <a class="nav_item" href="/">Dashboard</a>
        <a class="nav_item" href="/history">Geschiedenis</a>
        <a class="nav_item" href="/api/logout">Uitloggen</a>
        ';
    } else {
        echo '
        <a class="nav_item" href="/login">Inloggen</a>
        <a class="nav_item" href="/register">Registeren</a>
        ';
    }
    ?>
</div>