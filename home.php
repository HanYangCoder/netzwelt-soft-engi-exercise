<?php 
  session_start();
  
  if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
      // User is not authenticated
      header("Location: login.php");
      exit;
  }
?>

<DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
    <div class="home-container">
      <h2>Welcome home!</h2>
      <?php 
        $json = file_get_contents('https://netzwelt-devtest.azurewebsites.net/Territories/All');
        // echo json_encode($json);
      ?>
      <script>
        var json = JSON.stringify(JSON.parse(<?php echo json_encode($json); ?>));
        console.log(json);
      </script>
    </div>
  </body>

</html>