<?php

/**
 * This is the model class for table "discussion_table".
 *
 * The followings are the available columns in table 'discussion_table':
 * @property integer $event_id
 * @property integer $disc_id
 * @property integer $type
 * @property string $time_added
 * @property integer $user_id
 * @property string $comment
 */
class DiscussionTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'discussion_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, type, time_added, user_id, comment', 'required'),
			array('event_id, type, user_id', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_id, disc_id, type, time_added, user_id, comment', 'safe', 'on'=>'search'),
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
			'event_id' => 'Event',
			'disc_id' => 'Disc',
			'type' => 'Type',
			'time_added' => 'Time Added',
			'user_id' => 'User',
			'comment' => 'Comment',
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

		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('disc_id',$this->disc_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('time_added',$this->time_added,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DiscussionTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
