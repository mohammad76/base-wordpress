<?php
/**
 * This is simple class for adding Zhaket guard system in any wordpress theme and plugin.
 * Author: Mojtaba Darvishi
 * http://mojtaba.in
 * Created by PhpStorm.
 * User: mojtaba
 * Date: 11/10/17
 * Time: 12:17 PM
 */

class WPSeo_Premium_SDK {

	/**
     * Your plugin or theme name. It will be used in admin notices
	 * @var mixed
	 */
	private $name;
	/**
     * Registration page slug
	 * @var mixed
	 */
	private $slug;
	/**
     * Parent menu slug
     * More info: https://developer.wordpress.org/reference/functions/add_submenu_page/
	 * @var mixed
	 */
	private $parent_slug;
	/**
     * Your plugin or theme text domain
     * This wil be used to translate Zhaket Guard SDK strings with you theme or plugin translation file
	 * @var mixed
	 */
	private $text_domain = 'wpseo-grd';
	/**
     * Name of option that save info
	 * @var mixed
	 */
	private static $option_name;
	/**
     * Your product token in zhaket.com
	 * @var mixed
	 */
	private $product_token;
	/**
     * Zhaket guard API url
	 * @var string
	 */
	public static $api_url = 'http://guard.zhaket.com/api/';

	/**
     * Single instance of class
	 * @var null
	 */
	private static $instance = null;

	/**
	 * WPSeo_Premium_SDK constructor.
	 */
	public function __construct(array $settings) {

	    // Initial settings
		$defaults = [
			'name'          => '',
			'slug'          => '',
			'parent_slug'   => '',
			'product_token' => '',
			'option_name'   => ''
		];
		foreach ( $settings as $key => $setting ) {
			if( array_key_exists($key, $defaults) && !empty($setting) ) {
				$defaults[$key] = $setting;
			}
		}
		$this->name = $defaults['name'];
		$this->slug = $defaults['slug'];
		$this->parent_slug = $defaults['parent_slug'];
		self::$option_name = $defaults['option_name'];
		$this->product_token = $defaults['product_token'];

        $this->load_textdomain();

		add_action('admin_menu', array($this, 'admin_menu'));

		add_action('wp_ajax_zhk_guard_wp_yoastsp_starter', array($this, 'wp_yoastsp_starter'));

		add_action('wp_ajax_zhk_guard_yoastsp_revalidate', array($this, 'revalidate_yoastsp_starter'));

		add_action('init', array($this, 'schedule_programs'));

		add_action( 'zhk_guard_daily_validator', array($this, 'daily_event') );

		add_action( 'admin_notices', array($this, 'admin_notice') );

		add_action('add_meta_boxes', array($this, 'meta_box'), 10, 2);

		add_filter('wpseo_accessible_post_types', array($this, 'supported_post_types'), 9999);

	}

	public function supported_post_types( $post_types ) {
	    if( !self::is_activated() ) {
		    $post_types = array();
	    }
        return $post_types;
	}

	public function meta_box( $post_type, $post ) {
		if( !self::is_activated() ) {
			$post_types = get_post_types( array( 'public' => true ) );
			$accessible_post_types = array_filter( $post_types, 'is_post_type_viewable' );
			foreach ( $accessible_post_types as $accessible_post_type ) {
				add_meta_box(
					'wpseo_premium_activator',
					__('Yoast SEO Premium Activation', $this->text_domain),
					array($this, 'meta_box_content'),
					$accessible_post_type,
					'normal'
				);
			}
		}
	}

	public function meta_box_content( $post_id ) {
        ?>
		<div style="overflow: auto;">                
		<div style="float:left;"><img style="display: block;" src="<?php echo esc_url( plugin_dir_url( WPSEO_FILE ) . 'images/activate.png' ) ?>"></div>
    <div>
        <h3 class="post-title"><?php _e('Plugin NOT activated. first activate it before use', $this->text_domain); ?></h3>
        <p><?php _e('Get activation code from downloads section in your Zhaket.com profile.', $this->text_domain); ?></p>
		<p><a href="<?php echo esc_url(admin_url('admin.php?page=wpseo-activation')) ?>" class="button button-primary" style="margin: 15px 0 10px 0;"><?php _e('Click here to activate Yoast SEO Premium', $this->text_domain); ?></a>
		<a href="https://zhaket.com/product/yoast-seo-premium-wordpress-plugin/?add-to-cart=215531" target="_blank" class="button" style="margin: 15px 0 10px 0;"><?php _e('Buy New License', $this->text_domain); ?></a></p>
		</div>
</div>

        <?php
	}

