<?php

use yii\db\Migration;

/**
 * Class m201228_082132_initial
 */
class m201228_082132_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'last_ip'=> $this->string(16)->notNull()->defaultValue(''),
            'last_seen'=> $this->timestamp()->null()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%auth_assignment}}',[
            'item_name'=> $this->string(64)->notNull(),
            'user_id'=> $this->string(64)->notNull(),
            'created_at'=> $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_auth_assignment','{{%auth_assignment}}',['item_name','user_id']);

        $currentTimestampExp = "CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

        $this->createTable('{{%auth_item}}',[
            'name'=> $this->string(64)->notNull(),
            'type'=> $this->integer(11)->notNull(),
            'description'=> $this->text()->null()->defaultValue(null),
            'rule_name'=> $this->string(64)->null()->defaultValue(null),
            'data'=> $this->text()->null()->defaultValue(null),
            'created_at'=> $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at'=> $this->timestamp()->null()->defaultExpression($currentTimestampExp),
        ], $tableOptions);

        $this->createIndex('rule_name','{{%auth_item}}',['rule_name'],false);
        $this->createIndex('idx-auth_item-type','{{%auth_item}}',['type'],false);
        $this->addPrimaryKey('pk_on_auth_item','{{%auth_item}}',['name']);

        $this->createTable('{{%auth_item_child}}',[
            'parent'=> $this->string(64)->notNull(),
            'child'=> $this->string(64)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_auth_item_child','{{%auth_item_child}}',['parent','child']);

        $this->createTable('{{%auth_rule}}',[
            'name'=> $this->string(64)->notNull(),
            'data'=> $this->text()->null()->defaultValue(null),
            'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at'=> $this->timestamp()->null()->defaultExpression($currentTimestampExp),
        ], $tableOptions);

        $this->addPrimaryKey('pk_on_auth_rule','{{%auth_rule}}',['name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropPrimaryKey('pk_on_auth_assignment','{{%auth_assignment}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropPrimaryKey('pk_on_auth_item','{{%auth_item}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropPrimaryKey('pk_on_auth_item_child','{{%auth_item_child}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropPrimaryKey('pk_on_auth_rule','{{%auth_rule}}');
        $this->dropTable('{{%auth_rule}}');
    }
}
