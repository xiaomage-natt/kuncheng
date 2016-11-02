<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[BeidemaForm]].
 *
 * @see BeidemaForm
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
     * @return BeidemaForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BeidemaForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}