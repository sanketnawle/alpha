<?php

/**
 * This is the model class for table "student_attribs".
 *
 * The followings are the available columns in table 'student_attribs':
 * @property integer $user_id
 * @property string $website
 * @property string $major
 * @property integer $year
 * @property string $student_type
 * @property string $minor
 */
class StudentAttrib extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'student_attributes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, year', 'numerical', 'integerOnly'=>true),
			array('website, major, minor', 'length', 'max'=>255),
			array('student_type', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, website, major, year, student_type, minor', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'website' => 'Website',
			'major' => 'Major',
			'year' => 'Year',
			'student_type' => 'Student Type',
			'minor' => 'Minor',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('major',$this->major,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('student_type',$this->student_type,true);
		$criteria->compare('minor',$this->minor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentAttrib the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
