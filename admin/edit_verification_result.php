<?php
$page_title = "Edit Verification Result";
require 'header.php';

// Check if ID provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger text-center'>Invalid ID provided.</div>";
    require 'footer.php';
    exit;
}

$id = intval($_GET['id']);

// Fetch record
$stmt = $conn->prepare("SELECT * FROM verification_results WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-warning text-center'>No record found with this ID.</div>";
    require 'footer.php';
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();

// Handle update on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $update = $conn->prepare("
        UPDATE verification_results 
        SET top_title=?, policy_text=?, certificate_type=?, seafarer_name=?, validation_result=?, 
            certificate_status=?, document_serial_number=?, date_of_birth=?, date_of_issue=?, date_of_expiry=?, 
            stcw_regulations=? 
        WHERE id=?
    ");

    $update->bind_param(
        "sssssssssssi",
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
        $stcw_regulations,
        $id
    );

    if ($update->execute()) {
        echo "<div class='alert alert-success text-center'>
                Record updated successfully! 
                <a href='verification_list.php' class='alert-link'>Back to List</a>
              </div>";
        // Refresh data after update
        $stmt = $conn->prepare("SELECT * FROM verification_results WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger text-center'>Error updating record: " . $update->error . "</div>";
    }
    $update->close();
}
?>

<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Edit Verification Record</h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Top Title</label>
                    <input type="text" name="top_title" class="form-control" value="<?= htmlspecialchars($row['top_title']) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Certificate Type</label>
                    <input type="text" name="certificate_type" class="form-control" value="<?= htmlspecialchars($row['certificate_type']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Seafarer Name</label>
                    <input type="text" name="seafarer_name" class="form-control" value="<?= htmlspecialchars($row['seafarer_name']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Document Serial Number</label>
                    <input type="text" name="document_serial_number" class="form-control" value="<?= htmlspecialchars($row['document_serial_number']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Validation Result</label>
                    <input type="text" name="validation_result" class="form-control" value="<?= htmlspecialchars($row['validation_result']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Certificate Status</label>
                    <input type="text" name="certificate_status" class="form-control" value="<?= htmlspecialchars($row['certificate_status']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">STCW Regulations</label>
                    <input type="text" name="stcw_regulations" class="form-control" value="<?= htmlspecialchars($row['stcw_regulations']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($row['date_of_birth']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Issue</label>
                    <input type="date" name="date_of_issue" class="form-control" value="<?= htmlspecialchars($row['date_of_issue']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Expiry</label>
                    <input type="date" name="date_of_expiry" class="form-control" value="<?= htmlspecialchars($row['date_of_expiry']) ?>">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Policy Text</label>
                    <textarea name="policy_text" class="form-control" rows="4"><?= htmlspecialchars($row['policy_text']) ?></textarea>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">Update Record</button>
                    <a href="verification_list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>