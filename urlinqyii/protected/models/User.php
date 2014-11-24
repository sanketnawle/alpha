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
 * @property integer $department_id
 * @property integer $school_id
 * @property string $user_bio
 * @property integer $picture_file_id
 * @property string $status
 * @property string $gender
 * @property integer $available
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Class[] $classes1
 * @property Class[] $classes2
 * @property ClassReview[] $classReviews
 * @property ClassReview[] $classReviews1
 * @property ClassUser[] $classUsers
 * @property Course[] $courses
 * @property Department[] $departments
 * @property Event[] $events
 * @property GroupFile[] $groupFiles
 * @property GroupUser[] $groupUsers
 * @property Invite[] $invites
 * @property Notification[] $notifications
 * @property Notification[] $notifications1
 * @property Post[] $posts
 * @property Post[] $posts1
 * @property Post[] $posts2
 * @property PostQuestionOptionAnswer[] $postQuestionOptionAnswers
 * @property PostUserInv[] $postUserInvs
 * @property ProfessorAttribute $professorAttribute
 * @property Reply[] $replies
 * @property Reply[] $replies1
 * @property File[] $files
 * @property StudentAttributes $studentAttributes
 * @property File $pictureFile
 * @property Department $department
 * @property School $school
 * @property UserAuthProvider[] $userAuthProviders
 * @property UserConfirmation $userConfirmation
 * @property UserConnection[] $userConnections
 * @property UserConnection[] $userConnections1
 * @property UserLogin $userLogin
 * @property UserLoginAttempt $userLoginAttempt
 * @property UserOnboard $userOnboard
 * @property UserRecovery[] $userRecoveries
 * @property UserTag[] $userTags
 * @property UserToken[] $userTokens
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
			array('user_email, user_type, firstname', 'required'),
			array('department_id, school_id, picture_file_id, available', 'numerical', 'integerOnly'=>true),
			array('user_email', 'length', 'max'=>255),
			array('user_type, gender', 'length', 'max'=>1),
			array('firstname, lastname', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			array('user_bio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_email, user_type, firstname, lastname, department_id, school_id, user_bio, picture_file_id, status, gender, available', 'safe', 'on'=>'search'),
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
//			'classes' => array(self::HAS_MANY, 'ClassModel', 'professor'),
//			'classes1' => array(self::MANY_MANY, 'ClassModel', 'class_bookmark(user_id, class_id)'),
//			'classes2' => array(self::MANY_MANY, 'ClassModel', 'class_rating(user_id, class_id)'),
			'classReviews' => array(self::HAS_MANY, 'ClassReview', 'user_id'),
			'classReviews1' => array(self::MANY_MANY, 'ClassReview', 'class_review_vote(user_id, review_id)'),
			'classUsers' => array(self::HAS_MANY, 'ClassUser', 'user_id'),
			'courses' => array(self::MANY_MANY, 'Course', 'course_follow(user_id, course_id)'),
			'departments' => array(self::MANY_MANY, 'Department', 'department_follow(user_id, department_id)'),
			'events' => array(self::HAS_MANY, 'Event', 'user_id'),
			'groupFiles' => array(self::HAS_MANY, 'GroupFile', 'user_id'),
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'user_id'),
			'invites' => array(self::HAS_MANY, 'Invite', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notification', 'actor_id'),
			'notifications1' => array(self::HAS_MANY, 'Notification', 'user_id'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_report(user_id, post_id)'),
			'posts1' => array(self::MANY_MANY, 'Post', 'post_custom_user(user_id, post_id)'),
			'posts2' => array(self::MANY_MANY, 'Post', 'post_like(user_id, post_id)'),
			'postQuestionOptionAnswers' => array(self::HAS_MANY, 'PostQuestionOptionAnswer', 'user_id'),
			'postUserInvs' => array(self::HAS_MANY, 'PostUserInv', 'user_id'),
			'professorAttribute' => array(self::HAS_ONE, 'ProfessorAttribute', 'professor_id'),
			'replies' => array(self::HAS_MANY, 'Reply', 'user_id'),
			'replies1' => array(self::MANY_MANY, 'Reply', 'reply_vote(user_id, reply_id)'),
			'studentAttributes' => array(self::HAS_ONE, 'StudentAttrib', 'user_id'),
			'pictureFile' => array(self::BELONGS_TO, 'File', 'picture_file_id'),
			'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'school' => array(self::BELONGS_TO, 'School', 'school_id'),
			'userAuthProviders' => array(self::HAS_MANY, 'UserAuthProvider', 'user_id'),
			'userConfirmation' => array(self::HAS_ONE, 'UserConfirmation', 'user_id'),
			'userConnections' => array(self::HAS_MANY, 'UserConnection', 'to_user_id'),
			'userConnections1' => array(self::HAS_MANY, 'UserConnection', 'from_user_id'),
			'userLogin' => array(self::HAS_ONE, 'UserLogin', 'user_id'),
			'userLoginAttempt' => array(self::HAS_ONE, 'UserLoginAttempt', 'user_id'),
			'userOnboard' => array(self::HAS_ONE, 'UserOnboard', 'user_id'),
			'userRecoveries' => array(self::HAS_MANY, 'UserRecovery', 'user_id'),
			'userTags' => array(self::HAS_MANY, 'UserTag', 'user_id'),
			'token' => array(self::HAS_ONE, 'UserToken', 'user_id'),

            //added by Michael
            'groups' => array(self::MANY_MANY, 'Group', 'group_user(user_id,group_id)'),

            'classes' => array(self::MANY_MANY, 'ClassModel', 'class_user(user_id, class_id)'),

            'usersFollowed' => array(self::MANY_MANY, 'User', 'user_connection(from_user_id, to_user_id)'),
            'usersFollowing' => array(self::MANY_MANY, 'User', 'user_connection(to_user_id, from_user_id)'),
            'userInterests' => array(self::MANY_MANY, 'Tag', 'user_interest(user_id, tag_id)'),

            'showcase' => array(self::HAS_MANY, 'Showcase', 'user_id'),
            'showcase_files' => array(self::HAS_MANY, 'File', 'file_id','through'=>'showcase','order'=>'created_timestamp'),
            'majors' => array(self::MANY_MANY, 'Major', 'user_major(user_id, id)'),
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
			'department_id' => 'Department',
			'school_id' => 'School',
			'user_bio' => 'User Bio',
			'picture_file_id' => 'Picture File',
			'status' => 'Status',
			'gender' => 'Gender',
			'available' => 'Available',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_type',$this->user_type,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('user_bio',$this->user_bio,true);
		$criteria->compare('picture_file_id',$this->picture_file_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('available',$this->available);

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

    public function isFollowing($otherUser){
        foreach($this->usersFollowed as $userFollowed){
            if($userFollowed->user_id == $otherUser->user_id){
                return true;
            }
        }
        return false;
    }
}
