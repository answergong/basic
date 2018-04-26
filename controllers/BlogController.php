<?php

namespace app\controllers;

use app\common\components\AccessControl;
use app\common\components\MyBehavior;
use Yii;
use app\models\Blog;
use app\models\searches\BlogSearchController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //附加行为
//            'myBehavior' => MyBehavior::class,
            'as access' => [
                'class' => AccessControl::class,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * beforeAction
     *
     * @author   gongxiangzhu
     * @dateTime 2018/4/25 19:09
     *
     *
     * @return mixed
     */
//    public function beforeAction($action)
//    {
//        $currentRequestRoute = $action->getUniqueId();
//        if (!Yii::$app->user->can($currentRequestRoute)) {
//            throw new ForbiddenHttpException('没有访问权限');
//        }
//        return true;
//    }

    /**
     * Lists all Blog models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        if (!Yii::$app->user->can('blog/index')) {
//            throw new ForbiddenHttpException('客官,您没有访问权限');
//        }
//        $myBehavior = $this->getBehavior('myBehavior');
//        $isGuest = $myBehavior->isGuest();
//        $isGuest = $this->isGuest();
//        var_dump($isGuest);
        $searchModel = new BlogSearchController();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
