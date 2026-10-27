<?php
declare(strict_types=1);

$user = htmlentities($_POST['user'] ?? '', ENT_QUOTES, "UTF-8");
$pass = htmlentities($_POST['pass'] ?? '', ENT_QUOTES, "UTF-8");
$pass2 = htmlentities($_POST['pass2'] ?? '', ENT_QUOTES, "UTF-8");

// Walidacja loginu - tylko litery i cyfry 
if (!preg_match('/^[a-zA-Z0-9]+$/', $user)) {
    die("Błąd: Login może zawierać tylko litery i cyfry! <a href='rejestracja.php'>Wróć</a>");
}

if ($pass !== $pass2) {
    die("Hasła nie są identyczne! <a href='rejestracja.php'>Wróć</a>");
}

$avatarName = "default.png";

// Obsługa pliku awatara 
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['avatar']['tmp_name'];
    $fileName = basename($_FILES['avatar']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

    if (in_array($fileExt, $allowed)) {
        $newFileName = uniqid('av_', true) . '.' . $fileExt;
        $uploadDir = __DIR__ . '/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
            $avatarName = $newFileName;
        }
    }
}


$link = mysqli_connect('localhost', 'srv125882_z5', 'ZZBKRgdS9V5UpYHjZtya', 'srv125882_z5');
if (!$link) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}
mysqli_query($link, "SET NAMES 'utf8'");

// Czy użytkownik istnieje
$stmt_check = mysqli_prepare($link, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt_check, "s", $user);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);
if (mysqli_stmt_num_rows($stmt_check) > 0) {
    mysqli_stmt_close($stmt_check);
    mysqli_close($link);
    die("Użytkownik o takim loginie już istnieje! <a href='rejestracja.php'>Wróć</a>");
}
mysqli_stmt_close($stmt_check);

// Hashowanie hasła 
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Dodawanie użytkownika 
$stmt_insert = mysqli_prepare($link, "INSERT INTO users (username, password, avatar, worker) VALUES (?, ?, ?, 0)");
mysqli_stmt_bind_param($stmt_insert, "sss", $user, $hash, $avatarName);

if (mysqli_stmt_execute($stmt_insert)) {
    
    // Tworzenie prywatnego katalogu macierzystego
    $user_dir = __DIR__ . '/' . $user;
    if (!file_exists($user_dir)) {
        mkdir($user_dir, 0777, true);
    }
    
    mysqli_stmt_close($stmt_insert);
    mysqli_close($link);
    header("Location: logowanie.php?registered=1");
    exit();
} else {
    echo "Błąd bazy danych: " . mysqli_error($link);
    mysqli_stmt_close($stmt_insert);
    mysqli_close($link);
}
?>