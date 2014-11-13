<?php

/**
 * This is the model class for table "class".
 *
 * The followings are the available columns in table 'class':
 * @property integer $class_id
 * @property integer $course_id
 * @property integer $department_id
 * @property integer $school_id
 * @property string $section_id
 * @property integer $private
 * @property string $semester
 * @property string $year
 * @property string $component
 * @property integer $color_id
 * @property string $location
 * @property integer $professor
 * @property integer $cover_file_id
 * @property integer $picture_file_id
 * @property string $syllabus_id
 *
 * The followings are the available model relations:
 * @property File $pictureFile
 * @property Course $course
 * @property Department $department
 * @property School $school
 * @property Color $color
 * @property File $coverFile
 * @property User[] $users
 * @property File[] $files
 * @property ClassReview[] $classReviews
 * @property Schedule[] $schedules
 * @property ClassUser[] $classUsers
 */
class ClassModel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'class';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, department_id, school_id, section_id, year', 'required'),
			array('course_id, department_id, school_id, private, color_id, professor, cover_file_id, picture_file_id', 'numerical', 'integerOnly'=>true),
			array('section_id, syllabus_id', 'length', 'max'=>20),
			array('semester', 'length', 'max'=>6),
			array('year', 'length', 'max'=>4),
			array('component', 'length', 'max'=>200),
			array('location', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('class_id, course_id, department_id, school_id, section_id, private, semester, year, component, color_id, location, professor, cover_file_id, picture_file_id, syllabus_id', 'safe', 'on'=>'search'),
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
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
			'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'color' => array(self::BELONGS_TO, 'Color', 'color_id'),
			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'users' => array(self::MANY_MANY, 'User', 'class_rating(class_id, user_id)'),
			'files' => array(self::MANY_MANY, 'File', 'class_file(class_id, file_id)'),
			'classReviews' => array(self::HAS_MANY, 'ClassReview', 'class_id'),
			'schedules' => array(self::MANY_MANY, 'Schedule', 'class_schedule(class_id, schedule_id)'),
			'classUsers' => array(self::HAS_MANY, 'ClassUser', 'class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'class_id' => 'Class',
			'course_id' => 'refers to course(course_id)',
			'department_id' => 'Refers to department(dept_id)',
			'school_id' => 'refers to school(school_id)',
			'section_id' => 'Section',
			'private' => 'Private',
			'semester' => 'Semester',
			'year' => 'year',
			'component' => 'type of class',
			'color_id' => 'linked to event_color_table color_id',
			'location' => 'Location',
			'professor' => 'due to collected data inconsistency',
			'cover_file_id' => 'course_cover',
			'picture_file_id' => 'display picture id',
			'syllabus_id' => 'syllabus from file_upload',
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('section_id',$this->section_id,true);
		$criteria->compare('private',$this->private);
		$criteria->compare('semester',$this->semester,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('component',$this->component,true);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('professor',$this->professor);
		$criteria->compare('cover_file_id',$this->cover_file_id);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('syllabus_id',$this->syllabus_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
