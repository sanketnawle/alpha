<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $post_id
 * @property integer $user_id
 * @property string $origin_type
 * @property integer $origin_id
 * @property string $post_type
 * @property string $text
 * @property string $sub_text
 * @property integer $file_id
 * @property string $privacy
 * @property integer $anon
 * @property integer $like_count
 * @property string $last_activity
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property File $file
 * @property User $user
 * @property User[] $users
 * @property User[] $users1
 * @property PostQuestion $postQuestion
 * @property PostQuestionOption[] $postQuestionOptions
 * @property User[] $users2
 * @property Reply[] $replies
 */
class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_type, text, privacy, created_at', 'required'),
			array('user_id, origin_id, file_id, anon, like_count', 'numerical', 'integerOnly'=>true),
			array('origin_type', 'length', 'max'=>30),
			array('post_type', 'length', 'max'=>10),
			array('sub_text, last_activity', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('post_id, user_id, origin_type, origin_id, post_type, text, sub_text, file_id, privacy, anon, like_count, last_activity, created_at', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'users' => array(self::MANY_MANY, 'User', 'post_user_inv(post_id, user_id)'),
			'users1' => array(self::MANY_MANY, 'User', 'post_hide(post_id, user_id)'),
			'postQuestion' => array(self::HAS_ONE, 'PostQuestion', 'post_id'),
			'postQuestionOptions' => array(self::HAS_MANY, 'PostQuestionOption', 'post_id'),
			'users2' => array(self::MANY_MANY, 'User', 'post_report(post_id, user_id)'),
			'replies' => array(self::HAS_MANY, 'Reply', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => 'Post',
			'user_id' => 'User',
			'origin_type' => 'Origin Type',
			'origin_id' => 'Origin',
			'post_type' => 'Post Type',
			'text' => 'Text',
			'sub_text' => 'Sub Text',
			'file_id' => 'File',
			'privacy' => 'Privacy',
			'anon' => 'Anon',
			'like_count' => 'Like Count',
			'last_activity' => 'Last Activity',
			'created_at' => 'Created At',
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

		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('origin_type',$this->origin_type,true);
		$criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('post_type',$this->post_type,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sub_text',$this->sub_text,true);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('privacy',$this->privacy,true);
		$criteria->compare('anon',$this->anon);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
