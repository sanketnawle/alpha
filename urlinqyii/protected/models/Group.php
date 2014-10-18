<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property integer $group_id
 * @property integer $univ_id
 * @property string $group_name
 * @property string $group_desc
 * @property integer $color_id
 * @property string $contact_email
 * @property string $website
 * @property string $founded_on
 * @property string $dp_blob_id
 * @property string $cover_blob_id
 *
 * The followings are the available model relations:
 * @property GroupEvent[] $groupEvents
 * @property User[] $users
 * @property University $univ
 * @property DisplayPicture $dpBlob
 * @property DisplayPicture $coverBlob
 * @property EventColorTable $color
 * @property GroupsFiles[] $groupsFiles
 */
class Group extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('univ_id, group_name, group_desc', 'required'),
			array('univ_id, color_id', 'numerical', 'integerOnly'=>true),
			array('group_name', 'length', 'max'=>255),
			array('group_desc', 'length', 'max'=>500),
			array('contact_email, website', 'length', 'max'=>100),
			array('dp_blob_id, cover_blob_id', 'length', 'max'=>64),
			array('founded_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, univ_id, group_name, group_desc, color_id, contact_email, website, founded_on, dp_blob_id, cover_blob_id', 'safe', 'on'=>'search'),
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
			'events' => array(self::HAS_MANY, 'GroupEvent', 'group_id'),
			'users' => array(self::MANY_MANY, 'User', 'group_users(group_id, user_id)'),
			'univ' => array(self::BELONGS_TO, 'University', 'univ_id'),
			'dpBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'dp_blob_id'),
			'coverBlob' => array(self::BELONGS_TO, 'DisplayPicture', 'cover_blob_id'),
			'color' => array(self::BELONGS_TO, 'EventColorTable', 'color_id'),
			'groupsFiles' => array(self::HAS_MANY, 'GroupsFiles', 'group_id'),
            'admins' => array(self::HAS_MANY,'User',array('user_id'=>'id'),'through'=>'group_users')

//            'invites' => array(self::HAS_MANY, Invite, '', 'on'=>'invite.origin_type = group')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'univ_id' => 'Univ',
			'group_name' => 'Group Name',
			'group_desc' => 'Group Desc',
			'color_id' => 'Color',
			'contact_email' => 'Contact Email',
			'website' => 'Website',
			'founded_on' => 'Founded On',
			'dp_blob_id' => 'Dp Blob',
			'cover_blob_id' => 'Cover Blob',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('univ_id',$this->univ_id);
		$criteria->compare('group_name',$this->group_name,true);
		$criteria->compare('group_desc',$this->group_desc,true);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('founded_on',$this->founded_on,true);
		$criteria->compare('dp_blob_id',$this->dp_blob_id,true);
		$criteria->compare('cover_blob_id',$this->cover_blob_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
