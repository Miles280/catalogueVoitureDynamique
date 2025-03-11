<?php
$styleCustom = "CSS/indexStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
require_once("blocs/functions.php");
?>

<?php
verifySession();
?>

<main>
    <h1>Catalogue de voitures</h1>
    <form action="add.php">
        <button class="buttonAdd">Ajouter une voiture</button>
    </form>
    <div class="catalogue">
        <?php

        foreach ($cars as $car) { ?>
            <div class="article">
                <h2><?= $car["model"] ?></h2>
                <img src="pictures/<?= $car["image"] ?>" alt="">
                <p><?= $car["brand"] ?></p>
                <p><?= $car["horsePower"] ?> chevaux</p>
                <form method="GET">
                    <input type="hidden" name="carId" value="<?= $car["id"] ?>">
                    <button class="buttonModify" formaction="update.php">Modifier</button>
                    <button class="buttonSupp" formaction="delete.php">Supprimer</button>
                </form>
            </div>
        <?php
        }
        ?>
    </div>
</main>

<?php
require_once("blocs/footer.php")
?>