<?php

/**
 * SingupForm class.
 * Signup is the data structure for keeping
 * user signup form data. It is used by the 'Signup' action of 'SiteController'.
 */
class SignupForm extends CFormModel
{
	public $username;
	public $password;
        public $fname;
        public $lname; 
        public $e_id; 
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be added to the database.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, fname, lname', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Checks the credentials for errors and attempts to validate the username
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->validateNewUser())
				$this->addError('password','Incorrect username or password.');
                                echo "password not correct";
		}
	}

	/**
	 * Checks to see if the username is already take and attempts to 
         * log in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function signup()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
