<?php
include '_welconnect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the POST data from the form
    $departmentCode = $_POST['Department_Code'];
    $designGroup = $_POST['Design_Group'];
    $projectName = $_POST['Project_Name'];
    $productGroup = $_POST['Product_Group'];
    $userName = $_POST['User_Name'];
    $description = $_POST['Description'];

    // Insert data into the database
    $sql = "INSERT INTO welcome (`Department Code`, `Design Group`, `Project_Name`, `Product Group`, `User Name`, `Description`) 
            VALUES ('$departmentCode', '$designGroup', '$projectName', '$productGroup', '$userName', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New part generated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect back to the main page after inserting the data
    header("Location: generate.php"); // Replace with your actual page name
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Part Generation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Advance Engineering Part Generation</h3>
    <div class="card p-4">
        <form id="partForm" method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="departmentCode">Department Code</label>
                    <input type="text" class="form-control" name="Department_Code" required>
              <!-- Design Group Dropdown -->

<!-- Sub-Group Dropdown for Design Group 80 -->
<!-- if (isset($_POST['Design_Group']) && $_POST['Design_Group'] == '80'): ?>*/ -->
<div class="form-group col-md-6">
<label for="designGroup">Design Group</label>
    <select class="form-control" name="Sub_Group">
        <option value="">Select</option>
        <option value="10">10 - Assembly</option>
        <option value="20">20 - Cable Wiring & Cables</option>
        <option value="30">30 - Support and Protection System</option>
        <option value="40">40 - Hybrid & High Voltage Sensor</option>
        <option value="45">45 - Motors</option>
        <option value="50">50 - CAD Data Logger</option>
        <option value="55">55 - Inverter and Motor Controllers</option>
        <option value="56">56 - Rectifiers and Chargers</option>
        <option value="58">58 - DC-DC Converters</option>
        <option value="60">60 - Traction Battery & BMS</option>
        <option value="65">65 - Generators</option>
        <option value="66">66 - Belt Starter Generators (BSG)</option>
        <option value="67">67 - In-Line Starter Generators (ISG)</option>
        <option value="70">70 - Super Capacitor Module & Mountings</option>
        <option value="80">80 - Cooling System for Traction Components</option>
        <option value="81">81 - Battery Equaliser</option>
        <option value="85">85 - Battery Management System</option>
        <option value="99">99 - Kits, Sets</option>
    </select>
</div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="projectName">Project Name</label>
                    <input type="text" class="form-control" name="Project_Name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="productGroup">Product Group</label>
                    <select class="form-control" name="Product_Group">
                        <option value="">Select</option>
                        <option value="casting">casting</option>
                        <option value="assembly">assembly</option>
                        <option value="Sheet Metal">Sheet Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Bought Out">Bought Out</option>
                        <option value="Electrical And Electronic Parts">Electrical And Electronic Parts</option>
                        <option value="Machined Parts">Machined Parts</option>
                        <option value="Software">Software</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="userName">User Name</label>
                    <input type="text" class="form-control" name="User_Name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="Description" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate</button>
        </form>
    </div>

    <div class="mt-4">
        <h4>Generated Part List</h4>
        <table class="table table-bordered mt-3" id="partTable">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Department Code</th>
                    <th>Description</th>
                    <th>Project Name</th>
                    <th>User Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM welcome");
                $serialNumber = 1; // Initialize the serial number

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $serialNumber++ . "</td>"; // Increment serial number for each row
                        echo "<td>" . $row['Department Code'] . "</td>";
                        echo "<td>" . $row['Description'] . "</td>";
                        echo "<td>" . $row['Project_Name'] . "</td>";
                        echo "<td>" . $row['User Name'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>
</html>
