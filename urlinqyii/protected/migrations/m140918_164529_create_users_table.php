<?php

class m140918_164529_create_users_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('users', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'email' => 'text',
        ));
	}

	public function down()
	{
		echo "m140918_164529_create_users_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}

//   'posts'=>array(self::HAS_MANY, 'Post', 'author_id'),