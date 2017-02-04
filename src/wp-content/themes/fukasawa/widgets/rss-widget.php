<?php 

class fukasawa_rss_widget extends WP_Widget {

	function __construct() {
        $widget_ops = array( 'classname' => 'fukasawa_rss_widget', 'description' => __('Displays RSS link', 'fukasawa') );
        parent::__construct( 'fukasawa_rss_widget', __('RSS Widget','fukasawa'), $widget_ops );
    }
	
	function widget($args, $instance) {
	
		// Outputs the content of the widget
		extract($args); // Make before_widget, etc available.
		
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		
		
		echo $before_widget;
		
		if (!empty($widget_title)) {
		
			echo $before_title . $widget_title . $after_title;
			
		} ?>
			
                <a href="<?php echo esc_url(get_bloginfo('rss2_url')); ?>">
                    <?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?>
                </a>
							
		<?php echo $after_widget; 
	}
	
	
	function update($new_instance, $old_instance) {
	
		//update and save the widget
		return $new_instance;
		
	}
	
	function form($instance) {
	
		// Get the options into variables, escaping html characters on the way
		$widget_title = $instance['widget_title'];
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php  _e('Title:', 'fukasawa'); ?>:
			<input id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" class="widefat" value="<?php echo $widget_title; ?>" /></label>
		</p>
		
		<?php
	}
}
register_widget('fukasawa_rss_widget'); ?>