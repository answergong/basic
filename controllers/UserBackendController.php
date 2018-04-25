<?php
/**
 * 后台用户表的操作控制器
 *
 * @copyright (c) 2018 上海快猫文化传媒有限公司
 * @author        gongxiangzhu <gongxiangzhu@km.com>
 */

namespace app\controllers;


use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserBackendController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                        'actions' => [ 'view', 'create', 'update', 'delete', 'signup'],
                        // 设置actions的操作是允许访问还是拒绝访问
                        'allow' => true,
                        // @ 当前规则针对认证过的用户; ? 所有方可均可访问
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        // 自定义一个规则，返回true表示满足该规则，可以访问，false表示不满足规则，也就不可以访问actions里面的操作啦
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->id == 1 ? true : false;
                        },
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * 首页方法
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/24 14:22
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 用户注册
     *
     * @author
     * @dateTime 2018/4/24 14:22
     *
     * @return mixed
     */
    public function actionSignup()
    {
        // 实例化一个表单模型，这个表单模型我们还没有创建，等一下后面再创建
        $model = new SignupForm();

        // 下面这一段if是我们刚刚分析的第二个小问题的实现，下面让我具体的给你描述一下这几个方法的含义吧
        // $model->load() 方法，实质是把post过来的数据赋值给model的属性
        // $model->signup() 方法, 是我们要实现的具体的添加用户操作
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            // 添加完用户之后，我们跳回到index操作即列表页
            return $this->redirect(['index']);
        }

        // 下面这一段是我们刚刚分析的第一个小问题的实现
        // 渲染添加新用户的表单
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

}
