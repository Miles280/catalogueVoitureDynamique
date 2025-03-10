<?php
require_once("blocs/header.php");
require_once("blocs/connectDB.php")
?>

<?php
session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $errors["missing"] = "Le nom d'utilisateur et le mot de passe sont obligatoires.";
    } else {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];

        $requete = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $requete->execute(["username" => $username]);
        $user = $requete->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $errors["username"] = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $requete = $pdo->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
            $requete->execute([
                "username" => $username,
                "password" => $hashedPassword,
            ]);

            $_SESSION["username"] = $username;
            header("Location: admin.php");
            exit();
        }
    }
}
?>


<form method="POST">
    <label>Nom d'utilisateur :</label>
    <input type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required>
    <?php if (isset($errors["username"])) echo "<p>" . htmlspecialchars($errors["username"]) . "</p>"; ?>

    <label>Mot de passe :</label>
    <input type="password" name="password" required>
    <?php if (isset($errors["missing"])) echo "<p>" . htmlspecialchars($errors["missing"]) . "</p>"; ?>

    <button type="submit">S'inscrire</button>
</form>


<?php
require_once("blocs/footer.php")
?>