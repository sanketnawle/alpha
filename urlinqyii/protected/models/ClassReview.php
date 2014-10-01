<?php

/**
 * This is the model class for table "class_review".
 *
 * The followings are the available columns in table 'class_review':
 * @property integer $review_id
 * @property integer $user_id
 * @property string $class_id
 * @property integer $anonymous
 * @property string $review
 * @property integer $agree
 * @property integer $disagree
 * @property string $timestamp
 */
class ClassReview extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'class_review';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, class_id, anonymous, timestamp', 'required'),
			array('user_id, anonymous, agree, disagree', 'numerical', 'integerOnly'=>true),
			array('class_id', 'length', 'max'=>36),
			array('review', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('review_id, user_id, class_id, anonymous, review, agree, disagree, timestamp', 'safe', 'on'=>'search'),
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
			'review_id' => 'Review',
			'user_id' => 'User',
			'class_id' => 'Class',
			'anonymous' => 'Anonymous',
			'review' => 'Review',
			'agree' => 'Agree',
			'disagree' => 'Disagree',
			'timestamp' => 'Timestamp',
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

		$criteria->compare('review_id',$this->review_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('anonymous',$this->anonymous);
		$criteria->compare('review',$this->review,true);
		$criteria->compare('agree',$this->agree);
		$criteria->compare('disagree',$this->disagree);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassReview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
