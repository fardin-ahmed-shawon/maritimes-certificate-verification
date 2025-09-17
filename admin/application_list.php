<?php
$page_title = "Application List";
require 'header.php';

// Handle search
$search = $_GET['search'] ?? '';
$applications = [];

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM applications 
                            WHERE first_name LIKE ? 
                               OR middle_name LIKE ? 
                               OR surname LIKE ? 
                               OR email LIKE ? 
                               OR document_serial LIKE ?
                            ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("sssss", $like, $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM applications ORDER BY created_at DESC");
}

if ($result && $result->num_rows > 0) {
    $applications = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->

<div class="row mb-4">
    <div class="col-md-6">
        <form method="get" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search applications..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-dark">Search</button>
        </form>
    </div>
</div>

<?php if (!empty($applications)): ?>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Document Serial</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
            <tr>
                <td><?= $app['id'] ?></td>
                <td><?= htmlspecialchars($app['first_name']." ".$app['middle_name']." ".$app['surname']) ?></td>
                <td><?= $app['date_of_birth'] ?></td>
                <td><?= htmlspecialchars($app['email']) ?></td>
                <td><?= htmlspecialchars($app['document_serial']) ?></td>
                <td><?= $app['created_at'] ?></td>
                <td>
                    <a href="view_application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-dark text-white"><b>Details</b></a>
                    <a href="edit_application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-warning"><b>Edit</b></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="alert alert-warning">No applications found.</div>
<?php endif; ?>

<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>