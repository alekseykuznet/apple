<?php

namespace app\traits;

trait FlashTrait
{
    /**
     * @param $message
     */
    public function setFlashSuccess(string $message): void
    {
        \Yii::$app->session->setFlash('success', $message);
    }

    /**
     * @param $message
     */
    public function setFlashDanger(string $message): void
    {
        \Yii::$app->session->setFlash('danger', $message);
    }

    /**
     * @param string $message
     */
    public function setFlashWarning(string $message): void
    {
        \Yii::$app->session->setFlash('warning', $message);
    }

    /**
     * @param string $message
     */
    public function setFlashInfo(string $message): void
    {
        \Yii::$app->session->setFlash('info', $message);
    }
}