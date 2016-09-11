<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "wishes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $day
 * @property string $name
 * @property string $mobile
 * @property string $content
 * @property integer $star
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Wishes extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
    const ACTIVE = 10;
    const DELETE = 0;
    const CHECK = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'star', 'status'], 'integer'],
            [['day', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 16],
            [['content'], 'string', 'max' => 256]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishes';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'day' => Yii::t('app', 'Day'),
            'name' => Yii::t('app', 'Name'),
            'mobile' => Yii::t('app', 'Mobile'),
            'content' => Yii::t('app', 'Content'),
            'star' => Yii::t('app', 'Star'),
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
     * @return \app\models\WishesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\WishesQuery(get_called_class());
    }
}
