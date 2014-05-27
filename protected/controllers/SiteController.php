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
    
    public function actionAvailableGigs() {
        $this->render("availableGigs");
    }

    public function actionAvailable() {
        $this->render("available");
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
                $newGig->employer_id = $connection->createCommand("select eid e from employer where email='".$JobPostForm['username']."'")->queryRow()['e'];

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

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
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
                $newPermissions->password = password_hash($BusinessSignupForm['password'], PASSWORD_DEFAULT);
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
                $this->renderPartial('HomePage');
            }
        } else {
            $this->render('businessSignup', array('model' => $model));
        } 
    }
    
    public function actionSignup() {


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
                $newPermissions->password = password_hash($SignupForm['password'], PASSWORD_DEFAULT);
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
                $this->renderPartial('HomePage');
            }
        } else {
            $this->render('signup', array('model' => $model));
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
