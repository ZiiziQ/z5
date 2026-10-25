<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zadanie 3 - Geolokalizacja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main class="container">
        <section class="sekcja1">
            <h2>Zadanie _3. Geolokalizacja, logowanie wizyt</h2>
            <p>Wybierz jeden z poniższych skryptów z zajęć lub <strong>zaloguj się</strong> z górnego menu (logowanie zostanie odnotowane w bazie z Twoim IP).</p>
            <ul>
                <li><a href="index1.php">_1. Informacje diagnostyczne serwera (whoami, ls)</a></li>
                <li><a href="index2.php">_2. Badanie DNS i adresów IP (gethostbyname, REMOTE_ADDR)</a></li>
                <li><a href="index3.php">_3. Geolokalizacja IP przez JSON (ipinfo.io)</a></li>
                <li><a href="index4.php">_4. Rejestr wizyt gości portalu (Tabela, urządzenia i JS)</a></li>
            </ul>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>