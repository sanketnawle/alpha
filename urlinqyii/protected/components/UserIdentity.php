<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}


//    public function authenticate()
//    {
//        if(!($user=User::model()->findByAttributes(array('email'=>$this->username))))
//            $this->errorCode=self::ERROR_USERNAME_INVALID;
//        elseif($user->password!==md5($this->password))
//            $this->errorCode=self::ERROR_PASSWORD_INVALID;
//        elseif($user->status==User::INACTIVE)
//            $this->errorCode=self::ERROR_USER_INACTIVE;
//        else
//        {
//            $this->_id=$user->id;
//            $this->setState('roles', $user->role);
//            $this->setState('lastLoginTime', $user->lastLoginTime);
//            $this->errorCode=self::ERROR_NONE;
//
//        }
//        return !$this->errorCode;
//    }

    public function getId()
    {
        return $this->_id;
    }
}