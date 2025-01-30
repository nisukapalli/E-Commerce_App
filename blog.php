#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebpage');
session_start();

if (isset($_SESSION['loggedin'])) {
    if (!$_SESSION['loggedin']) {
        header('Location: login.php');
    }
    elseif (!isset($_COOKIE['username'])) {
        header('Location: login.php');
    }
}
else {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
        <title> Our Posts </title>
        <script>
            window.onload = function() {
                let author = get_author()
                if (author !== '') {
                    document.getElementById('author').value = author;
                }
            }

            function get_author() {
                const pairs = document.cookie.split('; ');
                for (const pair of pairs) {
                    if (pair.startsWith('author=')) {
                        return pair.substring(7);
                    }
                }
                return '';
            }

            function hour_in_future() {
                let d = new Date();
                d.setHours(d.getHours() + 1);
                return d.toUTCString();
            }
        </script>
    </head>

    <body>
        <header>
            <h1> Blog Posts </h1>
            <ul id="list">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li>Our Posts</li>
                <li><a href="merch.php">Our Products</a></li>
            </ul>
        </header>

        <main>
            <section>

                <form method="POST" action="post.php">
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author">
                    <br>
                    <label for="content" id="content-label">Content:</label>
                    <textarea id="content" name="content" required></textarea>
                    <input type="submit" id="submit">
                </form>

                <h2> Posts by other users: </h2>
                <?php
                    if (file_exists('posts.txt')) {
                        $posts = file_get_contents('posts.txt');
                        foreach (explode("</pre>", $posts) as $post) {
                            if (!empty($post)) {
                                echo $post;
                            }
                        }
                    }
                ?>
            </section>
        </main>

        <footer>
            <hr>
            &copy; Nikhil Isukapalli, 2024
        </footer>
    </body>
</html>