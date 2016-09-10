<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "wish_stars".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $wish_id
 * @property string $day
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class WishStars extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wish_id', 'status'], 'integer'],
            [['day', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wish_stars';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'wish_id' => Yii::t('app', 'Wish ID'),
            'day' => Yii::t('app', 'Day'),
            'status' => Yii::t('app', '状态'),
        ];
    }

/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\WishStarsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\WishStarsQuery(get_called_class());
    }
}
