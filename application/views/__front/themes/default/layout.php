<?php
$data['logged_in'] = ($this->ion_auth->logged_in());
$data['username'] = "";
$data['email'] = "";
$data['first_name'] = "";
$data['last_name'] = "";

if($data['logged_in']){
	$data['username'] = ucfirst($this->ion_auth->user()->row()->username);
	$data['email'] = $this->ion_auth->user()->row()->email;
	$data['first_name'] = $this->ion_auth->user()->row()->first_name;
	$data['last_name'] = $this->ion_auth->user()->row()->last_name;
}

//$data['logged_in'] = 1;

$this->load->view($this->config->item('tss_template_dir_front') . 'header', $data);

$this->load->view($this->config->item('tss_template_dir_front') . 'content');

$this->load->view($this->config->item('tss_template_dir_front') . 'footer');

?>