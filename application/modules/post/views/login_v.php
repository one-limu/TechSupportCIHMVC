<div class="l_login-page"  ng-controller="MainCtrl as main">

<input type="text" ng-init="name='<?=$this->session->flashdata('message')?>'" class="ng-hide" value=""/>

<div id="infoMessage" class="alert alert-danger" ng-if="name != ''">  {{name | htmlToPlaintext}}  </div>
  <div class="l_form">
    <form class="l_login-form" action="<?=base_url()?>auth/login" method="post" name="loginForm">
      <div class="form-group">
		<input type="text" placeholder="username" name="identity" 
										ng-model="main.identity"
										ng-minlength="5"
										ng-maxlength="20"
										required/>
		<div class="help-block" ng-messages="loginForm.identity.$error" ng-if="loginForm.identity.$touched">
										
										<p ng-message="required">Username harus di isi.</p>
		</div>
		<input type="password" placeholder="password" name="password" 
										ng-model="main.password"
										
										required/>
		<div class="help-block" ng-messages="loginForm.password.$error" ng-if="loginForm.password.$touched">
										
										<p ng-message="required">Password harus di isi.</p>
		</div>
	  </div>
      
	  
	  <button ng-disabled="loginForm.$invalid" type="submit">login</button>
     
    </form>
	
  </div>
</div>


<style>

@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.l_login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.l_form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.l_2), 0 5px 5px 0 rgba(0, 0, 0, 0.l_24);
}
.l_form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.l_form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.l_3 ease;
  transition: all 0.l_3 ease;
  cursor: pointer;
}
.l_form button:hover,.l_form button:active,.l_form button:focus {
  background: #43A047;
}
.l_form .l_message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.l_form .l_message a {
  color: #4CAF50;
  text-decoration: none;
}
.l_form .l_register-form {
  display: none;
}
.l_container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.l_container:before, .l_container:after {
  content: "";
  display: block;
  clear: both;
}
.l_container .l_info {
  margin: 50px auto;
  text-align: center;
}
.l_container .l_info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.l_container .l_info span {
  color: #4d4d4d;
  font-size: 12px;
}
.l_container .l_info span a {
  color: #000000;
  text-decoration: none;
}
.l_container .l_info span .l_fa {
  color: #EF3B3A;
}

body{
	background: #76b852; /* fallback for old browsers */
	  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
}

</style>