<?php
    class ApiController {
        public function index() {
            if (isset($_GET['apikey'])) {
                $pdo = (new Db)->connect();
                // searching for user with such api-key
                $keyMatch = Users::findByKey($pdo, $_GET['apikey']);
                if ($keyMatch) {
                    $users = Users::getPublicData($pdo);
                    if (isset($_GET['type']) && ($_GET['type'] == 'json' || $_GET['type'] == 'xml')) {
                        $this->response($users, $_GET['type']);
                    } else {
                        // if type is incorrect, send json
                        $this->response($users, 'json');
                    }
                } else {
                    echo json_encode(["error" => "Incorrect key"]);
                }
            } else {
                header("HTTP/1.0 400 Bad Request");
                echo json_encode(["error" => "Please, specify key"]);
            }
        }

        private function response($users, string $type) {
            if ($type == 'json') {
                // change name of image to link
                foreach ($users as &$user) {
                    foreach ($user as $property => $value) {
                        if ($property == 'photo') {
                            $user[$property] = $_SERVER['SERVER_NAME'] . "/images/" . $value;
                        }
                    }
                }
                header('Content-Type:application/json');
                echo json_encode($users);
            } else if ($type == 'xml') {
                $xml = new SimpleXMLElement('<xml/>');
                $allusers = $xml->addChild('users');
                foreach ($users as $user) {
                    $userrow = $allusers->addChild('user');
                    foreach ($user as $property => $value) {
                        if ($property == 'photo') {
                            // change name of image to link
                            $value = $_SERVER['SERVER_NAME'] . "/images/" . $value;
                        }
                        $userrow->addChild($property, $value);
                    }
                }
                header('Content-type: text/xml');
                echo $xml->asXML();
            }
        }
    }