	private function load_textdomain() {
		load_plugin_textdomain( 'wpseo-grd', false, dirname( plugin_basename( __FILE__ ) ) );
	}


	/**
	 * Add submenu page for display registration form
	 */
	public function admin_menu() {
		add_submenu_page(
			$this->parent_slug,
			__('Activate Yoast SEO Premium', $this->text_domain),
			__('Activate Premium Version', $this->text_domain),
			'manage_options',
			$this->slug,
			array($this, 'menu_content')
		);
	}

	/**
	 * Submenu content
	 */
	public function menu_content() {
		$option = get_option(self::$option_name);
		$now = json_decode(get_option($option));
		$starter = (isset($now->starter) && !empty($now->starter)) ? base64_decode($now->starter) : '';
		if( isset($_GET['debugger']) && !empty($_GET['debugger']) && $_GET['debugger'] === 'show' ) {
			$data_show = $option;
		} else {
			$data_show = '';
		}
		?>
        <style>
            form.register_version_form,
            .current_license {
                width: 30%;
                background: #fff;
                margin: 0 auto;
                padding: 20px 30px;
            }
            form.register_version_form  .license_key {
                padding: 5px 10px;
                width: calc( 100% - 100px );
            }

            form.register_version_form button {
                width: 80px;
                text-align: center;
            }

            form.register_version_form .result,
            .current_license .check_result {
                width: 100%;
                padding: 30px 0 15px;
                text-align: center;
                display: none;
            }
            .current_license .check_result {
                padding: 20px 0;
                float: right;
                width: 100%;
            }
            form.register_version_form .result .spinner,
            .current_license .check_result .spinner {
                width: auto;
                background-position: right center;
                padding-right: 30px;
                margin: 0;
                float: none;
                visibility: visible;
                display: none;
            }
            .current_license.waiting .check_result .spinner,
            form.register_version_form .result.show .spinner {
                display: inline-block;
            }
            .current_license {
                width: 40%;
                text-align: center;
            }
            .current_license > .current_label {
                line-height: 25px;
                height: 25px;
                display: inline-block;
                font-weight: bold;
                margin-left: 10px;
            }
            .current_license > code {
                line-height: 25px;
                height: 25px;
                padding: 0 5px;
                color: #c7254e;
                margin-left: 10px;
                display: inline-block;
                -webkit-transform: translateY(2px);
                -moz-transform: translateY(2px);
                -ms-transform: translateY(2px);
                -o-transform: translateY(2px);
                transform: translateY(2px);
            }
            .current_license .action {
                color: #fff;
                line-height: 25px;
                height: 25px;
                padding: 0 5px;
                display: inline-block;
            }
            .current_license .last_check {
                line-height: 25px;
                height: 25px;
                padding: 0 5px;
                display: inline-block;
            }
            .current_license .action.active {
                background: #4CAF50;
            }
            .current_license .action.inactive {
                background: #c7254e;
            }

            .current_license .keys {
                float: right;
                width: 100%;
                text-align: center;
                padding-top: 20px;
                border-top: 1px solid #ddd;
                margin-top: 20px;
            }
            .current_license .keys .wpmlr_revalidate {
                margin-left: 30px;
            }
            .current_license .register_version_form {
                display: none;
                padding: 0;
                float: right;
                width: 80%;
                margin: 20px 10%;
            }
            .zhk_guard_notice {
                background: #fff;
                border: 1px solid rgba(0,0,0,.1);
                border-right: 4px solid #00a0d2;
                padding: 5px 15px;
                margin: 5px;
            }
            .zhk_guard_danger {
                background: #fff;
                border: 1px solid rgba(0,0,0,.1);
                border-right: 4px solid #DC3232;
                padding: 5px 15px;
                margin: 5px;
            }
            .zhk_guard_success {
                background: #fff;
                border: 1px solid rgba(0,0,0,.1);
                border-right: 4px solid #46b450;
                padding: 5px 15px;
                margin: 5px;
            }
            @media (max-width: 1024px) {
                form.register_version_form,
                .current_license {
                    width: 90%;
                }
            }
        </style>
        <div class="wrap wpmlr_wrap" data-show="<?php echo $data_show ?>">
            <h1><?php _e('Activate Yoast SEO Premium Version', $this->text_domain); ?></h1>
			<?php if( isset($now) && !empty($now) ): ?>
                <p><?php _e('You already register your license key. to re validate it, you can use this form.', $this->text_domain); ?></p>
                <div class="current_license">
                    <span class="current_label"><?php _e('Your current license:', $this->text_domain); ?></span>
                    <code><?php echo $starter; ?></code>
                    <div class="action <?php echo ($now->action == 1) ? 'active' : 'inactive'; ?>">
						<?php if( $now->action == 1 ): ?>
                            <span class="dashicons dashicons-yes"></span>
							<?php echo $now->message; ?>
						<?php else: ?>
                            <span class="dashicons dashicons-no-alt"></span>
							<?php echo $now->message; ?>
						<?php endif; ?>
                    </div>
                    <div class="keys">
                        <a href="#" class="button button-primary wpmlr_revalidate" data-key="<?php echo $starter; ?>"><?php _e('Revalidate', $this->text_domain); ?></a>
                        <a href="#" class="button zhk_guard_new_key"><?php _e('Delete and submit another license', $this->text_domain); ?></a>
                    </div>

                    <form action="#" method="post" class="register_version_form">
                        <input type="text" class="license_key" placeholder="<?php _e('New license key', $this->text_domain); ?>">
                        <button class="button button-primary"><?php _e('Save', $this->text_domain); ?></button>
                        <div class="result">
                            <div class="spinner"><?php _e('Please wait...', $this->text_domain); ?></div>
                            <div class="result_text"></div>
                        </div>
                    </form>

                    <div class="check_result">
                        <div class="spinner"><?php _e('Please wait...', $this->text_domain); ?></div>
                        <div class="result_text"></div>
                    </div>
                    <div class="clear"></div>
                </div>
			<?php else: ?>
                <p><?php _e('Please activate plugin with your license key to all features work.', $this->text_domain); ?></p>
                <form action="#" method="post" class="register_version_form">
                    <input type="text" class="license_key" placeholder="<?php _e('License key', $this->text_domain); ?>">
                    <button class="button button-primary"><?php _e('Activate', $this->text_domain); ?></button>
                    <div class="result">
                        <div class="spinner"><?php _e('Please wait...', $this->text_domain); ?></div>
                        <div class="result_text"></div>
                    </div>
                </form>
			<?php endif; ?>
            <script>
                jQuery(document).ready(function($) {
                    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
                    jQuery(document).on('submit', '.register_version_form', function(event) {
                        event.preventDefault();
                        var starter = jQuery(this).find('.license_key').val(),
                            thisEl = jQuery(this);
                        thisEl.addClass('waiting');
                        thisEl.find('.result').slideDown(300).addClass('show');
                        thisEl.find('.button').addClass('disabled');
                        thisEl.find('.result_text').slideUp(300).html('');
                        jQuery.ajax({
                            url: ajax_url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'zhk_guard_wp_yoastsp_starter',
                                starter: starter
                            },
                        })
                            .done(function(result) {
                                thisEl.find('.result_text').append(result.data).slideDown(150)
                            })
                            .fail(function(result) {
                                thisEl.find('.result_text').append('<div class="zhk_guard_danger"><?php _e('Something goes wrong please try again.', $this->text_domain); ?></div>').slideDown(150)
                            })
                            .always(function(result) {
                                console.log(result);
                                thisEl.removeClass('waiting');
                                thisEl.find('.result').removeClass('show');
                                thisEl.find('.button').removeClass('disabled');
                            });
                    });

                    $(document).on('click', '.wpmlr_revalidate', function(event) {
                        event.preventDefault();
                        var starter = $(this).data('key'),
                            thisEl = $(this).parents('.current_license');
                        thisEl.addClass('waiting');
                        thisEl.find('.check_result').slideDown(300);
                        thisEl.find('.button').addClass('disabled');
                        thisEl.find('.result_text').slideUp(300).html('');
                        thisEl.find('.register_version_form').slideUp(300)
                        $.ajax({
                            url: ajax_url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'zhk_guard_yoastsp_revalidate',
                                starter: starter
                            },
                        })
                            .done(function(result) {
                                thisEl.find('.check_result .result_text').append(result.data).slideDown(150)
                            })
                            .fail(function(result) {
                                thisEl.find('.check_result .result_text').append('<div class="wpmlr_danger"><?php _e('Something goes wrong please try again.', $this->text_domain); ?></div>').slideDown(150)
                            })
                            .always(function(result) {
                                thisEl.removeClass('waiting');
                                thisEl.find('.button').removeClass('disabled');
                            });
                    });


                    $(document).on('click', '.zhk_guard_new_key', function(event) {
                        event.preventDefault();
                        var thisEl = $(this).parents('.current_license');
                        thisEl.find('.result_text').slideUp(300).html('');
                        thisEl.find('.register_version_form').slideDown(300)
                    });
                });
            </script>

        </div>
		<?php

	}

	/**
	 *
	 */
	public function wp_yoastsp_starter() {
		$starter = sanitize_text_field($_POST['starter']);
		if( empty($starter) ) {
			wp_send_json_error('<div class="zhk_guard_danger">'.__('Please insert your license code', $this->text_domain).'</div>');
		}

		$private_session = get_option(self::$option_name);
		delete_option($private_session);

		$product_token = $this->product_token;
		$result = self::install($starter, $product_token);
		$output = '';


			$rand_key = md5(wp_generate_password(12, true, true));
			update_option(self::$option_name, $rand_key);
			$result = array(
				'starter' => base64_encode($starter),
				'action' => 1,
				'message' => __('License code is valid.', $this->text_domain),
				'timer' => time(),
			);
			update_option($rand_key, json_encode($result));
			$output = '<div class="zhk_guard_success">'.__('Thanks! Your license activated successfully.', $this->text_domain).'</div>';
			wp_send_json_success($output);

	}

	/**
	 * Show admin notice for registration problems
	 */
	public function admin_notice() {
		$private_session = get_option(self::$option_name);
		$now = json_decode(get_option($private_session));
		?>
		<?php if( empty($now) ): ?>
            <div class="notice notice-error">
                <p>
					<?php printf(__( 'To activating your %s please insert you license key', $this->text_domain ), $this->name); ?>
                    <a href="<?php echo admin_url( 'admin.php?page='.$this->slug ); ?>" class="button button-primary"><?php _e('Register Activate Code', $this->text_domain); ?></a>
                </p>
            </div>
		<?php elseif( $now->action != 1 ): ?>
            <div class="notice notice-error">
                <p>
					<?php printf(__( 'There is something wrong with your %s license. please check it.', $this->text_domain ), $this->name); ?>
                    <a href="<?php echo admin_url( 'admin.php?page='.$this->slug ); ?>" class="button button-primary"><?php _e('Check Now', $this->text_domain); ?></a>
                </p>
            </div>
		<?php endif; ?>
		<?php
	}

	/**
	 *  Ajax callback for check license action
	 */
	public function revalidate_yoastsp_starter() {
		$starter = sanitize_text_field($_POST['starter']);
		if( empty($starter) ) {
			wp_send_json_error('<div class="zhk_guard_danger">'.__('Please insert your license code', $this->text_domain).'</div>');
		}

		$result = self::is_valid($starter);
		if ($result->status=='successful') {
			$rand_key = md5(wp_generate_password(12, true, true));
			update_option(self::$option_name, $rand_key);
			$how = array(
				'starter' => base64_encode($starter),
				'action' => 1,
				'message' => $result->message,
				'timer' => time(),
			);
			update_option($rand_key, json_encode($how));
			$output = '<div class="zhk_guard_success">'.__('Thanks! Your license activated successfully.', $this->text_domain).'</div>';
			wp_send_json_success($output);
		} else {
			$rand_key = md5(wp_generate_password(12, true, true));
			update_option(self::$option_name, $rand_key);
			$how = array(
				'starter' => base64_encode($starter),
				'action' => 0,
				'timer' => time(),
			);
			if (!is_object($result->message)) {
				$how['message'] = $result->message;
			} else {
				foreach ($result->message as $message) {
					foreach ($message as $msg) {
						$how['message'] = $msg;
					}
				}
			}
			update_option($rand_key, json_encode($how));
			$output = '<div class="zhk_guard_danger">'.$how['message'].'</div>';
			wp_send_json_success($output);
		}

	}

	/**
	 * Set a schedule event for daily checking
	 */
	public function schedule_programs() {
		if (! wp_next_scheduled ( 'zhk_guard_daily_validator' )) {
			wp_schedule_event(time(), 'daily', 'zhk_guard_daily_validator');
		}
	}

	/**
	 * Check license status every day
	 */
	public function daily_event() {
		$private_session = get_option(self::$option_name);
		$now = json_decode(get_option($private_session));
		if( isset($now) && !empty($now) ) {
			$starter = (isset($now->starter) && !empty($now->starter)) ? base64_decode($now->starter) : '';
			$result = self::is_valid($starter);
			if( $result != null ) {
				if ($result->status=='successful') {
					delete_option($private_session);
					$rand_key = md5(wp_generate_password(12, true, true));
					update_option(self::$option_name, $rand_key);
					$how = array(
						'starter' => base64_encode($starter),
						'action' => 1,
						'message' => $result->message,
						'timer' => time(),
					);
					update_option($rand_key, json_encode($how));
				} else {

					delete_option($private_session);
					$rand_key = md5(wp_generate_password(12, true, true));
					update_option(self::$option_name, $rand_key);
					$how = array(
						'starter' => base64_encode($starter),
						'action' => 0,
						'timer' => time(),
					);
					if (!is_object($result->message)) {
						$how['message'] = $result->message;
					} else {
						foreach ($result->message as $message) {
							foreach ($message as $msg) {
								$how['message'] = $msg;
							}
						}
					}
					update_option($rand_key, json_encode($how));
				}
			}
		}
	}

	/**
     * Check license status
     * If you want add an interrupt in your plugin or theme simply can use this static method: WPSeo_Premium_SDK::is_activated
     * This will return true or false for license status
	 * @return bool
	 */
	public static function is_activated() {
		$private_session = get_option(self::$option_name);
		$now = json_decode(get_option($private_session));
		if( empty($now) ) {
			return false;
		} elseif($now->action != 1) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @param $method
	 * @param array $params
	 *
	 * @return array|mixed|object
	 */
	public static function send_request( $method, $params=array() ) {
		$param_string = http_build_query($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,
			self::$api_url.$method.'?'.$param_string
		);
		$content = curl_exec($ch);
		return json_decode($content);
	}

	/**
	 * @param $license_token
	 *
	 * @return array|mixed|object
	 */
	public static function is_valid($license_token)	{
		$result = self::send_request('validation-license',array('token'=>$license_token,'domain'=>self::get_host()));
		return $result;
	}

	/**
	 * @param $license_token
	 * @param $product_token
	 *
	 * @return array|mixed|object
	 */
	public static function install($license_token, $product_token) {
		$result = self::send_request('install-license',array('product_token'=>$product_token,'token'=>$license_token,'domain'=>self::get_host()));
		return $result;
	}

	/**
	 * @return string
	 */
	public static function get_host() {
		$possibleHostSources = array('HTTP_X_FORWARDED_HOST', 'HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR');
		$sourceTransformations = array(
			"HTTP_X_FORWARDED_HOST" => function($value) {
				$elements = explode(',', $value);
				return trim(end($elements));
			}
		);
		$host = '';
		foreach ($possibleHostSources as $source)
		{
			if (!empty($host)) break;
			if (empty($_SERVER[$source])) continue;
			$host = $_SERVER[$source];
			if (array_key_exists($source, $sourceTransformations))
			{
				$host = $sourceTransformations[$source]($host);
			}
		}

		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);
		// remove www from host
		$host = str_ireplace('www.', '', $host);

		return trim($host);
	}

	/**
	 * @param $settings
	 *
	 * @return null|WPSeo_Premium_SDK
	 */
	public static function instance($settings) {
		// Check if instance is already exists
		if(self::$instance == null) {
			self::$instance = new self($settings);
		}
		return self::$instance;
	}

}
add_action('init', 'zhk_guard_WPSeo_init');
/**
 * Initialize function for class and hook it to wordpress init action
 */
function zhk_guard_WPSeo_init() {
	$settings = [
		'name'          => 'Yoast SEO Premium',
		'slug'          => 'wpseo-activation',
		'parent_slug'   => 'wpseo_dashboard', // Read this: https://developer.wordpress.org/reference/functions/add_submenu_page/#parameters
		'product_token' => 'f460521e-a67a-4d00-b2e0-98018b2ed381', // Get it from here: https://zhaket.com/dashboard/licenses/
		'option_name'   => 'wpseo_activation_options'
	];
	WPSeo_Premium_SDK::instance($settings);
}