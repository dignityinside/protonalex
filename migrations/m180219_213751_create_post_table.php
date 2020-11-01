<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 *
 * @author Alexander Schilling
 */
class m180219_213751_create_post_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%post}}', [
            'id'               => $this->primaryKey(),
            'title'            => $this->string(255)->notNull(),
            'slug'            => $this->string(255)->notNull(),
            'content'          => $this->text()->notNull(),
            'status_id'        => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'datecreate'       => $this->integer()->unsigned()->notNull(),
            'dateupdate'       => $this->integer()->unsigned()->null(),
            'category_id'      => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'user_id'          => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'hits'             => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'allow_comments'   => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'ontop'            => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'meta_description' => $this->string(255)->null()
        ], $tableOptions
        );

    }

    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
