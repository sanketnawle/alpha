<?php

/**
 * This is the model class for table "file_upload".
 *
 * The followings are the available columns in table 'file_upload':
 * @property string $file_id
 * @property string $file_name
 * @property string $file_content
 * @property string $file_type
 * @property string $created_timestamp
 *
 * The followings are the available model relations:
 * @property CourseEvent[] $courseEvents
 * @property CoursesSemester[] $coursesSemesters
 * @property CoursesSemester[] $coursesSemesters1
 * @property GroupEvent[] $groupEvents
 * @property GroupsFiles[] $groupsFiles
 * @property PersonalEvent[] $personalEvents
 * @property Reply[] $replies
 */
class FileUpload extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file_upload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_name, file_content, created_timestamp', 'required'),
			array('file_name, file_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('file_id, file_name, file_content, file_type, created_timestamp', 'safe', 'on'=>'search'),
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
			'courseEvents' => array(self::HAS_MANY, 'CourseEvent', 'file_id'),
			'coursesSemesters' => array(self::MANY_MANY, 'CoursesSemester', 'course_files(file_id, class_id)'),
			'coursesSemesters1' => array(self::HAS_MANY, 'CoursesSemester', 'syllabus_id'),
			'groupEvents' => array(self::HAS_MANY, 'GroupEvent', 'file_id'),
			'groupsFiles' => array(self::HAS_MANY, 'GroupsFiles', 'file_id'),
			'personalEvents' => array(self::HAS_MANY, 'PersonalEvent', 'file_id'),
			'replies' => array(self::HAS_MANY, 'Reply', 'file_id'),
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
			'file_content' => 'File Content',
			'file_type' => 'File Type',
			'created_timestamp' => 'Created Timestamp',
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

		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_content',$this->file_content,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('created_timestamp',$this->created_timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FileUpload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
