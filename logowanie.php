<?php 
declare(strict_types=1); 
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Logowanie - MyCloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main class="container">
        <section class="sekcja1" style="max-width: 420px; margin: 80px auto;">
            <h3 class="mb-4 text-center" style="color: #0078d4; font-weight: bold;">Logowanie</h3>
            
            <?php if (isset($_GET['registered'])): ?>
                <div class="alert alert-success">Konto utworzone! Możesz się zalogować.</div>
            <?php endif; ?>
            
            <!-- Komunikaty o błędach i włamaniach -->
            <?php if (isset($_GET['error']) && $_GET['error'] === 'blocked'): ?>
                <div class="alert alert-danger fw-bold">Zbyt wiele błędnych logowań. Konto zablokowane na 1 minutę.</div>
                <script>window.history.replaceState(null, null, window.location.pathname);</script>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Błędny login lub hasło!</div>
                <script>window.history.replaceState(null, null, window.location.pathname);</script>
            <?php endif; ?>

            <form method="post" action="weryfikuj.php">
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold">Login:</label>
                    <input type="text" class="form-control" name="user" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold">Hasło:</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Zaloguj się</button>
            </form>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>