<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $course_id
 * @property string $course_tag
 * @property integer $department_id
 * @property integer $school_id
 * @property string $course_name
 * @property string $course_desc
 * @property integer $course_credits
 * @property string $course_type
 * @property integer $picture_file_id
 * @property integer $course_visibility_id
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property File $pictureFile
 * @property Department $department
 * @property School $school
 * @property User[] $users
 */
class Course extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_tag, department_id, school_id, course_name, course_desc, course_credits', 'required'),
			array('department_id, school_id, course_credits, picture_file_id, course_visibility_id', 'numerical', 'integerOnly'=>true),
			array('course_tag', 'length', 'max'=>20),
			array('course_name', 'length', 'max'=>50),
			array('course_type', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('course_id, course_tag, department_id, school_id, course_name, course_desc, course_credits, course_type, picture_file_id, course_visibility_id', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'course_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'users' => array(self::MANY_MANY, 'User', 'course_follow(course_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'course_id' => 'Course',
			'course_tag' => 'Course Tag',
			'department_id' => 'Department',
			'school_id' => 'School',
			'course_name' => 'Course Name',
			'course_desc' => 'Course Desc',
			'course_credits' => 'Course Credits',
			'course_type' => 'Course Type',
			'picture_file_id' => 'Picture File',
			'course_visibility_id' => 'Course Visibility',
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

		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_tag',$this->course_tag,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('course_name',$this->course_name,true);
		$criteria->compare('course_desc',$this->course_desc,true);
		$criteria->compare('course_credits',$this->course_credits);
		$criteria->compare('course_type',$this->course_type,true);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('course_visibility_id',$this->course_visibility_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Course the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
