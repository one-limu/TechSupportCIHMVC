<!--  
slider
-->

   
  
<div style="display: flex;flex-direction: column;">
   

    <div id="jssor_1" style=" position: relative; margin: 0 auto; top: 0px; left: 0px; width: 100%; max-width: 1200px; height: auto; max-height:500px; margin-bottom:20px; overflow: hidden; ">
		<?php $this->load->view('home/slideshow_v')?>
    </div>

<!-- 
end slider
-->

	<!-- FEATURED CONTENT
	============================================= -->
	<div class="container  content-featured" style="border-top:0px; border-top: 0px none;">
				 Technical Support System
	</div>
    <style type="text/css">.content{min-height: 0}</style>
	<!-- END FEATURED CONTENT
	============================================= -->

	<!-- CONTENT 
	============================================= -->
	<div class="container content shortcodes gray-content" style="padding-bottom: 10px;">
		<?php $this->load->view('home/post_list_v')?>
	</div>


	<!-- END CONTENT 
	============================================= -->

</div>