
DROP DATABASE IF EXISTS ProjectDatabase;
CREATE DATABASE IF NOT EXISTS ProjectDatabase;
use ProjectDatabase;

CREATE TABLE Users (
 user_id INT unsigned NOT NULL AUTO_INCREMENT,
 user_name VARCHAR(32) NOT NULL, 
 email VARCHAR(32) NOT NULL,
 password VARCHAR(300),
 is_permission BOOLEAN not null,
 UNIQUE (user_name),
 PRIMARY KEY (user_id)
);


CREATE TABLE Workouts(
    workout_id INT unsigned NOT NULL AUTO_INCREMENT,
     picture_id INT unsigned NOT NULL,
    workout_name VARCHAR(32) not null,
    workout_duration VARCHAR(32) not null,
    workout_musclegroup VARCHAR(32) not null,
    total_calories float unsigned,
    PRIMARY KEY(workout_id)
);

create TABLE Day (
    day_id INT unsigned NOT NULL AUTO_INCREMENT,
     workout_id INT unsigned,
    calories INT unsigned NOT NULL,
    user_id INT unsigned NOT NULL,
    day INT unsigned not null,
    FOREIGN KEY (workout_id) REFERENCES Workouts(workout_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    PRIMARY KEY(day_id)
);

CREATE TABLE WorkoutUsers (
    workout_user_id int null AUTO_INCREMENT,
     user_id INT UNSIGNED NOT NULL,
    workout_id INT UNSIGNED NOT NULL,
    is_global BOOLEAN not null,
    PRIMARY KEY (workout_user_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (workout_id) REFERENCES Workouts(workout_id)
);



CREATE TABLE Exercise(
    exercise_id INT UNSIGNED not null AUTO_INCREMENT,
    exercise_name VARCHAR(32) not null, 
    calories float unsigned not null,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    PRIMARY KEY(exercise_id)
);

CREATE TABLE ExerciseWorkout (
    excercise_workout_id int null AUTO_INCREMENT,
    workout_id INT UNSIGNED NOT NULL,
    exercise_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    -- is_global BOOLEAN not null,
    PRIMARY KEY (excercise_workout_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (workout_id) REFERENCES Workouts(workout_id),
    FOREIGN KEY (exercise_id) REFERENCES Exercise(exercise_id)
);



DELIMITER //
CREATE TRIGGER update_total_calories AFTER INSERT ON exerciseworkout
FOR EACH ROW
BEGIN
    DECLARE exercise_calories INT;

    -- Get the calories for the new exercise
    SELECT calories INTO exercise_calories FROM exercise WHERE exercise_id = NEW.exercise_id;

    -- Update the total_calories for the corresponding workout
    UPDATE workouts 
    SET total_calories = total_calories + exercise_calories 
    WHERE workout_id = NEW.workout_id;
END;
//
DELIMITER ;






INSERT into Users (user_name, email, password, is_permission) 
VALUES ("charles", "charles.com", "password", '1');

INSERT INTO Workouts (Workout_name, workout_duration,
 workout_musclegroup, total_calories, picture_id)
VALUES("Squat", "1 hour", "legs", 0, 1);

INSERT INTO Workouts (Workout_name, workout_duration,
 workout_musclegroup, total_calories, picture_id)
VALUES("Chest-Day", "1 hour", "Chest", 0, 2);

INSERT INTO Workouts (Workout_name, workout_duration,
 workout_musclegroup, total_calories, picture_id)
VALUES("Back-Day", "1 hour", "Back", 0, 3);


INSERT INTO WorkoutUsers (user_id, workout_id, is_global) VALUES (1, 1, 1);

INSERT INTO WorkoutUsers (user_id, workout_id, is_global) VALUES (1, 2, 1);

INSERT INTO WorkoutUsers (user_id, workout_id, is_global) VALUES (1, 3, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Squat", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (1, 1, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Deadlift", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (1, 2, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("BoxJump", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (1, 3, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Single Leg Squat", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (1, 4, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Leg Curl", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (1, 5, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Bench", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 6, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Cable Cross", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 7, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("DB Flys", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 8, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Inclide DB Bench", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 9, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Standing Plate Push", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 10, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Squeeze Press", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 11, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Peck Deck", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (2, 12, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("One Arm DB Row", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 13, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Seated Row", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 14, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Lat Pull Down", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 15, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Back Extension", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 16, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Bent Over Row", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 17, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Tbar Row", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 18, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Shrugs", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 19, 1);

INSERT INTO Exercise (exercise_name, calories, user_id)
VALUES("Pullup", 50, 1);
INSERT INTO ExerciseWorkout(workout_id, exercise_id, user_id) VALUES (3, 20, 1);

INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 1);
INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 2);
INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 3);
INSERT INTO day (calories, user_id, day) VALUES ( 0, 1, 4);
INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 5);
INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 6);
INSERT INTO day ( calories, user_id, day) VALUES ( 0, 1, 7);
