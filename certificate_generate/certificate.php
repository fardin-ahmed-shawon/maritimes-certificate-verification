<?php 
require '../dbConnection.php';  
$certificate_id = $_GET['id'] ?? '';  

if (!$certificate_id) { die("No certificate ID provided."); }  

$stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
$stmt->bind_param("s", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) { die("Certificate not found."); }  

$cert = $result->fetch_assoc();

// Assign variables
$condition = $cert['policy_text'];

$type = $cert['certificate_type'] ?? '';

// $training = $cert['title_of_training'];
// $regulations = $cert['stcw_regulation'];
// $sections = $cert['section_stcw_code'] ;

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

$certificate_url = $site_url.'certificate_generate/certificate.php?id='. $certificate_id;

// Fetch multiple title one if exists
$stmt = $conn->prepare("SELECT * FROM titles_one WHERE certificate_id = ?");
$stmt->bind_param("i", $cert['id']);
$stmt->execute();
$title_one_result = $stmt->get_result();
$total_title_one = $title_one_result->num_rows;
// END


// Fetch multiple title two if exists
$stmt = $conn->prepare("SELECT * FROM titles_two WHERE certificate_id = ?");
$stmt->bind_param("i", $cert['id']);
$stmt->execute();
$title_two_result = $stmt->get_result();
$total_title_two = $title_two_result->num_rows;
// END


// Fetch multiple title three if exists
$stmt = $conn->prepare("SELECT * FROM titles_three WHERE certificate_id = ?");
$stmt->bind_param("i", $cert['id']);
$stmt->execute();
$title_three_result = $stmt->get_result();
$total_title_three = $title_three_result->num_rows;
// END


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

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    body {
      background: #ffffffff;
      font-family: 'Poppins', sans-serif;
    }
    .certificate-area {
      margin: 20px auto;
      padding: 20px;
      max-width: 1400px; /* Keep fixed width for PDF */
    }
    .bg-color {
      background-color: #5794da;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      /* margin-bottom: 20px; */
    }
    th, td {
      border: 1px solid #aaaaaa;
      padding: 5px 10px;
    }


    .f-t table tr:nth-child(odd),
    .s-t table tr:nth-child(odd),
    .t-t table tr:nth-child(odd) {
      background-color: #d9e8f7 !important;
    }

    table th {
      background-color: #5794da;

    }
    

    .label {
      background-color: #d9e8f7;
      /* font-weight: bold; */
      width: 40%;
    }
    .download-btn {
      margin: 20px auto;
      display: flex;
      justify-content: center;
    }
    
  </style>
