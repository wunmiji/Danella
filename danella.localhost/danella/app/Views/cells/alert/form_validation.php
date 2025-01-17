<?php if ($validation->getError($inputName)): ?>
    <span class="text-danger text-sm">
        <?= $error = $validation->getError($inputName); ?>
    </span>
<?php endif; ?>