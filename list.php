<?php

function order_by_desc($a, $b)
{
    if ( $a['mtime'] > $b['mtime'] )
    {
        return -1;
    }
    else if( $a['mtime'] < $b['mtime'] )
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function byte_format($size, $dec=2, $separate=false){
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $digits = ($size == 0) ? 0 : floor( log($size, 1024) );
     
    $over = false;
    $max_digit = count($units) -1 ;
 
    if($digits == 0){
        $num = $size;
    } else if(!isset($units[$digits])) {
        $num = $size / (pow(1024, $max_digit));
        $over = true;
    } else {
        $num = $size / (pow(1024, $digits));
    }
     
    if($dec > -1 && $digits > 0) $num = sprintf("%.{$dec}f", $num);
    if($separate && $digits > 0) $num = number_format($num, $dec);
     
    return ($over) ? $num . $units[$max_digit] : $num . $units[$digits];
}

	
session_start();

//URLs
$base_url = "https://your-urls-please/";




	
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
<p><small><a href="index.php">upload file</a></small></p>
	<h1>File lists</h1>

<?php

	$arr = array();
	if( $dir = opendir("./") )
	{
		while( ($file = readdir($dir)) != false )
		{
			if($file != "." && $file != ".." && $file != 'index.php' && $file != 'list.php')
			{
				$mtime = filemtime( $file );
				$fsize = filesize( $file );
				$arr[] = array(
					'name' => $file,
					'mtime' => $mtime,
					'size' => $fsize,
				
				);
			}
		}
		
		usort($arr, 'order_by_desc');	
	}

	echo "<ul>\n";
	foreach($arr as $f)
	{
		$date = date("Y-m-d H:i:s", $f['mtime']);
		$size = byte_format($f['size']);
		echo "    <li><a href=\"{$base_url}{$f['name']}\" target='_blank'>{$base_url}{$f['name']}</a> , {$date}, {$size}</li>\n";
		
	}
	echo "</ul>\n";
?>


  
<?php
}
else{
	header("Location: ".$base_url);
	exit;
}
?>	  
		  
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>	
</body>
</html>
