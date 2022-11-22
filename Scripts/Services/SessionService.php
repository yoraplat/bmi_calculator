<?php

namespace Scripts\Services;

class SessionService
{
    public function isAuthenticated()
    {
        self::createSession();
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            return true;
        } else {
            return false;
        }
    }


    public function createAuthSession(int $user_id, string $username)
    {
        session_start();
        $_SESSION["login"] = true;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
    }

    public function logout()
    {
        self::createSession();
        session_destroy();

        // Redirect to login page
        header("Location: " .  $_ENV['HOST'] . "/login");
    }

    public function createSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
}
