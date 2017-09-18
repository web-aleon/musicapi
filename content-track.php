<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php
	$wbh_postid = get_the_ID();
	$wbh_bpm = get_the_terms( $wbh_postid, 'bpm' )[0]->name;
	$wbh_date = get_the_terms( $wbh_postid, 'date' )[0]->name;

	$wbh_imageurl = get_the_terms( $wbh_postid, 'imageurl' )[0]->name;
	if (!$wbh_imageurl){ wp_delete_post( $wbh_postid, true ); }

	$wbh_djbayurl = get_the_terms( $wbh_postid, 'djbayurl' )[0]->name;
	if (!$wbh_djbayurl){ $wbh_djbayurl = '#'; }

	$wbh_beatporturl = get_the_terms( $wbh_postid, 'beatporturl' )[0]->name;
	if (!$wbh_beatporturl){ $wbh_beatporturl = 'http://beatport.com/'; }

	$wbh_trackurl = get_the_terms( $wbh_postid, 'trackurl' )[0]->name;
	if (!$wbh_trackurl){ $wbh_trackurl = '#'; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php twentyfourteen_post_thumbnail(); ?>

	<header class="entry-header">
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && twentyfourteen_categorized_blog() ) : ?>
		<div class="entry-meta">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfourteen' ) ); ?></span>
		</div><!-- .entry-meta -->
		<?php
			endif;

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>

		<div class="entry-meta">
			<?php twentyfourteen_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<div class="entry-content">
        <p>
        	<a href="#"><img src="<?php echo $wbh_imageurl; ?>" alt="" width="300" height="300" class="aligncenter size-medium"></a>
        </p>
		<div class="information-musicapi">
			<table>
				<tbody>
					<tr>
						<td>Release</td>
						<td><?php echo get_the_term_list( $wbh_postid, 'release'); ?></td>
						<td>Date</td>
						<td class="date"><?php echo $wbh_date; ?></td>
					</tr>
					<tr>
						<td>Artists</td>
						<td><?php echo get_the_term_list( $wbh_postid, 'artists', '', ', ', ''); ?></td>
						<td>BPM</td>
						<td><?php echo $wbh_bpm; ?></td>
					</tr>
					<tr>
						<td>Label</td>
						<td><?php echo get_the_term_list( $wbh_postid, 'label'); ?></td>
						<td><!-- Length --></td>
						<td><!-- 6:54 --></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="preview-musicapi">
		<!--[if lt IE 9]><script>document.createElement('audio');</script><![endif]-->
			<!-- <p>PLAYER</p> -->
			
			<?php
				$audio_args = array(
					'src'      => $wbh_trackurl,
					'loop'     => '',
					'autoplay' => '',
					'preload'  => 'none'
				);

				echo wp_audio_shortcode( $audio_args );
			?>
		</div>
		
		<div class="purchase-musicapi">
			<div>
				<a href="<?php echo $wbh_beatporturl; ?>" class="button" target="_blank" rel="nofollow">Purchase at Beatport</a>
			</div>
			<div>
				<a href="<?php echo $wbh_djbayurl; ?>" class="button" rel="nofollow" target="_blank">Download</a>
			</div>
		</div>
		<h3></h3>
		<div class="socialshare-musicapi">
		
		<?php

			if ( is_single() ) {
				if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
			}
		?>

		</div>

	</div>

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->
