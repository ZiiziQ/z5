<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: logowanie.php"); exit();
}

if (isset($_POST["submit"]) && isset($_FILES["fileToUpload"])) {
    $current_dir = $_SESSION['current_dir']; // Pobieramy aktualny katalog[cite: 12]
    $target_dir = __DIR__ . '/' . $current_dir;
    $target_file = $target_dir . '/' . basename($_FILES["fileToUpload"]["name"]);

    // Zgodnie z wytycznymi NIE ograniczamy typu pliku ani rozmiaru[cite: 13]
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Plik wgrany poprawnie[cite: 12]
    } else {
        // Błąd wgrywania
    }
}

header("Location: panel.php");
exit();
?>