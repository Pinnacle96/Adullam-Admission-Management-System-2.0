<!-- Redesigned About Page for Adullam -->
<?php include('includes/header.php'); ?>

<main class="bg-white">
  <!-- Page Banner -->
  <section class="bg-purple-700 py-10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-white">
      <h1 class="text-3xl font-bold">About</h1>
      <nav class="text-sm mt-2 md:mt-0">
        <ol class="flex space-x-2 text-white">
          <li><a href="index.php" class="hover:underline">Home</a></li>
          <li>/</li>
          <li class="opacity-80">About</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12">
      <div>
        <h2 class="text-2xl md:text-3xl font-bold text-purple-700 mb-6">Raising Kingdom-Minded Leaders</h2>
        <img src="assets/img/acad3.jpg" alt="About Adullam" class="rounded-xl shadow-md w-full object-cover">
      </div>

      <div>
        <div class="space-y-4">
          <!-- Accordion Item -->
          <details open class="bg-white border rounded-lg p-4">
            <summary class="cursor-pointer font-semibold text-gray-800">About Us</summary>
            <div class="mt-2 text-gray-700 text-sm">
              <h4 class="font-bold">RCN Theology Seminary</h4>
              <p><strong>Motto:</strong> Contending for the faith</p>
              <p><strong>Vision:</strong> To engage Christian apologetics as a vital aspect of raising
                biblical and theological scholars for life and ministry.</p>
            </div>
          </details>

          <details class="bg-white border rounded-lg p-4">
            <summary class="cursor-pointer font-semibold text-gray-800">Mission / Purpose Statement
            </summary>
            <p class="mt-2 text-gray-700 text-sm">
              RCN Theological Seminary - Adullam exists to train and equip Christ-like leaders to apply
              biblical, theological,
              and apologetic principles in real-world contexts through evangelism, preaching, teaching,
              counseling, and
              cross-cultural missions for church and society.
            </p>
          </details>

          <details class="bg-white border rounded-lg p-4">
            <summary class="cursor-pointer font-semibold text-gray-800">Core Values</summary>
            <ul class="list-disc list-inside text-gray-700 text-sm mt-2">
              <li>Sound Biblical Doctrine</li>
              <li>Intercessory Prayers</li>
              <li>Godly Lifestyle</li>
              <li>Accurate Witness</li>
              <li>Practical Training & Experiential Learning</li>
              <li>Dedication to Academic Excellence</li>
            </ul>
          </details>

          <details class="bg-white border rounded-lg p-4">
            <summary class="cursor-pointer font-semibold text-gray-800">Adullam History</summary>
            <p class="mt-2 text-gray-700 text-sm">
              Adullam began in 2015 as a Bible college with 35 students in modular programs. In July 2022,
              it became a full
              seminary producing transformational leaders impacting church and society.
            </p>
          </details>
        </div>
      </div>
    </div>
  </section>

  <!-- Optional: Team Section Integration (if needed later) -->

  <?php include('includes/footer.php'); ?>
</main>