<?php
  class UsersController {
      public function index() {
          $pdo = (new Db)->connect();
          $users = Users::getPublicData($pdo);
          View::render('users', $users);
      }

      public function login() {
          Auth::guest();
          if ($_SERVER["REQUEST_METHOD"] == "GET") {
              View::render('login');
          } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $pdo = (new Db)->connect();
              if ($loggedUser = Validator::validateLogin($pdo)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $loggedUser['email'];
                $_SESSION['key'] = $loggedUser['key'];
                echo json_encode(["redirect" => "/users"]);
              }
          }
      }

      public function registration() {
          Auth::guest();
          if ($_SERVER["REQUEST_METHOD"] == "GET") {
              Security::generateCsrfToken();
              View::render('registration');
          } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $pdo = (new Db)->connect();
              if ($data = Validator::validateRegister($pdo)) {
                  $name = $data['name'];
                  $email = $data['email'];
                  $password = $data['password'];
                  $imageName = $data['imageName'];
                  $apikey = Users::create($pdo, $name, $password, $email, $imageName);
                  $_SESSION['loggedin'] = true;
                  $_SESSION['email'] = $email;
                  $_SESSION['key'] = $apikey;
                  echo json_encode(["redirect" => "/users"]);
              }
          }
      }

      public function logout() {
          if (Auth::loggedIn()) {
              session_destroy();
              header("Location: /users/login");
              die();
          } else {
              header("Location: /users");
              die();
          }
      }
  }