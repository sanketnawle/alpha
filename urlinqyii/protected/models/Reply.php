<?php

/**
 * This is the model class for table "reply".
 *
 * The followings are the available columns in table 'reply':
 * @property integer $reply_id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $reply_msg
 * @property integer $up_vote
 * @property integer $down_vote
 * @property integer $file_id
 * @property integer $anon
 * @property string $update_timestamp
 *
 * The followings are the available model relations:
 * @property File $file
 * @property Post $post
 * @property User $user
 * @property User[] $users
 */
class Reply extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id, user_id, reply_msg, anon, update_timestamp', 'required'),
			array('post_id, user_id, up_vote, down_vote, file_id, anon', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('reply_id, post_id, user_id, reply_msg, up_vote, down_vote, file_id, anon, update_timestamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'users' => array(self::MANY_MANY, 'User', 'reply_vote(reply_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reply_id' => 'Reply',
			'post_id' => 'Post',
			'user_id' => 'User',
			'reply_msg' => 'Reply Msg',
			'up_vote' => 'Up Vote',
			'down_vote' => 'Down Vote',
			'file_id' => 'File',
			'anon' => 'Anon',
			'update_timestamp' => 'Update Timestamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('reply_id',$this->reply_id);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('reply_msg',$this->reply_msg,true);
		$criteria->compare('up_vote',$this->up_vote);
		$criteria->compare('down_vote',$this->down_vote);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('anon',$this->anon);
		$criteria->compare('update_timestamp',$this->update_timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
