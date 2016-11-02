<?php

namespace frontend\models;

use \frontend\models\base\BeidemaForm as BaseBeidemaForm;

/**
 * This is the model class for table "beidema_form".
 */
class BeidemaForm extends BaseBeidemaForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'marry', 'child'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 16],
            [['address'], 'string', 'max' => 256]
        ]);
    }
	
}
