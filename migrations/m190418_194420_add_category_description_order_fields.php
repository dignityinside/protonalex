<?php

use yii\db\Migration;

/**
 * Handles the add of new columns to table `category`.
 *
 * @author Alexander Schilling
 */
class m190418_194420_add_category_description_order_fields extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%category}}', 'description', $this->string(255)->null());
        $this->addColumn('{{%category}}', 'order', $this->integer()->unsigned()->null());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%category}}', 'description');
        $this->dropColumn('{{%category}}', 'order');
    }

}
