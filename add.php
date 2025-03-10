<?php
$styleCustom = "addStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
require_once("blocs/functions.php");


verifySession(); // Vérifie que l'utilisateur est connecté

$errors = [];
$model = $brand = $horsePower = "";

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $model = $_POST["model"];
    $brand = $_POST["brand"];
    $horsePower = $_POST["horsePower"];

    // Validation des champs
    if (empty($model)) {
        $errors["model"] = "Le modèle ne peut pas être vide.";
    }
    if (empty($brand)) {
        $errors["brand"] = "La marque ne peut pas être vide.";
    }
    if (empty($horsePower) || !is_numeric($horsePower) || $horsePower < 1) {
        $errors["horsePower"] = "La puissance doit être un nombre valide.";
    }
    if (empty($_FILES["image"]["name"])) {
        $errors["image"] = "L'image est requise.";
    }

    // Gestion de l'upload de l'image si aucun problème
    if (empty($errors) && !empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = "pictures/" . $fileName;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $errors["image"] = "Erreur lors du téléchargement de l'image.";
        }
    }

    // Si aucune erreur, insertion en base de données
    if (empty($errors)) {
        insertCar($pdo, $model, $brand, $horsePower, basename($targetFilePath));
        header("Location: index.php");
        exit();
    }
}
?>

<main>
    <h1>Ajout d'un nouvel article</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Modèle :</label>
        <input type="text" name="model" value="<?= htmlspecialchars($model) ?>">
        <?php if (isset($errors["model"])) echo "<p class='error'>" . $errors["model"] . "</p>"; ?>

        <label>Marque :</label>
        <input type="text" name="brand" value="<?= htmlspecialchars($brand) ?>">
        <?php if (isset($errors["brand"])) echo "<p class='error'>" . $errors["brand"] . "</p>"; ?>

        <label>Puissance (chevaux) :</label>
        <input type="number" min="1" name="horsePower" value="<?= htmlspecialchars($horsePower) ?>">
        <?php if (isset($errors["horsePower"])) echo "<p class='error'>" . $errors["horsePower"] . "</p>"; ?>

        <label>Image :</label>
        <input type="file" name="image">
        <?php if (isset($errors["image"])) echo "<p class='error'>" . $errors["image"] . "</p>"; ?>

        <button class="buttonValidation" type="submit">Ajouter</button>
    </form>
</main>

<?php require_once("blocs/footer.php"); ?>