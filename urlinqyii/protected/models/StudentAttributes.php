<?php

/**
 * This is the model class for table "student_attributes".
 *
 * The followings are the available columns in table 'student_attributes':
 * @property integer $user_id
 * @property string $website
 * @property string $major
 * @property integer $year
 * @property integer $degree_type_id
 * @property string $student_type
 * @property string $minor
 * @property string $year_name
 *
 * The followings are the available model relations:
 * @property User $user
 */
class StudentAttributes extends CActiveRecord
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
			array('user_id, degree_type_id', 'required'),
			array('user_id, year, degree_type_id', 'numerical', 'integerOnly'=>true),
			array('website, major, minor', 'length', 'max'=>255),
			array('student_type, year_name', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, website, major, year, degree_type_id, student_type, minor, year_name', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'refers to user_id in user table',
			'website' => 'Website',
			'major' => 'Major',
			'year' => 'year of grad',
			'degree_type_id' => 'Degree Type',
			'student_type' => 'Student Type',
			'minor' => 'Minor',
			'year_name' => 'freshman, sophomore, junior, senior, ms, or phd',
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
		$criteria->compare('degree_type_id',$this->degree_type_id);
		$criteria->compare('student_type',$this->student_type,true);
		$criteria->compare('minor',$this->minor,true);
		$criteria->compare('year_name',$this->year_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentAttributes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
