<?php
$page_title = "Edit Application";
require 'header.php';

// Check if ID exists
$appId = $_GET['id'] ?? null;
if (!$appId) {
    echo "<h4>Invalid Application ID</h4>";
    exit;
}

// Fetch application details
$sql = "SELECT * FROM applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h4>Application not found.</h4>";
    exit;
}
$app = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name     = $_POST['first_name'] ?? '';
    $middle_name    = $_POST['middle_name'] ?? '';
    $surname        = $_POST['surname'] ?? '';
    $date_of_birth  = $_POST['date_of_birth'] ?? '';
    $document_serial= $_POST['document_serial'] ?? '';
    $email          = $_POST['email'] ?? '';

    // File uploads
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $coc_file = $app['coc_file'];
    if (!empty($_FILES['coc_file']['name'])) {
        $coc_file = "uploads/" . time() . "_coc_" . basename($_FILES['coc_file']['name']);
        move_uploaded_file($_FILES['coc_file']['tmp_name'], "../" . $coc_file);
    }

    $cop_file = $app['cop_file'];
    if (!empty($_FILES['cop_file']['name'])) {
        $cop_file = "uploads/" . time() . "_cop_" . basename($_FILES['cop_file']['name']);
        move_uploaded_file($_FILES['cop_file']['tmp_name'], "../" . $cop_file);
    }

    // Update query
    $updateSql = "UPDATE applications 
                  SET first_name=?, middle_name=?, surname=?, date_of_birth=?, 
                      document_serial=?, email=?, coc_file=?, cop_file=? 
                  WHERE id=?";
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param(
        "ssssssssi",
        $first_name, $middle_name, $surname, $date_of_birth,
        $document_serial, $email, $coc_file, $cop_file, $appId
    );

    if ($stmtUpdate->execute()) {
        echo "<script>alert('Application updated successfully!'); window.location='view_application.php?id=$appId';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating record.</div>";
    }
}
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->

<div class="details-section">
  <h3>Edit Application</h3>

  <!-- Seafarer Info -->
  <div class="section-title">Seafarer Information</div><br>
  <form method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 info-item">
        <label>First Name:</label>
        <input type="text" name="first_name" class="form-control" 
               value="<?= htmlspecialchars($app['first_name']) ?>" required>
      </div>
      <div class="col-md-6 info-item">
        <label>Middle Name:</label>
        <input type="text" name="middle_name" class="form-control" 
               value="<?= htmlspecialchars($app['middle_name']) ?>">
      </div>
      <div class="col-md-6 info-item">
        <label>Surname:</label>
        <input type="text" name="surname" class="form-control" 
               value="<?= htmlspecialchars($app['surname']) ?>" required>
      </div>
      <div class="col-md-6 info-item">
        <label>Date of Birth:</label>
        <input type="date" name="date_of_birth" class="form-control" 
               value="<?= $app['date_of_birth'] ?>" required>
      </div>
      <div class="col-md-6 info-item">
        <label>Document Serial Number:</label>
        <input type="text" name="document_serial" class="form-control" 
               value="<?= htmlspecialchars($app['document_serial']) ?>" required>
      </div>
      <div class="col-md-6 info-item">
        <label>Email Address:</label>
        <input type="email" name="email" class="form-control" 
               value="<?= htmlspecialchars($app['email']) ?>" required>
      </div>
    </div>

    <!-- Supporting Docs -->
    <div class="section-title">Supporting Documents</div><br>
    <div class="row">
      <div class="col-md-6 info-item">
        <label>Certificate of Competency:</label><br>
        <?php if (!empty($app['coc_file'])): ?>
          <a href="../<?= $app['coc_file'] ?>" target="_blank" class="btn btn-sm btn-primary">View Current</a>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
        <input type="file" name="coc_file" class="form-control mt-2">
      </div>

      <div class="col-md-6 info-item">
        <label>Certificate of Proficiency:</label><br>
        <?php if (!empty($app['cop_file'])): ?>
          <a href="../<?= $app['cop_file'] ?>" target="_blank" class="btn btn-sm btn-primary">View Current</a>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
        <input type="file" name="cop_file" class="form-control mt-2">
      </div>
    </div>

    <!-- Meta Info -->
    <div class="section-title">Other Information</div><br>
    <div class="row">
      <div class="col-md-6 info-item">
        <label>Application ID:</label>
        <div><?= $app['id'] ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Submitted At:</label>
        <div><?= $app['created_at'] ?></div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mt-4">
      <button type="submit" class="btn btn-success">Update Application</button>
      <a href="view_application.php?id=<?= $appId ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>