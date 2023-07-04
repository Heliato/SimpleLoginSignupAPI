<?php

function verifUsernamePass($username) {
    $result = "ok";

    if (strlen($username) <= 3) {
        $result = "username_too_small";
    }
    else if (strlen($username) >= 16) {
        $result = "username_too_big";
    }
    else if (strpos($username, ' ') != false) {
        $result = "username_has_space";
    }
    else if (preg_match('/[^A-Za-z0-9]/', $username)) { 
        $result = "username_has_special_char";
    }

    return $result;
}

function verifEmailPass($email) {
    $result = false;

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, '@') !== false && strpos($email, '.') !== false) {
        $result = true;
    }

    return $result;
}

?>