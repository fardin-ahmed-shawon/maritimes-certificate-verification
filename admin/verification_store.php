<?php
require '../dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data safely
    $top_title = $_POST['top_title'] ?? '';
    $policy_text = $_POST['policy_text'] ?? '';
    $certificate_type = $_POST['certificate_type'] ?? '';
    $seafarer_name = $_POST['seafarer_name'] ?? '';
    $validation_result = $_POST['validation_result'] ?? '';
    $certificate_status = $_POST['certificate_status'] ?? '';
    $document_serial_number = $_POST['document_serial_number'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $date_of_issue = $_POST['date_of_issue'] ?? null;
    $date_of_expiry = $_POST['date_of_expiry'] ?? null;
    $stcw_regulations = $_POST['stcw_regulations'] ?? '';

    // Prepare SQL
    $stmt = $conn->prepare("
        INSERT INTO verification_results 
        (top_title, policy_text, certificate_type, seafarer_name, validation_result, certificate_status, document_serial_number, date_of_birth, date_of_issue, date_of_expiry, stcw_regulations)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("<div class='alert alert-danger text-center'>SQL Error: " . $conn->error . "</div>");
    }

    $stmt->bind_param(
        "sssssssssss",
        $top_title,
        $policy_text,
        $certificate_type,
        $seafarer_name,
        $validation_result,
        $certificate_status,
        $document_serial_number,
        $date_of_birth,
        $date_of_issue,
        $date_of_expiry,
        $stcw_regulations
    );

    // Execute and give response
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>
                Verification record added successfully! 
                <a href='verification_list.php'>View Records</a>
              </div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div class='alert alert-warning text-center'>Invalid request method.</div>";
}
?>