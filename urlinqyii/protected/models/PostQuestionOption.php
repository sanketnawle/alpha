<?php

/**
 * This is the model class for table "post_question_option".
 *
 * The followings are the available columns in table 'post_question_option':
 * @property integer $option_id
 * @property integer $post_id
 * @property string $option_text
 *
 * The followings are the available model relations:
 * @property PostQuestionOptionAnswer $postQuestionOptionAnswer
 */
class PostQuestionOption extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post_question_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id, option_text', 'required'),
			array('post_id', 'numerical', 'integerOnly'=>true),
			array('option_text', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('option_id, post_id, option_text', 'safe', 'on'=>'search'),
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
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'postQuestionOptionAnswer' => array(self::HAS_ONE, 'PostQuestionOptionAnswer', 'option_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'option_id' => 'Option',
			'post_id' => 'Post',
			'option_text' => 'Option Text',
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

		$criteria->compare('option_id',$this->option_id);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('option_text',$this->option_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PostQuestionOption the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
