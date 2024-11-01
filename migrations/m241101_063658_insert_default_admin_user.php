<?php

use yii\db\Migration;

/**
 * Class m241101_063658_insert_default_admin_user
 */
class m241101_063658_insert_default_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Yii::$app->security->generatePasswordHash('admin123'),
            'role' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString(),
            'created_at' => new \yii\db\Expression('CURRENT_TIMESTAMP'),
            'updated_at' => new \yii\db\Expression('CURRENT_TIMESTAMP'),
        ]);

        // Assign admin role to the default user
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll(1);

        $this->delete('{{%user}}', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241101_063658_insert_default_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
