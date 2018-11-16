<?php get_header(); ?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/twitch-custom/css/style-frontend.css" rel="stylesheet" />
<div class="mh-row mh-clearfix">
	<div id="plugin-content" class="mh-content">
	<div class="grid-container-outer">
	<article id="post-<?php the_ID(); ?>">
	<div class="chan-logo"><?$saved_data = get_post_meta($post->ID,'chan_logo',true);
echo '<img src="'.$saved_data['url'].'" width ="150px">';?></div>
    <!-- Add a placeholder for the Twitch embed -->
    <div id="twitch-embed"></div>

    <!-- Load the Twitch embed script -->
    <script src="https://embed.twitch.tv/embed/v1.js"></script>

    <!--
      Create a Twitch.Embed object that will render
      within the "twitch-embed" root element.
    -->
    <script type="text/javascript">
      var embed = new Twitch.Embed("twitch-embed", {
        width: 854,
        height: 480,
        channel: "<?php echo esc_html( get_post_meta( get_the_ID(), 'chan_name', true ) ); ?>",
        layout: "video",
        autoplay: false
      });

      embed.addEventListener(Twitch.Embed.VIDEO_READY, () => {
        var player = embed.getPlayer();
        player.play();
		player.setMuted(false);
      });
    </script>
	</div>
<div><iframe frameborder="0"
        scrolling="no"
        id="chat_embed"
        src="https://www.twitch.tv/embed/<?php echo esc_html( get_post_meta( get_the_ID(), 'chan_name', true ) ); ?>/chat"
        height="350"
        width="100%">
</iframe>
</div>
    <div><?php echo get_post_meta( get_the_ID(), 'chan_about', true ); ?></div>
		<br>	
      </article>
	</div>
</div>
</div>
<?php get_footer(); ?>