<?php

use yii\db\Migration;

/**
 * Class m201204_160559_add_reading_time_post_table
 */
class m201204_160559_add_reading_time_post_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'reading_time', $this->string(255)->null());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'reading_time');
    }
}
