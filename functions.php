<?php

// Add Djbay API functionality.
require get_stylesheet_directory() . '/api/posts-generator.php';

// Add admin panel API menu
if(is_admin()){ 
    require get_stylesheet_directory() . '/admin/admin.php';
}



// Get post date meta
function twentyfourteen_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post">' . __( 'Sticky', 'twentyfourteen' ) . '</span>';
	}

	// Set up and print post meta information.
	printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'F j, Y' ) ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
}



function wbh_register_taxonomy($name, $label, $show){
	
	register_taxonomy($name, array('post'), array(
		'labels'                => array(
			'name'              => $label,
			'singular_name'     => $label,
			'search_items'      => 'Search ' . $label,
			'all_items'         => 'All ' . $label,
			'parent_item'       => 'Parent ' . $label,
			'parent_item_colon' => 'Parent ' . $label . ':',
			'edit_item'         => 'Edit ' . $label,
			'update_item'       => 'Update ' . $label,
			'add_new_item'      => 'Add New ' . $label,
			'new_item_name'     => 'New ' . $label . ' Name',
			'menu_name'         => $label,
		),
		'public'                => true,
		'show_in_menu'			=> $show,
		'show_in_nav_menus'		=> $show,
		'show_tagcloud'			=> $show,
		'show_in_rest'          => true, 
		'hierarchical'          => false,
		'rewrite'               => array( 'slug' => $name ),
		'meta_box_cb'           => 'post_tags_meta_box', 
		'show_admin_column'     => false,
		'show_in_quick_edit'    => null,
	) );
}


add_action('init', 'create_taxonomy');
function create_taxonomy(){

	wbh_register_taxonomy('release', 'Release', true);
	wbh_register_taxonomy('artists', 'Artists', true);
	wbh_register_taxonomy('label', 'Label', true);
	wbh_register_taxonomy('bpm', 'bpm', false);
	wbh_register_taxonomy('date', 'Track Date', false);
	wbh_register_taxonomy('imageurl', 'ImageURL', false);
	wbh_register_taxonomy('djbayurl', 'djbayURL', false);
	wbh_register_taxonomy('beatporturl', 'BeatportURL', false);
	wbh_register_taxonomy('trackurl', 'TrackURL', false);
	
}


add_action('admin_print_footer_scripts', 'my_action_javascript', 99);
function my_action_javascript() {
	?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		
		$('#generateBlog').click(function(){
			var data = {
				action: 'generate_posts',
				whatever: 1234,
				datestring: $('#datestring').val()
			};

			alert('Generate process run!!!');
			jQuery.post( ajaxurl, data, function(response) {
				
			});
		});
	});
	</script>
	<?php
}

add_action( 'wp_ajax_generate_posts', 'generate_posts_callback' );
add_action('wp_ajax_nopriv_generate_posts', 'generate_posts_callback');
function generate_posts_callback() {
	
	$datestring = $_POST['datestring'];
	$tracksArray = wbh_getDjbayTracks($datestring);
	$tracksArray = wbh_getDjbayTracks($datestring);

	wbh_postGenerator( $tracksArray );

	wp_die(); 

}


	function my_auto_action_javascript(){
		$ajax_url = admin_url('admin-ajax.php');
		?>
			<script type="text/javascript" >
				var data = {
					action: 'generate_posts',
					whatever: 1234
				};

				console.log('Generate process run!!!');
				jQuery.post( "<?php echo $ajax_url; ?>", data, function(response) {
					console.log('Generate process end!!!');
				});
			</script>
		<?php
	}


add_action('wp', 'wbh_interval_tracks_generator');

function wbh_interval_tracks_generator(){

	// $wbh_current_time = time();

	// if ( get_option( 'wbh_is_autoupload' ) ){

	// 	if( ( !get_option( 'wbh_next_time_generator', false ) ) || ( $wbh_current_time > intval( get_option( 'wbh_next_time_generator', false ) ) ) ){

	// 			$wbh_next_time = $wbh_current_time + 300;
	// 			update_option( 'wbh_next_time_generator', $wbh_next_time, false );
	// 			add_action('wp_print_footer_scripts', 'my_auto_action_javascript', 99);

	// 	}

	// } else if ( get_option( 'wbh_next_time_generator', false ) ){

	// 	delete_option( 'wbh_next_time_generator' );
	// }
}


function wbh_djbay_api_echo(){

	$encoded = wbh_getDjbayTracks();
	foreach ($encoded as $key => $value) {
		var_dump($value);
		echo '<hr><hr>' ;	
	}
}