 <!DOCTYPE html>
<html lang="en">
  

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

  <!-- load angular -->
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/angular.js"></script>
		<!-- load ngmessages -->
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/angular-messages.js"></script>

        <!-- load smarttable -->
        <script src="<?=base_url(assetsfrontendurl)?>js/angular/smart-table.js"></script>

		<!-- load our custom app -->
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/header-front.js"></script>
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/app.js"></script>

	
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/bootstrap.min.css">

  <!-- Font awesome -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/font-awesome.css">

<!-- Flat Bootstrap CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/bootstrap-flat.min.css">

<!-- Manual Insert CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/custom/custom_insert.css"></script>
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/custom/custom_home.css"></script>


<!-- jQuery library -->
<script src="<?=base_url(assetsfrontendurl)?>js/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="<?=base_url(assetsfrontendurl)?>js/bootstrap.min.js"></script>





	










  </head>

  <body  ng-app="myApp">
 
 <div class="main" style="margin-top:70px">
 
	<!-- TOP BAR 
	============================================= -->
	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".collable">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				
				 
                <a class="navbar-brand" href="<?=base_url()?>">
                    <img src="" alt="ST">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse collable" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav nav-left">
                    <li>
                        <a href="#">Knowledgebase</a>
                    </li>
                    <li>
                        <a href="#">Technical Support</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
				<div  ng-controller="userInfo">
				
				<ul class="nav navbar-nav navbar-right" ng-if="<?=!$logged_in?>">
                    <li>
						<a style="padding-bottom: 0px; padding-top: 9px;" href="<?=base_url()?>login"><button style="margin: 0px; width: 100%;" class="btn navbar-btn btn-success"><span class="glyphicon glyphicon-log-in"></span>&nbspLogin</button></a>   
                    </li>
                    
                </ul>
				<ul class="nav navbar-nav navbar-right" style="position:relative;" ng-if="<?=$logged_in?>" >	
					<li>
						 <div class="dropdown" style="padding-bottom: 0px; padding-top: 9px;">
						  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span>&nbsp;
							<strong><?=$username?></strong>
							<span class="glyphicon glyphicon-chevron-down"></span>
						  </button>
						  <ul class="dropdown-menu">
							<li>
							<div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?=$first_name?> <?=$last_name?></strong></p>
                                        <p class="text-left small"><?=$email?></p>
                                        <p class="text-left">
                                            <a href="<?=base_url()?>logout" class="btn btn-primary btn-block btn-sm"><span class="glyphicon glyphicon-log-in"></span>&nbspLogout</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
							</li>
						  </ul>
						</div>  
                    </li>					
				</ul>
				</div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	</div>
	<!-- END TOP BAR 
	============================================= -->

	<!-- HEADER 
	============================================= -->
	
	<!-- END HEADER 
	============================================= -->
	
	
	<style>
		.navbar-login
{
    width: 305px;
    padding: 10px;
    padding-bottom: 0px;
}

.navbar-login-session
{
    padding: 10px;
    padding-bottom: 0px;
    padding-top: 0px;
}

.icon-size
{
    font-size: 87px;
}
	</style>
