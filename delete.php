<?php
$styleCustom = "deleteStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
?>

<?php
$goodCar = null;

foreach ($cars as $car) {
    if ($car["id"] == $_GET["carId"]) {
        $goodCar = $car;
        break;
    }
};

if (isset($goodCar) === false) {
    header("Location:index.php");
    exit();
}
?>

<main>
    <h1>Modification d'un article</h1>
    <div>
        <article class="article">
            <h2><?= $goodCar["model"] ?></h2>
            <img src="pictures/<?= $goodCar["image"] ?>" alt="">
            <p><?= $goodCar["brand"] ?></p>
            <p><?= $goodCar["horsePower"] ?> chevaux</p>
        </article>

        <form method="POST">
            <label>Êtes vous sur de vous supprimez cet article ?</label>

            <button class="buttonValidation" type="submit">Supprimer</button>
        </form>
    </div>
</main>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $requete = $pdo->prepare("DELETE FROM car WHERE id = :id;");
    $requete->execute([
        "id" => $goodCar["id"],
    ]);

    header("Location: index.php");
    exit();
}
?>

<?php
require_once("blocs/footer.php")
?>