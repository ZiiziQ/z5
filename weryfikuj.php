<?php
declare(strict_types=1);
session_start();

$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';
$ip_address = $_SERVER['REMOTE_ADDR'];

$link = mysqli_connect('localhost', 'srv125882_z5', 'ZZBKRgdS9V5UpYHjZtya', 'srv125882_z5');
if (!$link) { 
    die("Błąd połączenia z bazą: " . mysqli_connect_error()); 
}
mysqli_query($link, "SET NAMES 'utf8'");

// Krok 1: Sprawdzenie blokady Brute-force (3 błędy w ciągu 1 minuty)[cite: 10]
$time_limit = date('Y-m-d H:i:s', strtotime('-1 minute'));
$stmt_check = mysqli_prepare($link, "SELECT COUNT(*) FROM break_ins WHERE ip_address = ? AND attempt_time > ?");
mysqli_stmt_bind_param($stmt_check, "ss", $ip_address, $time_limit);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_bind_result($stmt_check, $attempts);
mysqli_stmt_fetch($stmt_check);
mysqli_stmt_close($stmt_check);

if ($attempts >= 3) {
    mysqli_close($link);
    header("Location: logowanie.php?error=blocked");
    exit();
}

// Krok 2: Pobranie danych użytkownika i weryfikacja hasła
$stmt = mysqli_prepare($link, "SELECT id, password, avatar FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row && password_verify($pass, $row['password'])) {
    // Sukces logowania
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user;
    $_SESSION['avatar'] = $row['avatar'];
    $_SESSION['user_id'] = $row['id'];
    
    // Zapisanie ścieżki do katalogu macierzystego i obecnego w sesji (MyCloud)
    $_SESSION['home_dir'] = $user;
    $_SESSION['current_dir'] = $user; 
    
    // Ostrzeżenie o wcześniejszych błędnych próbach (jeśli były)
    if ($attempts > 0) {
        $_SESSION['login_warning'] = "Ostatnie nieudane próby logowania ($attempts) z IP: $ip_address. Zabezpiecz swoje konto!";
    }

    // Czyszczenie historii błędów dla tego IP po udanym logowaniu
    $stmt_clear = mysqli_prepare($link, "DELETE FROM break_ins WHERE ip_address = ?");
    mysqli_stmt_bind_param($stmt_clear, "s", $ip_address);
    mysqli_stmt_execute($stmt_clear);
    mysqli_stmt_close($stmt_clear);
    
    // Rejestracja w tabeli goscieportalu (zgodnie z wymogami z poprzednich zadań)[cite: 10]
    $login_time = date('Y-m-d H:i:s');
    $browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Nieznana';
    // Zakładam tu prostą strukturę tabeli goscieportalu. W razie innej struktury - zaktualizuj zapytanie.
    $stmt_goscie = mysqli_prepare($link, "INSERT INTO goscieportalu (ipaddress, datetime, przegladarka) VALUES (?, ?, ?)");
    if($stmt_goscie) {
        mysqli_stmt_bind_param($stmt_goscie, "sss", $ip_address, $login_time, $browser);
        mysqli_stmt_execute($stmt_goscie);
        mysqli_stmt_close($stmt_goscie);
    }

    mysqli_close($link);
    header("Location: panel.php");
    exit();
} else {
    // Błąd logowania - dodanie wpisu do break_ins[cite: 10]
    $attempt_time = date('Y-m-d H:i:s');
    $stmt_fail = mysqli_prepare($link, "INSERT INTO break_ins (ip_address, attempt_time) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt_fail, "ss", $ip_address, $attempt_time);
    mysqli_stmt_execute($stmt_fail);
    mysqli_stmt_close($stmt_fail);

    mysqli_close($link);
    header("Location: logowanie.php?error=1");
    exit();
}