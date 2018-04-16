<?php
/**
 * Created by PhpStorm.
 * User: gxz
 * Date: 2018/4/11
 * Time: 14:56
 */

namespace app\common\services\logs;


use app\libraries\Tool;
use ReflectionClass;
use ReflectionException;

class Olog
{
    /**
     * 实例化的类
     *
     * @var String $name
     */
    private $context;

    /**
     * 获得类名的方法
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/12 12:00
     *
     * @param  string $contextName
     *
     * @return mixed
     */
    public function getContext($contextName)
    {
        $context = $this->getClass($contextName);
        try {
            $class = new ReflectionClass($context);
            $this->context = $class->newInstance();
        } catch (ReflectionException $e) {
            $this->context = '';
        }
    }

    private function getClass($contextName)
    {
        $context = '';
        $reflectionClass = [
            'tool' => ApiOLog::class,
        ];
        isset($reflectionClass[$contextName]) && $context = $reflectionClass[$contextName];
        return $context;
    }
}