<link rel="stylesheet" href="NavCSS.css" type="text/css">
<div class="topnav">
    <?php 
    $string = "/FinalProject/MainPage.php";
    $pageName = basename($string, ".php");
    print '<a id="e1234">'.'Welcome to '.$pageName.'</a>'; 

    ?>
    <a class="lazy" href="MainPage.php">Home Page</a>
    <a class="lazy" href="WorkoutsPage.php">Workouts</a>
    <!-- <a class="lazy" href="Meals.php">Meals</a> -->
    <a class="active" href="FindWorkouts.php">Find Workouts</a>
    <!-- <a class="active" href="FindMeals.php">Find Meals</a> -->

    <?php 
        if(isset($_COOKIE['userinfo'])){
            $pieces = explode(",", $_COOKIE['userinfo']);
            $username = $pieces[0];
            echo('<a class= "lazy" id="e1235">' . $username . '</a>');
        }
    ?>

</div>