
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fraddon Hall Event Creator</title>
    <meta name="description" content="Fraddon Hall Event Creator">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    
    <h1>Fraddon Hall Event Creator</h1>
    <p><a href= "../fraddonvillagehall">Back to main page</a></p>
    

        <?php 


    //print_r($_POST); 



    if((isset($_POST['userid'])==false)) {

    ?>

      <p>Log in to create events on the website.</p>
      <form method="post">

      <p>
        <label for="login_name">Username:</label>
        <input type="text" id="login_name" name="name" placeholder=Userame value = "<?php echo $_POST['name']; ?>">
      </p>
      <p>
        <label for="login_password">Password:</label>
        <input type="password" id="login_password" name="password" placeholder=Password>
      </p>
      <input type="submit" value="Login">

      </form>

    <?php

    }

    ?>

    <form method="post" id="login_form2">

    <?php



    include "secrets.php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed");
    }

    $name2= $_POST['name'];
    $password2 = $_POST['password'];

    //echo $name2.$password2;



    $sql = "SELECT id, name, password, usertype, groupid FROM users WHERE name = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $name2);
    $stmt->execute();
    //$result = $stmt->get_result(); // get the mysqli result
    //$result = $stmt->get_result();
    //$user = $result->fetch_assoc(); // fetch data   

          /* Store the result (to get properties) */
          $stmt->store_result();
          
          /* Get the number of rows */
          $num_of_rows = $stmt->num_rows;

          /* Bind the result to variables */
          
          $stmt->bind_result($id, $name, $password, $usertype, $groupid);
      

    $stmt->fetch();

    if((isset($_POST['userid'])==false)) {

      if(($num_of_rows == 0)and(empty($_POST['name'])==false)) {
        
        echo "<script type='text/javascript'>alert('This name is not in the database');</script>";
        
      } else {
        
        if(($password != $password2)) {
          echo "<script type='text/javascript'>alert('Incorrect password');</script>";
        
        } elseif (empty($_POST['name'])==false) {
          
          
          
          ?>
          
          <input type="hidden" name = "name" value = "<?php echo $name;?>">      
          <input type="hidden" name = "userid" value = "<?php echo $id;?>">
          <input type="hidden" name = "usertype" value = "<?php echo $usertype;?>">
          <input type="hidden" name = "groupid" value = "<?php echo $groupid;?>">
        
          <script type='text/javascript'>document.getElementById('login_form2').submit();</script>
          </form>

          <?php
          
          
          
          
        }
        
      }
    } else {
      echo "Logged in as: ".$_POST['name'];
      //print_r($_POST);

      ?>

      <form action = "" method="post">
        <p>
          <label for="event_name">Event Name: </label>
          <input required id="event_name" type="text" name ="event_name">
        </p>
        <p>
          <label for="event_description">Event Description: </label><br>
          <textarea required id="event_description" name ="event_description"></textarea>
        </p>
        <p>
          <label for="date" >Event Date: </label>
          <input required id="date" onchange="displayTimeStart()" type="date" name ="date" min = "<?=date("Y-m-d");?>">
        </p>
        <p>
          <label for="time_start" >Time Start: </label>
          <input required id="time_start" onchange="displayTimeStart()" type="time" name ="time_start">
        </p>
        <p>
          <label for="time_end">Time End: </label>
          <input required id="time_end" type="time" name ="time_end">
        </p>
        <input type="hidden" name="userid" value = "<?=$_POST['userid'];?>">
        <input type="hidden" name="name" value = "<?=$_POST['name'];?>">
        <input type="submit" name= "submit" value="submit">

      </form>
      


      <?php


      if($_POST['submit']) {
        
        $sql = "INSERT INTO calendar ( userid, eventName, description, date, startTime, endTime) VALUES (?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("isssss", $_POST['userid'], $_POST['event_name'], $_POST['event_description'], $_POST['date'], $_POST['time_start'], $_POST['time_end']);
        $stmt->execute();
        echo "New records created successfully";
        $stmt->close();
      }







    }


    

    $conn->close();
    ?>
    




    <script>

      function displayTimeStart() {
        var time_start = document.getElementById("time_start").value;
        //const time_split = time_start.split("T");
        //time_start = time_split[1];
        console.log(time_start);
        //console.log(time_split);
        document.getElementById("time_end").value=time_start;
        document.getElementById("time_end").min=time_start;
      }




    </script>
  </body>
</html>