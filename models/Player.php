<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "player".
 *
 * @property int $id
 * @property string $name
 * @property int $age
 * @property int $created_at
 * @property int $uodated_at
 */
class Player extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'player';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'age', 'uodated_at'], 'required'],
            [['age', 'created_at', 'uodated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'created_at' => 'Created At',
            'uodated_at' => 'Uodated At',
        ];
    }
}
