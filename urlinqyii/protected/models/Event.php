<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $event_id
 * @property string $event_type
 * @property string $origin_type
 * @property string $origin_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $start_time
 * @property string $end_time
 * @property string $start_date
 * @property string $end_date
 * @property integer $file_id
 * @property string $time_added
 * @property string $location
 * @property integer $hide_notification
 * @property integer $complete
 * @property integer $all_day
 *
 * The followings are the available model relations:
 * @property User $user
 * @property File $file
 * @property EventCheckin[] $eventCheckins
 * @property Tag[] $tags
 * @property User[] $users
 */
class Event extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'event';
	}


    public function user_group_color($user, $group_type){
        if($group_type == 'class'){
            $event_user = ClassUser::model()->find('user_id=:user_id', array(':user_id'=>$user->user_id));
            return $event_user->color();
        }else if($group_type == 'club'){
            $event_user = GroupUser::model()->find('user_id=:user_id', array(':user_id'=>$user->user_id));
            return $event_user->color();
        }
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_type, origin_type, origin_id, user_id, title, description, time_added', 'required'),
			array('user_id, file_id, hide_notification, complete, all_day', 'numerical', 'integerOnly'=>true),
			array('event_type', 'length', 'max'=>256),
			array('origin_type', 'length', 'max'=>10),
			array('origin_id', 'length', 'max'=>36),
			array('title, location', 'length', 'max'=>255),
			array('description', 'length', 'max'=>500),
			array('start_time, end_time, start_date, end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id, event_type, origin_type, origin_id, user_id, title, description, start_time, end_time, start_date, end_date, file_id, time_added, location, hide_notification, complete, all_day', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
			'eventCheckins' => array(self::HAS_MANY, 'EventCheckin', 'event_id'),
			'tags' => array(self::MANY_MANY, 'Tag', 'event_tag(event_id, tag_id)'),
            'theme' => array(self::BELONGS_TO, 'Theme', 'theme_id'),
            //'attendees' => array(self::HAS_MANY,'Event',array('origin_id'=>'group_id'),'condition'=>'origin_type = "group"'),
            //'attendees' => array(self::HAS_MANY, 'User', 'invite(:origin_type,:choice,origin_id, tag_id)',array('origin_type'=>'event','choice'=>1)),
            'invites' => array(self::HAS_MANY,'Invite',array('origin_id'=>'event_id'),'condition'=>'origin_type = "event"'),
            'acceptedInvites' => array(self::HAS_MANY,'Invite',array('origin_id'=>'event_id'),'condition'=>'origin_type = "event" AND choice = 1'),
            'event' => array(self::HAS_ONE,'Event',array('origin_id'=>'event_id'),'condition'=>'origin_type = "event"'),

            'attendees'=>array(self::MANY_MANY, 'User', 'event_user(event_id, user_id)', 'on'=>'attend_status="attending"','order'=>'attend_timestamp DESC'),
            //'eventUsers'=>array(self::MANY_MANY, 'EventUser', 'event_id', 'on'=>'event_user.status="attending"','order'=>'event_user.attend_timestamp DESC'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_id' => 'Event',
			'event_type' => 'Event Type',
			'origin_type' => 'Refers to the origin table',
			'origin_id' => 'Refers to the origin table id',
			'user_id' => 'Refers to the creator user(user_id)',
			'title' => 'Title',
			'description' => 'Description',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'file_id' => 'File',
			'time_added' => 'Time Added',
			'location' => 'Location',
			'hide_notification' => 'Hide Notification',
			'complete' => 'Complete',
			'all_day' => 'All Day',
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
		$criteria->compare('event_type',$this->event_type,true);
		$criteria->compare('origin_type',$this->origin_type,true);
		$criteria->compare('origin_id',$this->origin_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('time_added',$this->time_added,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('hide_notification',$this->hide_notification);
		$criteria->compare('complete',$this->complete);
		$criteria->compare('all_day',$this->all_day);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
