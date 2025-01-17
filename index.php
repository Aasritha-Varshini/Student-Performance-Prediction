<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins');
    /* BASIC */
    html {
      background-color: rgba(0, 0, 0, 0.1);
    }
    body {
      font-family: "Poppins", sans-serif;
      height: 100vh;
    }
    a {
      color: #92badd;
      display: inline-block;
      text-decoration: none;
      font-weight: 400;
    }
    h2 {
      text-align: center;
      font-size: 16px;
      font-weight: 600;
      text-transform: uppercase;
      display: inline-block;
      margin: 40px 8px 10px 8px;
      color: #cccccc;
    }
    /* STRUCTURE */
    .wrapper {
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
      width: 100%;
      min-height: 100%;
      padding: 20px;
      margin-top: -2%;
    }
    #formContent {
      -webkit-border-radius: 10px 10px 10px 10px;
      border-radius: 10px 10px 10px 10px;
      background: #fff;
      padding: 30px;
      width: 90%;
      max-width: 450px;
      position: relative;
      padding: 0px;
      -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
      box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
      text-align: center;
    }
    #formFooter {
      background-color: #f6f6f6;
      border-top: 1px solid #dce8f1;
      padding: 25px;
      text-align: center;
      -webkit-border-radius: 0 0 10px 10px;
      border-radius: 0 0 10px 10px;
    }
    /* TABS */
    h2.inactive {
      color: #cccccc;
    }
    h2.active {
      color: #0d0d0d;
      font-size: 25px;
      border-bottom: 2px solid #5fbae9;
    }
    /* FORM TYPOGRAPHY*/
    input[type=button],
    input[type=submit],
    input[type=reset] {
      background-color: #56baed;
      border: none;
      color: white;
      padding: 15px 80px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      text-transform: uppercase;
      font-size: 13px;
      -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
      box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
      -webkit-border-radius: 5px 5px 5px 5px;
      border-radius: 5px 5px 5px 5px;
      margin: 5px 20px 40px 20px;
      -webkit-transition: all 0.3s ease-in-out;
      -moz-transition: all 0.3s ease-in-out;
      -ms-transition: all 0.3s ease-in-out;
      -o-transition: all 0.3s ease-in-out;
      transition: all 0.3s ease-in-out;
    }
    input[type=button]:hover,
    input[type=submit]:hover,
    input[type=reset]:hover {
      background-color: #39ace7;
      cursor: pointer;
    }
    input[type=button]:active,
    input[type=submit]:active,
    input[type=reset]:active {
      -moz-transform: scale(0.95);
      -webkit-transform: scale(0.95);
      -o-transform: scale(0.95);
      -ms-transform: scale(0.95);
      transform: scale(0.95);
    }
    input[type=text],
    input[type=password] {
      background-color: #0094cf0c;
      border: none;
      color: #0d0d0d;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 12px 5px;
      width: 85%;
      border: 2px solid #f6f6f6;
      -webkit-transition: all 0.5s ease-in-out;
      -moz-transition: all 0.5s ease-in-out;
      -ms-transition: all 0.5s ease-in-out;
      -o-transition: all 0.5s ease-in-out;
      transition: all 0.5s ease-in-out;
      -webkit-border-radius: 5px 5px 5px 5px;
      border-radius: 5px 5px 5px 5px;
    }
    input[type=text]:focus,
    input[type=password]:focus {
      background-color: #fff;
      border-bottom: 2px solid #5fbae9;
    }
    input[type=text]:placeholder {
      color: #cccccc;
    }
    .underlineHover:hover {
      color: #0d0d0d;
    }
    .underlineHover:hover:after {
      width: 100%;
    }
    /* OTHERS */
    *:focus {
      outline: none;
    }
    #icon {
      width: 60%;
    }
    * {
      box-sizing: border-box;
    }
    @media screen and (max-width:800px) {
      .wrapper {
        margin-top: -4%;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
      <h1>Student Login</h1>
      <!-- Login Form -->
      <form action="checkScript.php" method='post'>
        <input type="text" id="login" class="fadeIn second" name="user" placeholder="username">
        <input type="password" id="password" class="fadeIn third" name="pwd" placeholder="password">
        <input type="submit" id='sbtn' class="fadeIn fourth" value="Log In" name="loginbtn">
      </form>
      <!-- Remind Password -->
      <div id="formFooter">
        <?php
        if (isset($_GET['err']) && $_GET['err'] == 1) {
          echo '<p style="color:red">Invalid Credentials</p>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
