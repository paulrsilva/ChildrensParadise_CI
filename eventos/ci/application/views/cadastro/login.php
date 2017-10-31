<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
         
        
        <title>Eventos Bacacheri - Login</title>
        
        <style type="text/css">
            /*
                Note: It is best to use a less version of this file ( see http://css2less.cc
                For the media queries use @screen-sm-min instead of 768px.
                For .omb_spanOr use @body-bg instead of white.
            */

            @media (min-width: 768px) {
                .omb_row-sm-offset-3 div:first-child[class*="col-"] {
                    margin-left: 25%;
                }
            }

            .omb_login .omb_authTitle {
                text-align: center;
                    line-height: 300%;
            }

            .omb_login .omb_socialButtons a {
                    color: white;  
                    opacity:0.9;
            }
            .omb_login .omb_socialButtons a:hover {
                color: white;
                    opacity:1;    	
            }
            .omb_login .omb_socialButtons .omb_btn-facebook {background: #3b5998;}
            .omb_login .omb_socialButtons .omb_btn-twitter {background: #00aced;}
            .omb_login .omb_socialButtons .omb_btn-google {background: #c32f10;}


            .omb_login .omb_loginOr {
                    position: relative;
                    font-size: 1.5em;
                    color: #aaa;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    padding-top: 0.5em;
                    padding-bottom: 0.5em;
            }
            .omb_login .omb_loginOr .omb_hrOr {
                    background-color: #cdcdcd;
                    height: 1px;
                    margin-top: 0px !important;
                    margin-bottom: 0px !important;
            }
            .omb_login .omb_loginOr .omb_spanOr {
                    display: block;
                    position: absolute;
                    left: 50%;
                    top: -0.6em;
                    margin-left: -1.5em;
                    background-color: white;
                    width: 3em;
                    text-align: center;
            }			

            .omb_login .omb_loginForm .input-group.i {
                    width: 2em;
            }
            .omb_login .omb_loginForm  .help-block {
                color: red;
            }
            
            .omb_login {
                background-color: rgba(245, 245, 245, 0.8);
            }


            @media (min-width: 768px) {
                .omb_login .omb_forgotPwd {
                    text-align: right;
                            margin-top:10px;
                    }		
            }
            

            
        </style>
        <?php get_header(); ?> 
    </head>
    
    
    <body>  
        <div class="container">
            <div class="omb_login">
                <h3 class="omb_authTitle">Entre ou <a href="#">Cadastre-se</a></h3>
                        <div class="row omb_row-sm-offset-3 omb_socialButtons">
                    <div class="col-xs-4 col-sm-2">
                                <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
                                        <i class="fa fa-facebook visible-xs"></i>
                                        <span class="hidden-xs">Facebook</span>
                                </a>
                        </div>
                        <div class="col-xs-4 col-sm-2">
                                <a href="#" class="btn btn-lg btn-block omb_btn-twitter">
                                        <i class="fa fa-twitter visible-xs"></i>
                                        <span class="hidden-xs">Twitter</span>
                                </a>
                        </div>	
                        <div class="col-xs-4 col-sm-2">
                                <a href="#" class="btn btn-lg btn-block omb_btn-google">
                                        <i class="fa fa-google-plus visible-xs"></i>
                                        <span class="hidden-xs">Google+</span>
                                </a>
                        </div>	
                        </div>

                        <div class="row omb_row-sm-offset-3 omb_loginOr">
                                <div class="col-xs-12 col-sm-6">
                                        <hr class="omb_hrOr">
                                        <span class="omb_spanOr">Ou</span>
                                </div>
                        </div>

                        <div class="row omb_row-sm-offset-3">
                                <div class="col-xs-12 col-sm-6">	
                                    <form class="omb_loginForm" action="" autocomplete="off" method="POST">
                                                <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" name="username" placeholder="Endereço de Email">
                                                </div>
                                                <span class="help-block"></span>

                                                <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                        <input  type="password" class="form-control" name="password" placeholder="Senha">
                                                </div>
                            <span class="help-block">Senha Incorreta</span>

                                                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                                        </form>
                                </div>
                </div>
                        <div class="row omb_row-sm-offset-3">
                                <div class="col-xs-12 col-sm-3">
                                        <label class="checkbox">
                                                <input type="checkbox" value="remember-me">Lembrar Senha
                                        </label>
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                        <p class="omb_forgotPwd">
                                                <a href="#">Esqueceu sua Senha?</a>
                                        </p>
                                </div>
                        </div>	    	
                </div>
            <div class="col-sm-12">
                <?php 
                if (is_user_logged_in()){
                    echo 'vc está logado';
                } else {
                    echo 'vc não está logado!!';
                }
                
                echo "<br>";
                
                //echo loginLink();
                echo '-------';
               
                
                ?>
            </div>
        </div>
        <?php get_footer(); ?>
    </body>
</html>
