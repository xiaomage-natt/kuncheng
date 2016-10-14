<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "user_profiles".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $nickname
 * @property string $gender
 * @property string $province
 * @property string $city
 * @property string $thumb
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserProfiles extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nickname', 'province', 'city'], 'string', 'max' => 32],
            [['gender'], 'string', 'max' => 8],
            [['thumb'], 'string', 'max' => 256],
            [['user_id'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profiles';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'nickname' => Yii::t('app', 'Nickname'),
            'gender' => Yii::t('app', 'Gender'),
            'province' => Yii::t('app', 'Province'),
            'city' => Yii::t('app', 'City'),
            'thumb' => Yii::t('app', 'Thumb'),
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
//            'uuid' => [
//                'class' => UUIDBehavior::className(),
//                'column' => 'id',
//            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\UserProfilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\UserProfilesQuery(get_called_class());
    }
}
