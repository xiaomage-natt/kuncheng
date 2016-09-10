<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\app\models\WishStars]].
 *
 * @see \app\models\WishStars
 */
class WishStarsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\WishStars[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\WishStars|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}