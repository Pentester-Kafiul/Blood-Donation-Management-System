<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-red-600 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="login.php" class="text-3xl font-bold tracking-wide">Donate Blood</a>
            <ul class="flex space-x-6">
                <li><a href="#about" class="hover:text-gray-300 transition">About Us</a></li>
                <li><a href="#why-donate" class="hover:text-gray-300 transition">Why Donate?</a></li>
                <li><a href="#contact" class="hover:text-gray-300 transition">Contact</a></li>
            </ul>
            <a href="login.php" class="bg-white text-red-600 px-4 py-2 rounded-lg shadow-lg font-semibold hover:bg-gray-100 transition">Donate Now</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-r from-red-500 to-red-700 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-4 animate-bounce">Be a Hero, Save Lives</h1>
            <p class="text-lg mb-8 max-w-3xl mx-auto">Every drop counts. Join us in our mission to make the world a healthier place by donating blood and saving lives.</p>
            <a href="login.php" class="bg-white text-red-600 px-8 py-4 rounded-full shadow-lg font-semibold text-lg hover:bg-gray-100 transition transform hover:scale-105">Start Donating</a>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">About Us</h2>
            <p class="text-lg max-w-3xl mx-auto mb-8">We aim to connect donors with those in need, ensuring no one suffers due to a lack of blood supply. Join us to make a difference.</p>
            <div class="flex justify-center">
                <img src="../image/human-blood-donate-and-heart-rate-on-white-background-free-vector.jpg" alt="Blood Donation" class="rounded-lg shadow-lg w-3/4 md:w-1/2">
            </div>
        </div>
    </section>

    <!-- Why Donate Section -->
    <section id="why-donate" class="py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Why Donate Blood?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition">
                    <i data-feather="heart" class="text-red-600 w-12 h-12 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Save Lives</h3>
                    <p class="text-gray-600">Your donation can save up to three lives and bring hope to those in need.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition">
                    <i data-feather="users" class="text-red-600 w-12 h-12 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Build Community</h3>
                    <p class="text-gray-600">Become part of a compassionate network that supports health and humanity.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition">
                    <i data-feather="activity" class="text-red-600 w-12 h-12 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Health Benefits</h3>
                    <p class="text-gray-600">Regular donations promote better health and reduce certain health risks.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Get In Touch</h2>
            <p class="text-lg max-w-xl mx-auto mb-8">Have questions or want to get involved? Contact us, and we’ll assist you promptly.</p>
            <form class="max-w-xl mx-auto space-y-4">
                <input type="text" placeholder="Your Name" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                <input type="email" placeholder="Your Email" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                <textarea placeholder="Your Message" rows="4" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg font-semibold hover:bg-red-700 transition">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-red-600 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Donate Blood. All rights reserved.</p>
        </div>
    </footer>
    <script>
        feather.replace();
    </script>
</body>
</html>
