<?php include('includes/header.php'); ?>
<main class="main">
    <!-- Page Title -->
    <div class="bg-gray-900 py-12">
        <div class="container mx-auto px-4 flex flex-col lg:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold text-white">Master of Arts</h1>
            <nav class="text-gray-300 mt-2 lg:mt-0">
                <ol class="flex space-x-2 text-sm">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li>/</li>
                    <li class="text-purple-400">Master of Arts</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Master of Arts Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <img src="assets/img/acad2.jpg" class="w-full rounded-xl shadow-md" alt="Master of Arts">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-purple-700 mb-6">Master of Arts</h2>

                    <div class="space-y-4">
                        <!-- What You Will Learn -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">What You Will Learn
                            </summary>
                            <ul class="mt-2 list-disc list-inside text-gray-700">
                                <li>Advanced knowledge of the Bible in historical and theological context</li>
                                <li>Proficiency in biblical interpretation</li>
                                <li>Understanding of Christian apologetics principles and practices</li>
                                <li>Critical thinking and defense of faith</li>
                            </ul>
                        </details>

                        <!-- Program Option -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Program Option
                                Available</summary>
                            <p class="mt-2 text-gray-700">
                                <strong>Masters of Theology Biblical Studies:</strong> Old & New Testament<br>
                                <strong>Masters of Theology:</strong> Christian Apologetics
                            </p>
                        </details>

                        <!-- Learning Options -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Learning Option
                                Available</summary>
                            <p class="mt-2 text-gray-700">
                                <strong>On-Campus:</strong> Full-time residency with class, ministry practicum, and
                                field trips.<br>
                                <strong>Online:</strong> Flexible learning for working professionals.
                            </p>
                        </details>

                        <!-- Program Length -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Program Length
                            </summary>
                            <p class="mt-2 text-gray-700">
                                Campus & Online: 24 months (4 semesters)
                            </p>
                        </details>

                        <!-- Admission Requirements -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Admission Requirements
                            </summary>
                            <ul class="mt-2 list-disc list-inside text-gray-700">
                                <li>$20 non-refundable application fee</li>
                                <li>Completed application form</li>
                                <li>Bachelor of Theology or Postgraduate Diploma in Theology</li>
                                <li>Two referees</li>
                                <li>International students must secure a student visa</li>
                            </ul>
                        </details>

                        <!-- Fees -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Fees</summary>
                            <p class="mt-2 text-gray-700">Tuition: <a href="fees/Masters 2025.docx"
                                    class="text-purple-700 hover:underline">Download Fees Document</a></p>
                        </details>

                        <!-- Course List -->
                        <details class="bg-white shadow rounded-lg p-4">
                            <summary class="cursor-pointer font-semibold text-lg text-purple-700">Course List</summary>
                            <p class="mt-2 text-gray-700">
                                <strong>M.A Biblical Studies (OT/NT):</strong>
                                <a href="course list/M.A. THEOLOGY - BIBLICAL STUDIES COURSE LISTING.pdf"
                                    class="text-purple-700 hover:underline">Download</a><br>
                                <strong>M.A Christian Apologetics:</strong>
                                <a href="course list/M.A. THEOLOGY - CHRISTIAN APOLOGETICS COURSE LISTING.pdf"
                                    class="text-purple-700 hover:underline">Download</a>
                            </p>
                        </details>
                    </div>

                    <a href="dashboard"
                        class="inline-block mt-6 px-6 py-3 bg-purple-700 text-white rounded-lg hover:bg-purple-900">Apply
                        Now</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('includes/footer.php'); ?>