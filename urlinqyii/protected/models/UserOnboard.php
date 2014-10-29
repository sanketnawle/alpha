<?php

/**
 * This is the model class for table "user_onboard".
 *
 * The followings are the available columns in table 'user_onboard':
 * @property integer $user_id
 * @property integer $home_search
 * @property integer $home_planner
 * @property integer $home_fbar
 * @property integer $calendar_create_event
 * @property integer $calendar_day_view
 * @property integer $department
 * @property integer $class
 * @property integer $club
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserOnboard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_onboard';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, home_search, home_planner, home_fbar, calendar_create_event, calendar_day_view, department, class, club', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, home_search, home_planner, home_fbar, calendar_create_event, calendar_day_view, department, class, club', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'home_search' => 'Home Search',
			'home_planner' => 'Home Planner',
			'home_fbar' => 'Home Fbar',
			'calendar_create_event' => 'Calendar Create Event',
			'calendar_day_view' => 'Calendar Day View',
			'department' => 'Department',
			'class' => 'Class',
			'club' => 'Club',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('home_search',$this->home_search);
		$criteria->compare('home_planner',$this->home_planner);
		$criteria->compare('home_fbar',$this->home_fbar);
		$criteria->compare('calendar_create_event',$this->calendar_create_event);
		$criteria->compare('calendar_day_view',$this->calendar_day_view);
		$criteria->compare('department',$this->department);
		$criteria->compare('class',$this->class);
		$criteria->compare('club',$this->club);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserOnboard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
