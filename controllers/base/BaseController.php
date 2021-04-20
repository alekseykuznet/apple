<?php

namespace app\controllers\base;

use app\helpers\DateTimeHelper;
use app\models\User;
use app\traits\FlashTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\base\Module;

class BaseController extends Controller
{
    use FlashTrait;
    
    public $layout = 'main';

    /**
     * @var null|User
     */
    public $user = null;

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
     * @param string $id
     * @param Module $module
     * @param array $config
     * @throws \Throwable
     */
    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->user = \Yii::$app->user->getIdentity() ?? null;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->view->params['pageHeaderText'] = $title;
        $this->view->title = $this->view->params['pageHeaderText'];
    }

    /**
     * @param string $label
     * @param string $url
     */
    protected function addBreadcrumb($label , $url = '')
    {
        $this->view->params['breadcrumbs'][] = ['label' => $label , 'url' => $url ];
    }

    /** @inheritdoc */
    public function beforeAction($action)
    {
        /*
        if ($this->user !== null) {

            if (!in_array($this->user->status, Partner::getActiveStatuses())) {
                return $this->redirect(['site/logout']);
            }

            $this->user->last_seen = DateTimeHelper::create(DateTimeHelper::NOW);
            $this->user->save();
            
            if ($this->user !== null && !in_array($this->user->status, Partner::getActiveStatuses())) {
                \Yii::$app->user->logout();
            }

        }
        */

        return parent::beforeAction($action);
    }
}
