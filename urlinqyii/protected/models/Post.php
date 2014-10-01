<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property string $post_id
 * @property integer $user_id
 * @property string $target_type
 * @property string $target_id
 * @property integer $target_univ_id
 * @property string $post_type
 * @property string $text_msg
 * @property string $sub_text
 * @property string $file_id
 * @property string $file_share_type
 * @property string $privacy
 * @property integer $anon
 * @property integer $like_count
 * @property string $last_activity
 * @property string $update_timestamp
 *
 * The followings are the available model relations:
 * @property User $user
 * @property PostsQuestions[] $postsQuestions
 * @property User[] $users
 */
class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, target_univ_id, text_msg, update_timestamp', 'required'),
			array('user_id, target_univ_id, anon, like_count', 'numerical', 'integerOnly'=>true),
			array('target_type', 'length', 'max'=>25),
			array('target_id', 'length', 'max'=>36),
			array('post_type', 'length', 'max'=>8),
			array('file_id', 'length', 'max'=>40),
			array('file_share_type', 'length', 'max'=>7),
			array('privacy', 'length', 'max'=>11),
			array('sub_text, last_activity', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('post_id, user_id, target_type, target_id, target_univ_id, post_type, text_msg, sub_text, file_id, file_share_type, privacy, anon, like_count, last_activity, update_timestamp', 'safe', 'on'=>'search'),
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
			'postsQuestions' => array(self::HAS_MANY, 'PostsQuestions', 'post_id'),
			'users' => array(self::MANY_MANY, 'User', 'posts_user_inv(post_id, user_id)'),
            //'files' => array(self::HAS_MANY, 'file_upload', 'file_id')
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
			'target_type' => 'Target Type',
			'target_id' => 'Target',
			'target_univ_id' => 'Target Univ',
			'post_type' => 'Post Type',
			'text_msg' => 'Text Msg',
			'sub_text' => 'Sub Text',
			'file_id' => 'File',
			'file_share_type' => 'File Share Type',
			'privacy' => 'Privacy',
			'anon' => 'Anon',
			'like_count' => 'Like Count',
			'last_activity' => 'Last Activity',
			'update_timestamp' => 'Update Timestamp',
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

		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('target_type',$this->target_type,true);
		$criteria->compare('target_id',$this->target_id,true);
		$criteria->compare('target_univ_id',$this->target_univ_id);
		$criteria->compare('post_type',$this->post_type,true);
		$criteria->compare('text_msg',$this->text_msg,true);
		$criteria->compare('sub_text',$this->sub_text,true);
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('file_share_type',$this->file_share_type,true);
		$criteria->compare('privacy',$this->privacy,true);
		$criteria->compare('anon',$this->anon);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('update_timestamp',$this->update_timestamp,true);

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
