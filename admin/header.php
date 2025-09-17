<?php
require '../dbConnection.php';
// If not logged in 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maritimes Admin</title>
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



        body {
        background: #f4f6f9;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
        background: #2c2c74;
        }
        .navbar-brand img {
        height: 50px;
        }
        .details-section {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        border-radius: 15px;
        padding: 30px 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        .details-section h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #0078D7;
        }
        .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-top: 25px;
        color: #333;
        border-left: 4px solid #0078D7;
        padding-left: 10px;
        }
        .info-item {
        margin-bottom: 15px;
        }
        .info-item label {
        font-weight: 600;
        color: #444;
        }
        .btn-back {
        background: #0078D7;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        }
        .btn-back:hover {
        background: #005fa3;
        }
    </style>
</head>
<body>

<?php include 'nav.php' ?>

<div class="container">
    <!-- Header -->
    <div class="row dashboard-header">
        <h1 class="col-md-6 fw-bold"><?= $page_title ?></h1>
        <div class="col-md-6">
            <a href="create_certificate.php" class="m-2 btn btn-primary btn-custom me-2"><b>+ Create Certificate</b></a>
            <a href="../index.php" class="m-2 btn btn-success btn-custom"><b>+ New Application</b></a>
            <a href="index.php" class="m-2 btn btn-dark btn-custom"><b>Dashboard</b></a>
            <a href="logout.php" class="m-2 btn btn-danger btn-custom"><b>Logout</b></a>
        </div>
    </div>

