<?php
ob_start();
session_start();
require_once('config/config.php');
include('curl.php');

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $disposableDomains = [
        'tempmail.com', 'mailinator.net', '10minutemail.com',
        'guerrillamail.ac.in', 'trashmail.edu'
    ];
    $domain = strtolower(substr(strrchr($email, "@"), 1)); 

    if (in_array($domain, $disposableDomains)) {
        return false;
    }

    if (!checkdnsrr($domain, "MX")) {
        return false;
    }

    return true;
}


echo "<style>
    h3{  
    position: absolute;
    top: 470px;
    }
    </style>";

if(isset($_POST['submit'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
        echo "<h3 style='color:red;text-align:center;'>Please fill in all fields.</h3>";
    } 
    else {
       
        $email = $_POST['email'];
        $password = $_POST['password'];
        // echo $email;
        $postLoad = json_encode(['action'=>'login','email'=>$email]);
        $res = new curl_function();
        $res->setOptions($postLoad);
        $response = $res->execute();

        if($response['status'] == 'error'){
            echo "<h3 style='color:red;text-align:center;'>".$response['message']."</h3>";
            exit();
        }
        
        if(password_verify($password, $response['message'][0]['password'])){
            $_SESSION['username'] = $response['message'][0]['name'];
            $_SESSION['user_id'] = $response['message'][0]['user_id'];
            $_SESSION['show_contacts'] = true;
            header('Location: index.php');
            exit();
        } 
        else {
            echo "<h3 style='color:red;text-align:center;'>Invalid username or password.</h3>";
        }
    }
}
    

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    if (validateEmail($email)) {
        $postLoad = json_encode(['action' => 'register','email' => $email,'password' => $password,'username' => $username]);
        $res = new curl_function();
        $res->setOptions($postLoad);
        $response = $res->execute();

        if ($response['status'] == 'emailexists') {
            echo "<h3 style='color:red;text-align:center;'>" . $response['message'] . "</h3>";
        } elseif ($response['status'] == 'success') {
            header('Location: login.php');
            exit();
        } else {
            echo "<h3 style='color:red;text-align:center;'>Error: " . $response['message'] . "</h3>";
        }
    } else {
        echo "<h3 style='color:red;text-align:center;'>Email not valid, please enter a valid email address.</h3>";
    }
    
}

?>

<style>

body{
    background-image: linear-gradient(135deg, #a18cd1, #fbc2eb);
    font-family: Arial;
    margin: 0px;
    padding: 0px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container{
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin: auto;
}

h2 
{
      text-align: center;
      margin-bottom: 24px;
      color: #333;
}

.user,.pass{
      width: 100%;
      padding: 10px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }


.btn{
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

.btn:hover {
      background-color: lightgreen;
}
</style>


<div class = 'container'>
    <form  method = 'post'>
        <h2>User Login</h2>
        <label for="email">Email:</label><br>
        <input type="text"  placeholder = 'email' name="email" class = 'user'><br>
        <label for="password">Password:</label><br>
        <input type="password"  name="password" class='pass'><br>
        <input type = 'submit' name = 'submit' value = 'Login' class='btn'>
        <a href='register.php' style = "margin-right:20px;">new user?</a>
    </form>
</div>    


<?php
ob_end_flush();
?>