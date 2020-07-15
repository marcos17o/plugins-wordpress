<?php   

/*
Plugin Name: Acortador
*/

function saca_dominio($url){
    $protocolos[0] = "http://";
    $protocolos[1] = "https://";
    $protocolos[2] = "ftp://";
    $protocolos[3] = "www.";
    // soporte para las url de zippyshare.com las cuales son como por ejemplo  www27.zippyshare.com
    $Contador = 4;
    for ($i=4; $i <= 99 ; $i++) { 
      $protocolos[$Contador] = "www$Contador.";
      $Contador++;
    }
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
function extraerURLs($content){
    $regex = '/https?\:\/\/[^\" ]+/i';
    preg_match_all($regex, $content, $partes);
    return ($partes[0]);
}


function acortador($content){

 // toquen de la api del acortador
$token = '79f44fae3d7ae61605d35342b5bb61838ce8c84d'; 

// esteblesco que urlsse acortaran
$dominios = array('depositfiles.com', 'shink.me', 'pasteca.sh', 'adf.ly', 'mega.nz', 'atominik.com', 'kimechanic.com', 'yamechanic.com', 'j.gs', 'openload.co', 'twineer.com','userscloud.com', 'zippyshare.com', 'uploadable.ch','mediafire.com', 'mp4upload.com' , 'ouo.io', 'vidoza.net','tiohentai.xyz'); 
 
// Llamamos a la función y le pasamos la cadena a buscar
$urls = extraerURLs($content);


foreach($urls as $url){
    
    $url_dominio = saca_dominio($url);

    if(array_search($url_dominio,$dominios) !== false){

    $urls_originales[] = $url; // almaseno en un array las url que se modificaran que an sifo filtradas por el if

    if ($url_dominio == 'ouo.io') { 

    $url_acortador = 'https://exe.io/st?api=e37fb9bc1ccf06682a1ced2cd7d2477ce37f1836&url='.$url; 
       
    }else{  // si no es de ouo.io tendra 2 acortadores si es de ouo.io 

// 
		$url_acortador = 'https://exe.io/st?api=e37fb9bc1ccf06682a1ced2cd7d2477ce37f1836&url='.$url;

    }

    $url_final[] = $url_acortador;
   }
 }
    if (is_single()) {  
    $content = str_replace($urls_originales, $url_final, $content);
    return $content;
    }
}
add_filter('the_content', 'acortador');




function scripts_header() {
 
}
add_action( 'wp_enqueue_scripts', 'scripts_header' );

function acortador_popup($content){
?>

<!-- section to include code in the page footer -->


<?php
}
add_filter( "wp_footer", "acortador_popup" );
