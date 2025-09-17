<!-- fname
fmname
fsname
dbirth
dsnumber
femail
coc
cop -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cook Islands Verification Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-brand img {
      height: 50px;
    }

    .form-section {
      max-width: 900px;
      margin: 40px auto;
      background: #fff;
      border-radius: 15px;
      padding: 30px 40px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .form-section h3 {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #0078D7;
    }

    .form-section p {
      color: #555;
      font-size: 15px;
    }

    label {
      font-weight: 600;
      margin-top: 15px;
    }

    input,
    select {
      border-radius: 8px !important;
    }

    .form-control:focus {
      border-color: #0078D7;
      box-shadow: 0 0 0 0.2rem rgba(0, 120, 215, 0.25);
    }

    .btn-submit {
      background: #0078D7;
      border: none;
      padding: 12px 30px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      background: #005fa3;
      transform: translateY(-2px);
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      margin-top: 25px;
      color: #333;
      border-left: 4px solid #0078D7;
      padding-left: 10px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-light bg-primary shadow-sm">
    <div class="container d-flex justify-content-center">
      <a class="navbar-brand text-white fw-bold" href="#">
        <img src="./image/download.png" alt="logo">
      </a>
    </div>
  </nav>

  <!-- Form Section -->
  <div class="form-section">
    <h3>Application for Verification of Certificate</h3>
    <p>Use this form to verify the validity and authenticity of a Cook Islands Certificate of Competency or Proficiency.</p>

    <form action="submit_application.php" method="POST" enctype="multipart/form-data">
      <!-- Seafarer Info -->
      <div class="section-title">Seafarer Information</div>
      <div class="row">
        <div class="col-md-6">
          <label for="fname">(*) First Name</label>
          <input type="text" class="form-control" name="fname" required>
        </div>
        <div class="col-md-6">
          <label for="fmname">(*) Middle Name</label>
          <input type="text" class="form-control" name="fmname" required>
        </div>
        <div class="col-md-6">
          <label for="fsname">(*) Surname</label>
          <input type="text" class="form-control" name="fsname" required>
        </div>
        <div class="col-md-6">
          <label for="dbirth">(*) Date of Birth</label>
          <input type="date" class="form-control" name="dbirth" required>
        </div>
        <div class="col-md-6">
          <label for="dsnumber">(*) Document Serial Number</label>
          <input type="text" class="form-control" name="dsnumber" required>
        </div>
        <div class="col-md-6">
          <label for="femail">(*) Email Address</label>
          <input type="email" class="form-control" name="femail" placeholder="example@mail.com" required>
        </div>
      </div>

      <!-- Supporting Docs -->
      <div class="section-title">Supporting Documents</div>
      <div class="row">
        <div class="col-md-6">
          <label for="coc">(*) Certificate of Competency</label>
          <input type="file" class="form-control" name="coc" required>
        </div>
        <div class="col-md-6">
          <label for="cop">Certificate of Proficiency</label>
          <input type="file" class="form-control" name="cop">
        </div>
      </div>

      <!-- Submit -->
      <div class="text-center mt-4">
        <button type="submit" class="btn-submit">Submit Application</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
