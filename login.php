<?php
require_once("blocs/header.php");
require_once("blocs/connectDB.php")
?>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $requete = $pdo->prepare("SELECT * FROM user WHERE username = :username");
    $requete->execute([
        "username" => $_POST["username"]
    ]);
    $user = $requete->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST["password"]) && !empty($user["password"]) && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["username"] = $user["username"];
        header("Location: admin.php");
        exit();
    }
}
?>


<form method="POST" action="login.php">
    <label>Username</label>
    <input required type="text" name="username">
    <label>Password</label>
    <input required type="password" name="password">
    <button class="connexionButton">Se connecter</button>
</form>

<a href="signin.php">S'inscrire</a>

<?php
require_once("blocs/footer.php")
?>