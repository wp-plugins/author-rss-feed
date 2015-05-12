<?php
/**
 * Widget Class
 *
 * This file holds the class that extends the WP_Widget class,
 * creating the widget.
 *
 * @author Daniel Pataki
 * @since 1.0.0
 *
 */

/**
 * Author RSS Feed Widget Class
 *
 * This creates the widget options in the backend and the widget UI
 * in the front-end.
 *
 * @author Daniel Pataki
 * @since 1.0.0
 *
 */
class Author_RSS_Feed_Widget extends WP_Widget {
    /**
     * Constructor
     *
     * The widget constructor uses the parent class constructor
     * to add the widget to WordPress, we just provide the basic
     * details
     *
     * @author Daniel Pataki
     * @since 1.0.0
     *
     */
    public function __construct() {
        $widget_details = array(
            'classname' => 'author-rss-feed-widget',
            'description' => __( 'Shows author-specific RSS feeds on author pages or posts', 'author-rss-feed' )
        );

        parent::__construct( 'author-rss-feed', __( 'Author RSS Feed', 'author-rss-feed' ), $widget_details );

    }


    /**
     * Widget Form
     *
     * The form shown in the admin when building the widget.
     *
     * @param array $instance The widget details
     * @author Daniel Pataki
     * @since 1.0.0
     *
     */
    public function form( $instance ) {

        $title = ( !empty( $instance['title'] ) ) ? $instance['title'] : '';
        $count = ( !empty( $instance['count'] ) ) ? $instance['count'] : 5;
        $default_feed = ( !isset( $instance['default_feed'] ) ) ? 'https://wordpress.org/news/feed/' : $instance['default_feed'];
        $feed_field = ( !empty( $instance['feed_field'] ) ) ? $instance['feed_field'] : 'author_feed';
        $show_on = ( !isset( $instance['show_on'] ) ) ? array( 'author_archives', 'single_posts' ) : $instance['show_on'];
        $show_on_options = array(
            'single_posts' => __( 'Single Posts', 'author-rss-feed' ),
            'author_archives' => __( 'Author Archives', 'author-rss-feed' ),
        );
        ?>

        <div class='author-rss-feed'>
            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'author-rss-feed' ) ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'feed_field' ); ?>"><?php _e( 'Field Name:', 'author-rss-feed' ) ?> <a href='https://wordpress.org/plugins/author-rss-feed/other_notes/' class='help'><?php _e( 'help', 'author-rss-feed' ) ?></a></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'feed_field' ); ?>" name="<?php echo $this->get_field_name( 'feed_field' ); ?>" type="text" value="<?php echo esc_attr( $feed_field ); ?>" />
            </p>

            <div class="help-content hidden">
            <?php echo sprintf( __('This is the usermeta field the plugin will look for when retrieving the RSS items. The value of this field should be a URL pointing to a valid RSS Feed. You can add a field to your users using %s', 'author-rss-feed' ), '<a href="https://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a>' ) ?>
            </div>


            <p>
                <label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Items To Show:', 'author-rss-feed' ) ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'default_feed' ); ?>"><?php _e( 'Default Feed URL:', 'author-rss-feed' ) ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'default_feed' ); ?>" name="<?php echo $this->get_field_name( 'default_feed' ); ?>" type="text" value="<?php echo esc_attr( $default_feed ); ?>" />
            </p>

            <p class='arf-show-on'>
                <label for="<?php echo $this->get_field_name( 'show_on' ); ?>"><?php _e( 'Show Feed On:', 'author-rss-feed' ) ?> </label><br>
                <?php
                    $i=0;
                    foreach( $show_on_options as $value => $name ) :
                        $checked = ( in_array( $value, $show_on ) ) ? 'checked="checked"' : '';
                ?>
                    <input <?php echo $checked ?> type='checkbox' id="<?php echo $this->get_field_id( 'show_on' ); ?>-<?php echo $i ?>" name="<?php echo $this->get_field_name( 'show_on' ); ?>[]" value='<?php echo $value ?>'> <label for='<?php echo $this->get_field_id( 'show_on' ); ?>-<?php echo $i ?>'><?php echo $name ?> <br>
                <?php $i++; endforeach ?>

            </p>


        </div>

        <?php
    }


    /**
     * Front End Output
     *
     * Handles the visitor-facing side of the widget.
     *
     * @param array $args The widget area details
     * @param array $instance The widget details
     * @author Daniel Pataki
     * @since 1.0.0
     *
     */
    public function widget( $args, $instance ) {

        $feed_url = $this->determine_feed_url( $instance );
        $feed = $this->get_feed( $feed_url, $instance['count'] );

        if( is_wp_error( $feed ) ) {
            return;
        }

        echo $args['before_widget'];

        if( !empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
        }

        echo '<ul>';
        foreach( $feed as $item ) {
            echo '<li><a href="' . $item['link'] . '">' . $item['title'] . '</a></li>';
        }
        echo '</ul>';

        echo $args['after_widget'];
    }

    /**
     * Determine Feed URL
     *
     * Figures out the feed URL based on the widget settings
     *
     * @param array $instance The widget details
     * @author Daniel Pataki
     * @since 1.0.0
     *
     */
    function determine_feed_url( $instance ) {

        // Singular Page Authors
        if( is_singular() && in_array( 'single_posts', $instance['show_on'] ) ) {
            global $post;
            $author_rss = get_user_meta( $post->post_author, $instance['feed_field'], true );
        }

        // Author Archive Authors
        elseif( is_author() ) {
            $profile = get_user_by( 'id', get_query_var( 'author' ) );
            $author_rss = get_user_meta( $profile->ID, $instance['feed_field'], true );
        }

        $author_rss = ( empty( $author_rss ) ) ? $instance['default_feed'] : $author_rss;

        return $author_rss;
    }

    /**
     * Get And Format Field
     *
     * @param string $feed_url The feed URL to retrieve data from
     * @author Daniel Pataki
     * @since 1.0.0
     *
     */
    function get_feed( $feed_url, $feed_count ) {

        $feed_data = array();
        $feed = fetch_feed( $feed_url );

        if( is_wp_error( $feed ) ) {
            return $feed;
        }

        $i=0;

        foreach ( $feed->get_items( 0, $feed_count ) as $item ) {
    		$link = $item->get_link();
    		while ( stristr( $link, 'http' ) != $link ) {
    			$link = substr( $link, 1 );
    		}
    		$feed_data[$i]['link'] = esc_url( strip_tags( $link ) );

    		$title = esc_html( trim( strip_tags( $item->get_title() ) ) );
    		if ( empty( $title ) ) {
    			$title = __( 'Untitled', 'author-rss-feed' );
    		}
            $feed_data[$i]['title'] = $title;

    		$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
            $feed_data[$i]['description'] = $desc;

            $feed_data[$i]['date'] = $item->get_date( 'U' );

            $i++;
        }

        return $feed_data;

    }


}

?>
