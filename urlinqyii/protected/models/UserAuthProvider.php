<?php

/**
 * This is the model class for table "user_auth_provider".
 *
 * The followings are the available columns in table 'user_auth_provider':
 * @property string $user_id
 * @property string $auth_key
 * @property string $auth_provider
 * @property string $fb_email
 */
class UserAuthProvider extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_auth_provider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, auth_key, fb_email', 'required'),
			array('user_id, auth_key', 'length', 'max'=>255),
			array('auth_provider', 'length', 'max'=>8),
			array('fb_email', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, auth_key, auth_provider, fb_email', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'auth_key' => 'Auth Key',
			'auth_provider' => 'Auth Provider',
			'fb_email' => 'Fb Email',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('auth_key',$this->auth_key,true);
		$criteria->compare('auth_provider',$this->auth_provider,true);
		$criteria->compare('fb_email',$this->fb_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAuthProvider the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
