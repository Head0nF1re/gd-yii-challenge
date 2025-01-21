<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $provider */

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Your property list.</p>

    <?= Html::a('Add', ['/property/create'], ['class' => 'profile-link']) ?>

    <div class="row">
        <div class="col-lg-5">

            <?php 
            echo GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'name',
                    'latitude',
                    'longitude',
                    'area',
                    'plantation_type',
                    'plantation_units',
                    'plantation_lines',
                    'plantation_unit_fails',
                    'plantation_status',
                    'altitude',
                    'declive',
                    [
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('View', [Yii::$app->controller->id . '/view', 'id' => $data->id]);
                        }
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>