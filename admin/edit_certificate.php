<?php
$page_title = "Edit Certificate";
require 'header.php';

// Check if ID exists
$certId = $_GET['id'] ?? null;
if (!$certId) {
    echo "<h4>Invalid Certificate ID</h4>";
    exit;
}

// Fetch certificate details
$sql = "SELECT * FROM certificates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h4>Certificate not found.</h4>";
    exit;
}
$cert = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $certificate_type     = $_POST['certificate_type'] ?? '';
    $policy_text          = $_POST['policy_text'] ?? '';
    $title_of_training    = $_POST['title_of_training'] ?? '';
    $stcw_regulation      = $_POST['stcw_regulation'] ?? '';
    $section_stcw_code    = $_POST['section_stcw_code'] ?? '';
    $full_name            = $_POST['full_name'] ?? '';
    $date_of_birth        = $_POST['date_of_birth'] ?? '';
    $certificate_number   = $_POST['certificate_number'] ?? '';
    $nationality          = $_POST['nationality'] ?? '';
    $date_of_issue        = $_POST['date_of_issue'] ?? '';
    $date_of_expiry       = $_POST['date_of_expiry'] ?? '';
    $place_of_issue       = $_POST['place_of_issue'] ?? '';
    $title                = $_POST['title'] ?? '';
    $name                 = $_POST['name'] ?? '';

    // File uploads
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Profile Photo
    $profile_photo = $cert['profile_photo'];
    if (!empty($_FILES['profile_photo']['name'])) {
        $profile_photo = "uploads/" . time() . "_profile_" . basename($_FILES['profile_photo']['name']);
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], "../" . $profile_photo);
    }

    // Signature Photo
    $signature_photo = $cert['signature_photo'];
    if (!empty($_FILES['signature_photo']['name'])) {
        $signature_photo = "uploads/" . time() . "_signature_" . basename($_FILES['signature_photo']['name']);
        move_uploaded_file($_FILES['signature_photo']['tmp_name'], "../" . $signature_photo);
    }

    // Registry Seal
    $registry_seal_img = $cert['registry_seal_img'];
    if (!empty($_FILES['registry_seal_img']['name'])) {
        $registry_seal_img = "uploads/" . time() . "_seal_" . basename($_FILES['registry_seal_img']['name']);
        move_uploaded_file($_FILES['registry_seal_img']['tmp_name'], "../" . $registry_seal_img);
    }

    // Authority Signature
    $authority_signature_img = $cert['authority_signature_img'];
    if (!empty($_FILES['authority_signature_img']['name'])) {
        $authority_signature_img = "uploads/" . time() . "_authsig_" . basename($_FILES['authority_signature_img']['name']);
        move_uploaded_file($_FILES['authority_signature_img']['tmp_name'], "../" . $authority_signature_img);
    }

    // Update certificate
    $updateSql = "UPDATE certificates SET 
                    certificate_type=?, policy_text=?, title_of_training=?, stcw_regulation=?, section_stcw_code=?,
                    full_name=?, date_of_birth=?, certificate_number=?, nationality=?, date_of_issue=?, date_of_expiry=?, place_of_issue=?,
                    profile_photo=?, signature_photo=?, registry_seal_img=?, authority_signature_img=?, title=?, name=?
                  WHERE id=?";
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param(
        "ssssssssssssssssssi",
        $certificate_type, $policy_text, $title_of_training, $stcw_regulation, $section_stcw_code,
        $full_name, $date_of_birth, $certificate_number, $nationality, $date_of_issue, $date_of_expiry, $place_of_issue,
        $profile_photo, $signature_photo, $registry_seal_img, $authority_signature_img, $title, $name, $certId
    );

    if ($stmtUpdate->execute()) {
        echo "<script>alert('Certificate updated successfully!'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating certificate.</div>";
    }
}
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->

