<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 *
 * @author Alexander Schilling
 */
class m180704_171500_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%category}}', [
            'id'               => $this->primaryKey(),
            'name'             => $this->string(255)->notNull(),
            'slug'             => $this->string(255)->notNull(),
            'material_id'      => $this->integer()->unsigned()->null()
        ], $tableOptions
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
