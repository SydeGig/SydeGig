<?php
	/*
		GET 
		
		gigs for employee
		gigs for employer
		
		profile information for employee
		profile information for employer 
		
		available gigs for industry (need to implement in tables)
		available gigs for company 
		available gigs for location 
		available gigs for industury in location
		available gigs for company in inudstury in location 
		
		
	
	
	*/ 
	
	if(isset($_GET['username'])&& isset($_GET['password'])) login(); 
	else {
	$query = "";
	if (isset($_GET['query'])){
		$query = $_GET['query']; 
		if ($query == 'gigsForUser'){
			if (isset($_GET['eid'])){
				$this->renderJSON(getGigsForUser($_GET['eid'])); 
			} else echo "MISSING REQUIRED PARAMETER EID";
		} else if ($query == 'gigsForCompany') {
			if(isset($_GET['industry'])) {
			
			}
			if(isset($_GET['loc'])) {
			
			}
			if(isset($_GET['company'])) {
			} else echo "MISSING REQUIRED PARAMETER COMPANY";
		} else if ($query == 'gigsForIndustry') {
			if(isset($_GET['loc'])) {
			
			}
			if(isset($_GET['industry'])) {
			
			} else echo "MISSING REQUIRED PARAMTER INDUSTURY";
		} else if ($query == 'gigsForLocation') {
		 	if(isset($_GET['loc'])) {
		 
			} else echo "MISSING REQUIRED PARAMETER LOC";
			
		} else echo "MISSING PARAMETER BEING QUERIED";
	} else echo "MISSING QUERY";
		
	}	
	
	
	// Returns JSON Array filled with Gigs that a user has already picked up
	function getGigsForUser($e_id) {
	
	
		$connection = Yii::app()->db;
		$gigsForEmployeeQuery = "select * from gig where employee_id=".$e_id;
		$result = $connection->createCommand($gigsForEmployeeQuery)->queryAll();
		
		$gigs = array(); 
		$i = 0; 
		foreach ($result as $g) {
			$gigs[$i] = $g;
			$i++; 
		}
		
		
		
		return ($gigs);
	}
	
	function login() {
		if (empty($_SERVER['HTTPS'])) {
    			header('Location: http://www.sydegig.com');
    			return "INSECURE REQUEST";
    		} else {
    			if(isset($_GET['username'])){
    				if(isiset($_GET['password'])) {
    					$username = $_GET['username'];
    					$password = $_GET['password']; 
    					
    					$connection = Yii::app()->db;
    					$accountForUserQuery = "select * from Permissions as p and employee as e where p.email = e.email and e.email=".$username." and p.password =".crypt($password,CRYPT_STD_DES);
    					$result = $connection->createCommand($accountForUserQuery)->queryAll(); 
    					
    					if(!isempty($result)) {
    						foreach($result as $res) {
    							echo $this->renderJSON($res);
    						}
    					} else echo "INCORRECT CREDENTIALS";
    				} else echo "MISSING PASSWORD"; 
    			} else echo "MISSING USERNAME";
    		}
    		
    		echo "NULL"; 
	}
			
			
		






?>
