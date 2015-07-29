<?php  
/* 
    Plugin Name: Cloak Front End Email
    Description: Display your email in javascript on your webiste with short code [email]. 
    Author: <a href="http://www.webbernaut.com/">Webbernaut</a> 
    Version: 1.0 
*/

//Allow Ajax js_admin_email front end and backend
  add_action('wp_ajax_cfe_js_admin_email', 'cfe_get_admin_email');
  add_action('wp_ajax_nopriv_cfe_js_admin_email', 'cfe_get_admin_email');

//Grab Email PHP
  function cfe_get_admin_email(){
    echo get_option('admin_email');
    die();
  }

//Set Ajax on front end
  function cfe_frontend_ajaxurl() { ?>
    <script type="text/javascript">
      var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
  <?php }
  add_action('wp_head','cfe_frontend_ajaxurl');
    
//Email JS Shorcode [email]
  function cfe_jsEmailShortcode($atts){
      return '<a href="#"><span class="cfe-jsemail">enable javascript</span></a>';
  }
  add_shortcode('email', 'cfe_jsEmailShortcode');
       
//Write js to wpheader
  function cfe_frontend_email_javascript() { ?>
   <script type="text/javascript" >
    //Email Anti Spam
    jQuery.ajax({
          type : "get",
          dataType : "text",
          url : ajaxurl,
          data : {action: "cfe_js_admin_email"},
         
          success: function(data) {
            jQuery('.cfe-jsemail').html(function(){
                var a = data;
                var h = 'mailto:' + a;
                jQuery(this).parent('a').attr('href', h);
                return a;
             });
          }
    })
   </script>
<?php exit; }
  add_action( 'wp_footer', 'cfe_frontend_email_javascript' );

//End of Plugin  
?>