<?php

use app\models\Video;
use yii\helpers\Html;

/* @var $this yii\web\View */

?>

<?php if ($model->platform === Video::PLATFORM_YOUTUBE): ?>
    <div class="videoPlayer">
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?= Html::encode($model->code); ?>" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture;" allowfullscreen></iframe>
    </div>
<?php endif; ?>
