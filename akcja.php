<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: logowanie.php"); exit();
}

$current_dir = $_SESSION['current_dir'];
$base_path = __DIR__ . '/' . $current_dir . '/';
$akcja = $_POST['akcja'] ?? '';

if ($akcja === 'mkdir' && !empty($_POST['folder_name'])) {
    // Tworzenie podkatalogu[cite: 11]
    $folder_name = basename($_POST['folder_name']);
    if (!file_exists($base_path . $folder_name)) {
        mkdir($base_path . $folder_name, 0777, true);
    }
} elseif ($akcja === 'unlink' && !empty($_POST['target'])) {
    // Usuwanie pojedynczego pliku[cite: 11]
    $file = basename($_POST['target']);
    if (is_file($base_path . $file)) {
        unlink($base_path . $file);
    }
} elseif ($akcja === 'rmdir' && !empty($_POST['target'])) {
    // Usuwanie katalogu (i plików wewnątrz)[cite: 11]
    $dir = basename($_POST['target']);
    $full_dir_path = $base_path . $dir;
    if (is_dir($full_dir_path)) {
        $files = array_diff(scandir($full_dir_path), array('.','..'));
        foreach ($files as $file) {
            unlink($full_dir_path . '/' . $file); // najpierw usuwamy pliki w środku[cite: 11]
        }
        rmdir($full_dir_path); // potem sam katalog[cite: 11]
    }
}

header("Location: panel.php");
exit();
?>