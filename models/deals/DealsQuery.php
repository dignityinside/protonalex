<?php

namespace app\models\deals;

use app\models\Material;
use yii\db\Query;
use yii\db\ActiveQuery;
use demi\comments\common\models\Comment;

/**
 * This is the ActiveQuery class for [[Deals]].
 *
 * @author Alexander Schilling
 *
 * @see Deals
 */
class DealsQuery extends ActiveQuery
{

    /**
     * All
     *
     * @param null $db
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * One
     *
     * @param null $db
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Return comments count
     *
     * @return DealsQuery
     */
    public function withCommentsCount(): DealsQuery
    {

        if ($this->select === null) {
            $this->select = ['*'];
        }

        $countQuery = (new Query())->select('COUNT(*)')->from(Comment::tableName())
            ->where(
                'material_type=:typeDeals AND material_id=deals.id',
                [
                    ':typeDeals' => Material::MATERIAL_DEALS_ID,
                ]
            );

        return $this->addSelect(['commentsCount' => $countQuery]);
    }
}
