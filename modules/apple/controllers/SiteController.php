<?php

namespace app\modules\apple\controllers;

use app\controllers\base\BaseController;
use app\models\forms\LoginForm;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\Apple;

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
                        'allow' => true,
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

        $apple = new Apple();

        $params = \Yii::$app->request->get();

        $provider = $apple->search($params);

        return $this->render('index', compact('provider'));
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
