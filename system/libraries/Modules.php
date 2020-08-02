<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Custom
 *
 * Application development framework for PHP 5.1.6 or newer
 *
 * @package	     Custom
 * @author	     Muhammad Arief R
 * @copyright	 Copyright (c) 2013 RiefSquadMelodic inc
 * @license
 * @link
 */
// ------------------------------------------------------------------------

class CI_Modules
{
    /**
     * Class Version
     * @access	public
     */
    public static $version = '1.0';

    /**
     * CodeIgniter Instance
     * @access	protected
     */
    protected $ci;

    /**
     * Constructor
     * @access	public
     */
    public function __construct()
    {
        $this->ci = &get_instance();
        log_message('debug', "Modules Class Initialized");
    }

    public function render($module_view, $module_data = array())
    {
        #$data = (is_array($module_data) ? array_merge($data, $module_data) : $data);

        #$data['contents'] = $this->ci->template->write_view($module_view, $module_data);

        // Build Template View
        $this->ci->template->build($module_view, $module_data);
    }
}
