<?php
$page_title = "Edit Certificate";
require 'header.php';

// Check certificate ID
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

// Fetch Title One / Two / Three entries
$titleOne = [];
$t1 = $conn->prepare("SELECT * FROM titles_one WHERE certificate_id = ?");
$t1->bind_param("i", $certId);
$t1->execute();
$res1 = $t1->get_result();
while ($row = $res1->fetch_assoc()) { $titleOne[] = $row; }

$titleTwo = [];
$t2 = $conn->prepare("SELECT * FROM titles_two WHERE certificate_id = ?");
$t2->bind_param("i", $certId);
$t2->execute();
$res2 = $t2->get_result();
while ($row = $res2->fetch_assoc()) { $titleTwo[] = $row; }

$titleThree = [];
$t3 = $conn->prepare("SELECT * FROM titles_three WHERE certificate_id = ?");
$t3->bind_param("i", $certId);
$t3->execute();
$res3 = $t3->get_result();
while ($row = $res3->fetch_assoc()) { $titleThree[] = $row; }

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $certificate_type     = $_POST['certificate_type'] ?? '';
    $policy_text          = $_POST['policy_text'] ?? '';
    $full_name            = $_POST['full_name'] ?? '';
    $date_of_birth        = $_POST['date_of_birth'] ?? null;
    $certificate_number   = $_POST['certificate_number'] ?? '';
    $nationality          = $_POST['nationality'] ?? '';
    $date_of_issue        = $_POST['date_of_issue'] ?? null;
    $date_of_expiry       = $_POST['date_of_expiry'] ?? null;
    $place_of_issue       = $_POST['place_of_issue'] ?? '';
    $title                = $_POST['title'] ?? '';
    $name                 = $_POST['name'] ?? '';

    // Upload files
    function uploadFile($file, $oldFile = null) {
        if ($file['name']) {
            $uploadDir = "../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $filename = time() . '_' . basename($file['name']);
            $target = $uploadDir . $filename;
            move_uploaded_file($file['tmp_name'], $target);
            return $target;
        }
        return $oldFile;
    }

    $profile_photo = uploadFile($_FILES['profile_photo'], $cert['profile_photo']);
    $signature_photo = uploadFile($_FILES['signature_photo'], $cert['signature_photo']);
    $registry_seal_img = uploadFile($_FILES['registry_seal_img'], $cert['registry_seal_img']);
    $authority_signature_img = uploadFile($_FILES['authority_signature_img'], $cert['authority_signature_img']);

    // Update main certificate
    $updateSql = "UPDATE certificates SET 
        certificate_type=?, policy_text=?, full_name=?, date_of_birth=?, certificate_number=?, nationality=?, 
        date_of_issue=?, date_of_expiry=?, place_of_issue=?, profile_photo=?, signature_photo=?, registry_seal_img=?, 
        authority_signature_img=?, title=?, name=? WHERE id=?";
    $stmtUpdate = $conn->prepare($updateSql);
    $stmtUpdate->bind_param(
        "sssssssssssssssi",
        $certificate_type, $policy_text, $full_name, $date_of_birth, $certificate_number, $nationality,
        $date_of_issue, $date_of_expiry, $place_of_issue, $profile_photo, $signature_photo, $registry_seal_img,
        $authority_signature_img, $title, $name, $certId
    );
    $stmtUpdate->execute();

    // Delete old title entries
    $conn->query("DELETE FROM titles_one WHERE certificate_id=$certId");
    $conn->query("DELETE FROM titles_two WHERE certificate_id=$certId");
    $conn->query("DELETE FROM titles_three WHERE certificate_id=$certId");

    // Insert new Title One entries
    if (!empty($_POST['title_of_training'])) {
        $stmt1 = $conn->prepare("INSERT INTO titles_one (certificate_id, title_of_training, stcw_regulation, section_stcw_code) VALUES (?, ?, ?, ?)");
        foreach ($_POST['title_of_training'] as $i => $training) {
            $stcw = $_POST['stcw_regulation_one'][$i] ?? '';
            $section = $_POST['section_stcw_code'][$i] ?? '';
            $stmt1->bind_param("isss", $certId, $training, $stcw, $section);
            $stmt1->execute();
        }
    }

    // Insert new Title Two entries
    if (!empty($_POST['functions'])) {
        $stmt2 = $conn->prepare("INSERT INTO titles_two (certificate_id, functions, levels, limitations) VALUES (?, ?, ?, ?)");
        foreach ($_POST['functions'] as $i => $function) {
            $level = $_POST['levels'][$i] ?? '';
            $limit = $_POST['limitations_two'][$i] ?? '';
            $stmt2->bind_param("isss", $certId, $function, $level, $limit);
            $stmt2->execute();
        }
    }

    // Insert new Title Three entries
    if (!empty($_POST['capacity'])) {
        $stmt3 = $conn->prepare("INSERT INTO titles_three (certificate_id, capacity, stcw_regulation, limitations) VALUES (?, ?, ?, ?)");
        foreach ($_POST['capacity'] as $i => $capacity) {
            $stcw3 = $_POST['stcw_regulation_three'][$i] ?? '';
            $limit3 = $_POST['limitations_three'][$i] ?? '';
            $stmt3->bind_param("isss", $certId, $capacity, $stcw3, $limit3);
            $stmt3->execute();
        }
    }

    echo "<script>alert('Certificate updated successfully!'); window.location='certificate_list.php';</script>";
    exit;
}
?>

