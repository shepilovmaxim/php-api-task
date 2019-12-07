<?php
    class Validator {
        public static function validateLogin($pdo) {
            if (isset($_POST['csrf_token']) && Security::checkCsrfToken($_POST['csrf_token'])) {
                if (!empty($_POST['email']) && !empty($_POST['password'])) {
                    $user = Users::findByEmail($pdo, $_POST['email']);
                    if ($user) {
                        $passwordMatch = password_verify($_POST['password'], $user['password']);
                        if ($passwordMatch) {
                            return $user;
                        } else {
                            echo json_encode(["message" => "Incorrect password"]);
                            die();
                        }
                    } else {
                        echo json_encode(["message" => "Incorrect email"]);
                        die();
                    }
                } else {
                    echo json_encode(["message" => "Please fill all fields"]);
                    die();
                }
            } else {
                echo json_encode(["message" => "Token mismatch. Please try again"]);
                die();
            }
        }

        public static function validateRegister($pdo) {
            if (isset($_POST['csrf_token']) && Security::checkCsrfToken($_POST['csrf_token'])) {
                $valid_extensions = ['jpeg', 'jpg', 'png'];
                $name;
                $password;
                $email;
                $imageName;
                  if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && $_FILES['file']) {
                      $img = $_FILES['file']['name'];
                      $tmp = $_FILES['file']['tmp_name'];
                      $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

                      // name validation
                      if (mb_strlen($_POST['name']) < 20) {
                          $name = $_POST['name'];
                      } else {
                          echo json_encode(["message" => "Name is too long"]);
                          die();
                      }

                      // password validation
                      if (mb_strlen($_POST['password']) > 6) {
                          $password = $_POST['password'];
                      } else {
                          echo json_encode(["message" => "Password is too short"]);
                          die();
                      }

                      // email validation
                      if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                          $email = $_POST['email'];
                      } else {
                          echo json_encode(["message" => "Invalid email"]);
                          die();
                      }

                      // check if email is unique
                      $user = Users::findByEmail($pdo, $email);
                      if ($user) {
                          echo json_encode(["message" => "This email is already taken"]);
                          die();
                      }

                      // validate reCAPTCHAv2
                      if (isset($_POST['recaptcha'])) {
                          $captcha = $_POST['recaptcha'];
                          $url = 'https://www.google.com/recaptcha/api/siteverify';
                          $data = [
                            'secret' => '6Ld8UsUUAAAAAHjJpx_1TnxZzwbJiTT5BuH3bmgk',
                            'response' => $_POST["recaptcha"]
                          ];
                          $options = [
                            'http' => [
                              'method' => 'POST',
                              "header" => "Content-Type: application/x-www-form-urlencoded",
                              'content' => http_build_query($data)
                            ]
                          ];
                          $context  = stream_context_create($options);
                          $verify = file_get_contents($url, false, $context);
                          $captcha_success = json_decode($verify);
                          if ($captcha_success->success == false) {
                              echo "CAPTCHA Error";
                              die();
                          }

                      } else {
                          echo json_encode(["message" => "Please solve CAPTCHA"]);
                          die();
                      }

                      // validate and upload image
                      if (in_array($ext, $valid_extensions)) {
                          $final_image = rand(1000,1000000).$img;
                          if (move_uploaded_file($tmp, "images/".$final_image)) {
                              $imageName = $final_image;
                          } else {
                              echo json_encode(["message" => "Upload error"]);
                              die();
                          }
                      } else {
                          echo json_encode(["message" => "Please upload image with extension .jpeg, .jpg or .png"]);
                          die();
                      }
                      
                      return ['name' => $name,
                              'password' => $password,
                              'email' => $email,
                              'imageName' => $imageName
                              ];

                  } else {
                      echo json_encode(["message" => "Please fill all fields"]);
                      die();
                  }
            } else {
                  echo json_encode(["message" => "Token mismatch. Please try again"]);
                  die();
            }
        }
    }