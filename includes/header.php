<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RCN Theological Seminary - Adullam</title>

  <!-- Meta tags remain unchanged -->
  <meta name="description"
    content="RCN Theological Seminary - Adullam exists to train and equip Christ-like leaders...">
  <!-- Rest of meta tags remain the same -->

  <link rel="icon" href="assets/img/favicon.png">
  <link rel="apple-touch-icon" href="assets/img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#633F83',
            deepPurple: '#5E397F',
            lightGray: '#BABBBD',
            coolGray: '#7A7C7E',
            softGray: '#CFD0D1',
          }
        }
      }
    }
  </script>
  <style>
    .mobile-nav {
      transition: all 0.3s ease-in-out;
    }

    .dropdown-menu {
      transition: all 0.2s ease-in-out;
      max-height: 0;
      overflow: hidden;
    }

    .dropdown-menu.open {
      max-height: 500px;
      /* Adjust based on content */
    }

    @media (max-width: 1279px) {
      .mobile-nav {
        max-height: 0;
        overflow: hidden;
      }

      .mobile-nav.open {
        max-height: 100vh;
      }
    }

    @media (min-width: 1280px) {
      .dropdown-menu {
        max-height: 0;
      }

      .group:hover .dropdown-menu {
        max-height: 500px;
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .animate-fade-in {
      opacity: 0;
      animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body class="bg-white text-gray-800 font-sans">
  <header class="sticky top-0 bg-white shadow z-50">
    <?php
    // Ensure database connection exists
    if (!isset($con)) {
      die("Database connection not established.");
    }

    try {
      // Use prepared statement for security
      $stmt = mysqli_prepare($con, "SELECT Email, MobileNumber FROM tblpage WHERE PageType = ?");
      $pageType = 'contactus';
      mysqli_stmt_bind_param($stmt, "s", $pageType);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $contactData = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_stmt_close($stmt);
    } catch (Exception $e) {
      error_log("Database Query Error: " . $e->getMessage());
      $contactData = []; // Fallback to empty array
    }
    ?>

    <div class="bg-gray-100 text-xs sm:text-sm py-2">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-2">
          <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-6 text-gray-600">
            <?php if (!empty($contactData)): ?>
              <?php foreach ($contactData as $row): ?>
                <div class="flex items-center gap-2">
                  <svg class="w-5 h-5 text-purple-700 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" role="img" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span class="truncate"><?php echo htmlspecialchars($row['Email'] ?? 'N/A'); ?></span>
                </div>
                <div class="flex items-center gap-2">
                  <svg class="w-5 h-5 text-purple-700 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" role="img" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  <span
                    class="truncate">+234<?php echo htmlspecialchars($row['MobileNumber'] ?? 'N/A'); ?></span>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-700 flex-shrink-0" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24" role="img" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="truncate">N/A</span>
              </div>
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-700 flex-shrink-0" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24" role="img" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="truncate">N/A</span>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
    <div class="py-4">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center">
          <a href="index.php" class="flex items-center flex-shrink-0">
            <img src="assets/img/logo1.png" alt="Adullam Logo" class="h-12 w-auto">
          </a>
          <button id="mobile-toggle" class="xl:hidden text-primary focus:outline-none"
            aria-label="Toggle navigation">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
          </button>
          <nav id="navmenu"
            class="mobile-nav hidden xl:block w-full xl:w-auto absolute xl:static top-full left-0 bg-white xl:bg-transparent shadow-xl xl:shadow-none">
            <ul class="flex flex-col xl:flex-row gap-2 xl:gap-6 text-primary font-medium p-4 xl:p-0">
              <li><a href="index.php" class="block py-2 hover:text-deepPurple">Home</a></li>
              <li><a href="about.php" class="block py-2 hover:text-deepPurple">About Us</a></li>
              <li class="relative group">
                <button
                  class="dropdown-toggle block py-2 hover:text-deepPurple w-full text-left xl:hover:text-deepPurple"
                  aria-expanded="false">
                  Academics
                  <svg class="w-4 h-4 inline-block ml-1 xl:hidden" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <ul
                  class="dropdown-menu xl:absolute bg-white xl:shadow-lg mt-1 xl:mt-2 rounded-md w-full xl:w-56 text-gray-700 xl:border">
                  <li><a href="cert.php" class="block px-4 py-2 hover:bg-purple-100">Certificate in
                      Theology</a></li>
                  <li><a href="dip.php" class="block px-4 py-2 hover:bg-purple-100">Diploma in
                      Theology</a></li>
                  <li><a href="biv.php" class="block px-4 py-2 hover:bg-purple-100">Bachelor of
                      Divinity</a></li>
                  <li><a href="pgdt.php" class="block px-4 py-2 hover:bg-purple-100">Postgraduate
                      Diploma</a></li>
                  <li><a href="masters.php" class="block px-4 py-2 hover:bg-purple-100">M.A Christian
                      Apologetics</a></li>
                  <li><a href="masters.php" class="block px-4 py-2 hover:bg-purple-100">M.A Biblical
                      Studies (OT/NT)</a></li>
                  <li><a href="short.php" class="block px-4 py-2 hover:bg-purple-100">Short Course</a>
                  </li>
                </ul>
              </li>
              <li class="relative group">
                <button
                  class="dropdown-toggle block py-2 hover:text-deepPurple w-full text-left xl:hover:text-deepPurple"
                  aria-expanded="false">
                  Campus Life
                  <svg class="w-4 h-4 inline-block ml-1 xl:hidden" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <ul
                  class="dropdown-menu xl:absolute bg-white xl:shadow-lg mt-1 xl:mt-2 rounded-md w-full xl:w-56 text-gray-700 xl:border">
                  <li><a href="#chapel.php" class="block px-4 py-2 hover:bg-purple-100">Chapel</a>
                  </li>
                  <li><a href="#student.php" class="block px-4 py-2 hover:bg-purple-100">Student
                      Ministry</a></li>
                  <li><a href="#counseling.php"
                      class="block px-4 py-2 hover:bg-purple-100">Counseling</a></li>
                  <li><a href="#discipleship.php"
                      class="block px-4 py-2 hover:bg-purple-100">Discipleship</a></li>
                  <li><a href="#mission.php" class="block px-4 py-2 hover:bg-purple-100">Mission</a>
                  </li>
                  <li><a href="#sport.php" class="block px-4 py-2 hover:bg-purple-100">Sport</a></li>
                </ul>
              </li>
              <li><a href="notice-details.php" class="block py-2 hover:text-deepPurple">Events</a></li>
              <li><a href="contact.php" class="block py-2 hover:text-deepPurple">Contact</a></li>
              <li><a href="partner.php" class="block py-2 hover:text-deepPurple">Partnership</a></li>
              <li>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSeFnzuBoA0GdT4aMsnu6B1S1NGQ7cEf_mavpUg0FDEOAiaCzA/viewform?usp=header"
                  target="_blank"
                  class="block bg-primary text-white px-4 py-2 rounded-md hover:bg-deepPurple text-center">
                  10th Years Anniversary
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <script>
    // Mobile menu toggle
    const toggleButton = document.getElementById('mobile-toggle');
    const navMenu = document.getElementById('navmenu');

    toggleButton.addEventListener('click', () => {
      navMenu.classList.toggle('hidden');
      navMenu.classList.toggle('open');
    });

    // Dropdown toggle for mobile
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        if (window.innerWidth < 1280) { // Only on mobile
          e.preventDefault();
          const dropdown = toggle.nextElementSibling;
          dropdown.classList.toggle('open');
          toggle.setAttribute('aria-expanded',
            toggle.getAttribute('aria-expanded') === 'false' ? 'true' : 'false'
          );
        }
      });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!navMenu.contains(e.target) && !toggleButton.contains(e.target) && !navMenu.classList.contains(
          'hidden')) {
        navMenu.classList.add('hidden');
        navMenu.classList.remove('open');
        // Close all dropdowns when main menu closes
        document.querySelectorAll('.dropdown-menu.open').forEach(dropdown => {
          dropdown.classList.remove('open');
        });
        dropdownToggles.forEach(toggle => {
          toggle.setAttribute('aria-expanded', 'false');
        });
      }
    });

    // Reset dropdowns on resize to desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1280) {
        document.querySelectorAll('.dropdown-menu.open').forEach(dropdown => {
          dropdown.classList.remove('open');
        });
        dropdownToggles.forEach(toggle => {
          toggle.setAttribute('aria-expanded', 'false');
        });
      }
    });
  </script>
</body>

</html>