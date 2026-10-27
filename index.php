<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zadanie 5 - MyCloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main class="container">
        <section class="sekcja1 text-center" style="margin-top: 80px;">
            <h1 style="color: #d2a8ff; font-weight: bold;">MyCloud Storage</h1>
            <p class="lead text-muted mt-3">Twój bezpieczny, prywatny dysk w chmurze.</p>
            <p>Zaloguj się, aby zarządzać swoimi plikami, tworzyć foldery i bezpiecznie udostępniać dane.</p>
            
            <div class="mt-4">
                <a href="logowanie.php" class="btn btn-primary btn-lg me-2">Zaloguj się</a>
                <a href="rejestracja.php" class="btn btn-outline-light btn-lg">Załóż konto</a>
            </div>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>