<?php include('../../config/constants.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php echo '<link rel="stylesheet" type="text/css" href="/Codebase/Portfolio/'.$AppName.'/assets/css/main.css">'?>
  <script src="https://kit.fontawesome.com/3d76f8d0a5.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Calligraffitti&display=swap" rel="stylesheet">
  <style>
   /*TOP NAV*/
      .top-nav{
          background:lightyellow;
            margin:0; 
            padding:4px 0;
            padding-right:60px;
            text-align:;
            border-bottom: 1px solid #ccc;
        }
        .top-nav span{
          position:absolute;
            right:20px;
            margin:0; 
            padding:0;
        }
        .top-nav a{
          text-decoration:none;
        }
        .top-nav .navbar-brand{
          margin: 0 60px;
          color: silver;
          font-size: 1.4em;
          font-family: 'Calligraffitti', cursive; 
          font-weight: bolder; 
          text-decoration: underline; 
          letter-spacing: 3px;
          font-stretch: ultra-expanded;
        }
        .top-nav .user{
          border:1px solid grey;
            border-radius:50%;
            padding:1px;
            color: grey;
        }
        .top-nav .dropdown-menu{
          background:lightyellow;
        }
        
        /*test*/
        .top-nav .test{
            position:relative;
            color: grey;
            margin:0 60px 0 0;
        }
        .top-nav .test p{
          position:absolute;
          display:inline;
            color:red;
            top: -8px;
            left:10px;
            font-weight:bold;
        }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    
    <!-- Nav -->
    <div class="col col-lg-12 navigation">
      <?php 
        echo'<div class="dropdown top-nav">
              <a class="navbar-brand" href="/Codebase/Portfolio/'.$AppName.'/views/post-views/index.php">Jokative</a>
              <span>
                <a class="test" href="#0">
                  <i class="fas fa-envelope"></i>
                  <p>0</p>
                </a>
                <a class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="user fas fa-user"></i> User\'s Name
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                  <li><a class="dropdown-item" href="/Codebase/Portfolio/'.$AppName.'/views/post-views/dashboard.php"><i class=\'fas fa-edit\'></i>&nbsp;&nbsp;Edit</a></li>   
                  <li><a class="dropdown-item" href="#"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a></li>
                  <li><a class="dropdown-item" href="/Codebase/Portfolio/'.$AppName.'/views/user-views/logout.php"><i class="fas fa-power-off"></i>&nbsp;&nbsp;Logout</a></li>
                </ul>
              </span>
            </div>'
      ?>
    </div>
    <!-- End Nav -->