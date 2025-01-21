<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $provider */

use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Property and Owners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Add Co-Owner', ['/property/invite-owner'], ['class' => 'profile-link']) ?>

    <div class="row">
        <div class="col-lg-5">

            <?php
            echo GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'username',
                    'email',
                    'phone_number',
                ]
            ]);
            ?>


            <?php
            echo DetailView::widget([
                'model' => $model,
            ]);
            ?>

        </div>
    </div>
</div>