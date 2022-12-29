<?php


// The widget class
class IMBACHAT_My_Custom_Widget extends WP_Widget {

    // Main constructor
    // public function __construct() {
    //     parent::__construct(
    //         'my_custom_widget',
    //         _e( 'My Custom Widget', "imbachat" ),
    //         array(
    //             'customize_selective_refresh' => true,
    //         )
    //     );
    // }

    public function __construct() {
        parent::__construct(
            'my_custom_widget','',
            array(
                'customize_selective_refresh' => true,
            )
        );
    }

    // The widget form (for the backend )
    // The widget form (for the backend )
    public function form( $instance ) {

        // Set widget defaults
        $defaults = array(
            'title'    => '',
            'text'     => '',
            'textarea' => '',
            'checkbox' => '',
            'select'   => '',
        );

        // Parse current settings with defaults
        extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

        <?php // Widget Title ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php // Text Field ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
        </p>

        <?php // Textarea Field ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php _e( 'Textarea:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>"><?php echo wp_kses_post( $textarea ); ?></textarea>
        </p>

        <?php // Checkbox ?>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Checkbox', 'text_domain' ); ?></label>
        </p>

        <?php // Dropdown ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select', 'text_domain' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="widefat">
                <?php
                // Your options array
                $options = array(
                    ''        => _e( 'Select', 'text_domain' ),
                    'option_1' => _e( 'Option 1', 'text_domain' ),
                    'option_2' => _e( 'Option 2', 'text_domain' ),
                    'option_3' => _e( 'Option 3', 'text_domain' ),
                );

                // Loop through options and add each one to the select dropdown
                foreach ( $options as $key => $name ) {
                    echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';

                } ?>
            </select>
        </p>

    <?php }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
        $instance['textarea'] = isset( $new_instance['textarea'] ) ? wp_kses_post( $new_instance['textarea'] ) : '';
        $instance['checkbox'] = isset( $new_instance['checkbox'] ) ? 1 : false;
        $instance['select']   = isset( $new_instance['select'] ) ? wp_strip_all_tags( $new_instance['select'] ) : '';
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {
        extract( $args );

        // Check the widget options
        $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $text     = isset( $instance['text'] ) ? $instance['text'] : '';
        $textarea = isset( $instance['textarea'] ) ?$instance['textarea'] : '';
        $select   = isset( $instance['select'] ) ? $instance['select'] : '';
        $checkbox = ! empty( $instance['checkbox'] ) ? $instance['checkbox'] : false;

        // WordPress core before_widget hook (always include )
        echo wp_kses($before_widget);

        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Display widget title if defined
        if ( $title ) {
            echo wp_kses($before_title) . esc_html($title) . wp_kses($after_title);
        }

        // Display text field
        if ( $text ) {
            echo '<p>' . esc_html($text) . '</p>';
        }

        // Display textarea field
        if ( $textarea ) {
            echo '<p>' . esc_textarea($textarea) . '</p>';
        }

        // Display select field
        if ( $select ) {
            echo '<p>' . esc_html($select) . '</p>';
        }

        // Display something if checkbox is true
        if ( $checkbox ) {
            echo '<p>Something awesome</p>';
        }

        echo '</div>';

        // WordPress core after_widget hook (always include )
        echo wp_kses($after_widget);
    }

}

// Register the widget
function imbachat_my_register_custom_widget() {
    register_widget( 'IMBACHAT_My_Custom_Widget' );
}
add_action( 'widgets_init', 'imbachat_my_register_custom_widget' );