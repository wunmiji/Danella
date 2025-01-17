<!-- Get in touch -->
<div class="card get-in-touch-card">
    <div class="card-body">
        <h5 data-anima class="card-title mb-4">Get in Touch</h5>
        <div class="d-flex flex-column row-gap-4">
            <div class="d-flex align-items-start column-gap-3">
                <i class='bx bx-current-location bx-sm'></i>
                <span data-anima class="fw-medium text-wrap text-break">
                    <?= $information['address']; ?>
                </span>
            </div>
            <div class="d-flex align-items-start column-gap-3">
                <i class="bx bx-phone-call bx-sm"></i>
                <div class="d-flex flex-column">
                    <?php foreach ($information['call'] as $key => $value): ?>
                        <span data-anima class="fw-medium text-wrap text-break">
                            <?= $value; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex align-items-start column-gap-3">
                <i class="bx bx-envelope bx-sm"></i>
                <div class="d-flex flex-column">
                    <?php foreach ($information['email'] as $key => $value): ?>
                        <span data-anima class="fw-medium text-wrap text-break">
                            <?= $value; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex align-items-start column-gap-3 mb-2">
                <i class="bx bx-time bx-sm"></i>
                <div class="d-flex flex-column">
                    <?php foreach ($information['working'] as $key => $value): ?>
                        <span data-anima class="fw-medium text-wrap text-break">
                            <?= $value; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>