<div>
    <?php

    use Scripts\Services\SessionService;

    $session_service = new SessionService;
    if ($session_service->isAuthenticated()) {
        echo '<a href="/">Dashboard</a>
        <a href="/history">Geschiedenis</a>
        <a href="/api/logout">Logout</a>';
    } else {
        echo '<a href="/login">Login</a>
        <a href="/register">Registeren</a>';
    }
    ?>
</div>