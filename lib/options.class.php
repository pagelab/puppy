<?php

class Custom_Options {

	private $sections;
	private $checkboxes;
	private $settings;
	private $storage;
	private $prefix;
	private $plugin_title;
	private $page;
	
	public $type = 'theme'; // set to plugin or theme
 
	public function __construct() {
		
		if ( $this->type == 'plugin')
			$this->storage = rtrim(plugin_dir_url(dirname(__FILE__)),'/');

		elseif ( $this->type == 'theme')
			$this->storage = get_bloginfo('template_directory');
		
		$this->prefix = "kibble_options";
		$this->plugin_title = "Kibble Options";
		$this->page = "kibble-options";
		$this->checkboxes = array();
		$this->settings = array();
		$this->get_settings();
		$this->sections['general']      = __( 'General Settings' );
	//	$this->sections['stats']        = __( 'Stats' );
		$this->sections['reset']        = __( 'Reset to Defaults' );
		$this->sections['about']        = __( 'About' );
		
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		if ( ! get_option( $this->prefix ) )
			$this->initialize_settings();
		
	}

	public function add_pages() {
		$admin_page = add_menu_page( __( $this->plugin_title ), __( $this->plugin_title ), 'manage_options', $this->page, array( &$this, 'display_page' ) , get_template_directory_uri() . '/images/drill.png');
		add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'scripts' ) );
		add_action( 'admin_print_styles-' . $admin_page, array( &$this, 'styles' ) );
		
	}
	
	public function create_setting( $args = array() ) {
		$defaults = array(
			'id'      => 'default_field',
			'title'   => __( 'Default Field' ),
			'desc'    => __( 'This is a default description.' ),
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => ''
		);
			
		extract( wp_parse_args( $args, $defaults ) );
		
		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class
		);
		
		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;
		
		add_settings_field( $id, $title, array( $this, 'display_setting' ), $this->page, $section, $field_args );
	}
	
	public function display_page() {
		echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __( $this->plugin_title ) . '</h2>';
	
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true )
			echo '<div class="updated fade"><p>' . __( $this->plugin_title . ' Updated.' ) . '</p></div>';
		
		echo '<form action="options.php" method="post">';
	
		settings_fields( $this->prefix );
		echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';
		
		foreach ( $this->sections as $section_slug => $section )
			echo '<li><a id="' . $section . '"href="#' . $section_slug . '">' . $section . '</a></li>';
		
		echo '</ul>';
		do_settings_sections( $_GET['page'] );
		
		echo '</div>';

		echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes' ) . '" /></p></form>';
	
	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
	
		$("a").click(function(){
			$(".submit").show();
		});        
	
		$("#About").click(function(){
			$(".submit").hide();
		}); 
		
		
			var sections = [];';
			
			foreach ( $this->sections as $section_slug => $section )
				echo "sections['$section'] = '$section_slug';";
			
			echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
			wrapped.each(function() {
				$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
			});
			$(".ui-tabs-panel").each(function(index) {
				$(this).attr("id", sections[$(this).children("h3").text()]);
				if (index > 0)
					$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({
				fx: { opacity: "toggle", duration: "fast" }
			});
			
			$("input[type=text], textarea").each(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
					$(this).css("color", "#999");
			});
			
			$("input[type=text], textarea").focus(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
					$(this).val("");
					$(this).css("color", "#000");
				}
			}).blur(function() {
				if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
					$(this).val($(this).attr("placeholder"));
					$(this).css("color", "#999");
				}
			});
			
			$(".wrap h3, .wrap table").show();
			
			$(".warning").change(function() {
				if ($(this).is(":checked"))
					$(this).parent().css("background", "#c00").css("color", "#fff").css("fontWeight", "bold");
				else
					$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
			});
			
			         
		});
		
	</script>
