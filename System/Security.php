<?php
    class Security {
        public static function setCsrfSession($csrfToken) {
            $_SESSION['csrfToken'] = $csrfToken;
        }

        public static function getCsrfSession() {
            return $_SESSION['csrfToken'];
        }

        public static function generateCsrfToken() {
            if (!session_id()) {
                session_start();
            }
            $token = bin2hex(random_bytes(20));
            self::setCsrfSession($token);
            return $token;
        }

        public static function checkCsrfToken($token) {
            return $token === self::getCsrfSession();
        }
    }