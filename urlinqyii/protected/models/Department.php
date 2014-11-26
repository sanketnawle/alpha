<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $department_id
 * @property integer $school_id
 * @property string $department_name
 * @property string $department_description
 * @property string $department_location
 * @property string $alias
 * @property integer $picture_file_id
 * @property integer $cover_file_id
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Course[] $courses
 * @property File $coverFile
 * @property School $school
 * @property File $pictureFile
 * @property User[] $users
 * @property User[] $users1
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
			array('school_id, department_name', 'required'),
			array('school_id, picture_file_id, cover_file_id', 'numerical', 'integerOnly'=>true),
			array('department_name', 'length', 'max'=>255),
			array('alias', 'length', 'max'=>20),
			array('department_description, department_location', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('department_id, school_id, department_name, department_description, department_location, alias, picture_file_id, cover_file_id', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'department_id'),
			'courses' => array(self::HAS_MANY, 'Course', 'department_id'),
			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'members' => array(self::MANY_MANY, 'User', 'user(user_id,department_id)'),
            'admins' => array(self::HAS_MANY,'User',array('department_id'=>'department_id'),'condition'=>'user_type = "p"'),


			'users1' => array(self::HAS_MANY, 'User', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'department_id' => 'Department',
			'school_id' => 'School',
			'department_name' => 'Department Name',
			'department_description' => 'Department Description',
			'department_location' => 'Department Location',
			'alias' => 'Alias',
			'picture_file_id' => 'Picture File',
			'cover_file_id' => 'Cover File',
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

		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('department_name',$this->department_name,true);
		$criteria->compare('department_description',$this->department_description,true);
		$criteria->compare('department_location',$this->department_location,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('cover_file_id',$this->cover_file_id);

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
