<?php
 /*Template Name: New Template
 */
 
get_header(); ?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/twitch-custom/css/style-frontend.css" rel="stylesheet" />
    <div id="plugin-content">
    <?php 
	add_action( 'pre_get_posts', 'my_change_sort_order'); 
    function my_change_sort_order($query){
        if(is_archive()):
         //If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
           //Set the order ASC or DESC
           $query->set( 'order', 'ASC' ); 
           //Set the orderby
           $query->set( 'orderby', 'the' );
        endif;    
    };
	?>
<?php $i = 0; ?>

	<?php
    $mypost = array( 'post_type' => 'user_profile', );
    $loop = new WP_Query( $mypost );
	$streamChannel = "theshroomeyone";
	$url = "https://api.twitch.tv/kraken/streams?channel=" . $streamChannel; 
	$clientID = "83pbna0y3wzfai0iz6spegovgqkcsl";
	function file_get_contents_curl($url, $headers) {
		$ch = curl_init();
		curl_setopt_array($ch, [
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_AUTOREFERER => TRUE,
				CURLOPT_HEADER => FALSE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_FOLLOWLOCATION => TRUE
			]);
		$data = curl_exec($ch);
		curl_close($ch);
			return $data;
	}
    ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post();?>
<?php
if($i == 0) {
	echo '<div class="ng-row">';
}
?>
<div class="org-half">     
		<article id="post-<?php the_ID(); ?>">
                <article id="post-<?php the_ID(); ?>">
	<div class="card-<?php echo get_post_meta( get_the_ID(), 'user_level', true ); ?>">				
<div>
	<?$chan = get_post_meta($post->ID,'chan_name',true);?>

<?echo do_shortcode("[twitch-status channel=".$chan."]"); ?></div>
	<div><a href="<?php the_permalink(); ?>">View Profile</a></div>
	<div>
	<?
		$headers = [
			"Client-ID: " . $clientID
		];
	$data = file_get_contents_curl($url, $headers);
	$json_array = json_decode($data, true);
	if(isset($json_array["streams"][0]["channel"])) {
		echo "LIVE NOW";
	} else {
		echo "OFFLINE";
	}
?>
</div>
	</div>

        </article>
		</div>
		<?php
$i++;
if($i == 3) {
	$i = 0;
	echo '</div>';
}
?>
    <?php endwhile; ?>
	<?php
if($i > 0) {
	echo '</div>';
}
?>
</div>
</div>
</div>

<?php get_footer(); ?>