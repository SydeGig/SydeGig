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
<div class="malcolm">
    <div class="padding" padding-top:10px>
        <ul class="nav nav-tabs">
            <li>
                <a href="/SydeGig/index.php/site/HomePage">Home</a>
            </li>
            <li class="active"><a href="/SydeGig/index.php/site/profile">Profile</a></li>
        </ul>

    </button>
</div>




<div class=site-wrapper>

    <div class=site-wrapper-inner>

        <div class="cover-container">
           
 <div style="height: 50px;">

</div>



            <?php
            // there is definitely a better way to do this
            $connection = Yii::app()->db;
            $employerQuery = "select * from employer";
            $employers = $connection->createCommand($employerQuery)->queryAll();

            $isBuss = false;
            foreach ($employers as $employer) {
                if ($employer['email'] == Yii::app()->user->id) {
                    print(" <div>  <button type=button class=btn btn-default btn-lg>
                    <span class=glyphicon glyphicon-plus></span> <a style=text-decoration: none href= /SydeGig/index.php/site/jobpost><font color=black> Add Gigs </font> </a>
                </button> </div>
                
   <div style=height: 20px;

</div>

                <div> <button type=button class=btn btn-default btn-lg>
                    <span class=glyphicon glyphicon-user></span> <a style=text-decoration: none href= /SydeGig/index.php/site/available><font color=black> View Available Employees </font> </a>
                </button></div>");
                    $isBuss = true;


                    break;
                }
            }

            if ($isBuss) {
                print("<div class=center>
                        <lead> Taken Gigs </lead>
                            <table class=table table-bordered table-hover width= 647>
    <thead>
        <tr class=warning>
            <th>#</th>
            <th>Job Title</th>

        </tr>
    </thead>
    <tbody>");
                $incrementor = 1;

                $connection = Yii::app()->db;

                $usersQuery = "select * from Gig where employer_id = (select eid from employer where email='" . Yii::app()->user->id . "')";

                $users = $connection->createCommand($usersQuery)->queryAll();



                foreach ($users as $user) {

                    print(" <tr>
                       <td>" . $incrementor . "</td>
                       <td>" . $user['title'] . " </td>");


                    $incrementor++;
                }
                print("
        </tr>
        <tr>

    </tbody>
</table> </div>");

                print("<div class=center>
                        <lead> Posted Gigs </lead>
                            <table class=table table-bordered table-hover width= 647>
    <thead>
        <tr class=warning>
            <th>#</th>
            <th>Job Title</th>

        </tr>
    </thead>
    <tbody>");
                $incrementor = 1;

                $connection = Yii::app()->db;

                $usersQuery = "select * from PostedGigs where employer_id  = (select eid from employer where email='" . Yii::app()->user->id . "')";

                $users = $connection->createCommand($usersQuery)->queryAll();



                foreach ($users as $user) {

                    print(" <tr>
                       <td>" . $incrementor . "</td>
                       <td>" . $user['title'] . " </td>");


                    $incrementor++;
                }
                print("
        </tr>
        <tr>

    </tbody>
</table> </div>");
            }

            if (!$isBuss) {
                print("<button type=button class=btn btn-default btn-lg>
                    <span class=glyphicon glyphicon-user></span> <a style=text-decoration: none href= /SydeGig/index.php/site/availableGigs><font color=black> View Available Gigs </font> </a>
                </button>");


                print("
                    


                    <div class=center style=margin-top:50px;>
                       
                            <table class=table table-bordered table-hover width= 647>
    <thead>
        <tr class=warning>
            <th>#</th>
            <th>Job Title</th>
            <th>Company</th>
        </tr>
    </thead>
    <tbody>");
                $incrementor = 1;

                $connection = Yii::app()->db;

                $usersQuery = "select * from Gig where employee_id = (select e_id from employee where email='" . Yii::app()->user->id . "')";

                $users = $connection->createCommand($usersQuery)->queryAll();



                foreach ($users as $user) {

                    print(" <tr>
                       <td>" . $incrementor . "</td>
                       <td>" . $user['title'] . " </td>");
                    $info = $connection->createCommand("select name n from employer where eid=" . $user['employer_id'])->queryRow();


                    print("<td>" . $info['n'] . "</td> </tr>");

                    $incrementor++;
                }
                print("
        </tr>
        <tr>

    </tbody>
</table> </div>");
            }
            ?>




            <div class=container>
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