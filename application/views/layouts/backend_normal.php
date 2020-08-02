<!DOCTYPE html>
<html ng-app="myApp">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <base href="<?php echo base_url();?>" />
  <title titlechange>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<!-- jQuery 3 -->
<script src="<?=BACKEND_ASSETS?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=BACKEND_ASSETS?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=BACKEND_ASSETS?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?=BACKEND_ASSETS?>bower_components/raphael/raphael.min.js"></script>
<script src="<?=BACKEND_ASSETS?>bower_components/morris.js/morris.min.js"></script>
<script src="<?=BACKEND_ASSETS?>bower_components/chartjs/chart.js"></script>


  
<!-- Sparkline -->
<script src="<?=BACKEND_ASSETS?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=BACKEND_ASSETS?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=BACKEND_ASSETS?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=BACKEND_ASSETS?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=BACKEND_ASSETS?>bower_components/moment/min/moment.min.js"></script>
<script src="<?=BACKEND_ASSETS?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?=BACKEND_ASSETS?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=BACKEND_ASSETS?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?=BACKEND_ASSETS?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=BACKEND_ASSETS?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=BACKEND_ASSETS?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=BACKEND_ASSETS?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=BACKEND_ASSETS?>dist/js/demo.js"></script>

    <script src="<?=base_url(NG)?>vendor/angular.js"></script>
    <script src="<?=base_url(NG)?>vendor/header-front.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-ui-router.js"></script>
    

    <script src="<?=base_url(NG)?>vendor/moment.js"></script>
    <script src="<?=base_url(NG)?>vendor/ngStorage.js"></script>
    
    <script src="<?=base_url(NG)?>vendor/ui-bootstrap-tpls-2.5.0.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-util.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload.js"></script>
    <script src="<?=base_url(NG)?>vendor/ng-file-upload-shim.js"></script>
    
    
    <script src="<?=base_url(NG)?>vendor/datetime-picker.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-morris.min.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-chart.js"></script>
    <script src="<?=base_url(NG)?>vendor/angular-confirm.js"></script>
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
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.profile.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.profile.edit.js"></script>
    <script src="<?=base_url(NGModules)?>user/controllers/user.memberarea.setting.js"></script>


     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.login.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.logout.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.dashboard.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.menu.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.header.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.setting.privilege.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.setting.profile.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.masterdata.user.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.masterdata.group.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.masterdata.ticket.priority.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.ticket.list.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.ticket.open.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.task.list.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.task.open.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.log.js"></script>
     <script src="<?=base_url(NGModules)?>user/controllers/user.admin.report.js"></script>

    <script src="<?=base_url(NGModules)?>post/services/postService.js"></script>

    <script src="<?=base_url(NGModules)?>ticket/services/ticketService.js"></script>
    <script src="<?=base_url(NGModules)?>log/services/logService.js"></script>

    <script src="<?=base_url(NGModules)?>user/services/userService.js"></script>
    <script src="<?=base_url(NGModules)?>user/services/userSession.js"></script>
    <script src="<?=base_url(NGModules)?>user/directives/user.directives.js"></script>

          <!-- load angular-material -->
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-animate.min.js"></script>
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-aria.min.js"></script>
          
          <script src="<?=base_url(assetsfrontendurl)?>plugin/angular-material/js/angular-material.min.js"></script>
          <link rel="stylesheet" href="<?=base_url(assetsfrontendurl)?>plugin/angular-material/css/angular-material.min.css">

              <!-- load ngmessages -->
    <script src="<?=base_url(assetsfrontendurl)?>js/angular/angular-messages.js"></script>



  <!--- AngularPrint -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>bower_components/angularPrint/angularPrint.css">
  <!-- AngularPrint -->
  <script src="<?=BACKEND_ASSETS?>bower_components/angularPrint/angularPrint.js"></script>



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?=BACKEND_ASSETS?>https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="<?=BACKEND_ASSETS?>https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?=BACKEND_ASSETS?>https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini" style="background: #222d32;">

<div class="wrapper">
  <div ui-view="header"></div>
  <div ui-view="sidebar"></div>
  <div ui-view="content"></div>
</div>
<div ui-view="footer"></div>
<div ui-view="control-sidebar"></div>
<ui-view></ui-view>
</body>





</html>
