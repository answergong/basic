<?php
/**
 * 接口报错操作日志
 *
 * @copyright (c) 2018 上海快猫文化传媒有限公司
 * @author        gongxiangzhu <gongxiangzhu@km.com>
 */

namespace app\common\services\logs;

use yii\helpers\ArrayHelper;

class ApiOLog extends BaseOLog
{
//    const SPECIAL_STATUS = [1 => '我最6'];

    public $operation = '接口报错:%s->%s';

    /**
     * 记录日志.
     *
     * @author   gongxiangzhu
     * @dateTime 2018/3/31 13:43
     *
     * @param  array $params
     */
    public function log($params)
    {
        $operation = $this->prepareData($params);
        if (!empty($operation)) {
            $this->writeLog($params['fiction_id'], $operation, 21);
        }
    }

    /**
     * 准备数据.
     *
     * @author   gongxiangzhu
     * @dateTime 2018/3/31 13:43
     *
     * @param  array $params
     *
     * @return mixed
     */
    public function prepareData($params)
    {
        $data = '';
        $status = ArrayHelper::merge(self::SPECIAL_STATUS, [0 => '未解决', 1 => '已解决']);
        if (key_exists('from', $params) && key_exists('to', $params)) {
            if ($params['from'] != $params['to']) {
                if (key_exists($params['from'], $status) && key_exists($params['to'], $status)) {
                    $data = sprintf($this->operation, $status[$params['from']], $status[$params['to']]);
                }
            }
        }
        return $data;
    }

}