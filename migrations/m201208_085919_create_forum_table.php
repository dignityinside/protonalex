<?php

use yii\db\Migration;

/**
 * Handles the creation of table `forum`.
 *
 * @author Alexander Schilling
 */
class m201208_085919_create_forum_table extends Migration
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
            'id'               => $this->primaryKey(),
            'title'            => $this->string(255)->notNull(),
            'content'          => $this->text()->notNull(),
            'user_id'          => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'status_id'        => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'category_id'      => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'hits'             => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'allow_comments'   => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'meta_description' => $this->string(255)->null(),
            'pinned'           => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'premium'          => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'created_at'       => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'       => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
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
