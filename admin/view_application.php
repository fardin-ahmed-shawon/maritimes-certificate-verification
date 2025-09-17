<?php
$page_title = "View Application";
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
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->
<!-- Details Section -->
  <div class="details-section">
    <h3>Application Details</h3>

    <!-- Seafarer Info -->
    <div class="section-title">Seafarer Information</div><br>
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
    <div class="section-title">Supporting Documents</div><br>
    <div class="row">
      <div class="col-md-6 info-item">
        <label>Certificate of Competency:</label>
        <?php if (!empty($app['coc_file'])): 
            $cocFile = htmlspecialchars($app['coc_file']);
            $cocPath = "../" . $cocFile;
            $cocExt = strtolower(pathinfo($cocFile, PATHINFO_EXTENSION));
        ?>
          <div class="mt-2">
            <?php if (in_array($cocExt, ['jpg','jpeg','png','gif','webp'])): ?>
              <img src="<?= $cocPath ?>" alt="Certificate of Competency" class="img-fluid rounded mb-2" style="max-height:250px;">
            <?php endif; ?>
            <br>
            <a href="<?= $cocPath ?>" target="_blank" class="btn btn-sm btn-primary">View</a>
            <a href="<?= $cocPath ?>" download class="btn btn-sm btn-success">Download</a>
          </div>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
      </div>

      <div class="col-md-6 info-item">
        <label>Certificate of Proficiency:</label>
        <?php if (!empty($app['cop_file'])): 
            $copFile = htmlspecialchars($app['cop_file']);
            $copPath = "../" . $copFile;
            $copExt = strtolower(pathinfo($copFile, PATHINFO_EXTENSION));
        ?>
          <div class="mt-2">
            <?php if (in_array($copExt, ['jpg','jpeg','png','gif','webp'])): ?>
              <img src="<?= $copPath ?>" alt="Certificate of Proficiency" class="img-fluid rounded mb-2" style="max-height:250px;">
            <?php endif; ?>
            <br>
            <a href="<?= $copPath ?>" target="_blank" class="btn btn-sm btn-primary">View</a>
            <a href="<?= $copPath ?>" download class="btn btn-sm btn-success">Download</a>
          </div>
        <?php else: ?>
          <span class="text-muted">Not Uploaded</span>
        <?php endif; ?>
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

    <!-- Back Button -->
    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-back">← Back to Dashboard</a>
    </div>
  </div>
<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>
