<?php
	
function get_rnd_str($length = 8) {
    static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; ++$i) {
        $str .= $chars[mt_rand(0, 61)];
    }
    return $str;
}

session_start();

//パスワード
$passwd = "YOUR-PASSWORD";
//URLs
$base_url = "https://your-urls-please/";

//パスワードチェック
if( isset($_POST['password']) &&  ($_POST['password'] == $passwd ) )
{
	$_SESSION['logined'] = true;
}


	
?>
<!DOCTYPE html>
<html>
<head>
  <title>toiee Data Storage</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <style>
	  body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.custom-file-control::before {
	content: "Browse";
}
.custom-file {
	margin-bottom: 5px;
}

  </style>
</head>
<body>
	
	<div class="container">


<?php

if( isset($_SESSION['logined']) && $_SESSION['logined'] ){
	
?>

          <form enctype="multipart/form-data" action="index.php" method="POST" class="form-signin">
             <h2 class="form-signin-heading">Upload here</h2>
			 <input type="file" id="uploaded_file" name="uploaded_file" value="Browse" class="btn"><br>
			 <input type="submit" value="Upload"  class="btn btn-lg btn-primary btn-block" ></input>
		  </form>
		  
<?PHP
  if(!empty($_FILES['uploaded_file']))
  {
	
	$info = new SplFileInfo( $_FILES['uploaded_file']['name'] );
	$ext = $info->getExtension();
    $path = "./".get_rnd_str(10).".".$ext;
    
    if($ext=='php' || $ext=='cgi' )
    {
	    echo "You are dangerous boy!!";
    }
    else
    {
	    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)){
		?>
		    
		    <div class="form-group form-signin">
	    <label class="form-control-label" for="formGroupExampleInput">URL</label>
	    <input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $base_url.basename($path);?>" readonly="readonly" onclick="this.select();">
	    <p><small>Cmd+C, Cmd+V for copy and paste ( <a href="<?php echo $base_url.basename($path);?>" target="_blank">check here</a> )</small></p>
	  </div>
	
	    <?php
	    } else{
	        echo "There was an error uploading the file, please try again!";
	    }
    }
  }
?>		  
		  <p class="text-center"><a href="list.php">list of upload files</a></p>
		  
<?php
}
else{
?>		  

          <form action="index.php" method="POST" class="form-signin">
			  <div class="form-group" >
			    <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="password" style="margin-bottom: 5px;">
    			 <input type="submit" value="login"  class="btn btn-lg btn-primary btn-block" ></input>
			  </div>
		  </form>



<?php
}
?>	  
		  
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>	
</body>
</html>
