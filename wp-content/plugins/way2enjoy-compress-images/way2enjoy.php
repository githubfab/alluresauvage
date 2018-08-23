<?php
 /**
 * Plugin Name: W2E Image Optimizer
 * Plugin URI: https://way2enjoy.com/compress-jpeg
 * Description: Image Optimizer will dramaticaly reduce image file size without losing quality. Resize, compress, optimize PNG, JPG, GIF, PDF, MP3 files, make your website load faster, improve SEO using way2enjoy, the most advanced image optimization tool.
 * Version: 3.2.0.6
 * Author: Way2enjoy
 * Author URI: https://way2enjoy.com/compress-jpeg
 * Text Domain: way2enjoy-compress-images
 */
 
//ini_set('display_errors', 'On');
//ini_set('display_errors', 'Off');
error_reporting(0);
//error_reporting(-1);
set_time_limit(1900);

if ( !class_exists( 'Wp_Way2enjoy' ) ) {


	define( 'WAY2ENJOY_DEV_MODE', false );
	class Wp_Way2enjoy {

		private $id;

		private $way2enjoy_settings = array();

		private $thumbs_data = array();

		private $optimization_type = 'lossy';

		public static $way2enjoy_plugin_version = '3.2.0.6';

		function __construct() {
			$plugin_dir_path = dirname( __FILE__ );
			require_once( $plugin_dir_path . '/lib/Way2enjoy.php' );
			require_once( $plugin_dir_path . '/lib/class-wp-way2enjoy-async.php' );
			$this->way2enjoy_settings = get_site_option( '_way2enjoy_options' );
			$this->optimization_type = $this->way2enjoy_settings['api_lossy'];
			add_action( 'admin_enqueue_scripts', array( &$this, 'my_enqueue' ) );
			add_action( 'wp_ajax_way2enjoy_reset', array( &$this, 'way2enjoy_media_library_reset' ) );
			add_action( 'wp_ajax_way2enjoy_optimize', array( &$this, 'way2enjoy_optimize' ) );
			add_action( 'wp_ajax_way2enjoy_request', array( &$this, 'way2enjoy_media_library_ajax_callback' ) );
			add_action( 'wp_ajax_way2enjoy_reset_all', array( &$this, 'way2enjoy_media_library_reset_all' ) );
			add_action( 'wp_ajax_way2enjoy_requestd', array( $this, 'way2enjoy_media_library_ajax_callback77' ) );
			add_action( 'manage_media_custom_column', array( &$this, 'fill_media_columns' ), 10, 2 );
			add_filter( 'manage_media_columns', array( &$this, 'add_media_columns') );
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( &$this, 'add_settings_link' ) );
			add_action( 'activated_plugin', array( &$this, 'cyb_activation_redirect' ) );
			add_action( 'wp_ajax_dismiss_welcome_notice_way2enjoy', array( &$this, 'dismiss_welcome_notice_way2enjoy' ) );
			add_action( 'wp_ajax_dismiss_buy_notice_way2enjoy', array( &$this, 'dismiss_buy_notice_way2enjoy' ) );
			add_action( 'wp_ajax_dismiss_rate_notice_way2enjoy', array( &$this, 'dismiss_rate_notice_way2enjoy' ) );

//	add_action( 'wp_ajax_way_enable_gzip', array( &$this, 'way_enable_gzip' ) );
			add_action( 'media_page_wp-way2enjoy', array( &$this, 'add_media_columns_way2enjoy_settings' ), 10, 2 );

// directory sleection starts here

			add_action( 'wp_ajax_way2enjoy_get_directory_list', 'way2enjoy_get_directory_list' );
			add_action( 'wp_ajax_image_list_way2enjoy', array( &$this, 'image_list_way2enjoy' ), 10, 2 );
			add_action( 'wp_ajax_way2enjoy_save_directory_list', 'way2enjoy_save_directory_list' );

// directory selection ends here
			add_action( 'plugins_loaded', array( &$this, 'way2enjoy_i18n' ), 12 );

// ajax call starts here
			add_action( 'plugins_loaded', 'load_libs_way2enjoy');

	
// nextgen starts  here

//	add_action( 'wp_ajax_way2_request-nextgen', array( &$this, 'way2enjoy_media_library_nextgen_ajax_callback' ), 9, 2 );
	
	add_action( 'init', function() {
    if ( ! isset( $_REQUEST[ 'photocrati_ajax' ] ) || $_REQUEST['action'] !== 'upload_image' ) {
        # not an upload image request so
        return;
    }
	$controller = C_Ajax_Controller::get_instance();
    $controller->index_action();


		
//$image_id = (int) $_POST['id'];

//$image_id = '99';

$type = false;

				$this->optimization_type = 'loosy';
		//	}

			$this->id = $image_id;

//			if ( wp_attachment_is_image( $image_id ) ) {

				$settings = $this->way2enjoy_settings;
			
	$upload_dir = wp_upload_dir() ;

$directorynext=dirname($upload_dir['basedir']);

$directorynext2= explode("/",$directorynext);  
$onlyname= end($directorynext2);


if(!empty($_SERVER["HTTPS"]))
  if($_SERVER["HTTPS"]!=="off")
    $httpssy='https://'; 
  else
   $httpssy='http://'; 
else
$httpssy='http://'; 

$nggdata = get_site_option( 'ngg_options' ) ;
$gallerypath=$nggdata['gallerypath'] ;
$galleryna= explode("/",$gallerypath,-1);  
$gallerynameuu= end($galleryna);
	

//			
				$image_path = $directorynext.'/'.$gallerynameuu.'/'.$_REQUEST['gallery_name'].'/'.$_REQUEST['name'];


				global $finalurluu;
				$finalurluu = $httpssy.$_SERVER['HTTP_HOST'].'/'.$gallerypath.$_REQUEST['gallery_name'].'/'.$_REQUEST['name'];
				global $finalurlthumb;
				$img_thumbpath = $directorynext.'/'.$gallerynameuu.'/'.$_REQUEST['gallery_name'].'/thumbs/thumbs_'.$_REQUEST['name'];
				$finalurlthumb = $httpssy.$_SERVER['HTTP_HOST'].'/'.$gallerypath.$_REQUEST['gallery_name'].'/thumbs/thumbs_'.$_REQUEST['name'];

				$optimize_main_image = !empty( $settings['optimize_main_image'] );
				$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
				$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';

	
				if ( $optimize_main_image ) {

					// check if thumbs already optimized
					$thumbs_optimized = false;
								$api_result1 = $this->optimize_thumbnails_nextgen( $img_thumbpath, $type, $resize );
						$this->replace_image( $img_thumbpath, $api_result1['compressed_url'] ) ;

					$resize = true;

	$api_result = $this->optimize_image_nextgen( $image_path, $type, $resize );

						
				$this->replace_image( $image_path, $api_result['compressed_url'] );	
					
				}
				
//			$kksdd=$_GET['gallery_id'];

// call test		
//$upload_dir = print_r(wp_upload_dir(),true) ;
$pajgfttht=''.$directorynext.'/93091.txt';
file_put_contents("$pajgfttht","$controller");

// call test ends here	
				
				
		//	}
			wp_die();
	 //  exit;
    # process upload request here
}, 9 );
	
	// nextgen ends  here

		if ( ( !empty( $this->way2enjoy_settings ) && !empty( $this->way2enjoy_settings['auto_optimize'] ) ) || !isset( $this->way2enjoy_settings['auto_optimize'] ) ) {
//	add_action( 'add_attachment', array( &$this, 'way2enjoy_media_uploader_callback' ) );			
//				add_filter( 'wp_generate_attachment_metadata', array( &$this, 'optimize_thumbnails' ) );
				
			add_action( 'wp_async_wp_generate_attachment_metadata', array( &$this, 'way2enjoy_media_library_ajax_callback_new' ), 10, 2  );
		
		
			
			}

			// If settings were not resaved after update
			if ( !isset( $this->way2enjoy_settings["optimize_main_image"] ) ) {
				$this->way2enjoy_settings["optimize_main_image"] = 1;
			}

			// If settings were not resaved after update
			if ( !isset( $this->way2enjoy_settings["chroma"] ) ) {
				$this->way2enjoy_settings["chroma"] = '4:2:0';
			}

		    add_action( 'admin_menu', array( &$this, 'way2enjoy_menu' ) );
			add_action( 'admin_menu', array( &$this, 'screen' ) );
	
		}

	function way2enjoy_i18n() {
			$path = path_join( dirname( plugin_basename( __FILE__ ) ), 'languages' );
			load_plugin_textdomain( 'way2enjoy-compress-images', false, $path );
		}



		function preg_array_key_exists( $pattern, $array ) {
		    $keys = array_keys( $array );    
		    return (int) preg_grep( $pattern,$keys );
		}

		function isApiActive() {
			$settings = $this->way2enjoy_settings;
			$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
			$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';
			if ( empty( $api_key ) || empty( $api_secret) ) {
				return false;
			}
			return true;			
		}



		function way2enjoy_menu() {
			$setting_txt = __( 'Way2enjoy Compress Images Settings', 'way2enjoy-compress-images' );

			add_options_page( $setting_txt, 'Way2enjoy', 'manage_options', 'wp-way2enjoy', array( &$this, 'way2enjoy_settings_page' ) );
		}
function cyb_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'options-general.php?page=wp-way2enjoy' ) ) );
    }
}

		function add_settings_link ( $links ) {
			$setting_txt80 = __( 'Settings', 'way2enjoy-compress-images' );	
			$setting_txt99 = __( "Buy", "way2enjoy-compress-images" );		

			$mylinks[]	='<a href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '">'.$setting_txt80.'</a>';
			$mylinks[]	='<a title="'.$setting_txt4.'" href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '">'.$linktextu.'</a>';
			return array_merge( $links, $mylinks );
		}
		
		
		
		
		
		function way2enjoy_settings_page() {
			if ( !empty( $_POST ) ) {
				$options = $_POST['_way2enjoy_options'];
				$result = $this->validate_options( $options );
				update_site_option( '_way2enjoy_options', $result['valid'] );
			}

			$settings = get_site_option( '_way2enjoy_options' );
			$lossy = isset( $settings['api_lossy'] ) ? $settings['api_lossy'] : 'lossy';
			$auto_optimize = isset( $settings['auto_optimize'] ) ? $settings['auto_optimize'] : 1;
			$optimize_main_image = isset( $settings['optimize_main_image'] ) ? $settings['optimize_main_image'] : 1;
			$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
			$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';
			$show_reset = isset( $settings['show_reset'] ) ? $settings['show_reset'] : 0;
			$bulk_async_limit = isset( $settings['bulk_async_limit'] ) ? $settings['bulk_async_limit'] : 3;
			$preserve_meta_date = isset( $settings['preserve_meta_date'] ) ? $settings['preserve_meta_date'] : 0;
			$preserve_meta_copyright = isset( $settings['preserve_meta_copyright'] ) ? $settings['preserve_meta_copyright'] : 0;
			$preserve_meta_geotag = isset( $settings['preserve_meta_geotag'] ) ? $settings['preserve_meta_geotag'] : 0;
			$preserve_meta_orientation = isset( $settings['preserve_meta_orientation'] ) ? $settings['preserve_meta_orientation'] : 0;
			$preserve_meta_profile = isset( $settings['preserve_meta_profile'] ) ? $settings['preserve_meta_profile'] : 0;
			$auto_orient = isset( $settings['auto_orient'] ) ? $settings['auto_orient'] : 1;
			$resize_width = isset( $settings['resize_width'] ) ? $settings['resize_width'] : 3000;
			$resize_height = isset( $settings['resize_height'] ) ? $settings['resize_height'] : 3000;
			$jpeg_quality = isset( $settings['jpeg_quality'] ) ? $settings['jpeg_quality'] : 0;
			$chroma_subsampling = isset( $settings['chroma'] ) ? $settings['chroma'] : '4:2:0';
			$mp3_bit = isset( $settings['mp3_bit'] ) ? $settings['mp3_bit'] : 96;
			$old_img_compression = isset( $settings['old_img'] ) ? $settings['old_img'] : 550;
			$notice_secn = isset( $settings['notice_s'] ) ? $settings['notice_s'] : 500;
			$total_thumbs = isset( $settings['total_thumb'] ) ? $settings['total_thumb'] : '6';
			$png_quality = isset( $settings['png_quality'] ) ? $settings['png_quality'] : 1;
			$gif_quality = isset( $settings['gif_quality'] ) ? $settings['gif_quality'] : 1;
			$pdf_quality = isset( $settings['pdf_quality'] ) ? $settings['pdf_quality'] : 100;
			$webp_yes = isset( $settings['webp_yes'] ) ? $settings['webp_yes'] : 0;
			$google = isset( $settings['google'] ) ? $settings['google'] : 0;
			$svgenable = isset( $settings['svgenable'] ) ? $settings['svgenable'] : 0;
			$video_quality = isset( $settings['video_quality'] ) ? $settings['video_quality'] : 75;
			$resize_video = isset( $settings['resize_video'] ) ? $settings['resize_video'] : 0;
			$intelligentcrop = isset( $settings['intelligentcrop'] ) ? $settings['intelligentcrop'] : 0;
			$artificial_intelligence = isset( $settings['artificial_intelligence'] ) ? $settings['artificial_intelligence'] : 0;

			$sizes = array_keys($this->get_image_sizes());
			foreach ($sizes as $size) {
				$valid['include_size_' . $size] = isset( $settings['include_size_' . $size]) ? $settings['include_size_' . $size] : 1;
			}

					$status = $this->get_api_status( $api_key, $api_secret );


			$setting_txt = __( 'Way2enjoy Compress Images Settings', 'way2enjoy-compress-images' );
			$setting_txt1 = __( 'Automatic compression enabled', 'way2enjoy-compress-images' );
			$setting_txt2 = __( 'STATS', 'way2enjoy-compress-images' );
			$setting_txt3 = __( 'PLAN', 'way2enjoy-compress-images' );
			$setting_txt4 = __( 'Balance', 'way2enjoy-compress-images' );
			$setting_txt5 = __( 'Compressed', 'way2enjoy-compress-images' );
			$setting_txt6 = __( 'IMAGES COMPRESSED', 'way2enjoy-compress-images' );
			$setting_txt7 = __( 'TOTAL SAVINGS', 'way2enjoy-compress-images' );
			$setting_txt8 = __( 'TOTAL QUOTA', 'way2enjoy-compress-images' );
			$setting_txt9 = __( 'NEXT CREDIT', 'way2enjoy-compress-images' );
			$setting_txt10 = __( 'Bulk Compress/Offers', 'way2enjoy-compress-images' );
			$setting_txt11 = __( 'discount in One time plan & similar discount in yearly & Monthly plans.Discounts decreases daily so hurry & buy some plans', 'way2enjoy-compress-images' );
			$setting_txt12 = __( '1% REDUCES TOMORROW', 'way2enjoy-compress-images' );
			$setting_txt13 = __( 'ONE TIME PLAN', 'way2enjoy-compress-images' );
			$setting_txt14 = __( '500000 Images', 'way2enjoy-compress-images' );
			$setting_txt15 = __( '% Off', 'way2enjoy-compress-images' );
			$setting_txt16 = __( 'YEARLY PLAN', 'way2enjoy-compress-images' );
			$setting_txt17 = __( 'MONTHLY PLAN', 'way2enjoy-compress-images' );
			$setting_txt18 = __( 'Settings saved', 'way2enjoy-compress-images' );
			$setting_txt19 = __( 'Upgrade', 'way2enjoy-compress-images' );
			$setting_txt20 = __( 'Chat', 'way2enjoy-compress-images' );
			$setting_txt21 = __( 'Your basic details will be shared with us', 'way2enjoy-compress-images' );
			$setting_txt22 = __( 'Optimization mode', 'way2enjoy-compress-images' );
			$setting_txt23 = __( 'Way2enjoy Lossy', 'way2enjoy-compress-images' );
			$setting_txt24 = __( 'Lossless', 'way2enjoy-compress-images' );
			$setting_txt25 = __( 'Automatically optimize uploads', 'way2enjoy-compress-images' );
			$setting_txt26 = __( 'Images uploaded through the Media Uploader will be optimized on-the-fly', 'way2enjoy-compress-images' );
			$setting_txt27 = __( 'Disable this setting if you wish to compress images later', 'way2enjoy-compress-images' );
			$setting_txt28 = __( 'Optimize main image', 'way2enjoy-compress-images' );
			$setting_txt29 = __( 'Image uploaded by the user will be optimized, as well as all size images generated by WordPress', 'way2enjoy-compress-images' );
			$setting_txt30 = __( 'Disabling this option results in faster uploading, since the main image is not sent to our system for optimization', 'way2enjoy-compress-images' );
			$setting_txt31 = __( 'Disable if you never use the main image upload in your posts, or speed of image uploading is an issue', 'way2enjoy-compress-images' );
			$setting_txt32 = __( 'Resize main image', 'way2enjoy-compress-images' );
			$setting_txt33 = __( 'Max Width (px)', 'way2enjoy-compress-images' );
			$setting_txt34 = __( 'Max Height (px)', 'way2enjoy-compress-images' );
			$setting_txt35 = __( 'Restrict the maximum dimensions of image uploads by width and/or height', 'way2enjoy-compress-images' );
			$setting_txt36 = __( 'Useful if you wish to prevent large photos with extremely high resolutions from being uploaded', 'way2enjoy-compress-images' );
			$setting_txt37 = __( 'you can restrict the dimensions by width, height, or both. set very high no to avoid resizing', 'way2enjoy-compress-images' );
			$setting_txt38 = __( 'Advanced Settings', 'way2enjoy-compress-images' );
			$setting_txt39 = __( 'We recommend to use default values', 'way2enjoy-compress-images' );
			$setting_txt40 = __( 'Image Sizes to Compress', 'way2enjoy-compress-images' );
			$setting_txt41 = __( 'Automatically Orient Images', 'way2enjoy-compress-images' );
			$setting_txt42 = __( 'This setting will rotate the JPEG image according to its <strong>Orientation</strong> EXIF metadata such that it will always be correctly displayed in Web Browsers', 'way2enjoy-compress-images' );
			$setting_txt43 = __( 'Enable this setting if many of your image uploads come from smart phones or digital cameras which set the orientation based on how they are held at the time of shooting', 'way2enjoy-compress-images' );
			$setting_txt44 = __( 'Show metadata reset per image', 'way2enjoy-compress-images' );
			$setting_txt45 = __( 'Reset All Images', 'way2enjoy-compress-images' );
			$setting_txt46 = __( 'It will add a Reset button in the "Show Details" popup in the Way2enjoy Stats column for already compressed images', 'way2enjoy-compress-images' );
			$setting_txt47 = __( 'Resetting an image will remove the Way2enjoy.com metadata associated with it, effectively making your website forget that it had been optimized in past, allowing further optimization in some cases', 'way2enjoy-compress-images' );
			$setting_txt48 = __( 'If in doubt, please contact support@way2enjoy.com', 'way2enjoy-compress-images' );
			$setting_txt49 = __( 'Bulk Compression', 'way2enjoy-compress-images' );
			$setting_txt50 = __( 'This settings defines how many images can be processed at the same time using the bulk optimizer. The default value is 4', 'way2enjoy-compress-images' );
			$setting_txt51 = __( 'For blogs on shared hosting plans a lower number is advisable to avoid hitting request limits', 'way2enjoy-compress-images' );
			$setting_txt52 = __( 'Save', 'way2enjoy-compress-images' );
		
			$setting_txt71 = __( 'Saved', 'way2enjoy-compress-images' );	
			$setting_txt72 = __( 'Reset', 'way2enjoy-compress-images' );	
			$setting_txt81 = __( 'Rate Us', 'way2enjoy-compress-images' );	
			$setting_txt88 = __( 'HTML, CSS, JS COMPRESSION', 'way2enjoy-compress-images' );	
			$setting_txt89 = __( 'Saving on Your Homepage. All other pages are also compressed', 'way2enjoy-compress-images' );	
			$setting_txt90 = __( 'Done', 'way2enjoy-compress-images' );	

			$setting_txt91 = __( "Images will be optimized by Way2enjoy Image compressor", "way2enjoy-compress-images" );
			$setting_txt92 = __( "Callback was already called", "way2enjoy-compress-images" );
			$setting_txt93 = __( "Failed! Hover here", "way2enjoy-compress-images" );
			$setting_txt94 = __( "Image optimized", "way2enjoy-compress-images" );
			$setting_txt95 = __( "Retry request", "way2enjoy-compress-images" );
			$setting_txt96 = __( "This image can not be optimized any further", "way2enjoy-compress-images" );		
		
			$setting_txt98 = __( "5000 Images", "way2enjoy-compress-images" );		
			$setting_txt100 = __( "GOOGLE PAGESPEED", "way2enjoy-compress-images" );		
			$setting_txt101 = __( "Mobile", "way2enjoy-compress-images" );		
			$setting_txt102 = __( "Desktop", "way2enjoy-compress-images" );		
			$setting_txt103 = __( "Refresh", "way2enjoy-compress-images" );		
			$setting_txt104 = __( "Minutes", "way2enjoy-compress-images" );		
			$setting_txt105 = __( "Seconds", "way2enjoy-compress-images" );		
			$setting_txt99 = __( "Buy", "way2enjoy-compress-images" );	
			$setting_txt106 = __( "Translate", "way2enjoy-compress-images" );	
			$setting_txt107 = __( "YOUR SERVER IS", "way2enjoy-compress-images" );	
			$setting_txt108 = __( "Slow", "way2enjoy-compress-images" );	
			$setting_txt109 = __( "Fast", "way2enjoy-compress-images" );	

			$setting_txt110 = __( "PDF", "way2enjoy-compress-images" );	
			$setting_txt111 = __( "Web Version", "way2enjoy-compress-images" );	
			$setting_txt112 = __( "MP3 Cutter", "way2enjoy-compress-images" );	
			$setting_txt113 = __( "MP3 Compression(Bit)", "way2enjoy-compress-images" );	
			$setting_txt114 = __( "Higher bitrate - Higher quality & bigger size,Low bitrate - Lower quality & smaller size", "way2enjoy-compress-images" );
			$setting_txt115 = __( "Optimize Old Images", "way2enjoy-compress-images" );
			$setting_txt116 = __( "No of previously uploaded images you want to Optimize", "way2enjoy-compress-images" );
			$setting_txt121 = __( "Image quality setting", "way2enjoy-compress-images" );
			$setting_txt122 = __( "Dont Change Please", "way2enjoy-compress-images" );
			$setting_txt123 = __( "Optimize database tables", "way2enjoy-compress-images" );
			$setting_txt124 = __( "Refer", "way2enjoy-compress-images" );
			$setting_txt125 = __( "Website", "way2enjoy-compress-images" );
			$setting_txt126 = __( "Submit", "way2enjoy-compress-images" );
			$setting_txt127 = __( "Report Issue", "way2enjoy-compress-images" );
			$setting_txt128 = __( "Issue", "way2enjoy-compress-images" );
			$setting_txt129 = __( "Support Forum", "way2enjoy-compress-images" );
			$setting_txt132 = __( "Control Notices, Alerts, Warnings", "way2enjoy-compress-images" );
			$setting_txt133 = __( "No of seconds after which all warnings,alerts,notices for all plugins will be hidden.Prefer 5-10 seconds to avoid important notice", "way2enjoy-compress-images" );
			$setting_txt134 = __( "LEVERAGE BROWSER CACHING", "way2enjoy-compress-images" );	
			$setting_txt137 = __( "Backup", "way2enjoy-compress-images" );	
			$setting_txt138 = __( "Cloud Backup for one hour.Only for Premium Customers", "way2enjoy-compress-images" );	
			$setting_txt139 = __( "Webp Image generation", "way2enjoy-compress-images" );	
			$setting_txt140 = __( "Google Love", "way2enjoy-compress-images" );	
			$setting_txt141 = __( "Quality", "way2enjoy-compress-images" );	
			$setting_txt143 = __( "SVG Upload", "way2enjoy-compress-images" );	
			$setting_txt144 = __( "Video", "way2enjoy-compress-images" );	
			$setting_txt145 = __( "Free", "way2enjoy-compress-images" );	
			$setting_txt146 = __( "Pro", "way2enjoy-compress-images" );	
			$setting_txt147 = __( "Intelligent Crop", "way2enjoy-compress-images" );	
			$setting_txt149 = __( "Artificial Intelligence", "way2enjoy-compress-images" );	
			$setting_txt150 = __( "3 Credits/image will be used. Be careful it will do lot of analysis. You may not get more savings in each image but in total you can expect 5-10% more savings. Only for Premium Users", "way2enjoy-compress-images" );	
			$setting_txt152 = __( "Never", "way2enjoy-compress-images" );	


//global $planname;
$resizefirst='';
$titlespacing='';
$displayornot='';
$htmlpopup='';
$stylered='';
$onemorebuy='';
$lbcenable="";
$lbcpopup="";
//$status['y_plan']="";
//$status['expiry']="";
$plannameoriginal=@$status['plan_name'];
//	if ( ( get_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome' )!=1 || get_option( 'wp-way2enjoy-hide_way2enjoy_welcome' ) !=1 )) {
//	$activimg='<img src="/wp-content/plugins/way2enjoy-compress-images/css/dist/loading-before-activation.svg" width="81" height="81"/>';
		if ( ( get_site_option( 'wp-way2enjoy-dir_update_time' )=='')) {

	//get_site_option('wp-way2enjoy-dir_update_time')
	
	
	create_table();
	
		}
	
	$adminemail=get_bloginfo('admin_email');

		
		if ( ( get_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome' )!=1 || get_option( 'wp-way2enjoy-hide_way2enjoy_welcome' ) !=1 )) {
	$totalqu="1000";
	$useedd="1";
	$remainnn="1000";
//		$margintop='520';		
		$margintop='170';			
	$iconslist='class="active"';
	$optinmsg=$setting_txt21.'(Email,Website name)';
	$resizefirst='<script>jQuery(document).ready(function($) {
if($("#the-list").length) {
setTimeout(function() {
$("#doaction").trigger(\'click\');}, 10000);
                        }
                        
                        });
	</script>';
		
					
echo '<div class="wpmud"><div id="wpbody1"><div class="block float-l way2enjoy-welcome-wrapper">';
//add_action( 'admin_notices', 'my_update_notice' );
my_update_notice_way2enjoy();
$this->welcome_screen_way2enjoy();

echo '</div></div></div>
<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/5QNPVzNV-W0" frameborder="0" allowfullscreen></iframe>-->
';
	
//	$emailladd = get_bloginfo('admin_email')  !='' ? get_bloginfo('admin_email') : "'.rand(99999,99999999999).'@tezt.com";
$randemail=rand(999999,99999999999).'@test.com';
	$emailladd = get_bloginfo('admin_email')  !='' ? get_bloginfo('admin_email') : "$randemail";
if(get_bloginfo('admin_email')=='')
{
			update_site_option( 'admin_email', $randemail );		
	
}
else
{
	
}
	
				$dataopttt['api_lossy'] = 'lossy';
				$dataopttt['auto_optimize'] = '1';
				$dataopttt['optimize_main_image'] = '1';
				$dataopttt['auto_orient'] = '1';
				$dataopttt['bulk_async_limit'] = '3';
				$dataopttt['resize_width'] = '3000';
				$dataopttt['resize_height'] = '3000';
				$dataopttt['mp3_bit'] = '96';
				$dataopttt['old_img'] = '550';
				$dataopttt['notice_s'] = '500';
				$dataopttt['jpeg_quality'] = '0';
				$dataopttt['chroma_subsampling'] = '4:2:0';
				$dataopttt['total_thumb'] = '6';
				//$dataopttt['include_size_thumbnail'] = '1';
//				$dataopttt['include_size_medium'] = '1';
//				$dataopttt['include_size_medium'] = '1';
//				$dataopttt['include_size_medium_large'] = '1';
//				$dataopttt['include_size_large'] = '1';
//				$dataopttt['include_size_post-thumbnail'] = '1';
//				$dataopttt['include_size_related'] = '1';
//				$dataopttt['include_size_home_img'] = '1';
			//	$dataopttt['api_key'] = get_bloginfo('admin_email');
				$dataopttt['api_key'] = $emailladd;
				$dataopttt['api_secret'] = get_bloginfo('siteurl');
  				$dataopttt['webp_yes'] = '0';
  				$dataopttt['google'] = '0';
				$dataopttt['pdf_quality'] = '100';
  				$dataopttt['svgenable'] = '0';
				$dataopttt['video_quality'] = '75';
				$dataopttt['resize_video'] = '0';
  				$dataopttt['intelligentcrop'] = '0';
  				$dataopttt['artificial_intelligence'] = '0';

				update_site_option( '_way2enjoy_options', $dataopttt );	
			
				update_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome', 5 );	
				update_site_option( 'hide_way2enjoy_buy', 0 );	
				$timenowww=time()+500000;
				update_site_option( 'rate_way2enjoy', $timenowww );	

				$way2enjoy_savingdata['size_before'] = '2';	
				$way2enjoy_savingdata['size_after'] = '1';	
				$way2enjoy_savingdata['total_images'] = '1';

				$way2enjoy_savingdata['quota_remaining']='1000';
				$way2enjoy_savingdata['pro_not']='0';

				update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );
		
		//$htmlorigi=$status['htmlo_size']  > 0 ? $status['htmlo_size'] : "1";
//$htmlcompress= $status['htmlc_size'] >0 ? $status['htmlc_size']:"1";
$htmlorigi='92510' ;
	$htmlcompress= '27890';
echo '<script>
var countDownDate = new Date().getTime() + 600000;
var x = setInterval(function() {
    var now = new Date().getTime();
  var distance = countDownDate - now;
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
   document.getElementById("timer").innerHTML =  + minutes + " '.$setting_txt104.' " + seconds + " '.$setting_txt105.' ";
       if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "<a href=\''.$_SERVER['REQUEST_URI'].'\'>'.$setting_txt103.'</a>";
    }
}, 1000);

</script><div id="updateyes"></div><script type="text/javascript">var admin_email_way2 = "'.$adminemail.'";</script>';
	
$pagespeedm='<p id="timer"></p>' ;
$pagespeedd= '';
	$seperator2='';
	$statusactive='true';	
	$slowfast=$setting_txt108.'/'.$setting_txt109;
	$strikethrough='style ="text-decoration: line-through;"';
	
				
		}
		
	else
	{
	$statusactive=$status['active'];
	echo '<div class="wpmud"><div id="wpbody2"><div class="block float-l way2enjoy-welcome-wrapper">';
$this->welcome_screen_way2enjoy();
//echo HelloWorldShortcode();
//echo plugin_install_count_shortcode();

echo '</div></div></div>

<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/5QNPVzNV-W0" frameborder="0" allowfullscreen></iframe>-->
';	
	$optinmsg=$setting_txt;				
	$totalqu=$status['quota_total'] ;
	$useedd=$status['quota_used'] ;
	$remainnn=$status['quota_remaining'] ;
		$margintop='170';			
	$iconslist='';

if($remainnn <='700')
{
$displayornot='';	
$titlespacing='';
}
else
{
//$displayornot='style="display:none"';	
$titlespacing='style="margin: -30px 0px 79px 0px"';
$displayornot='';	

// remove this one in next update added only for existing customers who has installed plugin but not saved in their database once they update these things should be saved in their database and should be removed. for all new customers these things will be saved once they install the plugin so this is simply not required for anyone just for old customers so that they can dismiss the notice
			update_site_option( 'hide_way2enjoy_buy', 0 );	
// must be removed above update in version 2.1.0.17 by 25042018

}
$htmlorigi="";
$htmlcompress="";
$slwfst="";
$status['htmlo_size']= '';
$status['htmlc_size']= '';
//$status['slow_fast']= '';
//$htmlorigi= $status['htmlo_size'];
$htmlorigi= $status['htmlo_size'];

if(!empty($htmlorigi)){
$htmlcompress=$status['htmlc_size'];
}
else{
$htmlcompress='10';
}
//$htmlorigi= !empty($status['htmlo_size']);
//$htmlcompress=!empty($status['htmlc_size']);
//$slwfst=!empty($status['slow_fast']);
$slwfst=@$status['slow_fast'];

$strikethrough='';
$pagespeedm=$setting_txt101.': '.@$status['pspeed_m'] ;
$pagespeedd= $setting_txt102.': '.@$status['pspeed_d'];
		$seperator2='/';
		$stylered='';
		$onemorebuy='';
if($remainnn<='0')
{
$buybtnshow=' '.$setting_txt99;	

$stylered='style="color: #ff4411; font-size: 28px;"';

$onemorebuy='<a href="https://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'" target="_blank"> '.$buybtnshow.'&nbsp;&nbsp;</a>';
}


if($slwfst=='0')
{
		$slowfast=$setting_txt108;			

	}
else

{
		$slowfast=$setting_txt109;			
	
}




	}
	
//	$totalqu=$status['quota_total']  > 0 ? $status['quota_total'] : "500";
//	$useedd=$status['quota_used']  > 0 ? $status['quota_used'] : "1";
//	$remainnn=$status['quota_remaining']  > 0 ? $status['quota_remaining'] : "500";
	$yplan=@$status['y_plan']  > 0 ? @$status['y_plan'] : "35";
	$onetimeplan=round($yplan*0.12,2);
	$mplan=round($yplan*0.10,2);


	
$wisiiss=round($useedd/$totalqu*100);
$hhggg=round($remainnn/$totalqu*100);	

$circlepercentage=round($useedd/$totalqu*125,1);
	
			$setting_txt78 = __( 'Your credentials are valid', 'way2enjoy-compress-images' );	

	
	
	$saveingstat = get_site_option( 'way2enjoy_global_stats' ) ;
	$saveingstat0 = get_site_option( 'way2enjoy_global_stats0' ) ;
	$saveingstat1 = get_site_option( 'way2enjoy_global_stats1' ) ;
	$saveingstat2 = get_site_option( 'way2enjoy_global_stats2' ) ;
	$saveingstat3 = get_site_option( 'way2enjoy_global_stats3' ) ;

	
	
	$saveingstat['size_before']="";
	$saveingstat['size_after']="";
	$saveingstat['total_images']="";

	
	//$sizebefor9=$saveingstat['size_before']  > 0 ? $saveingstat['size_before'] : "1";
//	$sizeaftr9=$saveingstat['size_after']  > 0 ? $saveingstat['size_after'] : "1";
//		$sizetotal9=$saveingstat['total_images']  > 0 ? $saveingstat['total_images'] : "0";
//$sizebefor=$sizebefor9+$saveingstat['size_before0']+$saveingstat['size_before1']+$saveingstat['size_before2']+$saveingstat['size_before3'];
//	$sizeaftr=$sizeaftr9+$saveingstat['size_after0']+$saveingstat['size_after1']+$saveingstat['size_after2']+$saveingstat['size_after3'];
//		$sizetotal=$sizetotal9+$saveingstat['total_images0']+$saveingstat['total_images1']+$saveingstat['total_images2']+$saveingstat['total_images3'];	
		
	$sizebefor9=$saveingstat['size_before']  > 0 ? $saveingstat['size_before'] : "1";
	$sizeaftr9=$saveingstat['size_after']  > 0 ? $saveingstat['size_after'] : "1";
		$sizetotal9=$saveingstat['total_images']  > 0 ? $saveingstat['total_images'] : "0";
//$sizebefor=$sizebefor9+$saveingstat0['size_before0']+$saveingstat1['size_before1']+$saveingstat2['size_before2']+$saveingstat3['size_before3'];
//	$sizeaftr=$sizeaftr9+$saveingstat0['size_after0']+$saveingstat1['size_after1']+$saveingstat2['size_after2']+$saveingstat3['size_after3'];
//	$sizetotal=$sizetotal9+$saveingstat0['total_images0']+$saveingstat1['total_images1']+$saveingstat2['total_images2']+$saveingstat3['total_images3'];	
	$sizebefor=$saveingstat0['size_before0']+$saveingstat1['size_before1']+$saveingstat2['size_before2']+$saveingstat3['size_before3']+1;
	$sizeaftr=$saveingstat0['size_after0']+$saveingstat1['size_after1']+$saveingstat2['size_after2']+$saveingstat3['size_after3']+1;
	$sizetotal=$saveingstat0['total_images0']+$saveingstat1['total_images1']+$saveingstat2['total_images2']+$saveingstat3['total_images3']+1;	

		
//$total_saving=$sizebefor-$sizeaftr;
	$total_saving=$sizebefor-$sizeaftr;
	
	
	
	
	// added on 21042018 for updating the quota if the users quota is expired
$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
$way2enjoy_savingdata['size_before']=$sizebefor;

$way2enjoy_savingdata['size_after']=$sizeaftr;
$way2enjoy_savingdata['total_images']=$sizetotal;
$way2enjoy_savingdata['quota_remaining']=$statusuu['quota_remaining'];
$way2enjoy_savingdata['pro_not']=$statusuu['plan_name'];
update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );		

	// ends here 
	
	
