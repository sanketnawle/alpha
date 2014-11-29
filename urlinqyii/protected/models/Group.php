<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $group_id
 * @property integer $school_id
 * @property integer $group_name
 * @property integer $group_desc
 * @property integer $color_id
 * @property string $contact_email
 * @property string $website
 * @property string $founded_on
 * @property integer $picture_file_id
 * @property integer $cover_file_id
 *
 * The followings are the available model relations:
 * @property File $coverFile
 * @property School $school
 * @property Color $color
 * @property File $pictureFile
 * @property GroupFile $groupFile
 * @property GroupUser[] $groupUsers
 * @property GroupUserTag[] $groupUserTags
 */
class Group extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('school_id, group_name, group_desc', 'required'),
			array('school_id, group_name, group_desc, color_id, picture_file_id, cover_file_id', 'numerical', 'integerOnly'=>true),
			array('contact_email, website', 'length', 'max'=>100),
			array('founded_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, school_id, group_name, group_desc, color_id, contact_email, website, founded_on, picture_file_id, cover_file_id', 'safe', 'on'=>'search'),
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
			'coverFile' => array(self::BELONGS_TO, 'File', 'cover_file_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'color' => array(self::BELONGS_TO, 'Color', 'color_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'groupFile' => array(self::HAS_ONE, 'GroupFile', 'group_id'),

            //Gets all users, admins AND members
            'users' => array(self::MANY_MANY, 'User', 'group_user(group_id, user_id)'),

            //Only gets users that are admins
            'admins' => array(self::MANY_MANY, 'User', 'group_user(group_id, user_id)', 'condition'=>'is_admin = 1'),


            //Only gets non admin users
            'members' => array(self::MANY_MANY, 'User', 'group_user(group_id, user_id)', 'condition'=>'is_admin = 0'),

            'files' => array(self::MANY_MANY, 'File', 'group_file(group_id, file_id)'),

            'events' => array(self::HAS_MANY,'Event',array('origin_id'=>'group_id'),'condition'=>'origin_type = "group"'),
			'groupUserTags' => array(self::HAS_MANY, 'GroupUserTag', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'school_id' => 'School',
			'group_name' => 'Group Name',
			'group_desc' => 'Group Desc',
			'color_id' => 'Color',
			'contact_email' => 'Contact Email',
			'website' => 'Website',
			'founded_on' => 'Founded On',
			'picture_file_id' => 'Picture File',
			'cover_file_id' => 'Cover File',
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
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('group_name',$this->group_name);
		$criteria->compare('group_desc',$this->group_desc);
		$criteria->compare('color_id',$this->color_id);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('founded_on',$this->founded_on,true);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('cover_file_id',$this->cover_file_id);

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
