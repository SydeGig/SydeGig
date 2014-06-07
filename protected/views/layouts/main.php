<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <!-- For Bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap-3.1.1-dist/css/bootstrap.min.css" media="screen, projection" />
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <?php Yii::app()->bootstrap->register(); ?>
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">SydeGig</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($this->getPageTitle() == "SydeGig")
                            print ("<li class=active><a href=" . Yii::app()->request->baseUrl . ">Home</a></li>");
                        else
                            print ("<li><a href=" . Yii::app()->request->baseUrl . ">Home</a></li>");
                        if ($this->getPageTitle() != "SydeGig - Login" && !Yii::app()->user->id)
                            print("<li><a href=" . Yii::app()->request->baseUrl . "/index.php/site/login>Login</a></li>");
                        else if (!Yii::app()->user->id)
                            print ("<li class = active><a href=" . Yii::app()->request->baseUrl . "/index.php/site/login>Login</a></li>");
                        if (Yii::app()->user->id)
                            print("<li ><a href=" . Yii::app()->request->baseUrl . "/index.php/site/logout>Logout</a></li>");
                        if (Yii::app()->user->id && ($this->getPageTitle() == "SydeGig - Login Site" || $this->getPageTitle() == "SydeGig - HomePage Site"))
                            print (" <li class = active><a href=" . Yii::app()->request->baseUrl . "/index.php/site/HomePage>HomePage</a></li>");
                        else if (Yii::app()->user->id)
                            print (" <li><a href=" . Yii::app()->request->baseUrl . "/index.php/site/HomePage>HomePage</a></li>");
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">SydeGig Options <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if (Yii::app()->user->id) print(" <li><a href=mailto:niyi%40sydegig.com?subject=Contact%20Us>Contact Us</a></li>"); ?>
                                <?php if (Yii::app()->user->id) print(" <li><a href=" . Yii::app()->request->baseUrl . "/index.php/site/HomePage>HomePage</a></li>"); ?>
                                <li class="divider"></li>
                                <li class="dropdown-header">Quick Nav</li>
                                <li><a href="http://www.google.com">Google</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div align = "center">
            <div style="margin-top: 30pt;">
                <?php echo $content ?> 
            </div>  
        </div>
    </body>
</html>


