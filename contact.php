<?php include('includes/header.php'); ?>
<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $emailid = $_POST['emailid'];
  $phoneno = $_POST['phoneno'];
  $message = $_POST['message'];
  $query = mysqli_query($con, "INSERT INTO tblcontact(Name, Email, PhoneNumber, Message) VALUES('$name', '$emailid', '$phoneno', '$message')");
  echo "<script>alert('Query sent successfully.');</script>";
  echo "<script>window.location.href='contact.php'</script>";
}
?>

<main class="bg-white">
    <!-- Page Title -->
    <section class="bg-purple-700 py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-white">
            <h1 class="text-3xl font-bold">Contact</h1>
            <nav class="text-sm mt-2 md:mt-0">
                <ol class="flex space-x-2 text-white">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li>/</li>
                    <li class="opacity-80">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Map Section -->
    <section class="w-full">
        <iframe
            src="https://maps.google.com/maps?q=Wurukum%20Makurdi&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
            frameborder="0" scrolling="no" class="w-full h-96"></iframe>
    </section>

    <!-- Contact Info and Form -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Info Panel -->
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-purple-700">📍 Get in Touch</h2>
                <?php $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='contactus'");
        while ($row = mysqli_fetch_array($ret)) { ?>
                <div class="space-y-2 text-sm text-gray-700">
                    <div>
                        <h4 class="font-semibold">Location:</h4>
                        <p><?php echo $row['PageDescription']; ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold">Email:</h4>
                        <p><a href="mailto:<?php echo $row['Email']; ?>"
                                class="text-purple-700 hover:underline"><?php echo $row['Email']; ?></a></p>
                    </div>
                    <div>
                        <h4 class="font-semibold">Call:</h4>
                        <p>+234<?php echo $row['MobileNumber']; ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold">Timing:</h4>
                        <p><?php echo $row['Timing']; ?> WAT</p>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Contact Form -->
            <div class="md:col-span-2">
                <form method="post" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name"
                            class="w-full p-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Your Name" required>
                        <input type="email" name="emailid"
                            class="w-full p-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600"
                            placeholder="Your Email" required>
                    </div>
                    <input type="text" name="phoneno"
                        class="w-full p-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Phone Number" required>
                    <textarea name="message" rows="5"
                        class="w-full p-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="Message" required></textarea>
                    <button type="submit" name="submit"
                        class="bg-purple-700 text-white px-6 py-3 rounded-lg hover:bg-purple-900 transition">Send
                        Message</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>