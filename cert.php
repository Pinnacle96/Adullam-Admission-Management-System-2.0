<?php include('includes/header.php'); ?>
<main class="main">
    <!-- Page Title -->

    <section class="bg-gray-900 text-white py-10">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <h1 class="text-3xl font-bold">Certificate in Theology</h1>
            <nav class="text-sm breadcrumbs mt-2 md:mt-0">
                <ol class="flex space-x-2">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li>/</li>
                    <li class="text-purple-400">Certificate in Theology</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Certificate Program Section -->
    <section id="certificate-program" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <!-- Image -->
                <div class="fade-in">
                    <img src="assets/img/acad2.jpg" class="rounded-xl shadow-lg" alt="Certificate in Theology">
                </div>

                <!-- Program Info -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-purple-700">Certificate in Theology</h2>

                    <!-- Accordion -->
                    <div class="space-y-4" id="programAccordion">
                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">What You Will Learn</summary>
                            <ul class="list-disc list-inside mt-2 text-gray-600">
                                <li>Establish believers in the foundation of the Christian Faith</li>
                                <li>Develop spiritual stamina for Christian living in a failing world</li>
                                <li>Develop skills in critical thinking</li>
                            </ul>
                        </details>

                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">Program Option</summary>
                            <p class="mt-2 text-gray-600">
                                <strong>On-Campus:</strong> Full residency program with class attendance, ministry
                                practicum, and a field trip.<br>
                                <strong>Online:</strong> Flexible and engaging program for those with family or work
                                commitments.
                            </p>
                        </details>

                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">Program Length</summary>
                            <p class="mt-2 text-gray-600">
                                Campus option: 10 months (with two semesters)<br>
                                Online option: 10 months (with two semesters)
                            </p>
                        </details>

                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">Admission Requirements</summary>
                            <ul class="list-disc list-inside mt-2 text-gray-600">
                                <li>A $10 non-refundable application fee</li>
                                <li>A completed Application form (available online)</li>
                                <li>A minimum of Secondary School Certificate Examination (SSCE) or its equivalent</li>
                                <li>Ability to demonstrate English Language Proficiency (Reading and Writing)</li>
                                <li>Two referees</li>
                                <li>International students applying for On-campus study must secure a student visa from
                                    the Nigerian Embassy in their country before traveling.</li>
                            </ul>
                        </details>

                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">Fees</summary>
                            <p class="mt-2 text-gray-600">Program fees: Tuition Fees: <a
                                    href="fees/Certificate 2024.pdf"
                                    class="text-purple-700 hover:underline">Download</a></p>
                        </details>

                        <details class="bg-white rounded-lg shadow-md p-4">
                            <summary class="cursor-pointer font-semibold text-gray-800">Course List</summary>
                            <p class="mt-2 text-gray-600">Course List: <a href="course list/certificate.pdf"
                                    class="text-purple-700 hover:underline">Download</a></p>
                        </details>
                    </div>

                    <!-- Apply Button -->
                    <a href="dashboard"
                        class="inline-block mt-4 bg-purple-700 text-white px-6 py-3 rounded-md shadow hover:bg-purple-800">Apply
                        Now</a>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>