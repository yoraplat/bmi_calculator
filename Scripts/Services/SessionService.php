<?php

namespace Scripts\Services;

class SessionService
{
    public function isAuthenticated()
    {
        session_start();
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
        session_start();
        session_destroy();

        // Redirect to login page
        header("Location: http://localhost:5050/login");
    }
}
