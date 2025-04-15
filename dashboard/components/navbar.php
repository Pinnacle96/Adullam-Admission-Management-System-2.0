<?php
if (!isset($_SESSION)) session_start();
$name = $_SESSION['name'] ?? 'User';
$role = $_SESSION['role'] ?? '';
?>

<header class="bg-purple-900 text-white p-4 flex justify-between items-center sticky top-0 z-40 lg:hidden">
    <div>
        <h1 class="text-lg font-semibold">📊 <?= ucfirst($role) ?> Panel</h1>
    </div>
    <div class="flex items-center gap-4">
        <button id="mobileSidebarToggle" class="text-white text-2xl focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</header>