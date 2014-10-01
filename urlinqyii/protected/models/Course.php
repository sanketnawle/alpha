<?php

/**
 * This is the model class for table "courses".
 *
 * The followings are the available columns in table 'courses':
 * @property string $course_id
 * @property integer $dept_id
 * @property integer $univ_id
 * @property string $course_name
 * @property string $course_desc
 * @property integer $course_credits
 * @property string $course_type
 * @property string $dp_blob_id
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property Department $dept
 * @property University $univ
 * @property DisplayPicture $dpBlob
 * @property CoursesSemester[] $coursesSemesters
 */
class Course extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, dept_id, univ_id, course_name, course_desc, course_credits', 'required'),
			array('dept_id, univ_id, course_credits', 'numerical', 'integerOnly'=>true),
			array('course_id', 'length', 'max'=>20),
			array('course_name', 'length', 'max'=>50),
			array('course_type', 'length', 'max'=>9),
			array('dp_blob_id', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('course_id, dept_id, univ_id, course_name, course_desc, course_credits, course_type, dp_blob_id', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'User', 'course_follow(course_id, user_id)'),
			'dept' => array(self::BELONGS_TO, 'Department', 'dept_id'),
			'univ' => array(self::BELONGS_TO, 'University', 'univ_id'),
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'semesters' => array(self::HAS_MANY, 'CourseSemester', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'course_id' => 'Course',
			'dept_id' => 'Dept',
			'univ_id' => 'Univ',
			'course_name' => 'Course Name',
			'course_desc' => 'Course Desc',
			'course_credits' => 'Course Credits',
			'course_type' => 'Course Type',
			'dp_blob_id' => 'Dp Blob',
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

		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('univ_id',$this->univ_id);
		$criteria->compare('course_name',$this->course_name,true);
		$criteria->compare('course_desc',$this->course_desc,true);
		$criteria->compare('course_credits',$this->course_credits);
		$criteria->compare('course_type',$this->course_type,true);
		$criteria->compare('dp_blob_id',$this->dp_blob_id,true);

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
