<?php
$styleCustom = "CSS/indexStyles.css";
require_once("blocs/header.php");
require_once("blocs/connectDB.php");
?>

<main>
    <h1>Catalogue de voitures</h1>
    <form action="login.php">
        <button class="buttonAdd">Se connecter</button>
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
                </form>
            </div>
        <?php
        }
        ?>
    </div>
</main>

<?php
require_once("blocs/footer.php");
?>