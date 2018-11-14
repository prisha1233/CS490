<?php
//Declaring all flag related to for & while loop
// also passing test case or not 
//  setting up score value for each test case 
$flag = 'fail'; 
$forLoopFlag = 'fail';
$whileLoopFlag = 'fail'; 
$ifFlag = 'fail';
$score = 25;

// question, test case, testCase ans, student ans
// for getting general idea 
$question = "Write a Python function called uniquelist that takes a list and returns a new list with unique elements of the first list.(MUST USE FOR LOOP)";
$ans= "def unique_list(l):
\n\tx = []
\n\tfor a in l:
   \n\t if a not in x:
     \n\tx.append(a)
  \n\treturn x";
$case= "print(unique_list([1,2,3,3,3,3,4,5]))";
$caseAns = "[1, 2, 3, 4, 5]\0";

// always need to add next line after writing studentAns and before adding testCase
$nextLine = "\n";

// checking requirement of FOR OR WHILE loop  
// if yes then check which one 
// if no then create dummyFlag which help us to execute less code
if (preg_match("/(MUST USE FOR LOOP)/", $question) === 1 ){
	$forLoopFlag = 'pass'; 
}
elseif (preg_match("/(MUST USE WHILE LOOP)/", $question) === 1 ){
	$whileLoopFlag = 'pass'; 
} 
elseif (preg_match("/(MUST USE IF LOOP)/", $question) === 1 ){
	$ifFlag = 'pass'; 
} 
else {
	$dummyFlag = 'pass'; 
}

// IN studentAns , for or while word exist or not 
// if not exists, then it deducted 10 points from the score
if ($dummyFlag === 'fail'){
	if ($forLoopFlag ==='pass'){
		if (preg_match ("/for/", $ans) !== 1 ){
			$score -= 10;  
		}
	}
	elseif ($whileLoopFlag ==== 'pass'){
		if (preg_match ("/while/", $ans) !== 1 ){

			$score -= 10; 
		}
	}
	else {
		if (preg_match ("/if/", $ans) !== 1 ){

			$score -= 10; 		
	}
}

// opening py file, add studentAns & case, execute it  and save as aoutput

$wfile = fopen("grader.py", 'w') or die("nope could not connect");

fwrite ($wfile,$ans);
fwrite ($wfile, $nextLine); 
fwrite ($wfile, $case);

fclose ($wfile);


$output = 'python grader.py';
$aoutput = shell_exec($output);

// converting all answers into string if any of them int 
// triming some testCase Ans since it also carries NULL char 
$exec = strval($aoutput);
$caseAnswer = strval (trim ($caseAns));
$length = strlen($caseAnswer);

//echo "$e<br>$f<br>";

// comparing studentAns and caseAns using strncmp 
if (strncmp ($exec, $caseAnswer, $length)===0 ){
	$flag= 'pass';
	echo "flag= pass" ;
	echo "<br>";
	echo "score = $score<br>";
}

// if it fails then replace word  if needed 
// try to execute it again 
else {
	$score -= 8;
	$result = preg_replace('/print/', 'return', $ans);
	echo "$result<br>";

	$wfile = fopen("grader.py", 'w+') or die("nope could not connect");
	
	fwrite ($wfile,$result);
	fwrite ($wfile, $nextLine);
	fwrite ($wfile, $abc);

	fclose ($wfile);
	
	$output = 'python grader.py';
	$aoutput = shell_exec($output);
	

	$exec = strval($aoutput);

	
	if (strncmp ($exec, $caseAnswer, $length)===0 ){
		echo "after triming and replacement <br>flag= pass" ;
		$flag= 'pass';
	}
	else {
		$score = 0; 
	}
}
?>
