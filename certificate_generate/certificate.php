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
    body {
      background: #f9f9f9;
      font-family: 'Poppins', sans-serif;
    }
    .certificate-area {
      margin: 20px auto;
      padding: 20px;
      max-width: 1300px; /* Keep fixed width for PDF */
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
      border: 1px solid #000;
      padding: 10px;
    }
    th { text-align: center; }
    td { text-align: left; }
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
      <img style="width: 100px" src="./image/certificatelogo.png" alt="certificatelogo.png">
      <h1 class="mt-2 text-center flex-grow-1"><b>COOK ISLANDS SHIPS REGISTRY</b></h1>
      <div id="qrcode" style="height:100px;"></div>
    </div>

    <!-- Title -->
    <div class="mt-3 bg-color text-white ps-2 py-1 text-center">
      <h3 class="mb-0"><b>COOK ISLANDS CERTIFICATE OF PROFICIENCY</b></h3>
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
          <div class="my-3">
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
          <div class="my-3">
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
        <div class="my-3">
          <div style="background-color: #d9e8f7; padding: 5px; border: 1px solid #000000ff;">
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
        <img src="../admin/<?= htmlspecialchars($img) ?>" alt="Profile Photo" style="height:120px;">
        <img src="../admin/<?= htmlspecialchars($sign) ?>" alt="Signature Photo" style="height:60px;">
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
            <img src="../admin/<?= htmlspecialchars($seal_img) ?>" alt="Registry Seal" style="height:120px;">
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <h6 class="fw-bold border-bottom pb-1">SIGNATURE</h6>
            <img src="../admin/<?= htmlspecialchars($seal_sign) ?>" alt="Authorized Signature" style="height:60px;">
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
      width: 100,
      height: 100,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });
  </script>

  <!-- PDF Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  window.addEventListener("load", () => {
    const { jsPDF } = window.jspdf;
    const element = document.getElementById("certificateContent");

    html2canvas(element, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");

        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = pdf.internal.pageSize.getHeight();

        const imgWidth = pdfWidth;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        if (imgHeight <= pdfHeight) {
            pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
        } else {
            let heightLeft = imgHeight;
            let position = 0;

            while (heightLeft > 0) {
                pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                heightLeft -= pdfHeight;
                position -= pdfHeight;
                if (heightLeft > 0) pdf.addPage();
            }
        }

        pdf.save("Certificate.pdf");
    });
  });
</script>

</body>
</html>