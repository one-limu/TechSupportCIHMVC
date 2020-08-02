angular.module('user').directive('usernav', function(userService, $rootScope){

	return{
		restrict: 'A',
		scope: {
			ddd : '='
		},
		template: `	
				
                   
						<a  ng-if="!vm.logged" style="padding-bottom: 0px; padding-top: 9px;" ui-sref="login"><button style="margin: 0px; width: 100%;" class="btn navbar-btn btn-success"><span class="glyphicon glyphicon-log-in"></span>&nbspLogin{{vm.lll}}</button></a>   
                  
                    
            
					
						 <div class="dropdown" style="padding-bottom: 0px; padding-top: 17px;" ng-if="vm.logged">
						  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span>&nbsp;
							<strong class="text-capitalize">{{vm.user.username}}</strong>
                            <small>
							 <span class="glyphicon glyphicon-chevron-down"></span>
                            </small>
						  </button>
						  <ul class="dropdown-menu" style="width: 260px;
top: ;
right: -50px;
padding: 9px 20px 0 20px;">
							<li>
							<div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center" style="width:60px;height:60px">
                                            <span style="font-size: 60px;" class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong class="text-capitalize">{{vm.user.first_name}} </strong><strong class="text-capitalize"> {{vm.user.last_name}}</strong></p>
                                        <p class="text-left small"></p>
                                        <p class="text-left">
                                            <a ui-sref="logout" class="btn btn-primary btn-block btn-sm"><span class="glyphicon glyphicon-log-in"></span>&nbspLogout</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
							</li>
						  </ul>
						</div>  
						
                
				`,
			controller: function(userService,$rootScope){
				console.log('dd')
				var vm = this
				//vm.lll = 'dddd'
				vm.logged = 0
				vm.isLoggedIn = function(){
					userService.is_logged_in().then(function(respone){
						vm.logged = respone.data
						console.log('ddd',vm.logged)
						userService.get_user().then(function(respone){
								        vm.user =  respone.data
								        console.log(vm.user)
								      })

					})
				}
				vm.isLoggedIn()
				   $rootScope.$on('user_nav_refresh', function(e, eArgs) {
			          // eArgs.myVar will be 'Jackson';
			          //element.append($compile(templ)(scope));
			          vm.isLoggedIn()
			        });
			},

			controllerAs: 'vm',
			bindToController: true

	}
})