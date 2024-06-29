<!Doctype html>

<html >
<link rel="stylesheet" href="FindWorkouts.css" type="text/css">
<script src="script.js" defer></script>
<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <head>
        <?php
            include("NavBar.php");
        ?>
    <h1 class='user-header'>Welcome to the Find WorkoutsPage</h1>
    </head>

    <body id = 'FindWorkoutsPage'>
        
    <?php 
    $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');

             echo("<h1 class='user-header'>Global Workouts</h1>");
                 echo(' <div class="wrapper">
                 <i id="left" class="fa-solid fa-angle-left"></i>
                 <ul class="carousel">');  
                 $pieces = explode(",", $_COOKIE["userinfo"]);
         
                 $userid = $pieces[1];

                     $query = "SELECT * FROM workoutusers WHERE is_global = '1' AND user_id != '$userid';";
                     //Display Workout ID
                     $result = mysqli_query($connection, $query);
                     while ($brow = mysqli_fetch_array($result)) {

                        $dquery = "SELECT * FROM workouts WHERE workout_id= '$brow[workout_id]';";
                        $dresult = mysqli_query($connection, $dquery);
                        $drow = mysqli_fetch_assoc($dresult);
            
                     $query = "SELECT * FROM exerciseworkout WHERE workout_id = '$brow[workout_id]';";
                     $cresult  = mysqli_query($connection, $query);
                     
                    
                     
                     $pictureid = $drow['picture_id'];
         
                     echo("<li class='card'>
                     <div class='img' draggable='false'>
                         <img src='image/sprite".$pictureid.".png'>
                     </div>
                     <h2 id='h21'>".$drow['workout_name']."</h2>
                     <p id='p1'>Calories Burned: ".$drow['total_calories']."</p1>
                     <h2 id='h21'>Exercises</h2>");
                     while ($crow = mysqli_fetch_assoc($cresult)){
                         $newQuery = "SELECT * FROM exercise WHERE exercise_id = '$crow[exercise_id]'";
                         $tresult = mysqli_query($connection, $newQuery);
                         while ($trow = mysqli_fetch_assoc($tresult)){
                         echo("<p id='p1'>$trow[exercise_name]</p>");
                         }
                     }
                     echo("<form action ='FindWorkouts.php' method='POST'>");
                     echo("<input type='hidden' id='hiddenValue' name='workoutid' value='".$brow['workout_id']."'>");
                     echo("<input class='in1' type = 'submit' value='Add Workout!'>");
                     echo("</form>");
                 echo("</li>");
                    }
             echo('</ul>
             <i id="right" class="fa-solid fa-angle-right"></i>
         </div>');
        
        

        if(isset($_POST['workoutid'])){
        $workoutid = $_POST['workoutid'];
        $query = "INSERT INTO workoutusers (user_id, workout_id, is_global)
        VALUES ('$userid', '$workoutid', 0)";
        mysqli_query($connection, $query);
        }

        ?>
    </body>

</html>