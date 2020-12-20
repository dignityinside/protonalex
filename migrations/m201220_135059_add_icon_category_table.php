<?php

use yii\db\Migration;

/**
 * Class m201220_135059_add_icon_category_table
 */
class m201220_135059_add_icon_category_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%category}}', 'icon', $this->string(255)->null());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%category}}', 'icon');
    }
}
