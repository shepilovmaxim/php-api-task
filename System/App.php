<?php 
  class App {
    public static function run() {
        $errorMessage = false;
        if (isset($_GET['path'])) {
            $pathParts = explode('/', $_GET['path']);
            $controllerName = ucfirst($pathParts[0]) . 'Controller';
            if (file_exists('Controllers/' . $controllerName . '.php')) {
                $controller = new $controllerName;
                if (array_key_exists("1", $pathParts)) {
                    $action = $pathParts[1];
                    if (method_exists($controller, $action)) {
                        $controller->$action();
                    } else {
                        $errorMessage = "Action doesn't exist";
                    }
                  } else {
                      $controller->index();
                  }
            } else {
                $errorMessage = "Controller not found";
            }
        } else {
            header("Location: /users");
            die();
        }

        if ($errorMessage) {
            $errorController = new ErrController;
            $errorController->index($errorMessage);
        }
    }
  }