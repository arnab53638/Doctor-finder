<?php
// ✅ Connect to the database (doctor_finder)
$conn = mysqli_connect("localhost", "root", "", "doctor_finder");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HomeDoc</title>
  <link rel="stylesheet" href="pag.css" />
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"> 
</head>

<body>
  <!-- Header -->
  <header>
    <div class="navbar">
      <!-- Left side -->
      <div class="navbar-left">
        <div class="logo">
          <img src="IMAGES/homedoc_icon.png" alt="HomeDoc Logo" width="100" />
        </div>
        <a href="about.php">About</a>
        <div class="dropdown">
          <a href="#">More</a>
          <div class="dropdown-content">
            <a href="contact.php">Contact</a>
            <a href="services.php">Services</a>
            <a href="faq.php">FAQ</a>
          </div>
        </div>
        <a href="hospital.php">Hospitals</a>
      </div>

      <!-- Right side -->
      <div class="navbar-right">
        <div class="search-container">
          <form id="locationForm" method="get">
            <input type="text" id="locationInput" name="location" placeholder="Enter location..." required>
            <select id="typeSelect" name="type">
              <option value="doctor">Doctor</option>
              <option value="hospital">Hospital</option>
            </select>
            <input type="submit" value="Search">
          </form>
        </div>
        <div class="navbar-buttons">
          <a href="Doctor_login/doctor_signup.php" class="btn-success">Sign Up</a>
          <a href="Doctor_login/doctor_login.php">Login</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Your Health, Our <span class="blue">Priority</span></h1>
      <p>With HomeDoc, managing your healthcare is easier than ever:</p>
      <ul class="hero-features">
        <li>🏥 Search for trusted hospitals</li>
        <li>👨‍⚕️ Find doctors by specialization & location</li>
        <li>📅 Book appointments online with ease</li>
        <li>🕒 View doctor visiting schedules at different hospitals</li>
      </ul>
      <div class="hero-buttons">
        <button class="hospital_button" onclick="window.location.href='hospital.php'">Find Hospitals</button>
        <button class="outline" onclick="window.location.href='appointment.php'">Book a Checkup</button>
      </div>
    </div>
    <div class="hero-image">
      <img src="IMAGES/doctor1.jpg" class="hero-slide active" alt="Doctor 1">
      <img src="IMAGES/doctor2.jpg" class="hero-slide" alt="Doctor 2">
      <img src="IMAGES/doctor3.jpg" class="hero-slide" alt="Doctor 3">
      <img src="IMAGES/doctor4.jpg" class="hero-slide" alt="Doctor 4">
      <div class="bottom">💙 100+ Experienced Doctors available</div>
    </div>
  </section>

  <!-- Contributors Section -->
  <section class="contributors">
    <h2>Contributors</h2>
   <div class="doctor-grid">
      <?php
      $contributors = [
        ["Frontend Developer", "IMAGES/TANUSHREE.jpg", "Tanushree Guin"],
        ["WEB Designer", "IMAGES/ARNAB.jpg", "Arnab Das"],
        ["BACKEND Developer", "IMAGES/RAJDEEP.jpg", "Rajdeep Das"],
        ["DATA ANALYST", "IMAGES/ADITYA.jpg", "Aditya Gupta"],
        ["SUPPORT BACKEND Developer", "IMAGES/CHOTTU.jpg", "Chottu"],
        ["Frontend Developer", "IMAGES/BALARKA.jpg", "Balarka Bera"],
        ["DATA ENGINEER", "IMAGES/default.jpg", "Ayan Sasmal"],
        ["DATA ENGINEER", "IMAGES/default.jpg", "Sibayan Pal"],
        ["DATA ENGINEER", "IMAGES/default.jpg", "Aparup Akhuli"]
      ];
      foreach ($contributors as $contributor) {
        echo "<div class='doctor-card'>
                <span class='tag'>{$contributor[0]}</span>
                <img src='{$contributor[1]}' alt='Contributor' />
                <h4>{$contributor[2]}</h4>
              </div>";
      }
      ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <p>&copy; 2025 HomeDoc. All rights reserved.</p>
      <p>📍 Kolkata, India | 📧 <a href="mailto:info@homedoc.com">info@homedoc.com</a></p>
      <div class="socials">
        <a href="#"><i class='bx bxl-facebook'></i></a>
        <a href="#"><i class='bx bxl-twitter'></i></a>
        <a href="#"><i class='bx bxl-instagram'></i></a>
      </div>
    </div>
  </footer>

  <!-- ✅ Scripts -->
  <script>
    // Search
    document.getElementById("locationForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const type = document.getElementById("typeSelect").value;
      const location = document.getElementById("locationInput").value.trim();
      if (!location) {
        alert("Please enter a location.");
        return;
      }
      if (type === "doctor") {
        window.location.href = "search_result.php?location=" + encodeURIComponent(location);
      } else {
        window.location.href = "hospital.php?location=" + encodeURIComponent(location);
      }
    });

    // Hero Slider
    const slides = document.querySelectorAll('.hero-slide');
    let currentIndex = 0;
    setInterval(() => {
      slides[currentIndex].classList.remove('active');
      currentIndex = (currentIndex + 1) % slides.length;
      slides[currentIndex].classList.add('active');
    }, 5000);
  </script>
</body>
</html>
