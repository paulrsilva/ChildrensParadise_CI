<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wordpress_helper
 *
 * @author paulinorochaesilva
 */
class wordpress_helper {
function wp_init(){


    $CI =& get_instance();


    $do_blog = TRUE; // this can be a function call to determine whether to load  CI or WP


    /* here we check whether to do the blog and also we make sure this is a
    front-end index call so it does not interfere with other CI modules. 
    */
    if($do_blog 
        && ($CI->router->class == "index" && $CI->router->method == "index")
    )   
    {       

    // these Wordpress variables need to be globalized because this is a function here eh!
        global $post, $q_config, $wp;
        global $wp_rewrite, $wp_query, $wp_the_query;
        global $allowedentitynames;
        global $qs_openssl_functions_used; // this one is needed for qtranslate


        // this can be used to help run CI code within Wordpress.
        define("CIWORDPRESSED", TRUE);


        require_once './wp-load.php';

        define('WP_USE_THEMES', true);

        // Loads the WordPress Environment and Template 
        require('./wp-blog-header.php');

        // were done. No need to load any more CI stuff.
        die();


    }

}
}
