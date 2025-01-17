<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
    <div class="fw-bold fs-5 gray-color">
        <?= $title; ?>
    </div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<div class="pt-4 row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php $validation = \Config\Services::validation(); ?>

                <form method="POST" action="<?= base_url('employees/' . \App\Libraries\SecurityLibrary::encryptUrlId($data->id) . '/update'); ?>"
                    onSubmit="document.getElementById('submit').disabled=true;">
                    <?= csrf_field(); ?>

                    <div>
                        <div class="card-form-title">Basic</div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <input type="text" name="first_name" id="firstNameInput" class="form-control"
                                    value="<?= esc($data->firstName); ?>" placeholder="First Name" />
                                <?php if ($validation->getError('first_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('first_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-4">
                                <input type="text" name="last_name" id="lastNameInput" class="form-control"
                                    value="<?= esc($data->lastName); ?>" placeholder="Last Name" />
                                <?php if ($validation->getError('last_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('last_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <input type="email" name="email" class="form-control" id="emailInput"
                                value="<?= esc($dataContact->email); ?>" placeholder="Enter Email">
                            <?php if ($validation->getError('email')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('email'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <div class="single-file-upload">
                                <div class="drop-zone py-5 text-center" id="dropzone" data-output="div-uploaded-file"
                                    data-multiple="false" data-bs-toggle="modal" data-bs-target="#filesModal">
                                    <i class='bx bx-cloud-upload fs-1'></i>
                                    <p class="fs-6" id="fileText"></p>
                                    <?php if (isset($dataImage->fileSrc)): ?>
                                        <input type="hidden" id="fileHidden" value="<?= esc(json_encode($dataImage)); ?>">
                                    <?php endif; ?>
                                </div>
                                <div id="div-uploaded-file"></div>
                            </div>
                            <?php if ($validation->getError('file')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('file'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <input type="text" name="mobile" id="mobileInput" class="form-control"
                                    value="<?= esc($dataContact->mobile); ?>" placeholder="Enter Mobile" />
                                <?php if ($validation->getError('mobile')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('mobile'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-4">
                                <input type="text" name="telephone" id="telephoneInput" class="form-control"
                                    value="<?= esc($dataContact->telephone); ?>" placeholder="Enter Telephone" />
                                <?php if ($validation->getError('telephone')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('telephone'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <textarea name="description" id="descriptionTextarea" class="form-control"
                                placeholder="Enter Description" rows="3"><?= esc($data->description); ?></textarea>
                            <?php if ($validation->getError('description')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('description'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>



<?= $this->endSection(); ?>