<div class="container my-5">
    <form method="post" enctype="multipart/form-data">

        <!-- Header Preview -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="../certificate_generate/image/certificatelogo.png" alt="Logo" style="width:100px">
            <h4>COOK ISLANDS SHIPS REGISTRY</h4>
            <div style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100px; height: 100px; border: 1px solid #ccc">QR CODE AREA</div>
        </div>

        <!-- Certificate Type & Condition -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <th>CERTIFICATE TYPE:</th>
                    <td><input type="text" name="certificate_type" class="form-control" value="<?= htmlspecialchars($cert['certificate_type']) ?>" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="policy_text" class="form-control" rows="3"><?= htmlspecialchars($cert['policy_text']) ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Training Details -->
        <div class="mt-3">
            <table class="table table-bordered text-center bg-primary text-white">
                <tr>
                    <th>Title of Training</th>
                    <th>STCW Regulation</th>
                    <th>Section of STCW Code</th>
                </tr>
                <tr>
                    <td><input type="text" name="title_of_training" class="form-control" value="<?= htmlspecialchars($cert['title_of_training']) ?>"></td>
                    <td><input type="text" name="stcw_regulation" class="form-control" value="<?= htmlspecialchars($cert['stcw_regulation']) ?>"></td>
                    <td><input type="text" name="section_stcw_code" class="form-control" value="<?= htmlspecialchars($cert['section_stcw_code']) ?>"></td>
                </tr>
            </table>
        </div>

        <!-- Profile Photo & Signature -->
        <div class="mt-3 p-3 border">
            <p>Photograph & Signature of the Holder</p>
            <div class="row">
                <div class="col-md-6">
                    <label>Profile Photo</label><br>
                    <?php if (!empty($cert['profile_photo'])): ?>
                        <a href="<?= $cert['profile_photo'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="profile_photo" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Signature Photo</label><br>
                    <?php if (!empty($cert['signature_photo'])): ?>
                        <a href="<?= $cert['signature_photo'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="signature_photo" class="form-control">
                </div>
            </div>
        </div>

        <!-- Holder Details -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold bg-light">Full Name of the Holder:</td>
                    <td><input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($cert['full_name']) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Birth:</td>
                    <td><input type="date" name="date_of_birth" class="form-control" value="<?= $cert['date_of_birth'] ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Certificate Number:</td>
                    <td><input type="text" name="certificate_number" class="form-control" value="<?= htmlspecialchars($cert['certificate_number']) ?>" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Nationality:</td>
                    <td><input type="text" name="nationality" class="form-control" value="<?= htmlspecialchars($cert['nationality']) ?>"></td>
                </tr>
            </table>
        </div>

        <!-- Issuing Authority -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr class="bg-primary text-white text-center">
                    <th colspan="2">Issuing Authority</th>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Issue:</td>
                    <td><input type="date" name="date_of_issue" class="form-control" value="<?= $cert['date_of_issue'] ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Expiry:</td>
                    <td><input type="date" name="date_of_expiry" class="form-control" value="<?= $cert['date_of_expiry'] ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Place of Issue:</td>
                    <td><input type="text" name="place_of_issue" class="form-control" value="<?= htmlspecialchars($cert['place_of_issue']) ?>"></td>
                </tr>
            </table>
        </div>

        <!-- Seal & Authorized Signature -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr class="bg-primary text-white text-center">
                    <th colspan="2">Seal & Authorized Signature</th>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Registry Seal Image:</td>
                    <td>
                        <?php if (!empty($cert['registry_seal_img'])): ?>
                            <a href="<?= $cert['registry_seal_img'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                        <?php endif; ?>
                        <input type="file" name="registry_seal_img" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Authority Signature Image:</td>
                    <td>
                        <?php if (!empty($cert['authority_signature_img'])): ?>
                            <a href="<?= $cert['authority_signature_img'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                        <?php endif; ?>
                        <input type="file" name="authority_signature_img" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Title:</td>
                    <td><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($cert['title']) ?>"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Name:</td>
                    <td><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cert['name']) ?>"></td>
                </tr>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">Update Certificate</button>
            <a href="index.php" class="btn btn-secondary btn-lg">Cancel</a>
        </div>

    </form>
</div>

<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>