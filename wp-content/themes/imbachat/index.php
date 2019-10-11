<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?= bloginfo('template_directory'); ?>/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <header class="d-flex align-items-center position-relative">
        <div class="container">
            <div class="row">
                <div class="col col-12 col-md-3 col-lg-6">
                    <a href="/"><img src="" class="logo" alt=""></a>
                </div>
                <div class="col col-12 col-md-6 col-lg-4">
                    <nav class="navbar navbar-left navbar-expand">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav narrow">
                                <li class="nav-item dropdown">
                                    <a class="nav-link mr-4" href="https://imbachat.com//contacts">Contacts</a>
                                </li>
                                <?php if(is_user_logged_in()): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle mr-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                                    <div class="dropdown-menu dropdown-menu-1 animate slideIn" aria-labelledby="navbarDropdown">
                                        <ul class="main-menu">
                                            <li><a href="/user">Cabinet</a></li>
                                            <li><a data-request="onLogout" href="<?php echo wp_logout_url(); ?>">Sign out</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <?php else: ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link mr-4" href="#" data-toggle="modal" data-target="#exampleModal2">Sign in</a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link mr-4" href="https://imbachat.com//help">Help</a>
                                </li>


                            </ul>
                        </div> 
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="user-list">
        <h2>Try chat on test accounts</h2>
        <ul>
            <li style="color: #7b7b7b;">Login - Password
                
            </li>
            <li>vasiliy - Hasol3424?
                <?php if(!is_user_logged_in()): ?>
                <form name="loginform" id="loginform" action="http://wordpress.imbachat.com/wp-login.php" method="post">
                    <input type="hidden" name="log" placeholder="Email" id="userSigninLogin" required value="vasiliy">
                    <input type="hidden" name="pwd" placeholder="Password" id="userSigninPassword" required value="Hasol3424?">
                    <button name="wp-submit" type="submit">Sing in</button>
                    <input type="hidden" name="redirect_to" value="http://wordpress.imbachat.com/">
                </form>
                <?php endif; ?>
            </li>
            <li>seriy - Hasol3424?
                <?php if(!is_user_logged_in()): ?>
                <form name="loginform" id="loginform" action="http://wordpress.imbachat.com/wp-login.php" method="post">
                    <input type="hidden" name="log" placeholder="Email" id="userSigninLogin" required value="seriy">
                    <input type="hidden" name="pwd" placeholder="Password" id="userSigninPassword" required value="Hasol3424?">
                    <button name="wp-submit" type="submit">Sing in</button>
                    <input type="hidden" name="redirect_to" value="http://wordpress.imbachat.com/">
                </form>
                <?php endif; ?>
            </li>
            <li>sean - Hasol3424?
                <?php if(!is_user_logged_in()): ?>
                <form name="loginform" id="loginform" action="http://wordpress.imbachat.com/wp-login.php" method="post">
                    <input type="hidden" name="log" placeholder="Email" id="userSigninLogin" required value="sean">
                    <input type="hidden" name="pwd" placeholder="Password" id="userSigninPassword" required value="Hasol3424?">
                    <button name="wp-submit" type="submit">Sing in</button>
                    <input type="hidden" name="redirect_to" value="http://wordpress.imbachat.com/">
                </form>
                <?php endif; ?>
            </li>
            <li>
                <span>Jack - Hasol3424?</span>
                <?php if(!is_user_logged_in()): ?>
                <form name="loginform" id="loginform" action="http://wordpress.imbachat.com/wp-login.php" method="post">
                    <input type="hidden" name="log" placeholder="Email" id="userSigninLogin" required value="jack" >
                    <input type="hidden" name="pwd" placeholder="Password" id="userSigninPassword" required value="Hasol3424?">
                    <button name="wp-submit" type="submit">Sing in</button>
                    <input type="hidden" name="redirect_to" value="http://wordpress.imbachat.com/">
                </form>
                <?php endif; ?>
            </li>
        </ul>
    </div>
    <style>
        .user-list {
            margin: 20px;
            text-align: center;
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .user-list ul {
            padding: 0;
        }
        .user-list h2 {
            font-size: 24px;
            width: 100%;
            color: black;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .user-list li {
            list-style-type: none;
            margin-top: 20px;
        }
        .user-list span {

        }
        .user-list form{
            margin-top: 15px;
            display: inline-block;
        }
        .user-list button{
            background: white;
            border-radius: 3px;
            border: 1px solid #b9b9b9;
        }
    </style>
    <div class="container position-relative">
        <div class="row">
            <div class="instruction-block">
                <h1>Chat Integration Guide</h1>
                <div class="instruction-block__sec-1">
                    <ul>
                                <li><a href="https://github.com/imbasynergy/ImbaChat-OctoberCMS">Chat plugin for WordPress</a></li>
                                <li><a href="https://github.com/imbasynergy/ImbaChat-OctoberCMS-demo">The source code of this site</a></li>
                            </ul>
                </div>
                <h1>Help</h1>
                <div class="instruction-block__sec-1">
                        <p>You can  <a href="https://imbachat.com/help">request a free help in integrating chat into your site. </a> </p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container position-relative">
        <div class="row pb-2">
            <div class="col col-12 col-md-8 col-lg-5 footer-text">
                <div class="narrow">
                    <h4 class="mb-3">support and update features</h4>
                    <p>We are ready to support each customer in updating and installing the chat application on the site.</p>
                </div>
            </div>
            <div class="col col-12 col-md-4 col-lg-3">
                <a class="nav-link no-arrow" href="https://imbachat.com/contacts">Contacts</a>
            </div>
            <div class="col col-12 col-md-6 col-lg-4 footer-menu">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav narrow">
                            <li class="nav-item dropdown dropup">
                                <a class="nav-link dropdown-toggle no-arrow" href="https://imbachat.com/help">Help</a>
                                
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col col-12 col-md-4 col-lg-3 copyright d-flex justify-content-end align-items-center">
                <span>© 2019 ImbaChat. All rights reserved.</span>
            </div>
        </div>
    </div>
    </footer>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                <form name="loginform" id="loginform" action="http://wordpress.imbachat.com/wp-login.php" method="post" class="d-flex flex-column justify-content-center align-items-center">
                    <input type="text" name="log" placeholder="Email" id="user_login" required>
                    <input type="password" name="pwd" placeholder="Password" id="user_pass" required>
                    <button type="submit" id="wp-submit" name="wp-submit">Sing in</button>
                    <input type="hidden" name="redirect_to" value="http://wordpress.imbachat.com/">
					<input type="hidden" name="testcookie" value="1">
                    <a class="link-reset_pass" href="http://wordpress.imbachat.com/wp-login.php?action=lostpassword">Forgot password?</a>
                    <a class="link-registrate" href="http://wordpress.imbachat.com/wp-login.php?action=register">Registration</a>
                </form>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('imbachat'); ?>
</body>
</html>