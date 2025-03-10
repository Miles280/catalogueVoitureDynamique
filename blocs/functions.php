<?php

// Vérifie que l'utilisateur est connecté
function verifySession(): void
{
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    };
};

// Récupère toutes les voitures dans la base de données
function selectAllCars(PDO $pdo): array
{
    $requete = $pdo->prepare("SELECT * FROM car");
    $requete->execute();
    $cars = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $cars;
};

// Récupère une voiture dans la base de données via son ID
function selectCarByID(PDO $pdo, int $idCar): array
{
    $requete = $pdo->prepare("SELECT * FROM car WHERE id = :id");
    $requete->execute(["id" => $idCar]);
    $car = $requete->fetch();
    return $car;
};

// Ajoute une voiture dans la base de données
function insertCar(PDO $pdo, string $model, string $brand, int $horsePower, string $image): void
{
    $requete = $pdo->prepare("INSERT INTO car (model, brand, horsePower, image) 
                                  VALUES (:model, :brand, :horsePower, :image)");
    $requete->execute([
        "model" => $model,
        "brand" => $brand,
        "horsePower" => $horsePower,
        "image" => $image,
    ]);
};

// Modifie les informations d'une voiture dans la base de données
function updateCar(PDO $pdo, string $model, string $brand, int $horsePower, string $image, int $idCar): void
{
    $requete = $pdo->prepare("UPDATE car SET model = :model, brand = :brand, horsePower = :horsePower, image = :image WHERE id = :id");
    $requete->execute([
        "model" => $model,
        "brand" => $brand,
        "horsePower" => $horsePower,
        "image" => $image,
        "id" => $idCar,
    ]);
};

// Supprime une voiture de la base de données
function deleteCar(PDO $pdo, int $idCar): void
{
    $requete = $pdo->prepare("DELETE FROM car WHERE id = :id;");
    $requete->execute([
        "id" => $idCar,
    ]);
};
