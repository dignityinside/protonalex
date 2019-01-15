<?php

namespace app\models;

use demi\comments\common\models\Comment;
use yii\db\Query;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Video]].
 *
 * @author Alexander Schilling
 *
 * @see Video
 */
class VideoQuery extends ActiveQuery
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
     * @return VideoQuery
     */
    public function withCommentsCount(): VideoQuery
    {

        if ($this->select === null) {
            $this->select = ['*'];
        }

        $countQuery = (new Query())->select('COUNT(*)')->from(Comment::tableName())
            ->where(
                'material_type=:typeVideo AND material_id=video.id', [
                    ':typeVideo' => Video::MATERIAL_ID,
                ]
            );

        return $this->addSelect(['commentsCount' => $countQuery]);

    }
}
