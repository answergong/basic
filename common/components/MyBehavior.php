<?php
/**
 * Created by PhpStorm.
 * User: gxz
 * Date: 2018/4/25
 * Time: 19:36
 */

namespace app\common\components;

use Yii;
use yii\base\ActionFilter;

class MyBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        var_dump(111);
        return true;
    }

    public function isGuest()
    {
        return Yii::$app->user->isGuest;
    }
}