<?php
	$send = file_get_contents('php://input');


    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad596/CS490/Back/addQuestion.php");
	curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ajg55/RC/B/getCase.php");
   // curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~jr528/CS490/B/submitQuestion.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $send);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $DBResponse = curl_exec($ch);
	echo $DBResponse;
    curl_close($ch);

?>