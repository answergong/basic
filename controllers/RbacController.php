<?php

namespace app\controllers;

use app\libraries\Tool;
use app\models\Player;
use app\models\searches\PlayerSearch;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $auth=  Yii::$app->authManager;
        //创建权限
        $agentPermission = $auth->createPermission('代理');
        $agentPermission->description = '创建代理操作权限';
        $auth->add($agentPermission);
        //创建角色
        $adminRole = $auth->createRole('管理员');
        $adminRole->description = '创建管理员角色';
        $auth->add($adminRole);
        //将权限赋予角色
        $auth->addChild($adminRole,$agentPermission);
        //将用户赋予角色
        $userId = 1;
        $auth->assign($adminRole,$userId);
    }

    /**
     * 创建一个许可的Permission(权限,许可)
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/18 18:07
     *
     * @param  string $item
     *
     * @return mixed
     */
    public function createPermission($item)
    {
        $auth = Yii::$app->authManager;
        $createPost = $auth->createPermission($item);
        $createPost->description = '创建了 ' . $item . ' 许可';
        $auth->add($createPost);
    }

    /**
     * 创建角色
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/18 18:18
     *
     * @param  string $item
     *
     * @return mixed
     */
    public function createRole($item)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($item);
        $role->description = '创建了 ' . $item . ' 角色';
        $res = $auth->add($role);
        if ($res) {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * 给角色分配许可
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/18 18:19
     *
     * @param  array $items
     *
     * @return mixed
     */
    public function createEmpowerment($items)
    {
        $auth = Yii::$app->authManager;
        $parent = $auth->createRole($items['name']);
        $child = $auth->createPermission($items['description']);
        $res = $auth->addChild($parent, $child);
        if ($res) {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * 给角色分配用户
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/18 19:03
     *
     * @param  array $item
     *
     * @return mixed
     */
    public function assign($item)
    {
        $auth = Yii::$app->authManager;
        $reader = $auth->createRole($item['name']);
        $res = $auth->assign($reader, $item['description']);
        if ($res) {
            return 1;
        } else {
            return 2;
        }
    }
}
