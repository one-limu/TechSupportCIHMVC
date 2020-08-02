<div class="panel panel-primary" style="border: none;">
	<div class="panel-heading text-right"><span class="pull-left" style="font-size: 15px;font-size: 15px;margin-top: 5px;"><strong><i class="fa" ng-class="{'fa-plus' : !vm.finishAdd, 'fa-check' : vm.finishAdd}"  aria-hidden="true"></i>
{{!vm.finishAdd ? 'ADD TICKET' : 'Penambahan Ticket Selesai'}}</strong></span> 
            <button ng-click="vm.close_form()" class="btn btn-success"><i class="fa fa-times"></i></button>      
    </div>

    <div class="panel-body" >
    <div ng-hide="!vm.finishAdd" class="text-center" >
    <strong>	Tracking-ID : {{vm.inserted_ticket[0].ticket_code}}</strong> <a href="<?=base_url('ticket/o/')?>{{vm.inserted_ticket[0].ticket_code}}"><i class="fa fa-arrow-right"></i></a>
    </div>


    	<ul class="list-group" ng-hide="vm.add_data.kategori_id || vm.finishAdd" style="display: flex;flex-direction: column;">
    	<li style="" ng-repeat="kategori in vm.list_ticket.addition.t_category" class="list-group-item col-md-5" ng-click="vm.set_kategori(kategori.id)" >{{kategori.nama}}</li>
    	</ul>

    	<ul class="list-group" ng-hide="!vm.add_data.kategori_id" >
    	<li class="list-group-item text-right"  >
    	<span ng-click="vm.set_kategori(0)" class="pull-left">Kategori</span>
    		{{vm.list_ticket.addition.t_category['id_' + vm.add_data.kategori_id]['nama']}}
    	</li>
    	</ul>
    	<div ng-hide="!vm.add_data.kategori_id">
    		<div class="form-group row">
    			<label class="col-xs-2">Judul</label>
    			<div class="col-xs-10">
    				<input type="text" class="form-control" ng-model="vm.add_data.judul">
    			</div>
    		</div>
    		<div class="form-group row">
    			<label class="col-xs-2">Prioritas</label>
    			<div class="col-xs-10">
    				<select class="form-control" ng-model="vm.add_data.prioritas_id">
    					<option ng-repeat="priority in vm.list_ticket.addition.t_priority" ng-value="priority.id">
    						{{priority.nama}}
    					</option>
    				</select>
    			</div>
    		</div>
    		<div class="form-group row">
    			<label class="col-xs-2">Pesan</label>
    			<div class="col-xs-10">
    				<textarea class="form-control" ng-model="vm.add_data.pesan"></textarea>
    			</div>
    		</div>
    		<div class="form-group row">
    		    <div class="col-md-12">
                <captcha></captcha>
                <div class="pull-right" style="margin-top:2px"><input type="text" class="form-control"  name="" style="width: 239px"></div>
            
        </div>
    		</div>
    	</div>
    </div>
    <div class="panel-footer" ng-hide="!vm.add_data.kategori_id" style="display: flex;flex-direction: column;">
    	<div class="form-group col-md-12">
    		 <div class="form-group pull-left" style="width:100%; display: flex;
flex-direction: row;
flex-wrap: wrap;
justify-content: space-around;">
            	<div ng-repeat="item in vm.picFile">
            
            <!--	<div ng-hide="item.type == 'image/png' || item.type == 'image/jpg' || item.type == 'image/jpeg' || item.type == 'image/gif'  " class="" style="width: 100px;height: 100px;"><i style="font-size: 99px;
text-align: center;" class="fa" aria-hidden="true" ng-class="{'fa-file-pdf-o' : item.type == 'application/pdf', 'fa-file-word-o' : ( item.type == 'application/msword' || item.type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ), 'fa-file-archive-o' : (item.type == 'application/zip' || item.type == 'application/rar' || item.type == 'application/7z')  }"></i>
</div>
  
  -->
            	<div class="" style="border: 1px solid brown;">{{item.name | limitTo:7 }}{{(item.name.length > 40 ? '..' : "" )}}{{(item.name.length > 40 ? item.name : "" | limitTo:-40)}}<button ng-click="vm.deleteQueue(item)" class="btn-danger"><i class="fa fa-times"></i></button></div>
               <div class="progress" ng-show="item.progress >= 0">
  <div class="progress-bar progress-bar-striped" role="progressbar" ng-bind = "item.progress  + '%'"
  aria-valuenow="{{item.progress}}" aria-valuemin="0" aria-valuemax="100" style="width:{{item.progress}}%;" ng-class="{'active': item.progress < 100}">
    
  </div>
</div>
            	</div>
            	</div>
    	</div>

    	<div class="col-md-12 pull-right">
    		<div class="form-group row pull-right">
    		<button ng-click="vm.uploadFiles(vm.picFile)" class="btn btn-danger" ng-show="vm.picFile.length > 0">Upload File</button>
    		 <button class="btn btn-danger" ngf-select="" ng-model="vm.picFile" ngf-keep="'distinct'" ngf-multiple="true" name="file" ngf-accept="'image/*'" required="" type="file"><i class="fa fa-upload"></i> Attachment</button>

              <button ng-disabled="" ng-click="vm.action_add()" class="btn btn-success"><i class="fa" ng-class="{'fa-plus' : !vm.loading.add , 'fa-circle-o' : vm.loading.add ,  'fa-spin' : vm.loading.add}"></i>Tambah</button>
    	</div>

             
              <div class="form-group"><span ng-show="vm.picFile.result">Upload Successful</span></div>
    	</div>
    </div>
   
</div>