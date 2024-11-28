<?php
include '_welconnect.php'; // Ensure database connection

$generatedPartNumber = ""; // Variable to hold the generated part number

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and validate data
    $departmentCode = isset($_POST['Department_Code']) ? $_POST['Department_Code'] : '';
    $designGroup = isset($_POST['Design_Group']) ? $_POST['Design_Group'] : '';
    $productGroup = isset($_POST['Product_Group']) ? $_POST['Product_Group'] : '';
    $userName = isset($_POST['User_Name']) ? $_POST['User_Name'] : '';
    $projectName = isset($_POST['Project_Name']) ? $_POST['Project_Name'] : '';
    $description = isset($_POST['Description']) ? $_POST['Description'] : '';

    // Ensure all required fields are provided and numeric where necessary
    if (is_numeric($departmentCode) && is_numeric($designGroup) && is_numeric($productGroup)) {
        // Logic for generating the part number
        
        // Barrel 1: Fixed as '2928' for Advance Engineering
        $barrel1 = "2928";

        // Barrel 2: Combining birth year (hardcoded for now) and design group
        $birthYearLastTwo = "95"; // Example: Year '1995'
        $barrel2 = $birthYearLastTwo . str_pad($designGroup, 2, '0', STR_PAD_LEFT);

        // Barrel 3: Using 0 as first digit, and product group for second digit
        $barrel3 = "0" . str_pad($productGroup, 1, '0', STR_PAD_LEFT);

        // Barrel 4: Unique serial number
        $result = $conn->query("SELECT MAX(Part_Number) AS maxPart FROM welcome WHERE Part_Number LIKE '$barrel1$barrel2$barrel3%'");
        $maxPartNumber = $result->fetch_assoc()['maxPart'] ?? null;
        $serialNumber = $maxPartNumber ? intval(substr($maxPartNumber, -2)) + 1 : 1;
        $barrel4 = str_pad($serialNumber, 2, '0', STR_PAD_LEFT);

        // Combine barrels to generate the part number
        $generatedPartNumber = $barrel1 . $barrel2 . $barrel3 . $barrel4;

        // Insert the generated part number and other form data into the database
        $stmt = $conn->prepare("INSERT INTO welcome (Part_Number, Description, Project_Name, `User Name`, `Product Group`) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            echo "Error in preparing statement: " . $conn->error; // Debugging
            exit;
        }
        
        $stmt->bind_param("sssss", $generatedPartNumber, $description, $projectName, $userName, $productGroup);
        if (!$stmt->execute()) {
            echo "Error in execution: " . $stmt->error; // Debugging
            exit;
        }
        $stmt->close();
        
        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "All fields should be numeric and must be filled out to generate a part number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Engineering Part Number System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #355C4C; color: #FFFFFF; }
        .container { margin-top: 50px; background-color: #446B57; padding: 20px; border-radius: 8px; }
        h3 { text-align: center; margin-bottom: 20px; }
        .table-container { background-color: #FFFFFF; color: #000000; padding: 15px; border-radius: 8px; }
        .btn-custom { background-color: #28a745; color: #fff; border: none; }
        .btn-custom:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h3>Advance Engineering Part Number System</h3>
    <form method="post" action="">
        <!-- Form fields for input -->
        <div class="mb-3"><label class="form-label">Dept Code</label><input type="text" class="form-control" name="Department_Code"></div>
        <div class="mb-3"><label class="form-label">Design Group (e.g., 8050)</label><input type="text" class="form-control" name="Design_Group"></div>
        <div class="mb-3"><label class="form-label">Project Name</label><input type="text" class="form-control" name="Project_Name"></div>
        <div class="mb-3"><label class="form-label">Product Group (e.g., 01)</label><input type="text" class="form-control" name="Product_Group"></div>
        <div class="mb-3"><label class="form-label">User Name (e.g., 914855 Vikrant)</label><input type="text" class="form-control" name="User_Name"></div>
        <div class="mb-3"><label class="form-label">Description</label><input type="text" class="form-control" name="Description"></div>
        
        <button type="submit" class="btn btn-custom mb-3" name="generate">Generate Part Number</button>
    </form>

    <!-- Display the generated part number if it was generated -->
    <?php if (!empty($generatedPartNumber)) : ?>
        <div class="alert alert-success mt-3">
            <strong>Generated Part Number:</strong> <?php echo htmlspecialchars($generatedPartNumber); ?>
        </div>
    <?php endif; ?>
</div>

<div class="table-container">
    <h4>Generated Part Numbers</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Part Number</th>
                <th>Description</th>
                <th>Project Name</th>
                <th>User ID & Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM welcome");
            if ($result->num_rows > 0) {
                $srNo = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $srNo++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['Part_Number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Project_Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['User Name']) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
