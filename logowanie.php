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
    <title>Logowanie</title>
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
            <h3 class="mb-3 text-center">Logowanie</h3>
            
            <?php if (isset($_GET['registered'])): ?>
                <div class="alert alert-success">Konto utworzone! Możesz się zalogować.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Błędny login lub hasło!</div>
            <?php endif; ?>

            <form method="post" action="weryfikuj.php">
                <div class="mb-3">
                    <label class="form-label">Login:</label>
                    <input type="text" class="form-control" name="user" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hasło:</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Zaloguj się</button>
            </form>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>