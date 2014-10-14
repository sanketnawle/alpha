<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $user_email
 * @property string $user_type
 * @property string $firstname
 * @property string $lastname
 * @property integer $univ_id
 * @property integer $dept_id
 * @property string $user_bio
 * @property string $dp_flag
 * @property string $dp_link
 * @property string $dp_blob
 * @property string $status
 * @property string $gender
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_email, user_type, firstname, univ_id, dept_id', 'required'),
			array('univ_id, dept_id', 'numerical', 'integerOnly'=>true),
			array('user_email', 'length', 'max'=>255),
			array('user_type, gender', 'length', 'max'=>1),
			array('firstname, lastname', 'length', 'max'=>100),
			array('dp_flag', 'length', 'max'=>4),
			array('dp_link', 'length', 'max'=>512),
			array('dp_blob', 'length', 'max'=>64),
			array('status', 'length', 'max'=>8),
			array('user_bio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_email, user_type, firstname, lastname, univ_id, dept_id, user_bio, dp_flag, dp_link, dp_blob, status, gender', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.


        //courses user
		return array(
            'courses' => array(self::MANY_MANY, 'Course', 'courses_user(class_id, user_id)'),


            //'courses' => array(self::HAS_MANY, 'CourseUser', 'user_id'),

            //'modelbs' => array(self::HAS_MANY, 'Model_B', 'ModelB_Id', 'through'=>'modelabs'),

            //'courses' => array(self::HAS_MANY, 'Course', 'class_id', 'through'=>'CourseUser'),


            //'classes' => array(self::HAS_MANY, 'Course', array('id'=>'user_id'), 'through'=>'CourseUser')

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_email' => 'User Email',
			'user_type' => 's or p or a',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'univ_id' => 'Univ',
			'dept_id' => 'Dept',
			'user_bio' => 'User Bio',
			'dp_flag' => 'Dp Flag',
			'dp_link' => 'Dp Link',
			'dp_blob' => 'Dp Blob',
			'status' => 'Status',
			'gender' => 'Gender',
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
	public function search(){
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_type',$this->user_type,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('univ_id',$this->univ_id);
		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('user_bio',$this->user_bio,true);
		$criteria->compare('dp_flag',$this->dp_flag,true);
		$criteria->compare('dp_link',$this->dp_link,true);
		$criteria->compare('dp_blob',$this->dp_blob,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('gender',$this->gender,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
