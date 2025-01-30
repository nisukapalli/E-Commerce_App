#!/usr/local/bin/php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = isset($_POST['author']) ? $_POST['author'] : document.getElementById('username').value;
    
    $content = $_POST['content'];
    file_put_contents('posts.txt', "<pre><b>$author</b> says: $content</pre>", FILE_APPEND);
    echo "<p>Post successfully written</p>";
}
else {
    if (file_exists('posts.txt')) {
        $posts = file_get_contents('posts.txt');
        foreach (explode("</pre>", $posts) as $post) {
            if (!empty($post)) {
                echo $post;
            }
        }
    }
    else {
        echo "Nobody has made a post.";
    }
}
?>