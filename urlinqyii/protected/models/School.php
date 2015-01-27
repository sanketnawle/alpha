<?php

/**
 * This is the model class for table "school".
 *
 * The followings are the available columns in table 'school':
 * @property integer $school_id
 * @property integer $university_id
 * @property string $school_name
 * @property integer $school_location
 * @property string $school_description
 * @property string $fb_link
 * @property integer $twitter_link
 * @property string $alias
 * @property string $weblink
 * @property integer $picture_file_id
 * @property integer $cover_file_id
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Course[] $courses
 * @property Department[] $departments
 * @property Group[] $groups
 * @property File $coverFile
 * @property University $university
 * @property File $pictureFile
 * @property SchoolSemester[] $schoolSemesters
 * @property User[] $users
 */
class School extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'school';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('university_id, school_name, school_location', 'required'),
			array('university_id, school_location, twitter_link, picture_file_id, cover_file_id', 'numerical', 'integerOnly'=>true),
			array('school_name', 'length', 'max'=>255),
			array('school_description', 'length', 'max'=>500),
			array('fb_link', 'length', 'max'=>400),
			array('alias', 'length', 'max'=>20),
			array('weblink', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('school_id, university_id, school_name, school_location, school_description, fb_link, twitter_link, alias, weblink, picture_file_id, cover_file_id', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'school_id'),
			'courses' => array(self::HAS_MANY, 'Course', 'school_id'),
			'departments' => array(self::HAS_MANY, 'Department', 'school_id'),
			'groups' => array(self::HAS_MANY, 'Group', 'school_id'),

            'clubs' => array(self::HAS_MANY,'Group',array('school_id'=>'school_id'),'condition'=>'group_type = "club" and privacy = "0"'),

			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'university' => array(self::BELONGS_TO, 'University', 'university_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'schoolSemesters' => array(self::HAS_MANY, 'SchoolSemester', 'school_id'),
			'users' => array(self::HAS_MANY, 'User', 'school_id'),
            'admins' => array(self::HAS_MANY,'User',array('school_id'=>'school_id'),'condition'=>'user_type = "p" or user_type = "f"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'school_id' => 'School',
			'university_id' => 'University',
			'school_name' => 'School Name',
			'school_location' => 'School Location',
			'school_description' => 'School Description',
			'fb_link' => 'Fb Link',
			'twitter_link' => 'Twitter Link',
			'alias' => 'Alias',
			'weblink' => 'Weblink',
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

		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('university_id',$this->university_id);
		$criteria->compare('school_name',$this->school_name,true);
		$criteria->compare('school_location',$this->school_location);
		$criteria->compare('school_description',$this->school_description,true);
		$criteria->compare('fb_link',$this->fb_link,true);
		$criteria->compare('twitter_link',$this->twitter_link);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('weblink',$this->weblink,true);
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
	 * @return School the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
