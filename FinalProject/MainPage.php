<!Doctype html>
<html>

<head>
    <link rel="stylesheet" href="MainPage.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');
    include ("NavBar.php");
    if (!isset($_COOKIE["userinfo"])) {
        if (isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['Email'])) {
            $username = $_POST['UserName'];
            $email = $_POST['Email'];
            $password = $_POST["Password"];

            $query = "SELECT * FROM users WHERE user_name = '$username' AND 
            password = '$password';";
            $result = mysqli_query($connection, $query);

            //If there is a user with this password do this
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $username = $row["user_name"];
                $user_id = $row["user_id"];
                setcookie("userinfo", $username . ',' . $user_id);
            }
            //else insert the user
            else {
                $query = "INSERT INTO Users (user_name, email, password) 
            VALUES ('$username', '$email', '$password');";
                mysqli_query($connection, $query);
                $query = "SELECT * FROM users WHERE user_name = '$username'";
                $results = mysqli_query($connection, $query);
                if (mysqli_num_rows($results) > 0) {
                    $row = mysqli_fetch_array($results);
                    $username = $row["user_name"];
                    $user_id = $row["user_id"];
                    setcookie("userinfo", $username . ',' . $user_id);
                } else {
                    echo ("Failed to query");
                }
            }
            
            for ($i = 1; $i <= 7; $i++) {
                $zquery = "INSERT INTO day (calories, user_id, day) VALUES (0, '$user_id', '$i');";
                mysqli_query($connection, $zquery);
            }
        } else {
            // echo("Fields weren't found");
        }
        header("Refresh:0");
    } else {
        // echo("Cookie is already set");
    
    }
    ?>
    <h1>Welcome to the main page</h1>
</head>

<body class="mainpage">
    <div class="chartwrap">
        <canvas id="myChart" class="chart"></canvas>
    </div>
    <?php 
      $pieces = explode(",", $_COOKIE["userinfo"]);
      $user_name = $pieces[0];
      $user_id = $pieces[1];
    $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');
    $query = "SELECT calories FROM day where user_id = '$user_id';";
    $result = mysqli_query($connection, $query);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['calories'];
    }
   

    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        var jsArray = <?php echo json_encode($data); ?>;
        console.log("array below");
        console.log(jsArray);
        const labels = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: "Calorie's Burned",
                data: jsArray,
                fill: false,
                backgroundColor: '#E7ECEF',
                borderColor: '#0F1E2E',
                tension: 0.1
            },
            {
                label: "Calorie Gains",
                backgroundColor: '#E7ECEF',
                borderColor: 'rgb(220, 20, 60)',
                data: [500, 600, 300, 200, 400, 400, 600]
            }]
        };

        const plugin = {
  id: 'customCanvasBackgroundColor',
  beforeDraw: (chart, args, options) => {
    const {ctx} = chart;
    ctx.save();
    ctx.globalCompositeOperation = 'destination-over';
    ctx.fillStyle = options.color || '#99ffff';
    ctx.fillRect(0, 0, chart.width, chart.height);
    ctx.restore();
  }
};

        const config = {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    customCanvasBackgroundColor: {
                        color: '#E7ECEF',
                    },
                    
                },
                legend: {
                display: true,
                labels: {
                    color: 'rgb(255, 99, 132)'
                }
            }
            },
            plugins: [plugin],
            };

            new Chart(
                document.getElementById('myChart'),
                config,
                {
                    options: {
                        scales: {
                            x: {
                                max: 100
                            },
                            y: {
                                max: 100
                            }
                        }
                    }
                }
            );


        });
    </script>




    <?php
    $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');
    $pieces = explode(",", $_COOKIE["userinfo"]);
    $user_id = $pieces[1];
    $query = "SELECT * FROM WorkoutUsers WHERE user_id = '$user_id';";
    $results = mysqli_query($connection, $query);
    if (mysqli_num_rows($results) > 0) {

        // echo ("<form action = 'MaingPage.php' method='post'>
        //             <label for='Workouts'>Choose a completed workout</label>
        //             <select name='User Workouts'>");

        while ($row = $results->fetch_assoc()) {
            $workout_id = $row['workout_id'];
            $query = "SELECT * FROM Workouts where workout_id = '$workout_id'";
            $results = mysqli_query($connection, $query);
            if (mysqli_num_rows($results) > 0) {
                $row = mysqli_fetch_array($results);

                // echo ("<option value = '" . $row['workout_name'] .
                //     "'>" . $row['workout_name'] . "</option>");


            }
        }


        // echo ("</select>
        //                 <input type = submit value = Finished>
        //                 </form> ");


    } else {

        echo ("<form action = 'WorkoutsPage.php' method='post'>
                    <input type = submit value='Create a New Workout'>
                    </form>");

    }

    ?>
<form class="form1"method="post" action="MainPage.php">
<select id="exercise" class= "in1" name="workout2" required>
        <option value=''>--Please choose a Workout--</option>
        <?php
          $connection = mysqli_connect('localhost', 'root', '', 'projectdatabase');
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
            <select id="exercise2" class= "in1" name="day" required>
        <option value=''>--Completed Workout on Day--</option>
        <option class='dropdown' value='1'>1</option>
        <option class='dropdown' value='2'>2</option>
        <option class='dropdown' value='3'>3</option>
        <option class='dropdown' value='4'>4</option>
        <option class='dropdown' value='5'>6</option>
        <option class='dropdown' value='6'>6</option>
        <option class='dropdown' value='7'>7</option>
            </select>
          
            <input class="in1" type="submit" name="Submit" value = "Submit">
</form>

<?php
    if(isset($_POST["workout2"]) && isset($_POST["day"])){
        $workoutid = $_POST["workout2"];
        $day = $_POST["day"];
        $iquery = "SELECT * FROM workouts WHERE workout_id = '$workoutid';";
        $iresult = mysqli_query($connection, $iquery);
        $irow = mysqli_fetch_array($iresult);
        $calories = $irow["total_calories"];
        $query = "UPDATE day SET calories = '$calories' WHERE day = '$day';";
        mysqli_query($connection, $query);
    }
?>
</body>

</html>