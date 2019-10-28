<?php
    include 'lib/Session.php';
    Session:: checkLogin();
?>
<?php
    include 'config/config.php';
    include 'lib/DB.php';
    include 'helpers/Format.php';
    $db = new DB();
    $fm = new Format();
?>

<?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email   = $fm->validate($_POST['email']);
                $password   = $fm->validate($_POST['password']);

                $email = mysqli_real_escape_string($db->link, $email);
                $password = mysqli_real_escape_string($db->link, $password);

                $password   = md5($password);
                
                $query      = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";

                $result     = $db->selectData($query);
            
                if ($result != false) {
                    $value  = mysqli_fetch_array($result);
                    $row    = mysqli_num_rows($result);

                    if ($row > 0) {
                        Session::set("login", true);
                        Session::set("email", $value['email']);
                        Session::set("userID", $value['id']);
                        Session::set("successmsg", 'Welcome '.$value['firstname'].'. You are now logged in.');
                        header("Location: home.php");
                    }else{
                        echo "<span class='errors'>No Data Found!!</span>";
                    }
                }else{

                    $errors = 'Email or password not matched!!';
                    //echo "<span style='error'>Email or password not matched!!</span>";
                }
            }   
        ?>

<!doctype html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/font-awesome-animation.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
    <!-- Add your site or application content here -->

    <div class="bg-img">
    </div>
        <div class="signup-form login-form">
                
                <form method="post" action="<?php echo htmlspecialchars('login.php');?>">
                    <div class="login-user-icon"><i class="fas fa-user faa-pulse animated fa-4x"></i></div>

                    <h2>User Login</h2>
                    <div class="input-item">
                        <label>Email <span class="errors blink"> <?php echo $erremail;?></span> </label>
                        <input type="text" name="email"/>
                    </div>

                    <div class="input-item">
                        <label>Password <span class="errors blink"> <?php echo $errpassword; ?></span></label>
                        <input style="float: left;" type="password" name="password" id="psw" required/>

                        <div class="pw-btn" type="button" onclick="myFunction()">
                            <i id="pw-eye" class="fa fa-fw fa-eye"></i>
                        </div>
                        
                        <span class="errors blink"><?php echo $errpassword; ?></span>
                    </div>

                    <div class="input-item">
                        <button type="submit" name="user_login">Login</button>
                    </div>

                    <p>Not yet a member? <a href="signup.php">Create an Account</a></p>

                </form>
            </div>

    
    
<script>
    function myFunction() {
    var x = document.getElementById("psw");
    if (x.type === "password") {
        document.getElementById("pw-eye").className = "fa fa-fw fa-eye-slash";
        x.type = "text";
    } else {
        x.type = "password";
        document.getElementById("pw-eye").className = "fa fa-fw fa-eye";
    }
}
</script>

    <script src="js/vendor/modernizr-3.5.0.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
    </script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/plugins.js">
    </script>
    <script src="js/main.js">
    </script>
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer>
    </script>
  </body>
</html>
