<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\WIshes */

$this->title = Yii::t('app', 'Create Wishes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wishes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
