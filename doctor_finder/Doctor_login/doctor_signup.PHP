<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "doctor_finder");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize inputs
    $name         = mysqli_real_escape_string($conn, trim($_POST['name']));
    $specialty    = mysqli_real_escape_string($conn, trim($_POST['specialty']));
    $city         = mysqli_real_escape_string($conn, trim($_POST['city']));
    $province     = mysqli_real_escape_string($conn, trim($_POST['province']));
    $country      = mysqli_real_escape_string($conn, trim($_POST['country']));
    $postal_code  = mysqli_real_escape_string($conn, trim($_POST['postal_code']));
    $phone        = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $chamber_name = mysqli_real_escape_string($conn, trim($_POST['chamber_name']));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password     = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if email already exists
    $checkemail = "SELECT * FROM doctor_db WHERE email='$email'";
    $result = mysqli_query($conn, $checkemail);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already exists. Please use a different email.";
    } elseif (
        empty($name) || empty($specialty) || empty($city) || empty($province) ||
        empty($country) || empty($postal_code) || empty($phone) ||
        empty($chamber_name) || empty($email) || empty($password)
    ) {
        $error = "All fields are required.";
    } else {
        // Insert into database
        $sql = "INSERT INTO doctor_db 
                (name, specialty, city, province, country, postal_code, phone, chamber_name, email, password) 
                VALUES 
                ('$name', '$specialty', '$city', '$province', '$country', '$postal_code', '$phone', '$chamber_name', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            $success = "Doctor registered successfully!";
        } else {
            $error = "Database Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Registration</title>
    <link href="sign_up.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4">Doctor Registration</h3>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Doctor Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Specialty</label>
                    <input type="text" name="specialty" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="city" class="form-control mb-2" placeholder="City" required>
                    <input type="text" name="province" class="form-control mb-2" placeholder="Province" required>
                    <input type="text" name="country" class="form-control mb-2" placeholder="Country" required>
                    <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" maxlength="10" pattern="\d{10}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chamber Name</label>
                    <input type="text" name="chamber_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <input type="button" class="btn btn-secondary mt-2" value="Show Password" onclick="togglePasswordVisibility('password')">
                </div>

                <button type="submit" class="btn btn-success">Sign Up</button>

                <h5 class="mt-3">Already have an account?</h5>
                <input type="button" class="btn btn-primary" value="Log-In" onclick="location.href='doctor_login.php'">
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
    </script>
</body>
</html>
