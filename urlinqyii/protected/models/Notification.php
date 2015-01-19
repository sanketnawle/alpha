<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property integer $notification_id
 * @property string $type
 * @property integer $actor_id
 * @property integer $user_id
 * @property integer $origin_id
 * @property string $origin_type
 * @property integer $status
 * @property string $check_point
 * @property integer $group_check_pt
 * @property string $created_time
 *
 * The followings are the available model relations:
 * @property User $actor
 * @property User[] $users
 */
class Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('actor_id, user_id, origin_id, origin_type, created_time', 'required'),
			array('actor_id, user_id, origin_id, status, group_check_pt', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>12),
			array('origin_type', 'length', 'max'=>50),
			array('check_point', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_id, type, actor_id, user_id, origin_id, origin_type, status, check_point, group_check_pt, created_time', 'safe', 'on'=>'search'),
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
			'actor' => array(self::BELONGS_TO, 'User', 'actor_id'),
			'users' => array(self::MANY_MANY, 'User', 'notification_user(notification_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notification_id' => 'Notification',
			'type' => 'type of notification',
			'actor_id' => 'user whose action created this notification',
			'user_id' => 'User who this notification is for',
			'origin_id' => 'Origin',
			'origin_type' => 'determines the type of notification; cr_invite->course_invite;gr_invite->group_invite;',
			'status' => 'Status',
			'check_point' => 'Check Point',
			'group_check_pt' => 'Group Check Pt',
			'created_time' => 'Created Time',
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

		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('actor_id',$this->actor_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('origin_type',$this->origin_type,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('check_point',$this->check_point,true);
		$criteria->compare('group_check_pt',$this->group_check_pt);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
