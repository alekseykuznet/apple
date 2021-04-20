<?php

use yii\db\Migration;
use app\models\Apple;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m210420_213332_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $updatedAtType = $this->timestamp()
            ->null()
            ->defaultExpression('null on update current_timestamp()');

        $this->createTable(Apple::tableName(), [
            'id' => $this->primaryKey(),
            'color' => $this->string(10)->notNull(),
            'status' => $this->integer()->defaultValue(Apple::STATUS_ON_TREE),
            'percent' => $this->integer()->defaultValue(Apple::DEFAULT_PERCENT),
            'drop_date' => $this->timestamp()->null(),
            'created_at' => $this->timestamp()->defaultExpression('current_timestamp()'),
            'updated_at' => $updatedAtType,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Apple::tableName());
    }
}