//$original_sizeinkb = self::formatBytes( $saveingstat['size_before'] );
//$original_sizeinkb = self::formatBytes( $sizebefor );
$original_sizeinkb = self::formatBytes( $total_saving );


if($way2enjoy_savingdata['pro_not']!='1')
{
$expirydatet= $status['expiry'] >0 ? $status['expiry']:time()+86400*30;
$expirey_date=date('d-M-Y', $expirydatet);
}
else
{
$expirey_date=$setting_txt152.' <a href="#popup8" id="kuchbhi8"> <i class="material-icons">compare_arrows</i></a>';	
}

//$htmlorigi=$htmlorigi  > 0 ? $htmlorigi : "1";
//$htmlcompress= $htmlcompress >0 ? $htmlcompress:"";
//$htmlorigi=$status['htmlo_size'] ;
//$htmlcompress= $status['htmlc_size'];

//$htmloriginal= self::formatBytes( $htmlorigi );
//$htmlcompressed= self::formatBytes( $htmlcompress );

//var_dump($status['htmlo_size'] ,true);
//var_dump($htmlorigi ,true);

if(is_numeric($htmlorigi)){
$htmloriginal= self::formatBytes( $htmlorigi );
$htmlcompressed= self::formatBytes( $htmlcompress );	
$savingperchtml=round(($htmlorigi-$htmlcompress)/$htmlorigi*100,1);
$seperator='/';
$percentage='%';
}
else
{
		$setting_txt97 = __( "Enable Now!", "way2enjoy-compress-images" );		

		if ( get_site_option( 'way2-lbc-enabled' )!=1){ 
				$lbc_text=$setting_txt97;		
		}
		else
		{
		$yes_url= admin_url() . 'images/yes.png';	
		$lbc_text='<span class="apiValid2" style="background:url('.$yes_url.') no-repeat 0 0"></span>';
			
		}

$headergzipuu='';
	if($status['plan_name']=='')
	{
	$headergzipuu='<h3>Upload few images & check this page again.</h3><br>
			<h3>You can see saving in place of that button</h3><br><br><h3>Read Below instructions if you cant</h3>';
			
				
	}
	
	
	
$htmloriginal= '<span class="boxuu"><a href="#popup1" id="kuchbhi">'.$setting_txt97.'</a></span>' ;
$htmlcompressed= $htmlcompress ;	
$savingperchtml='';	
$seperator='';
$percentage='';

$lbcenable= '<span class="boxuu"><a href="#popup7" id="kuchbhi7">'.$lbc_text.'</a></span>' ;
$common_rows='<tr class="way2enjoy-bulk-header"><td>Points to Check.</td><td style="width:120px">Importance</td></tr>

<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">Do only if You are getting this message in GTmetrix</td><td class="way2enjoy-originalsize">High</td></tr>

<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">Take .htaccess file backup ( under public_html folder )</td><td class="way2enjoy-originalsize">High</td></tr>

<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">99% chances are that everything will work in 1 click</td><td class="way2enjoy-originalsize"></td></tr>
<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">But 1% chance of server 500 error is there.</td><td class="way2enjoy-originalsize">High</td></tr>
<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">If you get server error,replace with backup .htaccess file </td><td class="way2enjoy-originalsize">High</td></tr>
<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">Site will be online without any issue</td><td class="way2enjoy-originalsize"></td></tr>
<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">Dont be panic,We are here to make your site super fast</td><td class="way2enjoy-originalsize">High</td></tr>
<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">Feel free to take help if in any doubt. Its free</td><td class="way2enjoy-originalsize"></td></tr>';
$another_head='<h2>Important Points. Must read</h2><a class="close" href="#">×</a><div class="content">';
$htmlpopup='<div id="popup1" class="overlay">
	<div class="popup">
	
			'.$headergzipuu.$another_head.'
		

<table id="way2enjoy-html">'.$common_rows.'<tr class="way2enjoy-item-row"><td class="way2enjoy-bulk-filename">HTML,CSS,JS,SVG etc compression will make site super fast</td><td class="way2enjoy-originalsize"></td></tr></table><input type="hidden" id="gzip" name="enable-gzip" value="0" /><button class="way2enjoy_req_html" id="gzipcomp">Enable HTML,CSS,JS Compression</button></div></div></div>';


$lbcpopup='<div id="popup7" class="overlay"><div class="popup">'.$another_head.'<table>'.$common_rows.'</table><input type="hidden" id="lbc1" name="enable-lbc" value="0" /><button class="way2enjoy_req_lbc" id="lbcenbl">Enable '.$setting_txt134.' </button></div></div></div>  ';



// scheduled to be removed below codes its of no use
	//	if(strtolower($_SERVER['SERVER_SOFTWARE']) == 'apache') {$funname='way2enjoy_addHtaccessContent';}
	//	else{$funname='way2enjoy_other_gzip';}
// scheduled to be removed above codes its of no use


echo '<script>
jQuery(document).ready(function($) {
$(\'.way2enjoy_req_html\').click(function(e){
        e.preventDefault();
        var $el = $(this).parents().eq(1);
        remove_element($el);
	    var data1 = {
        action: \'way_enable_gzip\',
        };		
        $.post(ajaxurl, data1, function(response) {
		 alert(response);
		 $(\'#popup1\').toggleClass(\'overlay class2\');
        });	 			  });
		
 });
</script>';

echo '<script>
jQuery(document).ready(function($) {
$(\'.way2enjoy_req_lbc\').click(function(e){
        e.preventDefault();
        var $el = $(this).parents().eq(1);
        remove_element($el);
	    var data29 = {
        action: \'way_enable_lbc\',
        };		
        $.post(ajaxurl, data29, function(response) {
		 alert(response);
		 $(\'#popup7\').toggleClass(\'overlay class2\');
        });	 			  });
		
 });
</script><script type="text/javascript">var admin_email_way2 = "'.$adminemail.'";</script>';



}

	$savingpercentage=(($sizebefor-$sizeaftr)/$sizebefor*100);
$randdchartt=' <table style="background:#f1f1f1;margin-right:40px;"><tr class="way2enjoyError" title="'.$remainnn.' '.$setting_txt4.','.$useedd.' '.$setting_txt5.'"><td><td style="background:#b9b9b9; width:'.$wisiiss.'%;height:0.3px;"></td><td style="background:#28B576; width:'.$hhggg.'%;height:0.3px;"></td></tr></table>';

			$icon_url = admin_url() . 'images/';
			if ( $status !== false && isset( $status['active'] ) && $status['active'] === true ) {
				$icon_url .= 'yes.png';
	$status_html = '<p class="apiStatus">'.$setting_txt78.' <span class="apiValid" style="background:url(' . "'$icon_url') no-repeat 0 0" . '"></span></p>';
//		

			} else {
				$icon_url .= 'no.png';

$status_html = '<p class="apiStatus"></p>';



//$status_html = '<p class="apiStatus"><input name="pluginemail" type="hidden" id="pluginemail" value="'.get_bloginfo('admin_email').' " onchange="way2ejy.updateSignupEmail();"> <a type="button" id="request_key" style="font-size: 66px;line-height: 66px;height: 75px;font-family: monospace;" class="button button-primary button-hero" title="Request a new API key" href="http://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'" onmouseenter="way2ejy.updateSignupEmail();" target="_blank">Get API Key</a><br><h3>Its free and 1 click away.No Signup required</h3> </p>';


//										
			}
			
		if($plannameoriginal=='0' || $plannameoriginal=='')
{
$backup_text= '<i class="material-icons">clear</i>';
$likesss='';	
	$planname=$setting_txt145.' : '.$setting_txt108;

}
else
{
$backup_text= '<i class="material-icons">cloud_done</i>';
$likesss='';	
	$planname='<span class="proclass"></span> '.$setting_txt146.' : '.$setting_txt109;

}
		
			?>	
            
            
         <?php	 $activimg= '';	  echo $activimg ;	 ?> 
            
              
     
            <h2 class="way2enjoy-admin-section-title"><?php echo $optinmsg ;?> 
            
 <span style="padding-left:20px;"><a style="text-decoration:none" href="https://wordpress.org/support/plugin/way2enjoy-compress-images" target="_blank"><?php echo $setting_txt129;?></a>
<?php
$randomerating=rand(1,5);
	
echo '<a style="text-decoration:none;text-align:right;margin-left:30px;'.$likesss.'" href="https://wordpress.org/support/plugin/way2enjoy-compress-images/reviews/?filter=5" target="_blank"><span class="inlove'.$randomerating.'"></span>'.$setting_txt81.'</a>'; 
//}
//elseif($randomerating=='3')
//{
//echo '<a style="text-decoration:none;text-align:right;margin-left:30px;'.$likesss.'" href="https://translate.wordpress.org/projects/wp-plugins/way2enjoy-compress-images" target="_blank"><i class="material-icons">translate</i></a>'; 	
//}
?> 
  </span>
    <span style="float:right;margin-right: 50px;"><?php echo $setting_txt1;?></span></h2><?php echo $randdchartt ;echo @$status['offer'] ;?>
            
            
            
            
<!--   <form id="way2enjoySettings" method="post">
--> <div class="wpmud"><div id="wpbody3">   
  <div class="row wp-way2enjoy-container-wrap">  
  <div class="wp-way2enjoyit-container-right col-half float-l"><section class="dev-box way2enjoy-stats-wrapper wp-way2enjoy-container" id="wp-way2enjoy-stats-box1"><div class="wp-way2enjoy-container-header box-title" xmlns="http://www.w3.org/1999/xhtml">
			<h3 tabindex="0"><?php echo $setting_txt2 ;?></h3><div class="way2enjoy-container-subheading roboto-medium"><?php echo $planname; ?></div></div><div class="box-content">
			<div class="row way2enjoy-total-savings way2enjoy-total-reduction-percent">
<div class="wp-way2enjoy-current-progress">
				<div class="wp-way2enjoyed-progress">
					<div class="wp-way2enjoy-score inside">
						<div class="tooltip-box">
							<div class="wp-way2enjoy-optimisation-progress">
								<div class="wp-way2enjoy-progress-circle"><a class="way2enjoyError" title="<?php echo $remainnn. ' '.$setting_txt4.','.$useedd.' '. $setting_txt5; ?>">
									<svg class="wp-way2enjoy-svg" xmlns="http://www.w3.org/2000/svg" width="50" height="50">
										<circle class="wp-way2enjoy-svg-circle" r="20" cx="25" cy="25" fill="transparent" stroke-dasharray="0" stroke-dashoffset="0"></circle>
										<!-- Stroke Dasharray is 2 PI r -->
										<circle class="wp-way2enjoy-svg-circle wp-way2enjoy-svg-circle-progress" r="20" cx="25" cy="25" fill="transparent" stroke-dasharray="125" style="stroke-dashoffset:  <?php echo $circlepercentage  < 126 ? $circlepercentage : "125"; ?>px;"></circle>
									</svg></a>
								</div>
							</div>
						</div><!-- end tooltip-box -->
					</div>
				</div>
  
                        
<!--                    stats summary starts here
-->
 <div class="wp-way2enjoy-count-total">
					<div class="wp-way2enjoy-way2enjoy-stats-wrapper">
						<span class="wp-way2enjoy-total-optimised"><?php echo $sizetotal; ?></span>
					</div>
					<span class="total-stats-label"><strong><?php esc_html_e( $setting_txt6, "wp-way2enjoy" ); ?></strong></span>
				</div>
				</div>
			</div>
			<hr />
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt7, "wp-way2enjoy");?></strong></span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human">
						<?php echo $original_sizeinkb > 0 ? $original_sizeinkb : "0MB"; ?>
					</span>
					<span class="wp-way2enjoy-stats-sep">/</span>
					<span class="wp-way2enjoy-stats-percent"><?php echo $savingpercentage > 0 ? number_format_i18n( $savingpercentage, 1, '.', '' ) : 0; ?></span>%
				</span>
			</div>
 <hr>
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt8, "wp-way2enjoy");?></strong></span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human" <?php 
 echo $stylered ; ?>>
                    
                    
                    
                    
						<?php 
 echo $onemorebuy ; ?>
						 <span class="counteruu" data-count="<?php echo $useedd > 0 ? $useedd : "0"; ?>">0</span>
						
						
						
					
                    
                    </span>
					<span class="wp-way2enjoy-stats-sep">/</span>
					<span class="wp-way2enjoy-stats-percent"><?php echo $totalqu > 0 ? $totalqu : 1500; ?><a href="#popup5" id="kuchbhi5">
                    <span class="transfer"></span>                    
                    </a></span>
				</span>
			</div>
			            <hr>        
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo $setting_txt9; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
				                    <span class="wp-way2enjoy-stats-human">
		             
<?php

echo $expirey_date; 
 
 ?>          

	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden">/</span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
          <hr>        
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><span class="way2enjoyError" title="<?php echo $setting_txt138; ?>"><?php echo $setting_txt137; ?></span></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
				                    <span class="wp-way2enjoy-stats-human">
		             
<?php

echo $backup_text; 
 
 ?>          

	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden">/</span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>    
            
            
                <hr>        
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo ''; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
				                    <span class="wp-way2enjoy-stats-human">
		               
<?php

echo ''; 
 
 ?>          

	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden">/</span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
            
            
            
            </div>				<!-- Make a hidden div if not stats found -->
				</section>				</div>    
                <div class="wp-way2enjoyit-container-right col-half float-l"><section class="dev-box way2enjoy-stats-wrapper wp-way2enjoy-container" id="wp-way2enjoy-stats-box2">			<div class="wp-way2enjoy-container-header box-title" <?php 	echo $titlespacing; ?> xmlns="http://www.w3.org/1999/xhtml">
			<h3 tabindex="0"><?php echo $setting_txt10; ?></h3><div class="way2enjoy-container-subheading roboto-medium"><div class="way2enjoy-container-subheading roboto-medium">
     <?php 	echo $resizefirst; ?>
            
            
   <!--       bulk compressor starts here    
-->           
<?php 	echo  $this->add_media_columns_way2enjoy_settings();	  ?>
         <!--       bulk compressor ends here    
-->     
   </div></div>			</div>			<div class="box-content" <?php 	echo $displayornot; ?>>
			
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt13, "wp-way2enjoy");?></strong></span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human">
						<?php echo $setting_txt98; ?>
					</span>
					<span class="wp-way2enjoy-stats-sep">/</span>
					<span class="wp-way2enjoy-stats-percent"><a href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank"><?php echo $onetimeplan; ?></a></span><a href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank"><?php $buybtnshow='';	
 echo '$ '.$buybtnshow; ?></a>
				</span>
			</div>   
      <hr>
		
            
            
            
            
               <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo $setting_txt16; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
                
             
             <span class="wp-way2enjoy-stats-human">
						<?php echo $setting_txt98; ?>
					</span>
               
                <span class="wp-way2enjoy-stats-sep">/</span>
				                    <span class="wp-way2enjoy-stats-human">
		                <a href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank">
<?php echo $yplan.'$ '.$buybtnshow; ?>          
              </a>
	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden"></span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
           
            
			            <hr>           
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo $setting_txt17; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
                
             
             <span class="wp-way2enjoy-stats-human">
						<?php echo $setting_txt98; ?>
					</span>
               
                <span class="wp-way2enjoy-stats-sep">/</span>
				                    <span class="wp-way2enjoy-stats-human">
		                <a href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank">
<?php echo $mplan.'$ '.$buybtnshow; ?>          
              </a>
	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden"></span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
            
            
            
            
            	            <hr>           
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo $setting_txt124; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
                
             
             <span class="wp-way2enjoy-stats-human">
						<?php echo $setting_txt98; ?>
					</span>
                 <span class="wp-way2enjoy-stats-sep">/</span>
				                    <span class="wp-way2enjoy-stats-human">
		                <a href="#popup2" id="kuchbhi2"><?php echo $setting_txt125; ?></a>
	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden"></span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
            
                   <hr>           
            <div class="row way2enjoy-dir-savings">
            <span class="float-l wp-way2enjoy-stats-label"><strong><?php echo $setting_txt127; ?></strong></span>
            <span class="float-r wp-way2enjoy-stats">
	            <span class="spinner" style="visibility: visible; display: none;" title="Updating Stats"></span>
                
             
             <span class="wp-way2enjoy-stats-human">
						<?php echo $setting_txt98; ?>
					</span>
                 <span class="wp-way2enjoy-stats-sep">/</span>
				                    <span class="wp-way2enjoy-stats-human">
		                <a href="https://wordpress.org/support/plugin/way2enjoy-compress-images" target="_blank"><?php echo $setting_txt128; ?></a>
	                </span>
                    <span class="wp-way2enjoy-stats-sep hidden"></span>
                    <span class="wp-way2enjoy-stats-percent"></span>
				                </span>
            </div>
            
            
            
            
            
            </div>				<!-- Make a hidden div if not stats found -->
				</section>				</div>      
                <!--     check third options        
-->     
     
     
  <form id="way2enjoySettings" method="post">  
       
 <div class="wp-way2enjoyit-container-right col-half float-l"><section class="dev-box way2enjoy-stats-wrapper wp-way2enjoy-container" id="wp-way2enjoy-stats-box3">			<div class="wp-way2enjoy-container-header box-title" xmlns="http://www.w3.org/1999/xhtml">
			<h3 tabindex="0"><?php echo $setting_txt32 ;?> ++</h3></div><div class="box-content">
        
        	<div><div class="wp-way2enjoy-resize-settings-wrap"><?php echo '<label><span class="way2enjoyError" title="'.$setting_txt35.' '.$setting_txt36.'  '. $setting_txt37.'">'.$setting_txt33.'</span><input type="text" id="way2enjoy_maximum_width" class="wp-way2enjoy-resize-input" value="'.esc_attr( $resize_width ).'" placeholder="'.esc_attr( $resize_width ).'" name="_way2enjoy_options[resize_width]" tabindex="0">
						</label><label><span class="way2enjoyError" title="'.$setting_txt35.' '.$setting_txt36.'  '. $setting_txt37.'">'.$setting_txt34.'</span><input type="text" id="way2enjoy_maximum_height" class="wp-way2enjoy-resize-input" value="'.esc_attr( $resize_height ).'" placeholder="'.esc_attr( $resize_height ).'" name="_way2enjoy_options[resize_height]" tabindex="0">
</label><input type="submit" style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_saveresize" onClick="this.value=\''.$setting_txt71.'\'" class="button button-primary" value="&nbsp;&nbsp;'.$setting_txt52.'"/>
<span class="way2enjoy-reset-all enabled">'.$setting_txt45.'</span>'; ?></div></div><hr />
           
<!--            mp3 starts here
-->            <div><div class="wp-way2enjoy-resize-settings-wrap"><label><span class="way2enjoyError" title="<?php echo  $setting_txt114; ?>"><?php echo $setting_txt113; ?></span>



  <span class="countBox" style="text-align:center;"><input id="valueClignote" type="range" value="<?php echo esc_attr( $mp3_bit );?>" max="320" min="16" step="16"></span>

<input type="text" id="way2enjoy_mp3" class="wp-way2enjoy-resize-input" style="text-align:left;" name="_way2enjoy_options[mp3_bit]" placeholder="<?php echo esc_attr( $mp3_bit );?>" tabindex="0">
			</label>
                        
                       <!-- <input type="submit"  style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_savemp3" onClick="this.value='<?php echo $setting_txt71; ?>'"  class="button button-primary" value="<?php echo $setting_txt52; ?>"/>-->       
                        
				                </span>
     
     
                        </div></div><hr />
<!--            mp3 ends here
-->    


<!--            pdf starts here
-->            <div><div class="wp-way2enjoy-resize-settings-wrap"><label><span class="way2enjoyError"><?php echo $setting_txt110.' '.$setting_txt141.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span class="countBox" style="text-align:center;"><input id="valueClignote1" type="range" value="<?php echo esc_attr( $pdf_quality );?>" max="100" min="10" step="10"></span><input type="text" id="way2enjoy_pdf" class="wp-way2enjoy-resize-input" style="text-align:left;" name="_way2enjoy_options[pdf_quality]" placeholder="<?php echo esc_attr( $pdf_quality );?>" tabindex="0"></label><!-- <input type="submit"  style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_savepdf" onClick="this.value='<?php echo $setting_txt71; ?>'"  class="button button-primary" value="<?php echo $setting_txt52; ?>"/>--></div></div><hr />
<!--            pdf ends here
--> 


  <div><div class="wp-way2enjoy-resize-settings-wrap"><label><span class="way2enjoyError" title="<?php echo  $setting_txt116; ?>"><?php echo $setting_txt115; ?>&nbsp;&nbsp;&nbsp;</span><input type="text" id="way2enjoy_old" class="wp-way2enjoy-resize-input" value="<?php echo esc_attr( $old_img_compression );?>" placeholder="<?php echo esc_attr( $old_img_compression );?>" name="_way2enjoy_options[old_img]" tabindex="0">
						</label><input type="submit" style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_saveold"  onClick="this.value='<?php echo $setting_txt71; ?>'"  class="button button-primary" value="<?php echo $setting_txt52; ?>"/></div></div>
                        
                        
              <!--           server status starts here 
-->            	<hr />
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt121, "wp-way2enjoy");?></strong>
</span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human">

<select name="_way2enjoy_options[jpeg_quality]" class="beautyface">
											<?php $i = 0 ?>
											<?php foreach ( range(100, 25) as $number ) { ?>
												<?php if ( $i === 0 ) { ?>
													<?php echo '<option value="0">'.$setting_txt122.''; ?>
												<?php } ?>
                                                <!-- <optgroup label="qty">-->
												<?php if ($i > 0) { ?>

													<option value="<?php echo $number ?>" <?php selected( $jpeg_quality, $number, true); ?>>
													<?php echo $number; ?>
												<?php } ?>
													</option>
                                                    	<?php $i++ ?>
                                                    <!--  </optgroup>-->

											
											<?php } ?>
										</select>

					</span>                  
				</span>
			</div>  	<hr />        
       			<!-- Make a hidden div if not stats found -->    
            
            
            
            
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt88, "wp-way2enjoy");?></strong>
</span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human" <?php echo $strikethrough; ?>>
						<?php echo $htmloriginal; ?>
					</span>
					<span class="wp-way2enjoy-stats-sep"><?php echo $seperator; ?></span>
					<span class="wp-way2enjoy-stats-human" <?php echo $strikethrough; ?>>
						<?php echo $htmlcompressed; ?>
					</span>
                    <span class="wp-way2enjoy-stats-sep"><?php echo $seperator; ?></span>
				<span class="way2enjoyError" title="<?php echo $setting_txt89; ?>">	<span class="wp-way2enjoy-stats-percent">
					<?php echo $savingperchtml; ?></span><?php echo $percentage; ?></span>
				</span>
			</div>
            
<!--           Google page speed starts here 
-->            	<hr />

			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt100, "wp-way2enjoy");?></strong>
</span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human" id="down-btnm">
						<?php echo $pagespeedm; ?>
					</span>
					<span class="wp-way2enjoy-stats-sep"><?php echo $seperator2; ?></span>
                    
                  
                    
                    <span class="wp-way2enjoy-stats-human" id="down-btnd">
						<?php echo $pagespeedd; ?><a id="pagespeedin"><span id="imgmmm" class="reload"></span><span class="loadericon" id="img" style="display:none"></span>
</a>
					</span>
                  
				</span>
			</div>
            
            
            
          <!--           server status starts here 
-->            	<hr />
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt107, "wp-way2enjoy");?></strong>
</span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human" <?php echo $strikethrough; ?>>
						<?php echo $slowfast; ?>
					</span>                  
				</span>
			</div>         
       			<!-- Make a hidden div if not stats found -->
               	<hr />
			<div class="row wp-way2enjoy-savings">
				<span class="float-l wp-way2enjoy-stats-label"><strong><?php esc_html_e($setting_txt134, "wp-way2enjoy");?></strong>
</span>
				<span class="float-r wp-way2enjoy-stats">
					<span class="wp-way2enjoy-stats-human">
						<?php  echo $lbcenable; ?>
					</span>                  
				</span>
			</div>            
                

                
                
                            </div>

				</section>		
                
                		</div>  
             
      
<div class="wp-way2enjoyit-container-right col-half float-l"><section class="dev-box way2enjoy-stats-wrapper wp-way2enjoy-container" id="wp-way2enjoy-stats-box4"><div class="wp-way2enjoy-container-header box-title" xmlns="http://www.w3.org/1999/xhtml">
			<h3 tabindex="0"><?php esc_html_e($setting_txt132, "wp-way2enjoy");?></h3><div class="way2enjoy-container-subheading roboto-medium"><div class="way2enjoy-container-subheading roboto-medium"></div></div></div><div class="box-content"><div class="row wp-way2enjoy-savings"><div><div class="wp-way2enjoy-resize-settings-wrap"><label><span class="way2enjoyError" title="<?php echo  $setting_txt133; ?>"><?php echo $setting_txt105; ?>&nbsp;&nbsp;&nbsp;</span><input type="text" id="way2enjoy_notice" class="wp-way2enjoy-resize-input" value="<?php echo esc_attr( $notice_secn );?>" placeholder="<?php echo esc_attr( $notice_secn );?>" name="_way2enjoy_options[notice_s]" tabindex="0"></label><input type="submit" style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_savenotice"  onClick="this.value='<?php echo $setting_txt71; ?>'"  class="button button-primary" value="<?php echo $setting_txt52; ?>"/></div></div></div></div></section></div>
            
            
            
            
            
<!--   ========================video starts here======================================              
-->      
      <div class="wp-way2enjoyit-container-right col-half float-l"><section class="dev-box way2enjoy-stats-wrapper wp-way2enjoy-container" id="wp-way2enjoy-stats-box5"><div class="wp-way2enjoy-container-header box-title" xmlns="http://www.w3.org/1999/xhtml">
			<h3 tabindex="0"><?php echo $setting_txt144;?></h3><div class="way2enjoy-container-subheading roboto-medium"><div class="way2enjoy-container-subheading roboto-medium"></div></div></div><div class="box-content"><div class="row wp-way2enjoy-savings">
            
       <!--            video starts here
-->            <div><div class="wp-way2enjoy-resize-settings-wrap"><label><span class="way2enjoyError"><?php echo $setting_txt144.' '.$setting_txt141.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span class="countBox" style="text-align:center;"><input id="valueClignote2" type="range" value="<?php echo esc_attr( $video_quality );?>" max="100" min="10" step="5"></span><input type="text" id="way2enjoy_video" class="wp-way2enjoy-resize-input" style="text-align:left;" name="_way2enjoy_options[video_quality]" placeholder="<?php echo esc_attr( $video_quality );?>" tabindex="0"></label><!-- <input type="submit"  style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_savepdf" onClick="this.value='<?php echo $setting_txt71; ?>'"  class="button button-primary" value="<?php echo $setting_txt52; ?>"/>--></div></div><hr />



