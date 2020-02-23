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
        <div><?php echo $this->mensaje; ?></div>
        <form action="<?php echo constant('URL'); ?>contact/newAddress" method="POST">
            <label for="">First Name</label><br>
            <input type="text" name="name" id=""><br>
            <label for="">Surname</label><br>
            <input type="text" name="surname" id=""><br>
            <label for="">Address</label><br>
            <input type="text" name="address" id=""><br>
            <label for="">eMail</label><br>
            <input type="text" name="email" id=""><br>
            <label for="">Phone</label><br>
            <input type="text" name="phone" id=""><br>
            <input type="submit" value="Add New Contact">
        </form>
    </div>

    <?php require 'views/footer.php'; ?>
    
</body>
</html>