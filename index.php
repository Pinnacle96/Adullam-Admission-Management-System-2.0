<?php include('includes/header.php'); ?>
<!-- Header -->
<!-- Modal Wrapper -->
<div id="messageModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative animate-fade-in">

        <!-- Close Button -->
        <button id="closeModal"
            class="absolute top-3 right-3 text-gray-400 hover:text-purple-700 text-xl font-bold">&times;</button>

        <!-- Modal Content -->
        <h2 class="text-xl font-semibold text-purple-700 mb-4">📢 Admission Update</h2>
        <p class="text-sm text-gray-700 leading-relaxed">
            The application window for the <strong>January 2025 Adullam Session</strong> is now closed.<br><br>
            Don't worry if you missed this intake! The admission portal will reopen soon for the <strong>April
                2025</strong> intake.
            Explore programs, requirements, and prepare your documents to apply early!
        </p>
    </div>
</div>

<!-- Hero -->
<section id="hero-slider"
    class="relative min-h-[90vh] flex items-center justify-center text-center text-white overflow-hidden">
    <!-- Background slides -->
    <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 slide active"
        style="background-image: url('assets/img/hero-carousel/1.jpg');"></div>
    <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 slide"
        style="background-image: url('assets/img/hero-carousel/4.jpg');"></div>
    <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 slide"
        style="background-image: url('assets/img/hero-carousel/2.jpg');"></div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/60 z-10"></div>

    <!-- Text Content -->
    <!-- Text Content Block -->
    <div id="hero-content" class="relative z-20 max-w-2xl px-4 text-white text-center">
        <div class="hero-text-slide">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6">Equipping a Generation</h2>
            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6">Rooted in truth, forged by prayer.</p>
        </div>
        <div class="hero-text-slide hidden">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6">Training Kingdom Leaders</h2>
            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6">Answer the call. Prepare. Impact nations.</p>
        </div>
        <div class="hero-text-slide hidden">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6">Christ-Centered Curriculum</h2>
            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6">Academic depth meets spiritual fire.</p>
        </div>
        <a href="#programs"
            class="inline-block bg-purple-700 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-purple-900 transition">
            Explore Programs
        </a>
    </div>

</section>
<!-- Call to Action -->
<section class="bg-gray-100 py-14">
    <div
        class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-0 transition-all duration-300">

        <!-- CTA Text -->
        <div class="text-center md:text-left">
            <h2 class="text-2xl md:text-3xl font-extrabold text-purple-700 mb-2">
                In a world of falsehood, contending
            </h2>
            <p class="text-gray-700 text-base md:text-lg">
                for the truth begins with an Education.
            </p>
        </div>

        <!-- CTA Button -->
        <a href="dashboard"
            class="bg-purple-700 text-white px-6 py-3 rounded-full font-medium hover:bg-purple-800 shadow-md transition">
            Apply Now
        </a>
    </div>
