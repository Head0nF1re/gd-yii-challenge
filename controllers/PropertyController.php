<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\properties\CreatePropertyForm;
use app\models\properties\InviteOwnerForm;
use app\models\Property;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class PropertyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // Guests cannot use this controller
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays table of @see app\models\Property
     *
     * @return string
     */
    public function actionIndex()
    {
        $userPropertiesQuery = Property::find()
            ->select('properties.*')
            ->innerJoin('user_property', 'user_property.property_id = properties.id');

        $provider = new ActiveDataProvider([
            'query' => $userPropertiesQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }

    /**
     * Displays a specific @see app\models\Property
     *
     * @return string
     */
    public function actionView(int $id)
    {
        // ToDo: add RBAC

        /** @var Property|null $property */

        $property = Property::find()
        ->innerJoin('user_property', 'user_property.property_id = properties.id')
        ->where(['user_property.user_id' => Yii::$app->user->id])
        ->andWhere(['properties.id' => $id])
        ->one();

        if ($property == null) {
            throw new NotFoundHttpException('Invalid Request');
        }

        $provider = new ActiveDataProvider([
            'query' => $property->getUsers()->select(['username', 'email', 'phone_number']),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('view', [
            'provider' => $provider,
            'model' => $property,
        ]);
    }

    /**
     * Create a new @see app\models\Property
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new CreatePropertyForm();

        if ($model->load(Yii::$app->request->post()) && $model->createProperty()) {
            return $this->redirect(Url::toRoute('property/index'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Create a new @see app\models\Property
     *
     * @return Response|string
     */
    public function actionInviteOwner()
    {
        $model = new InviteOwnerForm();

        // ToDo: Send invitation by email with a link that the app can verify it's integrity
        if ($model->load(Yii::$app->request->post()) && $model->inviteOwner()) {
        }

        return $this->render('invite', [
            'model' => $model,
        ]);
    }

}
