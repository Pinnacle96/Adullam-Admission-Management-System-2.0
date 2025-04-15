<?php include('includes/header.php'); ?>
<main class="main">

    <!-- Page Title -->
    <section class="bg-gray-900 text-white py-10">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <h1 class="text-3xl font-bold">Diploma Program</h1>
            <nav class="text-sm breadcrumbs mt-2 md:mt-0">
                <ol class="flex space-x-2">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li>/</li>
                    <li class="text-purple-400">Diploma Program</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Program Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10">
                <!-- Image -->
                <div data-aos="fade-up">
                    <img src="assets/img/acad3.jpg" alt="Diploma Program" class="rounded-xl shadow-md">
                </div>

                <!-- Content -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-2xl font-bold text-purple-700 mb-6">Diploma in Theology</h2>

                    <!-- Accordion -->
                    <div class="space-y-4">
                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">What You Will Learn</summary>
                            <ul class="list-disc list-inside mt-2 text-gray-700">
                                <li>Establish believers in the foundation of the Christian Faith</li>
                                <li>Develop spiritual stamina for Christian living in a failing world</li>
                                <li>Lay foundation for critical theological research writing</li>
                            </ul>
                        </details>

                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">Program Option</summary>
                            <p class="text-gray-700 mt-2">
                                <strong>On-Campus:</strong> Full residency program with class attendance, ministry
                                practicum, and a field trip.<br>
                                <strong>Online:</strong> Designed for those with work and family commitments, this
                                flexible program provides an impactful learning experience.
                            </p>
                        </details>

                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">Program Length</summary>
                            <p class="text-gray-700 mt-2">Diploma - 3 years (6 semesters)</p>
                        </details>

                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">Admission Requirements</summary>
                            <ul class="list-disc list-inside mt-2 text-gray-700">
                                <li>A $10 non-refundable application fee</li>
                                <li>A completed Application form (available online)</li>
                                <li>A minimum of three credits including English Language in SSCE or its equivalent</li>
                                <li>Ability to demonstrate English Language Proficiency (Reading and Writing)</li>
                                <li>Two referees</li>
                                <li>International students must secure a Nigerian student visa before traveling</li>
                            </ul>
                        </details>

                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">Fees</summary>
                            <p class="text-gray-700 mt-2">Program fees:<br>
                                Tuition Fees: <a href="fees/Diploma 2024.pdf"
                                    class="text-purple-700 underline">Download</a>
                            </p>
                        </details>

                        <details class="bg-white p-4 rounded-lg shadow">
                            <summary class="font-semibold cursor-pointer">Course List</summary>
                            <p class="text-gray-700 mt-2">
                                <a href="course list/diploma.pdf" class="text-purple-700 underline">Download Course
                                    List</a>
                            </p>
                        </details>
                    </div>

                    <!-- Apply Button -->
                    <div class="mt-6">
                        <a href="dashboard"
                            class="inline-block bg-purple-700 hover:bg-purple-900 text-white px-6 py-3 rounded-lg font-semibold">Apply
                            Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>