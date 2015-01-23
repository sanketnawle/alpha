<?php

/**
 * This is the model class for table "display_picture".
 *
 * The followings are the available columns in table 'display_picture':
 * @property string $img_id
 * @property string $img_name
 * @property string $img_content
 * @property string $img_type
 *
 * The followings are the available model relations:
 * @property Courses[] $courses
 * @property CoursesSemester[] $coursesSemesters
 * @property CoursesSemester[] $coursesSemesters1
 * @property Department[] $departments
 * @property Department[] $departments1
 * @property Groups[] $groups
 * @property Groups[] $groups1
 * @property ParentUniversity[] $parentUniversities
 * @property ParentUniversity[] $parentUniversities1
 * @property University[] $universities
 * @property University[] $universities1
 * @property User[] $users
 */
class DisplayPicture extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'display_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('img_name, img_content, img_type', 'required'),
			array('img_name', 'length', 'max'=>64),
			array('img_type', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('img_id, img_name, img_content, img_type', 'safe', 'on'=>'search'),
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
			'courses' => array(self::HAS_MANY, 'Courses', 'dp_blob_id'),
			'coursesSemesters' => array(self::HAS_MANY, 'CoursesSemester', 'cover_blob_id'),
			'coursesSemesters1' => array(self::HAS_MANY, 'CoursesSemester', 'dp_blob_id'),
			'departments' => array(self::HAS_MANY, 'Department', 'dp_blob_id'),
			'departments1' => array(self::HAS_MANY, 'Department', 'cover_blob_id'),
			'groups' => array(self::HAS_MANY, 'Groups', 'dp_blob_id'),
			'groups1' => array(self::HAS_MANY, 'Groups', 'cover_blob_id'),
			'parentUniversities' => array(self::HAS_MANY, 'ParentUniversity', 'dp_blob_id'),
			'parentUniversities1' => array(self::HAS_MANY, 'ParentUniversity', 'cover_blob_id'),
			'universities' => array(self::HAS_MANY, 'University', 'dp_blob_id'),
			'universities1' => array(self::HAS_MANY, 'University', 'cover_blob_id'),
			'users' => array(self::HAS_MANY, 'User', 'dp_blob'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'img_id' => 'Img',
			'img_name' => 'Img Name',
			'img_content' => 'Img Content',
			'img_type' => 'Img Type',
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

		$criteria->compare('img_id',$this->img_id,true);
		$criteria->compare('img_name',$this->img_name,true);
		$criteria->compare('img_content',$this->img_content,true);
		$criteria->compare('img_type',$this->img_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DisplayPicture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
