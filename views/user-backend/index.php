<?php
/* @var $this yii\web\View */

use app\models\UserBackend;
use yii\helpers\Html;

?>
<h1>user-backend/index</h1>

<p>
    <?= Html::a('添加新用户', ['signup'], ['class' => 'btn btn-success']) ?>
    <?= UserBackend::findIdentity(Yii::$app->user->id)['username']; ?>
</p>
