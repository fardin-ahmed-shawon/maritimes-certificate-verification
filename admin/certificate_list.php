<?php
$page_title = "Certificate List";
require 'header.php';

// Handle search
$search = $_GET['search'] ?? '';
$certificates = [];

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM certificates 
                            WHERE certificate_id LIKE ? 
                               OR certificate_type LIKE ? 
                               OR full_name LIKE ? 
                               OR certificate_number LIKE ?
                            ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM certificates ORDER BY created_at DESC");
}

if ($result && $result->num_rows > 0) {
    $certificates = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->

<div class="row mb-4">
    <div class="col-md-6">
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search certificates..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-dark">Search</button>
        </form>
    </div>
</div>

<?php if (!empty($certificates)): ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Certificate ID</th>
                <th>Type</th>
                <th>Full Name</th>
                <th>Number</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certificates as $cert): ?>
            <tr>
                <td><?= $cert['id'] ?></td>
                <td><?= htmlspecialchars($cert['certificate_id']) ?></td>
                <td><?= htmlspecialchars($cert['certificate_type']) ?></td>
                <td><?= htmlspecialchars($cert['full_name']) ?></td>
                <td><?= htmlspecialchars($cert['certificate_number']) ?></td>
                <td><?= $cert['date_of_issue'] ?></td>
                <td><?= $cert['date_of_expiry'] ?></td>
                <td><?= $cert['created_at'] ?></td>
                <td>
                    <a href="../certificate_generate/certificate.php?id=<?= $cert['certificate_id'] ?>" target="_blank" class="btn btn-sm btn-dark text-white"><b>Preview</b></a>
                    <a href="edit_certificate.php?id=<?= $cert['id'] ?>" class="btn btn-sm btn-warning"><b>Edit</b></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="alert alert-warning">No certificates found.</div>
<?php endif; ?>

<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>