<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\base\BeidemaForm */

$this->title = Yii::t('app', 'Create Beidema Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Beidema Form'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beidema-form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
