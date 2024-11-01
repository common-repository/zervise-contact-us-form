<?php
/**
 * Adds Zervise widget.
 */
 class Zervise_Contact_Us_Widget extends WP_Widget {
  
    /**
     * Register widget with WordPress.
     */
    function __construct() {
      parent::__construct(
        'zervise_contact_us_widget', // Base ID
        esc_html__( 'Zervise Contact Us Form', 'zervise_domain' ), // Name
        array( 'description' => esc_html__( 'Widget for zervise.com', 'zervise_domain' )) // Args
      );
    }
  
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
      echo '<b>'.esc_html('Zervise Contact Us Form').'</b>';

      if ( ! empty( $instance['title_c'] ) ) {
        echo esc_html($args['before_title']) . apply_filters( 'widget_title', 'Zervise' ) . esc_html($args['after_title']);
      }

      $class = "cu-zervise-btn-3";
      if($instance["position_c"] == "1")
        $class = "cu-zervise-btn-1";
      else if($instance["position_c"] == "2")
        $class = "cu-zervise-btn-2";
      else $class = "cu-zervise-btn-3";

      if($instance["accepted_c"] === 'on'){
        echo '<button class="cu-zervise-btn '.esc_html($class).'" data-subdomain="'.esc_url($instance['subdomain_c']).'" title="Contact use form by Zervise" >
        <i class="fas fa-envelope"></i> &nbsp;Contact Us
      </button>';
      } else {
        echo '<button class="cu-zervise-btn '.esc_html($class).' not-accepted" data-subdomain="'.esc_url($instance['subdomain_c']).'" title="Please agree to our Terms & Conditions to use the widget" disabled>
              <i class="fas fa-envelope"></i> &nbsp;Agree to enable widget
            </button>';
      }
    }
  
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
      $subdomain_c = ! empty( $instance['subdomain_c'] ) ? $instance['subdomain_c'] : esc_html__( 'https://zervise.com/', 'zervise_domain' ); 

      $title_c = ! empty( $instance['title_c'] ) ? $instance['title_c'] : esc_html__( 'Zervise', 'zervise_domain' ); 

      $position_c = ! empty( $instance['position_c'] ) ? $instance['position_c'] : esc_html__( "3", 'zervise_domain' );

      $accepted_c = ! empty( $instance['accepted_c'] ) ? $instance['accepted_c'] : esc_html__( "off", 'zervise_domain' ); 
      ?>

      
      
      
      <!-- SUBDOMAIN -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'subdomain_c' ) ); ?>">
          <?php esc_attr_e( 'Zervise Subdomain URL', 'zervise_domain' ); ?>
        </label>

        <input 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'subdomain_c' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'subdomain_c' ) ); ?>" 
          type="text" 
          value="<?php echo esc_attr( $subdomain_c ); ?>">
      </p>
      <p><span style="font-weight: bold;">NOTE:</span> Make sure the URL ends with a "slash" i.e. "/"</p>
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'position_c' ) ); ?>">
          <?php esc_attr_e( 'Position of widget on screen', 'zervise_domain' ); ?>
        </label>

        <select 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'position_c' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'position_c' ) ); ?>" 
        >
          <option 
            value="1" 
            <?php if ($instance['position_c'] == "1") echo "selected='selected'";?> >
            Bottom Left
          </option>
          <option 
            value="2" 
            <?php if ($instance['position_c'] == "2") echo "selected='selected'";?> >
            Bottom Middle
          </option>
          <option 
            value="3" 
            <?php if ($instance['position_c'] == "3") echo "selected='selected'";?> >
            Bottom Right
          </option>
        </select>
      </p>
      <p>
        <input 
          class="widefat" 
          id="<?php echo esc_attr( $this->get_field_id( 'accepted_c' ) ); ?>" 
          name="<?php echo esc_attr( $this->get_field_name( 'accepted_c' ) ); ?>" 
          type="checkbox" 
          <?php checked( $instance[ 'accepted_c' ], 'on' ); ?>
          >
        <label for="<?php echo esc_attr( $this->get_field_id( 'accepted_c' ) ); ?>">
        I agree to the MSA, <a href="https://www.zervise.com/terms" target="_blank">Terms & Conditions</a> and <a href="https://www.zervise.com/privacy" target="_blank">Privacy Policy</a>.
        </label>
      </p>
      <?php 
    }
  
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
      $instance = array();

      $instance['subdomain_c'] = 
        (!empty( $new_instance['subdomain_c']) and 
        (strpos($new_instance['subdomain_c'], 'https://') === 0) and 
        (strpos($new_instance['subdomain_c'], '.zervise.com/') === strlen($new_instance['subdomain_c']) - 13)) 
          ? strip_tags( $new_instance['subdomain_c'] ) 
          :( (!empty( $old_instance['subdomain_c']))
              ? $old_instance['subdomain_c']
              : 'https://zervise.com/');

      $instance['position_c'] = $new_instance['position_c'];
      $instance[ 'accepted_c' ] = $new_instance[ 'accepted_c' ];
  
      return $instance;
    }
  
  } // class Zervise_Widget