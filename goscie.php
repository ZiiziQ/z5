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
    <title>Goście portalu - MyCloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main class="container">
        <section class="sekcja1">
            <h4 class="mb-4 text-success">Historia logowań (Goście portalu)</h4>
            
            <table class="table table-hover text-start">
                <thead>
                    <tr>
                        <th>Adres IP</th>
                        <th>Data i godzina</th>
                        <th>Przeglądarka / System</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $link = mysqli_connect('localhost', 'srv125882_z5', 'ZZBKRgdS9V5UpYHjZtya', 'srv125882_z5');
                    
                    if (!$link) {
                        echo "<tr><td colspan='3' class='text-danger'>Błąd połączenia z bazą danych: " . mysqli_connect_error() . "</td></tr>";
                    } else {
                        mysqli_query($link, "SET NAMES 'utf8'");
                        
                        $sql = "SELECT ipaddress, datetime, przegladarka FROM goscieportalu ORDER BY datetime DESC LIMIT 50";
                        $res = mysqli_query($link, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) { 
                                echo "<tr>";
                                echo "<td><code>" . htmlspecialchars($row['ipaddress']) . "</code></td>";
                                echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['przegladarka']) . "</td>";
                                echo "</tr>"; 
                            }
                        } else { 
                            echo "<tr><td colspan='3' class='text-muted'>Brak logów w bazie.</td></tr>"; 
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