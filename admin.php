<?php
require_once("blocs/header.php");
require_once("blocs/connectDB.php")
?>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
?>

<h2>Vous êtes bien connectés.</h2>

<?php
require_once("blocs/footer.php")
?>