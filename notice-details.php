<?php include('includes/header.php'); ?>
<main class="main">
    <!-- Page Title -->
    <section class="bg-gradient-to-r from-purple-800 to-purple-600 py-12 text-white">
        <div class="container mx-auto px-4 flex flex-col lg:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold">Notice</h1>
            <nav class="text-sm mt-4 lg:mt-0">
                <ol class="flex space-x-2">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li class="text-gray-200">/ Notice</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
        $query = mysqli_query($con, "SELECT * FROM tblnotice ORDER BY ID DESC");
        while ($row = mysqli_fetch_array($query)) {
        ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="assets/img/3.jpg" alt="Notice Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-purple-700 mb-2">
                            <a href="#" class="hover:underline"><?php echo htmlspecialchars($row['Title']); ?></a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-3"><?php echo htmlspecialchars($row['CreationDate']); ?></p>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            <?php echo htmlspecialchars($row['Decription']); ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>