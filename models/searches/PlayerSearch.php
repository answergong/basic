<?php
/**
 * Created by PhpStorm.
 * User: gxz
 * Date: 2018/4/16
 * Time: 19:52
 */

namespace app\models\searches;


use app\models\Player;
use yii\data\ActiveDataProvider;

class PlayerSearch extends Player
{
    public function search()
    {
        $query = Player::find();
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
                'pagination' => ['defaultPageSize' => 5]
            ]
        );
        return $dataProvider;
    }
}