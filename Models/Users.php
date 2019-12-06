<?php
    class Users {
        public static function getAll($pdo) {
            $data = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPublicData($pdo) {
            $data = $pdo->query("SELECT name, email, photo FROM users")->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function findByEmail($pdo, string $email) {
            $sql = "SELECT * FROM `users` WHERE `email` = ?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email]);
            $data = $stm->fetch();
            return $data;
        }

        public static function findByKey($pdo, string $key) {
            $sql = "SELECT * FROM `users` WHERE `key` = ?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$key]);
            $data = $stm->fetch();
            return $data;
        }

        public static function create($pdo, string $name, string $password, string $email, string $imageName) {
            try {
                // generate api-key and hash password
                $key = bin2hex(random_bytes(16));
                $hashed = password_hash($password, PASSWORD_DEFAULT, ['cost' => '12']);
                $query = 'INSERT INTO `users`(`name`, `email`, `photo`, `key`, `password`) VALUES(:name, :email, :photo, :key, :password)';
                $params = [
                    ':name' => $name,
                    ':email' => $email,
                    ':photo' => $imageName,
                    ':key' => $key,
                    ':password' => $hashed
                ];
                $pdo->beginTransaction();
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $pdo->commit();
                return $key;
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "Database error: ".$e->getMessage();
                die();
            }
        }
    }