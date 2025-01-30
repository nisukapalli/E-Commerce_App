#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebpage');
session_start();

if (isset($_SESSION['loggedin'])) {
    if (!$_SESSION['loggedin']) {
        header('Location: login.php');
    }
    elseif (!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
}
else {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$db = new SQLite3('credit.db');
$db->exec("CREATE TABLE IF NOT EXISTS users (username TEXT, credit REAL)");
$row = $db->querySingle("SELECT credit FROM users WHERE username = '$username'");
if (!$row) {
    $db->exec("INSERT INTO users (username, credit) VALUES ('$username', 20)");
    $_SESSION['credit'] = 20;
}
else {
    $_SESSION['credit'] = $row;
}
$credit = $_SESSION['credit'];
$db->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
    <title> Our Merchandise </title>
    <script src="username.js?v=<?php echo rand(); ?>" defer></script>
    <script src="merch.js?v=<?php echo rand(); ?>" defer></script>
  </head>
  <body>
    <header>
        <h1 id="header"> Our Merchandise </h1>
        <ul id="list">
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="blog.php">Our Posts</a></li>
            <li>Our Products</li>
        </ul>
    </header>

    <main>
        <section id="section">
            <h2> Items </h2>
            <p>
                Please have a look around. Our new members are awarded with $20.00 in credit. You can add credit at anytime with a coupon code.
                When you want to make a purchase, please select the checkboxes of the items you wish to purchase and click the "Checkout" button below.
            </p>
            <p id="credit">Your credit: $<?php echo number_format($credit, 2); ?></p>

            <table>
                <tbody>
                    <tr>
                        <td>
                            <img src="https://goalkicksoccer.com/cdn/shop/articles/what-is-the-official-soccer-ball-for-the-2022-world-cup-481526_2000x.jpg?v=1654357624"
                                alt="Soccer Ball">
                            <h3>Soccer Ball</h3>
                            <input type="checkbox" id="ball">
                            <span></span>
                            <p>Official World Cup 2022 Adidas soccer ball.</p>
                        </td>
                        <td>
                            <img src="https://soccerzoneusa.com/cdn/shop/files/AURORA_DJ4977-300_PHCFH001-2000_2000x.jpg?v=1697838686"
                                alt="Cleats">
                            <h3>Nike Mercurial Cleats</h3>
                            <input type="checkbox" id="cleats">
                            <span></span>
                            <p>Nike Mercurial Superfly 9 soccer cleats, worn by Cristiano Ronaldo and Kylian Mbappé.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://playitagainsports.imgix.net/images/10292-ADIHN5586L-1?auto=compress,format&fit=clip&w=800"
                                alt="Shin Guards">
                            <h3>Shin Guards</h3>
                            <input type="checkbox" id="shin-guards">
                            <span></span>
                            <p>Adidas soccer shin guards.</p>
                        </td>
                        <td>
                            <img src="https://www.nikys-sports.com/cdn/shop/products/SX5728-010-NIKE_5000x.jpg?v=1602621088"
                                alt="Socks">
                            <h3>Soccer Socks</h3>
                            <input type="checkbox" id="socks">
                            <span></span>
                            <p>Nike black soccer socks.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <fieldset>
                <label for="coupon">Coupon code:</label>
                <input type="text" id="coupon">
                <br>
                <button type="button" id="checkout">Checkout</button>
                <p id="checkout-msg"></p>
            </fieldset>
        </section>
    </main>

    <footer>
      <hr>
      &copy; Nikhil Isukapalli, 2024
    </footer>
  </body>
</html>