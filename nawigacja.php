<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: logowanie.php");
    exit();
}

$home_dir = $_SESSION['home_dir'];
$current_dir = $_SESSION['current_dir'];

if (isset($_GET['akcja']) && $_GET['akcja'] === 'up') {
    // Wróć do katalogu macierzystego 
    $_SESSION['current_dir'] = $home_dir;
} elseif (isset($_GET['dir'])) {
    // Wejście do podkatalogu
    $target_dir = basename($_GET['dir']); // basename chroni przed znakami ../
    $full_path = __DIR__ . '/' . $current_dir . '/' . $target_dir;
    
    // Upewniamy się, że jesteśmy w katalogu macierzystym 
    if (is_dir($full_path) && $current_dir === $home_dir) {
        $_SESSION['current_dir'] = $home_dir . '/' . $target_dir;
    }
}

header("Location: panel.php");
exit();
?>