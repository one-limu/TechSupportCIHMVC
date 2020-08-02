<style type="text/css">



    .px10 {
        width: 50px;
        text-align: left;
    }
</style>

<div class="container" ng-controller="TicketTable as vm" ng-cloak>
    <!--  modal Form Add  -->

    <div style="visibility: hidden">
        <div class="md-dialog-container" id="modal_add_ticket" style="padding:0">
            <md-dialog class="" style="width: 50%; overflow-x: hidden ">
                <?php  $this->load->view('ticket/modal/add_ticket');
                //require_once "modal/add_ticket.php"; ?>
            </md-dialog>
        </div>
    </div>

    <!-- -->
    <div class="row">
        <div class="col-xs-3">
            <div class="panel panel-primary">
                <div class="panel-heading text-right"><span class="pull-left">Menu</span><button ng-click="vm.form_add()" class="btn btn-success"><i class="fa fa-plus" ng-class="{'fa-spin' : vm.loading.add == 1}" aria-hidden="true"></i>
<strong>Buat Ticket</strong></button></div>
                <div class="panel-body">
                    <ul class="list-group ">
                        <li class="list-group-item"><strong>List Ticket</strong><span class="badge">{{vm.list_ticket.list.length}}</span></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Profil</strong></span>_</li>

                    </ul>


                </div>
            </div>


        </div>

        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-right"><span class="pull-left" style="font-size: 15px;font-size: 15px;margin-top: 5px;"><strong><i class="fa fa-list" aria-hidden="true"></i>
LIST TICKET</strong></span>
                            <form>
                                <div class="form-group" style="display: flex;
flex-direction: row;
justify-content: end;
height: 15px;">
                                    <input class="input-mine" style="" type="text" ng-model="vm.filter.filter.like.judul" placeholder="Search...">

                                    <div class="dropdown">
                                        <span class="btn btn-success dropdown-toggle" type="button" id="filter-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   
    <span class="caret"></span>

                                        </span>
                                        <ul class="dropdown-menu noclose pull-right" aria-labelledby="filter-dropdown" style="margin-top:20px">
                                            <li>
                                                <div class="input-group" style="width: 300px">
                                                    <span class="input-group-addon" id="basic-addon1">Status</span>
                                                    <select class="form-control" ng-model="vm.filter.filter.equal.status_id">
    <option value="1">Selesai</option>
    <option value="2">Belum Selesai</option>

  </select>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-group" style="width: 300px">
                                                    <span class="input-group-addon" id="basic-addon1">Kategori</span>
                                                    <select class="form-control" ng-model="vm.filter.filter.equal.kategori_id">
    <option value="1">Kategori 1</option>
    <option value="2">kategori 2</option>

  </select>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-group" style="width: 300px">
                                                    <span class="input-group-addon" id="basic-addon1">Prioritas</span>
                                                    <select class="form-control" ng-model="vm.filter.filter.equal.prioritas_id">
    <option value="1">Low</option>
    <option value="2">High</option>

  </select>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-group" style="width: 300px">
                                                    <span class="input-group-addon" id="basic-addon1">Isi mengandung kata</span>
                                                    <input type="text" class="form-control" name="" ng-model="vm.filter.filter.like.pesan">
                                                </div>
                                            </li>


                                        </ul>
                                    </div>
                                    <button ng-click="vm.fetch()" class="btn btn-success" style="height: 34px">
                  <i class="fa fa-search" aria-hidden="true" ></i>
                  </button>

                                </div>

                            </form>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <div class="text-right">
                                    <span class="pull-left">
          <div class="text-right relative" >
            
          </div>
                </span>
                                    <span class="pull-left re">

                    <button  title="Refresh" ng-click = "vm.fetch()" class="btn btn-success"><span class="glyphicon glyphicon-refresh" ng-class="{'fa-spin' : vm.loading.list == 1}"></span> Refresh</button>
                                    <button ng-hide="!(ticketPoll.length > 0)" title="Hapus" ng-click="delete()" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Hapus Pilihan</button>
                                    </span>

                                </div>
                            </div>
                        </div>





                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">

                    <div class="table-backdrop">
                        <!-- Table Backdrop -->
                        <div ng-hide="!vm.loading.list" class="backdrop-in">
                            <div class="sk-cube-grid">
                                <div class="sk-cube sk-cube1"></div>
                                <div class="sk-cube sk-cube2"></div>
                                <div class="sk-cube sk-cube3"></div>
                                <div class="sk-cube sk-cube4"></div>
                                <div class="sk-cube sk-cube5"></div>
                                <div class="sk-cube sk-cube6"></div>
                                <div class="sk-cube sk-cube7"></div>
                                <div class="sk-cube sk-cube8"></div>
                                <div class="sk-cube sk-cube9"></div>
                            </div>
                        </div>
                        <div class=" col-xs-12 text-right"></div>

                        <div class="panel panel-primary">
                            <!-- Default panel contents -->
                            <div class="panel-heading text-right"><span class="pull-left"></span>
                                <select ng-model="vm.filter.limit.limit" ng-change="vm.fetch()" style="width: 19px">
                            <option ng-repeat="x in vm.displayedPerPage track by $index" ng-value="x">
                              {{x}} Butir
                             </option>
                      </select> Menampilkan {{vm.showingFrom}} - {{vm.showingTo}} dari {{ticketAll}} Ticket</div>
                            <table class="table table-hover" id="table-list-ticket">
                                <div id="target" ng-style="{'top' : table_position,  'width' : table_width,  height: auto}"></div>
                                <thead>
                                    <tr>
                                        <th style="width: 10px" class="text-right relative">
                                            <div class="pull-left relative"><input ng-model="checkAll" ng-checked="checkAllButton" ng-click="vm.c_checkAll()" type="checkbox" class="absolute" style="position: absolute; z-index: 2; margin-top:11px" name=""></div>
                                            <div class="dropdown" style="margin-left : -5px">
                                                <span class="btn btn-default dropdown-toggle" type="button" style="border: none;
