<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $template['title'] ?></title>

    <link href="<?php echo base_url() ?>assets/admin/img/favicon.144x144.html" rel="apple-touch-icon" type="image/png"
          sizes="144x144">
    <link href="<?php echo base_url() ?>assets/admin/img/favicon.114x114.html" rel="apple-touch-icon" type="image/png"
          sizes="114x114">
    <link href="<?php echo base_url() ?>assets/admin/img/favicon.72x72.html" rel="apple-touch-icon" type="image/png"
          sizes="72x72">
    <link href="<?php echo base_url() ?>assets/admin/img/favicon.57x57.html" rel="apple-touch-icon" type="image/png">
    <link href="<?php echo base_url() ?>assets/admin/img/favicon.html" rel="icon" type="image/png">
    <link href="<?php echo base_url() ?>assets/admin/img/favicon-2.html" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/lib/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/vendor/lobipanel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/lib/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/lib/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/vendor/typeahead.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/separate/vendor/select2.min.css">
    <link rel="stylesheet"
          href="<?php echo base_url() ?>assets/admin/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/main.css">

    <!--Jquery must on top of document-->
    <script src="<?php echo base_url() ?>assets/admin/js/lib/jquery/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>


</head>
<body class="with-side-menu control-panel control-panel-compact">
<input type="hidden" value="<?php echo base_url() ?>" id="base">
<?php if ($this->session->userdata('isLogged') && isset($_GET['token'])): ?>
    <header class="site-header">
        <div class="container-fluid">

            <a href="<?php echo base_url('admin/dashboard?token=' . $this->session->userdata('token')) ?>"
               class="site-logo">
                <span><i class="fa fa-cog"></i> Admin Panel</span>
                <!--
                <img class="hidden-md-down" src="<?php echo base_url() ?>assets/admin/img/logo-2.png" alt="">
                <img class="hidden-lg-up" src="<?php echo base_url() ?>assets/admin/img/logo-2-mob.png" alt="">
                -->
            </a>

            <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
                <span>toggle menu</span>
            </button>

            <button class="hamburger hamburger--htla">
                <span>toggle menu</span>
            </button>
            <div class="site-header-content">
                <div class="site-header-content-in">
                    <div class="site-header-shown">
                        <div class="dropdown dropdown-notification notif">
                            <a href="#"
                               class="header-alarm dropdown-toggle active"
                               id="dd-notification"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <i class="font-icon-alarm"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif"
                                 aria-labelledby="dd-notification">
                                <div class="dropdown-menu-notif-header">
                                    Notifications
                                    <span class="label label-pill label-danger">4</span>
                                </div>
                                <div class="dropdown-menu-notif-list">
                                    <div class="dropdown-menu-notif-item">
                                        <div class="photo">
                                            <img src="<?php echo base_url() ?>assets/admin/img/photo-64-1.jpg" alt="">
                                        </div>
                                        <div class="dot"></div>
                                        <a href="#">Morgan</a> was bothering about something
                                        <div class="color-blue-grey-lighter">7 hours ago</div>
                                    </div>
                                    <div class="dropdown-menu-notif-item">
                                        <div class="photo">
                                            <img src="<?php echo base_url() ?>assets/admin/img/photo-64-2.jpg" alt="">
                                        </div>
                                        <div class="dot"></div>
                                        <a href="#">Lioneli</a> had commented on this <a href="#">Super Important
                                            Thing</a>
                                        <div class="color-blue-grey-lighter">7 hours ago</div>
                                    </div>
                                    <div class="dropdown-menu-notif-item">
                                        <div class="photo">
                                            <img src="<?php echo base_url() ?>assets/admin/img/photo-64-3.jpg" alt="">
                                        </div>
                                        <div class="dot"></div>
                                        <a href="#">Xavier</a> had commented on the <a href="#">Movie title</a>
                                        <div class="color-blue-grey-lighter">7 hours ago</div>
                                    </div>
                                    <div class="dropdown-menu-notif-item">
                                        <div class="photo">
                                            <img src="<?php echo base_url() ?>assets/admin/img/photo-64-4.jpg" alt="">
                                        </div>
                                        <a href="#">Lionely</a> wants to go to <a href="#">Cinema</a> with you to see <a
                                                href="#">This Movie</a>
                                        <div class="color-blue-grey-lighter">7 hours ago</div>
                                    </div>
                                </div>
                                <div class="dropdown-menu-notif-more">
                                    <a href="#">See more</a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown dropdown-notification messages">
                            <a href="#"
                               class="header-alarm dropdown-toggle active"
                               id="dd-messages"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <i class="font-icon-mail"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages"
                                 aria-labelledby="dd-messages">
                                <div class="dropdown-menu-messages-header">
                                    <ul class="nav" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active"
                                               data-toggle="tab"
                                               href="#tab-incoming"
                                               role="tab">
                                                Inbox
                                                <span class="label label-pill label-danger">8</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                               data-toggle="tab"
                                               href="#tab-outgoing"
                                               role="tab">Outbox</a>
                                        </li>
                                    </ul>
                                    <!--<button type="button" class="create">
                                        <i class="font-icon font-icon-pen-square"></i>
                                    </button>-->
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                                        <div class="dropdown-menu-messages-list">
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/photo-64-2.jpg"
                                                        alt=""></span>
                                                <span class="mess-item-name">Tim Collins</span>
                                                <span class="mess-item-txt">Morgan was bothering about something!</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/avatar-2-64.png"
                                                        alt=""></span>
                                                <span class="mess-item-name">Christian Burton</span>
                                                <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/photo-64-2.jpg"
                                                        alt=""></span>
                                                <span class="mess-item-name">Tim Collins</span>
                                                <span class="mess-item-txt">Morgan was bothering about something!</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/avatar-2-64.png"
                                                        alt=""></span>
                                                <span class="mess-item-name">Christian Burton</span>
                                                <span
                                                        class="mess-item-txt">Morgan was bothering about something...</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-outgoing" role="tabpanel">
                                        <div class="dropdown-menu-messages-list">
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/avatar-2-64.png"
                                                        alt=""></span>
                                                <span class="mess-item-name">Christian Burton</span>
                                                <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something...</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/photo-64-2.jpg"
                                                        alt=""></span>
                                                <span class="mess-item-name">Tim Collins</span>
                                                <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/avatar-2-64.png"
                                                        alt=""></span>
                                                <span class="mess-item-name">Christian Burtons</span>
                                                <span class="mess-item-txt">Morgan was bothering about something!</span>
                                            </a>
                                            <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img
                                                        src="<?php echo base_url() ?>assets/admin/img/photo-64-2.jpg"
                                                        alt=""></span>
                                                <span class="mess-item-name">Tim Collins</span>
                                                <span class="mess-item-txt">Morgan was bothering about something!</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-menu-notif-more">
                                    <a href="#">See more</a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown dropdown-lang">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <span class="flag-icon flag-icon-us"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-col">
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-ru"></span>Русский</a>
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-de"></span>Deutsch</a>
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-it"></span>Italiano</a>
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-es"></span>Español</a>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-pl"></span>Polski</a>
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-li"></span>Lietuviu</a>
                                </div>
                                <div class="dropdown-menu-col">
                                    <a class="dropdown-item current" href="#"><span
                                                class="flag-icon flag-icon-us"></span>English</a>
                                    <a class="dropdown-item" href="#"><span
                                                class="flag-icon flag-icon-fr"></span>Français</a>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-by"></span>Беларускi</a>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-ua"></span>Українська</a>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-cz"></span>Česky</a>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-ch"></span>中國</a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown user-menu">
                            <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url() ?>assets/admin/img/avatar-2-64.png" alt="">
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                                <a class="dropdown-item" href="#"><span
                                            class="font-icon glyphicon glyphicon-user"></span>Profile</a>
                                <a class="dropdown-item" href="#"><span
                                            class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
                                <a class="dropdown-item" href="#"><span
                                            class="font-icon glyphicon glyphicon-question-sign"></span>Help</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('admin/auth/logout') ?>"><span
                                            class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
                            </div>
                        </div>

                        <button type="button" class="burger-right">
                            <i class="font-icon-menu-addl"></i>
                        </button>
                    </div><!--.site-header-shown-->

                    <div class="mobile-menu-right-overlay"></div>
                    <div class="site-header-collapsed">
                        <div class="site-header-collapsed-in">
                            <div class="dropdown dropdown-typical">
                                <div class="dropdown-menu" aria-labelledby="dd-header-sales">
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant
                                        and Verbal</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real
                                        Gmat Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep
                                        Official App</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer
                                        Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third
                                        Party Test</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-marketing" data-target="#"
                                   href="http://example.com/" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <span class="font-icon font-icon-cogwheel"></span>
                                    <span class="lbl">Marketing automation</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dd-header-marketing">
                                    <a class="dropdown-item" href="#">Current Search</a>
                                    <a class="dropdown-item" href="#">Search for Issues</a>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Recent issues</div>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant
                                        and Verbal</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real
                                        Gmat Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep
                                        Official App</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer
                                        Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third
                                        Party Test</a>
                                    <div class="dropdown-more">
                                        <div class="dropdown-more-caption padding">more...</div>
                                        <div class="dropdown-more-sub">
                                            <div class="dropdown-more-sub-in">
                                                <a class="dropdown-item" href="#"><span
                                                            class="font-icon font-icon-home"></span>Quant and Verbal</a>
                                                <a class="dropdown-item" href="#"><span
                                                            class="font-icon font-icon-cart"></span>Real Gmat Test</a>
                                                <a class="dropdown-item" href="#"><span
                                                            class="font-icon font-icon-speed"></span>Prep Official
                                                    App</a>
                                                <a class="dropdown-item" href="#"><span
                                                            class="font-icon font-icon-users"></span>CATprer Test</a>
                                                <a class="dropdown-item" href="#"><span
                                                            class="font-icon font-icon-comments"></span>Third Party Test</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Import Issues from CSV</a>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Filters</div>
                                    <a class="dropdown-item" href="#">My Open Issues</a>
                                    <a class="dropdown-item" href="#">Reported by Me</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Manage filters</a>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header">Timesheet</div>
                                    <a class="dropdown-item" href="#">Subscribtions</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-social" data-target="#"
                                   href="http://example.com/"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="font-icon font-icon-share"></span>
                                    <span class="lbl">Social media</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dd-header-social">
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant
                                        and Verbal</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real
                                        Gmat Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep
                                        Official App</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer
                                        Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third
                                        Party Test</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                                <a href="#" class="dropdown-toggle no-arr">
                                    <span class="font-icon font-icon-page"></span>
                                    <span class="lbl">Projects</span>
                                    <span class="label label-pill label-danger">35</span>
                                </a>
                            </div>

                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-form-builder" data-target="#"
                                   href="http://example.com/" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <span class="font-icon font-icon-pencil"></span>
                                    <span class="lbl">Form builder</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dd-header-form-builder">
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant
                                        and Verbal</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real
                                        Gmat Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep
                                        Official App</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer
                                        Test</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third
                                        Party Test</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-rounded dropdown-toggle" id="dd-header-add" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Add
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dd-header-add">
                                    <a class="dropdown-item" href="#">Quant and Verbal</a>
                                    <a class="dropdown-item" href="#">Real Gmat Test</a>
                                    <a class="dropdown-item" href="#">Prep Official App</a>
                                    <a class="dropdown-item" href="#">CATprer Test</a>
                                    <a class="dropdown-item" href="#">Third Party Test</a>
                                </div>
                            </div>
                            <div class="help-dropdown">
                                <button type="button">
                                    <i class="font-icon font-icon-help"></i>
                                </button>
                                <div class="help-dropdown-popup">
                                    <div class="help-dropdown-popup-side">
                                        <ul>
                                            <li><a href="#">Getting Started</a></li>
                                            <li><a href="#" class="active">Creating a new project</a></li>
                                            <li><a href="#">Adding customers</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Importing data</a></li>
                                            <li><a href="#">Exporting data</a></li>
                                        </ul>
                                    </div>
                                    <div class="help-dropdown-popup-cont">
                                        <div class="help-dropdown-popup-cont-in">
                                            <div class="jscroll">
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum is simply
                                                    <span class="describe">Lorem Ipsum has been the industry's standard dummy text </span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Contrary to popular belief
                                                    <span class="describe">Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    The point of using Lorem Ipsum
                                                    <span class="describe">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum
                                                    <span class="describe">There are many variations of passages of Lorem Ipsum available</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum is simply
                                                    <span class="describe">Lorem Ipsum has been the industry's standard dummy text </span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Contrary to popular belief
                                                    <span class="describe">Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    The point of using Lorem Ipsum
                                                    <span class="describe">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum
                                                    <span class="describe">There are many variations of passages of Lorem Ipsum available</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum is simply
                                                    <span class="describe">Lorem Ipsum has been the industry's standard dummy text </span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Contrary to popular belief
                                                    <span class="describe">Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    The point of using Lorem Ipsum
                                                    <span class="describe">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text</span>
                                                </a>
                                                <a href="#" class="help-dropdown-popup-item">
                                                    Lorem Ipsum
                                                    <span class="describe">There are many variations of passages of Lorem Ipsum available</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--.help-dropdown-->
                            <div class="site-header-search-container">
                                <form class="site-header-search closed">
                                    <input type="text" placeholder="Search"/>
                                    <button type="submit">
                                        <span class="font-icon-search"></span>
                                    </button>
                                    <div class="overlay"></div>
                                </form>
                            </div>
                        </div><!--.site-header-collapsed-in-->
                    </div><!--.site-header-collapsed-->
                </div><!--site-header-content-in-->
            </div><!--.site-header-content-->
        </div><!--.container-fluid-->
    </header><!--.site-header-->

    <div class="mobile-menu-left-overlay"></div>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="grey">
                <a href="<?php echo base_url('admin/dashboard') ?>">
                <span>
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </span>
                </a>
            </li>
            <li class="blue">
                <a href="<?php echo base_url('admin/banners?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="fa fa-shopping-bag"></i>
                        <span class="lbl">Banners</span>
                    </span>
                </a>
            </li>
            <li class="brown with-sub">
	            <span>
	                <i class="fa fa-users"></i>
	                <span class="lbl">User Management</span>
	            </span>
                <ul>
                    <li><a href="<?php echo base_url('admin/users?token=' . $this->session->userdata('token')) ?>"><span
                                    class="lbl">Users</span></a></li>
                    <li>
                        <a href="<?php echo base_url('admin/users_group?token=' . $this->session->userdata('token')) ?>"><span
                                    class="lbl">Users Group</span></a>
                    </li>
                </ul>
            </li>
            <li class="green">
                <a href="<?php echo base_url('admin/categories?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="fa fa-sitemap"></i>
                        <span class="lbl">Categories</span>
                    </span>
                </a>
            </li>

            <li class="gold">
                <a href="<?php echo base_url('admin/products?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="fa fa-gift"></i>
                        <span class="lbl">Products</span>
                    </span>
                </a>
            </li>

            <li class="red">
                <a href="<?php echo base_url('admin/stores?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="fa fa-shopping-bag"></i>
                        <span class="lbl">Store</span>
                    </span>
                </a>
            </li>
            <li class="green">
                <a href="<?php echo base_url('admin/offers?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="fa fa-shopping-bag"></i>
                        <span class="lbl">Offers</span>
                    </span>
                </a>
            </li>
            <li class="blue">
                <a href="<?php echo base_url('admin/filemanager?token=' . $this->session->userdata('token')) ?>">
                    <span>
                        <i class="font-icon glyphicon glyphicon-paperclip"></i>
                        <span class="lbl">File Manager</span></span>
                </a>
            </li>
        </ul>

        <section>
            <header class="side-menu-title">Tags</header>
            <ul class="side-menu-list">
                <li>
                    <a href="#">
                        <i class="tag-color green"></i>
                        <span class="lbl">Website</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="tag-color grey-blue"></i>
                        <span class="lbl">Bugs/Errors</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="tag-color red"></i>
                        <span class="lbl">General Problem</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="tag-color pink"></i>
                        <span class="lbl">Questions</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="tag-color orange"></i>
                        <span class="lbl">Ideas</span>
                    </a>
                </li>
            </ul>
        </section>
    </nav><!--.side-menu-->
