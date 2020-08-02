<?php

if (isset($page)) {
    if (isset($module)) {	
	//echo "$page";
        $this->load->view("$module/$page");
		
    } else {
        $this->load->view($page);
    }
}