<div><div class="wp-way2enjoy-resize-settings-wrap"><?php echo '<label><span class="way2enjoyError" title="'.$setting_txt35.' '.$setting_txt36.'  '. $setting_txt37.'">'.$setting_txt33.'</span><input type="text" id="way2enjoy_maximum_vwidth" class="wp-way2enjoy-resize-input" value="'.esc_attr( $resize_video ).'" placeholder="'.esc_attr( $resize_video ).'" name="_way2enjoy_options[resize_video]" tabindex="0"></label><input type="submit" style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_savevideo" onClick="this.value=\''.$setting_txt71.'\'" class="button button-primary" value="&nbsp;&nbsp;'.$setting_txt52.'"/>'; ?></div></div><hr />




<!--            video ends here
--> 
            
            
            </div></div></section></div>
      
<!--      ======================video ends here====================================
-->       
<div id="popup2" class="overlay">
	<div class="popup">
		<h2>Refer friends get 2500+2500 credit instantly</h2>
		<a class="close" href="#">×</a>
        <div id="referlo-btnm"></div>
		<div class="content" id="refsubmit">
<label>Friends site name where Plugin is installed & both of you will get 2500 Credit.<br /> <input type="text" id="sitename" name="sitename" value="" placeholder="https://example.com" /></label>

<input type="hidden" id="referral" name="referal" value="<?php echo get_bloginfo('admin_email'); ?>" />

<button class="way2enjoy_req_referal" id="referralsub"><?php echo $setting_txt126 ;?></button>
</div><div class="hiddenspinner" alt="spinner" id="imgref"></div> 
	
    <br />  <br /> <br /> <code>Hey,

I’ve been using Way2enjoy image optimizer plugin for WordPress and it made my website blazing fast.

Just download way2enjoy image optimizer from wordpress and install. Click on Refer and enter <?php echo get_bloginfo('siteurl'); ?>  & both will get 2500 credit instantly.Like me, You can also post these things in your site and forget about credit at all. Whenever someone will read your post and install this plugin and when he claims refer credit you will get 2500 always.
       
                     </code> <br /> <br /> <br /><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwordpress.org%2Fplugins%2Fway2enjoy-compress-images%2F" target="_blank"><span class="fbsvg"></span></a><a href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Fway2enjoy-compress-images%2F" target="_blank"><span class="twtsvg"></span></a><a href="https://reddit.com/submit?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Fway2enjoy-compress-images%2F" target="_blank"><span class="rdtsvg"></span></a><br /> 
                    Paste in FB/Twitter/Whatsapp etc & get 2000 Credit/Share <a style="text-decoration:none;text-align:right;margin-left:30px;" href="https://wordpress.org/support/view/plugin-reviews/way2enjoy-compress-images?rate=5#postform" target="_blank"><h2 style="display:inline-block"><?php echo $setting_txt81 ;?></h2></a> 	<br />
                     <code>Hey Try this image optimizer & speedup your site. Its free. https://wordpress.org/plugins/way2enjoy-compress-images/</code>
    
    </div>
    
  
    
</div> 


<div id="popup5" class="overlay">
	<div class="popup">
		<h2>Transfer Credit instantly</h2>
		<a class="close" href="#">×</a>
        <div id="trnsfr-btnm"></div>
		<div class="content" id="trsfrsubmit">
<label>Website Name/Admin Email(Preferred) where you want to transfer<br /> <input type="text" id="tsitename" name="tsitename" value="" placeholder="https://example.com or something@someemail.com" /></label>
<label>Credit(for example:1500)<br /> <input type="text" id="tcredite" name="tcredite" value="" placeholder="1500" /></label>
<button class="way2enjoy_req_referal" id="transfersub"><?php echo $setting_txt126 ;?></button>
</div><div class="hiddenspinner" alt="spinner" id="imgreftransfer"></div> 
	
    <br />  <br /> <br /> <code>Hey,

Its completely safe.Noone can steal your credit ever but you can easily transfer your credit to your friend sites :)
       
                     </code> <br /> <br /> <br /> <a style="font-size: 14px;line-height: 32px;height: 32px;font-family: monospace;" class="button button-primary button-hero" href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank"> <?php echo $setting_txt20;?></a>
                     
</div></div> 

<!--///popup 8
-->
<div id="popup8" class="overlay">
	<div class="popup">
		<h2>Switch to FREE account & get free Credit </h2><h5></h5>
		<a class="close" href="#">×</a>
        <div id="swtch-btnm"></div>
		<div class="content" id="swtchsubmit">
<label>FREE to PRO not Possible without Payment<br /> </label>
<button class="way2enjoy_req_referal" id="switchsub"><?php echo $setting_txt126 ;?></button>
</div><div class="hiddenspinner" alt="spinner" id="switchspinner"></div> 
	
    <br />  <br /> <br />  
                     
</div></div> 

<!--/// popup8 ends here
-->

<div id="popup10" class="overlay">
	<div class="popup">
    <a class="close" href="#">×</a>
		<h2>Refresh few times if Your Purchased Credit is not reflecting </h2><h5></h5> <br /> <br />
		<h3><?php echo $setting_txt8.':'.$totalqu; ?></h3>
    <br />   <br />  
                     
</div></div>



<div id="popup3" class="overlay">

	<div class="popup">
     <?php 
				$setting_txt130 = __( "Choose Directory", "way2enjoy-compress-images" );
	
	echo	'<h2>'.$setting_txt130.'</h2>';
	?>
		<a class="close" href="#">×</a>
   
   <div id="filetree-basic"></div>     
    <br /><br /><br /><br />
    <?php 
	$setting_txt103 = __( "Refresh", "way2enjoy-compress-images" );		
	$setting_txt126 = __( "Submit", "way2enjoy-compress-images" );

     echo ' <div id="save_response"></div><button class="way2enjoy_req_folder" id="way2enjoy_savedirectory">'.$setting_txt126.'</button>';
   
   
   ?>     
    </div>
    

    
</div> 


<div id="popup6" class="overlay">
	<div class="popup">
		<h2>Update your email address</h2>
		<a class="close" href="#">×</a>
        <div id="updte-btnm"></div>
		<div class="content" id="updtesubmit">

<button class="way2enjoy_req_updemail" id="upetemlsub"><?php echo $setting_txt52 ;?></button>
</div><div class="hiddenspinner" alt="spinner" id="imgupdtemail"></div> 
	
    <br />  
                     
</div></div> 




     <?php echo $htmlpopup; echo $lbcpopup; ?>       
<!--       third options ends here              
-->                
                <!-- </div> </div>-->
<!--          	 stats summary ends here
-->       
	<?php if ( isset( $result['error'] ) ) { ?>
						<div class="way2enjoy error settings-error">
						<?php foreach( $result['error'] as $error ) { ?>
							<p><?php echo $error; ?></p>
						<?php } ?>
						</div>
					<?php } else if ( isset( $result['success'] ) ) { ?>
						<div class="way2enjoy updated settings-error">
							<p><?php echo $setting_txt18; ?>.</p>
						</div>
					<?php } ?>				
 <p style="font-size:18px">
   <!--            <a style="font-size: 14px;line-height: 32px;height: 32px;font-family: monospace;" class="button button-primary button-hero" href="https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>" target="_blank"> <?php echo $setting_txt100.' 100';?></a>

<a style="font-size: 14px;line-height: 32px;height: 32px;font-family: monospace;" class="button button-primary button-hero" href="http://way2enjoy.com/word-to-pdf-online-free-without-email" target="_blank"> <?php echo $setting_txt110;?></a>
<a style="font-size: 14px;line-height: 32px;height: 32px;font-family: monospace;" class="button button-primary button-hero" href="https://way2enjoy.com/compress-png" target="_blank"> <?php echo $setting_txt111;?></a>
<a style="font-size: 14px;line-height: 32px;height: 32px;font-family: monospace;" class="button button-primary button-hero" href="https://way2enjoy.com/mp3-cutter" target="_blank"> <?php echo $setting_txt112;?></a>
-->        </p>
					<!--<form id="way2enjoySettings" method="post">-->
		<table class="form-table" style="background: #fff;color: #000;font-family:'Roboto Condensed',Roboto,sans-serif;font-size:18px;font-weight:500;line-height: 1.4em;margin-right:20px;border-radius:10px;">
						    <tbody>
                              <tr>
						            <th scope="row" class="somespc"><?php echo $setting_txt21;?></th>
						            <td>
<!--             <input id="way2enjoy_api_key" name="_way2enjoy_options[api_key]" type="text" value="<?php echo esc_attr( $api_key ); ?>" >
-->                                        
      	  <input id="way2enjoy_api_key" name="_way2enjoy_options[api_key]" type="hidden" value="<?php echo get_bloginfo('admin_email'); ?>">
             <input id="way2enjoy_api_secret" name="_way2enjoy_options[api_secret]" type="hidden" value="<?php echo get_bloginfo('siteurl'); ?>" />

						            </td>
						        </tr>
                              <tr>
						           <th scope="row" class="somespc"><?php echo $status_html ?></th>
						            <td>
						                
						            </td>
						        </tr>			     
						  <tr style="border-bottom: 1px solid #EAEAEA"><td></td><td></td></tr>
						      <tr class="with-tip">
						           <th scope="row" class="somespc"><?php echo $setting_txt22;?>:</th>
						            <td>
						                <input type="radio" id="way2enjoy_lossy" name="_way2enjoy_options[api_lossy]" value="lossy" <?php checked( 'lossy', $lossy, true ); ?>/>
						               <label for="way2enjoy_lossy"><?php echo $setting_txt23;?></label>
						                <input style="margin-left:10px;" type="radio" id="way2enjoy_lossless" name="_way2enjoy_options[api_lossy]" value="lossless" <?php checked( 'lossless', $lossy, true ) ?>/>
						                <label for="way2enjoy_lossless"><?php echo $setting_txt24;?></label>
						            </td>
						        </tr>
                              <!--   
						        <tr class="tip">
						        	<td colspan="2">
						        		<div>
						        			The <strong>Intelligent Lossy</strong> mode will yield the greatest savings without perceivable reducing the quality of your images, and so we recommend this setting to users.<br />
						        			The <strong>Lossless</strong> mode will result in an unchanged image, however, will yield reduced savings as the image will not be recompressed.
						        		</div>
						        	</td>
						        </tr>-->
						        <tr class="with-tip">
						            <th scope="row" class="somespc">
					<div class="way2enjoyError" title="<?php echo $setting_txt26.' '.$setting_txt27;?>">
									<?php echo $setting_txt25;?>:
                                    </div>
                                    </th>
						            <td>
						                <input type="checkbox" id="auto_optimize" name="_way2enjoy_options[auto_optimize]" value="1" <?php checked( 1, $auto_optimize, true ); ?>/>
						            </td>
						        </tr>
						      <!--  <tr><td colspan="2"></td></tr>-->
                                
						        <tr class="with-tip">
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt29.' '.$setting_txt30.' '.$setting_txt31;?>">
									<?php echo $setting_txt28;?>:
                                     </div>
                                    </th>
                                   
						            <td>
						                <input type="checkbox" id="optimize_main_image" name="_way2enjoy_options[optimize_main_image]" value="1" <?php checked( 1, $optimize_main_image, true ); ?>/>
						            </td>
						        </tr>
						     						       <!-- <tr><td colspan="2"></td></tr>-->

 <tr class="with-tip">
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt150;?>">
									<?php echo $setting_txt149;?>:
                                     </div>
                                    </th>
                                   <td>
						                <input type="checkbox" id="artificial_intelligence" title="<?php echo $setting_txt150;?>" name="_way2enjoy_options[artificial_intelligence]" value="1" <?php checked( 1, $artificial_intelligence, true ); ?>/>                     
                      </td>
						        </tr>

						       <!-- <tr class="with-tip">
						        	<th scope="row" class="somespc"><?php 
								//	echo $setting_txt32;
									?>:</th>
						        	<td>
						        		<?php 
									//	echo $setting_txt33;
										?>:&nbsp;&nbsp;<input type="text" id="way2enjoy_maximum_width" name="_way2enjoy_options[resize_width]" value="<?php 
									//	echo esc_attr( $resize_width ); 
										?>" style="width:50px;" />&nbsp;&nbsp;&nbsp;<?php 
									//	echo $setting_txt34;
										?>:&nbsp;<input type="text" id="way2enjoy_maximum_height" name="_way2enjoy_options[resize_height]" value="<?php //echo esc_attr( $resize_height ); ?>" style="width:50px;" />
						        	</td>
						        </tr>-->
						 
						   
						      <!--   <tr class="tip">
						        	<td colspan="2">
						        		<div>
						        			Advanced users can force the quality of JPEG images to a discrete "q" value between 25 and 100 using this setting <br />
						        			For example, forcing the quality to 60 or 70 might yield greater savings, but the resulting quality might be affected, depending on the image. <br />
						        			We therefore recommend keeping the <strong>Intelligent Lossy</strong> setting, which will not allow a resulting image of unacceptable quality.<br />
						        			This setting will be ignored when using the <strong>lossless</strong> optimization mode.
						        		</div>
						        	</td>
						        </tr>
						      <tr class="with-tip">
						            <th scope="row" class="somespc">Chroma subsampling scheme:</th>
						            <td>
						                <input type="radio" id="way2enjoy_chroma_420" name="_way2enjoy_options[chroma]" value="4:2:0" <?php checked( '4:2:0', $chroma_subsampling, true ); ?>/>
						                <label for="way2enjoy_chroma_420">4:2:0 (default)</label>
						                <input style="margin-left:10px;" type="radio" id="way2enjoy_chroma_422" name="_way2enjoy_options[chroma]" value="4:2:2" <?php checked( '4:2:2', $chroma_subsampling, true ) ?>/>
						                <label for="way2enjoy_chroma_422">4:2:2</label>
						                <input style="margin-left:10px;" type="radio" id="way2enjoy_chroma_444" name="_way2enjoy_options[chroma]" value="4:4:4" <?php checked( '4:4:4', $chroma_subsampling, true ) ?>/>
						                <label for="way2enjoy_chroma_444">4:4:4 (no subsampling)</label>						             
						            </td>
						        </tr>
						        <tr class="tip">
						        	<td colspan="2">
						        		<div>
						        			Advanced users can also set the resolution at which colour is encoded for JPEG images. In short, the default setting of <strong>4:2:0</strong> is suitable for most images,<br />
						        			and will result in the lowest possible optimized file size. Images containing high contrast text or bright red areas on flat backgrounds might benefit from disabling chroma subsampling<br />
						        			(by setting it to <strong>4:4:4</strong>). More information can be found in our <a href="https://way2enjoy.com/docs/chroma-subsampling" target="_blank">documentation</a>.
						        		</div>
						        	</td>
						        </tr>		-->			
                                <tr style="border-bottom: 1px solid #EAEAEA"><td></td><td></td></tr>	        					      
						        <tr class="no-border">
						        	<td class="way2enjoyAdvancedSettings"><h3><span class="way2enjoy-advanced-settings-label">
									<span class="way2enjoyError" title="<?php echo $setting_txt39;?>">
									<?php echo $setting_txt38;?>
                                    
                                    </span></span></h3></td><td></td>
                                    
						        </tr>
						       <!-- <tr class="way2enjoy-advanced-settings">
						        	<td colspan="2" class="way2enjoyAdvancedSettingsDescription"><small><?php //echo ' &nbsp;&nbsp;&nbsp;'.$setting_txt39;?></small></td>
						        </tr>-->
						        <tr class="way2enjoy-advanced-settings">
						           <th scope="row" class="somespc"><?php echo $setting_txt40;?>:</th>
									<td>
						            	<?php $size_count = count($sizes); ?>
						            	<?php $i = 0;$pm = 0; ?>
						            	<?php foreach($sizes as $size) { ?>
						            	<?php $size_checked = isset( $valid['include_size_' . $size] ) ? $valid['include_size_' . $size] : 1; ?>
						                <label for="<?php echo "way2enjoy_size_$size" ?>"><input type="checkbox" id="way2enjoy_size_<?php echo $size ?>" name="_way2enjoy_options[include_size_<?php echo $size ?>]" value="1" <?php checked( 1, $size_checked, true ); ?>/>&nbsp;<?php echo $size ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						            	<?php $i++ ;
										if($size_checked=='1'){$pm++;}
										
										?>
                                        
						            	<?php if ($i % 3 == 0) { ?>
						            		<br />
						            	<?php } ?>
     							        <?php } ?>
                                        <input type="hidden" name="_way2enjoy_options[total_thumb]" value="<?php echo $pm; ?>" />
						            </td>
						        </tr>						        
						      <!--  <tr class="way2enjoy-advanced-settings">
						           <th scope="row" class="somespc">Preserve EXIF Metadata:</th>
						            <td>
						                <label for="preserve_meta_date"><input type="checkbox" id="preserve_meta_date" name="_way2enjoy_options[preserve_meta_date]" value="1" <?php checked( 1, $preserve_meta_date, true ); ?>/>&nbsp;Date</label>&nbsp;&nbsp;&nbsp;&nbsp;
						                <label for="preserve_meta_copyright"><input type="checkbox" id="preserve_meta_copyright" name="_way2enjoy_options[preserve_meta_copyright]" value="1" <?php checked( 1, $preserve_meta_copyright, true ); ?>/>&nbsp;Copyright</label>&nbsp;&nbsp;&nbsp;&nbsp;
						                <label for="preserve_meta_geotag"><input type="checkbox" id="preserve_meta_geotag" name="_way2enjoy_options[preserve_meta_geotag]" value="1" <?php checked( 1, $preserve_meta_geotag, true ); ?>/>&nbsp;Geotag</label>&nbsp;&nbsp;&nbsp;&nbsp;
    						            <label for="preserve_meta_orientation"><input type="checkbox" id="preserve_meta_orientation" name="_way2enjoy_options[preserve_meta_orientation]" value="1" <?php checked( 1, $preserve_meta_orientation, true ); ?>/>&nbsp;Orientation</label>&nbsp;&nbsp;&nbsp;&nbsp;
						                <label for="preserve_meta_profile"><input type="checkbox" id="preserve_meta_profile" name="_way2enjoy_options[preserve_meta_profile]" value="1" <?php checked( 1, $preserve_meta_profile, true ); ?>/>&nbsp;Profile</label>&nbsp;&nbsp;&nbsp;&nbsp;
						            </td>
						        </tr>-->
						        <tr class="way2enjoy-advanced-settings with-tip">
                                
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt42.' '.$setting_txt43;?>">
									<?php echo $setting_txt41;?>:
</div>                                    </th>
						            <td>
						            	<input type="checkbox" id="auto_orient" name="_way2enjoy_options[auto_orient]" value="1" <?php checked( 1, $auto_orient, true ); ?>/>
						            </td>
						        </tr>
<!-- <tr><td colspan="2"></td></tr>-->



 <tr class="way2enjoy-advanced-settings with-tip">
                                
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt97;?>">
									<?php echo $setting_txt139;?>:
</div>                                    </th>
						            <td>
				<input type="checkbox" id="webp_yes" name="_way2enjoy_options[webp_yes]" value="1" <?php checked( 1, $webp_yes, true ); ?>/>
						            </td>
						        </tr>
<!-- <tr><td colspan="2"></td></tr>-->

<tr class="way2enjoy-advanced-settings with-tip">
                                
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt97;?>">
									<?php echo $setting_txt140;?>:
</div>                                    </th>
						            <td>
				<input type="checkbox" id="google" name="_way2enjoy_options[google]" value="1" <?php checked( 1, $google, true ); ?>/>
						            </td>
						        </tr>
<!-- <tr><td colspan="2"></td></tr>-->


<tr class="way2enjoy-advanced-settings with-tip">
                                
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt97;?>">
									<?php echo $setting_txt143;?>:
</div>                                    </th>
						            <td>
				<input type="checkbox" id="svgenable" name="_way2enjoy_options[svgenable]" value="1" <?php checked( 1, $svgenable, true ); ?>/>
						            </td>
						        </tr>
                                
                                
                                
                                
         <tr class="way2enjoy-advanced-settings with-tip">
                                
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title="<?php echo $setting_txt97;?>">
									<?php echo $setting_txt147;?>:
</div>                                    </th>
						            <td>
				<input type="checkbox" id="intelligentcrop" name="_way2enjoy_options[intelligentcrop]" value="1" <?php checked( 1, $intelligentcrop, true ); ?>/>
						            </td>
						        </tr>
                                
                                   
                                

    						    <tr class="way2enjoy-advanced-settings with-tip">
						           <th scope="row" class="somespc">
									<div class="way2enjoyError" title='<?php echo $setting_txt46.' '.$setting_txt47.' '.$setting_txt48;?>'>
									<?php echo $setting_txt44;?>:
                                    </div>
                                    
                                    </th>
						            <td>
						                <input type="checkbox" id="way2enjoy_show_reset" name="_way2enjoy_options[show_reset]" value="1" <?php checked( 1, $show_reset, true ); ?>/>
						                &nbsp;&nbsp;&nbsp;&nbsp;<span class="way2enjoy-reset-all enabled"><?php echo $setting_txt45;?></span>
						            </td>
						        </tr>
						      						     <!--   <tr><td colspan="2"></td></tr>-->

						        <tr class="way2enjoy-advanced-settings with-tip">
						        	<th scope="row" class="somespc"><div class="way2enjoyError" title="<?php echo $setting_txt50.' '.$setting_txt51;?>"><?php echo $setting_txt49;?>:</div></th>
						        	<td>
										<select name="_way2enjoy_options[bulk_async_limit]">
											<?php foreach ( range(1, 4) as $number ) { ?>
												<option value="<?php echo $number ?>" <?php selected( $bulk_async_limit, $number, true); ?>>
													<?php echo $number ?>
												</option>
											<?php } ?>
										</select> 
						        	</td>
						        </tr>
						     						       <!-- <tr><td colspan="2"></td></tr>-->

                                
<!--             // different compression modes starts here                   
-->                    
<tr><td id="hideshow">&nbsp;&nbsp;&nbsp;&nbsp;Dont Click Me</td><td></td></tr>
                  <!--     // pdf compression settings-->
                                
                               <!--     <tr class="way2enjoy-advanced-settings with-tip hidethis" id="hidethis5" style="display: none;">
						        	<th scope="row" class="somespc">PDF:</th>
						        	<td>
										<select name="_way2enjoy_options[pdf_quality]">
                                        <option value="0">No Compression</option>
										<option value="1" selected="selected">Lossy Compression</option>
                                         <option value="2">Lossless Compression</option>
                                    	<option value="3">Max Lossy Compression</option>
                                              
										</select>
						        	</td>
						        </tr>  
                             <tr class="tip hidethis" id="hidethis6" style="display: none;"><td colspan="2"></td></tr>     
-->            
            
            
                <!--  //png compression setting -->
                        <tr class="way2enjoy-advanced-settings with-tip hidethis" id="hidethis1"  style="display: none;">
						        	<th scope="row" class="somespc">PNG:</th>
						        	<td>
										<select name="_way2enjoy_options[png_quality]">
                                        <option value="0">No Compression</option>
										<option value="1" selected="selected">Lossy Compression</option>
                                         <option value="2">Lossless Compression</option>
                                    	<option value="3">Super Lossy Compression</option>
                                              
										</select>
						        	</td>
						        </tr>           
                                <tr class="tip hidethis" id="hidethis2"  style="display: none;"><td colspan="2"></td></tr>
                                            <!-- //gif compression setting -->
     
                                      <tr class="way2enjoy-advanced-settings with-tip hidethis" id="hidethis3"  style="display: none;">
						        	<th scope="row" class="somespc">GIF:</th>
						        	<td>
										<select name="_way2enjoy_options[gif_quality]">
                                        <option value="0">No Compression</option>
										<option value="1" selected="selected">Lossy Compression</option>
                                         <option value="2">Lossless Compression</option>
                                    	<option value="3">Max Lossy Compression</option>
                                              
										</select>
						        	</td>
						        </tr>           
                            <tr class="tip hidethis" style="display: none;" id="hidethis4" ><td colspan="2"></td></tr>
                    
                             
<!--    // different compression modes end here                   
--> 
<!--// conversion to different formats
-->

 <tr class="with-tip hidethis" style="display: none;" id="hidethis7" >
<th scope="row" class="somespc">Enable Conversion:</th><td>
<input style="margin-left:10px;" class="conver" type="radio" id="way2enjoy_convn" name="_way2enjoy_options[conv]" value="0" checked="checked" /><label>No</label>
<input type="radio" id="way2enjoy_convy" class="conver" name="_way2enjoy_options[conv]" value="1" />
<label>Yes</label>
						            </td>
                                    <td>
   <div class="way2-table-row" style="display: none;">
                                <div class="way2-table-cell">
                                    <label title="Removes metadata and increases cpu usage dramatically">JPG to PNG Conversion:
                                        </label>
                                </div>
                                <div class="way2-table-cell">
                  <input type="radio" name="jpg_to_png" id="jpg_to_png0" value="0" class="" checked="">
                                            <label>No</label>
                                                                                    <input type="radio" name="jpg_to_png" id="jpg_to_png1" value="1" class="">
                                            <label>Yes</label>
                                        
                                                                        <!-- help text -->
                                                                            <br>
<small>PNG uses lossless compression. It is preferred format of graphics designers who uses it for logos and pictures with transparent backgrounds. Converting to JPG removes image metadata</small>
                                                                                                        </div>
                            </div>
                                                    <div class="way2-table-row" style="display: none;">
                                <div class="way2-table-cell">
                                    <label>JPG to WEBP Conversion:
                                        </label>
                                </div>
                                <div class="way2-table-cell">
                                 <input type="radio" name="jpg_to_webp" id="jpg_to_webp0" value="0" class="" checked="">
                                            <label>No</label>
                                                                                    <input type="radio" name="jpg_to_webp" id="jpg_to_webp1" value="1" class="">
                                            <label>Yes</label>
                                        
                                                                        <!-- help text -->
                                                                            <br>
                                        <small>WebP images are 25-34% smaller images on average and can speed up your website. JPG to WebP conversion is lossy, but image quality will be identical.</small>
                                                                                                        </div>
                            </div>
                                                    <div class="way2-table-row" style="display: none;">
                                <div class="way2-table-cell">
                                    <label>PNG to JPG Conversion:
                                        </label>
                                </div>
                                <div class="way2-table-cell">
                                                                                                                        <input type="radio" name="png_to_jpg" id="png_to_jpg0" value="0" class="" checked="">
                                            <label>No</label>
                                                                                    <input type="radio" name="png_to_jpg" id="png_to_jpg1" value="1" class="">
                                            <label>Yes</label>
                                        
                                                                        <!-- help text -->
                                                                            <br>
<small>JPG format is preferred format for high-resolution photographs and images. Plugin uses lossy compression so minimal image data is lost during image compression.</small>
                                                                                                        </div>
                            </div>
                                                    <div class="way2-table-row" style="display: none;">
                                <div class="way2-table-cell">
                                    <label>PNG to WEBP Conversion:
                                        </label>
                                </div>
                                <div class="way2-table-cell">
                                                                                                                        <input type="radio" name="png_to_webp" id="png_to_webp0" value="0" class="" checked="">
                                            <label>No</label>
                                                                                    <input type="radio" name="png_to_webp" id="png_to_webp1" value="1" class="">
                                            <label>Yes</label>
                                        
                                                                        <!-- help text -->
                                                                            <br>
<small>PNG to WebP conversion is lossless. WebP images are 26% smaller in size on average so make your website faster but remember webp is not supported by all browser.</small>
                                                                                                        </div>
                            </div>
                                                    <div class="way2-table-row" style="display: none;">
                                <div class="way2-table-cell">
                                    <label>GIF to PNG Conversion:
                                        </label>
                                </div>
                                <div class="way2-table-cell">
                                                                                                                        <input type="radio" name="gif_to_png" id="gif_to_png0" value="0" class="" checked="">
                                            <label>No</label>
                                                                                    <input type="radio" name="gif_to_png" id="gif_to_png1" value="1" class="">
                                            <label>Yes</label>
                                        
                                                                        <!-- help text -->
                                                                            <br>
<small>PNG uses lossless compression. It is recommended for logos and pictures with transparent backgrounds. Animated GIFs cannot be converted as it contains several frames.</small>
                                                                                                        </div>
                            </div>
                                      
</td>
                                    
                                    
						        </tr>




<!--// conversion to different formats ends here
-->


                  
						    </tbody>
						</table>
			     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" style="vertical-align: middle;" name="way2enjoy_save" id="way2enjoy_save"  onClick="this.value='<?php echo $setting_txt71; ?>'" class="button button-primary" value="<?php echo $setting_txt52;?>"/>
			  </form></div></div>  </div>  
         
    
    
 
   <script>
jQuery(document).ready(function($) {
$('#referralsub').click(function(event) { 
$('#imgref').show();
$('#refsubmit').hide();

event.preventDefault();
var sitenameu = jQuery("#sitename").val();
var emailids = '<?php echo get_bloginfo('admin_email'); ?>'; 

$.ajax({
url: 'https://way2enjoy.com/modules/compress-png/referral-wp.php',

dataType: 'json',
cache:false,
data: {
sitenameu:sitenameu,
emailids:emailids
},
		type: "post",	
        success: function(data) {
var htmldre = '';
for (var i = 0; i < data.length; i++) {
referlo = data[i];
htmldre = ''+ referlo.credituu +'';
}

$('#referlo-btnm').html(htmldre);
$('#imgref').hide();

 }
    });
    return false; 
});
 });
</script>
          
     
     
     
<!--  // try email update  --> 
      <script>
jQuery(document).ready(function($) {
$('#updtesubmit').click(function(event) { 
$('#imgupdtemail').show();
$('#updtesubmit').hide();

event.preventDefault();
var siteoldemail = '<?php echo $api_key; ?>';
var newemail = '<?php echo get_bloginfo('admin_email'); ?>'; 

$.ajax({
url: 'https://way2enjoy.com/modules/compress-png/update-api.php',

dataType: 'json',
cache:false,
data: {
siteoldemail:siteoldemail,
newemail:newemail
},
type: "post",	
success: function(data) {
var htmldre = '';
for (var i = 0; i < data.length; i++) {
emlupdtlo = data[i];
htmldemailupdt = ''+ emlupdtlo.msgemail +'';
}
$('#updte-btnm').html(htmldemailupdt);
$('#imgupdtemail').hide();
 }
});
    return false; 
});
 });
</script>
     
     
    <!-- // try email update ends here  -->
  
     
     
     
     
     
     
        <script>
jQuery(document).ready(function($) {
$('#transfersub').click(function(event) { 
$('#imgreftransfer').show();
$('#trsfrsubmit').hide();

event.preventDefault();
var sitenameut = jQuery("#tsitename").val();
var emailidst = '<?php echo get_bloginfo('admin_email'); ?>'; 
var tcredite = jQuery("#tcredite").val();
$.ajax({
url: 'https://way2enjoy.com/modules/compress-png/transfer-wp.php',

dataType: 'json',
cache:false,
data: {
sitenameut:sitenameut,
emailidst:emailidst,
tcredite:tcredite
},
		type: "post",	
        success: function(data) {
var trnsfrdre = '';
for (var i = 0; i < data.length; i++) {
trnsfrlo = data[i];
trnsfrdre = ''+ trnsfrlo.tcredituu +'';
}

$('#trnsfr-btnm').html(trnsfrdre);
$('#imgreftransfer').hide();

 }
    });
    return false; 
});
 });
