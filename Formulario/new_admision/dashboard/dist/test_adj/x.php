<?php
	define("REPOSITORY", "/archivos");
	if(isset($_POST['submit'])){
		if(is_uploaded_file($_FILES['fileupload']['tmp_name'])){
			echo "temperory file name: " . $_FILES['fileupload']['tmp_name'] . "<br />";
			echo "file name: " . $_FILES['fileupload']['name'] . "<br />";
			echo "file size: " . $_FILES['fileupload']['size'] . "<br />";
			echo "file type: " . $_FILES['fileupload']['type'] . "<br />";
			$fileName=$_FILES['fileupload']['name'];
			$tmpFileName=$_FILES['fileupload']['tmp_name'];			
			//check file type
			//test base64_encode _decode
				$data=base64_encode(addslashes(fopen($tmpFileName, "r", filesize($tmpFileName))));
				echo "data " . $data;
				print "strip " . stripslashes(base64_decode($data));
			//test
			if($_FILES['fileupload']['type'] == "images/jpeg" || "images/bmp"){
				$result == move_uploaded_file($tmpFileName, REPOSITORY . "/$fileName");
				if($result==1){
					echo "file successfully uploaded.";
				}else{
					echo "something went wrong.";
				}
			}else{
				echo "not a valid file type";
			}
		}else{
			$err_Number = $_FILES['fileupload']['error'];
			switch($err_Number){
				case 1: echo "<b>UPLOAD_ERR_INI_SIZE: Err Num $err_Number </b>- There was an attempt to upload a file whose size exceeds the value specified by the <i>upload_max_filesize</i> directive.";
					break;
				case 2: echo "<b>UPLOAD_ERR_FORM_SIZE: Err Num $err_Number </b>- There was an attempt to upload a file whose size exceeds the value of the <i>max_file_size</i> directive, which can be embedded into the HTML form.";
					break;
				case 3: echo "<b>UPLOAD_ERR_PARTIAL: Err Num $err_Number </b>- A file is not completely  uploaded. ";
					break;
				case 4: echo "<b>UPLOAD_ERR_NO_FILE: Err Num $err_Number </b>- No file specified.";
					break;
			}
		}
	}else{
?>
<html>
<head>
	<title>Test</title>
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
	File: <input type="file" name="fileupload" />
	<br /><input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
<?php
	}
?>