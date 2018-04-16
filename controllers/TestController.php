<?php

namespace app\controllers;

use app\libraries\Tool;
use app\models\Player;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class TestController extends Controller
{
    /**
     * 分页每一页显示的条数
     *
     * @var String $limit
     */
    public $limit = 5;
    /**
     * 数据数组
     *
     * @var array $data
     */
    public $data = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $page = Yii::$app->request->get('page');
        $offset =
        $query = Player::find();
        $count = $query->count();
        //获得分页数据
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit]);
        $this->data['pagination'] = $pagination;
        //获得列表数据
        $this->data['players'] = $query->asArray()->all();
        return $this->render('index', $this->data);
    }

    public function actionCheck1()
    {
        return $this->render('preg');
    }

    public function actionCheck()
    {
        $request = Yii::$app->request;
        $content = $request->post('content');
        $res = Tool::checkFilter($content);
        if ($res) {
            echo '通过验证';
        } else {
            echo '没有通过验证';
            echo '没有通过验证';
            echo '没有通过验证--release';
            var_dump($content);
        }
    }

}
