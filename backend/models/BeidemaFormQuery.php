<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[\backend\models\BeidemaForm]].
 *
 * @see \backend\models\BeidemaForm
 */
class BeidemaFormQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \backend\models\BeidemaForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\BeidemaForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}