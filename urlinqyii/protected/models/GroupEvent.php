<?php

/**
 * This is the model class for table "group_event".
 *
 * The followings are the available columns in table 'group_event':
 * @property integer $event_id
 * @property integer $group_id
 * @property string $title
 * @property string $description
 * @property string $start_time
 * @property integer $user_id
 * @property string $recurrence
 * @property string $end_time
 * @property string $start_date
 * @property string $end_date
 * @property string $file_id
 * @property string $time_added
 * @property integer $theme_id
 * @property string $location
 * @property string $privacy
 * @property integer $made_by_admin
 *
 * The followings are the available model relations:
 * @property ThemeTable $theme
 * @property FileUpload $file
 * @property Groups $group
 * @property User $user
 * @property User[] $users
 */
class GroupEvent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, title, start_time, user_id, recurrence, end_time, start_date, time_added', 'required'),
			array('group_id, user_id, theme_id, made_by_admin', 'numerical', 'integerOnly'=>true),
			array('title, location', 'length', 'max'=>255),
			array('description', 'length', 'max'=>500),
			array('recurrence, privacy', 'length', 'max'=>7),
			array('file_id', 'length', 'max'=>20),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id, group_id, title, description, start_time, user_id, recurrence, end_time, start_date, end_date, file_id, time_added, theme_id, location, privacy, made_by_admin', 'safe', 'on'=>'search'),
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
			'theme' => array(self::BELONGS_TO, 'ThemeTable', 'theme_id'),
			'file' => array(self::BELONGS_TO, 'FileUpload', 'file_id'),
			'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'users' => array(self::MANY_MANY, 'User', 'group_event_invited(event_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_id' => 'Event',
			'group_id' => 'Group',
			'title' => 'Title',
			'description' => 'Description',
			'start_time' => 'Start Time',
			'user_id' => 'User',
			'recurrence' => 'Recurrence',
			'end_time' => 'End Time',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'file_id' => 'File',
			'time_added' => 'Time Added',
			'theme_id' => 'Theme',
			'location' => 'Location',
			'privacy' => 'Privacy',
			'made_by_admin' => 'Made By Admin',
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('recurrence',$this->recurrence,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('time_added',$this->time_added,true);
		$criteria->compare('theme_id',$this->theme_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('privacy',$this->privacy,true);
		$criteria->compare('made_by_admin',$this->made_by_admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupEvent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
