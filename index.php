<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aqua Sense - Healthy Water, Healthy Fish</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @layer base {
      :root {
        --logo-color: #0277BD;
        --logo-gradient: linear-gradient(to right, #0277BD, #039BE5);
      }
    }
  </style>
</head>
<body class="bg-blue-50 text-gray-900">

<!-- Header Section with Contact and Social Links -->
<header class="bg-[var(--logo-gradient)] text-lightblue py-3"></header>
  <div class="container mx-auto flex justify-between items-center px-4">
    <!-- Logo and Navigation -->
    <div class="logo flex items-center">
      <img src="images/AQUASENSE LOGO.png" alt="Aqua Sense Logo" class="w-32 h-32 mb-4">
      <div class="ml-4">
        <h1 class="text-3xl font-bold">Aqua Sense</h1>
        <p class="text-sm">Healthy Water, Healthy Fish</p>
      </div>
    </div>

        <!-- Main Navigation -->
        <nav>
            <ul class="flex space-x-6">
                <li><a href="#home" class="hover:text-blue-800 text-lightblue">Home</a></li>
                <li><a href="#about" class="hover:text-blue-800 text-lightblue">About</a></li>
                <li><a href="#services" class="hover:text-blue-800 text-lightblue">Services</a></li>
                <li><a href="#impact" class="hover:text-blue-800 text-lightblue">Impact</a></li>
                <li><a href="#pricing" class="hover:text-blue-800 text-lightblue">Pricing</a></li>
                <li><a href="#contact" class="hover:text-blue-800 text-lightblue">Contact</a></li>
            </ul>
        </nav>

        <!-- Signup and Login Buttons -->
        <div class="flex space-x-4">
    <?php
    session_start();
    if (isset($_SESSION['name'])) {
        $username = htmlspecialchars($_SESSION['name']);
        echo '
        <div class="flex items-center space-x-4">
            <span class="text-blue-900 font-semibold">' . $username . '</span>
            <a href="logout.php" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition duration-300">Logout</a>
        </div>';
    } else {
        echo '
        <div class="flex items-center space-x-4">
            
            <a href="login.html" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition duration-300">Login</a>
            <a href="register.html" class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-500 transition duration-300">Sign Up</a>
        </div>';
    }
    ?>
</div>

        </div>
    </div>
</header>

  <!-- Hero Section -->
  <section id="home" class="bg-gradient-to-r from-[#0277BD] to-[#039BE5] text-white py-32">
    <div class="container mx-auto text-center">
      <h2 class="text-5xl font-bold mb-4">Revolutionizing Sustainable Aquaculture</h2>
      <p class="text-xl mb-8">Helping fish farmers achieve optimal growth and sustainability using real-time data and intelligent insights.</p>
      <a href="<?php echo isset($_SESSION['name']) ? 'pond.php' : 'login.html'; ?>" class="bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg text-lg font-semibold hover:bg-yellow-500 transition duration-300">Start Farming</a>
    </div>
  </section>

  <!-- Fishes Section -->
  <section id="fishes" class="py-16 bg-blue-100">
    <div class="container mx-auto">
      <h2 class="text-4xl font-semibold mb-8 text-[var(--logo-color)] text-center">Select which fish you want to Farm</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 justify-items-center">
        <!-- Rui -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Rui">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/Rui.png" alt="Rui" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Rui</span>
          </button>
        </form>
        <!-- Katla -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Katla">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/katla.png" alt="Katla" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Katla</span>
          </button>
        </form>
        <!-- Mrigel -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Mrigel">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/mrigel.png" alt="Mrigel" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Mrigel</span>
          </button>
        </form>
        <!-- Tilapia -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Tilapia">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/tilapia.png" alt="Tilapia" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Tilapia</span>
          </button>
        </form>
        <!-- Pangasius -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Pangasius">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/pangas.png" alt="Pangasius" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Pangas</span>
          </button>
        </form>
        <!-- Koi -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Koi">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/koi.png" alt="Koi" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Koi</span>
          </button>
        </form>
        <!-- Shing -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Shing">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/shing.png" alt="Shing" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Shing</span>
          </button>
        </form>
        <!-- Magur -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Magur">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/magur.png" alt="Magur" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Magur</span>
          </button>
        </form>
        <!-- Bagda -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Bagda">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/bagda.png" alt="Bagda" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Bagda</span>
          </button>
        </form>
        <!-- Golda -->
        <form method="POST" action="fish_info.php">
          <input type="hidden" name="selected_fish" value="Golda">
          <button type="submit" class="w-32 h-32 bg-white rounded-lg shadow flex flex-col items-center justify-center hover:bg-blue-200 transition">
            <img src="images/golda.png" alt="Golda" class="w-16 h-16 mb-2 object-contain" />
            <span class="block font-semibold text-blue-900">Golda</span>
          </button>
        </form>
      </div>
    </div>
  </section>
<!-- Food Recommendation Section -->
<section id="food-recommendation" class="py-16 bg-gradient-to-r from-yellow-100 to-blue-50">
  <div class="container mx-auto text-center">
    <h2 class="text-4xl font-semibold mb-6 text-[var(--logo-color)]">Food Recommendation</h2>
    <p class="text-lg max-w-2xl mx-auto mb-8">
      Discover the best feed options tailored for your fish species and pond conditions. Our intelligent system helps you maximize growth, improve fish health, and reduce costs with expert food recommendations.
    </p>
    <a href="food.php" class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg text-lg font-bold shadow hover:bg-yellow-500 transition duration-300">
      Get Recommendation
    </a>
  </div>
</section>


  <!-- About Section -->
  <section id="about" class="py-16 bg-white text-center">
    <div class="container mx-auto">
      <h2 class="text-4xl font-semibold mb-6 text-[var(--logo-color)]">About Aqua Sense</h2>
      <p class="text-lg max-w-3xl mx-auto">
        Aqua Sense is committed to transforming aquaculture by providing farmers with cutting-edge tools for managing water quality, stocking density, and feed optimization. Our goal is to make sustainable fish farming accessible to all.
      </p>
    </div>
  </section>

  <!-- Footer Section -->
  <footer class="bg-[var(--logo-gradient)] text-[var(--logo-color)] py-8"></footer>
    <div class="container mx-auto text-center">
      <div class="mb-6">
        <h3 class="text-2xl font-semibold">Aqua Sense</h3>
        <p class="text-sm">Your trusted partner in sustainable aquaculture.</p>
      </div>
      <div class="flex justify-center space-x-8 mb-6">
        <a href="#about" class="hover:text-yellow-400">About Us</a>
        <a href="#services" class="hover:text-yellow-400">Services</a>
        <a href="#contact" class="hover:text-yellow-400">Contact</a>
        <a href="/privacy-policy" class="hover:text-yellow-400">Privacy Policy</a>
        <a href="/terms" class="hover:text-yellow-400">Terms & Conditions</a>
      </div>
      <div class="mb-6">
        <h4 class="text-xl font-semibold">Subscribe to Our Newsletter</h4>
        <form action="/subscribe" method="POST" class="flex justify-center space-x-4">
          <input type="email" name="email" placeholder="Enter your email" class="p-3 rounded-lg text-black" required>
          <button type="submit" class="bg-yellow-400 text-blue-900 py-3 px-6 rounded-lg hover:bg-yellow-500 transition duration-300">Subscribe</button>
        </form>
      </div>
      <div class="flex justify-center space-x-6">
        <a href="https://www.facebook.com/aquasense" class="hover:text-yellow-400"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/aquasense" class="hover:text-yellow-400"><i class="fab fa-twitter"></i></a>
        <a href="https://www.linkedin.com/company/aquasense" class="hover:text-yellow-400"><i class="fab fa-linkedin"></i></a>
        <a href="https://www.instagram.com/aquasense" class="hover:text-yellow-400"><i class="fab fa-instagram"></i></a>
      </div>
      <p class="mt-6 text-sm">&copy; 2025 Aqua Sense. All rights reserved.</p>
    </div>

    
  </footer>

</body>
</html>

