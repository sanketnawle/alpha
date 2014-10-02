<?php

/**
 * This is the model class for table "personal_event".
 *
 * The followings are the available columns in table 'personal_event':
 * @property integer $event_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $start_time
 * @property integer $is_check
 * @property string $end_time
 * @property integer $invites
 * @property string $recurrence
 * @property string $start_date
 * @property string $end_date
 * @property string $file_id
 * @property string $location
 * @property string $time_added
 * @property integer $theme_id
 * @property string $reminder_time
 * @property integer $color_id
 * @property integer $hide_notification
 *
 * The followings are the available model relations:
 * @property User $user
 * @property FileUpload $file
 * @property ThemeTable $theme
 * @property User[] $users
 */
class PersonalEvent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'personal_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title, start_time, end_time, start_date, time_added', 'required'),
			array('user_id, is_check, invites, theme_id, color_id, hide_notification', 'numerical', 'integerOnly'=>true),
			array('title, description, location', 'length', 'max'=>255),
			array('recurrence', 'length', 'max'=>7),
			array('file_id', 'length', 'max'=>20),
			array('end_date, reminder_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id, user_id, title, description, start_time, is_check, end_time, invites, recurrence, start_date, end_date, file_id, location, time_added, theme_id, reminder_time, color_id, hide_notification', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'file' => array(self::BELONGS_TO, 'FileUpload', 'file_id'),
			'theme' => array(self::BELONGS_TO, 'ThemeTable', 'theme_id'),
			'users' => array(self::MANY_MANY, 'User', 'personal_event_invited(event_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_id' => 'Event',
			'user_id' => 'User',
			'title' => 'Title',
			'description' => 'Description',
			'start_time' => 'Start Time',
			'is_check' => 'Is Check',
			'end_time' => 'End Time',
			'invites' => 'Invites',
			'recurrence' => 'Recurrence',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'file_id' => 'File',
			'location' => 'Location',
			'time_added' => 'Time Added',
			'theme_id' => 'Theme',
			'reminder_time' => 'Reminder Time',
			'color_id' => 'Color',
			'hide_notification' => 'Hide Notification',
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

		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('is_check',$this->is_check);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('invites',$this->invites);
		$criteria->compare('recurrence',$this->recurrence,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('time_added',$this->time_added,true);
		$criteria->compare('theme_id',$this->theme_id);
		$criteria->compare('reminder_time',$this->reminder_time,true);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('hide_notification',$this->hide_notification);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersonalEvent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
