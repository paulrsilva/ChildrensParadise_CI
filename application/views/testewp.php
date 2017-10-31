<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Página WP</title>
        
        <!-- Adicionando Funções BootStrap -->
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >

        <!-- Latest compiled and minified JavaScript -->
        <script src="<?php echo base_url('ci/includes/bootstrap/js/bootstrap.min.js'); ?>"></script>
        
        <!--
        <script type="text/javascript" src="/bower_components/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        -->
 
         <script type="text/javascript" src="<?php echo base_url('ci/bower_components/moment/min/moment.min.js'); ?>"></script>
        
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
        
        <link rel="stylesheet" href="<?php echo base_url('ci/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>" />
         <?php get_header(); ?>       
    </head>
    <body>
        
        
        <ol class="breadcrumb">
            <li><a href="#">Agenda</a></li>
            <li><a href="#">Datas</a></li>
            <li class="active">Reservar Salão</li>
       </ol>
        
        <div class="container-fluid">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">Calendário</a></li>
                <li role="presentation"><a href="#">Reserva</a></li>
                <li role="presentation"><a href="#">Convidados</a></li>
            </ul>
            
            <div class="row">
                
                <!-- Pegando variaveis do WP -->
                <?php
                    $taxonomy = 'product_cat';
                    $orderby = 'name';
                    $show_count = 0; // 1 for yes, 0 for no
                    $pad_counts = 0; // 1 for yes, 0 for no
                    $hierarchical = 1; // 1 for yes, 0 for no
                    $title = '';
                    $empty = 0;

                    $args = array(
                        'taxonomy' => $taxonomy,
                        'orderby' => $orderby,
                        'show_count' => $show_count,
                        'pad_counts' => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li' => $title,
                        'hide_empty' => $empty
                    );
               ?>

               <?php
               $all_categories = get_categories( $args );
               foreach ($all_categories as $cat)
               {

                    if($cat->category_parent == 0)
                    {
                        $category_id = $cat->term_id;
                        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        echo "<ul class='category'><li>".$cat->name;
                        $args2 = array(
                            'taxonomy' => $taxonomy,
                            'child_of' => 0,
                            'parent' => $category_id,
                            'orderby' => $orderby,
                            'show_count' => $show_count,
                            'pad_counts' => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li' => $title,
                            'hide_empty' => $empty
                        );

                        $sub_cats = get_categories( $args2 );
                        if($sub_cats)
                        {

                            foreach($sub_cats as $sub_category)
                            {
                                echo "<ul class='subcategory'>";
                                if($sub_cats->$sub_category == 0)
                                {
                                    echo "<li>".$sub_category->cat_name;

                                    ?>
                                    <?php
                                    /*echo "<pre>";
                                    print_r($sub_category);
                                    echo "</pre>";*/

                                    $args = array( 'post_type' => 'product','product_cat' => $sub_category->slug);
                                    $loop = new WP_Query( $args );
                                    echo "<ul class='products'>";
                                    while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?> <li>
                                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                    <?php the_title(); ?>
                                    </a></li>
                                    <?php endwhile; ?>
                                    </ul>
                                    <?php wp_reset_query(); ?>

                                    <?php
                                }
                                else
                                {
                                    echo "</li></ul></li>";
                                }
                                echo "</ul>";
                            }
                        }
                        else
                        {
                            $args = array( 'post_type' => 'product', 'product_cat' => $cat->slug );
                            $loop = new WP_Query( $args );
                            echo "<ul class='products'>";
                            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?> <li>
                                <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                <?php the_title(); ?>
                                </a></li>
                            <?php endwhile; ?>
                            </ul></li></ul>
                            <?php wp_reset_query();
                        }
                    }
                    else
                    {
                        echo "</li></ul>";
                    }
               }
               ?>                        
                <!-- FIM Pegando variaveis do WP -->
            </div>
            
            <div class="row">  

            </div>
        </div>    
        
        <?php get_footer(); ?>
    </body>
</html>
