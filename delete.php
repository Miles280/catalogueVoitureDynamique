<?php
$styleCustom = "deleteStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
require_once("blocs/functions.php");

verifySession(); // Vérifie que l'utilisateur est connecté

$car = selectCarByID($pdo, $_GET["carId"]);
if (!isset($car)) {
    header("Location:admin.php");
    exit();
}
?>

<main>
    <h1>Suppresion d'un article</h1>
    <div>
        <article class="article">
            <h2><?= $car["model"] ?></h2>
            <img src="pictures/<?= $car["image"] ?>" alt="">
            <p><?= $car["brand"] ?></p>
            <p><?= $car["horsePower"] ?> chevaux</p>
        </article>

        <form method="POST">
            <label>Êtes vous sur de vous supprimez cet article ?</label>

            <button class="buttonValidation" type="submit">Supprimer</button>
        </form>
    </div>
</main>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    deleteCar($pdo, $car["id"]);
    header("Location: admin.php");
    exit();
}
?>

<?php
require_once("blocs/footer.php")
?>