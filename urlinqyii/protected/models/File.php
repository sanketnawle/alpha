<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $file_id
 * @property string $file_name
 * @property string $file_url
 * @property string $file_type
 * @property string $file_extension
 * @property string $created_timestamp
 * @property string $origin_type
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Class[] $classes1
 * @property Class[] $classes2
 * @property Course[] $courses
 * @property Department[] $departments
 * @property Department[] $departments1
 * @property Event[] $events
 * @property Group[] $groups
 * @property Group[] $groups1
 * @property GroupFile[] $groupFiles
 * @property Post[] $posts
 * @property Reply[] $replies
 * @property School[] $schools
 * @property School[] $schools1
 * @property User[] $users
 * @property Theme[] $themes
 * @property University[] $universities
 * @property University[] $universities1
 * @property User[] $users1
 */
class File extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_name, file_url, created_timestamp', 'required'),
			array('file_name, file_type', 'length', 'max'=>255),
            array('original_name, file_type', 'length', 'max'=>255),
			array('file_url', 'length', 'max'=>512),
			array('file_extension', 'length', 'max'=>20),
			array('origin_type', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('file_id, file_name, original_name, file_url, file_type, file_extension, created_timestamp, origin_type', 'safe', 'on'=>'search'),

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
			'classes' => array(self::HAS_MANY, 'Class', 'picture_file_id'),
			'classes1' => array(self::HAS_MANY, 'Class', 'cover_file_id'),
			'classes2' => array(self::MANY_MANY, 'Class', 'class_file(file_id, class_id)'),
			'courses' => array(self::HAS_MANY, 'Course', 'picture_file_id'),
			'departments' => array(self::HAS_MANY, 'Department', 'cover_file_id'),
			'departments1' => array(self::HAS_MANY, 'Department', 'picture_file_id'),
			'events' => array(self::HAS_MANY, 'Event', 'file_id'),
			'groups' => array(self::HAS_MANY, 'Group', 'cover_file_id'),
			'groups1' => array(self::HAS_MANY, 'Group', 'picture_file_id'),
			'groupFiles' => array(self::HAS_MANY, 'GroupFile', 'file_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'file_id'),
			'replies' => array(self::HAS_MANY, 'Reply', 'file_id'),
			'schools' => array(self::HAS_MANY, 'School', 'cover_file_id'),
			'schools1' => array(self::HAS_MANY, 'School', 'picture_file_id'),
			'users' => array(self::MANY_MANY, 'User', 'showcase(file_id, user_id)'),
			'themes' => array(self::HAS_MANY, 'Theme', 'picture_file_id'),
			'universities' => array(self::HAS_MANY, 'University', 'cover_file_id'),
			'universities1' => array(self::HAS_MANY, 'University', 'picture_file_id'),
			'users1' => array(self::HAS_MANY, 'User', 'picture_file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'file_name' => 'File Name',
            'original_name' => 'Original Name',
			'file_url' => 'File Url',
			'file_type' => 'File Type',
			'file_extension' => 'File Extension',
			'created_timestamp' => 'Created Timestamp',
			'origin_type' => 'Origin Type',
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

		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_url',$this->file_url,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('file_extension',$this->file_extension,true);
		$criteria->compare('created_timestamp',$this->created_timestamp,true);
		$criteria->compare('origin_type',$this->origin_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return File the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
