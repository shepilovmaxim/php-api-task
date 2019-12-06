<?php 
    class Db {
        private $servername;
        private $username;
        private $password;
        private $dbname;

        public function connect() {
            $this->servername = "eu-cdbr-west-02.cleardb.net";
            $this->username = "bc74fe54f3dbc7";
            $this->password = "0f226e9b";
            $this->dbname = "heroku_2d1bb532abb7b5e";

            /* $this->servername = "task.test";
            $this->username = "root";
            $this->password = "secret";
            $this->dbname = "task"; */

            try {
                $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ];
                $pdo = new PDO($dsn, $this->username, $this->password, $options);
                return $pdo;
            } catch (PDOException $e) {
                $errorController = new ErrController;
                $errorController->index($e->getMessage());
            }
        }
    }