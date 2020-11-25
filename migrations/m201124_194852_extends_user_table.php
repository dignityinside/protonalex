<?php

use yii\db\Migration;

/**
 * Class m201124_194852_extend_user_table
 */
class m201124_194852_extends_user_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'payment_type', $this->integer()->unsigned()->notNull()->defaultValue(1));
        $this->addColumn('{{%user}}', 'payment_tariff', $this->integer()->unsigned()->notNull()->defaultValue(1));
        $this->addColumn('{{%user}}', 'premium_until', $this->dateTime());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'payment_type');
        $this->dropColumn('{{%user}}', 'payment_tariff');
        $this->dropColumn('{{%user}}', 'premium_until');
    }
}
