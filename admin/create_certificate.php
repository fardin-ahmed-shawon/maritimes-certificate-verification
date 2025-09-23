<?php
$page_title = "Create Certificate";
require 'header.php';
?>

<div class="container my-5">
    <form action="certificate_store.php" method="POST" enctype="multipart/form-data">
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
                    <th>CERTIFICATE TYPE:</th>
                    <td><input type="text" name="certificate_type" class="form-control" placeholder="Certificate Type"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="policy_text" class="form-control" rows="3" placeholder="Certificate Policy/Condition Text"></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Title One (Training Details) -->
        <div id="titleOneWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title One - Training Details</h5>
            <div class="title-one-block border p-3 mb-3">
                <table class="table table-bordered text-center">
                    <tr>
                        <th>Title of Training</th>
                        <th>STCW Regulation</th>
                        <th>Section of STCW Code</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="title_of_training[]" class="form-control"></td>
                        <td><input type="text" name="stcw_regulation_one[]" class="form-control"></td>
                        <td><input type="text" name="section_stcw_code[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger remove-title-one">X</button></td>
                    </tr>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-success" id="addTitleOne">+ Add More Training</button>
        </div>

        <!-- Title Two (Functions) -->
        <div id="titleTwoWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title Two - Functions</h5>
            <div class="title-two-block border p-3 mb-3">
                <table class="table table-bordered text-center">
                    <tr>
                        <th>Functions</th>
                        <th>Levels</th>
                        <th>Limitations</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="functions[]" class="form-control"></td>
                        <td><input type="text" name="levels[]" class="form-control"></td>
                        <td><input type="text" name="limitations_two[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger remove-title-two">X</button></td>
                    </tr>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-success" id="addTitleTwo">+ Add More Functions</button>
        </div>

        <!-- Title Three (Capacity) -->
        <div id="titleThreeWrapper" class="mt-3">
            <h5 class="bg-primary text-white p-2">Title Three - Capacity</h5>
            <div class="title-three-block border p-3 mb-3">
                <table class="table table-bordered text-center">
                    <tr>
                        <th>Capacity</th>
                        <th>STCW Regulation</th>
                        <th>Limitations</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="capacity[]" class="form-control"></td>
                        <td><input type="text" name="stcw_regulation_three[]" class="form-control"></td>
                        <td><input type="text" name="limitations_three[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger remove-title-three">X</button></td>
                    </tr>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-success" id="addTitleThree">+ Add More Capacity</button>
        </div>

        <!-- Photos -->
        <div class="mt-3 p-3 border">
            <p>Photograph & Signature of the Holder</p>
            <div class="row">
                <div class="col-md-6">
                    <label>Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label>Signature Photo</label>
                    <input type="file" name="signature_photo" class="form-control" accept="image/*">
                </div>
            </div>
        </div>

        <!-- Holder Details -->
        <div class="mt-3">
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold bg-light">Full Name:</td>
                    <td><input type="text" name="full_name" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Date of Birth:</td>
                    <td><input type="date" name="date_of_birth" class="form-control"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Certificate Number:</td>
                    <td><input type="text" name="certificate_number" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Nationality:</td>
                    <td><input type="text" name="nationality" class="form-control"></td>
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
                    <td class="fw-bold bg-light">Registry Seal:</td>
                    <td><input type="file" name="registry_seal_img" class="form-control" accept="image/*"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Authority Signature:</td>
                    <td><input type="file" name="authority_signature_img" class="form-control" accept="image/*"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Title:</td>
                    <td><input type="text" name="title" class="form-control"></td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Name:</td>
                    <td><input type="text" name="name" class="form-control"></td>
                </tr>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">Generate Certificate</button>
        </div>
    </form>
</div>

<script>
document.getElementById('addTitleOne').addEventListener('click', function () {
    let block = document.querySelector('.title-one-block').cloneNode(true);
    block.querySelectorAll('input').forEach(input => input.value = "");
    document.getElementById('titleOneWrapper').insertBefore(block, this);
});

document.getElementById('addTitleTwo').addEventListener('click', function () {
    let block = document.querySelector('.title-two-block').cloneNode(true);
    block.querySelectorAll('input').forEach(input => input.value = "");
    document.getElementById('titleTwoWrapper').insertBefore(block, this);
});

document.getElementById('addTitleThree').addEventListener('click', function () {
    let block = document.querySelector('.title-three-block').cloneNode(true);
    block.querySelectorAll('input').forEach(input => input.value = "");
    document.getElementById('titleThreeWrapper').insertBefore(block, this);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-title-one')) {
        e.target.closest('.title-one-block').remove();
    }
    if (e.target.classList.contains('remove-title-two')) {
        e.target.closest('.title-two-block').remove();
    }
    if (e.target.classList.contains('remove-title-three')) {
        e.target.closest('.title-three-block').remove();
    }
});
</script>

<?php require 'footer.php'; ?>