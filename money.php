#!/usr/local/bin/php
<?php
header('Content-Type: text/plain; charset=utf-8');
session_save_path(__DIR__.'/sessions/');
session_name('myWebpage');
session_start();

if (isset($_SESSION['username']) && isset($_POST['credit'])) {
    $username = $_SESSION['username'];
    $_SESSION['credit'] = $_POST['credit'];
    $credit = $_SESSION['credit'];
    $db = new SQLite3('credit.db');
    $db->exec("UPDATE users SET credit = '$credit' WHERE username = '$username'");
    $db->close();
}
else {
    echo "Either the user or credit was not posted.";
}
?>