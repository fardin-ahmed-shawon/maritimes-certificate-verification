<?php
require '../dbConnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch applications
$applications = [];
$sql = "SELECT * FROM applications ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $applications = $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch certificates
$certificates = [];
$sql2 = "SELECT * FROM certificates ORDER BY created_at DESC";
$result2 = $conn->query($sql2);
if ($result2 && $result2->num_rows > 0) {
    $certificates = $result2->fetch_all(MYSQLI_ASSOC);
}

// Stats
$totalApplications = count($applications);
$totalCertificates = count($certificates);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: "Poppins", sans-serif;
        }
        .dashboard-header {
            margin: 30px 0;
        }
        .card-stats {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .card-stats .card-body {
            padding: 25px;
        }
        .card-stats h2 {
            font-weight: 700;
            margin: 0;
        }
        .btn-custom {
            border-radius: 8px;
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: #0d6efd;
            color: #fff;
        }
        .section-title {
            margin-top: 40px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<?php include 'nav.php' ?>

<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center dashboard-header">
        <h1 class="fw-bold">Dashboard</h1>
        <div>
            <a href="create_certificate.php" class="btn btn-primary btn-custom me-2"><b>+ Create Certificate</b></a>
            <a href="../index.php" class="btn btn-success btn-custom"><b>+ New Application</b></a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats text-center bg-light">
                <div class="card-body">
                    <h2><?= $totalApplications ?></h2>
                    <br>
                    <p class="text-muted"><b>Total Applications</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats text-center bg-light">
                <div class="card-body">
                    <h2><?= $totalCertificates ?></h2>
                    <br>
                    <p class="text-muted"><b>Total Certificates</b></p>
                </div>
            </div>
        </div>
        <!-- You can add more stats later (like pending, expired, etc.) -->
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
                            <a href="view_application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-info text-white">Details</a>
                            <a href="edit_application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_application.php?id=<?= $app['id'] ?>" 
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this application?');">
                            Delete
                            </a>
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
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
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
                        <th>Action</th> <!-- Added -->
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
                            <a href="view_certificate.php?id=<?= $cert['id'] ?>" class="btn btn-sm btn-info text-white">Details</a>
                            <a href="edit_certificate.php?id=<?= $cert['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_certificate.php?id=<?= $cert['id'] ?>" 
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this certificate?');">
                            Delete
                            </a>
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

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>