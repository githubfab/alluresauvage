<?php	
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }	
    define( 'WAY2ENJOY_WEB_API_PLUGIN_DATA_PATH', 'http://way2enjoy.com/modules/compress-png/feedbackdata.php/' );
    require_once dirname( __FILE__ ) . '/config.php';  
            
    function way_web_init( $options ) { 
    
        // load files
        require_once dirname( __FILE__ ) . '/way.php';

        $wd = new Way2enjoyweb();
        $wd->way2_init( $options );

    }
    
    

        
