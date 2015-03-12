<?php

/**
 * This is the model class for table "message_group_user".
 *
 * The followings are the available columns in table 'message_group_user':
 * @property integer $message_group_id
 * @property integer $user_id
 * @property string $joined_at
 * @property integer $admin
 */
class MessageGroupUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message_group_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_group_id, user_id, joined_at', 'required'),
			array('message_group_id, user_id, admin', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message_group_id, user_id, joined_at, admin', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'message_group_id' => 'Message Group',
			'user_id' => 'User',
			'joined_at' => 'Joined At',
			'admin' => 'Admin',
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

		$criteria->compare('message_group_id',$this->message_group_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('joined_at',$this->joined_at,true);
		$criteria->compare('admin',$this->admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessageGroupUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
