<?php
require '../dbConnection.php';

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php
    include 'nav.php';
  ?>

  <!-- Details Section -->
  <div class="details-section">
    <h3>Application Details</h3>

    <!-- Seafarer Info -->
    <div class="section-title">Seafarer Information</div>
    <div class="row">
      <div class="col-md-6 info-item">
        <label>First Name:</label>
        <div><?= htmlspecialchars($app['first_name']) ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Middle Name:</label>
        <div><?= htmlspecialchars($app['middle_name']) ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Surname:</label>
        <div><?= htmlspecialchars($app['surname']) ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Date of Birth:</label>
        <div><?= $app['date_of_birth'] ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Document Serial Number:</label>
        <div><?= htmlspecialchars($app['document_serial']) ?></div>
      </div>
      <div class="col-md-6 info-item">
        <label>Email Address:</label>
        <div><?= htmlspecialchars($app['email']) ?></div>
      </div>
    </div>

    <!-- Supporting Docs -->
    <div class="section-title">Supporting Documents</div>
    <div class="row">
      <div class="col-md-6 info-item">
        <label>Certificate of Competency:</label>
        <?php if (!empty($app['certificate_of_competency'])): ?>
          <a href="../uploads/<?= htmlspecialchars($app['certificate_of_competency']) ?>" target="_blank" class="btn btn-sm btn-primary">View File</a>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
      </div>
      <div class="col-md-6 info-item">
        <label>Certificate of Proficiency:</label>
        <?php if (!empty($app['certificate_of_proficiency'])): ?>
          <a href="../uploads/<?= htmlspecialchars($app['certificate_of_proficiency']) ?>" target="_blank" class="btn btn-sm btn-primary">View File</a>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Meta Info -->
    <div class="section-title">Other Information</div>
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

    <!-- Back Button -->
    <div class="text-center mt-4">
      <a href="index.php" class="btn-back">← Back to Dashboard</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
