<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 *
 * @author Alexander Schilling
 */
class m180226_212102_create_tags_table extends Migration
{

    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tags}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->unsigned()->notNull(),
            'user_id'    => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions
        );

    }

    public function down()
    {
        $this->dropTable('{{%tags}}');
    }
}