</script>
     
    
    
    
<!--// switch accounts starts here    
-->    
          <script>
jQuery(document).ready(function($) {
$('#switchsub').click(function(event) { 
$('#switchspinner').show();
$('#swtchsubmit').hide();

event.preventDefault();
var emailidst = '<?php echo get_bloginfo('admin_email'); ?>'; 
$.ajax({
url: 'https://way2enjoy.com/modules/compress-png/switch-wp.php',

dataType: 'json',
cache:false,
data: {
emailidst:emailidst
},
		type: "post",	
        success: function(data) {
var swtchdre = '';
for (var i = 0; i < data.length; i++) {
swtchlo = data[i];
swtchdre = ''+ swtchlo.switchstatus +'';
}

$('#swtch-btnm').html(swtchdre);
$('#switchspinner').hide();

 }
    });
    return false; 
});
 });
</script>
    
    
<!--// switch accounts starts here    
-->    
    
    
    
    
    
    
    
    
     
                                       
<script>jQuery(document).ready(function($) 
{
	$("#kuchbhi").click(function() {
		$("#gzip").val("1");
		var gzipval=$("#gzip").val(); 
		});
		
		 $('#way2enjoy_maximum_width').click(function(){
       $('#way2enjoy_saveresize').show()
     })
		
		 $('#way2enjoy_mp3').click(function(){
       $('#way2enjoy_savemp3').show()
     })
	  $('#way2enjoy_old').click(function(){
       $('#way2enjoy_saveold').show()
     })
 $('#way2enjoy_notice').click(function(){
       $('#way2enjoy_savenotice').show()
     })
 $('#way2enjoy_maximum_vwidth').click(function(){
       $('#way2enjoy_savevideo').show()
     })

		});
</script>



<script>
jQuery(document).ready(function($) {
$('#pagespeedin,#gzipcomp').click(function(event) { 
//$('#pagespeedin').click(function(event) { 
$('#img').show();
$('#imgmmm').hide();

    event.preventDefault(); 
    $.ajax({
        url: 'https://way2enjoy.com/modules/compress-png/page-speed-wp2.php?email=<?php echo get_bloginfo('admin_email'); ?>',
		dataType: 'json',
    	cache:false,
	type: 'GET',
        success: function(data) {
var htmlm = '';
var htmld = '';
for (var i = 0; i < data.length; i++) {
downlo = data[i];
htmlm = ''+ downlo.pagespeedm +'';
htmld = ''+ downlo.pagespeedd +'';
}

if(htmlm === "undefined")
{
$('#down-btnd').html(htmld);
}
else
{
$('#down-btnm').html(htmlm);
}
$('#img').hide();
    $('#imgmmm').show();
   
 }
    });
    return false; 
});
 });
</script>


<script>
jQuery(document).ready(function($) 
{
$('.counteruu').each(function() {
  var $this = $(this),
      countTo = $this.attr("data-count");
  
  $({ countNum: $this.text()}).animate({
    countNum: countTo
  },

  {

    duration: 5000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
    }

  });  
  
  

});

	});
</script>

<script>
jQuery(function ($) {
$(document).ready(function () {
	$('#kuchbhi3').click(function(event) { 
   var getDirectoryList = function (param) {
        param.action = 'way2enjoy_get_directory_list';
        var res = '';
        $.ajax({
            type: "GET",
            url: ajaxurl,
            data: param,
            success: function (response) {
                res = response;
            },
            async: false
        });
        return res;
    };
$("#filetree-basic").fileTree({
script: getDirectoryList,
multiFolder: false
        });}); });});
      
    </script>






<script>
jQuery(function ($) {
$(document).ready(function () {
	$('#way2enjoy_savedirectory').click(function() { 
	var data = {
    action: 'way2enjoy_save_directory_list',
};
jQuery.post(ajaxurl, data, function(response) {
  //  alert(+ response);
  $('#save_response').html( ''+ response +'<meta http-equiv="refresh" content="2;url=<?php echo $_SERVER['REQUEST_URI']; ?>">' )
});	
		
});});});
    </script>   
         
<!--   ///new button starts here      
-->         
  <div id="button-group22" <?php echo $iconslist; ?>>
  <button class="primary-md">
    <i class="material-icons">add</i>
  </button>
  <button title="<?php echo $setting_txt19; ?>" onclick="window.open('https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>')"><i class="material-icons">shopping_cart</i>
  </button>
  <button title="<?php echo $setting_txt81; ?>" onclick="window.open('https://wordpress.org/support/view/plugin-reviews/way2enjoy-compress-images?rate=5#postform')"><i class="material-icons">grade</i>
  </button>
  <button title="<?php echo $setting_txt127; ?>" onclick="window.open('https://wordpress.org/support/plugin/way2enjoy-compress-images')"><i class="material-icons">forum</i>
  </button>
   <button title="<?php echo $setting_txt20; ?>" onclick="window.open('https://way2enjoy.com/compress-jpeg?pluginemail=<?php echo get_bloginfo('admin_email'); ?>')" ><i class="material-icons">chat</i>
  </button>  
 <button title="<?php echo $setting_txt106; ?>" onclick="window.open('https://translate.wordpress.org/projects/wp-plugins/way2enjoy-compress-images')"><i class="material-icons">translate</i>
  </button>
  
</div>       
         			<?php
		}

function validate_options( $input ) {
	$setting_txt82 = __( 'API Credentials must not be left blank.', 'way2enjoy-compress-images' );
		$setting_txt83 = __( 'Developer API credentials cannot be used with this plugin', 'way2enjoy-compress-images' );
		$setting_txt84 = __( 'Please enter a valid Way2enjoy.com API key and secret.' );

$valid = array();
$error = array();


//$valid['api_lossy'] = $input['api_lossy'];
$valid['api_lossy'] = sanitize_text_field($input['api_lossy']);
//if( isset( $input['auto_optimize'] ) ){$valid['auto_optimize'] =  sanitize_text_field($input['auto_optimize'] )? 1 : 0;}
//if( isset( $input['optimize_main_image'] ) ){$valid['optimize_main_image'] = sanitize_text_field($input['optimize_main_image'] ) ? 1 : 0;}

$valid['auto_optimize'] = isset( $input['auto_optimize'] )? 1 : 0;
$valid['optimize_main_image'] = isset( $input['optimize_main_image'] ) ? 1 : 0;
if( isset( $input['preserve_meta_date'] ) ){$valid['preserve_meta_date'] = sanitize_text_field($input['preserve_meta_date'] ) ? sanitize_text_field($input['preserve_meta_date']) : 0;}
if( isset( $input['preserve_meta_copyright'] ) ){$valid['preserve_meta_copyright'] = sanitize_text_field($input['preserve_meta_copyright'] ) ? sanitize_text_field($input['preserve_meta_copyright']) : 0;}
if( isset( $input['preserve_meta_geotag'] ) ){$valid['preserve_meta_geotag'] = sanitize_text_field($input['preserve_meta_geotag'] ) ? sanitize_text_field($input['preserve_meta_geotag']) : 0;}
if( isset( $input['preserve_meta_orientation'] ) ){$valid['preserve_meta_orientation'] = sanitize_text_field($input['preserve_meta_orientation'] ) ? sanitize_text_field($input['preserve_meta_orientation']) : 0;}
if( isset( $input['preserve_meta_profile'] ) ){$valid['preserve_meta_profile'] = sanitize_text_field($input['preserve_meta_profile'] ) ? sanitize_text_field($input['preserve_meta_profile']) : 0;}
if( isset( $input['auto_orient'] ) ){$valid['auto_orient'] = sanitize_text_field($input['auto_orient'] ) ? sanitize_text_field($input['auto_orient']) : 0;}
if( isset( $input['show_reset'] ) ){$valid['show_reset'] = sanitize_text_field($input['show_reset'] ) ? 1 : 0;}
if( isset( $input['bulk_async_limit'] ) ){$valid['bulk_async_limit'] = sanitize_text_field($input['bulk_async_limit'] ) ? sanitize_text_field($input['bulk_async_limit']) : 3;}
if( isset( $input['resize_width'] ) ){$valid['resize_width'] = sanitize_text_field($input['resize_width'] ) ? (int) sanitize_text_field($input['resize_width']) : 3000;}
if( isset( $input['resize_height'] ) ){$valid['resize_height'] = sanitize_text_field($input['resize_height'] ) ? (int) sanitize_text_field($input['resize_height']) : 3000;}
if( isset( $input['jpeg_quality'] ) ){$valid['jpeg_quality'] = sanitize_text_field($input['jpeg_quality'] ) ? (int) sanitize_text_field($input['jpeg_quality']) : 0;}
if( isset( $input['chroma'] ) ){$valid['chroma'] = sanitize_text_field($input['chroma']) ? sanitize_text_field($input['chroma']) : '4:2:0';}
if( isset( $input['mp3_bit'] ) ){$valid['mp3_bit'] = sanitize_text_field($input['mp3_bit'] ) ? (int) sanitize_text_field($input['mp3_bit']) : 96;}
if( isset( $input['old_img'] ) ){$valid['old_img'] = sanitize_text_field($input['old_img'] ) ? (int) sanitize_text_field($input['old_img']) : 550;}
if( isset( $input['notice_s'] ) ){$valid['notice_s'] = sanitize_text_field($input['notice_s'] ) ? (int) sanitize_text_field($input['notice_s']) : 0;}

if( isset( $input['total_thumb'] ) ){$valid['total_thumb'] = sanitize_text_field($input['total_thumb'] ) ? (int) sanitize_text_field($input['total_thumb']) : 6;}
if( isset( $input['png_quality'] ) ){$valid['png_quality'] = sanitize_text_field($input['png_quality'] ) ? (int) sanitize_text_field($input['png_quality']) : 1;}
if( isset( $input['gif_quality'] ) ){$valid['gif_quality'] = sanitize_text_field($input['gif_quality'] ) ? (int) sanitize_text_field($input['gif_quality']) : 1;}
if( isset( $input['pdf_quality'] ) ){$valid['pdf_quality'] = sanitize_text_field($input['pdf_quality'] ) ? (int) sanitize_text_field($input['pdf_quality']) : 100;}
if( isset( $input['webp_yes'] ) ){$valid['webp_yes'] = sanitize_text_field($input['webp_yes'] ) ? 1 : 0;}
if( isset( $input['google'] ) ){$valid['google'] = sanitize_text_field($input['google'] ) ? 1 : 0;}
if( isset( $input['svgenable'] ) ){$valid['svgenable'] = sanitize_text_field($input['svgenable'] ) ? 1 : 0;}
if( isset( $input['video_quality'] ) ){$valid['video_quality'] = sanitize_text_field($input['video_quality'] ) ? (int) sanitize_text_field($input['video_quality']) : 75;}
if( isset( $input['resize_video'] ) ){$valid['resize_video'] = sanitize_text_field($input['resize_video'] ) ? (int) sanitize_text_field($input['resize_video']) : 0;}
if( isset( $input['intelligentcrop'] ) ){$valid['intelligentcrop'] = sanitize_text_field($input['intelligentcrop'] ) ? 1 : 0;}
if( isset( $input['artificial_intelligence'] ) ){$valid['artificial_intelligence'] = sanitize_text_field($input['artificial_intelligence'] ) ? 1 : 0;}



			$sizes = get_intermediate_image_sizes();
			foreach ($sizes as $size) {
				$valid['include_size_' . $size] = isset($input['include_size_' . $size]) ? 1 : 0;
			}

			if ( $valid['show_reset'] ) {
				$valid['show_reset'] = sanitize_text_field($input['show_reset']);
			}

//			if ( empty( $input['api_key']) || empty( $input['api_secret'] ) ) {
//				if ( empty( sanitize_text_field($input['api_key']))) {
				if ( empty( $input['api_key'])) {

				$error[] = $setting_txt82;
			} 
			
			
			else {
			
				$status = $this->get_api_status( sanitize_text_field($input['api_key']), sanitize_text_field($input['api_secret'] ));

				if ( $status !== false ) {

//	if ( isset($status['active']) && $status['active'] === true ) {

					//	if ( $status['plan_name'] === 'Developers' ) {
						//	if ( $planname === 'Developers' ) {
//							$error[] = 'Developer API credentials cannot be used with this plugin.';
//						} else {
							$valid['api_key'] = sanitize_text_field($input['api_key']);
							$valid['api_secret'] = sanitize_text_field($input['api_secret']);
					//	}
//					} else {
//						$error[] = $setting_txt83;
//					}

				} else {
					$error[] = $setting_txt84 ;
				}			
			}

			if ( !empty( $error ) ) {
				return array( 'success' => false, 'error' => $error, 'valid' => $valid );
			} else {
				return array( 'success' => true, 'valid' => $valid );
			}
		}

		function my_enqueue( $hook ) {
			
	if ( $hook == 'options-media.php' || $hook == 'upload.php' || $hook == 'settings_page_wp-way2enjoy' || $hook == 'media_page_wp-way2enjoy') {

//		if ( $hook == 'options-media.php' || $hook == 'upload.php' || $hook == 'settings_page_wp-way2enjoy' ) {
				wp_enqueue_script( 'jquery' );
				if ( WAY2ENJOY_DEV_MODE === true ) {
					wp_enqueue_script( 'async-js', plugins_url( '/js/async.js', __FILE__ ) );
					wp_enqueue_script( 'tipsy-js', plugins_url( '/js/jquery.tipsy.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'modal-js', plugins_url( '/js/jquery.modal.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'ajax-script', plugins_url( '/js/ajax.js', __FILE__ ), array( 'jquery' ) );
					wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
					wp_localize_script( 'ajax-script', 'way2enjoy_settings', $this->way2enjoy_settings );
					wp_enqueue_style( 'way2enjoy_admin_style', plugins_url( 'css/admin.css', __FILE__ ) );
					wp_enqueue_style( 'tipsy-style', plugins_url( 'css/tipsy.css', __FILE__ ) );
					wp_enqueue_style( 'modal-style', plugins_url( 'css/jquery.modal.css', __FILE__ ) );
				} else {
					wp_enqueue_script( 'way2enjoy-js', plugins_url( '/js/dist/way2enjoy11.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'way2enjoy-additional', plugins_url( '/js/dist/way2enjoy.misc5.js', __FILE__ ), array( 'jquery' ) );
					wp_localize_script( 'way2enjoy-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
					wp_localize_script( 'way2enjoy-js', 'way2enjoy_settings', $this->way2enjoy_settings );
					wp_enqueue_style( 'wpb-fa', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,500,300,300italic' );
					wp_enqueue_style( 'wpb-mi', 'https://fonts.googleapis.com/icon?family=Material+Icons' );

					wp_enqueue_style( 'way2enjoy-css1', plugins_url( 'css/dist/way2enjoy.min16.css', __FILE__ ) );		

					wp_enqueue_style( 'way2enjoy-css', plugins_url( 'css/dist/way2enjoy.min3.css', __FILE__ ) );	
//				    wp_enqueue_script( 'way2enjoy-jstree', plugins_url( '/js/dist/jQueryFileTree.js', __FILE__ ), array( 'jquery' ) );

			wp_enqueue_script( 'jqft-js', plugins_url( 'js/dist/jQueryFileTree.js', __FILE__ ), array( 'jquery' )  );	
			wp_enqueue_style( 'jqft-css', plugins_url( 'css/dist/jQueryFileTree.css', __FILE__ ) );	
	 
$direcscan= time()- get_site_option('wp-way2enjoy-dir_update_time');
if($direcscan<='600')
{	 
		wp_enqueue_script( 'way2enjoy-js2', plugins_url( '/js/dist/ajaxcheck5.js', __FILE__ ), array( 'jquery' ) );
			
}
				//	wp_localize_script( 'way2enjoy-js2', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

			//		update_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome', true );

					localize();

				}
			}
			

		}
		

		function get_api_status( $api_key, $api_secret ) {

			if ( !empty( $api_key ) && !empty( $api_secret ) ) {
				$way2enjoy = new Way2enjoy( $api_key, $api_secret );
				$status = $way2enjoy->status();
				return $status;
			}
			return false;
		}

		/**
		 *	Converts an deserialized API result array into an array
		 *	which this plugin will consume
		 */
		function get_result_arr( $result, $image_id ) {
			$rv = array();
			$rv['original_size'] = $result['original_size'];
			$rv['compressed_size'] = $result['compressed_size'];
			$rv['saved_bytes'] = $result['saved_bytes'];
			$savings_percentage = $result['saved_bytes'] / $result['original_size'] * 100;
			$rv['savings_percent'] = round( $savings_percentage, 2 ) . '%';
			$rv['type'] = $result['type'];
			if ( !empty( $result['way2enjoyed_width'] ) && !empty( $result['way2enjoyed_height'] ) ) {
				$rv['way2enjoyed_width'] = $result['way2enjoyed_width'];
				$rv['way2enjoyed_height'] = $result['way2enjoyed_height'];
			}
			$rv['quota_remaining'] = $result['quota_remaining'];
			$rv['success'] = $result['success'];
			$rv['meta'] = wp_get_attachment_metadata( $image_id );
			return $rv;		
		
		}


		/**
		 *  Handles optimizing already-uploaded images in the  Media Library
		 */
		 
		 
	function dismiss_welcome_notice_way2enjoy() {
			update_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome', 1 );
			wp_send_json_success();
		}
		 
		function dismiss_buy_notice_way2enjoy() {
			$timestamp=time()+259200;
			update_site_option( 'hide_way2enjoy_buy', $timestamp );
			wp_send_json_success();
		}	 
	 
	 function dismiss_rate_notice_way2enjoy() {
			$timestampp=time()+rand(2002000,2592000);
			update_site_option( 'rate_way2enjoy', $timestampp );
			wp_send_json_success();
		}	 
	 
	function way2enjoy_media_library_ajax_callback_new() {
			$image_id = (int) $_POST['id'];
			$type = false;
$setting_txt85 = __( 'There is a problem with your credentials. Please check them in the Way2enjoy.com settings section of Media Settings, and try again.', 'way2enjoy-compress-images' );	
$setting_txt86 = __( 'Could not overwrite original file. Please ensure that your files are writable by plugins.' );	
		$setting_txt99 = __( 'Buy', 'way2enjoy-compress-images' );
		$setting_txt151 = __( "Quota exceeded.Please", "way2enjoy-compress-images" );	

		
		
	//	$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;

$data['error']='';
$api_result['message']='';
			if ( isset( $_POST['type'] ) ) {
				$type = $_POST['type'];
				$this->optimization_type = $type;
			}

			$this->id = $image_id;

$status_optimisation=time().'-'.@$image_id;		
update_site_option( 'way2-in-progress', $status_optimisation );


//$factor_img=$image_id%4;

//			if ( wp_attachment_is_image( $image_id ) ) {

				$settings = $this->way2enjoy_settings;
			


				$image_path = get_attached_file( $image_id );
		
				$optimize_main_image = !empty( $settings['optimize_main_image'] );
				$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
				$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';

				$data = array();

				if ( empty( $api_key ) && empty( $api_secret ) ) {
					$data['error'] = $setting_txt85;
					update_post_meta( $image_id, '_way2enjoy_size', $data );
					echo json_encode( array( 'error' => $data['error'] ) );

					
					exit;
				}

				if ( $optimize_main_image ) {

					// check if thumbs already optimized
					$thumbs_optimized = false;
					$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );
					
					if ( !empty ( $way2enjoyed_thumbs_data ) ) {
						$thumbs_optimized = true;
					}

					// get metadata for thumbnails
					$image_data = wp_get_attachment_metadata( $image_id );

					if ( !$thumbs_optimized ) {
						$this->optimize_thumbnails( $image_data );
					} else {

						// re-optimize thumbs if mode has changed
						$way2enjoyed_thumbs_mode = $way2enjoyed_thumbs_data[0]['type'];						
						if ( strcmp( $way2enjoyed_thumbs_mode, $this->optimization_type ) !== 0 ) {
							wp_generate_attachment_metadata( $image_id, $image_path );
							$this->optimize_thumbnails( $image_data );
						}
					}

					$resize = false;
					if ( !empty( $settings['resize_width'] ) || !empty( $settings['resize_height'] ) ) {
						$resize = true;
					}

					$api_result = $this->optimize_image( $image_path, $type, $resize );

					if ( !empty( $api_result ) && !empty( $api_result['success'] ) ) {
						$data = $this->get_result_arr( $api_result, $image_id );
					if($settings['webp_yes']=='1')
{	
$web_url = $api_result['webp_url'];
$this->webp_image( $image_path, $web_url ) ;
}
						if ( $this->replace_image( $image_path, $api_result['compressed_url'] ) ) {

							if ( !empty( $data['way2enjoyed_width'] ) && !empty( $data['way2enjoyed_height'] ) ) {
								$image_data = wp_get_attachment_metadata( $image_id );
								$image_data['width'] = $data['way2enjoyed_width'];
								$image_data['height'] = $data['way2enjoyed_height'];
								wp_update_attachment_metadata( $image_id, $image_data );
															
							}

							// store way2enjoyed info to DB
							update_post_meta( $image_id, '_way2enjoy_size', $data );


$savedetailuu = get_site_option( 'way2enjoy_global_stats' ) ;
$factor_img=$image_id%4;
$savedetailss = get_site_option( 'way2enjoy_global_stats'.$factor_img.'' ) ;

if($factor_img=='0')
{
		
	$way2enjoy_savingdata_new['size_before0'] = $data['original_size'] + $savedetailss['size_before0'];	
	$way2enjoy_savingdata_new['size_after0'] = $data['compressed_size'] + $savedetailss['size_after0'];		
	$way2enjoy_savingdata_new['total_images0'] = $savedetailss['total_images0']+1;	
}
elseif($factor_img=='1')
{
	

	$way2enjoy_savingdata_new['size_before1'] = $data['original_size'] + $savedetailss['size_before1'];	
	$way2enjoy_savingdata_new['size_after1'] = $data['compressed_size'] + $savedetailss['size_after1'];		
	$way2enjoy_savingdata_new['total_images1'] = $savedetailss['total_images1']+1;		
}
	elseif($factor_img=='2')
{
	

	$way2enjoy_savingdata_new['size_before2'] = $data['original_size'] + $savedetailss['size_before2'];	
	$way2enjoy_savingdata_new['size_after2'] = $data['compressed_size'] + $savedetailss['size_after2'];		
	$way2enjoy_savingdata_new['total_images2'] = $savedetailss['total_images2']+1;		
}			
	
	elseif($factor_img=='3')
{
		
	$way2enjoy_savingdata_new['size_before3'] = $data['original_size'] + $savedetailss['size_before3'];	
	$way2enjoy_savingdata_new['size_after3'] = $data['compressed_size'] + $savedetailss['size_after3'];		
	$way2enjoy_savingdata_new['total_images3'] = $savedetailss['total_images3']+1;		
}		
	else
	{
	$way2enjoy_savingdata['size_before'] = $data['original_size'] + $savedetailss['size_before'];	
	$way2enjoy_savingdata['size_after'] = $data['compressed_size'] + $savedetailss['size_after'];		
	$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;			
	}
	
	
//$randshow=rand(1,15);
//if($randshow=='10')
//{
//$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
////		$statusuu = $this->get_api_status( $api_key, $api_secret );
//$way2enjoy_savingdata['quota_remaining']=$statusuu['quota_remaining'];


$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];
//disabled on 10june as buy button was not displaying after quota exceeded//$way2enjoy_savingdata['quota_remaining']=$data['quota_remaining'];

//$way2enjoy_savingdata['pro_not']=$statusuu['plan_name'];
$way2enjoy_savingdata['pro_not'] = $savedetailuu['pro_not'];
//}
//	$remainnn=$savedetailss['quota_remaining'] ;

//$way2enjoy_savingdata['quota_remaining']=$data['quota_remaining'];

//$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];


						    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );		

						    update_site_option( 'way2enjoy_global_stats'.$factor_img.'', $way2enjoy_savingdata_new );		

	// testing ends here



							// enjoyed thumbnails, store that data too. This can be unset when there are no thumbs
							$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );
							if ( !empty( $way2enjoyed_thumbs_data ) ) {
								$data['thumbs_data'] = $way2enjoyed_thumbs_data;
								$data['success'] = true;
							}

							$data['html'] = $this->generate_stats_summary( $image_id );
							echo json_encode( $data );
						
						} else {
							echo json_encode( array( 'error' => ''.$setting_txt86.'' ) );
							exit;
						}	

					} else {
						// error or no optimization
						if ( file_exists( $image_path ) ) {
							update_post_meta( $image_id, '_way2enjoy_size', $data );
						} else {
							// file not found
						}
//						if($savedetailss['quota_remaining']>='0')
						if($savedetailuu['quota_remaining']>'0')
						{
						echo json_encode( array( 'error' => $api_result['message'], '' ) );
						
						}
						else
						{
								$data['html'] ='{"success":true,"html":"'.$setting_txt151.' <a href=\'https://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'\' target=\'_blank\'>'.$setting_txt99.'</a>"}';
								
if(is_numeric( $data['original_size']))
{
	echo json_encode( array( 'error' => $api_result['message'], '' ) );
	}
else
{
echo	$data['html'];
	}
						}
				
					}
				} else {
					// get metadata for thumbnails
					$image_data = wp_get_attachment_metadata( $image_id );
					$this->optimize_thumbnails( $image_data );

					// enjoyed thumbnails, store that data too. This can be unset when there are no thumbs
					$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );

					if ( !empty( $way2enjoyed_thumbs_data ) ) {
						$data['thumbs_data'] = $way2enjoyed_thumbs_data;
						$data['success'] = true;
					}
					$data['html'] = $this->generate_stats_summary( $image_id );

					echo json_encode( $data );
				
					
				}
		//	}
			wp_die();
		}



function way2enjoy_media_library_ajax_callback() {
			$image_id = (int) $_POST['id'];
			$type = false;
$setting_txt85 = __( 'There is a problem with your credentials. Please check them in the Way2enjoy.com settings section of Media Settings, and try again.', 'way2enjoy-compress-images' );	
$setting_txt86 = __( 'Could not overwrite original file. Please ensure that your files are writable by plugins.' );	
		$setting_txt99 = __( 'Buy', 'way2enjoy-compress-images' );
		$setting_txt151 = __( "Quota exceeded.Please", "way2enjoy-compress-images" );	

		
		
	//	$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;

$data['error']='';
$api_result['message']='';
			if ( isset( $_POST['type'] ) ) {
				$type = $_POST['type'];
				$this->optimization_type = $type;
			}

			$this->id = $image_id;

//$factor_img=$image_id%4;

//			if ( wp_attachment_is_image( $image_id ) ) {

				$settings = $this->way2enjoy_settings;
			


				$image_path = get_attached_file( $image_id );
		
				$optimize_main_image = !empty( $settings['optimize_main_image'] );
				$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
				$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';

				$data = array();

				if ( empty( $api_key ) && empty( $api_secret ) ) {
					$data['error'] = $setting_txt85;
					update_post_meta( $image_id, '_way2enjoy_size', $data );
					echo json_encode( array( 'error' => $data['error'] ) );

					
					exit;
				}

				if ( $optimize_main_image ) {

					// check if thumbs already optimized
					$thumbs_optimized = false;
					$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );
					
					if ( !empty ( $way2enjoyed_thumbs_data ) ) {
						$thumbs_optimized = true;
					}

					// get metadata for thumbnails
					$image_data = wp_get_attachment_metadata( $image_id );

					if ( !$thumbs_optimized ) {
						$this->optimize_thumbnails( $image_data );
					} else {

						// re-optimize thumbs if mode has changed
						$way2enjoyed_thumbs_mode = $way2enjoyed_thumbs_data[0]['type'];						
						if ( strcmp( $way2enjoyed_thumbs_mode, $this->optimization_type ) !== 0 ) {
							wp_generate_attachment_metadata( $image_id, $image_path );
							$this->optimize_thumbnails( $image_data );
						}
					}

					$resize = false;
					if ( !empty( $settings['resize_width'] ) || !empty( $settings['resize_height'] ) ) {
						$resize = true;
					}

					$api_result = $this->optimize_image( $image_path, $type, $resize );

					if ( !empty( $api_result ) && !empty( $api_result['success'] ) ) {
						$data = $this->get_result_arr( $api_result, $image_id );
					if($settings['webp_yes']=='1')
{	
$web_url = $api_result['webp_url'];
$this->webp_image( $image_path, $web_url ) ;
}
						if ( $this->replace_image( $image_path, $api_result['compressed_url'] ) ) {

							if ( !empty( $data['way2enjoyed_width'] ) && !empty( $data['way2enjoyed_height'] ) ) {
								$image_data = wp_get_attachment_metadata( $image_id );
								$image_data['width'] = $data['way2enjoyed_width'];
								$image_data['height'] = $data['way2enjoyed_height'];
								wp_update_attachment_metadata( $image_id, $image_data );
															
							}

							// store way2enjoyed info to DB
							update_post_meta( $image_id, '_way2enjoy_size', $data );


$savedetailuu = get_site_option( 'way2enjoy_global_stats' ) ;
$factor_img=$image_id%4;
$savedetailss = get_site_option( 'way2enjoy_global_stats'.$factor_img.'' ) ;

if($factor_img=='0')
{
		
	$way2enjoy_savingdata_new['size_before0'] = $data['original_size'] + $savedetailss['size_before0'];	
	$way2enjoy_savingdata_new['size_after0'] = $data['compressed_size'] + $savedetailss['size_after0'];		
	$way2enjoy_savingdata_new['total_images0'] = $savedetailss['total_images0']+1;	
}
elseif($factor_img=='1')
{
	

	$way2enjoy_savingdata_new['size_before1'] = $data['original_size'] + $savedetailss['size_before1'];	
	$way2enjoy_savingdata_new['size_after1'] = $data['compressed_size'] + $savedetailss['size_after1'];		
	$way2enjoy_savingdata_new['total_images1'] = $savedetailss['total_images1']+1;		
}
	elseif($factor_img=='2')
{
	

	$way2enjoy_savingdata_new['size_before2'] = $data['original_size'] + $savedetailss['size_before2'];	
	$way2enjoy_savingdata_new['size_after2'] = $data['compressed_size'] + $savedetailss['size_after2'];		
	$way2enjoy_savingdata_new['total_images2'] = $savedetailss['total_images2']+1;		
}			
	
	elseif($factor_img=='3')
{
		
	$way2enjoy_savingdata_new['size_before3'] = $data['original_size'] + $savedetailss['size_before3'];	
	$way2enjoy_savingdata_new['size_after3'] = $data['compressed_size'] + $savedetailss['size_after3'];		
	$way2enjoy_savingdata_new['total_images3'] = $savedetailss['total_images3']+1;		
}		
	else
	{
	$way2enjoy_savingdata['size_before'] = $data['original_size'] + $savedetailss['size_before'];	
	$way2enjoy_savingdata['size_after'] = $data['compressed_size'] + $savedetailss['size_after'];		
	$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;			
	}
	
	
//$randshow=rand(1,15);
//if($randshow=='10')
//{
//$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
////		$statusuu = $this->get_api_status( $api_key, $api_secret );
//$way2enjoy_savingdata['quota_remaining']=$statusuu['quota_remaining'];


$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];
//disabled on 10june as buy button was not displaying after quota exceeded//$way2enjoy_savingdata['quota_remaining']=$data['quota_remaining'];

//$way2enjoy_savingdata['pro_not']=$statusuu['plan_name'];
$way2enjoy_savingdata['pro_not'] = $savedetailuu['pro_not'];
//}
//	$remainnn=$savedetailss['quota_remaining'] ;

//$way2enjoy_savingdata['quota_remaining']=$data['quota_remaining'];

//$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];


						    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );		

						    update_site_option( 'way2enjoy_global_stats'.$factor_img.'', $way2enjoy_savingdata_new );		

	// testing ends here



							// enjoyed thumbnails, store that data too. This can be unset when there are no thumbs
							$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );
							if ( !empty( $way2enjoyed_thumbs_data ) ) {
								$data['thumbs_data'] = $way2enjoyed_thumbs_data;
								$data['success'] = true;
							}

							$data['html'] = $this->generate_stats_summary( $image_id );
							echo json_encode( $data );
						
						} else {
							echo json_encode( array( 'error' => ''.$setting_txt86.'' ) );
							exit;
						}	

					} else {
						// error or no optimization
						if ( file_exists( $image_path ) ) {
							update_post_meta( $image_id, '_way2enjoy_size', $data );
						} else {
							// file not found
						}
//						if($savedetailss['quota_remaining']>='0')
						if($savedetailuu['quota_remaining']>'0')
						{
						echo json_encode( array( 'error' => $api_result['message'], '' ) );
						
						}
						else
						{
								$data['html'] ='{"success":true,"html":"'.$setting_txt151.' <a href=\'https://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'\' target=\'_blank\'>'.$setting_txt99.'</a>"}';
								
if(is_numeric( $data['original_size']))
{
	echo json_encode( array( 'error' => $api_result['message'], '' ) );
	}
else
{
echo	$data['html'];
	}
						}
				
					}
				} else {
					// get metadata for thumbnails
					$image_data = wp_get_attachment_metadata( $image_id );
					$this->optimize_thumbnails( $image_data );

					// enjoyed thumbnails, store that data too. This can be unset when there are no thumbs
					$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );

					if ( !empty( $way2enjoyed_thumbs_data ) ) {
						$data['thumbs_data'] = $way2enjoyed_thumbs_data;
						$data['success'] = true;
					}
					$data['html'] = $this->generate_stats_summary( $image_id );

					echo json_encode( $data );
				
					
				}
		//	}
			wp_die();
		}






