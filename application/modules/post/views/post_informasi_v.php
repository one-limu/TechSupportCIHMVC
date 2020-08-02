<div ng-controller="PostInformasi" class="container">
		<div class="panel panel-primary" style="border: medium none;">
		        <div class="panel-heading">Informasi</div>
		        <div class="panel-body">
						<div  ng-repeat="x in informasi track by $index">
						       <div class="col-md-12 post">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>
                                <strong><a href="artikel/{{x.id}}/{{x.slug}}" class="post-title">{{x.title}}</a></strong></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 post-header-line">
                            <span class="glyphicon glyphicon-user"></span>by <a href="profile/{{x.username}}">{{x.author_name}}</a> | <span class="glyphicon glyphicon-calendar">
                            </span>{{x.create_time | dateToISO | date:'dd MMMM yyyy'}} | <span class="glyphicon glyphicon-comment"></span><a href="artikel/{{x.id}}/{{x.slug}}#comment_field">
                                {{x.comment_count}} Komentar</a>
                    </div>
                    <div class="row post-content">
                        <div class="col-md-3">
                            <a href="#">
                                <img src="http://4.bp.blogspot.com/-_lqoNpVXeU4/UkxQ7N-QW8I/AAAAAAAACTw/pni-TZyp17o/s1600/cool+share+button+effects+styles.png" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="col-md-9">
                            <p>
                                {{x.content | limitTo:200}} {{x.content.length > 200 ? '...' : ''}}
                            </p>
                            <p>
                                <a class="btn btn-read-more" href="artikel/{{x.id}}/{{x.slug}}">Read more</a></p>
                        </div>
                    </div>
                </div>
						</div>
		        </div>
		</div>

</div>


<style type="text/css">
	body
{
    //margin-top: 50px;
}
a:hover { text-decoration:none; }
.btn
{
    transition: all .2s linear;
    -webkit-transition: all .2s linear;
    -moz-transition: all .2s linear;
    -o-transition: all .2s linear;
}
.btn-read-more
{
    padding: 5px;
    text-align: center;
    border-radius: 0px;
    display: inline-block;
    border: 2px solid #662D91;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 12px;
    color:#662D91;
}

.btn-read-more:hover
{
    color: #FFF;
    background: #662D91;
}
.post { border-bottom:1px solid #DDD }
.post-title {  color:#662D91; }
.post .glyphicon { margin-right:5px; }
.post-header-line { border-top:1px solid #DDD;border-bottom:1px solid #DDD;padding:5px 0px 5px 15px;font-size: 12px; }
.post-content { padding-bottom: 15px;padding-top: 15px;}


</style>