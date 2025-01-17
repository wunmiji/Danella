<div class="card">
    <div class="card-header card-header-title">Basic</div>
    <div class="card-body">
        <table class="table">
            <tbody>
                <?php foreach ($rows as $key => $value): ?>
                    <tr>
                        <td>
                            <?= $key; ?>
                        </td>
                        <td>
                            <?= $value; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>