<div class="container my-5">
    <form method="post" enctype="multipart/form-data">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="../certificate_generate/image/certificatelogo.png" style="width:100px">
            <h4>COOK ISLANDS SHIPS REGISTRY</h4>
            <div style="width:100px;height:100px;border:1px solid #ccc;display:flex;align-items:center;justify-content:center;">QR CODE AREA</div>
        </div>

        <!-- Certificate Type & Policy -->
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

        <!-- Title One -->
        <div id="titleOneWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title One - Training Details</h5>
            <?php if (!empty($titleOne)): ?>
                <?php foreach ($titleOne as $t): ?>
                    <div class="title-one-block border p-3 mb-3">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>Title of Training</th>
                                <th>STCW Regulation</th>
                                <th>Section of STCW Code</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="title_of_training[]" class="form-control" value="<?= htmlspecialchars($t['title_of_training']) ?>"></td>
                                <td><input type="text" name="stcw_regulation_one[]" class="form-control" value="<?= htmlspecialchars($t['stcw_regulation']) ?>"></td>
                                <td><input type="text" name="section_stcw_code[]" class="form-control" value="<?= htmlspecialchars($t['section_stcw_code']) ?>"></td>
                                <td><button type="button" class="btn btn-danger remove-title-one">X</button></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="title-one-block border p-3 mb-3">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th>Title of Training</th>
                            <th>STCW Regulation</th>
                            <th>Section of STCW Code</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="title_of_training[]" class="form-control"></td>
                            <td><input type="text" name="stcw_regulation_one[]" class="form-control"></td>
                            <td><input type="text" name="section_stcw_code[]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger remove-title-one">X</button></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <button type="button" class="btn btn-sm btn-success" id="addTitleOne">+ Add More Training</button>
        </div>

        <!-- Title Two -->
        <div id="titleTwoWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title Two - Functions</h5>
            <?php if (!empty($titleTwo)): ?>
                <?php foreach ($titleTwo as $t): ?>
                    <div class="title-two-block border p-3 mb-3">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>Functions</th>
                                <th>Levels</th>
                                <th>Limitations</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="functions[]" class="form-control" value="<?= htmlspecialchars($t['functions']) ?>"></td>
                                <td><input type="text" name="levels[]" class="form-control" value="<?= htmlspecialchars($t['levels']) ?>"></td>
                                <td><input type="text" name="limitations_two[]" class="form-control" value="<?= htmlspecialchars($t['limitations']) ?>"></td>
                                <td><button type="button" class="btn btn-danger remove-title-two">X</button></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="title-two-block border p-3 mb-3">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th>Functions</th>
                            <th>Levels</th>
                            <th>Limitations</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="functions[]" class="form-control"></td>
                            <td><input type="text" name="levels[]" class="form-control"></td>
                            <td><input type="text" name="limitations_two[]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger remove-title-two">X</button></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <button type="button" class="btn btn-sm btn-success" id="addTitleTwo">+ Add More Functions</button>
        </div>

        <!-- Title Three -->
        <div id="titleThreeWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title Three - Capacity</h5>
            <?php if (!empty($titleThree)): ?>
                <?php foreach ($titleThree as $t): ?>
                    <div class="title-three-block border p-3 mb-3">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>Capacity</th>
                                <th>STCW Regulation</th>
                                <th>Limitations</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="capacity[]" class="form-control" value="<?= htmlspecialchars($t['capacity']) ?>"></td>
                                <td><input type="text" name="stcw_regulation_three[]" class="form-control" value="<?= htmlspecialchars($t['stcw_regulation']) ?>"></td>
                                <td><input type="text" name="limitations_three[]" class="form-control" value="<?= htmlspecialchars($t['limitations']) ?>"></td>
                                <td><button type="button" class="btn btn-danger remove-title-three">X</button></td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="title-three-block border p-3 mb-3">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th>Capacity</th>
                            <th>STCW Regulation</th>
                            <th>Limitations</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="capacity[]" class="form-control"></td>
                            <td><input type="text" name="stcw_regulation_three[]" class="form-control"></td>
                            <td><input type="text" name="limitations_three[]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger remove-title-three">X</button></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <button type="button" class="btn btn-sm btn-success" id="addTitleThree">+ Add More Capacity</button>
        </div>

        <!-- Files and Holder Details -->
        <div class="mt-3 p-3 border">
            <p>Photograph & Signature of the Holder</p>
            <div class="row">
                <div class="col-md-6">
                    <label>Profile Photo</label><br>
                    <?php if($cert['profile_photo']): ?>
                        <a href="<?= $cert['profile_photo'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="profile_photo" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Signature Photo</label><br>
                    <?php if($cert['signature_photo']): ?>
                        <a href="<?= $cert['signature_photo'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="signature_photo" class="form-control">
                </div>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <tr><td class="fw-bold bg-light">Full Name</td><td><input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($cert['full_name']) ?>" required></td></tr>
            <tr><td class="fw-bold bg-light">Date of Birth</td><td><input type="date" name="date_of_birth" class="form-control" value="<?= $cert['date_of_birth'] ?>"></td></tr>
            <tr><td class="fw-bold bg-light">Certificate Number</td><td><input type="text" name="certificate_number" class="form-control" value="<?= htmlspecialchars($cert['certificate_number']) ?>" required></td></tr>
            <tr><td class="fw-bold bg-light">Nationality</td><td><input type="text" name="nationality" class="form-control" value="<?= htmlspecialchars($cert['nationality']) ?>"></td></tr>
        </table>

        <table class="table table-bordered mt-3">
            <tr class="bg-primary text-white text-center"><th colspan="2">Issuing Authority</th></tr>
            <tr><td class="fw-bold bg-light">Date of Issue</td><td><input type="date" name="date_of_issue" class="form-control" value="<?= $cert['date_of_issue'] ?>"></td></tr>
            <tr><td class="fw-bold bg-light">Date of Expiry</td><td><input type="date" name="date_of_expiry" class="form-control" value="<?= $cert['date_of_expiry'] ?>"></td></tr>
            <tr><td class="fw-bold bg-light">Place of Issue</td><td><input type="text" name="place_of_issue" class="form-control" value="<?= htmlspecialchars($cert['place_of_issue']) ?>"></td></tr>
        </table>

        <table class="table table-bordered mt-3">
            <tr class="bg-primary text-white text-center"><th colspan="2">Seal & Authorized Signature</th></tr>
            <tr>
                <td class="fw-bold bg-light">Registry Seal Image</td>
                <td>
                    <?php if($cert['registry_seal_img']): ?>
                        <a href="<?= $cert['registry_seal_img'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="registry_seal_img" class="form-control">
                </td>
            </tr>
            <tr>
                <td class="fw-bold bg-light">Authority Signature Image</td>
                <td>
                    <?php if($cert['authority_signature_img']): ?>
                        <a href="<?= $cert['authority_signature_img'] ?>" target="_blank" class="btn btn-sm btn-primary mb-2">View Current</a>
                    <?php endif; ?>
                    <input type="file" name="authority_signature_img" class="form-control">
                </td>
            </tr>
            <tr><td class="fw-bold bg-light">Title</td><td><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($cert['title']) ?>"></td></tr>
            <tr><td class="fw-bold bg-light">Name</td><td><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cert['name']) ?>"></td></tr>
        </table>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">Update Certificate</button>
            <a href="certificate_list.php" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<script>
// Dynamic Title One
document.getElementById('addTitleOne').addEventListener('click', function(){
    const wrapper = document.getElementById('titleOneWrapper');
    const block = document.querySelector('.title-one-block').cloneNode(true);
    block.querySelectorAll('input').forEach(i => i.value = '');
    wrapper.insertBefore(block, this);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-title-one')){
        e.target.closest('.title-one-block').remove();
    }
});

// Dynamic Title Two
document.getElementById('addTitleTwo').addEventListener('click', function(){
    const wrapper = document.getElementById('titleTwoWrapper');
    const block = document.querySelector('.title-two-block').cloneNode(true);
    block.querySelectorAll('input').forEach(i => i.value = '');
    wrapper.insertBefore(block, this);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-title-two')){
        e.target.closest('.title-two-block').remove();
    }
});

// Dynamic Title Three
document.getElementById('addTitleThree').addEventListener('click', function(){
    const wrapper = document.getElementById('titleThreeWrapper');
    const block = document.querySelector('.title-three-block').cloneNode(true);
    block.querySelectorAll('input').forEach(i => i.value = '');
    wrapper.insertBefore(block, this);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-title-three')){
        e.target.closest('.title-three-block').remove();
    }
});
</script>

<?php require 'footer.php'; ?>