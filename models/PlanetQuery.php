<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Planet]].
 *
 * @author Alexander Schilling
 *
 * @see Planet
 */
class PlanetQuery extends \yii\db\ActiveQuery
{

    /**
     * All
     *
     * {@inheritdoc}
     *
     * @return Planet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * One
     *
     * {@inheritdoc}
     *
     * @return Planet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
