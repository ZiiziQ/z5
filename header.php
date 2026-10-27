<?php 
declare(strict_types=1); 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLogged = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<header>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" style="border-bottom: 1px solid #edebe9; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php" style="color: #0078d4;">☁️ MyCloud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main_nav">
      <ul class="navbar-nav me-auto">
        <?php if (!$isLogged): ?>
          <li class="nav-item"><a class="nav-link" href="logowanie.php">Logowanie</a></li>
          <li class="nav-item"><a class="nav-link" href="rejestracja.php">Rejestracja</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link fw-semibold" href="panel.php">Mój Dysk</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="bezpieczenstwo.php">Bezpieczeństwo</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="goscie.php">Goście portalu</a></li>
        <?php endif; ?>
      </ul>
      <?php if ($isLogged): ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><span class="nav-link text-muted">Zalogowany: <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span></li>
        <li class="nav-item"><a class="nav-link text-danger fw-semibold" href="logout.php">Wyloguj się</a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>
</div>
</header>