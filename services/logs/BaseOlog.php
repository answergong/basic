<?php
/**
 * Created by PhpStorm.
 * 记录日志的基类
 * User: gxz
 * Date: 2018/4/11
 * Time: 14:46
 */

namespace app\services\logs;


abstract class BaseOlog
{
    abstract public function log($params);

    abstract function prepareData($params);
    /**
     * 记录日志的具体方法
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/11 14:54
     *
     * @param  integer $id
     * @param  string  $name
     *
     * @return mixed
     */
    public  function writeLog($fictionId,$operation){
        //记录到日志表的具体操作
        //实例化日志model,为指定字段赋值,然后save()
    }


}