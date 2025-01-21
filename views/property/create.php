<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use app\constants\PropertyStatus;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Add Property';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Your property list.</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-create-properties']); ?>

                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'latitude') ?>
                <?= $form->field($model, 'longitude') ?>
                <?= $form->field($model, 'area') ?>
                <?= $form->field($model, 'plantation_type') ?>
                <?= $form->field($model, 'plantation_lines') ?>
                <?= $form->field($model, 'plantation_units') ?>
                <?= $form->field($model, 'plantation_unit_fails') ?>
                <?= $form->field($model, 'altitude') ?>
                <?= $form->field($model, 'declive') ?>

                <?php
                echo $form->field($model, 'plantation_status')->dropDownList(
                    array_map(fn(PropertyStatus $case) => "{$case->name}", PropertyStatus::getValuesWithNames()),
                );
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'button-create-properties']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>