<!Doctype html>
<html>

<head>
<?php
    include ("NavBar.php");

    ?>
    <link rel="stylesheet" href="Workout.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="script.js" defer></script>
    <script src="script1.js" defer></script>
</head>

<body>

    <?php

    $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');
    //Insert workout into database
    if (
        isset($_POST["workout_name"]) && isset($_POST["workout_duration"])
        && isset($_POST["workout_musclegroup"]) && isset($_POST["hiddenValue"]) )
   {
        $workout_name = $_POST["workout_name"];
        $workout_duration = $_POST["workout_duration"];
        $workout_musclegroup = $_POST["workout_musclegroup"];
    $pictureid = $_POST["hiddenValue"];
        $query = "INSERT INTO Workouts (workout_name, workout_duration,
    workout_musclegroup, total_calories, picture_id) VALUES ('$workout_name', '$workout_duration', 
    '$workout_musclegroup', '0', '$pictureid');";
        mysqli_query($connection, $query);

        $query = "SELECT * FROM Workouts WHERE workout_name = '$workout_name' AND workout_duration =
    '$workout_duration' AND total_calories = '0';";
        $results = mysqli_query($connection, $query);
        if (mysqli_num_rows($results) > 0) {
            $row = mysqli_fetch_array($results);
            $workout_id = $row["workout_id"];
            $pieces = explode(",", $_COOKIE["userinfo"]);
            $user_id = $pieces[1];
            $query = "INSERT INTO WorkoutUsers (user_id, workout_id) VALUES('$user_id', '$workout_id');";
            mysqli_query($connection, $query);
        }
    }



    //Fetch User and there workouts
    $pieces = explode(",", $_COOKIE["userinfo"]);
    $user_name = $pieces[0];
    $user_id = $pieces[1];
    echo("<h1 class='user-header'>$user_name's Workouts</h1>");
    $query = "SELECT * FROM WorkoutUsers WHERE user_id = '$user_id';";
    $results = mysqli_query($connection, $query);
    $idArray = array();
    if(mysqli_num_rows($results) > 0){
        echo(' <div class="wrapper">
        <i id="left" class="fa-solid fa-angle-left"></i>
        <ul class="carousel">');  
        while ($row = mysqli_fetch_assoc($results)){
       
            $query = "SELECT * FROM Workouts WHERE workout_id = '$row[workout_id]';";
            //Display Workout ID
            $result = mysqli_query($connection, $query);
            $brow = mysqli_fetch_assoc($result);

            $query = "SELECT * FROM exerciseworkout WHERE workout_id = '$row[workout_id]';";
            $cresult  = mysqli_query($connection, $query);
            
            $pictureid = $brow['picture_id'];

            echo("<li class='card'>
            <div class='img' draggable='false'>
                <img src='image/sprite".$pictureid.".png'>
            </div>
            <h2 id='h21'>".$brow['workout_name']."</h2>
            <p id='p1'>Calories Burned: ".$brow['total_calories']."</p1>
            <h2 id='h21'>Exercises</h2>");
            while ($crow = mysqli_fetch_assoc($cresult)){
                $newQuery = "SELECT * FROM exercise WHERE exercise_id = '$crow[exercise_id]'";
                $tresult = mysqli_query($connection, $newQuery);
                while ($trow = mysqli_fetch_assoc($tresult)){
                echo("<p id='p1'>$trow[exercise_name]</p>");
                }
            }
        echo("</li>");
    }
    echo('</ul>
    <i id="right" class="fa-solid fa-angle-right"></i>
</div>');
echo("<script> 
            window.addEventListener('load', function() {
              console.log('Works!');
              var left1 = document.getElementById('left2');
              var right1 = document.getElementById('right2');
              left1.removeAttribute('left2'); // Remove original class
              left1.setAttribute('id','left1'); // Add new class
              right1.removeAttribute('right2'); // Remove original class
              right1.setAttribute('id','right1'); // Add new class
              
            });
              </script>");
        }
        else{
            echo("<h1>No User Workouts!</h1>");
            echo("<script> 
            window.addEventListener('load', function() {
              console.log('Works!');
              var left1 = document.getElementById('left1');
              var right1 = document.getElementById('right1');
              left1.removeAttribute('left1'); // Remove original class
              left1.setAttribute('id','left2'); // Add new class
              right1.removeAttribute('right'); // Remove original class
              right1.setAttribute('id','right2'); // Add new class
              
            });
              </script>");
        }

    ?>
     <div class="break"></div>
    <div class = 'form'>
    <li class="card">
        <div class="button">
    <i id="left1" class="fa-solid fa-angle-left"></i>
         <div class='img' draggable='false'>
                <img src='image/sprite1.png'>
                <i id="right1" class="fa-solid fa-angle-right"></i>
    </div>
            </div>
       <h1 id="h1">Create a New Workout<h1 id="h1">
    <form action ="WorkoutsPage.php" method="post">
    <input type="hidden" id="hiddenValue" name="hiddenValue" value="1">
    <input class="in1" type = "text" name="workout_name" placeholder="Workout Name" required><br>
    <input class="in1" type ="number" name="workout_duration"placeholder="Workout Duration" required><br>
    <input class="in1" type = "text" name="workout_musclegroup" placeholder="Workout Musclegroup" required><br>
    <input class="in1" type = "submit" value="Submit">
    </form>
    </div>
    </li>
    <div class="card">
    <form class="form1" method="post" action="WorkoutsPage.php">
        <!-- Add exerice to database for ExceriseWorkouts -->
        <?php
           if(isset($_POST['exercise1']) && isset($_POST['workout1'])){
            // echo '<script>console.log("Worked"); </script>'; 
            $workout_id = $_POST['workout1'];
        //   echo "<script>console.log(" . json_encode($workout_id) . ");</script>";
            $exercise_id = $_POST['exercise1'];
            $query = "INSERT INTO exerciseworkout (workout_id, exercise_id, user_id) 
            VALUES('$workout_id', '$exercise_id', '$user_id');";
            mysqli_query( $connection, $query);
           }
           else{
            echo '<script>console.log("Not set values"); </script>'; 
           }
        ?>
    <h1 id="h1">Add Exercises to Workout</h1>
    <label class="label1" for="exercise">Workout<br></label>
        <select id="exercise" class= "in1" name="workout1" required>
        <option value=''>--Please choose a Workout--</option>
        <?php
            $query = "SELECT * FROM workoutusers WHERE user_id = '$user_id';";
            $results = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_assoc($results)){
            $aquery = "SELECT * FROM workouts WHERE workout_id = '$row[workout_id]';";
            $aresult = mysqli_query($connection, $aquery);
            $workout_id = $row['workout_id'];
            echo "<script>console.log(" . json_encode($workout_id) . ");</script>";
            while ($trow = mysqli_fetch_assoc($aresult)){
                
                    echo("<option class='dropdown' value='$trow[workout_id]'>$trow[workout_name]</option>");
                }
            }
        
       
            ?>
            
        </select>
        <label class="label1" for="workout">Add Exercise<br></label>
        <select id="workout" class= "in1" name="exercise1" required>
        <option value=''>--Please choose an Exercise--</option>
        <?php
            
            $aquery = "SELECT * FROM exercise WHERE user_id = '$user_id';";
            $aresult = mysqli_query($connection, $aquery);
            while ($trow = mysqli_fetch_assoc($aresult)){
                
                    echo("<option class='dropdown' value='$trow[exercise_id]'>$trow[exercise_name]</option>");
            }

            ?>
        </select>
        <input id="pixelfrick" class="in1" type="submit" name="Submit" value = "Submit">
    </form>
    <!-- Lets create a exercise -->
    <?php
        if(isset($_POST["exercisename"]) && isset( $_POST["excerisecalories"])){
            $exercisename = $_POST["exercisename"];
            $exercisecalories = $_POST["excerisecalories"];
            $query = "INSERT INTO exercise (exercise_name, calories, user_id) VALUES ('$exercisename',
            '$exercisecalories', '$user_id');";
            mysqli_query($connection, $query);
        }
    ?>
    <form class="form1" method="post" action="WorkoutsPage.php">
        <h1 id="h1">Create Exercises</h1>
        <form class="form1">
        <input class="in1" type = "text" name="exercisename" placeholder="Excercise Name" required>
        <input class="in1" type ="number" name="excerisecalories"placeholder="Calories Burned" required>
        <input class="in1" type="submit" name="Submit" value = "Submit">
    </form>
    
    </div>
        

</body>
        

<!-- JaveScript -->


</html>