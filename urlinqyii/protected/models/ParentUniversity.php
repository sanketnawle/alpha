<?php

/**
 * This is the model class for table "parent_university".
 *
 * The followings are the available columns in table 'parent_university':
 * @property integer $parent_univ_id
 * @property string $parent_univ_name
 * @property string $parent_univ_location
 * @property string $alias
 * @property string $weblink
 * @property string $dp_blob_id
 * @property string $cover_blob_id
 *
 * The followings are the available model relations:
 * @property DisplayPicture $dpBlob
 * @property DisplayPicture $coverBlob
 * @property University[] $universities
 */
class ParentUniversity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'parent_university';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_univ_name, parent_univ_location', 'required'),
			array('parent_univ_name, parent_univ_location, weblink', 'length', 'max'=>255),
			array('alias', 'length', 'max'=>20),
			array('dp_blob_id, cover_blob_id', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('parent_univ_id, parent_univ_name, parent_univ_location, alias, weblink, dp_blob_id, cover_blob_id', 'safe', 'on'=>'search'),
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
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'coverBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'cover_blob_id'),
			'universities' => array(self::HAS_MANY, 'University', 'parent_univ_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'parent_univ_id' => 'Parent Univ',
			'parent_univ_name' => 'Parent Univ Name',
			'parent_univ_location' => 'Parent Univ Location',
			'alias' => 'Alias',
			'weblink' => 'Weblink',
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

		$criteria->compare('parent_univ_id',$this->parent_univ_id);
		$criteria->compare('parent_univ_name',$this->parent_univ_name,true);
		$criteria->compare('parent_univ_location',$this->parent_univ_location,true);
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
	 * @return ParentUniversity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
