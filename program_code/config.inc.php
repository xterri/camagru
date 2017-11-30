<?php
    // Before implementing this code, you should use your own username, password and database name values.

    $mysql_link = mysql_connect("localhost", "root", "root");   
    mysql_select_db("sitepoint") or die("Could not select database");

    $images_dir = "photos";
?>
