 <!DOCTYPE html>
<html lang="en">
  

<head>
    <title><?php echo $template['title']; ?></title>
    <base href="<?php echo base_url(); ?>" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

   <!-- jQuery library -->
        <script src="<?=base_url(assetsfrontendurl)?>js/jquery.min.js"></script>

        <!-- Latest compiled bootsrt -->
        <script src="<?=base_url(assetsfrontendurl)?>js/bootstrap.min.js"></script>

  <!-- Latest compiled bootsrt -->
        <script src="<?=base_url(assetsfrontendurl)?>js/jquery.dataTables.min.js"></script>


  <!-- load angular -->
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/angular.js"></script>
		<!-- load ngmessages -->
		<script src="<?=base_url(assetsfrontendurl)?>js/angular/angular-messages.js"></script>



      
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script>


		<!-- load our custom app -->

    <script src="<?=base_url(NG)?>vendor/header-front.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-util.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload-shim.js"></script>
    <script src="<?=base_url(NG)?>app.js"></script>

    <script src="<?=base_url(NGModules)?>post/controllers/post.comment.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.detail.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.informasi.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.tutorial.js"></script>


    <script src="<?=base_url(NGModules)?>ticket/controllers/ticket.list.js"></script>
    <script src="<?=base_url(NGModules)?>ticket/controllers/ticket.open.js"></script>
    

    <script src="<?=base_url(NGModules)?>user/controllers/user.login.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.logout.js"></script>

    <script src="<?=base_url(NGModules)?>post/services/postService.js"></script>
    <script src="<?=base_url(NGModules)?>user/services/userService.js"></script>
    <script src="<?=base_url(NGModules)?>ticket/services/ticketService.js"></script>

    <script src="<?=base_url(NGModules)?>user/directives/user.directives.js"></script>

<!-- plugin -->
        <script src="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/js/bootstrap-modal.js"></script>
        <script src="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/js/bootstrap-modalmanager.js"></script>

          <!-- load angular-material -->
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-animate.min.js"></script>
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-aria.min.js"></script>
          
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-material.min.js"></script>
          <link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/angular-material/css/angular-material.min.css">

          <!-- load bootstrap dropdown echantment -->
          <script src="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-dropdown/js/bootstrap-dropdown.js"></script>
          <link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-dropdown/css/bootstrap-dropdown.css">



	
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/bootstrap.min.css">

  <!-- Font awesome -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/font-awesome.css">

<!-- Flat Bootstrap CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/bootstrap-flat.min.css">

<!-- Manual Insert CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/custom/custom_insert.css"></script>
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/custom/custom_home.css"></script>

<!-- bootstrap modal -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/css/bootstrap-modal.css"></script>
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/css/bootstrap-modal-bs3patch.css"></script>

<!-- datatables -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/jquery.dataTables.min.css"></script>



        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/common/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/common/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/common/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/common/ico/apple-touch-icon-57-precomposed.png">




</head>

<body  ng-app="myApp" ng-cloak style="position: relative;">
 <div class="main" style="">
 
	<!-- TOP BAR 
	============================================= -->
	<div>
	<nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".collable">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				
				 
                <a class="navbar-brand" href="<?=base_url()?>#/">
                    <img src="" alt="ST">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse collable" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav nav-left">
                    <li>
                        <a href="knowledgebase">Knowledgebase</a>
                    </li>
                    <li>
                        <a href="memberarea">Technical Support</a>
                    </li>
                    <li>
                        <a href="contact">Contact</a>
                    </li>
                </ul>
				<div >
				    <usernav></usernav>
				
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
<!-- ==================== Header ^ ========================= -->
<div ng-view>
 <?php echo $template['content']; ?>
</div>
<!-- ==================== Content ^ ========================= -->    

<!-- FOOTER ============================================= -->
<div style="width: 100%;height: 20px;position: absolute;bottom: 0">.</div>
    <div class="footer">
 
        <p>&copy; 2016</p>
 
    </div>
    <style>
        .footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 40px;
  background-color: black;
  text-align:center;
}
        
    </style>
    
<!-- END FOOTER 
    ============================================= -->
    
</div>
<!-- END MAIN 
============================================= -->


</body>


</html>

<!-- ==================== Footer ^ ========================= -->    