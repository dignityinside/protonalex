<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?= $content; ?>
        </div>
        <div class="col-md-2"></div>
    </div>

<?php $this->endContent(); ?>
