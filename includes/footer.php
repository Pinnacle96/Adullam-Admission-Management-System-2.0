<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (isset($_POST['sub'])) {
  $email = $_POST['email'];
  $query = mysqli_query($con, "insert into tblsubscriber(Email) value('$email')");
  if ($query) {
    echo "<script>alert('Your subscription was successful!');</script>";
    echo "<script>window.location.href ='index.php'</script>";
  } else {
    echo '<script>alert("Something went wrong. Please try again.")</script>';
  }
}
?>

<!-- Footer Section -->
<footer class="bg-gray-900 text-gray-300 pt-12 pb-6">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

      <!-- Contact Info -->
      <div>
        <h2 class="text-xl font-bold text-white mb-4">ADULLAM</h2>
        <?php
        $ret = mysqli_query($con, "select * from tblpage where PageType='contactus'");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
          <p class="flex items-start text-sm mb-2">
            <svg class="w-5 h-5 mr-2 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
              </path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <?php echo $row['PageDescription']; ?>
          </p>
          <p class="flex items-center text-sm mb-2">
            <svg class="w-5 h-5 mr-2 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
            </svg>
            <strong>Phone:</strong> +234<?php echo $row['MobileNumber']; ?>
          </p>
          <p class="flex items-center text-sm">
            <svg class="w-5 h-5 mr-2 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
            </svg>
            <strong>Email:</strong>
            <a href="mailto:<?php echo $row['Email']; ?>" class="text-purple-500 hover:text-purple-300 ml-1">
              <?php echo $row['Email']; ?>
            </a>
          </p>
        <?php } ?>
      </div>

      <!-- Useful Links -->
      <div>
        <h4 class="text-xl font-semibold text-white mb-4">Useful Links</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="index.php" class="hover:text-purple-400">Home</a></li>
          <li><a href="about.php" class="hover:text-purple-400">About</a></li>
          <li><a href="contact.php" class="hover:text-purple-400">Contact</a></li>
          <li><a href="index.php#services" class="hover:text-purple-400">Program</a></li>
          <li><a href="admin/login.php" class="hover:text-purple-400">Admin Login</a></li>
          <li><a href="https://adullam.ng/#portal/adminLogin.php"
              class="hover:text-purple-400">Administrative</a></li>
        </ul>
      </div>

      <!-- Programs -->
      <div>
        <h4 class="text-xl font-semibold text-white mb-4">Our Programs</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="cert.php" class="hover:text-purple-400">Certificate in Theology</a></li>
          <li><a href="dip.php" class="hover:text-purple-400">Diploma in Theology</a></li>
          <li><a href="biv.php" class="hover:text-purple-400">Bachelor of Divinity</a></li>
          <li><a href="pgdt.php" class="hover:text-purple-400">Postgraduate Degree</a></li>
          <li><a href="masters.php" class="hover:text-purple-400">M.A Christian Apologetics</a></li>
          <li><a href="masters.php" class="hover:text-purple-400">M.A Biblical Studies (OT/NT)</a></li>
          <li><a href="#short.php" class="hover:text-purple-400">Short Course</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div>
        <h4 class="text-xl font-semibold text-white mb-4">Our Newsletter</h4>
        <p class="text-sm mb-4">Subscribe to receive updates on our programs and events.</p>
        <form action="" method="post" class="flex flex-col gap-4">
          <input type="email" name="email" placeholder="Your email address" required
            class="w-full px-4 py-2 rounded-md bg-gray-800 text-white focus:outline-none">
          <button type="submit" name="sub"
            class="bg-purple-700 hover:bg-purple-900 text-white px-4 py-2 rounded-md">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm">
      <p>&copy; <?php echo date('Y'); ?> - 2027 <strong class="text-white px-1">ADULLAM</strong> All rights
        reserved.</p>
      <p class="mt-2">Developed by <a href="https://wa.me/+2348150829549/"
          class="text-purple-500 hover:text-purple-300">Pinnacle Tech Hub</a></p>
    </div>
  </div>
</footer>

<a href="#" id="scroll-top"
  class="fixed bottom-5 right-5 bg-purple-700 text-white p-3 rounded-full shadow-lg hover:bg-purple-900 transition hidden">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
  </svg>
</a>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>;
<script src="js/main.js"></script>
<script>
  // Framer Motion-like intro animation
  document.addEventListener("DOMContentLoaded", () => {
    gsap.to("#hero-title", {
      duration: 1,
      y: 0,
      opacity: 1,
      ease: "power3.out",
      delay: 0.3,
    });

    gsap.to("#hero-sub", {
      duration: 1,
      y: 0,
      opacity: 1,
      ease: "power3.out",
      delay: 0.6,
    });
  });

  const scrollTop = document.getElementById('scroll-top');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) scrollTop.classList.remove('hidden');
    else scrollTop.classList.add('hidden');
  });
  scrollTop.addEventListener('click', e => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
</script>