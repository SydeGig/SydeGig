<?php 

$GLOBALS['token'] = 'nothing'; 
define ('database','sydegigc_testdb');
define ('dbuser','sydegigc_webuser');
define ('sqlpass','H337w337$');


mysql_connect('localhost', dbuser, sqlpass) or die('Could not connect: ' . mysql_error());
 
# Choose a database
mysql_select_db(database) or die('Could not select database');
 
# Perform database query
$query = "SELECT max(e_id) from employee";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

 $employeeID = "";
# Filter through rows and echo desired information
while ($row = mysql_fetch_object($result)) {
      $employeeID = $row->{'max(e_id)'};
}

$employeeID++;
    
   
define('employeeID',$employeeID);
define('API_KEY',      '77ulqr7mklrx4t'                                          );
define('API_SECRET',   'Ru9RwFv4CP2FI4S6'                                       );
define('REDIRECT_URI', 'http://www.sydegig.com/LinkedIn.php');
define('SCOPE',        'r_fullprofile'                        );
 
// You'll probably use a database
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
 
// Congratulations! You have a valid token. Now fetch your profile 



$user = fetch('GET', '/v1/people/~:(email-address,firstName,lastName,positions,headline)');


define('firstName' , $user->{'firstName'}); 
define('lastName' , $user->{'lastName'}); 
define('headline' ,$user->{'headline'});
$positons = $user->{'positions'}->{'values'};
define('email', $user->{'emailaddress'});

mysql_connect('localhost', dbuser, sqlpass) or die('Could not connect: ' . mysql_error());
 
# Choose a database
mysql_select_db(database) or die('Could not select database');

$query = "insert into employee(`e_id`,`email`,`fname`,`lname`) VALUES(".employeeID.",'".rand()."'".",'".firstName."','".lastName."')";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());



ob_start(); // ensures anything dumped out will be caught

// do stuff here
$url = 'http://sydegig.com/index.php/site/confirmation'; // this can be set based on whatever

// clear out the output buffer
while (ob_get_status()) 
{
    ob_end_clean();
}

// no redirect
header( "Location: $url" );

 



// Begin Function Definitions
 
function getAuthorizationCode() {
       $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scope' => SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
   
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
	

     $params = array('grant_type' => 'authorization_code',
       		    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                  
              );
     
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
    
   
     
    // Tell streams to make a POST request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => 'POST',
                        )
                    )
                );
                
       
              
 
    // Retrieve access token information
    $response = file_get_contents($url);
  
   
    // Native PHP object, please
    $token = json_decode($response);
    $GLOBALS['token'] = $token->access_token; 

    mysql_connect('localhost', dbuser, sqlpass) or die('Could not connect: ' . mysql_error());
 
        # Choose a database
     mysql_select_db(database) or die('Could not select database');

    if($GLOBALS['token'] !== 'nothing' && empty($GLOBALS['token']) == false){
    	
    	
        $query = "INSERT into Tokens(`e_id`,`token`) VALUES(".employeeID.",'".$GLOBALS['token']."')";
    
        mysql_query($query) or die('Query failed: ' . mysql_error());
        
    } else {
    	var_dump("url ".$url."<br>");
    	var_dump("token".$response."<br>");
    	var_dump("Unable to grant access"); 
    	exit; 
    }
    
   
   
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    
    
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
    
    
    return true;
}
 
function fetch($method, $resource, $body = '') {


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