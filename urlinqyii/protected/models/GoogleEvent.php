<?php

/**
 * This is the model class for table "google_events".
 *
 * The followings are the available columns in table 'google_events':
 * @property string $event_id
 * @property string $user_id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property string $start_date
 * @property string $start_time
 * @property string $end_date
 * @property string $end_time
 * @property string $recurrence
 * @property string $team_id
 */
class GoogleEvent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'google_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, user_id, title, description, location, start_date, start_time, end_date, end_time, recurrence, team_id', 'required'),
			array('event_id', 'length', 'max'=>30),
			array('user_id, team_id', 'length', 'max'=>20),
			array('recurrence', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id, user_id, title, description, location, start_date, start_time, end_date, end_time, recurrence, team_id', 'safe', 'on'=>'search'),
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
			'event_id' => 'Event',
			'user_id' => 'User',
			'title' => 'Title',
			'description' => 'Description',
			'location' => 'Location',
			'start_date' => 'Start Date',
			'start_time' => 'Start Time',
			'end_date' => 'End Date',
			'end_time' => 'End Time',
			'recurrence' => 'Recurrence',
			'team_id' => 'Team',
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

		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('recurrence',$this->recurrence,true);
		$criteria->compare('team_id',$this->team_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoogleEvent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
