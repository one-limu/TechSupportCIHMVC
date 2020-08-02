	<div class="" style="padding-bottom: 1px;" ng-controller="PostList">
		<div ng-init="PList = <?php echo htmlspecialchars(json_encode($post_list)); ?>"></div>
			<div class="row" >
				<div class="row-item col-md-6">
					<!-- Icon Box -->
				<div class="row-item col-md-12">
					<h2 class="lined centered margin-30"><a href="<?=base_url("knowledgebase/informasi")?>">Informasi Terbaru</a></h2>
					<div class="b-news" ng-repeat="x in PList.information | limitTo:5 | orderBy:create_time">
						<div class="news-date">
							<div class="date-day">{{x.create_time | dateToISO | date:'dd'}}</div>
							<div class="date-mounth">{{x.create_time | dateToISO | date:'MMM'}}</div>
						</div>
						<div class="news-title">
							<a href="<?=base_url()?>artikel/{{x.id}}/{{x.slug}}">{{x.title | limitTo:80}}</a>
						</div>
						<div class="news-excerpt">
						{{x.content | limitTo:200}} {{x.content.length > 200 ? '...' : ''}}
						</div>
					</div>
					
					
				</div>
					
					
					<!-- End Icon Box -->
				</div>
				
					
				
				
				
				<div class="row-item col-md-6">
					<!-- Icon Box -->
				<div class="row-item col-md-12">
					<h2 class="lined centered margin-30"><a href="<?=base_url("knowledgebase/tutorial")?>">Tutorial Terbaru</a></h2>
					<div class="b-news" ng-repeat="x in PList.tutorial | limitTo:5 | orderBy:create_time">
						<div class="news-date">
							<div class="date-day">{{x.create_time | dateToISO | date:'dd'}}</div>
							<div class="date-mounth">{{x.create_time | dateToISO | date:'MMM'}}</div>
						</div>
						<div class="news-title">
							<a href="<?=base_url()?>artikel/{{x.id}}/{{x.slug}}">{{x.title | limitTo:80}}</a>
						</div>
						<div class="news-excerpt">
						{{x.content | limitTo:200}} {{x.content.length > 200 ? '...' : ''}}
						</div>
					</div>
					
					
				</div>
					
					
					<!-- End Icon Box -->
				</div>
			
			</div>
		</div>
	