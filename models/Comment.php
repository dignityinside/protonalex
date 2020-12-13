<?php

namespace app\models;

use app\models\forum\Forum;

/**
 * Comment model
 *
 * @author Alexander Schilling
 *
 * @package app\models
 *
 * @property-read \yii\db\ActiveQuery $topics
 */
class Comment extends \demi\comments\common\models\Comment
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasOne(Forum::class, ['id' => 'material_id']);
    }
}
