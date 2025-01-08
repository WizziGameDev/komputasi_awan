<?php
session_start();

// Check session
if (isset($_SESSION['username'])) {
    header('Location: viewDashboard.php');
    exit();
}

$adminUsername = 'admin';
$adminPassword = 'admin';

// Menerima data dari formulir login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi login
    if ($username === $adminUsername && $password === $adminPassword) {
        // Simpan username di session
        $_SESSION['username'] = $username;

        // Dashbord
        header('Location: viewDashboard.php');
        exit();
    } else {
        // Jika login tidak berhasil
        $errorMessage = "Username or Password incorrect";
        echo "<script>
                alert('$errorMessage');
                window.history.go(-1); 
            </script>";
        $connection = null;
        exit();
    }
}

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="../assets/style/styleLogin.css">
    </head>
    <body>
        <div class="container" id="content-container">
            <div class="page">

                <div class="image">
                    <img src="../assets/image/login.png" alt="image-inventory">
                </div>

                <div class="form">
                    <h1>LOGIN</h1>
                    <hr>
                    <form action="" method="POST">
                        <!-- Form elements go here -->
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username">

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">

                        <button type="submit">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