function way2enjoy_media_library_ajax_callback77() {
			$image_id = (int) $_POST['id'];
			
			
			$type = false;
$setting_txt85 = __( 'There is a problem with your credentials. Please check them in the Way2enjoy.com settings section of Media Settings, and try again.', 'way2enjoy-compress-images' );	
$setting_txt86 = __( 'Could not overwrite original file. Please ensure that your files are writable by plugins.' );	

$data['error']='';
$api_result['message']='';
//$api_result['compressed_size']='';
//$api_result['original_size']='';
//$finallsize='';
//$origgsize='';
//$total_compressed_size_final='';

			if ( isset( $_POST['type'] ) ) {
				$type = $_POST['type'];
//				$this->optimization_type = $type;
				$this->optimization_type = $type;

			}

			$this->id = $image_id;

//			if ( wp_attachment_is_image( $image_id ) ) {

				$settings = $this->way2enjoy_settings;
	
//	$GLOBALS['wp_object_cache']->delete( 'way2enjoy_global_stats', 'options' );
			
	

//				$image_path = get_attached_file( $image_id );
				$image_path = get_directory_image_path( $image_id );
//echo $image_path;
				$optimize_main_image = !empty( $settings['optimize_main_image'] );
				$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
				$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';

				$data = array();

				//if ( empty( $api_key ) && empty( $api_secret ) ) {
//					$data['error'] = $setting_txt85;
//					update_post_meta( $image_id, '_way2enjoy_size', $data );
//					echo json_encode( array( 'error' => $data['error'] ) );
//
//					
//					exit;
//				}

	//		if ( $optimize_main_image ) {
//
//					// check if thumbs already optimized
//					$thumbs_optimized = false;
//					$way2enjoyed_thumbs_data = get_post_meta( $image_id, '_way2enjoyed_thumbs', true );
//					
//					if ( !empty ( $way2enjoyed_thumbs_data ) ) {
//						$thumbs_optimized = true;
//					}
//
//					// get metadata for thumbnails
//					$image_data = wp_get_attachment_metadata( $image_id );
//
//					if ( !$thumbs_optimized ) {
//						$this->optimize_thumbnails( $image_data );
//					} else {
//
//						// re-optimize thumbs if mode has changed
//						$way2enjoyed_thumbs_mode = $way2enjoyed_thumbs_data[0]['type'];						
//						if ( strcmp( $way2enjoyed_thumbs_mode, $this->optimization_type ) !== 0 ) {
//							wp_generate_attachment_metadata( $image_id, $image_path );
//							$this->optimize_thumbnails( $image_data );
//						}
//					}

					$resize = false;
					if ( !empty( $settings['resize_width'] ) || !empty( $settings['resize_height'] ) ) {
					$resize = true;
					}

$api_result = $this->optimize_image_dir( $image_path, $type, $resize );
	if($settings['webp_yes']=='1')
{		
$web_url = $api_result['webp_url'];
$this->webp_image( $image_path, $web_url ) ;		
}
			if ( $this->replace_image( $image_path, $api_result['compressed_url'] ) ) {

													$data = $this->generate_stats_summary_dir( $image_id );


}

$datainaraaya=json_decode($data,true);


$finallsize =$datainaraaya['compressed_size'];
$origgsize =$datainaraaya['original_size'];

$total_compressed_size_final =$finallsize  < $origgsize ? $finallsize : $origgsize;

//if(!empty($api_result['quota_remaining']))
//{
//$balance_quota=$api_result['quota_remaining'];	
//}
//else
//{
//	$balance_quota='-10';	
//
//}
//
//$way2enjoy_savingdata['quota_remaining']=$balance_quota;



$savedetailuu = get_site_option( 'way2enjoy_global_stats' ) ;
$factor_img=$image_id%4;
$savedetailss = get_site_option( 'way2enjoy_global_stats'.$factor_img.'' ) ;

if($factor_img=='0')
{
		
	$way2enjoy_savingdata_new['size_before0'] = $origgsize + $savedetailss['size_before0'];	
	$way2enjoy_savingdata_new['size_after0'] = $total_compressed_size_final + $savedetailss['size_after0'];		
	$way2enjoy_savingdata_new['total_images0'] = $savedetailss['total_images0']+1;	
}
elseif($factor_img=='1')
{
	

	$way2enjoy_savingdata_new['size_before1'] = $origgsize + $savedetailss['size_before1'];	
	$way2enjoy_savingdata_new['size_after1'] = $total_compressed_size_final + $savedetailss['size_after1'];		
	$way2enjoy_savingdata_new['total_images1'] = $savedetailss['total_images1']+1;		
}
	elseif($factor_img=='2')
{
	

	$way2enjoy_savingdata_new['size_before2'] = $origgsize + $savedetailss['size_before2'];	
	$way2enjoy_savingdata_new['size_after2'] = $total_compressed_size_final + $savedetailss['size_after2'];		
	$way2enjoy_savingdata_new['total_images2'] = $savedetailss['total_images2']+1;		
}			
	
	elseif($factor_img=='3')
{
		
	$way2enjoy_savingdata_new['size_before3'] = $origgsize + $savedetailss['size_before3'];	
	$way2enjoy_savingdata_new['size_after3'] = $total_compressed_size_final + $savedetailss['size_after3'];		
	$way2enjoy_savingdata_new['total_images3'] = $savedetailss['total_images3']+1;		
}		
	else
	{
	$way2enjoy_savingdata['size_before'] = $origgsize + $savedetailss['size_before'];	
	$way2enjoy_savingdata['size_after'] = $total_compressed_size_final + $savedetailss['size_after'];		
	$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;			
	}
	
	
//$randshow=rand(1,15);
//if($randshow=='10')
//{
//$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
////		$statusuu = $this->get_api_status( $api_key, $api_secret );
//$way2enjoy_savingdata['quota_remaining']=$statusuu['quota_remaining'];
//$way2enjoy_savingdata['quota_remaining']=$datainaraaya['quota_remaining']; // it was causing quota exceeded buy now option to hide 

$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];

//$way2enjoy_savingdata['pro_not']=$statusuu['plan_name'];
$way2enjoy_savingdata['pro_not'] = $savedetailuu['pro_not'];



						    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );		

						    update_site_option( 'way2enjoy_global_stats'.$factor_img.'', $way2enjoy_savingdata_new );		


echo $data;
	

			wp_die();
		}
	


		
		function is_successful( $response ) {}

		/**
		 *  Handles optimizing images uploaded through any of the media uploaders.
		 */
		function way2enjoy_media_uploader_callback( $image_id ) {
$setting_txt87 = __( 'Way2enjoy.com: Could not replace local image with optimized image.', 'way2enjoy-compress-images' );	
			$this->id = $image_id;

//$factor_img=$image_id%4;

			if ( empty( $this->way2enjoy_settings['optimize_main_image'] ) ) {
				return;
			}
	
	
			$settings = $this->way2enjoy_settings;
		//	$type = $settings['api_lossy'];
	$type = isset( $settings['api_lossy'] ) ? $settings['api_lossy'] : 'lossy';
			

			if ( !$this->isApiActive() ) {
				remove_filter( 'wp_generate_attachment_metadata', array( &$this, 'optimize_thumbnails') );
				remove_action( 'add_attachment', array( &$this, 'way2enjoy_media_uploader_callback' ) );
				return;
			}
			

//			if ( wp_attachment_is_image( $image_id ) ) {


	///// trying this
				
//$image_urlpppp = wp_get_attachment_url( $image_id );

				///// trying this ends


				$image_path = get_attached_file( $image_id );
				if ( wp_attachment_is_image( $image_id ) ) {
		@$image_backup_path = $image_path . '_way2enjoy_' . md5( $image_path );
				}
			
				$backup_created = false;

				if ( @copy( $image_path, $image_backup_path ) ) {
					$backup_created = true;
				}

$resize = true;
				//$resize = false;
//				if ( !empty( $settings['resize_width'] ) || !empty( $settings['resize_height'] ) ) {
//					$resize = true;
//				}

				// optimize backup image
				if ( $backup_created ) {
					$api_result = $this->optimize_image( $image_backup_path, $type, $resize );
				} else {
					$api_result = $this->optimize_image( $image_path, $type, $resize );
				}				

				$data = array();

				if ( !empty( $api_result ) && !empty( $api_result['success'] ) ) {
					$data = $this->get_result_arr( $api_result, $image_id );
			if(@$settings['webp_yes']=='1')
{
$web_url = $api_result['webp_url'];
$this->webp_image( $image_path, $web_url ) ;
}
					if ( $backup_created ) {
						$data['optimized_backup_file'] = $image_backup_path;

						
						if ( $data['saved_bytes'] > 0 ) {
							if ( $this->replace_image( $image_backup_path, $api_result['compressed_url'] ) ) {
							} else {
								error_log($setting_txt87);
							}						
						}						
					} else {
						if ( $data['saved_bytes'] > 0 ) {
							if ( $this->replace_image( $image_path, $api_result['compressed_url'] ) ) {
							} else {
								error_log($setting_txt87);
							}						
						}
					}
					update_post_meta( $image_id, '_way2enjoy_size', $data );


$factor_img=$image_id%4;

$savedetailuu = get_site_option( 'way2enjoy_global_stats' ) ;


$savedetailss = get_site_option( 'way2enjoy_global_stats'.$factor_img.'' ) ;

if($factor_img=='0')
{
	$way2enjoy_savingdata_new['size_before0'] = $data['original_size'] + $savedetailss['size_before0'];	
	$way2enjoy_savingdata_new['size_after0'] = $data['compressed_size'] + $savedetailss['size_after0'];		
	$way2enjoy_savingdata_new['total_images0'] = $savedetailss['total_images0']+1;	
}
elseif($factor_img=='1')
{
	
	$way2enjoy_savingdata_new['size_before1'] = $data['original_size'] + $savedetailss['size_before1'];	
	$way2enjoy_savingdata_new['size_after1'] = $data['compressed_size'] + $savedetailss['size_after1'];		
	$way2enjoy_savingdata_new['total_images1'] = $savedetailss['total_images1']+1;		
}
	elseif($factor_img=='2')
{
	
	
	$way2enjoy_savingdata_new['size_before2'] = $data['original_size'] + $savedetailss['size_before2'];	
	$way2enjoy_savingdata_new['size_after2'] = $data['compressed_size'] + $savedetailss['size_after2'];		
	$way2enjoy_savingdata_new['total_images2'] = $savedetailss['total_images2']+1;		
}			
	
	elseif($factor_img=='3')
{
	
	$way2enjoy_savingdata_new['size_before3'] = $data['original_size'] + $savedetailss['size_before3'];	
	$way2enjoy_savingdata_new['size_after3'] = $data['compressed_size'] + $savedetailss['size_after3'];		
	$way2enjoy_savingdata_new['total_images3'] = $savedetailss['total_images3']+1;		
}		
	else
	{
		
		$way2enjoy_savingdata['size_before'] = $data['original_size'] + $savedetailss['size_before'];	
	$way2enjoy_savingdata['size_after'] = $data['compressed_size'] + $savedetailss['size_after'];		
	$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;			
	}

			
//$randshow=rand(1,15);
//if($randshow=='10')
//{
//$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
	//	$statusuu = $this->get_api_status( $api_key, $api_secret );
//$way2enjoy_savingdata['quota_remaining']=$statusuu['quota_remaining'];
$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];

//$way2enjoy_savingdata['pro_not'] = $statusuu['pro_not'];
$way2enjoy_savingdata['pro_not'] = $savedetailuu['pro_not'];

//$way2enjoy_savingdata['quota_remaining']=$data['quota_remaining'];
//$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];

//$way2enjoy_savingdata['quota_remaining']=$api_result['quota_remaining'];
//if(!empty($api_result['quota_remaining']))
//{
//$balance_quota=$api_result['quota_remaining'];	
//}
//else
//{
//	$balance_quota='-10';	
//
//}
//
//$way2enjoy_savingdata['quota_remaining']=$balance_quota;

//}
//	$remainnn=$savedetailss['quota_remaining'] ;

				    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );		
						    update_site_option( 'way2enjoy_global_stats'.$factor_img.'', $way2enjoy_savingdata_new );		

	// testing ends here


				} else {
					// error or no optimization
					if ( file_exists( $image_path ) ) {
$api_result['message']='';

						$data['original_size'] = filesize( $image_path );
						$data['error'] = $api_result['message'];
						$data['type'] = $api_result['type'];
						update_post_meta( $image_id, '_way2enjoy_size', $data );

					} else {
						// file not found
					}
				}
			//}
		}
	function container_header( $classes = '', $id = '', $heading = '', $sub_heading = '', $dismissible = false ) {
			if ( empty( $heading ) ) {
				return '';
			}
			$setting_txt66 = __( 'Dismiss Welcome notice', 'way2enjoy-compress-images' );	
			
			echo '<section class="dev-box ' . $classes . ' wp-way2enjoy-container" id="' . $id . '">'; ?>
			<div class="wp-way2enjoy-container-header box-title" xmlns="http://www.w3.org/1999/xhtml">
			<h3><?php echo $heading ?></h3><?php
			//Sub Heading
			if ( ! empty( $sub_heading ) ) { ?>
				<div class="way2enjoy-container-subheading roboto-medium"><?php echo $sub_heading ?></div><?php
			}
			//Dismissible
			if ( $dismissible ) { ?>
				<div class="float-r way2enjoy-dismiss-welcome">
				<a href="#" title="<?php esc_html_e( $setting_txt66, "wp-way2enjoyit" ); ?>">
					<!--<i class="wdv-icon wdv-icon-fw wdv-icon-remove"></i>-->
				</a>
				</div><?php
			} ?>
			</div><?php
		}


function welcome_screen_way2enjoy() {
$plugin_name = "Way2enjoy Image";
$setting_txt67 = __( 'WELCOME', 'way2enjoy-compress-images' );	
$setting_txt68 = __( 'OH YEAH, IT\'S COMPRESSION TIME!', 'way2enjoy-compress-images' );	
$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );
$way2esites=$statusuu['sites'] > 0 ? $statusuu['sites']: "0";
$warning="";
$execu_time=ini_get('max_execution_time');
if($execu_time <'300')
{
$mess_execution=' Your max_execution_time is '.$execu_time.' seconds which may kill big image optimization. Please add/edit wp-config.php. Backup first. <a href="https://stackoverflow.com/questions/16171132/how-to-increase-maximum-execution-time-in-php" target="_blank">here</a>.';	
}
if($way2esites >='4')
{
$warning='<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php' ) . '"><b>'.get_bloginfo('admin_email').'</b></a>';	
}



			//Header Of the Box
			$this->container_header( 'wp-way2enjoy-welcome', 'wp-way2enjoy-welcome-box', __( $setting_txt67.' '.$warning.$mess_execution, "wp-way2enjoyit" ), '', true );
			
;
			?>
			<!-- Content -->
				<div class="wp-way2enjoy-welcome-content">
					<h4 class="roboto-condensed-regular"><?php esc_html_e( $setting_txt68, "wp-way2enjoyit" ); ?></h4>
					<p class="wp-way2enjoy-welcome-message roboto-medium"><?php  printf( esc_html__( 'You\'ve just installed %3$s, the most powerful image compression plugin! change settings anytime.All uploaded images will be automatically compressed.Nothing required from your part!', 'way2enjoy-compress-images' ), '<strong>', '</strong>', $plugin_name ); ?></p>
				</div>
			<?php
			echo "</section>";
		}


		function way2enjoy_media_library_reset() {
			$image_id = (int) $_POST['id'];
			$image_meta = get_post_meta( $image_id, '_way2enjoy_size', true );
			$original_size = self::formatBytes( filesize( get_attached_file( $image_id ) ) );
			delete_post_meta( $image_id, '_way2enjoy_size' );
			delete_post_meta( $image_id, '_way2enjoyed_thumbs' );			
			echo json_encode( array( 'success' => true, 'original_size' => $original_size, 'html' => $this->optimize_button_html( $image_id ) ) );
			wp_die();
 		}

		function way2enjoy_media_library_reset_all() {
			$result = null;
			delete_post_meta_by_key( '_way2enjoyed_thumbs' );
			delete_post_meta_by_key( '_way2enjoy_size' );
			$result = json_encode( array( 'success' => true ) );
			echo $result;
			wp_die();
 		}
		
		function optimize_button_html( $id )  {
			$image_url = wp_get_attachment_url( $id );
			$filename = basename( $image_url );

$html = <<<EOD
	<div class="buttonWrap">
		<button type="button" 
				data-setting="$this->optimization_type" 
				class="way2enjoy_req" 
				data-id="$id" 
				id="way2enjoyid-$id" 
				data-filename="$filename" 
				data-url="<$image_url">
			Optimize This Image
		</button>
		<small class="way2enjoyOptimizationType" style="display:none">$this->optimization_type</small>
		<span class="way2enjoySpinner"></span>
	</div>
EOD;

			return $html;
		}


		function show_credentials_validity() {
$setting_txt79 = __( 'There is a problem with your credentials', 'way2enjoy-compress-images' );	
			$setting_txt78 = __( 'Your credentials are valid', 'way2enjoy-compress-images' );	

			$settings = $this->way2enjoy_settings;
			$api_key = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
			$api_secret = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';

			$status = $this->get_api_status( $api_key, $api_secret );
			$url = admin_url() . 'images/';

			if ( $status !== false && isset( $status['active'] ) && $status['active'] === true ) {
				$url .= 'yes.png';
				echo '<p class="apiStatus">'.$setting_txt78.' <span class="apiValid" style="background:url(' . "'$url') no-repeat 0 0" . '"></span></p>';
			} else {
				$url .= 'no.png';
				echo '<p class="apiStatus">'.$setting_txt79.' <span class="apiInvalid" style="background:url(' . "'$url') no-repeat 0 0" . '"></span></p>';
			}
		}

		function show_way2enjoy_image_optimizer() {
			
					$setting_txt76 = __( 'Visit Way2enjoy.com Compress Images', 'way2enjoy-compress-images' );	
					$setting_txt77 = __( 'API settings', 'way2enjoy-compress-images' );	

			echo '<a href="https://way2enjoy.com/compress-png" title="'.$setting_txt76.'">Way2enjoy</a> '.$setting_txt77.'';
		}

		function show_api_key() {
			$settings = $this->way2enjoy_settings;
			$value = isset( $settings['api_key'] ) ? $settings['api_key'] : '';
			?>
				<input id='way2enjoy_api_key' name='_way2enjoy_options[api_key]'
				 type='text' value='<?php echo esc_attr( $value ); ?>' />
			<?php
		}

		function show_api_secret() {
			$settings = $this->way2enjoy_settings;
			$value = isset( $settings['api_secret'] ) ? $settings['api_secret'] : '';
			?>
				<input id='way2enjoy_api_secret' name='_way2enjoy_options[api_secret]'
				 type='text' value='<?php echo esc_attr( $value ); ?>' />
			<?php
		}

		function show_lossy() {
			$setting_txt23 = __( 'Way2enjoy Lossy', 'way2enjoy-compress-images' );
			$setting_txt24 = __( 'Lossless', 'way2enjoy-compress-images' );
			
			$options = get_site_option( '_way2enjoy_options' );
			$value = isset( $options['api_lossy'] ) ? $options['api_lossy'] : 'lossy';

			$html = '<input type="radio" id="way2enjoy_lossy" name="_way2enjoy_options[api_lossy]" value="lossy"' . checked( 'lossy', $value, false ) . '/>';
			$html .= '<label for="way2enjoy_lossy">'.$setting_txt23.'</label>';

			$html .= '<input style="margin-left:10px;" type="radio" id="way2enjoy_lossless" name="_way2enjoy_options[api_lossy]" value="lossless"' . checked( 'lossless', $value, false ) . '/>';
			$html .= '<label for="way2enjoy_lossless">'.$setting_txt24.'</label>';

			echo $html;
		}

		function show_auto_optimize() {
			$options = get_site_option( '_way2enjoy_options' );
			$auto_optimize = isset( $options['auto_optimize'] ) ? $options['auto_optimize'] : 1;
			?>
			<input type="checkbox" id="auto_optimize" name="_way2enjoy_options[auto_optimize]" value="1" <?php checked( 1, $auto_optimize, true ); ?>/>
			<?php
		}

		function show_reset_field() {
			$setting_txt45 = __( 'Reset All Images', 'way2enjoy-compress-images' );
			$options = get_site_option( '_way2enjoy_options' );
			$show_reset = isset( $options['show_reset'] ) ? $options['show_reset'] : 0;
			?>
			<input type="checkbox" id="show_reset" name="_way2enjoy_options[show_reset]" value="1" <?php checked( 1, $show_reset, true ); ?>/>
			<span class="way2enjoy-reset-all enabled"><?php echo $setting_txt45; ?></span>
			<?php
		}

		function show_bulk_async_limit() {
			$options = get_site_option( '_way2enjoy_options' );
			$bulk_limit = isset( $options['bulk_async_limit'] ) ? $options['bulk_async_limit'] : 3;
			?>
			<select name="_way2enjoy_options[bulk_async_limit]">
				<?php foreach ( range(1, 4) as $number ) { ?>
					<option value="<?php echo $number ?>" <?php selected( $bulk_limit, $number, true); ?>>
						<?php echo $number ?>
					</option>
				<?php } ?>
			</select>
			<?php
		}

		function add_media_columns( $columns ) {
			$setting_txt60 = __( 'Way2enjoy Stats', 'way2enjoy-compress-images' );	
			$setting_txt59 = __( 'Original Size', 'way2enjoy-compress-images' );
			$columns['original_size'] = $setting_txt59;
			$columns['compressed_size'] = $setting_txt60;
			return $columns;
		}


		static function KBStringToBytes( $str ) {
			$temp = floatVal( $str );
			$rv = false;
			if ( 0 == $temp ) {
				$rv = '0 bytes';
			} else {
				$rv = self::formatBytes( ceil( floatval( $str) * 1024 ) );
			}
			return $rv;
		}


		static function calculate_savings( $meta ) {
//$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;

			if ( isset( $meta['original_size'] ) ) {

				$saved_bytes = isset( $meta['saved_bytes'] ) ? $meta['saved_bytes'] : '';
				$savings_percentage = @$meta['savings_percent'];

				// convert old data format, where applicable
				if ( stripos( $saved_bytes, 'kb' ) !== false ) {
					$saved_bytes = self::KBStringToBytes( $saved_bytes );
				} else {
					if ( !$saved_bytes ) {
						$saved_bytes = '0 bytes';
					} else {
						$saved_bytes = self::formatBytes( $saved_bytes );
					}
				}

				return array( 
					'saved_bytes' => $saved_bytes,
					'savings_percentage' => $savings_percentage 
				);
			
			} else if ( !empty( $meta ) ) {
				$thumbs_count = count( $meta );
				$total_thumb_byte_savings = 0;
				$total_thumb_commp_size='';
				$total_thumb_size = 0;
				$thumbs_savings_percentage = '';
				$total_thumbs_savings = '';
//because 1 is main image + n no of thumbs
$countno=2;
				foreach ( $meta as $k => $v ) {
					$total_thumb_size += $v['original_size'];
					$thumb_byte_savings = $v['original_size'] - $v['compressed_size'];
					$total_thumb_byte_savings += $thumb_byte_savings;
					$total_thumb_commp_size += $v['compressed_size'];
$countno++;
				}

				$thumbs_savings_percentage = round( ( $total_thumb_byte_savings / $total_thumb_size * 100 ), 2 ) . '%';
				if ( $total_thumb_byte_savings ) {
					$total_thumbs_savings = self::formatBytes( $total_thumb_byte_savings );
				} else {
					$total_thumbs_savings = '0 bytes';
				}
				
			//			$totalsizeorig=$meta['original_size']+$total_thumb_size;
//			$totalsizecomp=$meta['compressed_size']+$total_thumb_commp_size;
//
//$way2enjoy_savingdata['size_before'] = $totalsizeorig + $savedetailss['size_before'];	
//$way2enjoy_savingdata['size_after'] = $totalsizecomp + $savedetailss['size_after'];		
//$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+$countno;
////
//////$way2enjoy_savingdata['quota_remaining']=$result['quota_remaining'];
//$way2enjoy_savingdata['quota_remaining']='777';
//		    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata );	
//			

				
				
				
				
				
				
				
				return array( 
					'savings_percentage' => $thumbs_savings_percentage,
					'total_savings' => $total_thumbs_savings 
				);
	
			
			
			
			
			}
		}

		function generate_stats_summary( $id ) {
			$image_meta = get_post_meta( $id, '_way2enjoy_size', true );
			$thumbs_meta = get_post_meta( $id, '_way2enjoyed_thumbs', true );

$setting_txt70 = __( 'Show details', 'way2enjoy-compress-images' );	
$setting_txt63 = __( 'No savings found or quota exceeded', 'way2enjoy-compress-images' );	
$setting_txt71 = __( 'Saved', 'way2enjoy-compress-images' );	
$setting_txt99 = __( 'Buy', 'way2enjoy-compress-images' );
$setting_txt4 = __( 'Balance', 'way2enjoy-compress-images' );
	
$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;
//$remainnn=$statusbuy['quota_remaining'] ;
$remainnn=$savedetailss['quota_remaining'] ;

$buynot='';

if($remainnn<='100' && $remainnn!='')

{
	$buynot = '<br /><a href="https://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'" target="_blank">'.$setting_txt99.'</a> <b>'.$remainnn.'</b> '.$setting_txt4.'';	
}


			$total_original_size = 0;
			$total_compressed_size = 0;
			$total_saved_bytes = 0;
			
			$total_savings_percentage = 0;

			// crap for backward compat
			if ( isset( $image_meta['original_size'] ) ) {

				$original_size = $image_meta['original_size'];

				if ( stripos( $original_size, 'kb' ) !== false ) {
					$total_original_size = ceil( floatval( $original_size ) * 1024 );
				} else {
					$total_original_size = (int) $original_size;
				}

				if ( isset( $image_meta['saved_bytes'] ) ) {
					$saved_bytes = $image_meta['saved_bytes'];
					if ( is_string( $saved_bytes ) ) {
						$total_saved_bytes = (int) ceil( floatval( $saved_bytes ) * 1024 );
					} else {
						$total_saved_bytes = $saved_bytes;
					}
				}

				$total_compressed_size = $total_original_size - $total_saved_bytes;
			} 

			if ( !empty( $thumbs_meta ) ) {
				$thumb_saved_bytes = 0;
				$total_thumb_byte_savings = 0;
				$total_thumb_size = 0;

				foreach ( $thumbs_meta as $k => $v ) {
					$total_original_size += $v['original_size'];
					$thumb_saved_bytes = $v['original_size'] - $v['compressed_size'];
					$total_saved_bytes += $thumb_saved_bytes;
				}

			}
			$total_savings_percentage = round( ( $total_saved_bytes / $total_original_size * 100 ), 2 ) . '%';
			$summary_string = '';
			
			if ( !$total_saved_bytes ) {
				
				$summary_string = $setting_txt63;
				
			} else {
				$total_savings = self::formatBytes( $total_saved_bytes );
				$detailed_results_html = $this->results_html( $id );
				$summary_string = '<div class="way2enjoy-result-wrap">' .$setting_txt71.' '.$total_savings_percentage.' ('.$total_savings.')'.$buynot.'';
				$summary_string .= '<br /><small class="way2enjoy-item-details" data-id="' . $id . '" title="' . htmlspecialchars($detailed_results_html) .'">'.$setting_txt70.'</small></div>';			
			}
			
			return $summary_string;
			
			
		}




		function generate_stats_summary_dir( $id ) {
			global $wpdb;
			$image_meta_d = get_directory_image_orig_size( $id );
		//	$thumbs_meta = get_post_meta( $id, '_way2enjoyed_thumbs', true );
		
						$image_path = get_directory_image_path( $id );


$setting_txt70 = __( 'Show details', 'way2enjoy-compress-images' );	
$setting_txt63 = __( 'No savings found or quota exceeded', 'way2enjoy-compress-images' );	
$setting_txt71 = __( 'Saved', 'way2enjoy-compress-images' );	
$setting_txt99 = __( 'Buy', 'way2enjoy-compress-images' );
$setting_txt4 = __( 'Balance', 'way2enjoy-compress-images' );
	
$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;
//$remainnn=$statusbuy['quota_remaining'] ;
$remainnn=$savedetailss['quota_remaining'] ;

$buynot='';

if($remainnn<='100' && $remainnn!='')

{
	$buynot = '<br /><a href="https://way2enjoy.com/compress-jpeg?pluginemail='.get_bloginfo('admin_email').'" target="_blank">'.$setting_txt99.'</a> <b>'.$remainnn.'</b> '.$setting_txt4.'';	
}


			$total_original_size = 0;
			$total_compressed_size = 0;
		//	$total_saved_bytes = 0;
			
		//	$total_savings_percentage = 0;

			// crap for backward compat
//			if ( isset( $image_meta['original_size'] ) ) {

				$original_size = $image_meta_d;

				if ( stripos( $original_size, 'kb' ) !== false ) {
					$total_original_size = ceil( floatval( $original_size ) * 1024 );
				} else {
					$total_original_size = (int) $original_size;
				}

				$total_compressed_size1 = filesize($image_path);
$total_compressed_size=$total_compressed_size1  < $total_original_size ? $total_compressed_size1 : $total_original_size;


			$total_saved_bytes = $total_original_size-$total_compressed_size;
			$total_savings = self::formatBytes( $total_saved_bytes );
			
//				}
//
//			}
$total_savings_percentage = round( ( $total_saved_bytes / $total_original_size * 100 ), 2 ) . '%';
			$summary_string = '';
	
$summary_string ='{"original_size":'.$total_original_size.',"compressed_size":'.$total_compressed_size.',"type":"lossy","success":true,"html":"'.$setting_txt71.' '.$total_savings_percentage.' ('.$total_savings.')"}'; 
			
$file_time = '1';
		$queryupd = "UPDATE {$wpdb->prefix}way2enjoy_dir_images SET image_size=%d, file_time=%d WHERE id=%d LIMIT 1";
			$queryupd = $wpdb->prepare( $queryupd, $total_compressed_size, $file_time, $id );
			$wpdb->query( $queryupd );	
			

			return $summary_string;
			
			
		}




		function results_html( $id ) {

			$settings = $this->way2enjoy_settings;
			$optimize_main_image = !empty( $settings['optimize_main_image'] ); 
		$setting_txt71 = __( 'Saved', 'way2enjoy-compress-images' );	
		$setting_txt72 = __( 'Reset', 'way2enjoy-compress-images' );	

		$setting_txt73 = __( 'Main image savings', 'way2enjoy-compress-images' );	
		$setting_txt74 = __( 'Savings on', 'way2enjoy-compress-images' );	
		$setting_txt75 = __( 'thumbnails', 'way2enjoy-compress-images' );	

			$setting_txt22 = __( 'Optimization mode', 'way2enjoy-compress-images' );


			// get meta data for main post and thumbs
			$image_meta = get_post_meta( $id, '_way2enjoy_size', true );
			$thumbs_meta = get_post_meta( $id, '_way2enjoyed_thumbs', true );
			$main_image_optimized = !empty( $image_meta ) && isset( $image_meta['type'] );
			$thumbs_optimized = !empty( $thumbs_meta ) && count( $thumbs_meta ) && isset( $thumbs_meta[0]['type'] );

			$type = '';
			$compressed_size = '';
			$savings_percentage = '';

			if ( $main_image_optimized ) {
				$type = $image_meta['type'];
				$compressed_size = isset( $image_meta['compressed_size'] ) ? $image_meta['compressed_size'] : '';
				$savings_percentage = @$image_meta['savings_percent'];
				$main_image_way2enjoyed_stats = self::calculate_savings( $image_meta );
			} 

			if ( $thumbs_optimized ) {
				$type = $thumbs_meta[0]['type'];
				$thumbs_way2enjoyed_stats = self::calculate_savings( $thumbs_meta );
				$thumbs_count = count( $thumbs_meta );
			}
			

			
			
			ob_start();
			?>
				<?php if ( $main_image_optimized ) { ?>
				<div class="way2enjoy_detailed_results_wrap">
				<span class=""><strong><?php echo $setting_txt73; ?>:</strong></span>
				<br />
				<span style="display:inline-block;margin-bottom:5px"><?php echo $main_image_way2enjoyed_stats['saved_bytes']; ?> (<?php echo $main_image_way2enjoyed_stats['savings_percentage']; echo $setting_txt71; ?>)</span>
				<?php } ?>
				<?php if ( $main_image_optimized && $thumbs_optimized ) { ?>
				<br />
				<?php } ?>
				<?php if ( $thumbs_optimized ) { ?>
					<span><strong><?php echo $setting_txt74.' ';  echo $thumbs_count.' '; echo $setting_txt75 ?>:</strong></span>
					<br />
					<span style="display:inline-block;margin-bottom:5px"><?php echo $thumbs_way2enjoyed_stats['total_savings']; ?> (<?php echo $thumbs_way2enjoyed_stats['savings_percentage'];  echo $setting_txt71; ?>)</span>
				<?php } ?>
				<br />
				<span><strong><?php echo $setting_txt22 ?>:</strong></span>
				<br />
				<span><?php echo ucfirst($type); ?></span>	
				<?php if ( !empty( $this->way2enjoy_settings['show_reset'] ) ) { ?>
					<br />
					<small
						class="way2enjoyReset" data-id="<?php echo $id; ?>"
						title="Removes Way2enjoy metadata associated with this image">
						<?php echo $setting_txt72; ?>
					</small>
					<span class="way2enjoySpinner"></span>
				</div>
				<?php } ?>
			<?php 	
			$html = ob_get_clean();
			return $html;
		}

		function fill_media_columns( $column_name, $id ) {	
			$setting_txt61 = __( 'Optimize', 'way2enjoy-compress-images' );				
	$setting_txt148 = __( 'Optimizing...all recent uploads.Its doing in background.Check after few minutes by refreshing this page. Dont click again.', 'way2enjoy-compress-images' );	

			$setting_txt62 = __( 'Optimize Main Image', 'way2enjoy-compress-images' );	
			$setting_txt63 = __( 'No savings found or quota exceeded', 'way2enjoy-compress-images' );	
			$setting_txt64 = __( 'Type', 'way2enjoy-compress-images' );	
			$setting_txt65 = __( 'Failed! Hover here', 'way2enjoy-compress-images' );	

			$settings = $this->way2enjoy_settings;
			$optimize_main_image = !empty( $settings['optimize_main_image'] ); 
$auto_opti=$settings['auto_optimize'];
$quotabalance = get_site_option( 'way2enjoy_global_stats' ) ;
$quota_remains = $quotabalance['quota_remaining'];

 
$lastoptimized_time1 = get_site_option( 'way2-in-progress' ) ;
$id_seperator=explode("-",$lastoptimized_time1);  $lastid_on=end($id_seperator)-5; 

 if ( wp_attachment_is_image( $id )) {
$waiting_time='120';
 }
else
{
$waiting_time='1800';	
}
$lastid_time=reset($id_seperator)+$waiting_time; 

if($lastid_time > time() && $id > $lastid_on && $quota_remains >'0' && $auto_opti=='1')
{
$running_or_optimize=$setting_txt148;
$hideorshowspinner='1';	
$opacity_style='style="opacity: 0.5"';
}
else
{
$running_or_optimize=$setting_txt61;	
$hideorshowspinner='';	
$opacity_style=''.$auto_opti.'';
}


			$file = get_attached_file( $id );
			$original_size = filesize( $file );

			// handle the case where file does not exist
			if ( $original_size === 0 || $original_size === false ) {
				echo '0 bytes';
				return;
			} else {
				$original_size = self::formatBytes( $original_size );				
			}
			
			$type = isset( $settings['api_lossy'] ) ? $settings['api_lossy'] : 'lossy';

			if ( strcmp( $column_name, 'original_size' ) === 0 ) {
			//	if ( wp_attachment_is_image( $id ) ) {

					$meta = get_post_meta( $id, '_way2enjoy_size', true );

					if ( isset( $meta['original_size'] ) ) {

						if ( stripos( $meta['original_size'], 'kb' ) !== false ) {
							echo self::formatBytes( ceil( floatval( $meta['original_size']) * 1024 ) );
						} else {
							echo self::formatBytes( $meta['original_size'] );
						}
						
					} else {
						echo $original_size;
					}
				//}
//				 else {
//					echo $original_size;
//				}
			} else if ( strcmp( $column_name, 'compressed_size' ) === 0 ) {
				echo '<div class="way2enjoy-wrap">';
				$image_url = wp_get_attachment_url( $id );
				$filename = basename( $image_url );
//				if ( wp_attachment_is_image( $id ) ) {

					$meta = get_post_meta( $id, '_way2enjoy_size', true );
					$thumbs_meta = get_post_meta( $id, '_way2enjoyed_thumbs', true );

					// Is it optimized? Show some stats
					if ( ( isset( $meta['compressed_size'] ) && empty( $meta['no_savings'] ) ) || !empty( $thumbs_meta ) ) {
						if ( !isset( $meta['compressed_size'] ) && $optimize_main_image ) {
							echo '<div class="buttonWrap"><button data-setting="' . $type . '" type="button" class="way2enjoy_req" data-id="' . $id . '" id="way2enjoyid-' . $id .'" data-filename="' . $filename . '" data-url="' . $image_url . '">'.$setting_txt62.'</button><span class="way2enjoySpinner"></span></div>';
						}
						echo $this->generate_stats_summary( $id );

					// Were there no savings, or was there an error?
					} else {
					echo '<div class="buttonWrap"><button data-setting="' . $type . '" type="button" class="way2enjoy_req" data-id="' . $id . '" id="way2enjoyid-' . $id .'" data-filename="' . $filename . '" data-url="' . $image_url . '" '.$opacity_style.'>'.$running_or_optimize.'</button><span class="way2enjoySpinner'.$hideorshowspinner.'"></span></div>';



						if ( !empty( $meta['no_savings'] ) ) {
							echo '<div class="noSavings"><strong>'.$setting_txt63.'</strong><br /><small>'.$setting_txt64.':&nbsp;' . $meta['type'] . '</small></div>';
						} else if ( isset( $meta['error'] ) ) {
							$error = $meta['error'];
							
							echo '<div class="way2enjoyErrorWrap"><a class="way2enjoyError" title="' . $error . '">'.$setting_txt65.'</a></div>';
						}
						
					}
				//} else {
//					echo 'n/a';
//				}


				echo '</div>';
				
				
					}
					
		}

	
	
	
