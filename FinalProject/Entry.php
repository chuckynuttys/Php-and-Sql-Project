<!DOCTYPE html>
<link href="https://unpkg.com/tabulator-tables@6.2.1/dist/css/tabulator.min.css" rel="stylesheet">
 <script type="text/javascript" src="https://unpkg.com/tabulator-tables@6.2.1/dist/js/tabulator.min.js"></script>
<html>
    
    <head>
        <link rel="stylesheet" href="Entry.css" type="text/css">
        <title>Entry Page</title>
</head>

<body class = "body">
<div class = "container">
    
<?php
if(isset($_COOKIE["userinfo"])){
    $pieces = explode(",", $_COOKIE["userinfo"]);
    $username = $pieces[0];
    echo("<h1 id='h1'>Welcome Back<h1>");
    echo("<h1 id='h2'>". $username . "</h1>");
}
else{
    echo("<h1 id='h1'>Welcome New User!</h1>");
}
    
?>

<form action ="MainPage.php" class = "form" method="post">
<h2 id='h2'>Login / Register</h2>
   <div id = "centerChild">
   
  
</div>
 
  <?php
  if(isset($_COOKIE["userinfo"])){

  }
  else{
    echo("<input type = 'text' class= 'text' name ='UserName' placeholder = 'User Name' required>");
    echo("<input type = 'text' class = 'text' name ='Email' placeholder = 'Email' required>");
  }
  ?>
  <input type = "text" class = "text" name ="Password" placeholder = "Password" required>
    <input type = "submit" id = "submit" name="submit" value = "Submit">
</div>
</form>
<body>
</html>