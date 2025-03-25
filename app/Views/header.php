<?php
// Start session to access table number
session_start();

// Get the dynamic page title (fallback to empty if not set)
$pageTitle = isset($pageTitle) ? $pageTitle : "";

// Get the selected table number from session storage
$selectedTable = isset($_SESSION['selectedTable']) ? $_SESSION['selectedTable'] : "";
?>

<nav class="bg-blue-500 p-4 relative">
    <div class="container mx-auto flex items-center relative">
        <!-- Left-aligned Page Title -->
        <?php if (!empty($pageTitle)) : ?>
            <h1 class="text-white text-xl font-bold"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php endif; ?>

        <!-- Centered Table Number -->
        <?php if (!empty($selectedTable)) : ?>
            <span class="absolute left-1/2 transform -translate-x-1/2 text-white text-lg font-semibold">
                Table <?= htmlspecialchars($selectedTable) ?>
            </span>
        <?php endif; ?>
    </div>
</nav>
