<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "doctor_finder");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$location = '';
if (isset($_GET['location']) && !empty(trim($_GET['location']))) {
    $location = mysqli_real_escape_string($conn, trim($_GET['location']));
}

// Prepare SQL to search doctors based on location fields (city, province, country, postal_code)
$sql = "SELECT * FROM doctor_db WHERE 1";

if ($location !== '') {
    $sql .= " AND (
        city LIKE '%$location%' OR 
        province LIKE '%$location%' OR 
        country LIKE '%$location%' OR 
        postal_code LIKE '%$location%'
    )";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Search Results</title>
    <link rel="stylesheet" href="search_results.css" />
</head>

<body>
    <div class="search-container">
        <h2>Doctors in "<?php echo htmlspecialchars($location); ?>"</h2>

        <div class="search-results">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = htmlspecialchars($row['name'] ?? 'N/A');
                    $specialty = htmlspecialchars($row['specialty'] ?? 'N/A');
                    $city = htmlspecialchars($row['city'] ?? 'N/A');
                    $province = htmlspecialchars($row['province'] ?? 'N/A');
                    $country = htmlspecialchars($row['country'] ?? 'N/A');
                    $postal_code = htmlspecialchars($row['postal_code'] ?? 'N/A');
                    $phone = htmlspecialchars($row['phone'] ?? 'N/A');
                    $chamber_name = htmlspecialchars($row['chamber_name'] ?? 'N/A');
                    $email = htmlspecialchars($row['email'] ?? 'N/A');

                    echo "<div class='doctor-result'>
                            <strong>$name</strong><br/>
                            Specialty: $specialty<br/>
                            Location: $city, $province, $country, $postal_code<br/>
                            Contact: $phone<br/>
                            Chamber Name: $chamber_name<br/>
                            Email: $email
                          </div>";
                }
            } else {
                echo "<p>No doctors found in this location.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>
