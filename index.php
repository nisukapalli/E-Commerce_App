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
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
    <title> The Weeknd </title>
  </head>
  <body>
    <header>
        <span id="greeting">
            <?php echo "Hello, {$_SESSION['username']}!"; ?>
        </span>
        <h1> The Weeknd </h1>
        <ul id="list">
            <li>Home</li>
            <li><a href="login.php">Login</a></li>
            <li><a href="blog.php">Our Posts</a></li>
            <li><a href="merch.php">Our Products</a></li>
        </ul>
    </header>

    <main>
      <section>
        <p> The Weeknd is a Canadian R&B and pop artist. </p>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/The_Weeknd_Cannes_2023.png/440px-The_Weeknd_Cannes_2023.png"
          alt="The Weeknd" width=200>
        <h2> Albums </h2>
        <ul>
          <li> Trilogy (2012) </li>
          <li> Kiss Land (2013) </li>
          <li> Beauty Behind the Madness (2015) </li>
          <li> Starboy (2016) </li>
          <li> My Dear Melancholy (2018) </li>
          <li> After Hours (2020) </li>
          <li> Dawn FM (2022) </li>
        </ul>
      </section>

      <section>
        <h2> Some recent posts by other users: </h2>
        <p>
            <b> malicious666 </b> says: Could anyone see how I can fix my 
            <a href="scarf1.html" target="_blank" rel="opener">scarf</a>? Please help. I'm so sad. Here's a 
            <a href="scarf2.html" target="_blank" rel="opener">picture</a> of the other side.
        </p>
      </section>
    </main>

    <footer>
      <hr>
      &copy; Nikhil Isukapalli, 2024
    </footer>
  </body>
</html>