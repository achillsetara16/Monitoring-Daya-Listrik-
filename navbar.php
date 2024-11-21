<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<nav>
    <div class="logo">
        <img src="image/logo.png" alt="Logo" />
        <p>POWER MONITORING</p>
    </div>
    <ul>
        <li><a class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a></li>
        <li><a class="<?= $currentPage == 'control.php' ? 'active' : '' ?>" href="control.php">Control</a></li>
        <li><a class="<?= $currentPage == 'history.php' ? 'active' : '' ?>" href="history.php">History</a></li>
    </ul>
</nav>