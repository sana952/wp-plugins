<?php
/*
  Plugin Name: Post Metrics Plugin
  Description: A plugin that shows different metrics about a post like the number of words and paragraphs and reading time.
  Version: 1.0
  Author: Datajek
*/
/*
class PostMetricsPlugin {
    function __construct(){
        add_action('admin_menu', array($this, 'pmp_menu'));	
        add_action('admin_init', array($this, 'pmp_setting_options'));
        add_filter('the_content', array($this, 'calculate_post_metrics'));
    }

    //callback to create settings page/link in admin menu
    function pmp_menu(){
      add_options_page('Post Metrics Settings', 'Post Metrics', 'manage_options', 
                        'post-metrics-settings-page', array($this, 'render_settings_page')); 
  }

    //function to display HTML on the settings page
    function render_settings_page(){ ?>
        <div class="wrap">
          <h1>Post Metrics Settings</h1>
          <form action="options.php" method="POST"> <?php
            settings_fields('postmetricsplugin');
            do_settings_sections('post-metrics-settings-page');
            submit_button(); ?>
          </form>
        </div>
      <?php 
    }
*/
    /*
    //for lesson: Using WordPress Setting API
    //callback to register settings for plugin options
    function pmp_setting_options(){
        //step 1: Add a section to the settings page
        add_settings_section('pmp_first_section', null, null, 'post-metrics-settings-page');
        
        //step 2: Add an HTML field in the section
        add_settings_field('pmp_location', 'Display Location', array($this, 'display_location_html'), 'post-metrics-settings-page', 'pmp_first_section');
        
        //step 3: Register setting in the database
        register_setting('postmetricsplugin', 'pmp_location', array(
                                    'sanitize_callback' => 'sanitize_text_field',
                                    'default' => '0'  
                        ));
    }
    */
  /*  
    //for lesson: Cont..
    //callback to register settings for plugin options
    function pmp_setting_options(){
        //Add a section to the settings page
        add_settings_section('pmp_first_section', null, null, 'post-metrics-settings-page');
        
        //Display Location setting
        add_settings_field('pmp_location', 'Display Location', array($this, 'display_location_html'), 
                            'post-metrics-settings-page', 'pmp_first_section');
        register_setting('postmetricsplugin', 'pmp_location', array(
                                    'sanitize_callback' => 'sanitize_text_field',
                                    'default' => '0'  
                        ));

        //Read Time setting                
        add_settings_field('pmp_readtime', 'Read Time', array($this, 'checkbox_html'), 
                            'post-metrics-settings-page', 'pmp_first_section', 
                            array('name' => 'pmp_readtime'));
        register_setting('postmetricsplugin', 'pmp_readtime', array(
                                    'sanitize_callback' => 'sanitize_text_field',
                                    'default' => '1'  
                        ));

        //Word Count setting                
        add_settings_field('pmp_wordcount', 'Word Count', array($this, 'checkbox_html'), 
                           'post-metrics-settings-page', 'pmp_first_section', 
                            array('name' => 'pmp_wordcount'));
        register_setting('postmetricsplugin', 'pmp_wordcount', array(
                                    'sanitize_callback' => 'sanitize_text_field',
                                    'default' => '1'  
        ));
    
        //Paragraph Count setting                
        add_settings_field('pmp_paragraphcount', 'Paragraph Count', array($this, 'checkbox_html'), 
                           'post-metrics-settings-page', 'pmp_first_section', 
                            array('name' => 'pmp_paragraphcount'));
        register_setting('postmetricsplugin', 'pmp_paragraphcount', array(
                                    'sanitize_callback' => 'sanitize_text_field',
                                    'default' => '1'  
        ));

        //Words per Minute setting                
        add_settings_field('pmp_wordspermin', 'Words per Minute', array($this, 'wpm_html'), 
                           'post-metrics-settings-page', 'pmp_first_section');
        register_setting('postmetricsplugin', 'pmp_wordspermin', array(
                                    'sanitize_callback' => array($this, 'sanitize_wpm'),
                                    'default' => '300'  
        ));
    }

    //function to render the Display Location setting
    function display_location_html() { ?>
      <select name= "pmp_location">
        <option value="0" <?php selected(get_option('pmp_location'), '0'); ?>>Beginning of post</option>
        <option value="1" <?php selected(get_option('pmp_location'), '1'); ?>>End of post</option> 
      </select>
      <?php
    }
  
    //function to render checkbox setting
    function checkbox_html( $args ) { ?>
      <input type="checkbox" 
             name="<?php echo $args['name'] ?>" 
             value="1" 
            <?php checked(get_option($args['name']) , '1'); ?> >
      <?php
    }

    //function to render words per minute setting
    function wpm_html() { ?>
      <input type="text" name="pmp_wordspermin"  
             value="<?php echo esc_attr(get_option('pmp_wordspermin')); ?>" >
      <?php
    }
/*
    //function to render the Read Time setting
    function read_time_html() { ?>
      <input type="checkbox" name="pmp_readtime" value="1" 
                  <?php checked(get_option('pmp_readtime') , '1'); ?> 
                  >
      <?php
    }
*/
/*
    //Validation of the words oer minute value
    function sanitize_wpm( $input ){
      if($input < 200 OR $input > 300) {
        add_settings_error('pmp_wordspermin', 'pmp_wpm_error', 
                           'Words per Minute value must be between 200 and 300');
        return get_option('pmp_wordspermin');
      }
      return $input;
    }

    //calculate post metrics
    function calculate_post_metrics($content){
      if( is_main_query() AND is_single() AND (get_option('pmp_readtime', '1') OR 
                                               get_option('pmp_readtime', '1') OR 
                                               get_option('pmp_paragraphcount', '1') )){
        //word count
      	$wordcount = str_word_count( strip_tags($content));
	      //readtime
        $readtime = round($wordcount/get_option('pmp_wordspermin', 300));
        //paragraph count
        $paragraphcount= substr_count( $content, '</p>' );
        
        $text = '<h3>Post Metrics</h3>';
        
        if(get_option('pmp_readtime') == '1')
          $text .= '<p>Read time: ' . $readtime . ' minute(s).</p>';	
        
        if(get_option('pmp_wordcount') == '1' AND get_option('pmp_paragraphcount') == null)
          $text .= '<p>This post has ' . $wordcount . ' words.</p>';
        
          else if(get_option('pmp_wordcount') == '1' AND get_option('pmp_paragraphcount') == '1')
            $text .= '<p>This post has ' . $wordcount . ' words and ' . $paragraphcount . ' paragraphs.</p>';	
        
          else if(get_option('pmp_wordcount') == null AND get_option('pmp_paragraphcount') == '1')
            $text .= '<p>This post has ' . $paragraphcount . ' paragraphs.</p>';	
        
          $text .= '<br>';    

        if(get_option('pmp_location') == '0')
          return $text .  $content;
          else
            return $content . $text;
      }
      return $content;
    }
    
    
}

$postMetricsPlugin = new PostMetricsPlugin();
*/