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
 */
class ClassModel extends CActiveRecord
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'course_id' => 'refers to course(course_id)',
			'dept_id' => 'Refers to department(dept_id)',
			'univ_id' => 'refers to university(univ_id)',
			'section_id' => 'Section',
			'semester' => 'Semester',
			'year' => 'year',
			'component' => 'type of class',
			'color_id' => 'linked to event_color_table color_id',
			'class_id' => 'Has unique key for each class (updated through trigger)',
			'location' => 'Location',
			'professor' => 'due to collected data inconsistency',
			'cover_blob_id' => 'course_cover',
			'dp_blob_id' => 'display picture id',
			'syllabus_id' => 'syylabus from file_upload',
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
	 * @return ClassModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
