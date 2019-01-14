<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
   <!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <title>SQL Injection Simulation</title> -->
   <title>Banco Poupamais</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<meta name="keywords" content="Corporate Bank a Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- .css files -->
    <link href="css/bars.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/font-awesome.css" />
<!-- //.css files -->
<!-- Default-JavaScript-File -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- //Default-JavaScript-File -->
<!-- fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Ropa+Sans:400,400i&amp;subset=latin-ext" rel="stylesheet">
<!-- //fonts -->
<!-- scrolling script -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){     
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>
<script src="js/jarallax.js"></script>
    <script src="js/SmoothScroll.min.js"></script>
    <script type="text/javascript">
        /* init Jarallax */
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        })
    </script>

    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    
    <!-- here stars scrolling icon -->
    <script type="text/javascript">
        $(document).ready(function() {
            /*
                var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
                };
            */
                                
            $().UItoTop({ easingType: 'easeOutQuart' });
                                
            });
    </script>
    <!-- //here ends scrolling icon -->
    <script src="js/bars.js"></script>
<!-- //scrolling script -->
</head>
<body style="font-family: helvetica, arial, sans;">
<?php

/*
    This was written by Davo Smith ( http://www.davodev.co.uk )
    For what it is worth, it is released under the GPL version 3 or above
*/

$username = false;
$password = false;
$loginok = false;
$realname = false;

$users = array(
               array('username'=>'bob','password'=>'axp149','realname'=>'System Administrator'),
               array('username'=>'dave','password'=>'davepass','realname'=>'David Jones'),
               array('username'=>'sam','password'=>'cheese','realname'=>'Sam Davis')
               );

if (isset($_REQUEST['username'])) { 
    $username = strtolower($_REQUEST['username']);
}

if (isset($_REQUEST['password'])) {
    $password = $_REQUEST['password'];
}

// Remove any 'magic quotes' (if set)
if (get_magic_quotes_gpc()) {
    $username = stripslashes($username);
    $password = stripslashes($password);
}

// Check for 'proper' login
foreach ($users as $user) {
    if ($username == $user['username'] && $password == $user['password']) {
        $loginok = true;
        $realname = $user['realname'];
        $result = "Found 1 result:<br/>username: {$user['username']}, password: {$user['password']}, realname: {$user['realname']}";
    }
}

if (!$loginok) {
    // Split the username by the ' character
    $usersplit = explode('\'', $username);

    if (count($usersplit) == 1) {
        // No 'proper' login and no attempt at SQL injection
        $result = 'No records found';

    } else if (count($usersplit) % 2 == 0) { // Should have odd number of sections, otherwise there is a problem
        $result = 'SQL error - invalid query';
    } else {
        $conn = strtolower(trim($usersplit[1]));
        if ($conn != 'or' && $conn != 'and') {
            $result = 'SQL error - invalid query';
        } else {
            if ($conn == 'or') {
                if (trim($usersplit[3]) == '=') {
                    if (trim($usersplit[2]) == trim($usersplit[4])) {
                        // Correctly inserted: OR 'XX'='XX
                        $loginok = true;
                    }
                }
            }

            if ($loginok) {
                // Display all records - selet the first as the 'logged in' user
                $result = 'Found '.count($users).' results<br/>';
                foreach ($users as $user) {
                    $result .= "username: {$user['username']}, password: {$user['password']}, realname: {$user['realname']}<br/>";
                }
                $realname = $users[0]['realname'];
            } else {
                $result = 'No records found';
            }
        }
    }
}

