<?php

  $username = $_POST['username'];
  $password = $_POST['password'];
  // $username = "foo";
  // $password = "bar";
  $url = 'https://netzwelt-devtest.azurewebsites.net/Account/SignIn';

  $data = array("username" => $username, "password" => $password);
  
  $postdata = json_encode($data);
  
  $ch = curl_init($url); 
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch);

  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if ($status == 200) {
    // Successful response
    session_start();
    setcookie("session_cookie", session_id(), time() + 3600, "/");
    $_SESSION["authenticated"] = true;
    // echo $result;
    // echo $status;
    header("Location: home.php");
    
  }
  else {
    // Unsuccessful response
    echo "Request failed with status code $status";
  }

  curl_close($ch);


  // $ch = curl_init();

  // curl_setopt($ch, CURLOPT_URL, $url);
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
  // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  
  // $response = curl_exec($ch);
  // $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  // if ($status == 200) {
  //     // Successful response
  //     session_start();
  //     setcookie("session_cookie", session_id(), time() + 3600, "/");
  //     $_SESSION["authenticated"] = true;
  //     echo $response;
  // } else {
  //     // Unsuccessful response
  //     echo "Request failed with status code $status";
  // }
  
  // curl_close($ch);
?>