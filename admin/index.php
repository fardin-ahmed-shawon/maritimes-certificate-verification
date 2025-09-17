<?php
$page_title = "Dashboard";
require 'header.php';
?>

<?php
    // Fetch applications
    $applications = [];
    $sql = "SELECT * FROM applications ORDER BY created_at DESC LIMIT 10";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $applications = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch certificates
    $certificates = [];
    $sql2 = "SELECT * FROM certificates ORDER BY created_at DESC LIMIT 10";
    $result2 = $conn->query($sql2);
    if ($result2 && $result2->num_rows > 0) {
        $certificates = $result2->fetch_all(MYSQLI_ASSOC);
    }

    // Stats
    $totalApplications = count($applications);
    $totalCertificates = count($certificates);
?>

<!-------------------------->
<!-----START MAIN AREA------>
<!-------------------------->

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats text-center bg-dark">
                <div class="card-body">
                    <h2 class="text-white"><?= $totalApplications ?></h2>
                    <br>
                    <p class="text-white"><b>Total Applications</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats text-center bg-dark">
                <div class="card-body">
                    <h2 class="text-white"><?= $totalCertificates ?></h2>
                    <br>
                    <p class="text-white"><b>Total Certificates</b></p>
                </div>
            </div>
        </div>
    </div><br>

    <!-- Application List -->
    <h3 class="section-title">Application List</h3>
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
        <a href="application_list.php" class="btn btn-dark px-4 py-2">See All</a>
    <?php else: ?>
        <div class="alert alert-warning mt-3">No applications found.</div>
    <?php endif; ?>


    <!-- Certificate List -->
    <br><br><h3 class="section-title">Certificate List</h3>
    <?php if (!empty($certificates)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Certificate ID</th>
                        <th>Certificate Type</th>
                        <th>Full Name</th>
                        <th>Certificate Number</th>
                        <th>Date of Issue</th>
                        <th>Date of Expiry</th>
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
        <a href="certificate_list.php" class="btn btn-dark px-4 py-2">See All</a>
    <?php else: ?>
        <div class="alert alert-warning mt-3">No certificates found.</div>
    <?php endif; ?>

<!-------------------------->
<!----- END MAIN AREA------>
<!-------------------------->

<?php
require 'footer.php';
?>