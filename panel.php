<?php 
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: logowanie.php");
    exit();
}

$avatar = $_SESSION['avatar'] ?? 'default.png';
$username = $_SESSION['username'] ?? 'Użytkowniku';
$home_dir = $_SESSION['home_dir'] ?? $username;
$current_dir = $_SESSION['current_dir'] ?? $home_dir;

// Bezpieczeństwo: upewnienie się, że katalog bazowy istnieje
$full_home_path = __DIR__ . '/' . $home_dir;
if (!file_exists($full_home_path)) {
    mkdir($full_home_path, 0777, true);
}

// Bezpieczeństwo przed wyjściem poza własny folder (Directory Traversal)
$full_current_path = realpath(__DIR__ . '/' . $current_dir);
$real_home_path = realpath($full_home_path);
if ($full_current_path === false || strpos($full_current_path, $real_home_path) !== 0) {
    $current_dir = $home_dir;
    $_SESSION['current_dir'] = $home_dir;
    $full_current_path = $real_home_path;
}

// Pobieranie listy plików
$items = scandir($full_current_path);
$items = array_diff($items, array('.', '..')); // ukrywamy kropki
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MyCloud - Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
    <div id='myHeader'></div>
    <main class="container">
        <section class="sekcja1 mb-4">
            <div class="d-flex align-items-center gap-3">
                <img src="avatars/<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="rounded-circle border" width="80" height="80" style="object-fit: cover;">
                <div>
                    <h2>Witaj, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p class="mb-0 text-success fw-bold">Twój prywatny dysk w chmurze.</p>
                </div>
            </div>
        </section>

        <!-- OSTRZEŻENIE O BŁĘDNYCH LOGOWANIACH (Brute-force) -->
        <?php if (isset($_SESSION['login_warning'])): ?>
            <div class="alert alert-danger fw-bold">
                <?php 
                    echo htmlspecialchars($_SESSION['login_warning']); 
                    unset($_SESSION['login_warning']); // Czyścimy po wyświetleniu
                ?>
            </div>
        <?php endif; ?>

        <section class="sekcja1">
            <h4 style="color: #d2a8ff;">> Eksplorator plików: <code>/<?php echo htmlspecialchars($current_dir); ?></code></h4>
            
            <div class="d-flex gap-3 mb-3 mt-3 align-items-center">
                <!-- Ikona Level Up (powrót) widoczna tylko w podkatalogach -->
                <?php if ($current_dir !== $home_dir): ?>
                    <a href="nawigacja.php?akcja=up" class="btn btn-secondary btn-sm">[Wróć wyżej]</a>
                <?php endif; ?>

                <!-- Przycisk tworzenia folderu (tylko w katalogu macierzystym) -->
                <?php if ($current_dir === $home_dir): ?>
                    <form action="akcje.php" method="POST" class="d-flex gap-2 mb-0">
                        <input type="hidden" name="akcja" value="mkdir">
                        <input type="text" name="folder_name" class="form-control form-control-sm" placeholder="Nazwa folderu" required pattern="[a-zA-Z0-9]+">
                        <button type="submit" class="btn btn-warning btn-sm">Stwórz</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Upload plików -->
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-4 d-flex gap-2 p-3" style="background: #21262d; border-radius: 6px;">
                <input type="file" name="fileToUpload" class="form-control form-control-sm" required>
                <button type="submit" name="submit" class="btn btn-primary btn-sm">Wgraj plik</button>
            </form>

            <!-- Lista plików i katalogów -->
            <table class="table table-dark table-hover text-start">
                <thead>
                    <tr>
                        <th>Typ</th>
                        <th>Nazwa</th>
                        <th class="text-end">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Brak plików w tym katalogu.</td></tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <?php 
                                $is_dir = is_dir($full_current_path . '/' . $item); 
                                $safe_item = htmlspecialchars($item);
                            ?>
                            <tr>
                                <td><?php echo $is_dir ? '📁' : '📄'; ?></td>
                                <td>
                                    <?php if ($is_dir): ?>
                                        <a href="nawigacja.php?dir=<?php echo urlencode($safe_item); ?>" style="color: #58a6ff; text-decoration: none;">
                                            <?php echo $safe_item; ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo $current_dir . '/' . $safe_item; ?>" target="_blank" style="color: #c9d1d9; text-decoration: none;">
                                            <?php echo $safe_item; ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <form action="akcje.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="akcja" value="<?php echo $is_dir ? 'rmdir' : 'unlink'; ?>">
                                        <input type="hidden" name="target" value="<?php echo $safe_item; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm py-0 px-2" onclick="return confirm('Na pewno usunąć?');">🗑 Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>