</section>
<!-- About Section -->
<section id="about" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-10 items-center">

        <!-- Provost Image -->
        <div class="flex justify-center lg:justify-start">
            <img src="assets/img/team/team 1.jpg" alt="Provost - Adullam Seminary"
                class="w-60 h-60 rounded-full object-cover shadow-md transition-all duration-300 hover:scale-105">
        </div>

        <!-- Text Content -->
        <div class="lg:col-span-2">
            <h2 class="text-2xl md:text-3xl font-extrabold text-purple-700 mb-4">
                Provost's Welcoming Address
            </h2>

            <div class="space-y-4 text-gray-700 leading-relaxed text-base md:text-lg">
                <p>
                    I am excited to welcome you to <strong>RCN Theological Seminary - Adullam</strong>. Adullam was
                    established in 2015
                    as a response to the need to equip Christian leaders who will bring accurate witness unto Christ in
                    all spheres of life.
                </p>

                <p>
                    Adullam is a vibrant community of students, faculty, scholars, and friends living and learning
                    together in the belief
                    that moral and spiritual values in education are transformative. We foster a strong culture of
                    collaboration, inclusion,
                    and biblical orthodoxy.
                </p>

                <p>
                    Our Seminary stands on faithfulness to the Scriptures and deep devotion to Christ — while nurturing
                    spiritual formation and
                    recognizing the supernatural work of the Holy Spirit.
                </p>
            </div>

            <a href="welcome.php"
                class="mt-6 inline-flex items-center text-purple-700 hover:text-purple-900 font-semibold transition">
                <span>Read More</span>
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Programs / Services Section -->
<section id="services" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-purple-700">Explore Our Programs</h2>
            <p class="mt-2 text-gray-600 text-base md:text-lg">Training Christ-like leaders with deep biblical roots.
            </p>
        </div>

        <!-- Program Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            <!-- Card Component -->
            <a href="cert.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">Certificate in
                    Theology</h3>
            </a>

            <a href="dip.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">Diploma in
                    Theology</h3>
            </a>

            <a href="biv.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">Bachelor of
                    Divinity</h3>
            </a>

            <a href="pgdt.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">Postgraduate
                    Diploma</h3>
            </a>

            <a href="masters.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">M.A Christian
                    Apologetics</h3>
            </a>

            <a href="masters.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">M.A Biblical
                    Studies (OT/NT)</h3>
            </a>

            <a href="short.php"
                class="group bg-white rounded-xl p-6 shadow hover:shadow-lg transition border hover:border-purple-200">
                <div class="flex justify-center mb-4">
                    <svg class="w-10 h-10 text-purple-600 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-800 group-hover:text-purple-700">Short Course
                </h3>
            </a>

        </div>
    </div>
</section>

