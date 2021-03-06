<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
// They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    
    public function actionAPI() {
    	$this->render('api');
    }

    // from http://stackoverflow.com/questions/2824805/how-to-get-response-as-json-formatapplication-json-in-yii
    public function renderJSON($data) {

        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public function actionHomePage() {
        $this->render("HomePage");
        echo $this->renderJSON(array('Malcolm' => 1, 'Test' => 2));
    }

    public function actionProfile() {
        $this->render("Profile");
    }

    public function actionPickupGig() {
        $this->render('pickupGig');
        if (isset($_GET['gig'])) {

            $pgid = $_GET['gig'];

            $connection = Yii::app()->db;

            $postedGigsQuery = "select * from PostedGigs";

            $postedGigs = $connection->createCommand($postedGigsQuery)->queryAll();

            foreach ($postedGigs as $gig) {
                if ($gig['pgid'] == $pgid) {

                    $newGig = new Gig();
                    // combine commands
                    $titleInfo = $connection->createCommand("select title t from PostedGigs where pgid=" . $pgid)->queryRow();
                    $newGig->title = $titleInfo['t'];
                    $eid = $connection->createCommand("select e_id e from employee where email='" . Yii::app()->user->id . "'")->queryRow();
                    $newGig->employee_id = $eid['e'];
                    $employer = $connection->createCommand("select employer_id e from PostedGigs where pgid=" . $pgid)->queryRow();
                    $newGig->employer_id = $employer['e'];
                    $calculateG_ID = "select max(gid) maximum from Gig";
                    $maxE_ID = $connection->createCommand($calculateG_ID)->queryRow();
                    $gig_id = $maxE_ID['maximum'];
                    $gig_id++;
                    $newGig->gid = $gig_id;
                    $newGig->save();
                    $connection->createCommand("delete from PostedGigs where pgid=" . $pgid)->query();
                    $this->render("HomePage");
                }
            }
        } else {
            echo "<lead> Please go back and try again <lead>";
        }
    }

    public function actionAvailableGigs() {
        $this->render("availableGigs");
    }

    public function actionAvailable() {
        $this->render("available");
    }


    public function actionConfirmation() {
    	$this->render('confirmation');
    }
    	
    public function actionJobPost() {
        $model = new JobPostForm;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-post-form') {

            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobPostForm'])) {

            $model->attributes = $_POST['JobPostForm'];
            $JobPostForm = $_POST['JobPostForm'];
// validate user input and redirect to the previous page if valid
            if ($model->validate()) {
                $connection = Yii::app()->db;
                $newGig = new PostedGig();
                // need to find employer_id; 
                $employer = $connection->createCommand("select eid e from employer where email='" . $JobPostForm['username'] . "'")->queryRow();
                $newGig->employer_id = $employer['e'];

//back to employee creations
                $newGig->title = $JobPostForm['title'];
                $connection = Yii::app()->db;
                $calculateE_ID = "select max(pgid) maximum from PostedGigs";
                $maxE_ID = $connection->createCommand($calculateE_ID)->queryRow();
                $emp_id = $maxE_ID['maximum'];
                $emp_id++;
                $newGig->pgid = $emp_id;
                $newGig->save();

                Yii::app()->user->setFlash('success', 'Gig Posted.');
                $this->renderPartial('HomePage');
            }
        } else {
            $this->render('jobpost', array('model' => $model));
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
// renders the view file 'protected/views/site/index.php'
// using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionBusinessSignup() {
        $model = new BusinessSignupForm;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'business-signup-form') {

            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['BusinessSignupForm'])) {

            $model->attributes = $_POST['BusinessSignupForm'];
            $BusinessSignupForm = $_POST['BusinessSignupForm'];
// validate user input and redirect to the previous page if valid
            if ($model->validate()) {

                $newEmployer = new Employer();

                $newEmployer->email = $BusinessSignupForm['username'];
// Permissions
                $newPermissions = new Permissions();
                $newPermissions->email = $newEmployer->email;
                $newPermissions->password = crypt($BusinessSignupForm['password'], CRYPT_STD_DES);
                $newPermissions->save();
//back to employee creations
                $newEmployer->name = $BusinessSignupForm['businessName'];
                $newEmployer->industry = $BusinessSignupForm['industry'];
                $connection = Yii::app()->db;
                $calculateE_ID = "select max(eid) maximum from employer";
                $maxE_ID = $connection->createCommand($calculateE_ID)->queryRow();
                $emp_id = $maxE_ID['maximum'];
                $emp_id++;
                $newEmployer->eid = $emp_id;
                $newEmployer->save();

                Yii::app()->user->setFlash('signup', 'Thank you for signing up.');
                $this->rende('HomePage');
            }
        } else {
            $this->render('businessSignup', array('model' => $model));
        }
    }
    
    public function actionLISignup(){
        $this->render('LinkedInFetcher');
    }

    public function actionSignup() {
        if (isset($_GET['code'])) {
            $model = new LISignupForm();
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'LIsignup-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['LISignupForm'])) {
                $model->attributes = $_POST['LISignupForm'];
                $SignupForm = $_POST['LISignupForm'];
// validate user input and redirect to the previous page if valid
                if ($model->validate()) {
                    $newPermissions = new Permissions();
                    $newPermissions->email = $SignupForm['username'];
                    $newPermissions->password = crypt($SignupForm['password'], CRYPT_STD_DES);
                    
                    $connection = Yii::app()->db;
                    $calculateE_ID = "select max(e_id) from employee";
                    $maxID = $connection->createCommand($calculateE_ID)->queryRow();
                    
                    $query = "UPDATE employee
				SET email='".$newPermissions->email."', 
				WHERE e_id=".$maxID;
                
                    $newPermissions->save();
                    Yii::app()->user->setFlash('signup', 'Thank you for signing up.');
                    $this->render('HomePage');
                } else {
                    $this->render('LIsignup', array('model' => $model));
                }
            } else {
                $this->render('LIsignup', array('model' => $model));
            }
        } else {
            $model = new SignupForm;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'signup-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['SignupForm'])) {
                $model->attributes = $_POST['SignupForm'];
                $SignupForm = $_POST['SignupForm'];
// validate user input and redirect to the previous page if valid
                if ($model->validate()) {

                    $newEmployee = new Employee();
                    $newEmployee->email = $SignupForm['username'];
// Permissions
                    $newPermissions = new Permissions();
                    $newPermissions->email = $newEmployee->email;
                    $newPermissions->password = crypt($SignupForm['password'], CRYPT_STD_DES);
                    $newPermissions->save();
//back to employee creations
                    $newEmployee->fname = $SignupForm['fname'];
                    $newEmployee->lname = $SignupForm['lname'];
                    $connection = Yii::app()->db;
                    $calculateE_ID = "select max(e_id) maximum from employee";
                    $maxE_ID = $connection->createCommand($calculateE_ID)->queryRow();
                    $emp_id = $maxE_ID['maximum'];
                    $emp_id++;
                    $newEmployee->e_id = $emp_id;
                    $newEmployee->save();
                    Yii::app()->user->setFlash('signup', 'Thank you for signing up.');
                    $this->render('HomePage');
                } else {
                    $this->render('signup', array('model' => $model));
                }
            } else {
                $this->render('signup', array('model' => $model));
            }
        }
    }

// display the signup form

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;
// if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
// collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
// validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->render('HomePage');
            } else {
                $this->render('login', array('model' => $model));
            }
        } else {
            $this->render('login', array('model' => $model));
        }
// display the login form	
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}