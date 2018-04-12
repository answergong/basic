<?php

namespace app\controllers;

use app\libraries\Tool;
use app\models\Player;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class TestController extends Controller
{
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
        $model = new Player();
        return $this->render('gxz',['model' => $model]);
//        return $this->render('index', ['model' => $model]);
    }
    public function actionCheck(){
        $request = Yii::$app->request;
        $content = $request->post('content');
        $res = Tool::checkFilter($content);
        if ($res){
            echo '通过验证';
        }else{
            echo '没有通过验证';
            echo '没有通过验证';
            echo '没有通过验证--release';
            var_dump($content);
        }
    }

}