<!-- Events & Chapel Services -->
<section id="events-chapel" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

            <!-- Events Slider -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-purple-700 mb-6">🎉 Seminary Events</h2>
                <div class="swiper swiper-events rounded-xl overflow-hidden shadow-md">
                    <div class="swiper-wrapper">
                        <!-- Slide -->
                        <div class="swiper-slide text-center space-y-3">
                            <img src="assets/images/Events/1.jpg" alt="Event 1"
                                class="w-full h-64 object-cover rounded-md">
                            <h3 class="text-lg font-semibold text-gray-800">Apologetic Conference 2.0</h3>
                        </div>
                        <div class="swiper-slide text-center space-y-3">
                            <img src="assets/images/Events/2.jpg" alt="Event 2"
                                class="w-full h-64 object-cover rounded-md">
                            <h3 class="text-lg font-semibold text-gray-800">Beyond Love Conference 2024</h3>
                        </div>
                        <div class="swiper-slide text-center space-y-3">
                            <img src="assets/images/Events/3.jpg" alt="Event 3"
                                class="w-full h-64 object-cover rounded-md">
                            <h3 class="text-lg font-semibold text-gray-800">Adullam Sport Fest</h3>
                        </div>
                        <div class="swiper-slide text-center space-y-3">
                            <img src="assets/images/Events/4.png" alt="Event 4"
                                class="w-full h-64 object-cover rounded-md">
                            <h3 class="text-lg font-semibold text-gray-800">Adullam Graduation</h3>
                        </div>
                        <div class="swiper-slide text-center space-y-3">
                            <img src="assets/images/Events/mat.jpg" alt="Event 5"
                                class="w-full h-64 object-cover rounded-md">
                            <h3 class="text-lg font-semibold text-gray-800">Matriculation Jan 2025</h3>
                        </div>
                    </div>
                    <div class="swiper-pagination mt-4"></div>
                </div>
            </div>

            <!-- Chapel Services Slider -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-purple-700 mb-6">⛪ Chapel Moments</h2>
                <div class="swiper swiper-chapel rounded-xl overflow-hidden shadow-md">
                    <div class="swiper-wrapper">
                        <!-- Slide -->
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-1.jpg" alt="Service 1"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-2.jpg" alt="Service 2"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-3.jpg" alt="Service 3"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-4.jpg" alt="Service 4"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-5.jpg" alt="Service 5"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-6.jpg" alt="Service 6"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-7.jpg" alt="Service 7"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/Chapel/s-8.jpg" alt="Service 8"
                                class="w-full h-64 object-cover rounded-md">
                        </div>
                    </div>
                    <div class="swiper-pagination mt-4"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-purple-700">💬 What Our Students Say</h2>
            <p class="text-gray-600 text-base mt-2">Real voices, real journeys, transformed lives through Adullam.</p>
        </div>

        <!-- Swiper Container -->
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper">

                <!-- Testimonial Card -->
                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/nicole.jpeg" alt="Nicole"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Nicole</h3>
                        <p class="text-sm text-gray-500">Texas, USA</p>
                        <div class="flex justify-center text-yellow-400 text-sm">
                            ★★★★★
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “At Adullam, I learned so much about God that I knew I was being lied to. Now I walk in
                            peace and truth.”
                        </p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/le.jpeg" alt="Lesley Uzohuo"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Lesley Uzohuo</h3>
                        <p class="text-sm text-gray-500">California, USA</p>
                        <div class="flex justify-center text-yellow-400 text-sm">★★★★★</div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “I realized I wasn’t prepared for ministry. Adullam gave me the framework and spiritual
                            foundation I lacked.”
                        </p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/li.jpeg" alt="Andy A. Erick"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Andy A. Erick</h3>
                        <p class="text-sm text-gray-500">Ivory Coast</p>
                        <div class="flex justify-center text-yellow-400 text-sm">★★★★★</div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “After counting the cost, I discovered nothing is more valuable than discovering God's will
                            through Adullam.”
                        </p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/1.jpg" alt="Mr/Mrs Mbuyane"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Mr/Mrs Mbuyane</h3>
                        <p class="text-sm text-gray-500">Johannesburg, South Africa</p>
                        <div class="flex justify-center text-yellow-400 text-sm">★★★★★</div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “Three months into Adullam, we saw fruit in our spiritual growth through structure and
                            mentoring.”
                        </p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/2.jpeg" alt="Francis"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Francis</h3>
                        <p class="text-sm text-gray-500">Nigeria</p>
                        <div class="flex justify-center text-yellow-400 text-sm">★★★★★</div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “Christ-centered, internationally diverse, and intellectually stretching—Adullam is second
                            to none.”
                        </p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div
                        class="bg-gray-50 border rounded-xl shadow-sm p-6 text-center space-y-4 hover:shadow-md transition">
                        <img src="assets/img/testimonials/4.jpeg" alt="Collinpowell Ebai"
                            class="w-20 h-20 mx-auto rounded-full object-cover shadow">
                        <h3 class="text-lg font-semibold text-gray-800">Collinpowell Ebai</h3>
                        <p class="text-sm text-gray-500">USA</p>
                        <div class="flex justify-center text-yellow-400 text-sm">★★★★★</div>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            “Adullam is a spiritual breeding ground for anyone seeking to follow God’s will with
                            clarity.”
                        </p>
                    </div>
                </div>

            </div>

            <!-- Swiper Controls -->
            <div class="swiper-pagination mt-6"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </div>
</section>


<!-- CTA -->
<!-- <section class="bg-deepPurple text-white py-16 text-center">
    <h3 class="text-3xl font-bold mb-4">Ready to Answer the Call?</h3>
    <p class="mb-6 text-lg">Join a generation being shaped by truth and fire. Applications open now.</p>
    <a href="#" class="bg-white text-deepPurple px-6 py-3 rounded-lg font-medium shadow hover:bg-lightGray transition">
        Apply Now
    </a>
</section> -->

<!-- Footer -->
<?php include('includes/footer.php'); ?>

</body>

</html>