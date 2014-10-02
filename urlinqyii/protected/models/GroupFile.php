<?php

/**
 * This is the model class for table "groups_files".
 *
 * The followings are the available columns in table 'groups_files':
 * @property integer $group_id
 * @property string $file_id
 * @property integer $user_id
 * @property string $file_description
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property User $user
 * @property FileUpload $file
 */
class GroupFile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, file_id, user_id', 'required'),
			array('group_id, user_id', 'numerical', 'integerOnly'=>true),
			array('file_id', 'length', 'max'=>20),
			array('file_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, file_id, user_id, file_description', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'file' => array(self::BELONGS_TO, 'FileUpload', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'file_id' => 'File',
			'user_id' => 'User',
			'file_description' => 'File Description',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('file_description',$this->file_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
