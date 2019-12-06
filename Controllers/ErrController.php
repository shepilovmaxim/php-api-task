<?php
    class ErrController {
        public function index (string $message) {
            View::render('error', [ 'message' => $message ]);
        }
    }
