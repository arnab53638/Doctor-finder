<?php
// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "doctor_finder");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = $_POST['name'];
    $address     = $_POST['address'];
    $contact     = $_POST['contact'];
    $description = $_POST['description'];
    $link        = $_POST['link']; // ✅ lowercase

    // Handle image upload
    $image    = $_FILES['image']['name']; 
    $tmp_name = $_FILES['image']['tmp_name']; 

    // Make unique filename
    $target_dir  = "IMAGES/uploads/";
    $unique_name = time() . "_" . basename($image);
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($tmp_name, $target_file)) {
        // Prepared statement
        $stmt = mysqli_prepare($conn, "INSERT INTO hospitals (name, address, contact, description, link, image) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            // ✅ 6 variables → "ssssss"
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $address, $contact, $description, $link, $target_file);

            if (mysqli_stmt_execute($stmt)) {
                $message = "✅ Hospital added successfully!";
            } else {
                $message = "❌ Error executing statement: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "❌ Error preparing statement: " . mysqli_error($conn);
        }
    } else {
        $message = "❌ Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Hospital</title>
  <link rel="stylesheet" href="hospital_signup.css">
</head>
<body>
  <div class="form-container">
    <h1>Add Hospital</h1>
    <?php if (!empty($message)) { ?>
      <p class="message"><?php echo $message; ?></p>
    <?php } ?>
    <form method="post" enctype="multipart/form-data">
      <label>Hospital Name:</label>
      <input type="text" name="name" required>

      <label>Address:</label>
      <input type="text" name="address" required>

      <label>Contact:</label>
      <input type="text" name="contact" required>

      <label>Description:</label>
      <textarea name="description" required></textarea>

      <label>Upload Image:</label>
      <input type="file" name="image" accept="image/*" required>

      <label>Link:</label>
      <input type="text" name="link" required>

      <button type="submit">Save</button>
    </form>
  </div>
</body>
</html>
