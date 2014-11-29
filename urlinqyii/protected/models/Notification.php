<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $notification_id
 * @property integer $actor_id
 * @property integer $trigger_id
 * @property string $trigger_type
 * @property integer $status
 * @property string $check_point
 * @property integer $group_check_pt
 * @property string $created_time
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
			array('actor_id, trigger_id, trigger_type', 'required'),
			array('actor_id, trigger_id, status, group_check_pt', 'numerical', 'integerOnly'=>true),
			array('notification_id', 'length', 'max'=>11),
			array('trigger_type', 'length', 'max'=>50),
			array('check_point', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_id, actor_id, trigger_id, trigger_type, status, check_point, group_check_pt, created_time', 'safe', 'on'=>'search'),
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
			'notification_id' => 'Notification',
			'actor_id' => 'user whose action created this notification',
			'trigger_id' => 'Trigger',
			'trigger_type' => 'determines the type of notification; cr_invite->course_invite;gr_invite->group_invite;',
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

		$criteria->compare('notification_id',$this->notification_id,true);
		$criteria->compare('actor_id',$this->actor_id);
		$criteria->compare('trigger_id',$this->trigger_id);
		$criteria->compare('trigger_type',$this->trigger_type,true);
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
