<?php

/**
 * This is the model class for table "professor_attribute".
 *
 * The followings are the available columns in table 'professor_attribute':
 * @property integer $professor_id
 * @property string $designation
 * @property string $office_location
 * @property string $office_hours
 * @property string $website
 *
 * The followings are the available model relations:
 * @property User $professor
 */
class ProfessorAttribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'professor_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('professor_id', 'required'),
			array('professor_id', 'numerical', 'integerOnly'=>true),
			array('designation, office_hours', 'length', 'max'=>100),
			array('office_location', 'length', 'max'=>60),
			array('website', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('professor_id, designation, office_location, office_hours, website', 'safe', 'on'=>'search'),
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
			'professor' => array(self::BELONGS_TO, 'User', 'professor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'professor_id' => 'refers to user_id in user table',
			'designation' => 'Designation',
			'office_location' => 'Office Location',
			'office_hours' => 'CSV (format: day = starttime:endtime)',
			'website' => 'Website',
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

		$criteria->compare('professor_id',$this->professor_id);
		$criteria->compare('designation',$this->designation,true);
		$criteria->compare('office_location',$this->office_location,true);
		$criteria->compare('office_hours',$this->office_hours,true);
		$criteria->compare('website',$this->website,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfessorAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
