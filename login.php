#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebpage');
session_start();

$wrong_pwd = false;
if (isset($_POST['password'])) {
    validate_pwd($_POST['password'], $wrong_pwd);
}

function validate_pwd($submission, &$wrong_pwd) {
    $file = fopen('h_password.txt', 'r');
    $hash = trim(fgets($file));
    fclose($file);
    if ($hash !== hash('md2', trim($submission))) {
        $_SESSION['loggedin'] = false;
        $wrong_pwd = true;
    }
    else {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_POST['username'];
        setcookie('username', $_POST['username'], time()+3600);
        header('Location: index.php');
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
        <title> Login </title>
        <script src="username.js?v=<?php echo rand(); ?>" defer></script>
        <script src="login.js?v=<?php echo rand(); ?>" defer></script>
    </head>
    <body>
        <header>
            <h1 id="header"> Welcome! Ready to check out my webpage? </h1>
            <ul id="list">
                <li><a href="index.php">Home</a></li>
                <li>Login</li>
                <li><a href="blog.php">Our Posts</a></li>
                <li><a href="merch.php">Our Products</a></li>
            </ul>
        </header>

        <main>
            <section id="section">
                <h2> Enter a username. </h2>
                <p> So that you can make your own posts and purchases, select a username and password. </p>

                <form id="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <fieldset>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <br>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <button type="submit" id="login">Login</button>
                    </fieldset>
                </form>

                <p>
                    <?php
                    if ($wrong_pwd) {
                        echo "Invalid password!";
                    }
                    ?>
                </p>
            </section>
        </main>

        <footer class="footer">
            <hr>
            &copy; Nikhil Isukapalli, 2024
        </footer>
    </body>
</html>