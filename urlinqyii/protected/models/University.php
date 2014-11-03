<?php

/**
 * This is the model class for table "university".
 *
 * The followings are the available columns in table 'university':
 * @property integer $university_id
 * @property string $university_name
 * @property string $university_location
 * @property string $alias
 * @property string $website_url
 * @property integer $picture_file_id
 * @property integer $cover_file_id
 * @property string $fb_link
 *
 * The followings are the available model relations:
 * @property School[] $schools
 * @property File $coverFile
 * @property File $pictureFile
 */
class University extends CActiveRecord
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
			array('university_name, university_location', 'required'),
			array('picture_file_id, cover_file_id', 'numerical', 'integerOnly'=>true),
			array('university_name, university_location, fb_link', 'length', 'max'=>255),
			array('alias', 'length', 'max'=>20),
			array('website_url', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('university_id, university_name, university_location, alias, website_url, picture_file_id, cover_file_id, fb_link', 'safe', 'on'=>'search'),
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
			'schools' => array(self::HAS_MANY, 'School', 'university_id'),
			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'university_id' => 'University',
			'university_name' => 'University Name',
			'university_location' => 'University Location',
			'alias' => 'Alias',
			'website_url' => 'Website Url',
			'picture_file_id' => 'Picture File',
			'cover_file_id' => 'Cover File',
			'fb_link' => 'Fb Link',
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

		$criteria->compare('university_id',$this->university_id);
		$criteria->compare('university_name',$this->university_name,true);
		$criteria->compare('university_location',$this->university_location,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('website_url',$this->website_url,true);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('cover_file_id',$this->cover_file_id);
		$criteria->compare('fb_link',$this->fb_link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return University the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
