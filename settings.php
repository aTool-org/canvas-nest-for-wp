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

        private function wrap_var($v) {
            if ($v === false) return true;
            if ($v) return true;
            return false;
        }
		public function add_canvas_nest() {
            //判断当前页面是否开启
            //is_home 、 is_archive 、 is_singular 、 is_search 、 is_404
            $will_show = false;

            $is_home = $this->wrap_var(get_option('cn_setting_ishome'));
            $is_archive = $this->wrap_var(get_option('cn_setting_isarchive'));
            $is_singular = $this->wrap_var(get_option('cn_setting_issingular'));
            $is_search = $this->wrap_var(get_option('cn_setting_issearch'));
            $is_404 = $this->wrap_var(get_option('cn_setting_is404'));

            if (is_home() && $is_home === is_home()) $will_show = true;
            else if (is_singular() && $is_singular === is_singular()) $will_show = true;
            else if (is_archive() && $is_archive === is_archive()) $will_show = true;
            else if (is_search() && $is_search === is_search()) $will_show = true;
            else if (is_404() && $is_404 === is_404()) $will_show = true;

            if ($will_show) {
                $setting_color = get_option('cn_setting_color');
                if ($setting_color === false) $setting_color = '0,0,0';
                $setting_opacity = get_option('cn_setting_opacity');
                if ($setting_opacity === false)  $setting_opacity = '0.5';
                $setting_count = get_option('cn_setting_count');
                if ($setting_count === false)  $setting_count = '99';
                $setting_zindex = get_option('cn_setting_zindex');
                if ($setting_zindex === false)  $setting_zindex = '-1';
                echo "<script type='text/javascript' color='$setting_color' zIndex='$setting_zindex' opacity='$setting_opacity' count='$setting_count' src='//cdn.bootcss.com/canvas-nest.js/1.0.0/canvas-nest.min.js'></script>";
            }
        }
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init() {
        	// register your plugin's settings
        	register_setting('WP_Canvas_Nest-group', 'cn_setting_color');
        	register_setting('WP_Canvas_Nest-group', 'cn_setting_opacity');
            register_setting('WP_Canvas_Nest-group', 'cn_setting_count');
            register_setting('WP_Canvas_Nest-group', 'cn_setting_zindex');

        	// add your settings section
        	add_settings_section(
        	    'WP_Canvas_Nest-section', 
        	    '1. Canvas-Nest.js Confuages(配置参数)', 
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
                    'field' => 'cn_setting_color',
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
                    'field' => 'cn_setting_opacity',
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
                    'field' => 'cn_setting_count',
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
                    'field' => 'cn_setting_zindex',
                    'value' => '-1'
                )
            );
            
            // setting 2
            register_setting('WP_Canvas_Nest-checkbox-group', 'cn_setting_ishome');
            register_setting('WP_Canvas_Nest-checkbox-group', 'cn_setting_issearch');
            register_setting('WP_Canvas_Nest-checkbox-group', 'cn_setting_issingular');
            register_setting('WP_Canvas_Nest-checkbox-group', 'cn_setting_isarchive');
            register_setting('WP_Canvas_Nest-checkbox-group', 'cn_setting_is404');

            // add your settings section
            add_settings_section(
                'WP_Canvas_Nest-checkbox-section', 
                '2. Launch in Which pages(在哪些页面开启)', 
                array(&$this, 'settings_section_WP_Canvas_Nest_Checkbox'), 
                'WP_Canvas_Nest_Checkbox'
            );

            add_settings_field(
                'WP_Canvas_Nest-setting_ishome', 
                'Index(首页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Nest_Checkbox', 
                'WP_Canvas_Nest-checkbox-section',
                array(
                    'field' => 'cn_setting_ishome', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_isarchive', 
                'Archive(归档页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Nest_Checkbox', 
                'WP_Canvas_Nest-checkbox-section',
                array(
                    'field' => 'cn_setting_isarchive', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_issingular', 
                'Singular(文章单页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Nest_Checkbox', 
                'WP_Canvas_Nest-checkbox-section',
                array(
                    'field' => 'cn_setting_issingular', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_issearch', 
                'Search(搜索页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Nest_Checkbox', 
                'WP_Canvas_Nest-checkbox-section',
                array(
                    'field' => 'cn_setting_issearch', 'value' => true
                )
            );
            add_settings_field(
                'WP_Canvas_Nest-setting_is404', 
                '404(404页): ', 
                array(&$this, 'settings_field_checkbox'), 
                'WP_Canvas_Nest_Checkbox', 
                'WP_Canvas_Nest-checkbox-section',
                array(
                    'field' => 'cn_setting_is404', 'value' => true
                )
            );
            //is_home、is_archive、is_singular、is_search、is_404

        } // END public static function activate
        public function settings_section_WP_Canvas_Nest_Checkbox() {
            echo 'These configuages are setting in which pages, open the canvas-nest.js';
        }

        public function settings_section_WP_Canvas_Nest() {
            echo 'These configuages are setting for <a target="_blank" href="https://github.com/aTool-org/canvas-nest-for-wp">Canvas-Nest.js</a>. Need Help? <a target="_blank" href="http://www.atool.org/">Click Here</a>.';
        }

        public function settings_field_checkbox($args) {
            $field = $args['field'];
            $value = $this->wrap_var(get_option($field));

            if ($value) {
                $value = "checked='checked'";
            }
            else {
                $value = '';
            }
            echo sprintf('<input type="checkbox" name="%s" id="%s" %s />', $field, $field, $value);
        }
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args) {
            $field = $args['field'];
            $value = get_option($field);
            if ($value === false) {
                $value = $args['value'];
            }
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        }
        
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
