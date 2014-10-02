<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $dept_id
 * @property integer $univ_id
 * @property string $dept_name
 * @property string $dept_desc
 * @property string $dept_location
 * @property string $alias
 * @property string $dp_blob_id
 * @property string $cover_blob_id
 *
 * The followings are the available model relations:
 * @property Courses[] $courses
 * @property CoursesSemester[] $coursesSemesters
 * @property CoursesSemester[] $coursesSemesters1
 * @property University $univ
 * @property DisplayPicture $dpBlob
 * @property DisplayPicture $coverBlob
 * @property DepartmentFollow[] $departmentFollows
 */
class Department extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('univ_id, dept_name', 'required'),
			array('univ_id', 'numerical', 'integerOnly'=>true),
			array('dept_name', 'length', 'max'=>255),
			array('alias', 'length', 'max'=>20),
			array('dp_blob_id, cover_blob_id', 'length', 'max'=>64),
			array('dept_desc, dept_location', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dept_id, univ_id, dept_name, dept_desc, dept_location, alias, dp_blob_id, cover_blob_id', 'safe', 'on'=>'search'),
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
			'courses' => array(self::HAS_MANY, 'Courses', 'dept_id'),
			'coursesSemesters' => array(self::HAS_MANY, 'CoursesSemester', 'dept_id'),
			'coursesSemesters1' => array(self::HAS_MANY, 'CoursesSemester', 'univ_id'),
			'univ' => array(self::BELONGS_TO, 'University', 'univ_id'),
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'coverBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'cover_blob_id'),
			'departmentFollows' => array(self::HAS_MANY, 'DepartmentFollow', 'dept_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dept_id' => 'Dept',
			'univ_id' => 'Univ',
			'dept_name' => 'Dept Name',
			'dept_desc' => 'Dept Desc',
			'dept_location' => 'Dept Location',
			'alias' => 'Alias',
			'dp_blob_id' => 'Dp Blob',
			'cover_blob_id' => 'Cover Blob',
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

		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('univ_id',$this->univ_id);
		$criteria->compare('dept_name',$this->dept_name,true);
		$criteria->compare('dept_desc',$this->dept_desc,true);
		$criteria->compare('dept_location',$this->dept_location,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('dp_blob_id',$this->dp_blob_id,true);
		$criteria->compare('cover_blob_id',$this->cover_blob_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
