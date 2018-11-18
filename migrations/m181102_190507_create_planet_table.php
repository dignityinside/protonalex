<?php

use yii\db\Migration;

/**
 * Handles the creation of table `planet`.
 *
 * @author Alexander Schilling
 */
class m181102_190507_create_planet_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%planet}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'guid' => $this->string(255)->null(),
            'link' => $this->string(255)->null(),
            'pub_date' => $this->integer()->unsigned()->notNull(),
            'author' => $this->string(255)->null(),
            'status_id' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
        ], $tableOptions
        );

        $this->createIndex('idx-title-unique', '{{%planet}}', 'title', true);

    }

    public function down()
    {
        $this->dropTable('{{%planet}}');
    }
}
