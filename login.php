<?php
//This script will handle login
session_start();

// check if the user is already logged in
if (isset($_SESSION['username'])) {
  header("location: cv2.html");
  exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
    $enteruser = "Please enter username + password";
  } else {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    $wrongpass = "Wrong username/password!";
  }


  if (empty($err)) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;


    // Try to execute this statement
    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
        if (mysqli_stmt_fetch($stmt)) {
          if (password_verify($password, $hashed_password)) {
            // this means the password is corrct. Allow user to login
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $id;
            $_SESSION["loggedin"] = true;

            //Redirect user to welcome page
            header("location: cv2.html");
          }
        }
      }
    }
  }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page in HTML with CSS Code Example</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">

    <style>
    body {
        background-image: linear-gradient(135deg, #0E0836 10%, #2374E1 100%);
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: "Open Sans", sans-serif;
        color: #333333;
        align-items: center;
        position: relative;
        justify-content: center;

    }

    img {
        width: 250px;
        height: 100px;
    }

    .box-form {
        margin: 0 auto;
        width: 50%;
        height: 80%;
        margin-top: 10%;
        background: #FFFFFF;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex: 1 1 100%;
        align-items: stretch;
        justify-content: space-between;
        box-shadow: 0 0 10px 6px #090b6f85;
    }

    @media (max-width: 980px) {
        .box-form {
            flex-flow: wrap;
            text-align: center;
            align-content: center;
            align-items: center;
        }
    }

    .box-form div {
        height: auto;
    }

    .box-form .left {
        color: #FFFFFF;
        width: 80%;
        background-size: cover;
        background-repeat: no-repeat;
        background-image: url("https://i.pinimg.com/736x/5d/73/ea/5d73eaabb25e3805de1f8cdea7df4a42--tumblr-backgrounds-iphone-phone-wallpapers-iphone-wallaper-tumblr.jpg");
        overflow: hidden;
    }

    .box-form .left .overlay {
        padding: 30px;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(135deg, #0E0836 10%, #2374E1 100%);
        overflow: hidden;
        box-sizing: border-box;
    }

    .box-form .left .overlay span p {
        margin-top: 20px;
        font-weight: 800px;
    }

    .box-form .left .overlay span a {
        background: #3b5998;
        color: #FFFFFF;
        margin-top: 10px;
        padding: 10px 20px;
        border-radius: 100px;
        display: inline-block;
        box-shadow: 0 3px 6px 1px #042d4657;
    }

    .box-form .left .overlay span a:last-child {
        background: #0E0836;
        margin-left: 30px;
    }

    .box-form .right {
        padding: 20px;
        overflow: hidden;
    }

    @media (max-width: 980px) {
        .box-form .right {
            width: 100%;
        }
    }

    .box-form .right h5 {
        font-size: 5vmax;
        line-height: 0;
    }

    .box-form .right p {
        font-size: 14px;
        color: #B0B3B9;
    }

    .box-form .right .inputs {
        overflow: hidden;
    }

    .box-form .right input {
        width: 100%;
        padding: 10px;
        margin-top: 25px;
        font-size: 16px;
        border: none;
        outline: none;
        border-bottom: 2px solid #B0B3B9;
    }

    .box-form .right .remember-me--forget-password {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .box-form .right .remember-me--forget-password input {
        margin: 0;
        margin-right: 7px;
        width: auto;
    }

    .box-form .right button {

        color: #fff;
        font-size: 16px;
        padding: 12px 35px;
        border-radius: 50px;
        display: inline-block;
        border: 0;
        outline: 0;

        background-color: #0E0836;
    }

    label {
        display: block;
        position: relative;
        margin-left: 30px;
    }

    label::before {
        content: ' \f00c';
        position: absolute;
        font-family: FontAwesome;
        background: transparent;
        border: 3px solid #70F570;
        border-radius: 4px;
        color: transparent;
        left: -30px;
        transition: all 0.2s linear;
    }

    label:hover::before {
        font-family: FontAwesome;
        content: ' \f00c';
        color: #fff;
        cursor: pointer;
        background: #70F570;
    }

    label:hover::before .text-checkbox {
        background: #70F570;
    }

    label span.text-checkbox {
        display: inline-block;
        height: auto;
        position: relative;
        cursor: pointer;
        transition: all 0.2s linear;
    }

    label input[type="checkbox"] {
        display: none;
    }

    </style>


</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="box-form">
        <div class="left">
            <div class="overlay">
                <img src="Careerversez.png" alt="">
                <br>
                <br>
                <br>

                <span>
                    <p>Don't have an account?</p>
                    <a class="nav-link" style="text-decoration:none" href="register.php">Register</a>


                </span>
            </div>
        </div>


        <div class="right">

            <h1>Login</h1>
            <form action="" method="post">
                <div class="inputs">
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Enter Username">
                    <br>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                        placeholder="Enter Password">
                </div>

                <br><br>



                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- partial -->

</body>
<script>
alert("<?php echo $wrongpass ?>");
</script>

<script>
alert("<?php echo $enteruser ?>");
</script>

</html>
