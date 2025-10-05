<?php
// hospital.php
include 'db.php';

$location = '';
$search_sql = '';

if (isset($_GET['location']) && !empty(trim($_GET['location']))) {
    $location = trim($_GET['location']);
    $location_safe = mysqli_real_escape_string($conn, $location);
    $search_sql = "WHERE address LIKE '%$location_safe%'";
}

$sql = "SELECT * FROM hospitals $search_sql";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Hospitals</title>
  <link rel="stylesheet" href="hospitalpage.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script>
    function toggleDoctors(id) {
      const section = document.getElementById("doctors-" + id);
      if (section.style.display === "none" || section.style.display === "") {
        section.style.display = "block";
      } else {
        section.style.display = "none";
      }
    }
  </script>
</head>
<body>
  <div class="container">

    <!-- Header with Location Search and Hospital Sign Up Button -->
    <div class="page-header">
      <form class="search-form" method="GET" action="hospital.php">
        <input
          type="text"
          name="location"
          placeholder="Search by location..."
          value="<?php echo htmlspecialchars($location); ?>"
          required
        />
        <button type="submit">🔍 Search</button>
      </form>

      <!-- Hospital Sign Up Button -->
      <a href="hospital_signup.php" class="signup-btn">Hospital Sign Up</a>
    </div>

    <h1>🏥 Hospital Directory</h1>

    <!-- Filter Bar -->
    <div class="filter-bar">
      <button>⭐ Top Rated</button>
      <button>✔️ Verified</button>
      <button>⚡ Quick Response</button>
      <button>💳 Insurance Accepted</button>
      <button>🔽 Ratings</button>
      <button>⚙️ All Filters</button>
    </div>

    <!-- Hospital Cards -->
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($hospital = mysqli_fetch_assoc($result)) {
    ?>
    <div class="hospital-card">
      <div class="hospital-img">
        <img src="<?php echo htmlspecialchars($hospital['image']); ?>" alt="Hospital Image" loading="lazy" onerror="this.src='fallback.jpg'" />
      </div>

      <div class="hospital-content">
        <h3><?php echo htmlspecialchars($hospital['name']); ?></h3>

        <div class="hospital-tags">
          <span class="rating">⭐ <?php echo rand(3,5) . "." . rand(0,9); ?></span>
          <span class="tag top">Top Rated</span>
          <span class="tag trust">Trusted</span>
        </div>

        <p class="address">📍 <?php echo htmlspecialchars($hospital['address']); ?></p>
        <p class="years">🏥 <?php echo rand(1,50); ?> Years in Healthcare</p>
        <p class="open">🕒 Open 24 Hrs</p>

        <div class="hospital-buttons">
          <a href="tel:<?php echo htmlspecialchars($hospital['contact']); ?>" class="btn show">📞 Show Number</a>
          <a href="https://wa.me/<?php echo htmlspecialchars($hospital['contact']); ?>" target="_blank" class="btn whatsapp">💬 WhatsApp</a>
          <a href="hospital.php?id=<?php echo $hospital['id']; ?>" class="btn enquiry">📩 Send Enquiry</a>
        </div>

        <button class="toggle-btn" onclick="toggleDoctors(<?php echo $hospital['id']; ?>)">👨‍⚕️ Available Doctors</button>
        <div id="doctors-<?php echo $hospital['id']; ?>" class="doctor-section hidden">
          <h4>Available Doctors</h4>
          <?php
            $hospital_id = (int)$hospital['id'];
            $doctor_sql = "SELECT * FROM doctors WHERE hospital_id = $hospital_id";
            $doctor_result = mysqli_query($conn, $doctor_sql);

            if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
                echo "<ul class='doctor-list'>";
                while ($doctor = mysqli_fetch_assoc($doctor_result)) {
                    echo "<li class='doctor-card'>
                            <strong>" . htmlspecialchars($doctor['name']) . "</strong> (" . htmlspecialchars($doctor['specialty']) . ")<br>
                            🗓 " . htmlspecialchars($doctor['checkup_days']) . " | ⏰ " . htmlspecialchars($doctor['checkup_time']) . " | 💰 ₹" . htmlspecialchars($doctor['fee']) . "
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No doctors listed for this hospital.</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <?php
        }
    } else {
        echo "<p>No hospitals found for the searched location.</p>";
    }
    ?>
  </div>
</body>
</html>
