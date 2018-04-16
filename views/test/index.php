<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\widgets\LinkPager;

?>l

<table class="">
    <thead>
    <tr>
        <th width="20">
            <label class="form-checkbox js-checkbox" check-all="true">
                <i></i>
            </label>
        </th>
        <th width="30">序号</th>
        <th width='60'>ID</th>
        <th>姓名</th>
        <th>年龄</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($players as $mKey => $model): ?>
        <tr>
            <td>
                <label class="form-checkbox js-checkbox">
                    <input type="checkbox" class="js-checkbox-value" name="check[]" value="<?= $model['id'] ?>">
                    <i></i>
                </label>
            </td>
            <td><?= $mKey + 1 ?></td>
            <td><?= $model['id']; ?></td>
            <td><?= $model['name']; ?></td>
            <td><?= $model['age']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
echo LinkPager::widget(['pagination' => $pagination,]);
?>