<?php
require 'dbConnection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $fmname = $_POST['fmname'];
    $fsname = $_POST['fsname'];
    $dbirth = $_POST['dbirth'];
    $dsnumber = $_POST['dsnumber'];
    $femail = $_POST['femail'];

    // File upload handling
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // COC file (required)
    $coc_file = "";
    if (isset($_FILES['coc']) && $_FILES['coc']['error'] == 0) {
        $coc_file = $uploadDir . time() . "_coc_" . basename($_FILES['coc']['name']);
        move_uploaded_file($_FILES['coc']['tmp_name'], $coc_file);
    }

    // COP file (optional)
    $cop_file = NULL;
    if (isset($_FILES['cop']) && $_FILES['cop']['error'] == 0) {
        $cop_file = $uploadDir . time() . "_cop_" . basename($_FILES['cop']['name']);
        move_uploaded_file($_FILES['cop']['tmp_name'], $cop_file);
    }

    // Insert into DB
    $sql = "INSERT INTO applications 
        (first_name, middle_name, surname, date_of_birth, document_serial, email, coc_file, cop_file)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fname, $fmname, $fsname, $dbirth, $dsnumber, $femail, $coc_file, $cop_file);

    if ($stmt->execute()) {
        echo "<script>alert('Application submitted successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>