<?php

/**
 * This is the model class for table "class_syllabus".
 *
 * The followings are the available columns in table 'class_syllabus':
 * @property string $class_id
 * @property integer $schedule_id
 */
class ClassSyllabusEvent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'syllabus_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_title', 'event_date', 'user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('class_id', 'length', 'max'=>36),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id','class_id, user_id, event_type, event_date, file_id', 'safe', 'on'=>'search'),
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
			'class_id' => array(self::BELONGS_TO, 'Class', 'class_id'),
			'user_id' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'class_id' => 'Class',
			'event_id' => 'Event',
			'user_id' => "User",
			'event_type' => "Type",
			'event_title' => "Title",
			'event_date' => "Date",
			'file_id' => "FileID"
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

		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('event_type',$this->event_type);
		$criteria->compare('event_date',$this->event_date);
		$criteria->compare('file_id',$this->file_id);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseSemesterSchedule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
