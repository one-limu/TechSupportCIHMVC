<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends FrontendController {

    function __construct() {
        parent::__construct();
        //$this->load->model('post/post_model');
        $this->load->helper('captcha');
    }

    public function index(){
        // If captcha form is submitted
        if($this->input->post('submit')){
            $inputCaptcha = strtolower($this->input->post('captcha'));
            $sessCaptcha = strtolower($this->session->userdata('captchaCode'));


            if($inputCaptcha === $sessCaptcha){
                echo json_encode((object)['message' => 'Captcha Cocok', 'status' => 1]);
            }else{
                echo json_encode((object)['message' => 'Kode Captcha Tidak Cocok, Coba lagi', 'status' => 0]);
                //echo 'Captcha code was not match, please try again.';
            }
        }
        
        // Captcha configuration
        $config = array(
            'img_path'      => 'assets/common/image/captcha/',
            'font_path'  => '/assets/common/font/good-times.regular.ttf',
            'img_url'       => base_url().'assets/common/image/captcha/',
            'img_width'     => 120,
            'img_height'    => 30,
            'word_length'   => 6,
            'font_size'     => 300,
            'pool'  =>'0123456789',
                'colors'        => array(
                                    'background' => array(255, 255, 255),
                                    'border' => array(0, 0, 0),
                                    'text' => array(0, 0, 0),
                                    'grid' => array(255, 255, 255)
                  )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Send captcha image to view
        $data['captchaImg'] = $captcha['image'];
        $data['captchaName'] = $captcha['filename'];

        //print_r($captcha);
        
        // Load the view
        if($this->input->post('imgOnly')){
            echo json_encode((object)['data' => $data]);
        }else{
            //$this->load->view('captcha/index', $data);
        }
        
    }
    
    public function refresh(){
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 8,
            'font_size'     => 16
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        

        // Display captcha image
        if($this->input->post('imgOnly')){
            $data['captchaImg'] = $captcha['image'];
            $data['captchaName'] = $captcha['filename'];
            echo json_encode((object)['data' => $data]);
        }else{
             echo $captcha['image'];
        }
    
    }


    }