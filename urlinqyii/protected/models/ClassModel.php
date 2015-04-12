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
 * @property integer $public
 * @property integer $member_privacy
 * @property string $semester
 * @property string $year
 * @property string $component
 * @property integer $color_id
 * @property string $location
 * @property integer $professor_id
 * @property integer $cover_file_id
 * @property integer $picture_file_id
 * @property string $syllabus_id
 * @property string $class_name
 * @property string $class_datetime
 * @property string $class_professor_firstname
 * @property string $class_professor_lastname
 *
 * The followings are the available model relations:
 * @property Course $course
 * @property Department $department
 * @property School $school
 * @property Color $color
 * @property File $coverFile
 * @property File $pictureFile
 * @property User $professor
 * @property User[] $users
 * @property ClassFile[] $classFiles
 * @property ClassReview[] $classReviews
 * @property Schedule[] $schedules
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



     //Returns professor model object
    public function professor(){
        if($this->professor_id){
            $professor = User::model()->find('user_id=:id', array(':id'=>$this->professor_id));
            if($professor){
                return $professor;
            }
        }


        foreach($this->admins as $admin){
            if($admin->user_type == 'p'){
                return $admin;
            }
        }
        return null;
    }
    //Returns files uploaded by the professor or other admin
    public function classFiles(){
        $class_files = array();
        $class_file_objects = ClassFile::model()->findAllBySql('SELECT * FROM `class_file` WHERE class_id=' . $this->class_id);
        foreach($class_file_objects as $class_file_object){
            $class_user_object = ClassUser::model()->findBySql("SELECT * FROM `class_user` WHERE class_id=" . $this->class_id . " AND user_id=" . $class_file_object->user_id);
            $user_type = $class_user_object->is_admin;
            if($user_type == '1'){
                array_push($class_files,$class_file_object->file);
            }
        }
        return $class_files;
    }
    //Returns files uploaded by the professor or other admin
    public function studentFiles(){
        $student_files = array();
        $student_file_objects = ClassFile::model()->findAllBySql('SELECT * FROM `class_file` WHERE class_id=' . $this->class_id);
        foreach($student_file_objects as $student_file_object){
            $class_user_object = ClassUser::model()->findBySql('SELECT * FROM `class_user` WHERE class_id=' . $this->class_id . ' AND user_id=' . $student_file_object->user_id);
            $user_type = $class_user_object->is_admin;
            if($user_type == '0'){
                array_push($student_files,$student_file_object->file);
            }
        }
        return $student_files;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, department_id, school_id, section_id, year, class_name', 'required'),
			array('course_id, department_id, school_id, public, member_privacy, color_id, professor_id, cover_file_id, picture_file_id', 'numerical', 'integerOnly'=>true),
			array('section_id, syllabus_id', 'length', 'max'=>20),
			array('semester', 'length', 'max'=>6),
			array('year', 'length', 'max'=>4),
			array('component', 'length', 'max'=>200),
			array('location', 'length', 'max'=>100),
			array('class_name, class_datetime', 'length', 'max'=>50),
			array('class_professor_firstname', 'length', 'max'=>30),
			array('class_professor_lastname', 'length', 'max'=>40),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('class_id, course_id, department_id, school_id, section_id, public, member_privacy, semester, year, component, color_id, location, professor_id, cover_file_id, picture_file_id, syllabus_id, class_name, class_datetime, class_professor_firstname, class_professor_lastname', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
			'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'color' => array(self::BELONGS_TO, 'Color', 'color_id'),
			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'professor' => array(self::BELONGS_TO, 'User', 'professor_id'),
			'users' => array(self::MANY_MANY, 'User', 'class_user(class_id, user_id)'),
			'classFiles' => array(self::HAS_MANY, 'ClassFile', 'class_id'),
			'classReviews' => array(self::HAS_MANY, 'ClassReview', 'class_id'),
			'schedules' => array(self::MANY_MANY, 'Schedule', 'class_schedule(class_id, schedule_id)'),
            'students' => array(self::MANY_MANY, 'User', 'class_user(class_id, user_id)', 'on'=>'is_admin=0'),
            'admins' => array(self::MANY_MANY, 'User', 'class_user(class_id, user_id)', 'on'=>'is_admin=1'),
            'files' => array(self::MANY_MANY, 'File', 'class_file(class_id, file_id)'),

            'events' => array(self::HAS_MANY,'Event',array('origin_id'=>'class_id'),'condition'=>'origin_type = "class"'),

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
			'public' => 'True - Anyone can join the class. False - only people who were invited or had their request accepted can join',
			'member_privacy' => 'False - Everyone can see the members of the class. True - only members can see the other members',
			'semester' => 'Semester',
			'year' => 'year',
			'component' => 'type of class',
			'color_id' => 'linked to event_color_table color_id',
			'location' => 'Location',
			'professor_id' => 'due to collected data inconsistency',
			'cover_file_id' => 'course_cover',
			'picture_file_id' => 'display picture id',
			'syllabus_id' => 'syllabus from file_upload',
			'class_name' => 'Class Name',
			'class_datetime' => 'Holds a string like Wed 2.00 PM - 4.50 PM',
			'class_professor_firstname' => 'Class Professor Firstname',
			'class_professor_lastname' => 'Class Professor Lastname',
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
		$criteria->compare('public',$this->public);
		$criteria->compare('member_privacy',$this->member_privacy);
		$criteria->compare('semester',$this->semester,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('component',$this->component,true);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('professor_id',$this->professor_id);
		$criteria->compare('cover_file_id',$this->cover_file_id);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('syllabus_id',$this->syllabus_id,true);
		$criteria->compare('class_name',$this->class_name,true);
		$criteria->compare('class_datetime',$this->class_datetime,true);
		$criteria->compare('class_professor_firstname',$this->class_professor_firstname,true);
		$criteria->compare('class_professor_lastname',$this->class_professor_lastname,true);

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