width: 41px;
height: 23px;
margin-top: 7px;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  
    <span class="caret" style="margin-top: -14px;
margin-left: 8px;
"></span>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><a ng-click="vm.c_check_some('all')">Semua</a></li>
                                                    <li><a ng-click="vm.c_check_some('none')">Tak Satupun</a></li>
                                                    <li><a ng-click="vm.c_check_some('baca')">Telah Dibaca</a></li>
                                                    <li><a ng-click="vm.c_check_some('belum baca')">Belum Dibaca</a></li>
                                                    <li><a ng-click="vm.c_check_some('selesai')">Telah Selesai</a></li>
                                                    <li><a ng-click="vm.c_check_some('belum selesai')">Belum Selesai</a></li>

                                                </ul>
                                            </div>
                                        </th>
                                        <th ng-click="vm.set_order('ticket_id')" class="px10">Tracking-ID</th>
                                        <th ng-click="vm.set_order('tanggal_update')">Update terakhir</th>
                                        <th ng-click="vm.set_order('judul')">Judul</th>
                                        <th ng-click="vm.set_order('status_id')">Status{{}}</th>


                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <tr dir-paginate="row in vm.list_ticket.list | itemsPerPage: vm.filter.limit.limit" total-items="vm.pagination.total_row" current-page="ctr.pagination.cur_page" ng-class="({{(row.user_read_status)}}) ? '' : 'read_status'">
                                        <td> <input type="checkbox" ng-click="vm.changeCheckbox(row)" ng-checked="vm.ticketPoll.indexOf(row) !== -1"></td>
                                        <td class="px10"><a href="<?=base_url()?>#/ticket/{{row.ticket_code}}" >{{row.ticket_code}}</a></td>
                                        <td>{{row.tanggal_update | dateToISO | date:'dd-MMMM-yyyy'}}</td>
                                        <td>{{row.judul}}</td>
                                        <td>
                                            {{row.nama_status}}


                                        </td>


                                    </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- Table Backdrop -->



                    <table width="100%">
                        <tfoot>

                            <tr>

                                <td colspan="6" class="text-center">
                                    <dir-pagination-controls on-page-change="vm.pageChanged(newPageNumber)">
                                    </dir-pagination-controls>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>





<style type="text/css">
    .table-backdrop {
        position: relative; // background-color: black;
    }

    .relative {
        position: relative;
    }

    .absolute {
        position: absolute;
    }

    .backdrop-in {
        background-color: rgba(255, 0, 0, 0.2); //background: transparent;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 99;
    }

    .read_status {
        background-color: rgba(255, 0, 0, 0.2);
    }

    .sk-cube-grid {
        position: absolute;
        width: 40px;
        height: 40px; //margin: 100px auto;
        left: 50%;
        top: 50%;

        z-index: 222;
    }

    .sk-cube-grid .sk-cube {
        width: 33%;
        height: 33%;
        background-color: #333;
        float: left;
        -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
        animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
    }

    .sk-cube-grid .sk-cube1 {
        -webkit-animation-delay: 0.2s;
        animation-delay: 0.2s;
    }

    .sk-cube-grid .sk-cube2 {
        -webkit-animation-delay: 0.3s;
        animation-delay: 0.3s;
    }

    .sk-cube-grid .sk-cube3 {
        -webkit-animation-delay: 0.4s;
        animation-delay: 0.4s;
    }

    .sk-cube-grid .sk-cube4 {
        -webkit-animation-delay: 0.1s;
        animation-delay: 0.1s;
    }

    .sk-cube-grid .sk-cube5 {
        -webkit-animation-delay: 0.2s;
        animation-delay: 0.2s;
    }

    .sk-cube-grid .sk-cube6 {
        -webkit-animation-delay: 0.3s;
        animation-delay: 0.3s;
    }

    .sk-cube-grid .sk-cube7 {
        -webkit-animation-delay: 0s;
        animation-delay: 0s;
    }

    .sk-cube-grid .sk-cube8 {
        -webkit-animation-delay: 0.1s;
        animation-delay: 0.1s;
    }

    .sk-cube-grid .sk-cube9 {
        -webkit-animation-delay: 0.2s;
        animation-delay: 0.2s;
    }

    @-webkit-keyframes sk-cubeGridScaleDelay {
        0%,
        70%,
        100% {
            -webkit-transform: scale3D(1, 1, 1);
            transform: scale3D(1, 1, 1);
        }
        35% {
            -webkit-transform: scale3D(0, 0, 1);
            transform: scale3D(0, 0, 1);
        }
    }

    @keyframes sk-cubeGridScaleDelay {
        0%,
        70%,
        100% {
            -webkit-transform: scale3D(1, 1, 1);
            transform: scale3D(1, 1, 1);
        }
        35% {
            -webkit-transform: scale3D(0, 0, 1);
            transform: scale3D(0, 0, 1);
        }
    }


    .input-mine {
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        height: 34px;
    }
</style>