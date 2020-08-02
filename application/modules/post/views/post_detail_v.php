

<div class="container" style="margin-bottom:35px; width: 75%">

<!-- Modal -->
<div class="modal fade ajaxz" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body"></div>
</div> <!-- /.modal -->
<div class="col-lg-12" ng-controller="PostDetail">
<div ng-init="PDetail = <?php echo htmlspecialchars(json_encode($post_detail['post_detail'])); ?>"></div>
               <div ng-repeat="x in PDetail | limitTo:1" style="text-align: justify;">
                <!-- Blog Post -->

                <!-- Title -->
                <h1 class="centered artikel_title">{{ x.title  | uppercase}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="{{x.author_id}}">{{x.author_name}}</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span>{{x.create_time | dateToISO | date:'MMMM, dd yyyy'}} 
                    on <a href="{{x.kategori_id}}" > {{x.kategori_name}}</a></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="<?=base_url(assetsfrontendurl)?>/post/img/900x300.png" alt="">

                <hr class="artikel_content">

                <!-- Post Content -->
                
                {{x.content}}

                <hr>


            </div>
            <div>
           


            </div>
</div>

<div class="col-lg-12" ng-controller="PostComment">

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <?php if ($this->ion_auth->logged_in()): ?>

                <div class="well" id="comment_field">
                    <h4>Leave a Comment:</h4>
                    <form role="form">
                        <div style="position: relative;" class="form-group">
                           <textarea class="form-control" ng-model="commentPost"></textarea>
                        </div>


                        <?php if ($this->ion_auth->logged_in()):?>
                            <button type="submit" class="btn btn-primary ajax" ng-click="writeComment()">Submit</button>
                        
                        <?php endif?>

                    </form>
                </div>
                <?php else : ?>
                        <a data-toggle="modal" class="btn btn-info" href="<?=base_url('post/modal/cek_before_comment')?>" data-target="#myModal">Silahkan Login dahulu unutk menuliskan komentar</a>
                <?php endif?>
                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div class="">{{thisComment.length}} Komentar</div>
                <div ng-repeat="x in thisComment track by $index" style="margin: 5px 5px 20px 5px">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?=base_url(assetsfrontendurl)?>/post/img/64x64.png" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{x.author_name}} 
                            <small><a href="{{x.id}}">@{{x.username}}</a></small> 
                            <small style="font-size:60%"><span class="glyphicon glyphicon-time"></span>{{x.create_time | dateToISO | date:'dd MMMM yyyy'}}</small>
                        </h4>
                        {{x.content}}
                    </div>
                </div>
                <hr>
                </div>

</div>


   </div>