</div>';
		
	}
	
	
	public function display_section() {
	}
	
	public function display_about_section() {
			echo('
		<table>
	        <tbody>
	                <tr>
	                        <td>Kibble is a simple WordPress Theme for Photos and Galleries.</td>
	                </tr>
	        </tbody>
	</table>');

		 echo '<p>Copyright 2012-2013 fris.net</p>';
		
	}

	public function display_setting( $args = array() ) {
		extract( $args );
		
		$options = get_option( $this->prefix );
		
		if ( ! isset( $options[$id] ) && $type != 'checkbox' )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;
		
		$field_class = '';
		if ( $class != '' )
			$field_class = ' ' . $class;
		
		switch ( $type ) {
			
			case 'heading':
				echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
				break;
			
			case 'checkbox':
				
				echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
				
				break;
			
			case 'select':
				echo '<select class="select' . $field_class . '" name="'.$this->prefix.'[' . $id . ']">';
				
				foreach ( $choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
				
				echo '</select>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'radio':
				$i = 0;
				foreach ( $choices as $value => $label ) {
					echo '<input class="radio' . $field_class . '" type="radio" name="'.$this->prefix.'[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ( $i < count( $options ) - 1 )
						echo '<br />';
					$i++;
				}
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" placeholder="' . $std . '" rows="12" cols="100">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'password':
				echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'text':
			default:
		 		echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		
		 		if ( $desc != '' )
		 			echo '<br /><span class="description">' . $desc . '</span>';
		 		
		 		break;			

	 		case 'slider':
			default:
		 		echo '
					<label for="amount">Selected Value:</label>
					<input  type="text" class="amount" name="'.$this->prefix.'[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />
					<div class="slider"></div>
		 		';
		 		break;

			case 'date':
			default:
		 		echo '<input class="date-pick' . $field_class . '" type="text" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		
		 		if ( $desc != '' )
		 			echo '<span class="description">' . $desc . '</span>';
		 		
		 		break;

			case 'upload':
			default:
		 		echo '<input class="upload-url' . $field_class . '" type="text" id="' . $id . '" name="'.$this->prefix.'[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		echo '<input class="st_upload_button" type="button" id="st_upload_button" name="upload_button" placeholder="' . $std . '" value="Upload" />';
		 		
		 		if ( $desc != '' )
		 			echo '<br /><span class="description">' . $desc . '</span>';
		 		
		 		break;
		 	
		}
		
	}
	
	public function get_settings() {


		// general

		$this->settings['kibble_lightbox_type'] = array(
			'section' => 'general',
			'title'   => __( 'Gallery Lightbox' ),
			'desc'    => __( 'Use lightbox for galleries' ),
			'type'    => 'checkbox',
			'std'     => 1
		);

		// video options
		$this->settings['kibble_video_width'] = array(
			'title'   => __( 'Video Width' ),
			'desc'    => __( 'Width used for your videos.' ),
			'std'     => '420',
			'type'    => 'text',
			'section' => 'general'
		);

		$this->settings['kibble_video_height'] = array(
			'title'   => __( 'Video Height' ),
			'desc'    => __( 'Height used for your videos.' ),
			'std'     => '310',
			'type'    => 'text',
			'section' => 'general'
		);

		$this->settings['kibble_adult_embed'] = array(
			'section' => 'general',
			'title'   => __( 'Adult oEmbeds' ),
			'desc'    => __( 'Allow automatic video embeds from adult tube sites' ),
			'type'    => 'checkbox',
			'std'     => 1 // Set to 1 to be checked by default, 0 to be unchecked by default.
		);

		// reset
		$this->settings['reset_theme'] = array(
			'section' => 'reset',
			'title'   => __( 'Reset theme' ),
			'type'    => 'checkbox',
			'std'     => 0,
			'class'   => 'warning', // Custom class for CSS
			'desc'    => __( 'Check this box and click "Save Changes" below to reset theme options to their defaults.' )
		);
		
	}
	
	public function initialize_settings() {
		$default_settings = array();
		foreach ( $this->settings as $id => $setting ) {
			if ( $setting['type'] != 'heading' )
				$default_settings[$id] = $setting['std'];
		}
		
		update_option( $this->prefix, $default_settings );
		
	}
	
	public function register_settings() {
		register_setting( $this->prefix, $this->prefix, array ( &$this, 'validate_settings' ) );
		
		foreach ( $this->sections as $slug => $title ) {
			if ( $slug == 'about' )
				add_settings_section( $slug, $title, array( &$this, 'display_about_section' ), $this->page );
			else
				add_settings_section( $slug, $title, array( &$this, 'display_section' ), $this->page );
		}
		
		$this->get_settings();
		
		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}
		
	}
	
	public function scripts() {
		wp_print_scripts( 'jquery-ui-tabs' );
	}
	
	public function styles() {
		wp_register_style( 'css-admin', $this->storage . '/css/options.css' );
		wp_enqueue_style( 'css-admin' );
	}
	
	public function validate_settings( $input ) {
		if ( ! isset( $input['reset_theme'] ) ) {
			$options = get_option( $this->prefix );
			
			foreach ( $this->checkboxes as $id ) {
				if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
					unset( $options[$id] );
			}
			
			return $input;
		}
		return false;
		
	}
	
}

$custom_options = new Custom_Options();

function kibble_option( $option) {
	$options = get_option( 'kibble_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}


