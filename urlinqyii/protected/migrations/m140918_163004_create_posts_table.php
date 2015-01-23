<?php

class m140918_163004_create_posts_table extends CDbMigration
{


    //yiic create create_posts_table

	public function up()
	{
        $this->createTable('posts', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'content' => 'text',
        ));
	}

	public function down()
	{
		echo "m140918_163004_create_posts_table does not support migration down.\n";
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