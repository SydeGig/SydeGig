<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;

if (isset($_GET['code'])) {
    $this->actionSignup();
}
?>

<head>
    <style>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap-3.1.1-dist/css/bootstrap.min.css" media="screen, projection" />
    </style>
</head>

<body>





    <div class="jumbotron">


        <h1>Welcome to SydeGig!</h1>



        <div style="margin-top:20px">
            <p class = "lead"> <font face=""HelveticaNeue-Light">
                                     SydeGig is a skillsharing site that will be launching in a few months to 
                                     revolutionize how you find work. </font>  </p>

            <a href="<?php echo Yii::app()->baseUrl; ?>/LinkedIn.php"><img src="./linkedin_button.png"></a>


            <div class ="container">



            </div>



        </div>




    </div>



</body>



