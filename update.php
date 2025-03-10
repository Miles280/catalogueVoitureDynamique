<?php
$styleCustom = "updateStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
require_once("blocs/functions.php");

verifySession(); // Vérifie que l'utilisateur est connecté

// Vérification que l'ID de la voiture est bien fourni
if (!isset($_GET["carId"])) {
    header("Location: index.php");
    exit();
}

// Récupération des données de la voiture depuis la BDD
$car = selectCarByID($pdo, $_GET["carId"]);
if (!isset($car)) {
    header("Location: admin.php");
    exit();
}

$errors = [];
$model = $car["model"];
$brand = $car["brand"];
$horsePower = $car["horsePower"];
$image = $car["image"];

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $model = trim($_POST["model"]);
    $brand = trim($_POST["brand"]);
    $horsePower = trim($_POST["horsePower"]);

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

    // Gestion de l'upload d'image (facultatif)
    if (!empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = "pictures/" . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image = $fileName; // Nouvelle image si upload réussi
        } else {
            $errors["image"] = "Erreur lors du téléchargement de l'image.";
        }
    }

    // Si aucune erreur, on met à jour la base de données
    if (empty($errors)) {
        updateCar($pdo, $model, $brand, $horsePower, $image, $car["id"]);
        header("Location: admin.php");
        exit();
    }
}
?>

<main>
    <h1>Modification d'un article</h1>
    <div>
        <article class="article">
            <h2><?= htmlspecialchars($car["model"]) ?></h2>
            <img src="pictures/<?= htmlspecialchars($car["image"]) ?>" alt="Image de la voiture">
            <p><?= htmlspecialchars($car["brand"]) ?></p>
            <p><?= htmlspecialchars($car["horsePower"]) ?> chevaux</p>
        </article>

        <form method="POST" enctype="multipart/form-data">
            <label>Modèle :</label>
            <input type="text" name="model" value="<?= htmlspecialchars($model) ?>">
            <?php if (isset($errors["model"])) echo "<p class='error'>" . $errors["model"] . "</p>"; ?>

            <label>Marque :</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($brand) ?>">
            <?php if (isset($errors["brand"])) echo "<p class='error'>" . $errors["brand"] . "</p>"; ?>

            <label>Puissance (chevaux) :</label>
            <input type="number" name="horsePower" min="1" value="<?= htmlspecialchars($horsePower) ?>">
            <?php if (isset($errors["horsePower"])) echo "<p class='error'>" . $errors["horsePower"] . "</p>"; ?>

            <label>Nouvelle Image (optionnel) :</label>
            <input type="file" name="image">
            <?php if (isset($errors["image"])) echo "<p class='error'>" . $errors["image"] . "</p>"; ?>

            <button class="buttonValidation" type="submit">Modifier</button>
        </form>
    </div>
</main>

<?php require_once("blocs/footer.php"); ?>