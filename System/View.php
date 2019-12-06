<?php
    class View {
        public static function render(string $viewName, array $data = []) {
            require('views/layout.php');
        }
    }