if ($loginok) {
    echo "<h1>Welcome, $realname</h1>";
    echo '<p>Here is some top secret information, that only you should be able to access</p>';
    echo '<p><a href="sqlinjectsim.php">Logout</a></p>';

} else {
    echo '<h1>Welcome to this site</h1>';
    echo '<p>Please login below:</p>';

    $loginname = '';
    if ($username) {
        echo '<p style="color: red;">Username / password is incorrect</p>';
        $loginname = $username;
    }

    echo '
    <div class="top-main">
        <!-- <div class="number">
            <h3><i class="fa fa-phone" aria-hidden="true"></i> +91 080 987 6541</h3>
            <div class="clearfix"></div>
        </div>
        <div class="social-icons">
        <ul class="top-icons">
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
        </ul>
        <div class="form-top">
          <form action="#" method="post" class="navbar-form navbar-left">
            <div class="form-group">
                <input type="search" class="form-control" placeholder="Buscar">
            </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button> -->
                <!-- <button type="submit" class="btn btn-default">Submit</button> -->
            <!-- </form>
        </div>
            <div class="clearfix"></div>
        </div>
            <div class="clearfix"></div> -->
    </div>
        <!-- Top-Bar -->
        <div class="top-bar">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#index.html" class="scroll">O BANCO</a></li>
                            <li><a href="#about" class="scroll">INSTITUCIONAL</a></li>
                            <li><a href="#services" class="scroll">SERVICOS</a></li>
                            <li><a href="#skills" class="scroll">BLOG</a></li>
                            <li><a href="#team" class="scroll">CONSÓRCIO</a></li>
                            <li><a href="#payment" class="scroll">PAGONLINE</a></li>
                            <li><a href="#blog" class="scroll">BLOG</a></li>
                            <li><a href="#contact" class="scroll">CONTATO</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="logo">
            <a href="index.html"><!--<i class="fa fa-inr" aria-hidden="true"></i>-->Banco <span>Poupamais</span></a>
        </div>
        <!-- //Top-Bar -->
        <div class="banner-main jarallax">
            <div class="container">
                <div class="banner-inner">
                    <div class="col-md-5 banner-left">
                        <form action="#" method="post" action="sqlinjectsim.php">
                        <h3>Start savings account</h3>
                            <input type="text" placeholder="Conta" required="" name="username" value=""/>
                            <input type="password" placeholder="Senha" required="" name="password" value=""/>
                            <div class="submit">
                                <input type="submit" name="login"value="entrar">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-7 banner-right">
                        <h1>Conheça o Banco Poupamais</h1>
                        <h4>Plataforma 100% online. Seu banco, seus serviços, todos os serviços sem tarifa.</h4>
                            <div class="banner-right-text">
                                <div class="main-icon">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </div>
                                <p>Transferências TED ilimitadas.</p>
                            <div class="clearfix"></div>
                            </div>
                            <div class="banner-right-text">
                                <div class="main-icon">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </div>
                                <p>Agendamento de boletos.</p>
                            <div class="clearfix"></div>
                            </div>
                            <div class="banner-right-text">
                                <div class="main-icon">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </div>
                                <p>Investimentos diversificados.</p>
                            <div class="clearfix"></div>
                            </div>
                            <div class="banner-right-text">
                                <div class="main-icon">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </div>
                                <p>Seguros parasua casa, seu carro, suas viagens.</p>
                            <div class="clearfix"></div>
                            </div>
                            <div class="banner-right-text">
                                <div class="main-icon">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </div>
                                <p>Atendimento 24h por dia.</p> 
                            <div class="clearfix"></div>
                            </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
<!-- about -->
<section class="about" id="about">
    <div class="container">
    <div class="about-heading">
        <h2>O Banco</h2>
    </div>
        <div class="about-grids">
        <div class="col-md-6 about-left">
            <img src="images/1.jpg" alt="" />
        </div>
        <div class="col-md-6 about-right">
            <h3>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</h3>
            <p>Phasellus lorem enim, aliquet vitae pharetra a, vehicula sed risus. Suspendisse rhoncus, ligula ut bibendum imperdiet, nibh lectus gravida lorem, at tristique eros turpis in tortor.</p>
            <p>Phasellus lorem enim, aliquet vitae pharetra a, vehicula sed risus. Suspendisse rhoncus, ligula ut bibendum imperdiet, nibh lectus gravida lorem, at tristique eros turpis in tortor.</p>
            <div class="more">
                <a href="#" data-toggle="modal" data-target="#myModal">Read More</a>
            </div>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>
</section>
<!-- //about -->

<!-- services -->
<section class="services" id="services">
    <div class="container">
        <div class="services-heading">
            <h3>services</h3>
        </div>
        <div class="service-grids">
            <div class="service-grid-top">
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-usd" aria-hidden="true"></i>
                        </div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-university" aria-hidden="true"></i>
                        </div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="service-grid-bottom">
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-handshake-o" aria-hidden="true"></i></div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                        </div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="col-md-4 service-grid-1">
                    <div class="service-grid-text">
                        <div class="icon">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                        </div>
                        <h4>lorem ipsum</h4>
                        <p>Proin feugiat, lorem ut consequat pellentesque, dolor est consequat lorem, eu condimentum tortor justo id lectus.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- //services -->

<!-- clients -->
<section class="skills" id="skills">
    <div class="container">
        <div class="skills-heading">
            <h3>Our growth</h3>
        </div>
        <div class="col-md-2 career-growth">
            <h4>2017 :</h4>
            <h4>2015 :</h4>
            <h4>2011 :</h4>
            <h4>2006 :</h4>
            <h4>2001 :</h4>
        </div>

    </div>
</section>
<!-- //clients -->

<!--team-->
<div class="team" id="team">
    <div class="container">
        <h4 class="title-w3">Team</h4>
        <div class="team-grids">
        <div class="col-md-3 team-gds wow fadeInLeft animated" data-wow-delay=".5s">
            <div class="gal-grid-rev vertical">
                <div class="img-box-content"><img src="images/t1.jpg" alt=" " /></div>
                    <div class="gal-text-box">
                        <div class="info-gal-con">
                            <div class="social-content">
                                <ul>
                                    <li class="facebook"><a class=" hvr-underline-from-center" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="twitter"><a class="ico2 hvr-underline-from-center" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li class="pinterest"><a class="ico3 hvr-underline-from-center" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li class="linkedin"><a class="ico4 hvr-underline-from-center" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>           
                            </div>
                        </div>
                    </div>
            </div>
            <h4>michael</h4>
            <p>CEO</p>
        </div>
        <div class="col-md-3 team-gds wow fadeInUp animated" data-wow-delay=".5s">
            <div class="gal-grid-rev vertical">
                <div class="img-box-content"><img src="images/t2.jpg" alt=" " /></div>
                    <div class="gal-text-box">
                        <div class="info-gal-con">
                            <div class="social-content">
                                <ul>
                                    <li class="facebook"><a class="ico1 hvr-underline-from-center" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="twitter"><a class="ico2 hvr-underline-from-center" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li class="pinterest"><a class="ico3 hvr-underline-from-center" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li class="linkedin"><a class="ico4 hvr-underline-from-center" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>           
                            </div>
                        </div>
                    </div>
            </div>
            <h4>johnson</h4>
            <p>Manager </p>
        </div>
        <div class="col-md-3 team-gds wow fadeInDown animated three" data-wow-delay=".5s">
            <div class="gal-grid-rev vertical">
                <div class="img-box-content"><img src="images/t3.jpg" alt=" " /></div>
                    <div class="gal-text-box">
                        <div class="info-gal-con">
                            <div class="social-content">
                                <ul>
                                    <li class="facebook"><a class="ico1 hvr-underline-from-center" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="twitter"><a class="ico2 hvr-underline-from-center" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li class="pinterest"><a class="ico3 hvr-underline-from-center" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li class="linkedin"><a class="ico4 hvr-underline-from-center" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>           
                            </div>
                        </div>
                    </div>
            </div>
            <h4>corbin</h4>
            <p>Director </p>
        </div>
        <div class="col-md-3 team-gds wow fadeInRight animated four" data-wow-delay=".5s">
            <div class="gal-grid-rev vertical">
                <div class="img-box-content"><img src="images/t4.jpg" alt=" " /></div>
                    <div class="gal-text-box">
                        <div class="info-gal-con">
                            <div class="social-content">
                                <ul>
                                    <li class="facebook"><a class="ico1 hvr-underline-from-center" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="twitter"><a class="ico2 hvr-underline-from-center" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li class="pinterest"><a class="ico3 hvr-underline-from-center" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li class="linkedin"><a class="ico4 hvr-underline-from-center" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>           
                            </div>
                        </div>
                    </div>
            </div>
            <h4>ferdan</h4>
            <p>Chair man </p>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
</div>
<!--//team-->

<!-- payment -->
<section class="payment jarallax" id="payment">
    <div class="container">
        <div class="payments-heading">
            <h3>Our Payments</h3>
        </div>
        <div class="payment-grids">
        <div class="col-md-3 payment-grid">
            <i class="fa fa-cc-visa" aria-hidden="true"></i>
            <h5>visa card</h5>
        </div>
        <div class="col-md-3 payment-grid">
            <i class="fa credit fa-credit-card-alt" aria-hidden="true"></i>
            <h5>credit card</h5>
        </div>
        <div class="col-md-3 payment-grid">
            <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
            <h5>master card</h5>
        </div>
        <div class="col-md-3 payment-grid">
            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
            <h5>debit card</h5>
        </div>
        <div class="clearfix"></div>
        </div>
    </div>
</section>
<!-- //payment -->

<!-- our blog -->
<section class="blog" id="blog">
    <div class="container">
        <div class="blog-heading">
            <h3>Our blog</h3>
        </div>
        <div class="blog-grids">
        <div class="col-md-4 blog-grid">
            <a href="#"><img src="images/b2.jpg" alt="" /></a>
            <h5><i class="fa fa-calendar" aria-hidden="true"></i> 21/2/2017 | by <i class="fa fa-user" aria-hidden="true"></i> <a href="#"> Admin</a></h5>
            <h4><a href="#" data-toggle="modal" data-target="#myModal">lorem ipsum</a></h4>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum orci justo, vehicula vel sapien et, feugiat tristique sapien. Integer sit amet dictum libero.</p>
        </div>
        <div class="col-md-4 blog-grid">
            <a href="#"><img src="images/b1.jpg" alt="" /></a>
            <h5><i class="fa fa-calendar" aria-hidden="true"></i> 20/2/2017 | by <i class="fa fa-user" aria-hidden="true"></i> <a href="#"> Admin</a></h5>
            <h4><a href="#" data-toggle="modal" data-target="#myModal">dolor sit</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum orci justo, vehicula vel sapien et, feugiat tristique.</p>
        </div>
        <div class="col-md-4 blog-grid">
            <a href="#"><img src="images/b3.jpg" alt="" /></a>
            <h5><i class="fa fa-calendar" aria-hidden="true"></i> 19/2/2017 | by <i class="fa fa-user" aria-hidden="true"></i> <a href="#"> Admin</a></h5>
            <h4><a href="#" data-toggle="modal" data-target="#myModal">sit amet</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum orci justo, vehicula vel sapien et, feugiat tristique sapien. Integer sit amet.</p>
        </div>
        <div class="clearfix"></div>
        </div>
    </div>
</section>
<!-- //our blog -->

<!-- modal -->
    <div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="span1"aria-hidden="true">&times;</span></button>                       
                        <h4 class="modal-title"> Corporate<span> Bank</span></h4>
                    </div> 
                    <div class="modal-body">
                    <div class="agileits-w3layouts-info">
                        <img src="images/business.jpg" alt="" />
                        <p>Duis venenatis, turpis eu bibendum porttitor, sapien quam ultricies tellus, ac rhoncus risus odio eget nunc. Pellentesque ac fermentum diam. Integer eu facilisis nunc, a iaculis felis. Pellentesque pellentesque tempor enim, in dapibus turpis porttitor quis. Suspendisse ultrices hendrerit massa. Nam id metus id tellus ultrices ullamcorper.  Cras tempor massa luctus, varius lacus sit amet, blandit lorem. Duis auctor in tortor sed tristique. Proin sed finibus sem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- //modal -->
    
<!-- contact -->
<section class="contact" id="contact">
    <div class="container">
        <div class="contact-heading">
            <h3>Contact us</h3>
        </div>
        <div class="contact-grids">
            <div class=" col-md-6 contact-form">
                <form action="#" method="post">
                        <input type="text" placeholder="Subject" required=""/>
                        <input type="text" placeholder="Your name" required=""/>
                        <input type="email" placeholder="Your mail" required=""/>
                        <textarea placeholder="Message" required=""></textarea>
                        <div class="submit1">
                            <input type="submit" value="submit">
                        </div>
                </form>
            </div>
            <div class=" col-md-6 map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d167998.10803373056!2d2.2074740643680624!3d48.85877410312378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e1f06e2b70f%3A0x40b82c3688c9460!2sParis%2C+France!5e0!3m2!1sen!2sin!4v1488168816174"></iframe>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<!-- //contact -->

<!-- footer -->
<section class="footer">
    <div class="container">
        <div class="footer-grids">
            <div class="col-md-4 footer-grid1">
                <div class="logo1">
                    <a href="index.html">Corporate <span>Bank</span></a>
                </div>
                <p> Donec in neque quis orci consequat lobortis. Sed non vestibulum mauris. Donec in neque quis orci</p>
                <p> Donec in neque quis orci consequat lobortis. Sed non vestibulum mauris. Donec in neque quis orci</p>
            </div>
            <div class="col-md-3 footer-grid2">
                <h4>Locations</h4>
                <p class="p1">Stoke Newington,London,</p>
                <p>Smith street,8814DM</p>
                <p class="p1">Paris,arrondissement</p>
                <p>on the Right Bank,2216TF</p>
                <p class="p1">Los Vegas,Nevada,</p>
                <p>Eiffel Tower road,2243FR</p>
            </div>
            <div class="col-md-2 footer-grid3">
                <h4>menu</h4>
                    <p><a href="#index.html" class="scroll">O BANCO</a></p>
                    <p><a href="#about" class="scroll">INSTITUCIONAL</a></p>
                    <p><a href="#services" class="scroll">SERVICOS</a></p>
                    <p><a href="#skills" class="scroll">BLOG</a></p>
                    <p><a href="#team" class="scroll">CONSÓRCIO</a></p>
                    <p><a href="#payment" class="scroll">PAGONLINE</a></p>
                    <p><a href="#blog" class="scroll">BLOG</a></p>
                    <p><a href="#contact" class="scroll">CONTATO</a></p>
            </div>
            <div class="col-md-3 footer-grid4">
                <h4>our links</h4>
                <p><a href="#">Funds transfer</a></p>
                <p><a href="#">Mobile banking</a></p>
                <p><a href="#">Deposits</a></p>
                <p><a href="#">New joint accounts</a></p>
                <p><a href="#">Internet online banking</a></p>
                <p><a href="#">Balance enquiry</a></p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<!-- //footer -->

<!-- copyright -->
<section class="copyright">
    <div class="agileits_copyright text-center">
            <p>© 2017 Corporate Bank. All rights reserved | Design by <a href="//w3layouts.com/" class="w3_agile">W3layouts</a></p>
    </div>
</section>
<!-- //copyright -->';
    // echo '<label style="width:80px; display:inline-block; text-align:right;" for="username">Username:</label><input id="username" name="username" type="text" value="'.$loginname.'" /><br />';
    // echo '<label style="width:80px; display:inline-block; text-align:right;" for="password">Password:</label><input id="password" name="password" type="password" value="" /><br />';
    // echo '<input type="submit" name="login" value="Login" />';
    // echo '</form>';
}

if ($username) {
    // Login was attempted, so give a 'behind the scenes' look at the SQL query
    echo '<br />';
    echo '<div style="border:solid 1px black; padding: 10px; background-color: #ffffa0;">';
    echo '<h2>This is what happened on the server</h2>';
    echo '<p>SQL Query:<br />';
    echo "SELECT * from `users` WHERE username='$username' AND password='$password'; <br/>";
    echo $result.'<br/>';
}

?>
</body>
</html>