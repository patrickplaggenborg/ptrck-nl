<?php 
/*
 * Template Name: Portfolio Page - 3 Cols
 * Description: A portfolio page template displaying content in two columns
 */
 
get_header();

get_template_part( 'content', 'portfolio' );

get_sidebar('home-full-column');

get_footer();