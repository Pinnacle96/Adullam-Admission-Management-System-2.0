<?php include('includes/header.php'); ?>
<main class="main">

  <!-- Page Title -->
  <section class="bg-gray-900 text-white py-10">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
      <h1 class="text-3xl font-bold">Bachelor of Divinity</h1>
      <nav class="text-sm breadcrumbs mt-2 md:mt-0">
        <ol class="flex space-x-2">
          <li><a href="index.php" class="hover:underline">Home</a></li>
          <li>/</li>
          <li class="text-purple-400">Bachelor of Divinity</li>
        </ol>
      </nav>
    </div>
  </section>


  <!-- Program Info Section -->
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-2 gap-10 items-start">

        <!-- Image -->
        <div class="rounded-lg overflow-hidden">
          <img src="assets/img/acad1.png" alt="Bachelor Program" class="w-full h-auto rounded-lg shadow">
        </div>

        <!-- Accordion -->
        <div>
          <h2 class="text-2xl font-bold text-purple-700 mb-6">Bachelor of Divinity</h2>

          <div class="space-y-4">
            <!-- Learn -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">What You Will Learn</summary>
              <ul class="list-disc list-inside mt-2 text-gray-700">
                <li>Establish believers in the foundation of the Christian Faith</li>
                <li>Develop spiritual stamina for Christian living in a failing world</li>
                <li>Develop skills in critical theological research writing</li>
              </ul>
            </details>

            <!-- Program Option -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">Program Option</summary>
              <p class="mt-2 text-gray-700"><strong>On-Campus:</strong> Full residency program with class
                attendance, ministry practicum, and a field trip.</p>
              <p class="text-gray-700"><strong>Online:</strong> Flexible and engaging program designed for
                those with work and family commitments.</p>
            </details>

            <!-- Program Length -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">Program Length</summary>
              <p class="mt-2 text-gray-700">Diploma - 4 years (8 semesters)</p>
            </details>

            <!-- Admission Requirements -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">Admission Requirements</summary>
              <ul class="list-disc list-inside mt-2 text-gray-700">
                <li>A $10 non-refundable application fee</li>
                <li>A completed Application form (available online)</li>
                <li>A minimum of five credits including English Language in SSCE or its equivalent</li>
                <li>Ability to demonstrate English Language Proficiency (Reading and Writing)</li>
                <li>Two referees</li>
                <li>International students must secure a student visa before traveling.</li>
              </ul>
            </details>

            <!-- Fees -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">Fees</summary>
              <p class="mt-2 text-gray-700">Tuition Fees: <a href="fees/Bachelor 2024.pdf"
                  class="text-purple-700 underline">Download</a></p>
            </details>

            <!-- Course List -->
            <details class="bg-white border border-gray-200 rounded-md p-4">
              <summary class="font-semibold cursor-pointer">Course List</summary>
              <p class="mt-2 text-gray-700">Course List: <a href="course list/bachelor.pdf"
                  class="text-purple-700 underline">Download</a></p>
            </details>
          </div>

          <div class="mt-6">
            <a href="dashboard"
              class="inline-block bg-purple-700 text-white px-6 py-3 rounded-lg shadow hover:bg-purple-900 transition">Apply
              Now</a>
          </div>

        </div>
      </div>
    </div>
  </section>
</main>
<?php include('includes/footer.php'); ?>