<style>
    /* Smooth transition for sidebar */
    #sidebar {
        transition: transform 0.3s ease-in-out;
    }

    /* Hide sidebar on mobile by default */
    @media (max-width: 1023px) {
        #sidebar {
            transform: translateX(-100%);
        }

        #sidebar.open {
            transform: translateX(0);
        }
    }

    /* Ensure main content adjusts for sidebar on desktop */
    @media (min-width: 1024px) {
        main {
            margin-left: 16rem;
            /* w-64 = 16rem */
        }
    }
</style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Mobile Toggle Button -->
    <div class="bg-purple-900 text-white p-4 lg:hidden flex justify-between items-center">
        <span class="text-lg font-semibold">📚 Adullam</span>
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Main Container for Sidebar and Content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:static w-64 flex flex-col bg-purple-900 text-white min-h-screen p-6 space-y-4 z-50">
            <h2 class="text-xl font-bold lg:block hidden">🎓 Dashboard</h2>
            <nav class="space-y-2">
                <a href="dashboard.php" class="block px-4 py-2 rounded hover:bg-purple-800">🏠 Home</a>
                <?php if ($status === 'admitted'): ?>
                    <a href="payment_proof.php" class="block px-4 py-2 rounded hover:bg-purple-800">🏨 Upload proof of Payment</a>

                <?php endif; ?>
                <?php if (strtolower($mode) === 'onsite' && $status === 'admitted'): ?>
    <a href="register_hostel.php" class="block px-4 py-2 rounded hover:bg-purple-800">
        🏨 Hostel Registration
    </a>
<?php endif; ?>

                <a href="preview_application.php" class="block hover:bg-purple-700 px-3 py-2 rounded">📄 View
                    Application</a>
                <a href="profile.php" class="block px-4 py-2 rounded hover:bg-purple-800">👤 Profile</a>
                <a href="logout.php" class="block px-4 py-2 text-red-300 hover:text-white hover:bg-purple-800">🚪
                    Logout</a>
            </nav>
        </aside>