<?php

require_once('regdb2.php');


if(isset($_POST['email']))
{
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = $_POST['message'];
	
	if (!empty($name) || !empty($email) || !empty($phone) || !empty($message)) 
	{
		
		 $SELECT = "SELECT email From register Where email = ? Limit 1";
		 $INSERT = "INSERT Into register (name, email, phone, message) values(?, ?, ?, ?)";
		 //Prepare statement
		 $stmt = $conn->prepare($SELECT);
	
		 $stmt->bind_param("s", $email);
		 
		 $stmt->execute();
		 
		 $stmt->bind_result($email);
		 $stmt->store_result();
		 $rnum = $stmt->num_rows;
		/* if($_POST['email'] != '')
		{
        // The email to validate
        $email = $_POST['email'];

        // An optional sender
        function domain_exists($email, $record = 'MX'){
            list($user, $domain) = explode('@', $email);
            return checkdnsrr($domain, $record);
        }
        if(domain_exists($email)) {
            echo('This MX records exists; I will accept this email as valid.');
        }
        else {
            echo('No MX record exists;  Invalid email.');
        }
    }*/
		 if ($rnum==0) {
		  $stmt->close();
		  $stmt = $conn->prepare($INSERT);
		  $stmt->bind_param("ssis", $name, $email, $phone, $message);
		  $stmt->execute();
		  echo "New record inserted sucessfully";
		 } 
		 else 
		 {
		  echo "Someone already register using this email";
		 }
		 $stmt->close();
		 $conn->close();
	} 
	else 
	{
	 echo "All field are required";
	 die();
	}

	
}


?>