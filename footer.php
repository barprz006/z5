<?php declare(strict_types=1); ?>
<footer class="page-footer mt-auto bg-light border-primary">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <span>Portal laboratoryjny - Politechnika Bydgoska</span>
        <span id="footer-info">Zalogowany jako: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Gość'); ?></span>
    </div>
</footer>