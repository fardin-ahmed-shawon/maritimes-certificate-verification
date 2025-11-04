<?php
$page_title = "Create Verification Result";
require 'header.php';
?>

<div class="container my-5">
    <form action="verification_store.php" method="POST" enctype="multipart/form-data">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="../certificate_generate/image/certificatelogo.png" alt="Logo" style="width:100px">
            <h4>COOK ISLANDS SHIPS REGISTRY</h4>
            <div style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100px; height: 100px; border: 1px solid #ccc">QR CODE AREA</div>
        </div>

        <!-- Certificate Type & Policy -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <th>TOP TITLE:</th>
                    <td><input type="text" name="top_title" class="form-control" placeholder="Enter Top Title"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="policy_text" class="form-control" rows="3" placeholder="Certificate Policy/Condition Text"></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Holder Details -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold bg-light">Certificate Type:</td>
                    <td><input type="text" name="certificate_type" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Seafarer Name:</td>
                    <td><input type="text" name="seafarer_name" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Validation Result:</td>
                    <td><input type="text" name="validation_result" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Certificate Status:</td>
                    <td><input type="text" name="certificate_status" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Document Serial Number:</td>
                    <td><input type="text" name="document_serial_number" class="form-control" required></td>
                </tr>

                <tr>
                    <td class="fw-bold bg-light">Date of Birth:</td>
                    <td><input type="date" name="date_of_birth" class="form-control"></td>
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
                    <td class="fw-bold bg-light">STCW Regulations:</td>
                    <td><input type="text" name="stcw_regulations" class="form-control"></td>
                </tr>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">Generate Verification Result</button>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>