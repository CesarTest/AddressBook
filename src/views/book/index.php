<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Address Book</title>
</head>
<body>

    <?php require 'views/header.php'; ?>

    <div id="main">
        <h1 class="center">List Contacts of Address Book!</h1>
     
    	<?php
    	if(empty($this->contact)) {echo("<h3>Empty Book </h3>");
    	} else {
    	    $newline="\n";
    	    $header="<thead>";
    	    $body="<tbody>";
    	    $first=true;
    	    foreach ($this->contact as $address ) {
    	        $body=$body."<tr>".$newline;
    	        if($first) {$header=$header."<tr>";}
    	        foreach ( $address as $key => $value ) {
    	            if ($first) {$header=$header."<td>".$key."</td>";}
    	            $body=$body."<td>".$value."</td>";
    	        }
    	        if($first) {$header=$header."</tr><thead>".$newline;}
    	        $body=$body."</tr>".$newline;
    	        $first=false;
    	    }
    	    $body=$body."</tbody>";
    	}
    	
    	$html="<table>".$header.$body."</table>".$newline;
        echo($html);    	
    	?>
    
    </div>

    <?php require 'views/footer.php'; ?>
    
</body>
</html>