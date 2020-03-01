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
            <h1 class="center">Add Contact!</h1>
            <div>
                <?php 
                      if (!empty($this->message))      { echo("<h2>"        . $this->message      . "</h2>");}
        		      if (!empty($this->errorMessage)) { echo('<h3>ERROR: ' . $this->errorMessage . '</H3>'); }
        		?>
    		</div>
    		
            <form action="<?php echo constant('URL'); ?>index.php?url=contact&command=newAddress" method="POST">
            	<?php 
            	$fields=$this->fields;
            	foreach($fields as $key=>$value){ 
            	    echo ('<label for="">'.$fields[$key]['label'].'</label><br>');
            	    echo ('<input type="text" name="'.$key.'" id="" value="'.$fields[$key]['value'].'" ><br>');
            	}
            	?>
                <input type="submit" value="Add New Contact">
            </form>
        </div>

    <?php require 'views/footer.php'; ?>
    
   </body>
</html> 