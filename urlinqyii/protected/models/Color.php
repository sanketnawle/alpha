<?php

/**
 * This is the model class for table "color".
 *
 * The followings are the available columns in table 'color':
 * @property integer $color_id
 * @property integer $red_code
 * @property integer $green_code
 * @property integer $blue_code
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property ClassUser[] $classUsers
 * @property Group[] $groups
 */
class Color extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'color';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('red_code, green_code, blue_code', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('color_id, red_code, green_code, blue_code', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'color_id'),
			'classUsers' => array(self::HAS_MANY, 'ClassUser', 'color_id'),
			'groups' => array(self::HAS_MANY, 'Group', 'color_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'color_id' => 'Color',
			'red_code' => 'Red Code',
			'green_code' => 'Green Code',
			'blue_code' => 'Blue Code',
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

		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('red_code',$this->red_code);
		$criteria->compare('green_code',$this->green_code);
		$criteria->compare('blue_code',$this->blue_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Color the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
