<?php

use yii\db\Migration;

/**
 * Class m180712_185600_add_aads_com
 *
 * @author Alexander Schilling
 */
class m180712_185600_add_aads_com extends Migration
{

    public function up()
    {
        $this->addColumn('{{%user}}', 'aads_com_id', $this->string(20));
        $this->addColumn('{{%user}}', 'ads_visibility', $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'aads_com_id');
    }

}
