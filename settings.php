<?php

if(!class_exists('WP_Canvas_Nest_Settings')) {
	class WP_Canvas_Nest_Settings {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
            add_action('wp_footer', array(&$this, 'add_canvas_nest'));
		} // END public function __construct

		public function add_canvas_nest() {
            $setting_color = get_option('setting_color');
            if (!isset($setting_color)) $setting_color = '0,0,0';
            $setting_opacity = get_option('setting_opacity');
            if (!isset($setting_opacity)) $setting_opacity = '0.5';
            $setting_count = get_option('setting_count');
            if (!isset($setting_count)) $setting_count = '99';
            $setting_zindex = get_option('setting_zindex');
            if (!isset($setting_zindex)) $setting_zindex = '-1';
            echo "<script type='text/javascript' color='$setting_color' zIndex='$setting_zindex' opacity='$setting_opacity' count='$setting_count' src='//cdn.bootcss.com/canvas-nest.js/1.0.0/canvas-nest.min.js'></script>";
        }
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
        	// register your plugin's settings
        	register_setting('WP_Canvas_Nest-group', 'setting_color');
        	register_setting('WP_Canvas_Nest-group', 'setting_opacity');
            register_setting('WP_Canvas_Nest-group', 'setting_count');
            register_setting('WP_Canvas_Nest-group', 'setting_zindex');

        	// add your settings section
        	add_settings_section(
        	    'WP_Canvas_Nest-section', 
        	    'Canvas-Nest.js Settings', 
        	    array(&$this, 'settings_section_WP_Canvas_Nest'), 
        	    'WP_Canvas_Nest'
        	);
        	
        	// add your setting's fields
            add_settings_field(
                'WP_Canvas_Nest-setting_color', 
                'Line Color: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Nest', 
                'WP_Canvas_Nest-section',
                array(
                    'field' => 'setting_color',
                    'value' => '0,0,0'
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_opacity', 
                'Line Opacity: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Nest', 
                'WP_Canvas_Nest-section',
                array(
                    'field' => 'setting_color',
                    'value' => '0.5'
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_count', 
                'Line Count: ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Nest', 
                'WP_Canvas_Nest-section',
                array(
                    'field' => 'setting_count',
                    'value' => '99'
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_zindex', 
                'Css zIndex): ', 
                array(&$this, 'settings_field_input_text'), 
                'WP_Canvas_Nest', 
                'WP_Canvas_Nest-section',
                array(
                    'field' => 'setting_zindex',
                    'value' => '-1'
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate
        
        public function settings_section_WP_Canvas_Nest() {
            echo 'These configuages are setting for <a target="_blank" href="https://github.com/aTool-org/canvas-nest-for-wp">Canvas-Nest.js</a>. Need Help? <a target="_blank" href="http://www.atool.org/">Click Here</a>.';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args) {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            if (! isset($value)) $value = $args['value'];
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */		
        public function add_menu() {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Canvas-Nest.js Setting', 
        	    'Canvas-Nest.js', 
        	    'manage_options', 
        	    'WP_Canvas_Nest', 
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */		
        public function plugin_settings_page() {
        	if(!current_user_can('manage_options')) {
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
        	// Render the settings template
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class WP_Canvas_Nest_Settings
} // END if(!class_exists('WP_Canvas_Nest_Settings'))
