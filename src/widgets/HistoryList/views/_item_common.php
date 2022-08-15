<?php

use yii\helpers\Html;
use app\widgets\DateTime\DateTime;

/**
 * @var string $userName
 * @var string $body
 * @var string $bodyDatetime
 * @var string $footer
 * @var string $footerDatetime
 * @var string $iconClass
 * @var string $content
 */
?>

<?php echo Html::tag('i', '', ['class' => "icon icon-circle icon-main white $iconClass"]); ?>

    <div class="bg-success ">
        <?php echo $body ?>

        <?php if (isset($bodyDatetime)): ?>
            <span>
       <?= DateTime::widget(['dateTime' => $bodyDatetime]) ?>
    </span>
        <?php endif; ?>
    </div>

<?php if ($userName): ?>
    <div class="bg-info"><?= $userName; ?></div>
<?php endif; ?>

<?php if (isset($content) && $content): ?>
    <div class="bg-info">
        <?php echo $content ?>
    </div>
<?php endif; ?>

<?php if (isset($footer) || isset($footerDatetime)): ?>
    <div class="bg-warning">
        <?php echo $footer ?? '' ?>
        <?php if (isset($footerDatetime)): ?>
            <span><?= DateTime::widget(['dateTime' => $footerDatetime]) ?></span>
        <?php endif; ?>
    </div>
<?php endif; ?>
