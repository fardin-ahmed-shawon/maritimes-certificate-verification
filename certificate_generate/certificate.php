<?php
require '../dbConnection.php';

$certificate_id = $_GET['id'] ?? '';

// Fetch The Certificate Information
$condition = "Issued under the authority of the Government of the Cook Islands. THIS IS TO CERTIFY that the lawful holder of this certificate has met the requirements laid down in the International Convention on Standards of Training, Certification and Watchkeeping for Seafarers (STCW), 1978, as amended, and the standards of competency specified in the STCW Code as amended.";
$training = "SHIP SECURITY OFFICER";
$regulations = "Reg. VI/5";
$sections = "Section A-VI/5";
$full_name = "Amin Miya";
$date_of_birth = "21 Aug 1998";
$certificate_number = "C-COP-23116";
$nationality = "Bangladeshi";
$date_of_issue = "31 Jan 2024";
$date_of_expiry = "31 Jan 2029";
$place_of_issue = "Rarotonga, Cook Islands";
$img = "./image/profile.png";
$sign = "./image/sign.png";
$seal_img = "./image/seal.png";
$seal_sign = "./image/auth-sign.png";
$auth_title = "Deputy Registrar CIDR - 93";
$auth_name = "Tiare Alice Story";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .certificate-container {
            max-width: 1000px;
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
    <div class="container mx-auto">
        <!-- Header -->
        <div class="certificate-container ps-5 pt-5 pb-2 d-flex justify-content-between align-items-center">
            <img src="./image/certificatelogo.png" alt="certificatelogo.png" style="height:60px;">
            <h3 class="mt-2">COOK ISLANDS SHIPS REGISTRY</h3>
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
                    <th><?= $training ?></th>
                </tr>
                <tr>
                    <td colspan="2"><?= $condition ?></td>
                </tr>
            </table>
        </div>

        <!-- Second table -->
        <div class="mt-3">
            <table>
                <tr class="bg-color text-white">
                    <th>Title of Training</th>
                    <th>STCW Regulation</th>
                    <th>Section</th>
                </tr>
                <tr>
                    <td><?= $training ?></td>
                    <td><?= $regulations ?></td>
                    <td><?= $sections ?></td>
                </tr>
            </table>
        </div>
        <!-- Profile and sign   -->
<div class="">
    <p>Photograph & Signature of the Holder</p>
            <div class="mt-3 d-flex">

            <tr>
                <td colspan="2" class="">

                    <img src="<?= $img ?>" alt="Seal" style="height:120px;">
                </td>
            </tr>
            <tr class="">
                <td colspan="2" class=" ">
                    <img src="<?= $sign ?>" alt="Authorized Signature" style="height:60px;">
                </td>
            </tr>
        </div>
</div>
        <!-- Holder details -->
        <div class="mt-3">
            <table>
                <tr>
                    <td class="label">Full Name of the Holder of the Certificate:</td>
                    <td><?= $full_name ?></td>
                </tr>
                <tr>
                    <td class="label">Date of Birth of the Holder of the Certificate:</td>
                    <td><?= $date_of_birth ?></td>
                </tr>
                <tr>
                    <td class="label">Certificate Number:</td>
                    <td><?= $certificate_number ?></td>
                </tr>
                <tr>
                    <td class="label">Nationality:</td>
                    <td><?= $nationality ?></td>
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
                    <td><?= $date_of_issue ?></td>
                </tr>
                <tr>
                    <td class="label">Date of Expiry:</td>
                    <td><?= $date_of_expiry ?></td>
                </tr>
                <tr>
                    <td class="label">Place of Issue:</td>
                    <td><?= $place_of_issue ?></td>
                </tr>
            </table>
        </div>

        <!-- Seal & Signature in full-width table -->
        <div class="mt-3">
            <table>
                <tr>
                    <th colspan="2" class="bg-color text-white"></th>
                </tr>
                <tr>
                    <td colspan="2" class="">
                        <img src="<?= $seal_img ?>" alt="Seal" style="height:120px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="">
                        <h6 class="fw-bold border-bottom pb-1">SIGNATURE</h6>
                        <img src="<?= $seal_sign ?>" alt="Authorized Signature" style="height:60px;">
                    </td>
                </tr>
                <tr>
                    <td class="label">Title</td>
                    <td><?= $auth_title ?></td>
                </tr>
                <tr>
                    <td class="label">Name</td>
                    <td><?= $auth_name ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>