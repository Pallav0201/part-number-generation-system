<?php
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbregister.php';
    $emp_id = $_POST['emp_id'];
    $password = $_POST['password'];

    // Prepare statement to avoid SQL injection
    $sql = "SELECT * FROM users WHERE Emp_Id = ?";
    $stmt = mysqli_prepare($conn, $sql); 
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $emp_id);
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Fetch result
    $result = mysqli_stmt_get_result($stmt); 
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['emp_id'] = $emp_id;
            $_SESSION['success_message'] = "You have successfully logged in!";
            header("location: welcome.php");
            exit;
        } else {
            $showError = "Incorrect password!";
        }
    } else {
        $showError = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background-image: url('partials/bgimg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        h1 {
            margin-bottom: 20px;
            color: rgb(0,9,9);
        }
        .form-group, .mail-container, .password, .phone-container, .field-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: rgb(0,0,9);
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"], select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        p {
            font-size: 80%;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?php require 'partials/_nav.php'; ?>
    <!-- Login form content here -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

   <?php
  if($login){ 
   echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
     <strong>Success!</strong>You are logged in '.$login.'
     <button type="button" class="btn-close" data-ds-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button> 
     </div> ';
   }
   if($showError){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
      <strong>Error!</strong> '.$showError.'
      <button type="button" class="btn-close" data-ds-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button> 
      </div> ';
    }
     ?>
 
    <div class="container my-4">
        <h1 class="text-center">Login to our website</h1>
        <form action="/login_page/login.php" method="post">
            <div class="mb-3">
                <label for="emp_id" class="form-label">emp_id</label>
                <input type="text" class="form-control" id="emp_id" name="emp_id" required aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <p>password should be atleast 8 digit or must contain special characters.</p>
            </div>
           
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Login</button>
               
            </div>
             <!-- Link to Registration Page -->
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
