<?php

use yii\db\Migration;

/**
 * Class m241101_055915_init_rbac
 */
class m241101_055915_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Create roles
        $admin = $auth->createRole('admin');
        $user = $auth->createRole('user');
        $auth->add($admin);
        $auth->add($user);

        // Create permissions
        $manageUsers = $auth->createPermission('manageUsers');
        $auth->add($manageUsers);

        // Assign permissions to roles
        $auth->addChild($admin, $manageUsers);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241101_055915_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
