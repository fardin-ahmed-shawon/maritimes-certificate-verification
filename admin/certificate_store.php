<?php
require '../dbConnection.php';

// Function to handle file upload
function uploadFile($file, $uploadDir = './uploads/') {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filename = time() . '_' . basename($file['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile;
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect certificate POST data
    $certificate_type = $_POST['certificate_type'] ?? '';
    $policy_text = $_POST['policy_text'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $certificate_number = $_POST['certificate_number'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $date_of_issue = $_POST['date_of_issue'] ?? null;
    $date_of_expiry = $_POST['date_of_expiry'] ?? null;
    $place_of_issue = $_POST['place_of_issue'] ?? '';
    $title = $_POST['title'] ?? '';
    $name = $_POST['name'] ?? '';

    // Handle file uploads
    $profile_photo = $_FILES['profile_photo']['name'] ? uploadFile($_FILES['profile_photo']) : null;
    $signature_photo = $_FILES['signature_photo']['name'] ? uploadFile($_FILES['signature_photo']) : null;
    $registry_seal_img = $_FILES['registry_seal_img']['name'] ? uploadFile($_FILES['registry_seal_img']) : null;
    $authority_signature_img = $_FILES['authority_signature_img']['name'] ? uploadFile($_FILES['authority_signature_img']) : null;

    // Generate certificate ID
    $certificate_id = 'CERT-' . time();

    // Insert into certificates
    $stmt = $conn->prepare("INSERT INTO certificates 
        (certificate_id, certificate_type, policy_text, profile_photo, signature_photo, full_name, date_of_birth, certificate_number, nationality, date_of_issue, date_of_expiry, place_of_issue, registry_seal_img, authority_signature_img, title, name)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "ssssssssssssssss",
        $certificate_id,
        $certificate_type,
        $policy_text,
        $profile_photo,
        $signature_photo,
        $full_name,
        $date_of_birth,
        $certificate_number,
        $nationality,
        $date_of_issue,
        $date_of_expiry,
        $place_of_issue,
        $registry_seal_img,
        $authority_signature_img,
        $title,
        $name
    );

    if ($stmt->execute()) {
        $newCertId = $conn->insert_id; // Get inserted certificate ID

        // -------- Insert titles_one (multiple allowed) --------
        if (!empty($_POST['title_of_training'])) {
            $stmt1 = $conn->prepare("INSERT INTO titles_one (certificate_id, title_of_training, stcw_regulation, section_stcw_code) VALUES (?, ?, ?, ?)");
            foreach ($_POST['title_of_training'] as $index => $training) {
                $stcw = $_POST['stcw_regulation'][$index] ?? '';
                $section = $_POST['section_stcw_code'][$index] ?? '';
                $stmt1->bind_param("isss", $newCertId, $training, $stcw, $section);
                $stmt1->execute();
            }
            $stmt1->close();
        }

        // -------- Insert titles_two (multiple allowed) --------
        if (!empty($_POST['functions'])) {
            $stmt2 = $conn->prepare("INSERT INTO titles_two (certificate_id, functions, levels, limitations) VALUES (?, ?, ?, ?)");
            foreach ($_POST['functions'] as $index => $function) {
                $level = $_POST['levels'][$index] ?? '';
                $limit = $_POST['limitations_two'][$index] ?? '';
                $stmt2->bind_param("isss", $newCertId, $function, $level, $limit);
                $stmt2->execute();
            }
            $stmt2->close();
        }

        // -------- Insert titles_three (multiple allowed) --------
        if (!empty($_POST['capacity'])) {
            $stmt3 = $conn->prepare("INSERT INTO titles_three (certificate_id, capacity, stcw_regulation, limitations) VALUES (?, ?, ?, ?)");
            foreach ($_POST['capacity'] as $index => $capacity) {
                $stcw3 = $_POST['stcw_regulation_three'][$index] ?? '';
                $limit3 = $_POST['limitations_three'][$index] ?? '';
                $stmt3->bind_param("isss", $newCertId, $capacity, $stcw3, $limit3);
                $stmt3->execute();
            }
            $stmt3->close();
        }

        echo "<div class='alert alert-success text-center'>Certificate created successfully! <a href='certificate_list.php'>View Certificates</a></div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div class='alert alert-warning text-center'>Invalid request method.</div>";
}
?>