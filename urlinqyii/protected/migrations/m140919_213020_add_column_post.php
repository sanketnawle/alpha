<?php

class m140919_213020_add_column_post extends CDbMigration
{
	public function up()
	{

        $this->addColumn('posts', 'author_id', 'int AFTER id');
	}

	public function down()
	{
		echo "m140919_213020_add_column_post does not support migration down.\n";
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