</head>
<body>
  <!-- <div class="download-btn">
    <button id="downloadPDF" class="btn btn-info">Download PDF</button>
  </div> -->

  <div id="certificateContent" class="certificate-area">
    <!-- Header -->
    <div class="certificate-container pb-2 d-flex justify-content-between align-items-center">
      <img style="width: 140px" src="./image/certificatelogo.png" alt="certificatelogo.png">
      <h1 class="mt-2 text-center flex-grow-1" style="font-size: 50px;"><b>COOK ISLANDS SHIPS REGISTRY</b></h1>
      <div id="qrcode" style="width: 140px; height:140px;"></div>
    </div><br>

    <!-- Title -->
    <div class="mt-3 bg-color text-white ps-2 py-1">
      <h3 class="mb-0 p-2"><b>COOK ISLANDS CERTIFICATE OF PROFICIENCY</b></h3>
    </div>

    <!-- First table -->
    <div class="mt-3">
      <table>
        <?php
          if ($type != '') {
              echo '
              <tr>
                <th class="label">CERTIFICATE TYPE:</th>
                <th>'.$type.'</th>
              </tr>
              ';
          }
        ?>
        <tr>
          <td class="label" colspan="2"><?= htmlspecialchars($condition) ?></td>
        </tr>
      </table>
    </div>

    <!-- Title One table -->
    <?php
      if ($total_title_one > 0) {
        ?>
          <div class="my-3 f-t">
            <table>
              <tr class="bg-color text-white">
                <th>Title of Training</th>
                <th>STCW Regulation</th>
                <th>Section of STCW Code</th>
              </tr>
              <?php
                while ($row = $title_one_result->fetch_assoc()) {
                    $training = $row['title_of_training'];
                    $regulations = $row['stcw_regulation'];
                    $sections = $row['section_stcw_code'];

                    echo "<tr>
                            <td>" . htmlspecialchars($training) . "</td>
                            <td>" . htmlspecialchars($regulations) . "</td>
                            <td>" . htmlspecialchars($sections) . "</td>
                          </tr>";
                }
              ?>
            </table>
          </div>
        <?php
      }
    ?>

    <!-- Title Two table -->
    <?php
      if ($total_title_two > 0) {
        ?>
          <div class="my-3 s-t">
            <table>
              <tr class="bg-color text-white">
                <th>Function</th>
                <th>Level</th>
                <th>Limitations applying (if any)</th>
              </tr>
              <?php
                while ($row = $title_two_result->fetch_assoc()) {
                    $functions = $row['functions'];
                    $levels = $row['levels'];
                    $limitations = $row['limitations'];

                    echo "<tr>
                            <td>" . htmlspecialchars($functions) . "</td>
                            <td>" . htmlspecialchars($levels) . "</td>
                            <td>" . htmlspecialchars($limitations) . "</td>
                          </tr>";
                }
              ?>
            </table>
          </div>
        <?php
      }
    ?>

    <!-- Title Three table -->
    <?php
      if ($total_title_three > 0) {
        ?>
        <div class="my-3 t-t">
          <div style="background-color: #d9e8f7; padding: 5px; border: 1px solid #aaaaaa;">
            The lawful holder of this certificate may serve in the following capacity or capacities specified in the applicable safe manning requirements of the Administration:
          </div>
        </div>
          <div class="my-3">
            <table>
              <tr class="bg-color text-white">
                <th>Capacity</th>
                <th>STCW Regulation</th>
                <th>Limitations applying (if any)</th>
              </tr>
              <?php
                while ($row = $title_three_result->fetch_assoc()) {
                    $capacity = $row['capacity'];
                    $stcw_regulation = $row['stcw_regulation'];
                    $limitations = $row['limitations'];

                    echo "<tr>
                            <td>" . htmlspecialchars($capacity) . "</td>
                            <td>" . htmlspecialchars($stcw_regulation) . "</td>
                            <td>" . htmlspecialchars($limitations) . "</td>
                          </tr>";
                }
              ?>
            </table>
          </div>
        <?php
      }
    ?>

    <!-- Profile and sign -->
    <div style="border: 1px solid #ccc; padding: 12px">
      <p>Photograph & Signature of the Holder</p>
      <div class="mt-3 d-flex gap-3">
        <img src="../admin/<?= htmlspecialchars($img) ?>" alt="Profile Photo" style="width: 200px;">
        <img src="../admin/<?= htmlspecialchars($sign) ?>" alt="Signature Photo" style="height: 60px;">
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
            <img src="../admin/<?= htmlspecialchars($seal_img) ?>" alt="Registry Seal" style="height:170px;">
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <h6 class="fw-bold border-bottom pb-1">SIGNATURE</h6>
            <img src="../admin/<?= htmlspecialchars($seal_sign) ?>" alt="Authorized Signature" style="height:110px;">
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
    <br>
    <p class="mb-0" style="color: #6e6e6eff;">COOK ISLANDS CERTIFICATE OF COMPETENCY <?= htmlspecialchars($certificate_number) ?>-<?= htmlspecialchars($full_name) ?></p>
  </div>

  <!-- QR Code -->
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
  <script>
    const certificateURL = "<?= $certificate_url ?>";
    new QRCode(document.getElementById("qrcode"), {
      text: certificateURL,
      width: 140,
      height: 140,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });
  </script>

  <!-- PDF Export with compressed images -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    window.addEventListener("load", () => {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById("certificateContent");

        html2canvas(element, { scale: 3.5 }).then(canvas => {
            const imgData = canvas.toDataURL("image/jpeg", 1);

            const pdf = new jsPDF("p", "mm", "a4");
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            const padding = 6; // 10mm padding on all sides

            const imgWidth = pdfWidth - 2 * padding;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            if (imgHeight <= pdfHeight - 2 * padding) {
                pdf.addImage(imgData, "JPEG", padding, padding, imgWidth, imgHeight);
            } else {
                let heightLeft = imgHeight;
                let position = padding;

                while (heightLeft > 0) {
                    pdf.addImage(imgData, "JPEG", padding, position, imgWidth, imgHeight);
                    heightLeft -= (pdfHeight - 2 * padding);
                    position -= (pdfHeight - 2 * padding);
                    if (heightLeft > 0) pdf.addPage();
                }
            }

            pdf.save("Certificate.pdf");
        });
    });
  </script>


</body>
</html>