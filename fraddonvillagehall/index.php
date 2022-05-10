
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fraddon Village Hall</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <style>
      ul {
        padding: 0;
      }
      ul li {
        list-style-type: none;
        margin-top: 16px;
        padding: 0;
      }

      
      table {
        border-collapse: collapse;
      }

      th, td {
        border: 1px solid black;
        padding: 5px;
      }
    
    </style>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <h1>Fraddon Village Hall  </h1>
    <p>Welcome to the Fraddon Village Hall Webiste!</p>
    <p>Clck <a href="event_create.php">here</a> to login as the caretaker and create a new event for the calendar.</p>


    <h2>Upcoming Events:</h2>
    <table>
      <tr>
        <th>Event Name</th>
        <th>Event Description</th>
        <th>Date</th>
        <th>Time Start</th>
        <th>Time Finish</th>
      </tr>
    

    <?php

      include "secrets.php";
      $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed");
    }

    $sql = "SELECT * FROM calendar ORDER BY date, startTime";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param();
    $stmt->execute();
    $result=$stmt->get_result();
    if ($result) {
      while ($row = $result->fetch_assoc()) {
        //print_r($row);
        //echo "<br>";
        ?>

        <tr>
          <td><?=htmlspecialchars($row['eventName']);?></td>
          <td><?=htmlspecialchars($row['description']);?></td>
          <td><?=htmlspecialchars(date("l, j F Y", strtotime($row['date'])));?></td>
          <td><?=htmlspecialchars(date("g:ia", strtotime($row['startTime'])));?></td>
          <td><?=htmlspecialchars(date("g:ia", strtotime($row['endTime'])));?></td>
 
        </tr> 

        <?php
      }
    } 


    ?>

    </table>

    
    <script src="" async defer></script>
  </body>
</html>

