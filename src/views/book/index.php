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
    	    //var_dump($this->contact);
    	    foreach ($this->contact as $address ) {
    	        if(!empty($address)) {
        	        $body=$body."<tr>".$newline;
        	        if($first) {$header=$header."<tr>";}
        	        foreach ( $address as $value ) {
        	            if ($first) {$header=$header."<td>".$value['label']."</td>";}
        	            $body=$body."<td>".$value['value']."</td>";
        	        }
        	        if($first) {$header=$header."</tr>".$newline;}
        	        $body=$body."</tr>".$newline;
        	        $first=false;
    	        }
    	    }
    	    $header=$header."</thead>";
    	    $body=$body."</tbody>";
    	}
    	
    	$html="<table>".$header.$body."</table>".$newline;
        echo($html);    	
    	?>
    
    </div>

    <?php require 'views/footer.php'; ?>
    
</body>
</html>