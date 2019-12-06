<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <title>Document</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/users">
                        Users
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(Auth::loggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="/users/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/registration">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?php 
        require_once($viewName . '.php');
    ?>
</body>
</html>