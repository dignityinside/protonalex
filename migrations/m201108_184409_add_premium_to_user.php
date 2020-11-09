<?php

use yii\db\Migration;

/**
 * Class m201108_184409_add_premium_to_user
 */
class m201108_184409_add_premium_to_user extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'premium', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'premium');
    }
}
