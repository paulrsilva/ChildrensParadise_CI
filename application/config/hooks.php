<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

//adicionando funções do Wordpress
$hook['pre_controller'] = array(
    'class'    => '',
    'function' => 'wp_init',
    'filename' => 'wordpress_helper.php',
    'filepath' => APPPATH.DS.'helpers'
);

//teste2
