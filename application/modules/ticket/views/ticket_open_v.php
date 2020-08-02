

<div class="container" ng-controller="TicketOpen" >
<div ng-show="valid">
<div class="row">
    <div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Informasi Ticket</div>
        <div class="panel-body">
            <div>

                <div class="row">
                  <div class="col-xs-2">ID</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisTicket[0].ticket_id}}</div>
                </div>
                <div class="row">
                  <div class="col-xs-2">Judul</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisTicket[0].judul}}</div>
                </div>
                <div class="row">
                  <div class="col-xs-2">DiPerbaharui</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisTicket[0].tanggal_update}}</div>
                </div>
                <div class="row">
                  <div class="col-xs-2">Balasan</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisReply.length}}</div>
                </div>
                <div class="row">
                  <div class="col-xs-2">DiPerbaharui</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisTicket[0].tanggal_update}}</div>
                </div>
                <div class="row">
                  <div class="col-xs-2">DiPerbaharui</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9">{{thisTicket[0].tanggal_update}}</div>
                </div>
              
            </div>
        </div>
      </div>
      </div>


    <div class="col-md-6">
      <div class="panel panel-primary" >
        <div class="panel-heading">Status</div>
        <div class="panel-body">
               <div class="row">
                  <div class="col-xs-2">Status</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-9"><button class="btn">{{thisTicket[0].status_id}}</button></div>
                </div>
              
        </div>
        </div>
    </div>

</div>

<div class="container row">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                  <div class="col-xs-3">Tanggal di buat</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-8">{{thisTicket[0].tanggal_dibuat}}</div>
                </div>
            <div class="row">
                  <div class="col-xs-3">Nama</div>
                  <div class="col-xs-1">:</div>
                  <div class="col-xs-8">{{thisTicket[0].creator_id}}</div>
        </div>
                <div class="panel-body" style="background-color: white; color: black">{{thisTicket[0].pesan}}</div>
        </div>
        <div class="panel-body">
            <div class="row" ng-repeat="x in thisReply">
                 
                  <div class="" style="border: 1px solid #337ab7; margin:  5px">
                    <div class="row">
                          <div class="col-xs-3">Tanggal di buat</div>
                          <div class="col-xs-1">:</div>
                          <div class="col-xs-8">{{x.date_made}}</div>
                    </div>
                    <div class="row">
                          <div class="col-xs-3">Nama</div>
                          <div class="col-xs-1">:</div>
                          <div class="col-xs-8">{{x.replier_id}}</div>
                    </div>
                    <div class="panel-body" style="background-color: white; color: black">{{x.content}}</div>
                  </div>
            </div>
        </div>
</div>
</div>

<div class="container row">
    <div class="panel panel-primary">
        <div class="panel-heading">
        Tulis Balasan
        </div>
         <div class="panel-body">
         <textarea class="form-control" ng-model="replyTicket"></textarea>

         <button class="btn btn-primary pull-right" ng-click="writeReply()">Tulis</button>
         </div>
    </div>
</div>




</div>
<div ng-show="!valid">
    <div class="panel panel-primary text-centered">
        <div class="panel-heading">Error</div>
        <div class="panel-body">
            Halaman tiak di temukan
        </div>
</div>
</div>

</div>








