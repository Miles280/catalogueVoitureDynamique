<?php

function verifySession() // Vérifie que l'utilisateur est connecté
{
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    };
};

function selectAllCars(PDO $pdo) // Récupère toutes les voitures dans la base de données
{
    $requete = $pdo->prepare("SELECT * FROM car");
    $requete->execute();
    $cars = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $cars;
};

function selectCarByID(PDO $pdo, $idCar) // Récupère une voiture dans la base de données via son ID
{
    $requete = $pdo->prepare("SELECT * FROM car WHERE id = :id");
    $requete->execute(["id" => $idCar]);
    $car = $requete->fetch();
    return $car;
};
