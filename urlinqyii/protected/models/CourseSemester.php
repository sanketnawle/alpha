<?php

/**
 * This is the model class for table "courses_semester".
 *
 * The followings are the available columns in table 'courses_semester':
 * @property string $course_id
 * @property integer $dept_id
 * @property integer $univ_id
 * @property string $section_id
 * @property string $semester
 * @property string $year
 * @property string $component
 * @property integer $color_id
 * @property string $class_id
 * @property string $location
 * @property integer $professor
 * @property string $cover_blob_id
 * @property string $dp_blob_id
 * @property string $syllabus_id
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property ClassReview[] $classReviews
 * @property CourseEvent[] $courseEvents
 * @property FileUpload[] $fileUploads
 * @property Courses $course
 * @property Department $dept
 * @property Department $univ
 * @property DisplayPicture $coverBlob
 * @property DisplayPicture $dpBlob
 * @property FileUpload $syllabus
 * @property EventColorTable $color
 * @property User $professor0
 * @property Schedule[] $schedules
 */
class CourseSemester extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'courses_semester';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, dept_id, univ_id, section_id, year, class_id', 'required'),
			array('dept_id, univ_id, color_id, professor', 'numerical', 'integerOnly'=>true),
			array('course_id, section_id, syllabus_id', 'length', 'max'=>20),
			array('semester', 'length', 'max'=>6),
			array('year', 'length', 'max'=>4),
			array('component', 'length', 'max'=>200),
			array('class_id', 'length', 'max'=>36),
			array('location', 'length', 'max'=>100),
			array('cover_blob_id, dp_blob_id', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('course_id, dept_id, univ_id, section_id, semester, year, component, color_id, class_id, location, professor, cover_blob_id, dp_blob_id, syllabus_id', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'User', 'courses_user(class_id, user_id)'),
			'classReviews' => array(self::HAS_MANY, 'ClassReview', 'class_id'),
			'courseEvents' => array(self::HAS_MANY, 'CourseEvent', 'class_id'),
			'fileUploads' => array(self::MANY_MANY, 'FileUpload', 'course_files(class_id, file_id)'),
			'course' => array(self::BELONGS_TO, 'Courses', 'course_id'),
			'dept' => array(self::BELONGS_TO, 'Department', 'dept_id'),
			'univ' => array(self::BELONGS_TO, 'Department', 'univ_id'),
			'coverBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'cover_blob_id'),
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'syllabus' => array(self::BELONGS_TO, 'FileUpload', 'syllabus_id'),
			'color' => array(self::BELONGS_TO, 'EventColorTable', 'color_id'),
			'professor0' => array(self::BELONGS_TO, 'User', 'professor'),
			'schedules' => array(self::MANY_MANY, 'Schedule', 'courses_semester_schedule(class_id, schedule_id)'),
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
			'section_id' => 'Section',
			'semester' => 'Semester',
			'year' => 'Year',
			'component' => 'Component',
			'color_id' => 'Color',
			'class_id' => 'Class',
			'location' => 'Location',
			'professor' => 'Professor',
			'cover_blob_id' => 'Cover Blob',
			'dp_blob_id' => 'Dp Blob',
			'syllabus_id' => 'Syllabus',
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
		$criteria->compare('section_id',$this->section_id,true);
		$criteria->compare('semester',$this->semester,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('component',$this->component,true);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('professor',$this->professor);
		$criteria->compare('cover_blob_id',$this->cover_blob_id,true);
		$criteria->compare('dp_blob_id',$this->dp_blob_id,true);
		$criteria->compare('syllabus_id',$this->syllabus_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseSemester the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
