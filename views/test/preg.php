<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<form method="post" action="/test/check">
    <textarea required name="content" cols="50" rows="10"></textarea>
<!--    <input type="textarea" name="content">-->
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input type="submit" value="检测">
</form>
<!DOCTYPE html>
<html>
<body>

