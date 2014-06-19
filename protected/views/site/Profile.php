<?php 

$GLOBALS['token'] = 'nothing'; 
$GLOBALS['months'] = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
define ('database','sydegigc_testdb');
define ('dbuser','sydegigc_webuser');
define ('sqlpass','H337w337$');

 
/*

define('API_KEY',      '77ulqr7mklrx4t'                                          );
define('API_SECRET',   'Ru9RwFv4CP2FI4S6'                                       );
define('REDIRECT_URI', 'http://www.sydegig.com/LinkedIn.php');
define('SCOPE',        'r_fullprofile'                        );
 
session_name('linkedin');
session_start();
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
*/
 // Congratulations! You have a valid token. Now fetch your profile 



$user = fetch('GET', '/v1/people/~:(email-address,firstName,lastName,positions,headline)');


define('firstName' , $user->{'firstName'}); 
define('lastName' , $user->{'lastName'}); 
define('headline' ,$user->{'headline'});
$positions = objectToArray($user->{'positions'}->{'values'});
$GLOBALS['positions'] = $positions; 
define('email', $user->{'emailaddress'});




// Begin Function Definitions
 
 function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

     
function getAccessToken() {
	


    mysql_connect('localhost', dbuser, sqlpass) or die('Could not connect: ' . mysql_error());
 
        # Choose a database
     mysql_select_db(database) or die('Could not select database');

    
    	
    	
        $query = "select token from Tokens where e_id= (select e_id from employee where email='".Yii::app()->user->id."')";
    	
    
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
 
    	
   	while ($row = mysql_fetch_object($result)) {
   
      		$GLOBALS['token'] =  $row->{'token'};
	}

   
 /*
    
    $_SESSION['access_token'] = $token->access_token;  
    $_SESSION['expires_in']   = $token->expires_in; 
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in'];
    */
    
    return true;
}
 
function fetch($method, $resource, $body = '') {
	getAccessToken(); 

    $params = array('oauth2_access_token' => $GLOBALS['token'],
                    'format' => 'json',
              );
     
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
    
   
    

    // Native PHP object, please
    return json_decode($response);
}




?>

<!- Begin HTML -->
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
                <a href="/index.php/site/HomePage">Home</a>
            </li>
            <li class="active"><a href="/index.php/site/Profile">Profile</a></li>
        </ul>

    </button>
</div>




<div class=site-wrapper>

    <div class=site-wrapper-inner>

        <div class="cover-container">
           
 <div style="height: 50px;">

</div>



            <?php
            print("<h3>".firstName." ".lastName."<br> Current Position: ".headline."</h3><br><h1><strong> Resume </strong></h1><br>");
            $pos = $GLOBALS['positions']; 
            foreach($pos as $p)
            {
            	echo "<p class=lead>".$p['title']." at ";
            	$company = $p['company'];
            	echo $company['name']." from ";
            	$startDate = $p['startDate']; 
            	echo $GLOBALS['months'][$startDate['month']]." ".$startDate['year']." to ";
            	if($p['isCurrent']) echo " Present<br>";
            	else {
            	 $endDate = $p['endDate']; 
            	echo $GLOBALS['months'][$endDate['month']]." ".$endDate['year'].".</p> <br>";
            	} 	
            }
            /*
            // there is definitely a better way to do this
            $connection = Yii::app()->db;
            $employerQuery = "select * from employer";
            $employers = $connection->createCommand($employerQuery)->queryAll();

            $isBuss = false;
            foreach ($employers as $employer) {
                if ($employer['email'] == Yii::app()->user->id) {
                    print(" <div>  <button type=button class=btn btn-default btn-lg>
                    <span class=glyphicon glyphicon-plus></span> <a style=text-decoration: none href= /index.php/site/jobpost><font color=black> Add Gigs </font> </a>
                </button> </div>
                
   <div style=height: 20px;

</div>

                <div> <button type=button class=btn btn-default btn-lg>
                    <span class=glyphicon glyphicon-user></span> <a style=text-decoration: none href= /index.php/site/available><font color=black> View Available Employees </font> </a>
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

                $usersQuery = "select * from gig where employer_id = (select eid from employer where email='" . Yii::app()->user->id . "')";

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
                    <span class=glyphicon glyphicon-user></span> <a style=text-decoration: none href= /index.php/site/availableGigs><font color=black> View Available Gigs </font> </a>
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

                $usersQuery = "select * from gig where employee_id = (select e_id from employee where email='" . Yii::app()->user->id . "')";

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
</table></div>");
            }*/
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