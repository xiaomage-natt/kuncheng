<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "accounts".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $auth_type
 * @property string $auth_uid
 * @property string $auth_token
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Accounts extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['auth_uid'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['auth_type'], 'string', 'max' => 255],
            [['auth_uid'], 'string', 'max' => 64],
            [['auth_token'], 'string', 'max' => 256],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'auth_type' => Yii::t('app', 'Auth Type'),
            'auth_uid' => Yii::t('app', 'Auth Uid'),
            'auth_token' => Yii::t('app', 'Auth Token'),
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
     * @return \app\models\AccountsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\AccountsQuery(get_called_class());
    }
}
