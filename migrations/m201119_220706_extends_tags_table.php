<?php

use yii\db\Migration;

/**
 * Class m201119_220706_extends_tags_table
 */
class m201119_220706_extends_tags_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%tags}}', 'slug', $this->string(255)->notNull());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%tags}}', 'slug');
    }
}
