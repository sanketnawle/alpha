<?php

class m140918_170242_add_posts_user_relationship extends CDbMigration
{
	public function up()
	{
        $this->addColumn('posts', 'author_id', 'int AFTER id');
    }

	public function down()
	{
		echo "m140918_170242_add_posts_user_relationship does not support migration down.\n";
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