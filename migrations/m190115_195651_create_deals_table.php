<?php

use yii\db\Migration;

/**
 * Handles the creation of table `deals`.
 *
 * @author Alexander Schilling
 */
class m190115_195651_create_deals_table extends Migration
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
            '{{%deals}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'thumbnail' => $this->string(255)->null(),
            'created' => $this->integer()->unsigned()->notNull(),
            'updated' => $this->integer()->unsigned()->null(),
            'author' => $this->string(255)->null(),
            'user_id' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'status_id' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'category_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'hits' => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'allow_comments' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'meta_keywords' => $this->string(255)->null(),
            'meta_description' => $this->string(255)->null(),
            'url' => $this->string(255)->null(),
            'price_before' => $this->string(255)->null(),
            'price_after' => $this->string(255)->null(),
            'coupon' => $this->string(255)->null(),
            'valid_until' => $this->dateTime()->null(),

        ], $tableOptions
        );

        $this->createIndex('idx-title-unique', '{{%deals}}', 'title', true);

    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%deals}}');
    }
}
