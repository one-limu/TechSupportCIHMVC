<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login Form Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?=base_url(assetsbackendurl)?>login/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url(assetsbackendurl)?>login/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url(assetsbackendurl)?>login/css/form-elements.css">
        <link rel="stylesheet" href="<?=base_url(assetsbackendurl)?>login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?=base_url(assetsbackendurl)?>login/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url(assetsbackendurl)?>login/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=base_url(assetsbackendurl)?>login/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url(assetsbackendurl)?>login/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?=base_url(assetsbackendurl)?>login/ico/apple-touch-icon-57-precomposed.png">

		<!-- Javascript -->
        <script src="<?=base_url(assetsbackendurl)?>login/js/jquery-1.11.1.min.js"></script>
        <script src="<?=base_url(assetsbackendurl)?>login/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url(assetsbackendurl)?>login/js/jquery.backstretch.min.js"></script>
        <script src="<?=base_url(assetsbackendurl)?>login/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="<?=base_url(assetsbackendurl)?>login/js/placeholder.js"></script>
        <![endif]-->
		
		<!-- load angular -->
		<script src="<?=base_url(assetsbackendurl)?>login/js/angular.js"></script>

		<!-- load ngmessages -->
		<script src="<?=base_url(assetsbackendurl)?>login/js/angular-messages.js"></script>

		<!-- load our custom app -->
		<script src="<?=base_url(assetsbackendurl)?>login/js/app.js"></script>
		
		
    </head>

    <body ng-app="app" ng-controller="MainCtrl as main">

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>TSS</strong> Login Form</h1>
                            <div class="description">
                            	<p>
	                            	Technical Support System .. Administrator Login Page
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>Masukan Username dan Password:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form" novalidate name="loginForm">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" placeholder="Username..." class="form-username form-control" id="form-username" name="username"
										ng-model="main.username"
										ng-minlength="5"
										ng-maxlength="10"
										required
										>
			                        </div>
									<div class="help-block" ng-messages="loginForm.username.$error" ng-if="loginForm.username.$touched">
										<p ng-message="minlength">Username terlalu pendek.</p>
										<p ng-message="maxlength">Username terlalu panjang.</p>
										<p ng-message="required">Username harus di isi.</p>
									</div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" placeholder="Password..." class="form-password form-control" id="form-password" name="password"
										ng-model="main.password"
										ng-minlength="6"
										ng-maxlength="12"
										required
										>
			                        </div>
									<div class="help-block" ng-messages="loginForm.password.$error" ng-if="loginForm.password.$touched">
										<p ng-message="minlength">Password terlalu pendek.</p>
										<p ng-message="maxlength">Password terlalu panjang.</p>
										<p ng-message="required">Password harus di isi.</p>
									</div>
									
			                        <button type="submit" ng-disabled="loginForm.$invalid" class="btn">Masuk!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                 
                </div>
            </div>
            
        </div>


        

    </body>

</html>