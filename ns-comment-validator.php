<?php
   /**
   * Plugin Name: NS Comment Validator
   * Plugin URI: http://www.nilambar.net
   * Description: Client side validation of comment form
   * Version: 1.0.3
   * Author: Nilambar Sharma
   * Author URI: http://www.nilambar.net
   * License: GPLv2 or later
   * License URI: http://www.gnu.org/licenses/gpl-2.0.html
   */
// If this file is called directly, abort.
   if (!defined('WPINC'))
    die;

  define('NS_COMMENT_VALIDATOR_NAME','NS Comment Validator');
  define('NS_COMMENT_VALIDATOR_SLUG','ns-comment-validator');


  class NS_Comment_Validator  {
   protected $plugin_name = NS_COMMENT_VALIDATOR_NAME ;
   protected $plugin_slug = NS_COMMENT_VALIDATOR_SLUG ;

   private $hook_settings_page;

   /**
    * Default options
    */
   private $defaults = array(
      'cvns_rules' => 'author:{
              required : true
            },
            email:{
              required : true,
              email : true
            },
            url:{
              url : true
            },
            comment:{
              required : true,
              minlength : 10
            }',
      'cvns_messages' => "author:{
              required : 'Please enter name'
            },
            email:{
              required : 'Please enter valid email',
              email : 'Please enter valid email'
            },
            url:{
              url : 'Please enter valid URL'
            },
            comment:{
              required : 'Please enter comment',
              minlength : jQuery.format('Please enter at least {0} characters.')
            }",
        'cvns_error_element' => 'label',
        'cvns_error_class' => 'error',
        'cvns_styles' => '#commentform p.error,
                  #commentform span.error,
                  #commentform div.error,
                  #commentform label.error{
                    color:#FF0000;
                    font-size:.9em;
                    font-style:italic;
                  }',

    );

   /**
    * Plugin Options
    */
   private $options = array();
   /**
    * Constructor
    */
   function __construct(){
    $this->hook_settings_page = 'settings_page_'. $this->plugin_slug;

    // Load plugin text domain
    add_action('init', array($this, 'plugin_textdomain'));

    register_activation_hook( __FILE__, array( $this, 'activate' ) );
    register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

    //register setting
    add_action('admin_init', array($this, 'ns_comment_validator_register_settings'));

    //Register public CSS and JS
    add_action('wp_enqueue_scripts', array($this, 'register_public_scripts'));

    add_action('admin_menu', array( $this, 'ns_comment_validator_plugin_menu' ) );

    //get current options
    $this->_getCurrentOptions();

    //Add CSS for validation
    add_action('wp_head', array($this,'inject_css_in_page'));

    //Add JS for validation
    add_action('comment_form_after', array($this,'inject_javascript_in_page'));

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", array($this, 'ns_comment_validator_add_settings_link'));

   }
   //
   function activate(){
      //activation
      $this->_setDefaultOptions();
   }

   function deactivate(){
      //deactivation
      // $this->_removePluginOptions();
   }

   /**
    * Loads the plugin text domain for translation
    */
   public function plugin_textdomain()
   {
       load_plugin_textdomain('ns-comment-validator',  false, dirname(plugin_basename(__FILE__)) . '/languages');
   }

   function ns_comment_validator_plugin_menu()
   {
      add_options_page( $this->plugin_name, $this->plugin_name, 'manage_options', $this->plugin_slug,
         array($this, 'ns_comment_validator_admin_function'));
   }
   function ns_comment_validator_admin_function()
   {
      if (!current_user_can('manage_options'))
      {
          wp_die(__('You do not have sufficient permissions to access this page.'));
      }
      $options = $this->options;
      extract($options);
      require_once( ( plugin_dir_path(__FILE__) ) . '/admin/admin.php');
   }
   public function ns_comment_validator_register_settings()
   {
       register_setting('ns-comment-validator-options-group', 'cvns_options', array($this, 'cvns_validate_options'));
   }
   public function ns_comment_validator_add_settings_link($links)
   {
       $settings_link = '<a href="options-general.php?page=ns-comment-validator">' . __("Settings", 'ns-comment-validator') . '</a>';
       array_push($links, $settings_link);
       return $links;
   }

   public function register_public_scripts($hook)
   {
      if (!is_admin()) {
       wp_enqueue_script('ns-comment-validator-public-script', plugins_url( '/public/js/jquery.validate.min.js' , __FILE__ ) , array('jquery'));
      }
   }

   //get default options and saves in options table
   private function _setDefaultOptions()
   {
       update_option('cvns_options', $this->defaults);
   }

   //remove all options from database
   private function _removePluginOptions()
   {
       delete_option('cvns_options');
   }

   //
   private function _getCurrentOptions()
   {

       $cvns_options = get_option('cvns_options', $this->defaults);
       $this->options = $cvns_options;
   }

   ////////////////////////////////////////
   public function cvns_validate_options($input)
   {
    //validation stuff here

    return $input;
   }
    public function inject_javascript_in_page(){
      ?>
       <script type="text/javascript">
      //<![CDATA[
      if (typeof jQuery != 'undefined') {


          jQuery(document).ready(function($){
            jQuery('#commentform').validate({
              rules:{
                <?php
                  echo $this->options['cvns_rules'];
                ?>
              },

              messages:{
                <?php
                  echo $this->options['cvns_messages'];
                ?>
              },
              errorClass : '<?php echo ($this->options['cvns_error_class']!='')?$this->options['cvns_error_class']:'errort'; ?>',
              errorElement : '<?php echo ($this->options['cvns_error_element']!='')?$this->options['cvns_error_element']:'p'; ?>',
              submitHandler : function(form){
                form.submit();
                return false;
              }
            });
          });

      } //end if jQuery is not loaded
      //]]>
      </script>
           <?php
    }
    ////////
    function inject_css_in_page(){
      echo '<style type="text/css">';
      echo $this->options['cvns_styles'];
      echo '</style>';
    }
    ////


 }//end class




/**
 * Create new instance
 */
$ns_shortcode = new NS_Comment_Validator();
