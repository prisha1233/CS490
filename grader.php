<?php


//todo
//read/write to python file works!!
//executing works
$UCID = $_POST['UCID'];
$exam = $_POST['exam'];
$question = $_POST['question'];
$answer = $_POST['answer'];
$filename = "grader.py";

$send = "question=" . $question;

$conn = mysqli_connect("sql1.njit.edu","ajg55","splice46","ajg55");
  if(!$conn){
      die('no connection' . mysql_error());
  }



$sql = "SELECT * FROM questions WHERE id = (SELECT $question from exam WHERE name = 'Exam 1')";

$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $response = array(
		"question" => $row["question"]; 
    	"test1" => $row["test1"],
    	"test2" => $row["test2"],
    	"test3" => $row["test3"],
    	"test4" => $row["test4"],

    	"t1a"   => $row["t1a"],
    	"t2a"   => $row["t2a"],
    	"t3a"   => $row["t3a"],
    	"t4a"   => $row["t4a"]


    );

    
}

//getting the right values


for($i = 1; $i <= 4; $i++){
	//echo $response["test".$i];
	$wfile = fopen("grader.py", 'w') or die("nope could not connect");
	//$in = fread($wfile,filesize("test.py"));
	$extra = "\nprint(".$response["test".$i].")";
	fwrite($wfile,$answer);

	fwrite($wfile,$extra);
	fclose($wfile);
	$command = 'python grader.py';
	$output = shell_exec($command);

	//Execute the overwritten python file compate it with extra acting as the 
	//test case if it matches write pass/ fail otherwise

    if (strcmp ($output, $response["t".$i."a"]) == 0){
		$flag = "pass"; 
	}
		//$flag = "pass"; 
	
		}
	else{//$flag = "fail";
	
		$wfile = fopen("grader.py", 'w') or die("nope could not connect");
		$result = ('/print/','return',$answer);
		fwrite($wfile,$answer);

		fwrite($wfile,$extra);
		fclose($wfile);
		$command = 'python grader.py';
	$output = shell_exec($command);
	}//failed test



	//$place = "question".$i."points";
	$questionplace = $question;
	$testplace = $questionplace."t".$i;

	

	$sql = "update studentAnswers set $testplace = '$flag' where UCID='$UCID' and examName='Exam 1'";
	//echo $output;
	
	$conn->query($sql);

// comparing both answer with test cases




}

//chmod($filename, 0777); no need problem was chmod not working for http
//solved by setting afs permission: fs setacl method



?>
