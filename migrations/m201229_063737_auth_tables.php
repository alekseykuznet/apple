<?php

use yii\db\Migration;
use app\helpers\DateTimeHelper;

/**
 * Class m201229_063737_auth_tables
 */
class m201229_063737_auth_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $currentDateTime = date(DateTimeHelper::DEFAULT_DATETIME_FORMAT);

        $this->batchInsert('{{%auth_assignment}}',
            ["item_name", "user_id", "created_at"],
            [
                [
                    'item_name' => 'admin',
                    'user_id' => '1',
                    'created_at' => $currentDateTime,
                ]
            ]);

        $this->batchInsert('{{%auth_item}}',
            ["name", "type", "description", "rule_name", "data", "created_at", "updated_at"],
            [
                [
                    'name' => 'admin',
                    'type' => '1',
                    'description' => 'Admin',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'administrateRbac',
                    'type' => '2',
                    'description' => 'Can administrate all "RBAC" module',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'DeleteOwn',
                    'type' => '2',
                    'description' => 'Удалить свое',
                    'rule_name' => 'AuthorRule',
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'ItemCreate',
                    'type' => '2',
                    'description' => 'Создать обьект',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'ItemDelete',
                    'type' => '2',
                    'description' => 'Удалить обьект',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'ItemUpdate',
                    'type' => '2',
                    'description' => 'Редактировать обьект',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'ItemView',
                    'type' => '2',
                    'description' => 'Просмотр обьекта',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'manager',
                    'type' => '1',
                    'description' => 'Манагер стажор',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'superadmin',
                    'type' => '1',
                    'description' => 'Super admin',
                    'rule_name' => null,
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'UpdateOwn',
                    'type' => '2',
                    'description' => 'Редактировать свое',
                    'rule_name' => 'AuthorRule',
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'user',
                    'type' => '1',
                    'description' => 'User',
                    'rule_name' => 'GroupRule',
                    'data' => null,
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
            ]);

        $this->batchInsert('{{%auth_item_child}}',
            ["parent", "child"],
            [
                [
                    'parent' => 'admin',
                    'child' => 'ItemCreate',
                ],
                [
                    'parent' => 'admin',
                    'child' => 'ItemDelete',
                ],
                [
                    'parent' => 'admin',
                    'child' => 'ItemUpdate',
                ],
                [
                    'parent' => 'admin',
                    'child' => 'ItemView',
                ],
                [
                    'parent' => 'admin',
                    'child' => 'user',
                ],
                [
                    'parent' => 'manager',
                    'child' => 'ItemView',
                ],
                [
                    'parent' => 'manager',
                    'child' => 'user',
                ],
                [
                    'parent' => 'superadmin',
                    'child' => 'admin',
                ],
                [
                    'parent' => 'superadmin',
                    'child' => 'administrateRbac',
                ],
                [
                    'parent' => 'user',
                    'child' => 'DeleteOwn',
                ],
                [
                    'parent' => 'user',
                    'child' => 'UpdateOwn',
                ],
            ]);

        $this->batchInsert('{{%auth_rule}}',
            ["name", "data", "created_at", "updated_at"],
            [
                [
                    'name' => 'AuthorRule',
                    'data' => 'O:25:"kak\\rbac\\rules\\AuthorRule":3:{s:4:"name";s:10:"AuthorRule";s:9:"createdAt";i:1519740817;s:9:"updatedAt";i:1519740830;}',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'GroupRule',
                    'data' => 'O:24:"kak\\rbac\\rules\\GroupRule":3:{s:4:"name";s:9:"GroupRule";s:9:"createdAt";i:1519740852;s:9:"updatedAt";i:1519740852;}',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'UserRule',
                    'data' => 'O:23:"kak\\rbac\\rules\\UserRule":3:{s:4:"name";s:8:"UserRule";s:9:"createdAt";i:1519740869;s:9:"updatedAt";i:1519740869;}',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
            ]);

        $this->batchInsert('{{%user}}',
            ["id", "username", "password_hash", "password_reset_token",  "email", "status", "last_ip", "last_seen", "created_at", "updated_at"],
            [
                [
                    'id' => '1',
                    'username' => 'admin',
                    'password_hash' => '$2y$11$TuvA1o.ct7J0xF.N8PrabOG3nqEELX.IlkdHoiMe5eElqXl3N2bK.',
                    'password_reset_token' => '',
                    'email' => 'aleksey.a.kuznecov@yandex.ru',
                    'status' => 1,
                    'last_ip' => '127.0.0.1',
                    'last_seen' => '2020-12-29 09:29:26',
                    'created_at' => '2020-12-29 15:12:13',
                    'updated_at' => '2020-12-29 12:22:27',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%auth_assignment}} CASCADE');
        $this->truncateTable('{{%auth_item}} CASCADE');
        $this->truncateTable('{{%auth_item_child}} CASCADE');
        $this->truncateTable('{{%auth_rule}} CASCADE');
    }
}