//		function add_media_columns_way2enjoy_settings( $column_name, $id ) {	
		function add_media_columns_way2enjoy_settings() {	
			$setting_txt53 = __( 'Compress All', 'way2enjoy-compress-images' );
			$setting_txt54 = __( 'incl thumbnails) can be optimized.Ensure that you have sufficient credit left as Bulk compression will stop if credit is exhausted', 'way2enjoy-compress-images' );
			$setting_txt55 = __( 'Images', 'way2enjoy-compress-images' );
			$setting_txt56 = __( 'Bulk Compress via', 'way2enjoy-compress-images' );
			$setting_txt57 = __( 'Media Library', 'way2enjoy-compress-images' );
			$setting_txt58 = __( 'Name', 'way2enjoy-compress-images' );
			$setting_txt59 = __( 'Original Size', 'way2enjoy-compress-images' );
				$setting_txt130 = __( "Choose Directory", "way2enjoy-compress-images" );

		
//			$setting_txt60 = __( 'Way2enjoy Stats', 'way2enjoy-compress-images' );	
			$setting_txt154 = __( 'File Type', 'way2enjoy-compress-images' );	

			$setting_txt61 = __( 'Optimize', 'way2enjoy-compress-images' );	
			$setting_txt153 = __( 'Search. Use checkbox to make selection', 'way2enjoy-compress-images' );	


			$settings = $this->way2enjoy_settings;
			$optimize_main_image = !empty( $settings['optimize_main_image'] ); 


global $wpdb;
//$settings['total_thumb']='';

$tr_dir='';
$directory_table='';

if(!empty( $settings['total_thumb']))
{
$thumbcnt=$settings['total_thumb'];;
}
else
{
$thumbcnt='6';	
}
//$jjjsj=$settings['total_thumb'];
//$post_last_id = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM $wpdb->posts WHERE post_status = 'inherit' AND post_type = 'attachment' AND (post_mime_type = 'image/jpeg' OR post_mime_type = 'image/png' OR post_mime_type = 'image/gif') order by id desc limit 1" ) );
//$id = $post_last_id->id;


//$compressed_last_id = $wpdb->get_row( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE `meta_key` ='_way2enjoy_size' order by post_id desc limit 1" ) );

$compressed_last_id = $wpdb->get_row( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE `meta_key` ='_way2enjoy_size' order by post_id desc limit 1", 'foo', 1337 ) );
// dont remove., 'foo', 1337 as it helps to solve some wordpress error

//$comp_last_id = $compressed_last_id->post_id;

$post_last_id_way2 = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM $wpdb->posts order by ID desc limit 1", 'foo', 1337 ) );


 $comp_last_id = (($compressed_last_id != FALSE) ? $compressed_last_id->post_id : 0);

 $post_last_id_way2enjoy = (($post_last_id_way2 != FALSE) ? $post_last_id_way2->ID : 0);


//echo $post_last_id_way2enjoy;



// directory code starts here
$direcscan= time()- get_site_option('wp-way2enjoy-dir_update_time');
if($direcscan<='600')
{
			
//$query_dir = "SELECT id, path, orig_size FROM {$wpdb->prefix}way2enjoy_dir_images WHERE last_scan = (SELECT MAX(last_scan) FROM {$wpdb->prefix}way2enjoy_dir_images ) ORDER BY id desc";
$query_dir = "SELECT id, path, orig_size FROM {$wpdb->prefix}way2enjoy_dir_images WHERE file_time ='0' ORDER BY id desc";
$results = $wpdb->get_results( $query_dir, ARRAY_A );
$way2direc = 0;
foreach ( $results as $imagedirectoryy ) {
if ( ! is_null( $imagedirectoryy['path'] ) ) {
	$path_directory = $imagedirectoryy['path'];
	$id_directory = $imagedirectoryy['id'];
	$origsize_direc = $imagedirectoryy['orig_size'];
	$origsize_directory = self::formatBytes( $origsize_direc );
	$directorynext23= explode("/",$path_directory);  
$file_nm_dir= end($directorynext23);
						$tr_dir .='<tr id="postd-'.$id_directory.'"><td class="check-column"><input type="checkbox" name="media[]" id="cb-select-'.$id_directory.'" value="'.$id_directory.'" checked=""></td>    <td data-colname="File">'.$file_nm_dir.'</td><td class="original_size" data-colname="Original Size">'.$origsize_directory.'</td><td data-colname="Way2enjoy Stats"><div class="way2enjoy-wrap"><div class="buttonWrap"><input data-setting="lossy" type="hidden" class="way2enjoy_req" data-id="'.$id_directory.'" id="way2enjoyidd-'.$id_directory.'" data-filename="'.$file_nm_dir.'" data-url="'.$path_directory.'"></div></div></td></tr>';	
					$way2direc ++;
				}
}
	
$directory_table='<br /><br /><br /> <hr><br /> <br /> <select style="display:none" name="actiond" id="bulk-action-selector-top1"><option value="way2enjoy-bulk-lossy">Lossy</option>
</select><button type="button" id="doactiond" class="wp-way2enjoy-alld">'.$setting_txt53.'</button><a class="way2enjoyError" title="'.$way2direc.' '.$setting_txt55.'">'.$way2direc.' '.$setting_txt55.'</a><table class="wp-list-table widefat fixed striped media" style="border:0px;max-height:300px;overflow-y:scroll;display:block;"><thead><tr><th class="check-column" scope="col"><input id="cb-select-all-1" type="checkbox" checked=""></th><th scope="col" class="manage-column column-original_size">Name</th>    <th scope="col" id="original_size1" class="manage-column column-original_size">Original Size</th><th scope="col" id="compressed_size1" class="manage-column column-original_size">Way2enjoy Stats</th></tr></thead><tbody id="the-list">'.$tr_dir.'</tbody></table>
';

}
// directory code ends here


//$comp_last_id = $compressed_last_id[2]->post_id;

//$wpdb->prepare( "SELECT * FROM `table` WHERE `column` = %s AND `field` = %d", 'foo', 1337 ); // dont disable. it helps to solve some wordpress error

//var_dump();

$paginateuu = get_site_option( '_way2enjoy_options' ) ;
//
//if ( empty( get_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome' ) )) {
//	$paginate_by ='20000';	
//}
//else
//{
	$paginate_by1 = $paginateuu['old_img']  > 0 ? $paginateuu['old_img'] : "550";
	$paginate_by = $post_last_id_way2enjoy  > $paginate_by1 ? $post_last_id_way2enjoy : "5000";

	$offset = 0;
	$has_more_images = true;
	$listresult='';
$headerruu='';
	

	

$ippp='0';
while ( $has_more_images ) {

		$args = array(
			'posts_per_page' => $paginate_by,
//			'posts_per_page' => $post_last_id_way2enjoy,
			'offset'         => $offset,
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'orderby'        =>'ID',
			'order'          => 'ASC',
			'ID'			 => $comp_last_id,
			'compare' 		 => '>'

			
		);
		
	
		
		
		$the_query = new WP_Query( $args );
		if ( $the_query -> have_posts () ) {
			while ( $the_query -> have_posts () ) {
				$the_query -> the_post ();
				$idall = get_the_ID ();
				

$file = get_attached_file( $idall );
			$original_size1 = filesize( $file );
			$original_size = self::formatBytes( $original_size1 );

	
			$type = isset( $settings['api_lossy'] ) ? $settings['api_lossy'] : 'lossy';

				$image_url = wp_get_attachment_url( $idall );
				$filename1 = basename( $image_url );
				$ext_way2enjoy1=wp_check_filetype($filename1);
				$ext_way2enjoy=$ext_way2enjoy1['ext'];
				$filename = strlen($filename1) > 25 ? substr($filename1,0,25).".." : $filename1;
	
				
$other_extn_way2enjoy= array("svg","SVG","PDF","pdf","mp3","mp4","avi","mov","mpeg","m4a","wav","aac","wma","amr","ogg","flac","m4r","aif","webm");
$banned_extn= array("svg","SVG","ico");

//
//if(is_numeric($idall)){
//commented on 11052018
 if ( wp_attachment_is_image( $idall ) && !in_array($ext_way2enjoy,$banned_extn)) {

//	if($idall > $comp_last_id)

		


$meta = get_post_meta( $idall, '_way2enjoy_size', true );
					$thumbs_meta = get_post_meta( $idall, '_way2enjoyed_thumbs', true );

					// Is it optimized? Show some stats
//					if ( ( isset( $meta['compressed_size'] ) && empty( $meta['no_savings'] ) ) || !empty( $thumbs_meta ) ) 

//if($remainnn >='0')
//{
//$criteria=	'&& !empty( $thumbs_meta[\'no_savings\'])';
//}
//
//else
//{
//$criteria=	'';
//	
//}

//					if (  empty( $thumbs_meta ) && $criteria ) 
//this was till 18.11.2017//				if ( empty( $thumbs_meta ) && ($meta['saved_bytes']!='0') ) 
$meta['saved_bytes']='';

//if(in_array($ext_way2enjoy,$img_extn_way2enjoy)){
//	$filter_way2enjoy=empty( $thumbs_meta ) && ($meta['saved_bytes']<'0');
//	}
//else
//{
//$filter_way2enjoy= $meta['saved_bytes']<'0';	
//	}







			if ( empty( $thumbs_meta ) && ($meta['saved_bytes']<'0' && is_numeric($original_size1)) ) 	{



				//	if ($meta['saved_bytes'] )) {


	
$listresult .='<tr id="post-'.$idall.'"><td class="check-column"><input type="checkbox" name="media[]" id="cb-select-'.$idall.'" value="'.$idall.'" checked></td>    <td data-colname="File">' . $filename . '</td><td class=\'original_size\' data-colname="'.$setting_txt59.'">'.$original_size.'</td><td data-colname="'.$setting_txt154.'"><div class="way2enjoy-wrap"><div class="buttonWrap">'.$ext_way2enjoy.'<input data-setting="' . $type . '" type="hidden" class="way2enjoy_req" data-id="'.$idall.'" id="way2enjoyid-'.$idall.'" data-filename="' . $filename . '" data-url="' . $image_url .'" /></div></div></td></tr>';
	
			
			
				$ippp++;
	
}}
//else
elseif(in_array($ext_way2enjoy,$other_extn_way2enjoy))
{
$meta = get_post_meta( $idall, '_way2enjoy_size', true );
//$meta['saved_bytes']='';	
			if ( @$meta['saved_bytes'] <'0' && is_numeric($original_size1)) 	{
	
	$listresult .='<tr id="post-'.$idall.'"><td class="check-column"><input type="checkbox" name="media[]" id="cb-select-'.$idall.'" value="'.$idall.'" checked></td>    <td data-colname="File">' . $filename . '</td><td class=\'original_size\' data-colname="'.$setting_txt59.'">'.$original_size.'</td><td data-colname="'.$setting_txt154.'"><div class="way2enjoy-wrap"><div class="buttonWrap">'.$ext_way2enjoy.'<input data-setting="' . $type . '" type="hidden" class="way2enjoy_req" data-id="'.$idall.'" id="way2enjoyid-'.$idall.'" data-filename="' . $filename . '" data-url="' . $image_url .'" /></div></div></td></tr>';
				$ippp++;
			}
}

$headerruu='<thead>
        <th class="check-column" scope="col"><input id="cb-select-all-1" type="checkbox" checked></th>

    <th scope="col"  class="manage-column column-original_size">'.$setting_txt58.'</th>    <th scope="col" id="original_size" class="manage-column column-original_size">'.$setting_txt59.'</th><th scope="col" id="compressed_size" class="manage-column column-original_size">'.$setting_txt154.'</th>

	</thead>';
	
				
				}
				}
					
				 else {
		}	
//			

$has_more_images = false; // STOP
	
//					
//				
$someno='';
if($ippp =='0'){$someno='1';}
}
return '<script>
jQuery(document).ready(function($) {
	$(".wp-way2enjoy-all").click(function() {
$(\'html, body\').animate({
    scrollTop: $("#wp-way2enjoy-welcome-box").offset().top - 150
}, 2000);
	});
});
</script><select style="display:none" name="action" id="bulk-action-selector-top">
<option  value="way2enjoy-bulk-lossy">Lossy</option>
</select>

<button type="button" id="doaction" class="wp-way2enjoy-all">'.$setting_txt53.'</button><a class="way2enjoyError" title="'.$ippp.' x ('.$thumbcnt.'+1)('.$setting_txt54.'">'.($ippp*($thumbcnt+1)).' '.$setting_txt55.'</a><span class="smallsize"> '.$setting_txt56.' <a href="/wp-admin/upload.php" title="'.$setting_txt57.'" target="_blank">'.$setting_txt57.'</a></span>
<br/><br/> <a href="#popup3" id="kuchbhi3">'.$setting_txt130.'</a><br/><br/>
<!--  <input id="search_Inputway2" type="text" placeholder="'.$setting_txt153.'"> --> 

<table class="wp-list-table widefat fixed striped media" style="border:0px;max-height:300px;overflow-y:scroll;display:block;">'.$headerruu.'<tbody id="the-list'.$someno.'">'.$listresult.'</tbody></table>
'.$directory_table.'';
}
// end to fetch all images to be compressed


	
	function screen() {
			global $admin_page_suffix;

						$setting_txt = __( 'Way2enjoy Compress Images Settings', 'way2enjoy-compress-images' );
	
	add_media_page( $setting_txt, 'Way2enjoy Image', 'manage_options', 'wp-way2enjoy', array( &$this, 'way2enjoy_settings_page' ) );


		}
		function replace_image( $image_path, $compressed_url) {
			$rv = false;

$argsiuu = array('compress'    => false,'decompress'  => true,'sslverify'   => false,'stream' => false); 
 $resultpo = wp_remote_get($compressed_url,$argsiuu);
$result = $resultpo['body'];
			if ( $result ) {
				$rv = file_put_contents( $image_path, $result );
							
			}

			return $rv !== false;
		}

function webp_image( $image_path, $web_url) {
$rvwebp = false;
$argsiuu2 = array('compress'    => false,'decompress'  => true,'sslverify'   => false,'stream' => false); 
$resultwebp = wp_remote_get($web_url,$argsiuu2);
$path_partsw = pathinfo($image_path);

$filepathwebp=$path_partsw['dirname'].'/'.$path_partsw['filename'].'.webp';
$resultwp = $resultwebp['body'];
			if ( $resultwp ) {
				$rvwebp = file_put_contents( $filepathwebp, $resultwp );
							
			}
			
			return $rvwebp !== false;
		}


			function optimize_image( $image_path, $type, $resize = false ) {
//			function optimize_image( $image_path, $type, $resize = true ) {

	
			$settings = $this->way2enjoy_settings;
			$way2enjoy = new Way2enjoy( $settings['api_key'], $settings['api_secret'] );

			if ( !empty( $type ) ) {
				$lossy = $type === 'lossy';
			} else {
				$lossy = $settings['api_lossy'] === 'lossy';
			}
$ippoge_id = $this->id;



//$kdkdkw=$wpsmush_helper->get_attached_file( $ID );
$image_linkuu = wp_get_attachment_url( $ippoge_id );
//$image_linkuu = wp_get_attachment_url( '55' );

			$params = array(
				'file' => $image_path,
//				'urlll' => $image_linkuu.$linkspp,
				'urlll' => $image_linkuu,
				'wait' => true,
				//'async' => true,
				'lossy' => $lossy,
				'origin' => 'wp'
			);

$settings['preserve_meta_date']='';
$settings['preserve_meta_copyright']='';
$settings['preserve_meta_geotag']='';
$settings['preserve_meta_orientation']='';
$settings['preserve_meta_profile']='';



			$preserve_meta_arr = array();
			if ( $settings['preserve_meta_date'] ) {
				$preserve_meta_arr[] = 'date';
			}
			if ( $settings['preserve_meta_copyright'] ) {
				$preserve_meta_arr[] = 'copyright';
			}
			if ( $settings['preserve_meta_geotag'] ) {
				$preserve_meta_arr[] = 'geotag';
			}
			if ( $settings['preserve_meta_orientation'] ) {
				$preserve_meta_arr[] = 'orientation';
			}
			if ( $settings['preserve_meta_profile'] ) {
				$preserve_meta_arr[] = 'profile';
			}
			if ( $settings['chroma'] ) {
				$params['sampling_scheme'] = $settings['chroma'];
			}

			if ( count( $preserve_meta_arr ) ) {
				$params['preserve_meta'] = $preserve_meta_arr;
			}

			if ( $settings['auto_orient'] ) {
				$params['auto_orient'] = true;
			}
if ( $settings['mp3_bit'] !='96' ) {
				$params['mp3_bit'] = $settings['mp3_bit'];
			}

			if ( $resize ) {
				$width = (int) $settings['resize_width'];
				$height = (int) $settings['resize_height'];
				if ( $width && $height ) {
					$params['resize'] = array('strategy' => 'auto', 'width' => $width, 'height' => $height );
				} elseif ( $width && !$height ) {
					$params['resize'] = array('strategy' => 'landscape', 'width' => $width );
				} elseif ( $height && !$width ) {
					$params['resize'] = array('strategy' => 'portrait', 'height' => $height );
				}
			}

			if ( isset( $settings['jpeg_quality'] ) && $settings['jpeg_quality'] > 0 ) {
				$params['quality'] = (int) $settings['jpeg_quality'];
			}
			if ( isset( $settings['total_thumb'] ) && $settings['total_thumb'] > 4 ) {
				$params['total_thumb'] = (int) $settings['total_thumb'];
			}
			if ( isset( $settings['optimize_main_image'] ) && $settings['optimize_main_image'] >= 0 ) {
				$params['optimize_main_image'] = (int) $settings['optimize_main_image'];
			}

// testing quota parameter starts here
$quotabalance = get_site_option( 'way2enjoy_global_stats' ) ;
$params['quota_remaining'] = $quotabalance['quota_remaining'];
$params['pro_not'] = $quotabalance['pro_not'];

// testing quota parameter ends here
if ( isset( $settings['webp_yes'] ) && $settings['webp_yes'] >= 0 ) {$params['webp_yes'] = (int) $settings['webp_yes'];	}
if ( isset( $settings['google'] ) && $settings['google'] >= 0 ) {$params['google'] = (int) $settings['google'];	}
if ( $settings['pdf_quality'] !='100' ) {$params['pdf_quality'] = $settings['pdf_quality'];}
if ( $settings['video_quality'] !='75' ) {$params['video_quality'] = $settings['video_quality'];}
if ( $settings['resize_video'] !='0' ) {$params['resize_video'] = $settings['resize_video'];}
if ( isset( $settings['intelligentcrop'] ) && $settings['intelligentcrop'] >= 0 ) {$params['intelligentcrop'] = (int) $settings['intelligentcrop'];	}
if ( isset( $settings['artificial_intelligence'] ) && $settings['artificial_intelligence'] >= 0 ) {$params['artificial_intelligence'] = (int) $settings['artificial_intelligence'];	}

					
			set_time_limit(400);
			set_time_limit(2000);
			$data = $way2enjoy->upload( $params );
			
			
			
			$data['type'] = !empty( $type ) ? $type : $settings['api_lossy'];
	
			return $data;
		}

		function get_sizes_to_enjoyed() {
			$settings = $this->way2enjoy_settings;
			$rv = array();

			foreach( $settings as $key => $value ) {
				if ( strpos( $key, 'include_size' ) === 0 && !empty( $value ) ) {
					$rv[] = $key;
				}
			}
			return $rv;
		}

		function optimize_thumbnails( $image_data ) {
//$image_data['file']='';
$settings = $this->way2enjoy_settings;
			$image_id = $this->id;
			if ( empty( $image_id ) ) {
				global $wpdb;
				$post = $wpdb->get_row( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s LIMIT 1", $image_data['file'] ) );
				$image_id = $post->post_id;
			}

			$way2enjoy_meta = get_post_meta( $image_id, '_way2enjoy_size', true );
			$image_backup_path = isset( $way2enjoy_meta['optimized_backup_file'] ) ? $way2enjoy_meta['optimized_backup_file'] : '';
			
			if ( $image_backup_path ) {
				$original_image_path = get_attached_file( $image_id );				
				if ( copy( $image_backup_path, $original_image_path ) ) {
					unlink( $image_backup_path );
					unset( $way2enjoy_meta['optimized_backup_file'] );
					update_post_meta( $image_id, '_way2enjoy_size', $way2enjoy_meta );
				}
			}

			if ( !$this->preg_array_key_exists( '/^include_size_/', $this->way2enjoy_settings ) ) {
				
				global $_wp_additional_image_sizes;
				$sizes = array();

				foreach ( get_intermediate_image_sizes() as $_size ) {
					if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
						$sizes[ $_size ]['width']  = get_site_option( "{$_size}_size_w" );
						$sizes[ $_size ]['height'] = get_site_option( "{$_size}_size_h" );
						$sizes[ $_size ]['crop']   = (bool) get_site_option( "{$_size}_crop" );
					} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
						$sizes[ $_size ] = array(
							'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
							'height' => $_wp_additional_image_sizes[ $_size ]['height'],
							'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
						);
					}
				}
				$sizes = array_keys( $sizes );
				foreach ($sizes as $size) {
					$this->way2enjoy_settings['include_size_' . $size] = 1;
				}
			}			

			// when resizing has taken place via API, update the post metadata accordingly
			if ( !empty( $way2enjoy_meta['way2enjoyed_width'] ) && !empty( $way2enjoy_meta['way2enjoyed_height'] ) ) {
				$image_data['width'] = $way2enjoy_meta['way2enjoyed_width'];
				$image_data['height'] = $way2enjoy_meta['way2enjoyed_height'];
			}
$path_parts="";

			$path_parts = @pathinfo($image_data['file']);
