<?php

/**
 * This is the model class for table "courses_user".
 *
 * The followings are the available columns in table 'courses_user':
 * @property string $class_id
 * @property integer $user_id
 * @property integer $color_id
 * @property integer $is_admin
 * @property integer $sync_events
 * @property integer $notifications
 */
class CourseUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'courses_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class_id, user_id', 'required'),
			array('user_id, color_id, is_admin, sync_events, notifications', 'numerical', 'integerOnly'=>true),
			array('class_id', 'length', 'max'=>36),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('class_id, user_id, color_id, is_admin, sync_events, notifications', 'safe', 'on'=>'search'),
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
			'class_id' => 'Class',
			'user_id' => 'User',
			'color_id' => 'Color',
			'is_admin' => 'Is Admin',
			'sync_events' => 'Sync Events',
			'notifications' => 'Notifications',
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

		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('is_admin',$this->is_admin);
		$criteria->compare('sync_events',$this->sync_events);
		$criteria->compare('notifications',$this->notifications);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
