<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('./partials/sidebar/categories.php'); ?>
        <?= $this->render('./partials/sidebar/subscribe.php'); ?>
        <?= $this->render('./partials/sidebar/social.php'); ?>
    </div>
    <div class="col-md-6">
        <?= $content; ?>
    </div>
    <div class="col-md-3">
        <?= $this->render('./partials/sidebar/interesting.php'); ?>
        <?= $this->render('./partials/sidebar/useful.php'); ?>
        <?= $this->render('./partials/sidebar/friends.php'); ?>
    </div>
</div>

<?php $this->endContent(); ?>
