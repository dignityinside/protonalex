<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth`.
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class m180222_190528_create_auth_table extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%auth}}', [
            'id'        => $this->primaryKey(),
            'user_id'   => $this->integer()->notNull(),
            'source'    => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ], $tableOptions
        );

        $this->addForeignKey('fk-auth-user_id-user-id', '{{%auth}}', 'user_id', '{{%user}}', 'id');

    }

    public function down()
    {
        $this->dropTable('{{%auth}}');
    }
}
