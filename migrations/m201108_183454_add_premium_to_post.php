<?php

use yii\db\Migration;

/**
 * Class m201108_183454_add_premium_to_post
 */
class m201108_183454_add_premium_to_post extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'premium', $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0));
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'premium');
    }
}
