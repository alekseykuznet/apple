<?php

namespace app\commands;

use app\commands\base\BaseController;
use app\models\Apple;
use Carbon\Carbon;

class AppleController extends BaseController
{
    const COUNT_HOURS_DROP = 5;

    public function init()
    {
        parent::init();
    }

    public function actionApple()
    {
        $this->lockProcess('cron-apple');

        $carbonNow = Carbon::now();
        $timeEnd = $carbonNow->toDateTimeString();
        $timeStart = $carbonNow->addSeconds()
            ->subHour(self::COUNT_HOURS_DROP)
            ->toDateTimeString();

        $apples = Apple::find()
            ->andWhere(['status' => Apple::STATUS_DROP])
            ->where([
                'AND',
                ['BETWEEN', 'drop_date', $timeStart, $timeEnd]
            ])
            ->all();

        foreach ($apples as $apple) {
            $apple->status = Apple::STATUS_ROTTEN;
            $apple->save();
        }

        $this->unlockProcess();
    }

}
