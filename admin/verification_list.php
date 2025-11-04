<?php
$page_title = "Verification Results List";
require 'header.php';

// Handle search
$search = $_GET['search'] ?? '';
$records = [];

if ($search) {
    $stmt = $conn->prepare("
        SELECT * FROM verification_results
        WHERE top_title LIKE ?
           OR certificate_type LIKE ?
           OR seafarer_name LIKE ?
           OR document_serial_number LIKE ?
        ORDER BY created_at DESC
    ");
    $like = "%$search%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM verification_results ORDER BY created_at DESC");
}

if ($result && $result->num_rows > 0) {
    $records = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!--------------------------->
<!------ START MAIN --------->
<!--------------------------->

<div class="row mb-4">
    <div class="col-md-6">
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search verification results..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-dark">Search</button>
        </form>
    </div>
    <div class="col-md-6 text-end">
        <a href="create_verification_result.php" class="btn btn-primary">+ Add New Verification</a>
    </div>
</div>

<?php if (!empty($records)): ?>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Certificate Type</th>
                <th>Seafarer Name</th>
                <th>Document Serial</th>
                <th>Validation Result</th>
                <th>Status</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Created At</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['certificate_type']) ?></td>
                <td><?= htmlspecialchars($row['seafarer_name']) ?></td>
                <td><?= htmlspecialchars($row['document_serial_number']) ?></td>
                <td><?= htmlspecialchars($row['validation_result']) ?></td>
                <td><?= htmlspecialchars($row['certificate_status']) ?></td>
                <td><?= htmlspecialchars($row['date_of_issue']) ?></td>
                <td><?= htmlspecialchars($row['date_of_expiry']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <a href="../verification_result/verif.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-sm btn-dark text-white"><b>Preview</b></a>
                </td>
                <td>
                    <a href="edit_verification_result.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><b>Edit</b></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="alert alert-warning">No verification results found.</div>
<?php endif; ?>

<!--------------------------->
<!------ END MAIN ----------->
<!--------------------------->

<?php require 'footer.php'; ?>