//$path_parts['dirname']='';
			// e.g. 04/02, for use in getting correct path or URL
			$upload_subdir = @$path_parts['dirname'];

		$upload_dir = wp_upload_dir() ;
	//		$upload_dir = '/wp-content/gallery';

			// all the way up to /uploads
			$upload_base_path = $upload_dir['basedir'];
			$upload_full_path = $upload_base_path . '/' . $upload_subdir;

			$sizes = array();

			if ( isset( $image_data['sizes'] ) ) {
				$sizes = $image_data['sizes'];
			}

			if ( !empty( $sizes ) ) {

				$sizes_to_enjoyed = $this->get_sizes_to_enjoyed();
				$thumb_path = '';
				$thumbs_optimized_store = array();
				$this_thumb = array();

				foreach ( $sizes as $key => $size ) {

					if ( !in_array("include_size_$key", $sizes_to_enjoyed) ) {
						continue;
					}

					$thumb_path = $upload_full_path . '/' . $size['file'];
					
					if ( file_exists( $thumb_path ) !== false ) {
						$result = $this->optimize_image( $thumb_path, $this->optimization_type );
						if ( !empty( $result ) && isset( $result['success'] ) && isset( $result['compressed_url'] ) ) {
							$compressed_url = $result['compressed_url'];
if(@$settings['webp_yes']=='1')
{						
$web_url = $result['webp_url'];
$this->webp_image( $thumb_path, $web_url ) ;
}
							if ( (int) $result['saved_bytes'] !== 0 ) {
			
			
								if ( $this->replace_image( $thumb_path, $compressed_url ) ) {
									$this_thumb = array( 'thumb' => $key, 'file' => $size['file'], 'original_size' => $result['original_size'], 'compressed_size' => $result['compressed_size'], 'type' => $this->optimization_type, 'quota_remaining' => $result['quota_remaining'] );
									$thumbs_optimized_store [] = $this_thumb;
									
								
									
									
								}
							} else {
								$this_thumb = array( 'thumb' => $key, 'file' => $size['file'], 'original_size' => $result['original_size'], 'compressed_size' => $result['original_size'], 'type' => $this->optimization_type, 'quota_remaining' => $result['quota_remaining'] );
								$thumbs_optimized_store [] = $this_thumb;								
							}
							
							
		//		//			// my edit

			$factor_img=$image_id%4;
$savedetailss = get_site_option( 'way2enjoy_global_stats'.$factor_img.'' ) ;

//$way2enjoy_savingdata['size_before'.$factor_img.''] = $result['original_size'] + $savedetailss['size_before'.$factor_img.''];	
//$way2enjoy_savingdata['size_after'.$factor_img.''] = $result['compressed_size'] + $savedetailss['size_after'.$factor_img.''];		
//$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;


if($factor_img=='0')
{
		
	$way2enjoy_savingdata['size_before0'] = $result['original_size'] + $savedetailss['size_before0'];	
	$way2enjoy_savingdata['size_after0'] = $result['compressed_size'] + $savedetailss['size_after0'];		
	$way2enjoy_savingdata['total_images0'] = $savedetailss['total_images0']+1;	
}
elseif($factor_img=='1')
{
	

	$way2enjoy_savingdata['size_before1'] = $result['original_size'] + $savedetailss['size_before1'];	
	$way2enjoy_savingdata['size_after1'] = $result['compressed_size'] + $savedetailss['size_after1'];		
	$way2enjoy_savingdata['total_images1'] = $savedetailss['total_images1']+1;		
}
	elseif($factor_img=='2')
{
	

	$way2enjoy_savingdata['size_before2'] = $result['original_size'] + $savedetailss['size_before2'];	
	$way2enjoy_savingdata['size_after2'] = $result['compressed_size'] + $savedetailss['size_after2'];		
	$way2enjoy_savingdata['total_images2'] = $savedetailss['total_images2']+1;		
}			
	
	elseif($factor_img=='3')
{
		
	$way2enjoy_savingdata['size_before3'] = $result['original_size'] + $savedetailss['size_before3'];	
	$way2enjoy_savingdata['size_after3'] = $result['compressed_size'] + $savedetailss['size_after3'];		
	$way2enjoy_savingdata['total_images3'] = $savedetailss['total_images3']+1;		
}		
	else
	{
	$way2enjoy_savingdata['size_before'] = $result['original_size'] + $savedetailss['size_before'];	
	$way2enjoy_savingdata['size_after'] = $result['compressed_size'] + $savedetailss['size_after'];		
	$way2enjoy_savingdata['total_images'] = $savedetailss['total_images']+1;			
	}




	//$statusuu = $this->get_api_status( get_bloginfo('admin_email'), get_bloginfo('siteurl') );


//$way2enjoy_savingdata['quota_remaining'] = $statusuu['quota_remaining'];
//$way2enjoy_savingdata['pro_not'] = $statusuu['pro_not'];
//$way2enjoy_savingdata['pro_not'] = $savedetailss['pro_not'];

$way2enjoy_savingdata_thumb['quota_remaining']=$result['quota_remaining'];
//if(!empty($result['quota_remaining']))
//{
//$balance_quota=$result['quota_remaining'];	
//}
//else
//{
//	$balance_quota='-10';	
//
//}
//
//$way2enjoy_savingdata['quota_remaining']=$balance_quota;



						    update_site_option( 'way2enjoy_global_stats', $way2enjoy_savingdata_thumb );		

		    update_site_option( 'way2enjoy_global_stats'.$factor_img.'', $way2enjoy_savingdata );		
	
				
								// my edit ends here								
							
										

							
							
						} 
					}
				}
			}
			if ( !empty( $thumbs_optimized_store ) ) {
				update_post_meta( $image_id, '_way2enjoyed_thumbs', $thumbs_optimized_store, false );
				
				
						
			}
			
			
		
			
				
			
			return $image_data;
		}
		
		
		
	function optimize_image_dir( $image_path, $type, $resize = false ) {
//			function optimize_image( $image_path, $type, $resize = true ) {

	
			$settings = $this->way2enjoy_settings;
			$way2enjoy = new Way2enjoy( $settings['api_key'], $settings['api_secret'] );

			if ( !empty( $type ) ) {
				$lossy = $type === 'lossy';
			} else {
				$lossy = $settings['api_lossy'] === 'lossy';
			}

$ippoge_id = $this->id;

//$image_linkuu = wp_get_attachment_url( $ippoge_id );
$rootpth = realpath( get_root_path() );
 $exprelpath=explode($rootpth,$image_path);
$image_linkuu=get_bloginfo('siteurl').'/'.$exprelpath[1];


			$params = array(
				'file' => $image_path,
				'urlll' => $image_linkuu,
				'wait' => true,
				'lossy' => $lossy,
				'origin' => '1'
			);

$settings['preserve_meta_date']='';
$settings['preserve_meta_copyright']='';
$settings['preserve_meta_geotag']='';
$settings['preserve_meta_orientation']='';
$settings['preserve_meta_profile']='';
//$result['compressed_size']='';
//$result['original_size']='';


			$preserve_meta_arr = array();
			if ( $settings['preserve_meta_date'] ) {
				$preserve_meta_arr[] = 'date';
			}
			if ( $settings['preserve_meta_copyright'] ) {
				$preserve_meta_arr[] = 'copyright';
			}
			if ( $settings['preserve_meta_geotag'] ) {
				$preserve_meta_arr[] = 'geotag';
			}
			if ( $settings['preserve_meta_orientation'] ) {
				$preserve_meta_arr[] = 'orientation';
			}
			if ( $settings['preserve_meta_profile'] ) {
				$preserve_meta_arr[] = 'profile';
			}
			if ( $settings['chroma'] ) {
				$params['sampling_scheme'] = $settings['chroma'];
			}

			if ( count( $preserve_meta_arr ) ) {
				$params['preserve_meta'] = $preserve_meta_arr;
			}

			if ( $settings['auto_orient'] ) {
				$params['auto_orient'] = true;
			}
if ( $settings['mp3_bit'] !='96' ) {
				$params['mp3_bit'] = $settings['mp3_bit'];
			}
			if ( $resize ) {
				$width = (int) $settings['resize_width'];
				$height = (int) $settings['resize_height'];
				if ( $width && $height ) {
					$params['resize'] = array('strategy' => 'auto', 'width' => $width, 'height' => $height );
				} elseif ( $width && !$height ) {
					$params['resize'] = array('strategy' => 'landscape', 'width' => $width );
				} elseif ( $height && !$width ) {
					$params['resize'] = array('strategy' => 'portrait', 'height' => $height );
				}
			}

			if ( isset( $settings['jpeg_quality'] ) && $settings['jpeg_quality'] > 0 ) {
				$params['quality'] = (int) $settings['jpeg_quality'];
			}
			if ( isset( $settings['total_thumb'] ) && $settings['total_thumb'] > 4 ) {
				$params['total_thumb'] = (int) $settings['total_thumb'];
			}
			
			if ( isset( $settings['optimize_main_image'] ) && $settings['optimize_main_image'] >= 0 ) {
				$params['optimize_main_image'] = (int) $settings['optimize_main_image'];
			}

// testing quota parameter starts here
$quotabalance = get_site_option( 'way2enjoy_global_stats' ) ;
$params['quota_remaining'] = $quotabalance['quota_remaining'];
$params['pro_not'] = $quotabalance['pro_not'];

// testing quota parameter ends here	
if ( isset( $settings['webp_yes'] ) && $settings['webp_yes'] >= 0 ) {$params['webp_yes'] = (int) $settings['webp_yes'];	}
if ( isset( $settings['google'] ) && $settings['google'] >= 0 ) {$params['google'] = (int) $settings['google'];	}
if ( $settings['pdf_quality'] !='100' ) {$params['pdf_quality'] = $settings['pdf_quality'];}
if ( $settings['video_quality'] !='75' ) {$params['video_quality'] = $settings['video_quality'];}
if ( $settings['resize_video'] !='0' ) {$params['resize_video'] = $settings['resize_video'];}
if ( isset( $settings['intelligentcrop'] ) && $settings['intelligentcrop'] >= 0 ) {$params['intelligentcrop'] = (int) $settings['intelligentcrop'];	}
if ( isset( $settings['artificial_intelligence'] ) && $settings['artificial_intelligence'] >= 0 ) {$params['artificial_intelligence'] = (int) $settings['artificial_intelligence'];	}

			
			set_time_limit(400);
			$data = $way2enjoy->upload( $params );
			$data['type'] = !empty( $type ) ? $type : $settings['api_lossy'];
	
			return $data;
		}	
		
		
		
		
		
		function optimize_image_nextgen( $image_path, $type, $resize = true ) {

//			function optimize_image_nextgen( $image_path, $type, $resize = false ) {
global $finalurluu;
			$settings = $this->way2enjoy_settings;
			$way2enjoy = new Way2enjoy( $settings['api_key'], $settings['api_secret'] );

			if ( !empty( $type ) ) {
				$lossy = $type === 'lossy';
			} else {
				$lossy = $settings['api_lossy'] === 'lossy';
			}

$ippoge_id = $this->id;
$image_linkuu =$finalurluu;

//$image_linkuu = wp_get_attachment_url( $ippoge_id );

			$params = array(
				'file' => $image_path,
				'urlll' => $image_linkuu,
				'wait' => true,
				'lossy' => $lossy,
				'origin' => 'wp'
			);

			$preserve_meta_arr = array();
			if ( $settings['preserve_meta_date'] ) {
				$preserve_meta_arr[] = 'date';
			}
			if ( $settings['preserve_meta_copyright'] ) {
				$preserve_meta_arr[] = 'copyright';
			}
			if ( $settings['preserve_meta_geotag'] ) {
				$preserve_meta_arr[] = 'geotag';
			}
			if ( $settings['preserve_meta_orientation'] ) {
				$preserve_meta_arr[] = 'orientation';
			}
			if ( $settings['preserve_meta_profile'] ) {
				$preserve_meta_arr[] = 'profile';
			}
			if ( $settings['chroma'] ) {
				$params['sampling_scheme'] = $settings['chroma'];
			}

			if ( count( $preserve_meta_arr ) ) {
				$params['preserve_meta'] = $preserve_meta_arr;
			}

			if ( $settings['auto_orient'] ) {
				$params['auto_orient'] = true;
			}
if ( $settings['mp3_bit'] !='96' ) {
				$params['mp3_bit'] = $settings['mp3_bit'];
			}
			if ( $resize ) {
				$width = (int) $settings['resize_width'];
				$height = (int) $settings['resize_height'];
				if ( $width && $height ) {
					$params['resize'] = array('strategy' => 'auto', 'width' => $width, 'height' => $height );
				} elseif ( $width && !$height ) {
					$params['resize'] = array('strategy' => 'landscape', 'width' => $width );
				} elseif ( $height && !$width ) {
					$params['resize'] = array('strategy' => 'portrait', 'height' => $height );
				}
			}

			if ( isset( $settings['jpeg_quality'] ) && $settings['jpeg_quality'] > 0 ) {
				$params['quality'] = (int) $settings['jpeg_quality'];
			}
			
			if ( isset( $settings['total_thumb'] ) && $settings['total_thumb'] > 4 ) {
				$params['total_thumb'] = (int) $settings['total_thumb'];
			}
			
			if ( isset( $settings['optimize_main_image'] ) && $settings['optimize_main_image'] >= 0 ) {
				$params['optimize_main_image'] = (int) $settings['optimize_main_image'];
			}

// testing quota parameter starts here
$quotabalance = get_site_option( 'way2enjoy_global_stats' ) ;
$params['quota_remaining'] = $quotabalance['quota_remaining'];
$params['pro_not'] = $quotabalance['pro_not'];

// testing quota parameter ends here	
if ( isset( $settings['webp_yes'] ) && $settings['webp_yes'] >= 0 ) {$params['webp_yes'] = (int) $settings['webp_yes'];	}
if ( isset( $settings['google'] ) && $settings['google'] >= 0 ) {$params['google'] = (int) $settings['google'];	}
if ( $settings['pdf_quality'] !='100' ) {$params['pdf_quality'] = $settings['pdf_quality'];}
if ( $settings['video_quality'] !='75' ) {$params['video_quality'] = $settings['video_quality'];}
if ( $settings['resize_video'] !='0' ) {$params['resize_video'] = $settings['resize_video'];}
if ( isset( $settings['intelligentcrop'] ) && $settings['intelligentcrop'] >= 0 ) {$params['intelligentcrop'] = (int) $settings['intelligentcrop'];	}
if ( isset( $settings['artificial_intelligence'] ) && $settings['artificial_intelligence'] >= 0 ) {$params['artificial_intelligence'] = (int) $settings['artificial_intelligence'];	}

			
			set_time_limit(400);
			$data = $way2enjoy->upload( $params );
			$data['type'] = !empty( $type ) ? $type : $settings['api_lossy'];
			return $data;
		}
	
function optimize_thumbnails_nextgen( $img_thumbpath, $type, $resize = true ) {

//			function optimize_image_nextgen( $image_path, $type, $resize = false ) {
global	$finalurlthumb;
	
			$settings = $this->way2enjoy_settings;
			$way2enjoy = new Way2enjoy( $settings['api_key'], $settings['api_secret'] );

			if ( !empty( $type ) ) {
				$lossy = $type === 'lossy';
			} else {
				$lossy = $settings['api_lossy'] === 'lossy';
			}

$ippoge_id = $this->id;
$image_linkthumb =$finalurlthumb;


//$image_linkuu = wp_get_attachment_url( $ippoge_id );

			$params = array(
				'file' => $img_thumbpath,
				'urlll' => $image_linkthumb,
				'wait' => true,
				'lossy' => $lossy,
				'origin' => 'wp'
			);

			$preserve_meta_arr = array();
			if ( $settings['preserve_meta_date'] ) {
				$preserve_meta_arr[] = 'date';
			}
			if ( $settings['preserve_meta_copyright'] ) {
				$preserve_meta_arr[] = 'copyright';
			}
			if ( $settings['preserve_meta_geotag'] ) {
				$preserve_meta_arr[] = 'geotag';
			}
			if ( $settings['preserve_meta_orientation'] ) {
				$preserve_meta_arr[] = 'orientation';
			}
			if ( $settings['preserve_meta_profile'] ) {
				$preserve_meta_arr[] = 'profile';
			}
			if ( $settings['chroma'] ) {
				$params['sampling_scheme'] = $settings['chroma'];
			}

			if ( count( $preserve_meta_arr ) ) {
				$params['preserve_meta'] = $preserve_meta_arr;
			}

			if ( $settings['auto_orient'] ) {
				$params['auto_orient'] = true;
			}
if ( $settings['mp3_bit'] !='96' ) {
				$params['mp3_bit'] = $settings['mp3_bit'];
			}

			if ( $resize ) {
				$width = (int) $settings['resize_width'];
				$height = (int) $settings['resize_height'];
				if ( $width && $height ) {
					$params['resize'] = array('strategy' => 'auto', 'width' => $width, 'height' => $height );
				} elseif ( $width && !$height ) {
					$params['resize'] = array('strategy' => 'landscape', 'width' => $width );
				} elseif ( $height && !$width ) {
					$params['resize'] = array('strategy' => 'portrait', 'height' => $height );
				}
			}

			if ( isset( $settings['jpeg_quality'] ) && $settings['jpeg_quality'] > 0 ) {
				$params['quality'] = (int) $settings['jpeg_quality'];
			}
			
			if ( isset( $settings['total_thumb'] ) && $settings['total_thumb'] > 4 ) {
				$params['total_thumb'] = (int) $settings['total_thumb'];
			}
			
			if ( isset( $settings['optimize_main_image'] ) && $settings['optimize_main_image'] >= 0 ) {
				$params['optimize_main_image'] = (int) $settings['optimize_main_image'];
			}

// testing quota parameter starts here
$quotabalance = get_site_option( 'way2enjoy_global_stats' ) ;
$params['quota_remaining'] = $quotabalance['quota_remaining'];
$params['pro_not'] = $quotabalance['pro_not'];

// testing quota parameter ends here	
			
if ( isset( $settings['webp_yes'] ) && $settings['webp_yes'] >= 0 ) {$params['webp_yes'] = (int) $settings['webp_yes'];	}
if ( isset( $settings['google'] ) && $settings['google'] >= 0 ) {$params['google'] = (int) $settings['google'];	}
if ( $settings['pdf_quality'] !='100' ) {$params['pdf_quality'] = $settings['pdf_quality'];}
if ( $settings['video_quality'] !='75' ) {$params['video_quality'] = $settings['video_quality'];}
if ( $settings['resize_video'] !='0' ) {$params['resize_video'] = $settings['resize_video'];}
if ( isset( $settings['intelligentcrop'] ) && $settings['intelligentcrop'] >= 0 ) {$params['intelligentcrop'] = (int) $settings['intelligentcrop'];	}
if ( isset( $settings['artificial_intelligence'] ) && $settings['artificial_intelligence'] >= 0 ) {$params['artificial_intelligence'] = (int) $settings['artificial_intelligence'];	}




			set_time_limit(400);
			$data = $way2enjoy->upload( $params );
			$data['type'] = !empty( $type ) ? $type : $settings['api_lossy'];
			return $data;
		}

		function get_image_sizes() {
			global $_wp_additional_image_sizes;

			$sizes = array();

			foreach ( get_intermediate_image_sizes() as $_size ) {
				if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
					$sizes[ $_size ]['width']  = get_site_option( "{$_size}_size_w" );
					$sizes[ $_size ]['height'] = get_site_option( "{$_size}_size_h" );
					$sizes[ $_size ]['crop']   = (bool) get_site_option( "{$_size}_crop" );
				} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
					$sizes[ $_size ] = array(
						'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
						'height' => $_wp_additional_image_sizes[ $_size ]['height'],
						'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
					);
				}
			}

			return $sizes;
		}


		static function formatBytes( $size, $precision = 2 ) {
			if (empty($size)) $size = 0.0;// added this line on 20.12.2017
		    $base = log( $size, 1024 );
			//			if (empty($base)) $base = 0.0;// added this line on 20.12.2017
		    $suffixes = array( ' bytes', 'KB', 'MB', 'GB', 'TB' );   
		    return round( pow( 1024, $base - floor( $base ) ), $precision ) . $suffixes[floor( $base )];
		}
	
	}
}

//	add_action( 'wp_ajax_way_enable_gzip', 'way_enable_gzip' , 10, 1 );
	add_action( 'wp_ajax_way_enable_gzip', 'way_enable_gzip');
//add_action( 'wp_loaded', 'way_enable_gzip');

function way_enable_gzip() {
			update_site_option( 'way2-gzip-enabled', 1 );

		if(strtolower($_SERVER['SERVER_SOFTWARE']) == 'apache') {
//			if(strtolower($_SERVER['SERVER_SOFTWARE']) != 'apache') {
	
	     if(!get_site_option('way2-htaccess-enabled') ) {

			update_site_option( 'way2-htaccess-enabled', 1 );

			add_filter('mod_rewrite_rules', 'way2enjoy_addHtaccessContent');
			save_mod_rewrite_rules();
		 }
		 else
		 
		 {
						way2enjoy_other_gzip();
 
			 
		 }

echo '

    HTML,JS,CSS,SVG,XML etc Compression enabled
    ▬▬▬▬▬▬▬▬▬ஜ۩۞۩ஜ▬▬▬▬▬▬▬▬▬
	 • Contact us if you faced any issue 
    • bydbest@gmail.com
    • Check saving in setting page 
    • If Plugin is uninstalled, this compression will be disabled

 '; 
		} 
		else {
			update_site_option( 'way2-htaccess-enabled', 0 );
remove_filter('mod_rewrite_rules', 'way2enjoy_addHtaccessContent');
			save_mod_rewrite_rules();
			way2enjoy_other_gzip();	
echo '

    HTML,JS,CSS,SVG,XML etc Compression enabled
    ▬▬▬▬▬▬▬▬▬ஜ۩۞۩ஜ▬▬▬▬▬▬▬▬▬
	 • Contact us if you faced any issue 
    • bydbest@gmail.com
    • Check saving in setting page 
    • If Plugin is uninstalled, this compression will be disabled 

     '; 
		 
		 
		 			
	//		remove_filter('mod_rewrite_rules', 'way2enjoy_addHtaccessContent');
	//		save_mod_rewrite_rules();
		}

	die();			

	}

function way2enjoy_addHtaccessContent($rules) {
	$my_contentgzip = '
<IfModule mod_deflate.c>
	<IfModule mod_filter.c>
			<IfModule mod_version.c>
				# Declare a "gzip" filter, it should run after all internal filters like PHP or SSI
				FilterDeclare  gzip CONTENT_SET

				# Enable "gzip" filter if "Content-Type" contains "text/html", "text/css" etc.
				<IfVersion < 2.4.4>
					<IfModule filter_module>
						FilterDeclare   COMPRESS
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $text/html
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $text/css
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $text/plain
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $text/xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $text/x-component
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/javascript
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/json
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/xhtml+xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/rss+xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/atom+xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/vnd.ms-fontobject
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $image/svg+xml
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $application/x-font-ttf
						FilterProvider  COMPRESS  DEFLATE resp=Content-Type $font/opentype
						FilterChain     COMPRESS
						FilterProtocol  COMPRESS  DEFLATE change=yes;byteranges=no
					</IfModule>
				</IfVersion>

				<IfVersion >= 2.4.4>
					<IfModule filter_module>
						FilterDeclare   COMPRESS
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'text/html\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'text/css\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'text/plain\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'text/xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'text/x-component\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/javascript\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/json\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/xhtml+xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/rss+xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/atom+xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/vnd.ms-fontobject\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'image/svg+xml\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'image/x-icon\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'application/x-font-ttf\'"
						FilterProvider  COMPRESS  DEFLATE "%{Content_Type} = \'font/opentype\'"
						FilterChain     COMPRESS
						FilterProtocol  COMPRESS  DEFLATE change=yes;byteranges=no
					</IfModule>
				</IfVersion>
		</IfModule>
	</IfModule>

  <IfModule !mod_filter.c>
	 #add content typing
	AddType application/x-gzip .gz .tgz
	AddEncoding x-gzip .gz .tgz

	# Insert filters
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/xml
	AddOutputFilterByType DEFLATE text/css
	AddOutputFilterByType DEFLATE application/xml
	AddOutputFilterByType DEFLATE application/xhtml+xml
	AddOutputFilterByType DEFLATE application/rss+xml
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript
	AddOutputFilterByType DEFLATE application/x-httpd-php
	AddOutputFilterByType DEFLATE application/x-httpd-fastphp
	AddOutputFilterByType DEFLATE image/svg+xml

	# Drop problematic browsers
	BrowserMatch ^Mozilla/4 gzip-only-text/html
	BrowserMatch ^Mozilla/4\.0[678] no-gzip
	BrowserMatch \bMSI[E] !no-gzip !gzip-only-text/html

	# Make sure proxies don\'t deliver the wrong content
	Header append Vary User-Agent env=!dont-vary
  </IfModule>
</IfModule>

<IfModule !mod_deflate.c>
    #Apache deflate module is not defined, active the page compression through PHP ob_gzhandler
    php_flag output_buffering On
    php_value output_handler ob_gzhandler
</IfModule>
# END GZIP COMPRESSION
';
	return $my_contentgzip . $rules;
}

add_action( 'after_setup_theme', 'way2enjoy_other_gzip' );



function way2enjoy_other_gzip() {
     global $wp_customize;
//    if(!isset( $wp_customize ) && !is_admin()  ) {
		 
		 
     if(!isset( $wp_customize ) && (!get_site_option('way2-htaccess-enabled') && get_option('way2-gzip-enabled')) && !is_admin() ) {

 
          if (!in_array('ob_gzhandler', ob_list_handlers())) {
		ob_start('ob_gzhandler');
	    } else {
	ob_start();
	    }
    }

//die();	

}



// temprorary disabled as it was overwritting .htaccess if begin wordpress and end wordpres was mentioned in wordpress
add_action( 'wp_ajax_way_enable_lbc', 'way_enable_lbc');
function way_enable_lbc() {
		if(strtolower($_SERVER['SERVER_SOFTWARE']) == 'apache') {	
	     if(!get_site_option('way2-lbc-enabled') ) {

			update_site_option( 'way2-lbc-enabled', 1 );

			add_filter('mod_rewrite_rules', 'way2enjoy_lbcdata');
			save_mod_rewrite_rules();
		 }
		 else
		 
		 {
//noting to do 
			 
		 }

echo '

    Leverage browser caching enabled
    ▬▬▬▬▬▬▬▬▬ஜ۩۞۩ஜ▬▬▬▬▬▬▬▬▬
	 • Contact us if you faced any issue 
    • bydbest@gmail.com
    • Check with GTmetrixa
    • If Plugin is uninstalled, this may not work

 '; 
		} 
		
else
{
	
echo 'Your server is not Apache so it cant be enabled by our software.Contact our experts.They will do for you';	
	
}
	die();			

	}

function way2enjoy_lbcdata($rules22) {
	$my_contentlbc = <<<EOD
\n # BEGIN way2enjoy Leverage browser caching Content
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/x-icon A2419200
ExpiresByType image/gif A6048000
ExpiresByType image/png A6048000
ExpiresByType image/jpeg A6048000
ExpiresByType text/css A6048000
ExpiresByType application/x-javascript A6048000
ExpiresByType text/plain A6048000
ExpiresByType text/x-javascript A6048000
ExpiresByType application/javascript A6048000
ExpiresByType application/x-shockwave-flash A604800
ExpiresByType application/pdf A6048000
ExpiresByType text/html A900000
</IfModule>
# END way2enjoy Leverage browser caching Content\n
EOD;
return $my_contentlbc . $rules22;
}

wp_register_script('way2enjoy-js', plugins_url( '/js/dist/way2enjoy11.min.js', __FILE__ ), array( 'jquery' ) );
wp_register_script('way2enjoy-js9', plugins_url( '/js/dist/way2enjoy.misc5.js', __FILE__ ), array( 'jquery' ) );

//wp_register_script('way2enjoy-js2', plugins_url( '/js/dist/ajaxcheck3.js', __FILE__ ), array( 'jquery' ) );


		function localize() {
		$handle = 'way2enjoy-js';
  		$handle2 = 'way2enjoy-js9';
//	$settings = $this->way2enjoy_settings;
	
//	if ( !isset( $this->way2enjoy_settings["total_thumb"] ) ) {
//				$this->way2enjoy_settings["total_thumb"] = 6;
//			}
//	
//$thumbcnt=$settings['total_thumb']  > 0 ? $settings['total_thumb'] : "6";
	$optionstotlu = get_site_option( '_way2enjoy_options' );
	$setting_txt135 = __( ".", "way2enjoy-compress-images" );
	$setting_txt4 = __( 'Balance', 'way2enjoy-compress-images' );	
	$setting_txt148 = __( 'Optimizing...', 'way2enjoy-compress-images' );	

  $thumbcnt=$optionstotlu['total_thumb']  > 0 ? $optionstotlu['total_thumb'] : "6";
    $oldimg=$optionstotlu['old_img']  > 0 ? $optionstotlu['old_img'] : "550";

  $finalcount=$thumbcnt+1;
$setting_txt99 = __( "Buy", "way2enjoy-compress-images" );	
			$wp_way2_msgs = array(
				'bulkc'                 => esc_html__( 'Bulk Compression', 'way2enjoy-compress-images' ),
				'nameuu'               => esc_html__( 'Name', 'way2enjoy-compress-images' ),
				'original_sz'           => esc_html__( 'Original Size', 'way2enjoy-compress-images' ),
				'way2enjoy_st'           => esc_html__( 'Way2enjoy Stats', 'way2enjoy-compress-images' ),
				'comp_all'                 => esc_html__( "Compress All", "way2enjoy-compress-images" ),
				'doneuu'                => esc_html__( "Done", "way2enjoy-compress-images" ),
				'opti_mode'                => esc_html__( "Optimization mode", "way2enjoy-compress-images" ),
				'way2_lossy'        => esc_html__( "Way2enjoy Lossy", "way2enjoy-compress-images" ),
				'loss_less'      => esc_html__( "Lossless", "way2enjoy-compress-images" ),
				'opti_mess'      => esc_html__( "Images will be optimized by Way2enjoy Image compressor", "way2enjoy-compress-images" ),
				'call_bk'      => esc_html__( "Callback was already called", "way2enjoy-compress-images" ),
				'failed_h'      => esc_html__( "Failed! Hover here", "way2enjoy-compress-images" ),
				'img_opz'      => esc_html__( "Image optimized", "way2enjoy-compress-images" ),
				'ret_req'      => esc_html__( "Retry request", "way2enjoy-compress-images" ),
				'any_fur'      => esc_html__( "This image can not be optimized any further", "way2enjoy-compress-images" ),
				'rt_us'      => esc_html__( "Rate Us", "way2enjoy-compress-images" ),		
				'thumb_countss'      => esc_html__( "*$finalcount", "way2enjoy-compress-images" ),		
				'no_svng'      => esc_html__( "No savings found or quota exceeded", "way2enjoy-compress-images" )	,	
				'shw_dtls'      => esc_html__( "Show Details", "way2enjoy-compress-images" )	,	
				'hide_dtls'      => esc_html__( "Hide Details", "way2enjoy-compress-images" )	,
				'rate_msg'      => esc_html__( "We've spent countless hours developing this free plugin for you, and we would really appreciate it if you dropped us a quick rating!", "way2enjoy-compress-images" )		,
				'balance_dtls'      => esc_html__( "$setting_txt135", "way2enjoy-compress-images" )	,
				'quotabal_dtls'      => esc_html__( "$setting_txt4", "way2enjoy-compress-images" )	,
				'buy_msg'      => esc_html__( "$setting_txt99", "way2enjoy-compress-images" )	,
				'optimizing_img'      => esc_html__( "$setting_txt148", "way2enjoy-compress-images" )	,
'all_meta_reset_way2'      => esc_html__( "This will immediately remove all Way2enjoy metadata associated with your images. \n\nAre you sure you want to do this?", "way2enjoy-compress-images" )	,
				'reset_way2_wait'      => esc_html__( "Resetting images, pleaes wait...", "way2enjoy-compress-images" )	,

						);

			wp_localize_script( $handle, 'wp_way2_msgs', $wp_way2_msgs );
			wp_localize_script( $handle2, 'wp_way2_msgs', $wp_way2_msgs );

//wp_enqueue_script( 'way2enjoy-js' );

			//Check if settings were changed for a multisite, and localize whether to run re-check on page load
			

		}


