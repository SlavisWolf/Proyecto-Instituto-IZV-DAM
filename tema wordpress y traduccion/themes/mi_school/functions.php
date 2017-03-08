<?php

// THEME SUPPORT
add_theme_support('post-thumbnails');



function wpbootstrap_scripts_with_jquery() {
// Register the script like this for a theme:
wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
// For either a plugin or a theme, you can then enqueue the script: wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );


function namespace_theme_stylesheets() {
    wp_register_style( 'mamies-wafers-bootstrap-min',  get_template_directory_uri() .'/css/bootstrap.min.css', array(), null, 'all' );
    wp_register_style( 'mamies-wafers-carousel',  get_template_directory_uri() .'/css/carousel.css', array(), null, 'all' );
    wp_register_style( 'mamies-wafers-style', get_stylesheet_uri(), '', null, 'all' );
    wp_enqueue_style( 'mamies-wafers-bootstrap-min' );
    wp_enqueue_style( 'mamies-wafers-carousel' );
    wp_enqueue_style( 'mamies-wafers-style' );
}
add_action( 'wp_enqueue_scripts', 'namespace_theme_stylesheets' );



//TRADUCCION

function theme_name_setup(){
	$domain = 'mi_school';
	// wp-content/languages/theme-name/de_DE.mo
	load_theme_textdomain( $domain, trailingslashit( WP_LANG_DIR ) ."/themes/". $domain );
	// wp-content/themes/child-theme-name/languages/de_DE.mo
	//load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages' );
	// wp-content/themes/theme-name/languages/de_DE.mo
	//load_theme_textdomain( $domain, get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'theme_name_setup' );



//FILTER HOOK PARA QUE WORDPRESS AGREGUE LA CLASE IMG-RESPONSIVE  A LAS IMAGENES DE LAS ENTRADAS

function addResponsiveClass($content) {
    
    if ($content==='') {
        return $content;
    }
   //convertimos en contenido a una codificacion html en utf8
   $content = mb_convert_encoding($content,'HTML-ENTITIES', 'UTF-8');
    //Creamos un objeto tio dom
    $document = new DOMDocument();
    
    //desabilitamos los errores de libxml y habilitamos el manejo por parte del usuario
    libxml_use_internal_errors(true);
    
    //cargamos el contenido de dom en el objeto DomDocument
    $document->loadHTML(utf8_decode($content));
    
    //recogemos en un array todas los nodos te tag img
    $imgs = $document->getElementsByTagName('img');    
    //recoremos el array para añadirle la clase img-responsive a las imagenes
    foreach($imgs as $img){
        $img->setAttribute('class','img-responsive');
    }
    // ---------------------------------------------------
    //GUARDAMOS los cambios
    $html = $document->saveHTML();
    return $html;
}

add_filter("the_content","addResponsiveClass"); //filter hook


//PAGINACIÓN DE POSTS

function get_paginate_pagelink($type = "plain", $endsize = 1 , $midsize = 1) { // hay que definir en el back end que la pagina principal sea home y la de entradas sea Blog
    
    global $wp_query,$wp_rewrite;
    /*
        Obtenemos  el numero  de pagina
        para obtener el numero de pagina de de una pagina estatica hay que usar page en vez de paged
    */
    
    $current = get_query_var ('paged') > 1 ? get_query_var ('paged') : 1; // esto hace que tanto si devuelve 0 o 1 la función, nosotros lo consideraremos pagina 1.
    
    
    // saneamos lo valores de los parametros de entrada
    if (! in_array ( $type, array('plain','list','array') ) )
        $type = 'plain';
    
    $endsize = absint($endsize); // valor absoluto de un entero, esta función es de WP
    $midsize = absint($midsize);
    
    
    $pagination = array(
                    'base'          => @add_query_arg('paged','%#%'),
                    'format'        => '',
                    'total'         => $wp_query->max_num_pages, // este es el valor x defecto
                    'current'       => $current,
                    'show_all'      => false,
                    'end_size'      => $endsize,
                    'mid_size'      => $midsize,
                    'type'          => $type,
                    'prev_text'     => '&lt;&lt;',
                    'next_text'     => '&gt;&gt;'
                );
    
    if ($wp_rewrite->using_permalinks() ) {
        $pagination['base'] = user_trailingslashit (trailingslashit 
                                                    ( remove_query_arg ( 's',get_pagenum_link( 1 ) ) )
                                                    .'page/%#%/');
    }
    
    if (! empty ($wp_query->query_vars['s'] ) ) {
        $pagination['add_args'] = array('s' => get_query_var ( 's' ) );
    }
    
    return paginate_links($pagination); // nota para que funcione perfectamente hay que poner en el back end 
}


// activar widgets

function generaltheme_widgets_init() {
    // para registrar los widgets en el back end
    
    
    //registramos varios por si quiere el usuario poner widgets en otros sitios que no sea el sidebar.
  register_sidebar(array(
        'name' => __('Header Widgets'),
        'id' =>'header',
        'description' => __('Header Widget Area'),
        'before_widget' => '<div class= "widget %2$s">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Sidebar Widgets'),
        'id' =>'sidebar',
        'description' => __('Sidebar Widget Area'),
        'before_widget' => '<div class= "widget %2$s">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widgets'),
        'id' =>'footer',
        'description' => __('Footer Widget Area'),
        'before_widget' => '<div class= "widget %2$s">',
        'after_widget' => '</div>',
    ));
}

add_action('widgets_init','generaltheme_widgets_init'); //action hook



// esta funcion evita que en las busquedas del search aparezcan las paginas estaticas

//* Muestra exclusivamente entradas (posts) en los resultados de búsqueda 
function filtro_mostrar_solo_entradas($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','filtro_mostrar_solo_entradas');



//ENVIO DE CORREOS WORDPRESS


//Filtro para indicar que email debe ser enviado en modo HTML
/*	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
 
	//Cambiamos el remitente del email que en Wordpress por defecto es tu email de admin
   
 
	function my_wp_email_from($content_type) {
	  return 'antoniojesus.ib@gmail.com';
	}
 
    add_filter('wp_mail_from','my_wp_email_from');
    
    
	//Cambiamos el nombre del remitente del email que en Wordpress por defecto es "Wordpress"
    add_filter('wp_mail_from_name','my_wp_email_name');

    function my_wp_email_name($name) {
        return 'I.E.S Zaidín Vergeles';
    }*/
    
    
    
    function tituloWeb() {
        if (function_exists('is_tag') && is_tag()) {
            single_tag_title('Tag Archive for &quot;'); echo '&quot; - ';
        } elseif (is_archive()) {
            wp_title(''); echo ' Archive - ';
        } elseif (is_search()) {
            echo 'Search for &quot;'.wp_specialchars($s).'&quot; - ';
        } elseif (!(is_404()) && (is_single()) || (is_page())) {
            wp_title(''); echo ' - ';
        } elseif (is_404()) {
            echo 'Not Found - ';
        }
        if (is_home()) {
            bloginfo('name'); echo ' - '; bloginfo('description');
        } else {
            bloginfo('name');
        }
        if ($paged > 1) {
            echo ' - page '. $paged;
        }
}
?>