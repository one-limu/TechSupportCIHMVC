<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title titlechange>Mentor Education Bootstrap Theme</title>
    <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
    <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
    
    
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/custom.js"></script>

<!--- Mein Script !-->

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



<!--      
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script>
!-->

    <!-- load our custom app -->
    <script src="<?=BACKEND_ASSETS?>bower_components/chartjs/chart.js"></script>

    <script src="<?=base_url(NG)?>vendor/header-front.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-ui-router.js"></script>
    
    <script src="<?=base_url(NG)?>vendor/moment.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-util.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload-shim.js"></script>
    <script src="<?=base_url(NG)?>vendor/datetimepicker.js"></script>
    <script src="<?=base_url(NG)?>vendor/datetimepicker.templates.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-morris.min.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-chart.js"></script>
    <script src="<?=base_url(NG)?>app.js"></script>

    <script src="<?=base_url(NGModules)?>post/controllers/post.comment.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.detail.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.informasi.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.tutorial.js"></script>
    <script src="<?=base_url(NGModules)?>post/controllers/post.knowledgebase.main.js"></script>


    <script src="<?=base_url(NGModules)?>ticket/controllers/ticket.list.js"></script>
    <script src="<?=base_url(NGModules)?>ticket/controllers/ticket.open.js"></script>
    <script src="<?=base_url(NGModules)?>ticket/controllers/ticket.add.js"></script>

    
    

    <script src="<?=base_url(NGModules)?>user/controllers/user.login.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.logout.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.profile.js"></script>\
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.profile.edit.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.setting.js"></script>


    <script src="<?=base_url(NGModules)?>user/services/userService.js"></script>
    <script src="<?=base_url(NGModules)?>user/services/userSession.js"></script>


      <!--- AngularPrint -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/angularPrint/angularPrint.css">
  <!-- AngularPrint -->
  <script src="<?=BACKEND_ASSETS?>bower_components/angularPrint/angularPrint.js"></script>
    <script src="<?=base_url(NG)?>vendor/ngStorage.js"></script>

    <script src="<?=base_url(NGModules)?>post/services/postService.js"></script>

    <script src="<?=base_url(NGModules)?>ticket/services/ticketService.js"></script>

    <script src="<?=base_url(NGModules)?>user/services/userService.js"></script>
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

<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/mentor/style.css"></script>

  <script src="<?=base_url(NG)?>vendor/ui-bootstrap-tpls-2.5.0.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/bootstrap.min.css">

  <!-- Font awesome -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>bootstrap/css/font-awesome.css">


<!-- Flat Bootstrap CSS 
<link rel="stylesheet" href="<?php //base_url(assetsfrontendurl)?>bootstrap/css/bootstrap-flat.min.css">
-->
<!-- Manual Insert CSS
<link rel="stylesheet" href="<?php //base_url(assetsfrontendurl)?>css/custom/custom_insert.css"></script>
-->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>css/custom/custom_home.css"></script>
 
<!-- bootstrap modal -->
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/css/bootstrap-modal.css"></script>
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/bootstrap-modal/css/bootstrap-modal-bs3patch.css"></script>
<link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/angular-datetimepicker/css/datetimepicker.css"></script>

<!-- datatables ->
<link rel="stylesheet" href="<?php //base_url(assetsfrontendurl)?>css/jquery.dataTables.min.css"></script>
!-->

<!-- end mein Script !-->


    <!-- =======================================================
        Theme Name: Mentor
        Theme URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
        Author: BootstrapMade.com
        Author URL: https://bootstrapmade.com
    ======================================================= -->
  </head>
  <body  ng-cloak style="padding-bottom: 600px; background: #111">
    <!--Navigation bar-->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" ui-sref="/">Tech<span>Support</span></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a ui-sref="knowledgebase">Knowledgebase</a></li>
          <li><a ui-sref="memberarea">Memberarea</a></li>
          
          <li usernav></li>
        </ul>
      
        </div>
      </div>
    </nav>
    <!--/ Navigation bar-->

    <!--Banner-->
   
    <!--/ Banner-->
    <!--Feature-->
    <section id ="pricing" class="section-padding" style="padding :71px 0px;background: url(<?=base_url('assets/common/img/backgrounds/s_st_bg-80.jpg')?>);
min-height: 500px !important;
">
         <ui-view></ui-view>
    </section>
    
    <!--Footer-->
    <footer id="footer" class="footer">
      <div class=" text-center">
    
      
      
        ©2016 Mentor Theme. All rights reserved
        <div class="credits">
            <!-- 
                All the links in the footer should remain intact. 
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Mentor
            -->
            Designed by <a href="https://bootstrapmade.com/">Free Bootstrap Themes</a>
        </div>
      </div>
    </footer>
    <!--/ Footer-->
    
  
    
  </body>
</html>