<?php
$showAlert = false;
$showError = false;
/* include 'partials/_nav.php'; */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbregister.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $Emp_Id = $_POST['Emp_Id'];
    $Phone = $_POST['Phone'];
    $alt_phone = $_POST['alt_phone']; 
    $Department = $_POST['Department'];
    $Gender = $_POST['gender'];

    // Check if user already exists
    $existSql = "SELECT * FROM users WHERE Emp_Id = ?";
    $stmt = mysqli_prepare($conn, $existSql);
    mysqli_stmt_bind_param($stmt, "s", $Emp_Id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        $showError = "User with Emp_Id already registered";
    } else {
        // Hash the password before storing
        $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
       

        // Insert new user using prepared statements
        $sql = "INSERT INTO users (first_name, last_name, Email, password, Emp_Id, Phone, alt_phone, Department, Gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $last_name, $Email, $hashed_password, $Emp_Id, $Phone, $alt_phone, $Department, $Gender);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $showAlert = true;
        } else {
            $showError = "Error in registration.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css"> 
  <!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>  -->

<body>

<?php 
if($showAlert){ 
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
    <strong>Form Submitted Successfully!</strong>
    <button type="button" class="btn-close" data-ds-dismiss="alert" aria-label="Close"></button>
    </div>';
}
if($showError){ 
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
    <strong>Error!</strong> '.$showError.'
    <button type="button" class="btn-close" data-ds-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>
<br>
<div class="container">
    <h2>Registration Form</h2>
    <form action="register.php" method="post" autocomplete="off">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div class="mail-container">
            <label for="Email">Email:</label>
            <input type="email" id="Email" name="Email" autocomplete="new-username" required>
        </div>
        <div class="password">
            <label for="Password">Password:*</label>
            <input type="password" id="Password" name="Password" required>
        </div>
        <div class="form-group">
            <label for="Emp_Id">Emp ID:</label>
            <input type="text" id="Emp_Id" name="Emp_Id" required>
        </div>
        <div class="phone-container">
            <div class="phone-block">
                <label for="Phone">Phone:</label>
                <input type="tel" id="Phone" name="Phone" required>
            </div>
            <div class="alt-phone-block">
                <label for="alt_phone">Alt Phone:</label>
                <input type="tel" id="alt_phone" name="alt_phone">
            </div>
        </div>
        <div class="field-group">
            <div class="department-block">
                <label for="Department">Department:</label>
                <input type="text" id="Department" name="Department" required>
            </div>
            <div class="gender-block">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="">Select...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Register</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  -->
</body>
</html>