function my_update_notice_way2enjoy() {
			$setting_txt81 = __( 'Rate Us', 'way2enjoy-compress-images' );	

    ?>
    <div class="way2enjoy notice notice-warn is-dismissible">
        <p><?php 
$setting_txt135 = __( "--", "way2enjoy-compress-images" );	
$setting_txt24 = __( 'Lossless', 'way2enjoy-compress-images' );
$setting_txt23 = __( 'Way2enjoy Lossy', 'way2enjoy-compress-images' );
$setting_txt74 = __( 'Savings on', 'way2enjoy-compress-images' );	

		
		echo 'Starting Optimization...'.$setting_txt135.'  Whitelist our IP:104.250.147.130';
_e( '<a href="https://wordpress.org/support/plugin/way2enjoy-compress-images/reviews/?filter=5" target="_blank">&#128077; '.$setting_txt81.' Please.&#128591;</a>  <a href="https://wordpress.org/support/plugin/way2enjoy-compress-images/" target="_blank">Report bug get 5000 credit &nbsp;</a> <a href="#popup2">Refer/Share in FB/Twitter get 5000 credit</a>', 'way2enjoy-compress-images' ); 	
		
		?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'buy_notice_way2enjoy' );
function buy_notice_way2enjoy() {
$setting_txt142= __( 'We\'ve spent countless hours developing this free plugin for you, and we would really appreciate it if you dropped us a quick rating!', 'way2enjoy-compress-images' );	
$setting_txt81 = __( 'Rate Us', 'way2enjoy-compress-images' );	
$setting_txt106 = __( "Translate", "way2enjoy-compress-images" );	
$optionsuuu = get_site_option( '_way2enjoy_options' );
//$widthhu=$optionsuuu['resize_width'];
//$oldimguu=$optionsuuu['old_img'];
$oldimguu=$optionsuuu['old_img']  > 0 ? $optionsuuu['old_img'] : "550";
$widthhu=$optionsuuu['resize_width']  > 0 ? $optionsuuu['resize_width'] : "3000";
if(@$optionsuuu['notice_s']!='')
{
	$notice_secds=@$optionsuuu['notice_s'].'000';
}
else

{
$notice_secds='8888010';	
}
//	$notice_secds=$optionsuuu['notice_s']  != '' ? $optionsuuu['notice_s'] : "500";
//$notice_se2='';
//if($notice_secds!='' ){$notice_se2=$notice_secds;}else{$notice_se2='5000';}

$randdddd= rand(1,5000);

$savedetailss = get_site_option( 'way2enjoy_global_stats' ) ;
//$remainnn=$statusbuy['quota_remaining'] ;
$remainnn=$savedetailss['quota_remaining'] ;

//$jhii='99';
//if($remainnn<='0' && get_site_option( 'wp-way2enjoy-hide_way2enjoy_welcome' ) =='1' )
//check for correct email address
echo'<style>.wp-way2enjoy-rate-welcome {
	display: inline-block;
    width: 48px;
    height: 52px;
	background-color: #fff;
    background-image: url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAAxCAMAAAC4V5rkAAACQ1BMVEVHcEweTXgeTXgAAAAeTXgeTXgdTHZ8cHAVN1UAAAAdTXgeTXj3yasbRWseTXj2w6D3yaoAAAAAAAAeTXgeTXgdTXgdTXgdTHYdTXgdTHfhtJf2xaQAAAAAAAEAAAAAAAAdTXgeTXj3yarvuJH1wqAxXIP2wqD2wJsAAQEAAAAAAAAAAAAAAAAAAAAAAAAeFhMeTXgdTXgdTHceTXgdTHf2xaMdTHf1vpn3x6f2wp/2xaMAAAAAAAAAAAAAAAAAAAAdTHceTXgAAAAeTXgeTXj3xqb3x6b3yKgAAAAAAAAAAAAAAAAAAAAeTHgAAAAAAAAeTXgAAADCqZvFpZH2xaT3yKn3yKkAAAAAAAAAAAHUsZtSaYJRaYOilZEeTXhEa472x6itjHX89vLI0dpxWUr318Kywc/z8O/2yKn2x6f2x6gAAAAeTXj3yqz5waj6vKfvwqQHBQT3yav4xqoMCQj2w6j1yKr8+/oTDgvYrZI1KiI/MSj4zrP+/v7etJjqv6JrVUbkgW7Cztn65dZZRjqLb11NPTLHoYfQqI1zXEy5i3nluZ16X1DZW03RPTTOMirvq5H0v6LX1NMZEg3Pf0jDnoSFnrXq7vHmu5/zuZyDZVXht5u0lYHVTEHAk4D418Gef2rnnHmZdWUgT3mhtMby6uQlU3y1s7N9ZFOhgGvmpnyga2VnRDrdlWXFZCeCUU5lYmLfv7GQc2Cri3fnknztpIv47OVdUk/NkWrY4OfEWRC7gl00GAZfOCyRorJPc5RlhaIKIDS7AAAAa3RSTlMAlePv/fMLAgT9noX6EPlI7eknjLtzph5kKiKQ9QloF97r9AgQ+0ErEt3WNEefkv2uRFTWP2xaGs9Scom7YiohIzqryzOjq+sdT3t1yRelzH2A8/aB4eN4Vm5g+f2HyY/D48WTr3TZ0d21131U2CMAAAP2SURBVEjHlZb3exJJGMcXBAZCCyUFSAyhmt57MaaIepbTR73e+zGzLj1AeqJJTO/qE7uPXj+v9/Kn3cwu4CYXlvX7yw6z89n3fb/zzjxQVFYpe3tquytKVIaaE5R4HXm5xqDyp1RxVCxmrDX4+eouFRetq8S/V6oXxHBVlen1gQxZcjI3d/JQZnniWmZo6M3FVT/j/OGxRGZ8OkeZRr4ryWi8LvPjlCAHunlcYCuItoYzZZYJJqrigfPMxFVmqy6Q5Ew6LwT287gEE40yUXTjs5ld1qRKpUCmPGeScfrO9QjCujHLzJDNNGYHyzhmOOz3P5hb/OvPjQeI0xzJtkegZ1ju6lg8ubEQ/WPz919/WWC5SCSJ57sEaqwguxdHaPwWQ0fub/68/gPh4l99eQu/qBEAu9iIZDFNh2h65O44Ht78ZvPptzjXWgHwBHFneA6NYPIKFpvoF18z313HnXBYaD9eYs1ZXN8NohB95WaQgCE6FIokBF2lqNJzXJcOj0UZhJZ+XMMgCU3P+E8rhQ9VaivnF75HaHLp9srtpclIKIjmhTPFOsx1XfjzBEJrK/dXJ1cmScITFbluAeUpjgwExhBaXV5e/gljwTt11TlPMuhJZbtLtn51DQXHZyfCoi4P41n20rmHIzGz9xavbeAOLz3gVOk9XhcAgD+lrT7f3/8OGp8Ip1r+laoDvGnRXPqkXePQ758/jt7PnBaVaj9o81DA6rmYj5CNF1Np0VLgbYfzaE36pqs8QuZdLpfV62FDdPg6Oy9rEMpvd7RkSEWhXPreuxr0gQtU1Z47pFIZzrKXud7naz/+qaOFjNuGfAhpPrZZnUOaV1O9oSyEcHt0GqGRj95qVSjLjL1l7DeBDQe4qPcCymMjqL7D68RP64XXJBxZACGcYsHYo4f1mU4DLY52HCV4qbPT18EvF8cpIM9jcghlU6OxETQ9uuOWqVMVKN/QDDnbbLiuYP6QlQ8O6qDuGN6KJgh1xR8+ik3fje385oayYu61+vULZLnT26Fv29cyOGSTFuTheK197odTsfXRbbcUf6WRvC2GUAKydEwfzlFSLMMZg1YI/4092XHbLZiUN7D5mxVZew27IpVDmQlQlnL4eOrJNpQqLDjz8sEiOxzQCpwMM/ZTZiI+NkvhP38/hvW4ZokO2s1QWiTU3mfMsvICzv9mnDe3GjS/mS40uxTNfemhGoNNXBhtoSwPiP7/gG3EIRtZQNGqEM2BegJCXZ6Wej416CAnu+W5uDN2mJawn/s3ph4+k1l8gdSLMh4I1aItbZDzOdzzIskiKdwrnUmUt8AM/6eBQRFgIzxA5IjkkkQ+UJhHJMEymUxqooK92/kff8aaMZjB6fUAAAAASUVORK5CYII=\');
    background-repeat: no-repeat;
    background-position: 50% 50%;
}</style>';


$admineml=get_bloginfo('admin_email');
$apikeypp=$optionsuuu['api_key'] ;

$setting_txt24 = __( 'Lossless', 'way2enjoy-compress-images' );
$setting_txt23 = __( 'Way2enjoy Lossy', 'way2enjoy-compress-images' );

$hidetime = get_site_option( 'hide_way2enjoy_buy' ) ;
$presentime= time();
$differencetime=$presentime-$hidetime;
if($remainnn<='0' && $remainnn!='')	
{
if($differencetime>='0')
{
//if($jhii<='199')	

$setting_txt117 = __( "You have consumed your monthly quota. buy additional credit for optimizing more images. For current  status Click me Please and then Refresh 1 times", "way2enjoy-compress-images" );	
//$setting_txt136 = __( "Lossless Optimization has started with 1MB limitation.Untick Automatically optimize uploads temporarily if you dont like Lossless. Prefer Lossy for getting more saving ", "way2enjoy-compress-images" );	

    ?>
 <script>jQuery(document).on( 'click', '#noticehide_way2enjoy-22 .notice-dismiss', function() {jQuery.ajax({url: ajaxurl,data: {action: 'dismiss_buy_notice_way2enjoy'
        }});});</script> <div class="notice notice-error is-dismissible" id="noticehide_way2enjoy">

<!--    <div class="notice notice-warn is-dismissible" id="noticehide">
-->       
<!--<div class="way2enjoy error notice-warn is-dismissible" id="noticehide">
--> 

<p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '"><b>'.$setting_txt117.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}}

$hiderate2 = get_site_option( 'rate_way2enjoy' ) ;
if($hiderate!='')
{
$hiderate=$hiderate2 ;	
}
else{
$hiderate=time()+500000 ;		
}
$difftimerate=time()-$hiderate;

if($difftimerate>='0')
{
// update_site_option( 'rate_way2enjoy', $presentime );	

    ?>
      <script>jQuery(document).on( 'click', '#ratehideuu_way2enjoy', function() {jQuery.ajax({url: ajaxurl,data: {action: 'dismiss_rate_notice_way2enjoy'
        }});});</script>  <div class="notice notice-success is-dismissible" id="ratehideuu_way2enjoy">

<p><?php 
_e( '<span class="wp-way2enjoy-rate-welcome"></span><a style="text-decoration: none;color: #19B4CF" href="https://wordpress.org/support/plugin/way2enjoy-compress-images/reviews/?filter=5" target="_blank"><b>&#128591;'.$setting_txt81.' &#128591;'.$setting_txt142.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}

if($randdddd =='999' && $widthhu >= '1510')	

//if($jhii<='199')	

{
$setting_txt118 = __( "Hey! Do you really need this much big images?? change the width & height in setting page. Click on reset all images and all images will appear again in dashboard. Please note that all images will be compressed again and it will count again.So be careful.If you have lot of big images you can save lot & make your site very fast. Current width is", "way2enjoy-compress-images" );	

    ?>
    <div class="notice notice-warn is-dismissible">
 <p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '"><b>'.$setting_txt118.' - '.$widthhu.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}



if($apikeypp!=$admineml && $remainnn!='')

//if($jhii<='199')	

{
$setting_txt130 = __( "Hey Your email has been changed.Please update new email in our dashboard." );	

    ?>
    <div class="notice notice-warn is-dismissible">
 <p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php?page=wp-way2enjoy#popup6' ) . '" id="kuchbhi6"><b>'.$setting_txt130.' </b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}







if($randdddd =='1999' && $oldimguu == '150')	

//if($jhii<='199')	

{
$setting_txt119 = __( "Hey! Do you know you can compress all your previously uploaded files. Change 550 to higher no in Optimize Old Images field", "way2enjoy-compress-images" );	
    ?>
    <div class="notice notice-warn is-dismissible">
       
 <p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '"><b>'.$setting_txt119.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}



if($randdddd =='2999')	

//if($jhii<='199')	

{
$setting_txt120 = __( "Hey! Do you know you can use way2enjoy image optimizer credit in all of your sites", "way2enjoy-compress-images" );	
    ?>
    <div class="notice notice-warn is-dismissible">
       
 <p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="' . admin_url( 'options-general.php?page=wp-way2enjoy' ) . '"><b>'.$setting_txt120.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}

if($randdddd =='4500')	
{
    ?>
    <div class="notice notice-warn is-dismissible">
       
 <p><?php 
_e( '<a style="text-decoration: none;color: #19B4CF" href="https://translate.wordpress.org/projects/wp-plugins/way2enjoy-compress-images" target="_blank"><b>'.$setting_txt106.'</b></a>&nbsp;&nbsp;&nbsp;', 'way2enjoy-compress-images' ); 	
		?></p>
    </div>
    <?php
}

$setting_txt105 = __( "Seconds", "way2enjoy-compress-images" );		


//$setting_txt131 = __( "All notices, warnings, alerts will be closed in", "way2enjoy-compress-images" );
if (stripos($_SERVER['REQUEST_URI'], 'editor.php') !== false)
{
$notice_remove='';	
}
else
{
$notice_remove='.error, .notice, .updated, .update-nag, .success, .info, .warning, .danger';	
	}


	
    ?>
 <script>jQuery(document).ready(function($) 
{	
setTimeout(function() {
$("<?php echo $notice_remove; ?>").trigger('click');
$('[class^="error"],[class^="notice"],[class^="updated"],[class^="update-nag"],[class^="success"],[class^="info"],[class^="warning"],[class^="danger"]').hide();
}, <?php 
//$notice_se2='';
//if($remainnn >='0' ){$notice_se2=$notice_secds;}else{$notice_se2='5000';}
echo $notice_secds;?>);
});

</script>
   
    <?php



}
define ('SC_FILE' , __FILE__);
define ('SC_DIR',dirname(__FILE__));
define ('SC_URL',plugins_url(plugin_basename(dirname(__FILE__))));

add_action('init', 'tway2_way2_lib_init', 9);


function tway2_way2_lib_init() {
  if (!isset($_REQUEST['ajax'])) {
    if (!class_exists("Way2enjoyweb")) {
      require_once(SC_DIR . '/way/start.php');
    }
    global $tway2_options;
    $tway2_options = array(
   
      "plugin_dir" => SC_DIR,
      "plugin_main_file" => __FILE__, 
      "deactivate" => true,
    );
    way_web_init($tway2_options);
  }
}


function way2enjoy_get_directory_list()
{
	
$setting_txt71 = __( 'Saved', 'way2enjoy-compress-images' );	
$setting_txt52 = __( 'Save', 'way2enjoy-compress-images' );	
	
	
//$root = $_SERVER['DOCUMENT_ROOT'];
//if( !$root ) exit("ERROR: Root filesystem directory not set in jqueryFileTree.php");

//$postDir = rawurldecode($root.(isset($_POST['dir']) ? $_POST['dir'] : null ));
//	$postDir = rawurldecode($root.'/wp-content/');








//	$root = realpath( $this->get_root_path() );
 
	$root = realpath( get_root_path() );
//	$root = realpath( get_root_path() ).'/';

		$dir     = isset( $_GET['dir'] ) ? ltrim( $_GET['dir'], '/' ) : null;

            $postDir = strlen( $dir ) > 1 ? path_join( $root, $dir ) : $root . $dir;
			$postDir = realpath( rawurldecode( $postDir ) );


//echo  $root;





// set checkbox if multiSelect set to true
$checkbox = ( isset($_POST['multiSelect']) && $_POST['multiSelect'] == 'true' ) ? "<input type='checkbox' />" : null;
$onlyFolders = ( isset($_POST['onlyFolders']) && $_POST['onlyFolders'] == 'true' ) ? true : false;
$onlyFiles = ( isset($_POST['onlyFiles']) && $_POST['onlyFiles'] == 'true' ) ? true : false;
//echo 'helloooopp';
//echo $root;
$supported_image = array(
				'gif',
				'jpg',
				'jpeg',
				'png'
			);

	$list = '';


if( file_exists($postDir) ) {

	$files		= scandir($postDir);
	$returnDir	= substr($postDir, strlen($root));

$fullpath=$root.'/'.$returnDir;


	natcasesort($files);
//echo $postDir;
	if( count($files) > 2 ) { // The 2 accounts for . and ..
//		echo "<ul class='jqueryFileTree'>";
$list = "<ul class='jqueryFileTree'>";

		foreach( $files as $file ) {


		//	$htmlRel	= htmlentities($returnDir . $file,ENT_QUOTES);
			$htmlRel	= htmlentities($returnDir .'/'. $file,ENT_QUOTES);

			$htmlName	= htmlentities($file);
			$ext		= preg_replace('/^.*\./', '', $file);
$filenamwithpath=$postDir.$file;


$file_path = path_join( $postDir, $file );


if ( file_exists( $file_path ) && $file != '.' && $file != '..' ) {

//	if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {
//					if( file_exists($filenamwithpath) && $file != '.' && $file != '..' ) {
			//		if( $file != '.' && $file != '..' ) {

			//	if( file_exists($ . $file)) {
	
		
	//		echo '6777';
//		if( is_dir($postDir . $file) && (!$onlyFiles || $onlyFolders) )
		//		if( is_dir($file_path) && (!$onlyFiles || $onlyFolders) )
		
//			if ( is_dir( $file_path ) && ! $this->skip_dir( $file_path ) ) {
	//		if ( is_dir( $file_path ) && ! skip_dir( $file_path ) ) {
			if ( is_dir( $file_path )) {
	
			//		echo "<li class='directory collapsed'>{$checkbox}<a rel='" .$htmlRel. "/'>" . $htmlName . "</a></li>";

$list .= "<li class='directory collapsed'>{$checkbox}<a rel='" .$htmlRel. "/'>" . $htmlName . "</a>
<input type='hidden' id='directorysub' name='directorysub' value='" .$htmlRel. "/' />


</li><br />";



		//		else if (!$onlyFolders || $onlyFiles)
//					}else if ( in_array( $ext, $supported_image ) && ! $this->is_media_library_file( $file_path ) ) {
       //       else if ( in_array( $ext, $supported_image ) && ! is_media_library_file( $filenamwithpath ) ) 
								
								update_site_option( 'wp-way2enjoy-dir_path', $fullpath, false );
								update_site_option( 'wp-way2enjoy-dir_update_time', time(), false );

					
					}
				else if ( in_array( $ext, $supported_image ) && ! is_media_library_file( $file_path ) ) {

		//   else if ( in_array( $ext, $supported_image )) {
//echo '999999';

		//			echo "<li class='file ext_{$ext}'>{$checkbox}<a rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
	$list .= "<li class='file ext_{$ext}'>{$checkbox}<a rel='" . $htmlRel . "'>" . $htmlName . "</a></li><br />";
				
					
					}
	
					
			}
		}

//		echo "</ul>";
	$list .= "</ul>";

	}
}

echo $list;
			die();
}





function get_root_path() {
			if ( is_main_site() ) {

				return rtrim( get_home_path(), '/' );
			} else {	
				$up = wp_upload_dir();

				return $up['basedir'];
			}
		}






function is_media_library_file( $file_path ) {
			$upload_dir  = wp_upload_dir();
			$upload_path = $upload_dir["path"];

			//Get the base path of file
			$base_dir = dirname( $file_path );
			if ( $base_dir == $upload_path ) {
				return true;
			}

			return false;
		}


	function skip_dir( $path ) {

			//Admin Directory path
	//		$admin_dir = $this->get_admin_path();

			//Includes directory path
			$includes_dir = ABSPATH . WPINC;

			//Upload Directory
			$upload_dir = wp_upload_dir();
			$base_dir   = $upload_dir["basedir"];

			$skip = false;

			//Skip sites folder for Multisite
			if ( false !== strpos( $path, $base_dir . '/sites' ) ) {
				$skip = true;
			} else if ( false !== strpos( $path, $base_dir ) ) {
				//If matches the current upload path
				//contains one of the year subfolders of the media library
				$pathArr = explode( '/', str_replace( $base_dir . '/', "", $path ) );
				if ( count( $pathArr ) >= 1
				     && is_numeric( $pathArr[0] ) && $pathArr[0] > 1900 && $pathArr[0] < 2100 //contains the year subfolder
				     && ( count( $pathArr ) == 1 //if there is another subfolder then it's the month subfolder
				          || ( is_numeric( $pathArr[1] ) && $pathArr[1] > 0 && $pathArr[1] < 13 ) )
				) {
					$skip = true;
				}
			} elseif ( ( false !== strpos( $path, $admin_dir ) ) || false !== strpos( $path, $includes_dir ) ) {
				$skip = true;
			}

			/**
			 * Can be used to skip/include folders matching a specific directory path
			 *
			 */
			apply_filters( 'way2enjoy_skip_folder', $skip, $path );

			return $skip;
		}
		
		
		
function way2enjoy_save_directory_list()
{
	$setting_txt53 = __( 'Compress All', 'way2enjoy-compress-images' );
 $direcscan= time()- get_site_option('wp-way2enjoy-dir_update_time');
if($direcscan<='200')
{
//get_image_list('/home/garamtea/wp.garamtea.com/wp-content/gallery/kjuuuuuui/');

$direcpath=get_site_option('wp-way2enjoy-dir_path');
if($direcpath!='')
{
get_image_list($direcpath);
}

}
echo 'Just Click on '.$setting_txt53.'' ;
	die();

}
		
		function create_table() {
			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			//Use a lower index size
			$path_index_size = 191;
			
			/**
			 * Table: wp_way2enjoy_dir_images
			 * Columns:
			 * id -> Auto Increment ID
			 * path -> Absolute path to the image file
			 * resize -> Whether the image was resized or not
			 * lossy -> Whether the image was lossy or not
			 * image_size -> Current image size post optimisation
			 * orig_size -> Original image size before optimisation
			 * file_time -> Unix time for the file creation, to match it against the current creation time,
			 *                  in order to confirm if it is optimised or not
			 * last_scan -> Timestamp, Get images form last scan by latest timestamp
			 *                  are from latest scan only and not the whole list from db
			 * meta -> For any future use
			 *
			 */
			
		$sql = "CREATE TABLE {$wpdb->prefix}way2enjoy_dir_images (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				path text NOT NULL,
				resize varchar(55),
				lossy varchar(55),
				error varchar(55) DEFAULT NULL,
				image_size int(10) unsigned,
				orig_size int(10) unsigned,
				file_time int(10) unsigned,
				last_scan timestamp DEFAULT '0000-00-00 00:00:00',
				meta text,
				UNIQUE KEY id (id),
				UNIQUE KEY path (path($path_index_size)),
				KEY image_size (image_size)
			) $charset_collate;";

			// include the upgrade library to initialize a table
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		/**
		 * Get the image ids and path for last scanned images
		 *
		 * @return array Array of last scanned images containing image id and path
		 */
		function get_scanned_images() {
			global $wpdb;

			$query = "SELECT id, path, orig_size FROM {$wpdb->prefix}way2enjoy_dir_images WHERE last_scan = (SELECT MAX(last_scan) FROM {$wpdb->prefix}way2enjoy_dir_images )  GROUP BY id ORDER BY id";

			$results = $wpdb->get_results( $query, ARRAY_A );

			//Return image ids
			if ( is_wp_error( $results ) ) {
				error_log( sprintf( "Way2enjoy Query Error in %s at %s: %s", __FILE__, __LINE__, $results->get_error_message() ) );
				$results = array();
			}

			return $results;
		}

			
			function get_image_list( $path = '' ) {
			global $wpdb;

		$base_dir = empty( $path ) ? ltrim( $_GET['path'], '/' ) : $path;
		$base_dir = realpath( rawurldecode( $base_dir ) );
//$base_dir = '/home/garamtea/wp.garamtea.com/wp-content/gallery/kjuuuuuui/';
		//	if ( !$base_dir ) {
//				wp_send_json_error( "Unauthorized" );
//			}
//
//			//Store the path in option
	//		update_site_option( 'wp-way2enjoy-dir_path', $base_dir, false );

			//Directory Iterator, Exclude . and ..
			$dirIterator = new RecursiveDirectoryIterator(
				$base_dir
			//PHP 5.2 compatibility
			//RecursiveDirectoryIterator::SKIP_DOTS
			);

			$filtered_dir = new WPSmushRecursiveFilterIterator( $dirIterator );

			//File Iterator
			$iterator = new RecursiveIteratorIterator( $filtered_dir,
				RecursiveIteratorIterator::CHILD_FIRST
			);

			//Iterate over the file List
			$files_arr = array();
			$images    = array();
			$count     = 0;
//			$timestamp = gmdate( 'Y-m-d H:i:s' );
			$timestamp = '';
			$values = array();
			//Temporary Increase the limit
//			@ini_set('memory_limit','256M');
			@ini_set('memory_limit','512M');

			foreach ( $iterator as $path ) {

				//Used in place of Skip Dots, For php 5.2 compatability
				if ( basename( $path ) == '..' || basename( $path ) == '.' ) {
					continue;
				}
				if ( $path->isFile() ) {
					$file_path = $path->getPathname();
					$file_name = $path->getFilename();

//					if ( $this->is_image( $file_path ) && ! $this->is_media_library_file( $file_path ) && strpos( $path, '.bak' ) === false ) {
					if ( is_image( $file_path ) && ! is_media_library_file( $file_path ) && strpos( $path, '.bak' ) === false ) {

						/**  To generate Markup **/
						$dir_name = dirname( $file_path );

						//Initialize if dirname doesn't exists in array already
						if ( ! isset( $files_arr[ $dir_name ] ) ) {
							$files_arr[ $dir_name ] = array();
						}
						$files_arr[ $dir_name ][ $file_name ] = $file_path;
						/** End */

//echo $file_path.'<br /><br />';
						//Get the file modification time
//						$file_time = @filectime( $file_path );
						$file_time = '0';

						/** To be stored in DB, Part of code inspired from Ewwww Optimiser  */
						$image_size = $path->getSize();
						$images []  = $file_path;
						$images []  = $image_size;
						$images []  = $file_time;
						$images []  = $timestamp;
						$values[]   = '(%s, %d, %d, %s)';
						$count ++;
					}
				}
//echo $image_size.'<br /><br />';

				//Store the Images in db at an interval of 5k
				if ( $count >= 5000 ) {
					$count  = 0;
//					$query  = $this->build_query1( $values, $images );
					$query  = build_query1( $values, $images );

					$images = $values = array();
					$wpdb->query( $query );
					
//					echo $wpdb->query( $query ).'<br /><br />';

				}
			}

			//Update rest of the images
			if ( ! empty( $images ) && $count > 0 ) {
//				$query = $this->build_query1( $values, $images );
				$query = build_query1( $values, $images );

				$wpdb->query( $query );
				
						//		echo $wpdb->query( $query ).'<br /><br />';

			//	echo $query;
			}

			return array( 'files_arr' => $files_arr, 'base_dir' => $base_dir, 'image_items' => $images );
		}

		/**
		 * Build and prepare query from the given values and image array
		 *
		 * @param $values
		 * @param $images
		 *
		 * @return bool|string|void
		 */
		function build_query1( $values, $images ) {

			if ( empty( $images ) || empty( $values ) ) {
				return false;
			}

			global $wpdb;
			$values = implode( ',', $values );

			//Replace with image path and respective parameters
//			$query = "INSERT INTO {$wpdb->prefix}way2enjoy_dir_images (path,orig_size,file_time,last_scan) VALUES $values ON DUPLICATE KEY UPDATE image_size = IF( file_time < VALUES(file_time), NULL, image_size ), file_time = IF( file_time < VALUES(file_time), VALUES(file_time), file_time ), last_scan = VALUES( last_scan )";

			$query = "INSERT INTO {$wpdb->prefix}way2enjoy_dir_images (path,orig_size,file_time,last_scan) VALUES $values";

			$query = $wpdb->prepare( $query, $images );

			return $query;

		}
	
		
		
		function is_image( $path ) {

			//Check if the path is valid
//			if ( ! file_exists( $path ) || ! $this->is_image_from_extension( $path ) ) {
				if ( ! file_exists( $path ) || ! is_image_from_extension( $path ) ) {

				return false;
			}

			$a = @getimagesize( $path );

			//If a is not set
			if ( ! $a || empty( $a ) ) {
				return false;
			}

			$image_type = $a[2];

			if ( in_array( $image_type, array( IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG ) ) ) {
				return true;
			}

			return false;
		}
		
		
		
		function is_image_from_extension( $path ) {
			$supported_image = array(
				'gif',
				'jpg',
				'jpeg',
				'png'
			);
			$ext             = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) ); // Using strtolower to overcome case sensitive
			if ( in_array( $ext, $supported_image ) ) {
				return true;
			}

			return false;
		}	
		
		
		
		
		function image_list_way2enjoy() {

			//Check For Permission
		//	if ( ! current_user_can( 'manage_options' ) ) {
//				wp_send_json_error( "Unauthorized" );
//			}

			//Verify nonce
			check_ajax_referer( 'get_image_list', 'image_list_nonce' );

			//Check if directory path is set or not
		//	if ( empty( get_site_option ('wp-way2enjoy-dir_path')) ) {	
//		//		get_site_option['wp-way2enjoy-dir_path']
//				
//				wp_send_json_error( "Empth Directory Path" );
//			}

			//Get the File list
			$files = get_image_list( get_site_option ('wp-way2enjoy-dir_path') );

			//If files array is empty, send a message
			if ( empty( $files['files_arr'] ) ) {
//				$this->send_error();

			send_error();

			}

			//Get the markup from the list
//			$markup = $this->generate_markup( $files );

			$markup = generate_markup( $files );


			//Send response
			wp_send_json_success( $markup );

		}
		
		
		
		
		
	if ( class_exists( 'RecursiveFilterIterator' ) && ! class_exists( 'WPSmushRecursiveFilterIterator' ) ) {
	class WPSmushRecursiveFilterIterator extends RecursiveFilterIterator {

		public function accept() {
			$path = $this->current()->getPathname();
	return true;
		}

	}
}	
		
	

		
	function get_directory_image_path($id) {
			global $wpdb;

			$query   = $wpdb->prepare( "SELECT path FROM {$wpdb->prefix}way2enjoy_dir_images WHERE id='$id' LIMIT 1", 1 );
			$results = $wpdb->get_col( $query );

return $results['0'];

		}	
		
		
		function get_directory_image_orig_size($id) {
			global $wpdb;

			$query   = $wpdb->prepare( "SELECT orig_size FROM {$wpdb->prefix}way2enjoy_dir_images WHERE id='$id' LIMIT 1", 1 );
			$results = $wpdb->get_col( $query );

return $results['0'];

		}	
			
		
//
////add_shortcode( 'plugin_install_count', 'plugin_install_count_shortcode' );
//function futuredev() {
//	return '<p>Needs to be improved!</p>';
//}
//add_shortcode('futurework', 'futuredev');

//function more_mime_types($mimes) {

function more_mime_types($mimes = array()) {
$optionstotlu = @get_site_option( '_way2enjoy_options' );
if(@$optionstotlu['svgenable']=='1'){$mimes['svg'] = 'image/svg+xml';
$mimes['svgz'] = 'image/svg+xml';  return $mimes;}
else
{
		return $mimes;
}

}

 add_filter('upload_mimes', 'more_mime_types');







// async starts here

	define( 'WAY2ENJOY_ASYNC', true );

	/**
		 * Send JSON response whether to show or not the warning
		 */
		function show_warning_ajax() {
			$show = $this->show_warning();
			wp_send_json( intval( $show ) );
		}
 
function load_libs_way2enjoy() {
	 wp_way2enjoy_async();
		}

		function wp_way2enjoy_async() {

			//Don't load the Async task, if user not logged in or not in backend
			if ( ! is_user_logged_in() || ! is_admin() ) {
				return;
			}
			//Instantiate Class
			new WpWay2enjoyParallel();
			new WpWay2enjoyEditorParallel();
			
					}

new Wp_Way2enjoy();
