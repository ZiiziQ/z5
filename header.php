<?php 
declare(strict_types=1); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLogged = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<header>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="border-bottom: 1px solid #2ea043;">
  <div class="container-fluid">
    <a class="navbar-brand font-monospace" href="index.php" style="color: #4af626; font-weight: bold;">> Zadanie_3</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="main_nav">
      <ul class="navbar-nav me-auto">
        <?php if (!$isLogged): ?>
          <li class="nav-item">
            <a class="nav-link font-monospace" href="logowanie.php" style="color: #4af626;">Logowanie</a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-monospace" href="rejestracja.php" style="color: #4af626;">Rejestracja</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link active fw-bold font-monospace" href="panel.php" style="color: #4af626;">Mój profil (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
          </li>
        <?php endif; ?>
      </ul>

      <?php if ($isLogged): ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link font-monospace" href="logout.php" style="color: #ff5555;">[ Wyloguj ]</a>
        </li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>
</div>
</header>