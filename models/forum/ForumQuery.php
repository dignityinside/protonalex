<?php

namespace app\models\forum;

use app\models\Material;
use yii\db\Query;
use yii\db\ActiveQuery;
use demi\comments\common\models\Comment;

/**
 * This is the ActiveQuery class for [[Forum]].
 *
 * @author Alexander Schilling
 *
 * @see Forum
 */
class ForumQuery extends ActiveQuery
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
     * @return ForumQuery
     */
    public function withCommentsCount(): ForumQuery
    {

        if ($this->select === null) {
            $this->select = ['*'];
        }

        $countQuery = (new Query())->select('COUNT(*)')
            ->from(Comment::tableName())
            ->where(
                'material_type=:typeForum AND material_id=forum.id',
                [
                    ':typeForum' => Material::MATERIAL_FORUM_ID,
                ]
            );

        return $this->addSelect(['commentsCount' => $countQuery]);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status_id' => Material::STATUS_PUBLIC]);
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function recentTopics(int $count = 10)
    {
        return $this->addOrderBy(['created_at' => SORT_DESC])->limit($count);
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function populare(int $count = 10)
    {
        return $this->addOrderBy('commentsCount DESC')->limit($count);
    }
}
