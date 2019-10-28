<?php
include 'lib/Session.php';
Session::checkSession();
?>
<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

  //or, if you DO want a file to cache, use:
  header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)

  ?>
  <?php
  include 'config/config.php';
  include 'lib/DB.php';
  include 'helpers/Format.php';

  $db = new DB();
  $fm = new Format();
  ?>
  <?php
  $maleavatar = "<img src='img/male.png'/>";
  $femaleavatar = "<img src='img/female.png'/>";
  ?>
  <!doctype html>
  <html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
      <?php echo TITLE; ?>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/font-awesome-animation.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">

    <script type="text/javascript" src="js/jspdf.min.js"></script>
    <script type="text/javascript" src="js/html2canvas.js"></script>
    <script type="text/javascript">
    function genPDF(){
      html2canvas(document.getElementById('content'),{
        onrendered: function (canvas) {
          var pdf = new jsPDF('p', 'mm', [297, 210]);
          var img = canvas.toDataURL("image/png");
          var doc = new jsPDF();
          doc.addImage(img, 'PNG',5,5,200,80);
          doc.save('ledger.pdf');
      }
  });
  }
</script>

  </head>
  <body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<!-- Add your site or application content here -->    
<header class="headsection">
  <div class="container-fluid">
    <nav class="navbar navbar-inverse">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home.php"><?php echo TITLE;?></a>
        <?php
        $userID = $_SESSION['userID'];
        $query = "SELECT * FROM user WHERE id='$userID'";
        $result = $db->selectData($query);
        if ($result) {
          $user = mysqli_fetch_array($result);
        }
        ?>
        <div class="user-name">
          <a href="profile.php?id=<?php echo $userID;?>">
            <?php

            if (!empty($user['pimg'])) {
              ?>
              <img src="user_image/<?php echo $user['pimg'];?>"/>
              <?php
            }else{
              if ($user['gender']=='Male') {
                echo $maleavatar;
              }else{
                echo $femaleavatar;
              }
            }
            ?>    
            <h4><?php echo $user['firstname'].' '.$user['lastname'];?></h4></a>
          </div>
        </div>          
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Home</a></li>   
            <form class="navbar-form navbar-left">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Go</button>
            </form>
            <?php
            if (isset($_GET['action']) && $_GET['action']=='logout') {
              Session::destroy();
            }
            ?>
            <li><a href="?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>   
          </ul>
        </div>
      </nav>
    </div>
  </header>