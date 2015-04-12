<?php

/**
 * This is the model class for table "gdrive_share".
 *
 * The followings are the available columns in table 'gdrive_share':
 * @property string $file_id
 * @property string $file_gdrive_id
 * @property string $file_name
 * @property string $file_url
 * @property string $file_type
 */
class GdriveShare extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gdrive_share';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_gdrive_id, file_name, file_url, file_type', 'required'),
			array('file_gdrive_id, file_type', 'length', 'max'=>255),
			array('file_name, file_url', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('file_id, file_gdrive_id, file_name, file_url, file_type', 'safe', 'on'=>'search'),
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
			'file_id' => 'File',
			'file_gdrive_id' => 'File Gdrive',
			'file_name' => 'File Name',
			'file_url' => 'File Url',
			'file_type' => 'File Type',
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
		$criteria->compare('file_gdrive_id',$this->file_gdrive_id,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_url',$this->file_url,true);
		$criteria->compare('file_type',$this->file_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GdriveShare the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
