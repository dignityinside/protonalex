<?php

use yii\db\Migration;

/**
 * Class m201125_210824_add_preview_to_post_table
 */
class m201125_210824_add_preview_img_post_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'preview_img', $this->string(255)->notNull());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'preview_img');
    }
}
