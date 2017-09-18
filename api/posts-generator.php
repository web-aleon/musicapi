<?php

require get_stylesheet_directory() . '/api/djbay.php';


function wbh_get_api_post_title($array){

	return implode(' - ', $array);

}

function wbh_get_category_ids($category_name){

	$categories = explode(", ", $category_name);

	for ($i = 0; $i < count($categories); $i++){
		$result[$i] = intval( wp_create_category($categories[$i]) );
	}

	return $result;

}

function wbh_get_api_post_slug($string_id){

	return 'id' . $string_id;

}

function wbh_get_api_post_tags($array){

	return implode(', ', $array);

}


function wbh_postGenerator($tracksArray){


		foreach ($tracksArray as $key => $value) {	

			$post_array = array(
				'post_title'	 => wbh_get_api_post_title( array( $value['track_author'], $value['track_name'] ) ),
				'post_content' 	 => 'simple content',
				'comment_status' =>  'closed',
				'ping_status'    =>  'closed',
				'post_author'    => 1,
				'post_category'  =>  wbh_get_category_ids( $value['track_genre'] ),
				'post_name'      =>  wbh_get_api_post_slug( $value['track_id'] ), 
				'post_status'    =>  'publish',
				'post_type'      =>  'post',
				'tags_input'     =>  wbh_get_api_post_tags( array( $value['track_author'], $value['release_name'], $value['track_label'] ) ) ,
				// 'tax_input'      =>  array(
				// 						'release'		=> array( $value['release_name'] ),
				// 						'artists'		=> explode( ", ", $value['track_author'] ),
				// 						'label'			=> array( $value['track_label'] ),
				// 						'bpm'			=> array( $value['bpm'] ),
				// 						'date'			=> array( $value['track_date'] ),
				// 						'imageurl'		=> array( $value['image_url'] ),
				// 						'beatporturl'	=> array( $value['beatport_url'] ),
				// 						'djbayurl'		=> array( $value['url']),
				// 						'trackurl'		=> array( $value['preview_audio_url'] )
				// 					) , 
			);

			echo($value['track_date'] . ' - ' . $post_array['post_title'] . ', id: ' . $post_array['post_name']);

			if( !get_page_by_path( $post_array['post_name'], OBJECT, 'post' ) ){
				$pid = wp_insert_post(wp_slash($post_array, true));
				wp_set_object_terms($pid, $value['image_url'], 'imageurl' , true);
				wp_set_object_terms($pid, $value['release_name'], 'release' , true);
				wp_set_object_terms($pid, explode( ", ", $value['track_author'] ), 'artists' , true);
				wp_set_object_terms($pid, $value['track_label'], 'label' , true);
				wp_set_object_terms($pid, strval($value['bpm']), 'bpm' , true);
				wp_set_object_terms($pid, $value['track_date'], 'date' , true);
				wp_set_object_terms($pid, $value['beatport_url'], 'beatporturl' , true);
				wp_set_object_terms($pid, $value['url'], 'djbayurl' , true);
				wp_set_object_terms($pid, $value['preview_audio_url'], 'trackurl' , true);
				echo(" - CREATED \n");
			} else { echo("\n"); }

		}


}

