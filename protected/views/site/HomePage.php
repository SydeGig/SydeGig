


<!DOCTYPE html>
<html lang=en>
  <head>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap-3.1.1-dist/css/bootstrap.min.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap-3.1.1-dist/css/cover.css" media="screen, projection" />
 </head>


    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content=IE=edge>
    <meta name=viewport content=width=device-width, initial-scale=1>
    <meta name=description content=>
    <meta name=author content=>
    <link rel=shortcut icon href=../../assets/ico/favicon.ico>

    <title>Cover Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    

    <!-- Just for debugging purposes. Dont actually copy this line! -->
    <!--[if lt IE 9]><script src=../../assets/js/ie8-responsive-file-warning.js></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src=https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js></script>
      <script src=https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js></script>
    <![endif]-->
  </head>

  <body>

    <div class=site-wrapper>

      <div class=site-wrapper-inner>

          <div class="cover-container">



          <div class=inner cover>
            <h1 class=cover-heading>Welcome to SydeGig <?php 
            
            echo Yii::app()->user->id;
         
       
       
            
            ?>!</h1>
            <p class=lead>Next Level Skill Sharing</p>
            <p class=lead>
              <a href=mailto:sam%40sydegig.com?subject=Mailing%20List class=btn btn-lg btn-default>Contact Us</a>
            </p>
          </div>
              
              <!-- Need to validate user type -->
              <button type="button" class="btn btn-default btn-lg">
                  <span class="glyphicon glyphicon-plus"></span> <a href= "/google.com"><font color="black"> Add Gigs </font> </a>
</button>
              
                 <button type="button" class="btn btn-default btn-lg">
                  <span class="glyphicon glyphicon-user"></span> <a href= "/google.com"><font color="black"> View Available Employees </font> </a>
</button>

          <div class=mastfoot>
            <div class=inner>
              <p>Cover template for <a href=http://getbootstrap.com>Bootstrap</a>, by <a href=https://twitter.com/mdo>@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js></script>
    <script src=../../dist/js/bootstrap.min.js></script>
    <script src=../../assets/js/docs.min.js></script>
  </body>
</html>   


