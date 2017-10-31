<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
     
/**
* Classe de Integração com o WordPress
*
* Essa classe possibilita o uso de funções do WordPress
*
* @author   Paulino R. e Silva
* @link     http://www.ogrodafloresta.com.br/about/
*/

class Wpintegration {
 
    public function __construct() {
        global $table_prefix, $wp_embed, $wp_widget_factory, $_wp_deprecated_widgets_callbacks, $wp_locale, $wp_rewrite;
        // Variáveis adicionais do WordPress
        //$wpdb, $current_user, $auth_secure_cookie, $wp_roles, $wp_the_query, $wp_query, $wp, $_updated_user_settings,
        //$wp_taxonomies, $wp_filter, $wp_actions, $merged_filters, $wp_current_filter, $wp_registered_sidebars,
        //$wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_widget_updates, $_wp_deprecated_widgets_callbacks,
        //$posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_version, $id, $comment, $user_ID;

        require_once '../wp-load.php';
    }
    
    public function isLoggedIn()
    {
        return is_user_logged_in();
    }
    
    public function isSuperAdmin()
    {
        if(wp_get_current_user()->user_level >= 10)
            return true;
        else
            return false;
    }
    
    public function loginLink()
    {
        $CI = & get_instance();
        $CI->load->helper('ci_url');
        $redirect = current_url();

        return wp_login_url()."?redirect_to=$redirect";
    }
 
    public function logoutLink()
    {
        $CI = & get_instance();
        $CI->load->helper('ci_url');
        $redirect = current_url();

        return wp_logout_url()."&redirect_to=$redirect";
    }
    
    public function blogLink()
    {
        return get_option('siteurl');
    }
 
    public function adminLink()
    {
        return get_option('siteurl') . "/wp-admin";
    }

 
}
/* Fim do arquivo Wpintegration.php */