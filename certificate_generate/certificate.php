<?php
require '../dbConnection.php';

$certificate_id = $_GET['id'] ?? '';

if (!$certificate_id) {
    die("No certificate ID provided.");
}

// Fetch certificate data from the database
$stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
$stmt->bind_param("s", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Certificate not found.");
}

$cert = $result->fetch_assoc();

// Assign variables
$condition = $cert['policy_text'];
$training = $cert['title_of_training'];
$regulations = $cert['stcw_regulation'];
$sections = $cert['section_stcw_code'];
$full_name = $cert['full_name'];
$date_of_birth = $cert['date_of_birth'] ? date("d M Y", strtotime($cert['date_of_birth'])) : '';
$certificate_number = $cert['certificate_number'];
$nationality = $cert['nationality'];
$date_of_issue = $cert['date_of_issue'] ? date("d M Y", strtotime($cert['date_of_issue'])) : '';
$date_of_expiry = $cert['date_of_expiry'] ? date("d M Y", strtotime($cert['date_of_expiry'])) : '';
$place_of_issue = $cert['place_of_issue'];
$img = $cert['profile_photo'];
$sign = $cert['signature_photo'];
$seal_img = $cert['registry_seal_img'];
$seal_sign = $cert['authority_signature_img'];
$auth_title = $cert['title'];
$auth_name = $cert['name'];

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - <?= htmlspecialchars($full_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .certificate-area {
            margin: 20px;
            padding: 0 23px;
            border: 1px solid #ccc;
        }

        .certificate-container {
            margin: 0 auto;
        }

        .bg-color {
            background-color: #0078D7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
        }

        th {
            text-align: center;
        }

        td {
            text-align: left;
        }

        .label {
            background-color: #d9e8f7;
            font-weight: bold;
            width: 40%;
        }
    </style>
</head>

<body>
    <div class="container mx-auto certificate-area">
        <!-- Header -->
        <div class="certificate-container pt-5 pb-2 d-flex justify-content-between align-items-center">
            <img style="width: 100px" src="./image/certificatelogo.png" alt="certificatelogo.png">
            <h1 class="mt-2">COOK ISLANDS SHIPS REGISTRY</h1>
            <img src="./image/qrcode.png" alt="QR code" style="height:60px;">
        </div>

        <!-- Title -->
        <div class="mt-5 bg-color text-white ps-2 py-1 text-center">
            <h3 class="mb-0">COOK ISLANDS CERTIFICATE OF PROFICIENCY</h3>
        </div>

        <!-- First table -->
        <div class="mt-3">
            <table>
                <tr>
                    <th>CERTIFICATE TYPE:</th>
                    <th><?= htmlspecialchars($training) ?></th>
                </tr>
                <tr>
                    <td colspan="2"><?= htmlspecialchars($condition) ?></td>
                </tr>
            </table>
        </div>

        <!-- Second table -->
        <div class="mt-3">
            <table>
                <tr class="bg-color text-white">
                    <th>Title of Training</th>
                    <th>STCW Regulation</th>
                    <th>Section of STCW Code</th>
                </tr>
                <tr>
                    <td><?= htmlspecialchars($training) ?></td>
                    <td><?= htmlspecialchars($regulations) ?></td>
                    <td><?= htmlspecialchars($sections) ?></td>
                </tr>
            </table>
        </div>

        <!-- Profile and sign -->
        <div style="border: 1px solid #ccc; padding: 12px">
            <p>Photograph & Signature of the Holder</p>
            <div class="mt-3 d-flex gap-3">
                <img src="../admin<?= htmlspecialchars($img) ?>" alt="Profile Photo" style="height:120px;">
                <img src="../admin<?= htmlspecialchars($sign) ?>" alt="Signature Photo" style="height:60px;">
            </div>
        </div>

        <!-- Holder details -->
        <div class="mt-3">
            <table>
                <tr>
                    <td class="label">Full Name of the Holder:</td>
                    <td><?= htmlspecialchars($full_name) ?></td>
                </tr>
                <tr>
                    <td class="label">Date of Birth:</td>
                    <td><?= htmlspecialchars($date_of_birth) ?></td>
                </tr>
                <tr>
                    <td class="label">Certificate Number:</td>
                    <td><?= htmlspecialchars($certificate_number) ?></td>
                </tr>
                <tr>
                    <td class="label">Nationality:</td>
                    <td><?= htmlspecialchars($nationality) ?></td>
                </tr>
            </table>
        </div>

        <!-- Issuing authority -->
        <div class="mt-3">
            <table>
                <tr>
                    <th colspan="2" class="bg-color text-white">Issuing Authority</th>
                </tr>
                <tr>
                    <td class="label">Date of Issue:</td>
                    <td><?= htmlspecialchars($date_of_issue) ?></td>
                </tr>
                <tr>
                    <td class="label">Date of Expiry:</td>
                    <td><?= htmlspecialchars($date_of_expiry) ?></td>
                </tr>
                <tr>
                    <td class="label">Place of Issue:</td>
                    <td><?= htmlspecialchars($place_of_issue) ?></td>
                </tr>
            </table>
        </div>

        <!-- Seal & Signature -->
        <div class="mt-3">
            <table>
                <tr>
                    <th colspan="2" class="bg-color text-white"></th>
                </tr>
                <tr>
                    <td colspan="2">
                        <img src="../admin<?= htmlspecialchars($seal_img) ?>" alt="Registry Seal" style="height:120px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h6 class="fw-bold border-bottom pb-1">SIGNATURE</h6>
                        <img src="../admin<?= htmlspecialchars($seal_sign) ?>" alt="Authorized Signature" style="height:60px;">
                    </td>
                </tr>
                <tr>
                    <td class="label">Title</td>
                    <td><?= htmlspecialchars($auth_title) ?></td>
                </tr>
                <tr>
                    <td class="label">Name</td>
                    <td><?= htmlspecialchars($auth_name) ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>