<?php

/**
 * This is the model class for table "university".
 *
 * The followings are the available columns in table 'university':
 * @property integer $univ_id
 * @property integer $parent_univ_id
 * @property string $univ_name
 * @property string $univ_location
 * @property string $univ_desc
 * @property string $fb_link
 * @property string $twitter_link
 * @property string $alias
 * @property string $weblink
 * @property string $dp_blob_id
 * @property string $cover_blob_id
 *
 * The followings are the available model relations:
 * @property Courses[] $courses
 * @property Department[] $departments
 * @property Groups[] $groups
 * @property UnivSemester[] $univSemesters
 * @property ParentUniversity $parentUniv
 * @property DisplayPicture $dpBlob
 * @property DisplayPicture $coverBlob
 * @property UniversityCover[] $universityCovers
 */
class School extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'university';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_univ_id, univ_name, univ_location', 'required'),
			array('parent_univ_id', 'numerical', 'integerOnly'=>true),
			array('univ_name, univ_location', 'length', 'max'=>255),
			array('fb_link, twitter_link', 'length', 'max'=>400),
			array('alias', 'length', 'max'=>20),
			array('weblink', 'length', 'max'=>50),
			array('dp_blob_id, cover_blob_id', 'length', 'max'=>64),
			array('univ_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('univ_id, parent_univ_id, univ_name, univ_location, univ_desc, fb_link, twitter_link, alias, weblink, dp_blob_id, cover_blob_id', 'safe', 'on'=>'search'),
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
			'courses' => array(self::HAS_MANY, 'Courses', 'univ_id'),
			'departments' => array(self::HAS_MANY, 'Department', 'univ_id'),
			'groups' => array(self::HAS_MANY, 'Groups', 'univ_id'),
			'univSemesters' => array(self::HAS_MANY, 'UnivSemester', 'univ_id'),
			'parentUniv' => array(self::BELONGS_TO, 'ParentUniversity', 'parent_univ_id'),
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'coverBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'cover_blob_id'),
			'universityCovers' => array(self::HAS_MANY, 'UniversityCover', 'univ_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'univ_id' => 'Univ',
			'parent_univ_id' => 'Parent Univ',
			'univ_name' => 'Univ Name',
			'univ_location' => 'Address of the university',
			'univ_desc' => 'Univ Desc',
			'fb_link' => 'Fb Link',
			'twitter_link' => 'Twitter Link',
			'alias' => 'Alias',
			'weblink' => 'Weblink',
			'dp_blob_id' => 'display_picture img_id',
			'cover_blob_id' => 'display_picture img_id',
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

		$criteria->compare('univ_id',$this->univ_id);
		$criteria->compare('parent_univ_id',$this->parent_univ_id);
		$criteria->compare('univ_name',$this->univ_name,true);
		$criteria->compare('univ_location',$this->univ_location,true);
		$criteria->compare('univ_desc',$this->univ_desc,true);
		$criteria->compare('fb_link',$this->fb_link,true);
		$criteria->compare('twitter_link',$this->twitter_link,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('weblink',$this->weblink,true);
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
	 * @return School the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