<?php endif; ?>
<?php echo $template['body'] ?>
<?php if ($this->session->userdata('loggedIn')): ?>
    <div class="control-panel-container">
        <ul>
            <li class="tasks">
                <div class="control-item-header">
                    <a href="#" class="icon-toggle">
                        <span class="caret-down fa fa-caret-down"></span>
                        <span class="icon fa fa-tasks"></span>
                    </a>
                    <span class="text">Task list</span>
                    <div class="actions">
                        <a href="#">
                            <span class="fa fa-refresh"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-cog"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="control-item-content">
                    <div class="control-item-content-text">You don't have pending tasks.</div>
                </div>
            </li>
            <li class="sticky-note">
                <div class="control-item-header">
                    <a href="#" class="icon-toggle">
                        <span class="caret-down fa fa-caret-down"></span>
                        <span class="icon fa fa-file"></span>
                    </a>
                    <span class="text">Sticky Note</span>
                    <div class="actions">
                        <a href="#">
                            <span class="fa fa-refresh"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-cog"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="control-item-content">
                    <div class="control-item-content-text">
                        StartUI – a full featured, premium web application admin dashboard built with Twitter Bootstrap
                        4,
                        JQuery and CSS
                    </div>
                </div>
            </li>
            <li class="emails">
                <div class="control-item-header">
                    <a href="#" class="icon-toggle">
                        <span class="caret-down fa fa-caret-down"></span>
                        <span class="icon fa fa-envelope"></span>
                    </a>
                    <span class="text">Recent e-mails</span>
                    <div class="actions">
                        <a href="#">
                            <span class="fa fa-refresh"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-cog"></span>
                        </a>
                        <a href="#">
                            <span class="fa fa-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="control-item-content">
                    <section class="control-item-actions">
                        <a href="#" class="link">My e-mails</a>
                        <a href="#" class="mark">Mark visible as read</a>
                    </section>
                    <ul class="control-item-lists">
                        <li>
                            <a href="#">
                                <h6>Welcome to the Community!</h6>
                                <div>Hi, welcome to the my app...</div>
                                <div>
                                    Message text
                                </div>
                            </a>
                            <a href="#" class="reply-all">Reply all</a>
                        </li>
                        <li>
                            <a href="#">
                                <h6>Welcome to the Community!</h6>
                                <div>Hi, welcome to the my app...</div>
                                <div>
                                    Message text
                                </div>
                            </a>
                            <a href="#" class="reply-all">Reply all</a>
                        </li>
                        <li>
                            <a href="#">
                                <h6>Welcome to the Community!</h6>
                                <div>Hi, welcome to the my app...</div>
                                <div>
                                    Message text
                                </div>
                            </a>
                            <a href="#" class="reply-all">Reply all</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="add">
                <div class="control-item-header">
                    <a href="#" class="icon-toggle no-caret">
                        <span class="icon fa fa-plus"></span>
                    </a>
                </div>
            </li>
        </ul>
        <a class="control-panel-toggle">
            <span class="fa fa-angle-double-left"></span>
        </a>
    </div>
<?php endif; ?>
<script src="<?php echo base_url() ?>assets/admin/js/lib/tether/tether.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/plugins.js"></script>

<!--bootstrap table-->
<script src="<?php echo base_url() ?>assets/admin/js/lib/bootstrap-table/bootstrap-table.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/lib/bootstrap-table/bootstrap-table-init.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/js/lib/lobipanel/lobipanel.min.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>assets/admin/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/charts/loader.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/lib/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/lib/select2/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/lib/html5-form-validation/jquery.validation.min.js"></script>
<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>


<script>
    $(document).ready(function () {
        $('.panel').lobiPanel({
            sortable: true
        });
        $('.panel').on('dragged.lobiPanel', function (ev, lobiPanel) {
            $('.dahsboard-column').matchHeight();
        });

        $(window).resize(function () {
            setTimeout(function () {
            }, 1000);
        });
    });
    $(function () {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function () {
            setTimeout(function () {
                $('.page-center').matchHeight({remove: true});
                $('.page-center').matchHeight({
                    target: $('html')
                });
            }, 100);
        });
    });
</script>
<script src="<?php echo base_url() ?>assets/admin/js/app.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/MY_Script.js"></script>


</body>
</html>