<?php include('includes/header.php'); ?>
<main class="main">

  <!-- Page Title -->
  <section class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center justify-between">
      <h1 class="text-3xl font-bold">Short Course</h1>
      <nav class="text-sm breadcrumbs">
        <ol class="flex space-x-2">
          <li><a href="index.php" class="text-purple-400 hover:underline">Home</a></li>
          <li class="text-white">/ Short Course</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Program Info Section -->
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Image -->
        <div class="rounded-xl overflow-hidden">
          <img src="assets/img/acad3.jpg" alt="Short Course" class="w-full h-auto object-cover shadow-lg">
        </div>

        <!-- Program Details -->
        <div class="space-y-6">
          <h2 class="text-2xl font-bold text-purple-700">Short Course</h2>

          <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">📘 What You Will Learn</h3>
            <p class="text-gray-600 italic">Coming Soon...</p>
          </div>

          <a href="#dashboard"
            class="inline-block mt-4 bg-purple-700 hover:bg-purple-900 text-white font-medium py-2 px-6 rounded-lg transition">Apply
            Now</a>
        </div>
      </div>
    </div>
  </section>

</main>
<?php include('includes/footer.php'); ?>