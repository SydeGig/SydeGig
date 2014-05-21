<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function validateNewUser() {
        $connection = Yii::app()->db;

        $credentialsQuery = "select * from Permissions";

        $users = $connection->createCommand($credentialsQuery)->queryAll();

        // additional password validation
        // name validation
        // email address verification
        
        $sessionUser = "empty";

        foreach ($users as $user) {
            /* If there is no user already registered with this email */
            if ($user['email'] !== $this->username) {
                $sessionUser = $user;
            } else {
                $sessionUser = "already taken";
            }
        }
        if ($sessionUser !== "already taken") {
            $this->errorCode = self::ERROR_NONE;
        } else
            $this->errorCode = self::ERROR_USERNAME_INVALID;

      
        return !$this->errorCode;
    }

    public function authenticate() {
        $connection = Yii::app()->db;

        $credentialsQuery = "select * from Permissions";

        $users = $connection->createCommand($credentialsQuery)->queryAll();


        $sessionUser = "blank";

        foreach ($users as $user) {
            if ($user['email'] == $this->username && password_verify($user['password'],password_hash($user['password'],PASSWORD_DEFAULT))) {
                $sessionUser = $user;
            }
        }


        if ($sessionUser !== "blank") {
            $this->errorCode = self::ERROR_NONE;
            /* fix to include incorrect username error */
        } else
            $this->errorCode = self::ERROR_PASSWORD_INVALID;


        return !$this->errorCode;
    }

}
