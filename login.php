<?php
include 'functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isValidUser($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(90deg, red, blue, green);
            background-size: 400% 400%;
            animation: rgbMotion 6s infinite;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        .login-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #6c63ff;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            background-color: #6c63ff;
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #574b90;
        }

        .error-message {
            color: #ff6b6b;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rgbMotion {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <?php if (isset($error)) echo '<p class="error-message">' . $error . '</p>'; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            Show
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-login btn-block">Login</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change button text
            this.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    </script>
</body>
</html>
