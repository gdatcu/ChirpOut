<?php
require 'config/config.php';

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
}
else {
    header("Location: register.php");
}

?>
<html>
    <head>
        <title>Welcome to ChirpOut</title>
        <!-- Javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="assets/js/bootstrap.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    </head>
    <body>

      <div class="top_bar">
        <div class="logo">
          <!-- If we want an image instead of text, we can use
          <img src="assets/images/logoImg"> -->
          <a href="index.php">ChirpOut!</a>
        </div>

        <nav>
          <a href="#">Home</a>
          <a href="#">messages</a>
          <a href="#">settings</a>

        </nav>

      </div>
