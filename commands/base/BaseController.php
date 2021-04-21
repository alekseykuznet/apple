<?php

namespace app\commands\base;

use yii\console\Controller;
use yii\db\Connection;

class BaseController extends Controller
{
    protected $timer = null;
    protected $lockHandle = null;

    private const START_PARAM_VALUE = 'start';

    public function init()
    {
        parent::init();
    }

    /**
     * @param string $processName
     */
    protected function lockProcess(string $processName)
    {
        $path = \Yii::getAlias("@app/runtime/lock/{$processName}.txt");
        $this->lockHandle = fopen($path, 'w');

        if (flock($this->lockHandle, LOCK_EX | LOCK_NB) === false) {
            echo "Already runninng\n";
            exit;
        }

        fwrite($this->lockHandle, 'run');
    }

    protected function unlockProcess()
    {
        flock($this->lockHandle, LOCK_UN);
        fclose($this->lockHandle);
    }

    protected function startTimer()
    {
        $this->timer = microtime(true);
    }

    protected function stopTimer()
    {
        $result = 'time:';
        $result .= sprintf('%0.3f', microtime(true) - $this->timer);
        $result .= "\n";

        echo $result;
    }
}
