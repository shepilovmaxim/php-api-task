<?php
    class Auth {
        public static function guest() {
            if (self::loggedIn()) {
                header("Location: /users");
                die();
            }
        }

        public static function loggedIn() {
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                return true;
            } else {
                return false;
            }
        }
    }