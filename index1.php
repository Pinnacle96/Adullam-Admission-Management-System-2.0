<?php include('includes/header.php'); ?>
<main class="main">
  <!-- Modal -->
  <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full animate-fade-in">
      <span class="close-button cursor-pointer text-2xl float-right">×</span>
      <h2 class="text-2xl font-bold text-purple-700 mb-4">Important Admission Update:</h2>
      <p class="text-gray-700">
        The application window for the January 2025 Adullam Session is now closed. Don't worry if you missed
        this intake! The admission portal will reopen soon for the April 2025 intake. Explore the different
        program options, requirements, and fees and optimally prepare to apply for the next session.
      </p>
    </div>
  </div>

  <!-- Hero Section -->
  <section id="hero" class="relative h-screen overflow-hidden">
    <div id="hero-carousel" class="relative w-full h-full">
      <div class="carousel-item absolute w-full h-full opacity-0 transition-opacity duration-1000">
        <img src="assets/img/hero-carousel/2.jpg" alt="Hero 1" class="w-full h-full object-cover">
        <div
          class="absolute inset-0 flex items-center justify-center text-center text-white bg-black bg-opacity-50">
          <div class="animate-slide-in">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">RCN Theological Seminary - Adullam</h2>
            <p class="text-lg md:text-xl mb-6">Adullam is designed with a learning environment that has an
              intense atmosphere of Heaven, accompanied with Spiritual impartations.</p>
            <a href="user/register.php" target="_blank"
              class="bg-purple-700 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-900">Apply
              Now</a>
          </div>
        </div>
      </div>
      <div class="carousel-item absolute w-full h-full opacity-0 transition-opacity duration-1000">
        <img src="assets/img/hero-carousel/4.jpg" alt="Hero 2" class="w-full h-full object-cover">
        <div
          class="absolute inset-0 flex items-center justify-center text-center text-white bg-black bg-opacity-50">
          <div class="animate-slide-in">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">In a world of falsehood, contending</h2>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">for the truth begins with an Education.</h2>
            <a href="about.php"
              class="bg-purple-700 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-900">About
              Us</a>
          </div>
        </div>
      </div>
      <div class="carousel-item absolute w-full h-full opacity-0 transition-opacity duration-1000">
        <img src="assets/img/hero-carousel/1.jpg" alt="Hero 3" class="w-full h-full object-cover">
        <div
          class="absolute inset-0 flex items-center justify-center text-center text-white bg-black bg-opacity-50">
          <div class="animate-slide-in">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">In a world of falsehood, contending</h2>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">for the truth begins with an Education.</h2>
            <a href="contact.php"
              class="bg-purple-700 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-900">Contact
              Us</a>
          </div>
        </div>
      </div>
      <!-- Carousel Controls -->
      <button class="carousel-control-prev absolute top-1/2 left-4 transform -translate-y-1/2 text-white text-3xl"
        aria-label="Previous">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <button
        class="carousel-control-next absolute top-1/2 right-4 transform -translate-y-1/2 text-white text-3xl"
        aria-label="Next">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>
      <!-- Carousel Indicators -->
      <ol class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <li class="w-3 h-3 bg-white rounded-full cursor-pointer"></li>
        <li class="w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></li>
        <li class="w-3 h-3 bg-gray-400 rounded-full cursor-pointer"></li>
      </ol>
    </div>
  </section>

  <!-- Call To Action Section -->
  <section id="call-to-action" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row items-center justify-between animate-fade-in">
        <div class="text-center md:text-left mb-6 md:mb-0">
          <h3 class="text-3xl font-bold text-purple-700">In a world of falsehood, contending</h3>
          <p class="text-lg text-gray-700">for the truth begins with an Education.</p>
        </div>
        <div>
          <a href="#services"
            class="bg-purple-700 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-900">Apply
            Now</a>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="flex justify-center">
          <img src="assets/img/team/team 1.jpg" alt="Provost"
            class="w-64 h-64 object-cover rounded-full animate-slide-in">
        </div>
        <div class="lg:col-span-2">
          <h3 class="text-3xl font-bold text-purple-700 mb-4 animate-slide-in">Provost Welcoming Address</h3>
          <p class="text-gray-700 mb-4 animate-slide-in" style="animation-delay: 0.2s;">
            I am excited to welcome you to <b>RCN Theological Seminary - Adullam.</b> Adullam was
            established in 2015 as a response to the need to equip Christian leaders who will bring accurate
            witness unto Christ in all spheres of life. Adullam is a vibrant community of students,
            faculties, scholars, counsellors, and friends living and learning together in the belief that
            moral and religious values in education are a life-changing experience to which everyone is
            called.
          </p>
          <p class="text-gray-700 mb-4 animate-slide-in" style="animation-delay: 0.4s;">
            Our Seminary is a community bound by a strong commitment to collaboration, respect, diversity,
            inclusion, and learning from one another. This is done within the limits of our absolute
            devotion to Christ and faithfulness to the scriptures. We are a Bible-believing community with a
            firm commitment to biblical orthodoxy, spiritual formation, and the acknowledgement of the
            supernatural operations of the Spirit of God.
          </p>
          <a href="welcome.php"
            class="text-purple-700 hover:text-purple-900 font-semibold flex items-center animate-slide-in"
            style="animation-delay: 0.6s;">
            <span>Read More</span>
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
              </path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 animate-fade-in">
        <h2 class="text-3xl font-bold text-purple-700">Programs</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="cert.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">Certificate
            in Theology</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 0.2s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="dip.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">Diploma in
            Theology</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 0.4s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="biv.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">Bachelor
            of Divinity</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 0.6s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="pgdt.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">Postgraduate
            Diploma in Theology</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 0.8s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="masters.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">M.A
            Christian Apologetics</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 1s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="masters.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">M.A
            Biblical Studies (OT/NT)</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow animate-slide-in"
          style="animation-delay: 1.2s;">
          <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <a href="short.php"
            class="text-xl font-semibold text-purple-700 hover:text-purple-900 text-center block">Short
            Course</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Events & Chapel Services Section -->
  <section id="events-chapel" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Events -->
        <div>
          <h3 class="text-2xl font-bold text-purple-700 mb-6 animate-fade-in"><b>Events</b></h3>
          <div class="relative overflow-hidden">
            <div id="events-carousel" class="flex transition-transform duration-500">
              <div class="min-w-full">
                <img src="assets/images/Events/1.jpg" alt="Event 1"
                  class="w-full h-64 object-cover rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mt-4">Apologetic Conference 2.0</h4>
              </div>
              <div class="min-w-full">
                <img src="assets/images/Events/2.jpg" alt="Event 2"
                  class="w-full h-64 object-cover rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mt-4">Beyond Love Conference 2024</h4>
              </div>
              <div class="min-w-full">
                <img src="assets/images/Events/3.jpg" alt="Event 3"
                  class="w-full h-64 object-cover rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mt-4">Adullam Sport Fest</h4>
              </div>
              <div class="min-w-full">
                <img src="assets/images/Events/4.png" alt="Event 4"
                  class="w-full h-64 object-cover rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mt-4">Adullam Graduation</h4>
              </div>
              <div class="min-w-full">
                <img src="assets/images/Events/mat.jpg" alt="Event 5"
                  class="w-full h-64 object-cover rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mt-4">Adullam Matriculation January 2025
                </h4>
              </div>
            </div>
            <button class="events-prev absolute top-1/2 left-2 transform -translate-y-1/2 text-purple-700">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <button class="events-next absolute top-1/2 right-2 transform -translate-y-1/2 text-purple-700">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                </path>
              </svg>
            </button>
          </div>
        </div>
        <!-- Chapel Services -->
        <div>
          <h3 class="text-2xl font-bold text-purple-700 mb-6 animate-fade-in"><b>Chapel Services</b></h3>
          <div class="relative overflow-hidden">
            <div id="chapel-carousel" class="flex transition-transform duration-500">
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-1.jpg" alt="Chapel 1"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-2.jpg" alt="Chapel 2"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-3.jpg" alt="Chapel 3"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-4.jpg" alt="Chapel 4"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-5.jpg" alt="Chapel 5"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-6.jpg" alt="Chapel 6"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-7.jpg" alt="Chapel 7"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
              <div class="min-w-full">
                <img src="assets/images/Chapel/s-8.jpg" alt="Chapel 8"
                  class="w-full h-64 object-cover rounded-lg">
              </div>
            </div>
            <button class="chapel-prev absolute top-1/2 left-2 transform -translate-y-1/2 text-purple-700">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <button class="chapel-next absolute top-1/2 right-2 transform -translate-y-1/2 text-purple-700">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                </path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="py-16">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 animate-fade-in">
        <h2 class="text-3xl font-bold text-purple-700">Testimonials</h2>
      </div>
      <div class="relative overflow-hidden">
        <div id="testimonials-carousel" class="flex transition-transform duration-500">
          <div class="min-w-full md:min-w-[33.333%] px-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <img src="assets/img/testimonials/nicole.jpeg" alt="Nicole"
                class="w-16 h-16 rounded-full mx-auto mb-4">
              <h3 class="text-xl font-semibold text-gray-700 text-center">Nicole</h3>
              <h4 class="text-gray-500 text-center">Texas, USA</h4>
              <div class="flex justify-center mb-4">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <p class="text-gray-600 italic text-center">
                "I had had previous experiences that made me believe God hated me and was trying to kill
                me. I was always afraid trying so hard to please him and know. At Adullam, I learned so
                much about God that I knew I was being lied to..."
              </p>
            </div>
          </div>
          <div class="min-w-full md:min-w-[33.333%] px-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <img src="assets/img/testimonials/le.jpeg" alt="Lesley Uzohuo"
                class="w-16 h-16 rounded-full mx-auto mb-4">
              <h3 class="text-xl font-semibold text-gray-700 text-center">Lesley Uzohuo</h3>
              <h4 class="text-gray-500 text-center">California, USA</h4>
              <div class="flex justify-center mb-4">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <p class="text-gray-600 italic text-center">
                "Fulfilling my calling would have been a nightmare without the kind of training I
                received at Adullam. I have been ministering part-time for 2 years when I realized I was
                not prepared for ministry..."
              </p>
            </div>
          </div>
          <div class="min-w-full md:min-w-[33.333%] px-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <img src="assets/img/testimonials/li.jpeg" alt="Andy A. Erick"
                class="w-16 h-16 rounded-full mx-auto mb-4">
              <h3 class="text-xl font-semibold text-gray-700 text-center">Andy A. Erick</h3>
              <h4 class="text-gray-500 text-center">Ivory Coast</h4>
              <div class="flex justify-center mb-4">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <p class="text-gray-600 italic text-center">
                "Coming to Adullam was one of the least on my agenda because of the sacrifices attached
                to it. Well, I came after counting the costs, and I discovered there is nothing more
                important than to discover God's will for my life..."
              </p>
            </div>
          </div>
          <div class="min-w-full md:min-w-[33.333%] px-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <img src="assets/img/testimonials/1.jpg" alt="Mr/Mrs Mbuyane"
                class="w-16 h-16 rounded-full mx-auto mb-4">
              <h3 class="text-xl font-semibold text-gray-700 text-center">Mr/Mrs Mbuyane</h3>
              <h4 class="text-gray-500 text-center">Johannesburg, South Africa</h4>
              <div class="flex justify-center mb-4">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <p class="text-gray-600 italic text-center">
                "The benefit of having a structured and regimented spiritual program yields much fruit.
                In about three months into the program, I and my husband already began to enjoy so much
                spiritual growth..."
              </p>
            </div>
          </div>
          <div class="min-w-full md:min-w-[33.333%] px-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
              <img src="assets/img/testimonials/2.jpeg" alt="Francis"
                class="w-16 h-16 rounded-full mx-auto mb-4">
              <h3 class="text-xl font-semibold text-gray-700 text-center">Francis</h3>
              <h4 class="text-gray-500 text-center">Nigeria</h4>
              <div class="flex justify-center mb-4">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                  </path>
                </svg>
              </div>
              <p class="text-gray-600 italic text-center">
                "I am grateful for the opportunity to study at Adullam. The training I received here has
                equipped me to serve effectively in my ministry..."
              </p>
            </div>
          </div>
        </div>
        <button class="testimonials-prev absolute top-1/2 left-2 transform -translate-y-1/2 text-purple-700">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
            </path>
          </svg>
        </button>
        <button class="testimonials-next absolute top-1/2 right-2 transform -translate-y-1/2 text-purple-700">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>
      </div>
    </div>
  </section>
</main>

<?php include('includes/footer.php'); ?>