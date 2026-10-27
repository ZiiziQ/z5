<?php 
declare(strict_types=1);
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { 
    header("Location: logowanie.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bezpieczeństwo - MyCloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main class="container">
        <section class="sekcja1">
            <h4 class="mb-4 text-danger">Zarejestrowane próby włamań (Brute-force Log)</h4>
            
            <table class="table table-hover text-start">
                <thead>
                    <tr>
                        <th>Adres IP</th>
                        <th>Data i godzina błędnej próby</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $link = mysqli_connect('localhost', 'srv125882_z5', 'ZZBKRgdS9V5UpYHjZtya', 'srv125882_z5');
                    
                    if (!$link) {
                        echo "<tr><td colspan='2' class='text-danger'>Błąd połączenia z bazą danych: " . mysqli_connect_error() . "</td></tr>";
                    } else {
                        mysqli_query($link, "SET NAMES 'utf8'");
                        
                        $sql = "SELECT ip_address, attempt_time FROM break_ins ORDER BY attempt_time DESC LIMIT 50";
                        $res = mysqli_query($link, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) { 
                                echo "<tr>";
                                echo "<td><code>" . htmlspecialchars($row['ip_address']) . "</code></td>";
                                echo "<td class='text-danger fw-bold'>" . htmlspecialchars($row['attempt_time']) . "</td>";
                                echo "</tr>"; 
                            }
                        } else { 
                            echo "<tr><td colspan='2' class='text-muted'>Brak zarejestrowanych włamań w bazie.</td></tr>"; 
                        }
                        mysqli_close($link);
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>