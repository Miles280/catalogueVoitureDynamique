<?php
require_once("blocs/header.php");
require_once("blocs/connectDB.php")
?>

<?php
session_start();

if (isset($_SESSION["username"])) {
    unset($_SESSION["username"]);
};

header("location: index.php");
?>

<?php
require_once("blocs/footer.php")
?>