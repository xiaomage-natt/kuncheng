<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "beidema_form".
 *
 * @property string $name
 * @property string $mobile
 * @property string $address
 * @property string $marry
 * @property string $child
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $id
 */
class BeidemaForm extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'marry', 'child'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 16],
            [['address'], 'string', 'max' => 256]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beidema_form';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', '姓名'),
            'mobile' => Yii::t('app', '手机号'),
            'address' => Yii::t('app', '地址'),
            'marry' => Yii::t('app', '婚姻状况'),
            'child' => Yii::t('app', '孩子年龄'),
            'status' => Yii::t('app', '状态'),
            'id' => Yii::t('app', 'ID'),
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
        ];
    }

    /**
     * @inheritdoc
     * @return \backend\models\BeidemaFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\BeidemaFormQuery(get_called_class());
    }
}
