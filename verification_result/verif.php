<?php 
require '../dbConnection.php';  

$verify_id = $_GET['id'] ?? '';  

// if (!$verify_id) { die("No verification ID provided."); }  

// $stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
// $stmt->bind_param("s", $certificate_id);
// $stmt->execute();
// $result = $stmt->get_result();
// if ($result->num_rows === 0) { die("Certificate not found."); }  
// $cert = $result->fetch_assoc();

 $certificate_url = $site_url.'certificate_generate/verif.php?id='. $verify_id;


// $stmt->close(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate - FUll Name</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    body {
      background: #ffffffff;
      /* font-family: 'Poppins', sans-serif; */
      font-family: Arial, Helvetica, sans-serif;
      font-size: 26px;
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
      color: #000;
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

    h2 {
      font-size: 40px;
    }
    
  </style>
</head>
<body>

  <div class="download-btn d-none">
    <button id="downloadPDF" class="btn btn-info">Download PDF</button>
  </div>

  <div id="certificateContent" class="certificate-area">
    <!-- Header -->
    <div class="certificate-container pb-2 d-flex justify-content-between align-items-center">
      <img style="width: 140px" src="./image/certificatelogo.png" alt="certificatelogo.png">
      <h1 class="mt-2 text-center flex-grow-1" style="font-size: 50px;"><b>COOK ISLANDS SHIPS REGISTRY</b></h1>
      <div id="qrcode" style="width: 140px; height:140px;"></div>
    </div><br>

    <!-- Title -->
    <div class="mt-3 bg-color text-white ps-2 py-1">
      <h2 class="mb-0 p-2 mx-4"><b>Verification result - STCW</b></h2>
    </div>

    <!-- First table -->
    <div class="mt-3">
      <table>
        <tr>
          <td class="label" colspan="2">Maritime Cook Islands has received an application for verification of a Cook Islands Certificate, Certificate of Competency and/or Certificate of Proficiency. The verification result is as follows:
          </td>
        </tr>
        <tr>
            <td class="label">Certificate Type:</td>
            <td class="bg-white">Certificate of Competency</td>
        </tr>
        <tr>
            <td class="label">Seafarer Name:</td>
            <td class="bg-white">NAYEEM MIA</td>
        </tr>
        <tr>
            <td class="label">Validation Result:</td>
            <td class="bg-white">VERIFICATION SUCCESSFUL.</td>
        </tr>
        <tr>
            <td class="label">Certificate Status:</td>
            <td class="bg-white">Current</td>
        </tr>
        <tr>
            <td class="label">Document Serial Number</td>
            <td class="bg-white">C-COC-2252 & C-COC-2253</td>
        </tr>
        <tr>
            <td class="label" style="vertical-align: top;">Notes:</td>
            <td class="bg-white">
              Date of Birth of the Holder of the Certificate: 21 Aug 1998
              <br>
              Date of Issue 31 Jan 2024
              <br>
              Date of Expiry 31 Jan 2029
              <br>
              STCW Regulations: II/1 OOW DECK & IV/2 GMDSS
              <br><br><br>
              Any questions pertaining to this verification result shall be
              <br>
              forwarded to seafarers@maritimecookislands.com
            </td>
        </tr>
      </table>
    </div>

    
    <br><br>
    <p class="mb-0" style="color: #6e6e6eff;">COOK ISLANDS CERTIFICATE OF COMPETENCY</p>
  </div>

  <!-- QR Code (same as before) -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
  const certificateURL = "<?= $certificate_url ?>";
  // generate visible QR (keeps original behavior)
  new QRCode(document.getElementById("qrcode"), {
    text: certificateURL,
    width: 140,
    height: 140,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });
</script>

<!-- html2canvas & jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  // Utility: wait until an image (img element) has finished loading
  function waitForImageLoad(img) {
    return new Promise(resolve => {
      if (!img) return resolve();
      if (img.complete && (img.naturalWidth !== 0 || img.src.indexOf('data:') === 0)) return resolve();
      img.onload = img.onerror = () => resolve();
    });
  }

  // Main PDF generator — produces consistent A4 single-page PDF regardless of viewport
  // Main PDF generator — produces consistent A4 single-page PDF with X-axis padding
  async function generateA4PdfFromElement(options = {}) {
    const {
      elementId = 'certificateContent',
      filename = 'Certificate.pdf',
      canvasScale = 2.0,
      xPadding = 10 // padding on both left and right (mm)
    } = options;

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    const pdfWidthMM = pdf.internal.pageSize.getWidth();   // 210mm
    const pdfHeightMM = pdf.internal.pageSize.getHeight(); // 297mm

    const original = document.getElementById(elementId);
    if (!original) throw new Error('Element not found: ' + elementId);

    // Clone element
    const clone = original.cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.style.position = 'fixed';
    wrapper.style.left = '-9999px';
    wrapper.style.top = '0';
    wrapper.style.background = '#fff';
    wrapper.appendChild(clone);
    document.body.appendChild(wrapper);

    // Wait for fonts & images
    const waitForImageLoad = img => new Promise(res => {
      if (!img) return res();
      if (img.complete && (img.naturalWidth !== 0 || img.src.indexOf('data:') === 0)) return res();
      img.onload = img.onerror = () => res();
    });
    const images = wrapper.querySelectorAll('img');
    const imagePromises = Array.from(images).map(waitForImageLoad);
    const fontPromise = (document.fonts && document.fonts.ready) ? document.fonts.ready : Promise.resolve();
    await Promise.all([fontPromise, ...imagePromises]);

    // Render with html2canvas
    const canvas = await html2canvas(wrapper, {
      scale: canvasScale,
      useCORS: true,
      allowTaint: false,
      windowWidth: wrapper.scrollWidth,
      windowHeight: wrapper.scrollHeight
    });
    const imgData = canvas.toDataURL('image/jpeg', 0.98);

    // Calculate scaling (keep aspect ratio)
    const maxWidthMM = pdfWidthMM - (2 * xPadding); // shrinkable width
    const imgHeightMM = (canvas.height * maxWidthMM) / canvas.width;

    let finalWidthMM, finalHeightMM;
    if (imgHeightMM > pdfHeightMM) {
      // Fit by height
      finalHeightMM = pdfHeightMM;
      finalWidthMM = (canvas.width * finalHeightMM) / canvas.height;
    } else {
      // Fit by width (with padding)
      finalWidthMM = maxWidthMM;
      finalHeightMM = imgHeightMM;
    }

    // Position (top aligned, padded X)
    const x = (pdfWidthMM - finalWidthMM) / 2;
    const y = 0;

    pdf.addImage(imgData, 'JPEG', x, y, finalWidthMM, finalHeightMM);
    pdf.save(filename);

    document.body.removeChild(wrapper);
  }

  // Hook button
  document.getElementById('downloadPDF').addEventListener('click', async () => {
    await generateA4PdfFromElement({
      elementId: 'certificateContent',
      filename: 'Certificate.pdf',
      canvasScale: 2.5,
      xPadding: 7 // adjust padding here
    });
  });


  // OPTIONAL: if you really want auto-download on page load (not recommended), uncomment:
  // window.addEventListener('load', () => document.getElementById('downloadPDF').click());

</script>



</body>
</html>