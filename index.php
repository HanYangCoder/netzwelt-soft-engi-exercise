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

    <form action="authentication.php" method="post">
        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" id="username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" id="password" name="password" required>

            <button type="submit">Login</button>
        </div>
    </form>

	<script src="index.js"></script>
  </body>
</html>

<?php 
  // $username = "foo";
  // $password = "bar";
  // $url = "https://netzwelt-devtest.azurewebsites.net/Account/SignIn";
  
  // $data = array("username" => $username, "password" => $password);
  
  // $postdata = json_encode($data);
  
  // $ch = curl_init($url); 
  // curl_setopt($ch, CURLOPT_POST, 1);
  // curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  // $result = curl_exec($ch);

  // $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  // if ($status == 200) {
  //   // Successful response
  //   // session_start();
  //   // setcookie("session_cookie", session_id(), time() + 3600, "/");
  //   // $_SESSION["authenticated"] = true;
  //   // echo $result;
  //   echo $status;
  //   // header("Location: home.php");
    
  // }
  // else {
  //   // Unsuccessful response
  //   echo "Request failed with status code $status";
  // }

  // curl_close($ch);
?>