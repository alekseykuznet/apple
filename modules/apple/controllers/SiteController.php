<?php

namespace app\modules\apple\controllers;

use app\controllers\base\BaseController;
use app\helpers\Password;
use app\models\forms\LoginForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\Apple;
use app\models\forms\AppleForm;

class SiteController extends BaseController
{
    public $layout = 'guest';

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'login',
                            'validate-login'
                        ],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'eat',
                            'drop',
                            'logout',
                        ],
                        'roles' => ['@'],
                        'matchCallback' => function(){
                            return $this->user->status == User::STATUS_ACTIVE;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $this->setTitle(\Yii::$app->name);

        $model = new Apple();
        $appleForm = new AppleForm;

        if ($appleForm->load(\Yii::$app->request->post()) && $appleForm->generate()) {

            return $this->redirect(['index']);
        }

        $params = \Yii::$app->request->get();

        $provider = $model->search($params);

        return $this->render('index', compact('provider', 'appleForm'));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/']);
        }

        $loginForm = new LoginForm();

        if ($loginForm->load(\Yii::$app->request->post()) && $loginForm->login()) {

            if (!\Yii::$app->user->isGuest) {
                return $this->redirect(['/']);
            }
        }

        return $this->redirect(['/']);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        \Yii::$app->user->logout();

        return $this->redirect(['/']);
    }

    public function actionEat($id)
    {
        $model = Apple::findOne(['id' => $id]);

        if ($model === null) {
            $this->redirect(['index']);
        }

        if ($model->load(\Yii::$app->request->post()) && $model->eat()) {
            return $this->redirect(['index']);
        }

        return $this->render('eat', compact('model'));
    }

    public function actionDrop($id)
    {
        $model = Apple::findOne(['id' => $id]);

        if ($model === null) {
            $this->redirect(['index']);
        }

        $model->fallToGround();

        $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = Apple::findOne(['id' => $id]);
        if ($model !== null) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionValidateLogin()
    {
        if (\Yii::$app->user->isGuest) {
            $loginForm = new LoginForm();

            if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
                return $this->performAjaxValidation($loginForm);
            }
        }

        return $this->redirect(['/']);
    }

    protected function performAjaxValidation($model): array
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        return [];
    }

    /**
     * @return string
     */
    public function actionError(): string
    {
        $this->setTitle(\Yii::t('app', '404 — not found'));
        $message = \Yii::t('app', 'This page does not exist.');

        return $this->render('error', compact('message'));
    }
}
