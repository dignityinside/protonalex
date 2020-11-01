<?php

use yii\db\Migration;

/**
 * Handles the creation of table `forum`.
 *
 * @author Alexander Schilling
 */
class m190416_203553_create_forum_table extends Migration
{

    /**
     * @return bool|void
     */
    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%forum}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'created' => $this->integer()->unsigned()->notNull(),
            'updated' => $this->integer()->unsigned()->null(),
            'user_id' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'status_id' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'category_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'hits' => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'allow_comments' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'meta_description' => $this->string(255)->null(),
        ], $tableOptions
        );

        $this->createIndex('idx-title-unique', '{{%forum}}', 'title', true);

    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%forum}}');
    }

}
