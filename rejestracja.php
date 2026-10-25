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
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main class="container">
        <section class="sekcja1" style="max-width: 500px; margin: 80px auto;">
            <h3 class="mb-3 text-center">Rejestracja konta</h3>
            <form method="post" action="add_user.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nazwa użytkownika:</label>
                    <input type="text" class="form-control" name="user" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hasło:</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Powtórz hasło:</label>
                    <input type="password" class="form-control" name="pass2" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Awatar profilu (opcjonalnie):</label>
                    <input type="file" class="form-control" name="avatar" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100">Zarejestruj</button>
            </form>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>