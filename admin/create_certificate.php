<?php
$page_title = "Create Certificate";
require 'header.php';
?>

<div class="container my-5">

    <form action="certificate_store.php" method="POST" enctype="multipart/form-data">
        <!-- Header Preview -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="../certificate_generate/image/certificatelogo.png" alt="Logo" style="width:100px">
            <h4>COOK ISLANDS SHIPS REGISTRY</h4>
            <div style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100px; height: 100px; border: 1px solid #ccc">QR CODE AREA</div>
        </div>

        <!-- Certificate Type & Condition -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <th>CERTIFICATE TYPE:</th>
                    <td><input type="text" name="certificate_type" class="form-control" placeholder="Certificate Type" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="policy_text" class="form-control" rows="3" placeholder="Certificate Policy/Condition Text"></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Training Details -->
        <div class="mt-3">
            <table class="table table-bordered text-center bg-primary text-white">
                <tr>
                    <th>Title of Training</th>
                    <th>STCW Regulation</th>
                    <th>Section of STCW Code</th>
                </tr>
                <tr>
                    <td><input type="text" name="title_of_training" class="form-control" placeholder="Training Title"></td>
                    <td><input type="text" name="stcw_regulation" class="form-control" placeholder="STCW Regulation"></td>
                    <td><input type="text" name="section_stcw_code" class="form-control" placeholder="Section"></td>
                </tr>
            </table>
        </div>

        <!-- Profile Photo & Signature -->
        <div class="mt-3 p-3 border">
            <p>Photograph & Signature of the Holder</p>
            <div class="row">
                <div class="col-md-6">
                    <label>Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-6">
                    <label>Signature Photo</label>
                    <input type="file" name="signature_photo" class="form-control" accept="image/*" required>
                </div>
            </div>
        </div>

        <!-- Holder Details -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold bg-light">Full Name of the Holder:</td>
                    <td><input type="text" name="full_name" class="form-control" placeholder="Full Name" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Birth:</td>
                    <td><input type="date" name="date_of_birth" class="form-control"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Certificate Number:</td>
                    <td><input type="text" name="certificate_number" class="form-control" placeholder="Unique Certificate Number" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Nationality:</td>
                    <td><input type="text" name="nationality" class="form-control" placeholder="Nationality"></td>
                </tr>
            </table>
        </div>

        <!-- Issuing Authority -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr class="bg-primary text-white text-center">
                    <th colspan="2">Issuing Authority</th>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Issue:</td>
                    <td><input type="date" name="date_of_issue" class="form-control"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Expiry:</td>
                    <td><input type="date" name="date_of_expiry" class="form-control"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Place of Issue:</td>
                    <td><input type="text" name="place_of_issue" class="form-control"></td>
                </tr>
            </table>
        </div>

        <!-- Seal & Signature -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr class="bg-primary text-white text-center">
                    <th colspan="2">Seal & Authorized Signature</th>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Registry Seal Image:</td>
                    <td><input type="file" name="registry_seal_img" class="form-control" accept="image/*"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Authority Signature Image:</td>
                    <td><input type="file" name="authority_signature_img" class="form-control" accept="image/*"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Title:</td>
                    <td><input type="text" name="title" class="form-control" placeholder="Authority Title"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Name:</td>
                    <td><input type="text" name="name" class="form-control" placeholder="Authority Name"></td>
                </tr>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">Generate Certificate</button>
        </div>
    </form>
</div>

<?php
require 'footer.php';
?>