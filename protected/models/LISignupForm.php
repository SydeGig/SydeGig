<?php

/**
 * LISingupForm class.
 * Signup is the data structure for keeping
 * user signup form data. It is used by the 'Signup' action of 'SiteController'.
 */
class LISignupForm extends CFormModel {

    public $password;
    private $_identity;
    public $username; 

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be added to the database.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }


    /**
     * Checks the credentials for errors and attempts to validate the username
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        $connection = Yii::app()->db;
        $calculateE_ID = "select email from employee where e_id = (select max(e_id) maximum from employee)";
        $this->username = $connection->createCommand($calculateE_ID)->queryRow();
      
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->validateNewUser()) {
                $this->addError('username', 'Username Taken.');
              
            } else {
                // do we need this?
            }
        }
    }

    /**
     * Checks to see if the username is already take and attempts to 
     * log in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function LIsignup() {
        echo "signup";
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            //$this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

}
