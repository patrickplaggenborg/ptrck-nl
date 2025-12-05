<?php

/**
 * WPLE_Admin class
 * 
 * Handles all the aspects of plugin page & cert generation form
 * @since 1.0.0
 */
class WPLE_Admin
{
    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'wple_admin_styles' ) );
        add_action( 'admin_menu', array( $this, 'wple_admin_menu_page' ) );
        add_action(
            'before_wple_admin_form',
            array( $this, 'wple_debug_log' ),
            20,
            1
        );
        add_action(
            'before_wple_admin_form',
            array( $this, 'wple_download_links' ),
            30,
            1
        );
        add_action( 'admin_init', array( $this, 'wple_save_email_generate_certs' ) );
        add_action( 'admin_init', array( $this, 'wple_download_files' ) );
        add_action( 'plugins_loaded', array( $this, 'wple_load_plugin_textdomain' ) );
        $wple_opts = ( get_option( 'wple_opts' ) === FALSE ? array() : get_option( 'wple_opts' ) );
        if ( isset( $wple_opts['wple_show_notice'] ) ) {
            if ( $wple_opts['wple_show_notice'] == 1 ) {
                add_action( 'admin_notices', array( $this, 'wple_rateus' ) );
            }
        }
        add_action( 'wp_ajax_wple_dismiss', array( $this, 'wple_dismiss_notice' ) );
        add_action( 'init', array( $this, 'wple_http_challenge_rewrite' ) );
    }
    
    /**
     * Enqueue admin styles
     * 
     * @since 1.0.0
     * @return void
     */
    public function wple_admin_styles()
    {
        wp_enqueue_style(
            WPLE_NAME,
            WPLE_URL . 'admin/css/le-admin.css',
            FALSE,
            WPLE_VERSION,
            'all'
        );
        wp_enqueue_script(
            WPLE_NAME . '-popper',
            WPLE_URL . 'admin/js/popper.min.js',
            array( 'jquery' ),
            WPLE_VERSION,
            true
        );
        wp_enqueue_script(
            WPLE_NAME . '-tippy',
            WPLE_URL . 'admin/js/tippy-bundle.iife.min.js',
            array( 'jquery' ),
            WPLE_VERSION,
            true
        );
        wp_enqueue_script(
            WPLE_NAME,
            WPLE_URL . 'admin/js/le-admin.js',
            array( 'jquery' ),
            WPLE_VERSION,
            true
        );
        wp_enqueue_script(
            WPLE_NAME . '-fs',
            'https://checkout.freemius.com/checkout.min.js',
            array( 'jquery' ),
            WPLE_VERSION,
            false
        );
    }
    
    /**
     * Register plugin page
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_admin_menu_page()
    {
        add_menu_page(
            WPLE_NAME,
            WPLE_NAME,
            'manage_options',
            WPLE_SLUG,
            array( $this, 'wple_menu_page' ),
            plugin_dir_url( __DIR__ ) . 'admin/assets/icon.png',
            100
        );
    }
    
    public function wple_load_plugin_textdomain()
    {
        load_plugin_textdomain( 'wp-letsencrypt-ssl', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    
    /**
     * Plugin page HTML
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_menu_page()
    {
        $this->wple_subdir_ipaddress();
        $eml = '';
        $leopts = get_option( 'wple_opts' );
        $checked = ( isset( $leopts['force_ssl'] ) && $leopts['force_ssl'] ? 'checked' : '' );
        if ( $opts = get_option( 'wple_opts' ) ) {
            $eml = ( isset( $opts['email'] ) ? $opts['email'] : '' );
        }
        $html = '
    <div class="wple-header">
      <img src="' . WPLE_URL . 'admin/assets/logo.png" class="wple-logo"/> <span class="wple-version">v' . WPLE_VERSION . '</span>
    </div>';
        $this->wple_success_block( $html );
        $this->wple_error_block( $html );
        if ( !wple_fs()->is__premium_only() || !wple_fs()->can_use_premium_code() ) {
            $this->wple_upgrade_block( $html );
        }
        $html .= '<div id="wple-sslgen">
    <h2>' . esc_html__( 'ENTER YOUR EMAIL BELOW AND GENERATE SSL IN ONE CLICK', 'wp-letsencrypt-ssl' ) . '</h2>';
        $leadminform = '<form method="post" class="le-genform">
    <input type="email" name="wple_email" value="' . esc_attr( $eml ) . '" placeholder="' . esc_attr__( 'Enter your email address', 'wp-letsencrypt-ssl' ) . '" required><br />';
        if ( isset( $_GET['includewww'] ) ) {
            $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_include_www" value="1">
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . esc_html__( 'Generate SSL Certificate for both www & non-www version of domain', 'wp-letsencrypt-ssl' ) . '&nbsp; <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( "Before enabling this - please make sure both www & non-www version of your domain works!. Add a CNAME with name 'www' pointing to your non-www domain", 'wp-letsencrypt-ssl' ) . '"></span></label>
    </span><br />';
        }
        $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_send_usage" value="1" checked>
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . esc_html__( 'Anonymously send response data to improve this plugin', 'wp-letsencrypt-ssl' ) . '</label>
    </span><br />    
    <span class="lecheck">
    <label class="checkbox-label">
      <input type="checkbox" name="wple_agree_le_tos" value="1" required>
      <span class="checkbox-custom rectangular"></span>
    </label>
    ' . $this->wple_kses( sprintf( __( "I agree to <b>Let's Encrypt</b> %sTerms of service%s", "wp-letsencrypt-ssl" ), '<a href="' . esc_attr__( 'https://letsencrypt.org/repository/', 'wp-letsencrypt-ssl' ) . '" rel="nofollow" target="_blank" style="margin-left:5px">', '</a>' ), 'a' ) . '
    </span> 
    <span class="lecheck">
    <label class="checkbox-label">
      <input type="checkbox" name="wple_agree_gws_tos" value="1" required>
      <span class="checkbox-custom rectangular"></span>
    </label>
    ' . $this->wple_kses( sprintf( __( "I agree to <b>Go Web Smarty</b> %sTerms of service%s", "wp-letsencrypt-ssl" ), '<a href="https://gowebsmarty.com/terms-and-conditions/" rel="nofollow" target="_blank" style="margin-left:5px">', '</a>' ), 'a' ) . '
    </span>        
    ' . wp_nonce_field(
            'legenerate',
            'letsencrypt',
            false,
            false
        ) . '
    <button type="submit" name="generate-certs">' . esc_html__( 'Generate Free SSL Certificate', 'wp-letsencrypt-ssl' ) . '</button>
    </form>';
        $wildcardleadminform = '';
        $html .= '<div id="le-tabbed-sections">    
    <span class="le-section-title active" data-section="single-domain-ssl">' . esc_html__( 'Single Domain SSL', 'wp-letsencrypt-ssl' ) . '</span>';
        $currentdomain = str_ireplace( array( 'http://', 'https://' ), array( '', '' ), site_url() );
        $cname = '';
        if ( stripos( $currentdomain, 'www' ) === FALSE ) {
            $cname = '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( "Add a CNAME with name 'www' pointing to your non-www domain", 'wp-letsencrypt-ssl' ) . '"></span>';
        }
        $html .= '<span class="le-section-title" data-section="force-ssl">' . esc_html__( 'Force HTTPS', 'wp-letsencrypt-ssl' ) . '</span>
    <span class="le-section-title" data-section="download-certs">' . esc_html__( 'Download Certs', 'wp-letsencrypt-ssl' ) . '</span>
    <span class="le-section-title" data-section="faq">' . esc_html__( 'FAQ', 'wp-letsencrypt-ssl' ) . '</span>
    <span class="le-section-title" data-section="go-viral">' . esc_html__( 'How to use?', 'wp-letsencrypt-ssl' ) . '</span>
  
    <div class="le-section single-domain-ssl active">
    <h3>' . esc_html__( 'Install SSL for', 'wp-letsencrypt-ssl' ) . ' ' . $currentdomain . ' ' . $cname . '</h3>';
        ob_start();
        do_action( 'before_wple_admin_form', $html );
        $html .= ob_get_contents();
        ob_end_clean();
        if ( isset( $_GET['dnsverify'] ) ) {
            $html .= '<h2 style="text-align:center;line-height:1.4em">' . esc_html__( 'Hope you have added the above DNS records! Please wait few minutes for DNS propagation to complete & run the below "Generate Free SSL" form again.', 'wp-letsencrypt-ssl' ) . '</h2>';
        }
        $html .= apply_filters( 'wple_admin_form', $leadminform );
        ob_start();
        do_action( 'after_wple_admin_form', $html );
        $html .= ob_get_contents();
        ob_end_clean();
        $html .= '
    </div><!--single-domain-ssl-->
    <div class="le-section wildcard-ssl">';
        $html .= '</div>';
        $html .= '<div class="le-section force-ssl">';
        $html .= "<div class=\"wple-force\">\r\n      <p>" . $this->wple_kses( __( "If you still don't see a green padlock or notice <b>mixed content</b> warning in your browser console due to resources being loaded over http:// - please enable the below option to force SSL on all resources of site.", 'wp-letsencrypt-ssl' ) ) . "</p>\r\n      <p><strong>" . esc_html__( 'WARNING', 'wp-letsencrypt-ssl' ) . ":</strong> " . esc_html__( "Use this feature with CAUTION. Enabling this will immediately force https and might cause issues accessing the site IF you have NOT installed the SSL certificate properly. If you face difficulty accessing site - You will need to manually revert back to http:// as explained here -", 'wp-letsencrypt-ssl' ) . " <b>https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/</b></p>";
        $html .= '<form method="post">
      <label class="checkbox-label" style="float:left">
      <input type="checkbox" name="wple_forcessl" value="1" ' . $checked . '>
        <span class="checkbox-custom rectangular"></span>
      </label>

      <label>' . esc_html__( 'Force SSL throughout the entire site', 'wp-letsencrypt-ssl' ) . '</label><br />
      ' . wp_nonce_field(
            'wpleforcessl',
            'site-force-ssl',
            false,
            false
        ) . '
      <button type="submit" name="wple_ssl">' . esc_html__( 'Save', 'wp-letsencrypt-ssl' ) . '</button>
      </form>
      </div>';
        $html .= '</div>
    <div class="le-section download-certs">';
        $cert = ABSPATH . 'keys/certificate.crt';
        
        if ( file_exists( $cert ) ) {
            $html .= '<ul>
      <li class="le-dwnld"><a href="?page=wp_encryption&le=1">' . esc_html__( 'Download cert file', 'wp-letsencrypt-ssl' ) . '</a></li>
      <li class="le-dwnld"><a href="?page=wp_encryption&le=2">' . esc_html__( 'Download key file', 'wp-letsencrypt-ssl' ) . '</a></li>
      <li class="le-dwnld"><a href="?page=wp_encryption&le=3">' . esc_html__( 'Download ca bundle', 'wp-letsencrypt-ssl' ) . '</a></li>
      </ul>';
        } else {
            $html .= '<b>' . esc_html__( "You don't have any SSL certificates generated yet! Please generate your single/wildcard SSL first before you can download it here.", 'wp-letsencrypt-ssl' ) . '</b>';
        }
        
        $html .= '</div>
    <div class="le-section faq">';
        $this->wple_faq_block( $html );
        $html .= '</div>

    <div class="le-section go-viral">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/KQ2HYtplPEk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>   
    <h2 style="margin:30px 0 20px">Try our social sharing plugin with share analytics!</h2>  
    <a href="https://wordpress.org/plugins/go-viral/" target="_blank"><img src="' . WPLE_URL . 'admin/assets/go-viral.jpg"/></a>
    </div>

    <div class="le-powered">
		  <span>' . $this->wple_kses( sprintf( __( 'Help your locale users by translating this page to your language!. %sSign-Up / Login and start translating right away%s.' ), '<a href="https://translate.wordpress.org/projects/wp-plugins/wp-letsencrypt-ssl/" target="_blank">', '</a>' ), 'a' ) . '</span>
	  </div>

    </div><!--le-tabbed-sections-->';
        $html .= '</div><!--wple-sslgen-->';
        $html .= '  
    <div class="wrap" id="le-wrap">

    <div class="le-inner">';
        $cert = ABSPATH . 'keys/certificate.crt';
        $cexpiry = '';
        if ( file_exists( $cert ) && isset( $opts['expiry'] ) ) {
            $cexpiry = ' (' . esc_html__( 'Your current SSL certificate expires on', 'wp-letsencrypt-ssl' ) . ' <span style="color:#fb4646;font-weight:600">' . $opts['expiry'] . '</span>)';
        }
        $html .= '<div class="le-buypro">
      <p>' . $this->wple_kses( __( "Let's Encrypt is a free, automated, and open certificate authority brought to you by the non-profit Internet Security Research Group (ISRG). Free SSL certificate provided by Let's Encrypt expires every <b>90 days</b> so you will need to re-generate SSL certificates again here before the expiry date", 'wp-letsencrypt-ssl' ) ) . $cexpiry . '.<br>' . $this->wple_kses( __( 'Love this plugin? Wanna donate for this wonderful work? Buy the <b>Auto renewal + Wildcard</b> add-on to avoid manual work of re-generating certificates every 90 days.', 'wp-letsencrypt-ssl' ) ) . '</p>
      <p class="le-offer">' . esc_html__( "Limited period offer! ONE time purchase - LIFETIME SSL", 'wp-letsencrypt-ssl' ) . '</p>
      <p><a href="https://gowebsmarty.com/product/wp-encryption-pro/?utm_source=wordpress&utm_medium=comparison&utm_campaign=wpencryption" target="_blank" class="wplecompare">' . esc_html__( 'COMPARE FREE & PRO VERSION', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-external"></span></a></p>
      <a href="#" class="le-buypro-button">' . esc_html__( 'BUY WP ENCRYPTION PRO TODAY!', 'wp-letsencrypt-ssl' ) . '</a>
      </div>';
        $html .= '  
    </div>
    </div>';
        echo  $html ;
    }
    
    /**
     * log process & error in debug.log file
     *
     * @since 1.0.0
     * @param string $html
     * @return void
     */
    public function wple_debug_log( $html )
    {
        
        if ( !file_exists( WPLE_DEBUGGER ) ) {
            wp_mkdir_p( WPLE_DEBUGGER );
            $htacs = '<Files debug.log>' . "\n" . 'Order allow,deny' . "\n" . 'Deny from all' . "\n" . '</Files>';
            file_put_contents( WPLE_DEBUGGER . '.htaccess', $htacs );
        }
        
        $html = '<div class="toggle-debugger"><span class="dashicons dashicons-arrow-down-alt2"></span> ' . esc_html__( 'Show/hide full response', 'wp-letsencrypt-ssl' ) . '</div>';
        $file = WPLE_DEBUGGER . 'debug.log';
        
        if ( file_exists( $file ) ) {
            $log = file_get_contents( $file );
            $hideh2 = '';
            if ( isset( $_GET['dnsverified'] ) || isset( $_GET['dnsverify'] ) ) {
                $hideh2 = 'hideheader';
            }
            $html .= '<div class="le-debugger running ' . $hideh2 . '"><h3>' . esc_html__( 'Response Log', 'wp-letsencrypt-ssl' ) . ':</h3>' . wp_kses_post( nl2br( $log ) ) . '</div>';
        } else {
            $html .= '<div class="le-debugger">' . esc_html__( "Full response will be shown here", 'wp-letsencrypt-ssl' ) . '</div>';
        }
        
        echo  $html ;
    }
    
    /**
     * Save email & proceed upon clicking install SSL
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_save_email_generate_certs()
    {
        //since 2.4.0
        //force https upon success
        
        if ( isset( $_POST['wple-https'] ) ) {
            if ( !wp_verify_nonce( $_POST['sslready'], 'wplehttps' ) ) {
                exit( 'Unauthorized access' );
            }
            $basedomain = str_ireplace( array( 'http://', 'https://' ), array( '', '' ), addslashes( site_url() ) );
            $streamContext = stream_context_create( [
                'ssl' => [
                'capture_peer_cert' => true,
            ],
            ] );
            $client = @stream_socket_client(
                "ssl://{$basedomain}:443",
                $errorNumber,
                $errorDescription,
                30,
                STREAM_CLIENT_CONNECT,
                $streamContext
            );
            
            if ( !$client ) {
                wp_redirect( admin_url( '/admin.php?page=wp_encryption&success=1&nossl=1', 'http' ) );
                exit;
            }
            
            // $SSLCheck = @fsockopen("ssl://" . $basedomain, 443, $errno, $errstr, 30);
            // if (!$SSLCheck) {
            //   wp_redirect(admin_url('/admin.php?page=wp_encryption&success=1&nossl=1', 'http'));
            //   exit();
            // }
            $reverter = uniqid( 'wple' );
            $savedopts = get_option( 'wple_opts' );
            $savedopts['force_ssl'] = 1;
            $savedopts['revertnonce'] = $reverter;
            $this->wple_send_reverter_secret( $reverter );
            update_option( 'wple_opts', $savedopts );
            update_option( 'siteurl', str_ireplace( 'http:', 'https:', get_option( 'siteurl' ) ) );
            update_option( 'home', str_ireplace( 'http:', 'https:', get_option( 'home' ) ) );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption', 'https' ) );
        }
        
        //single domain ssl
        
        if ( isset( $_POST['generate-certs'] ) ) {
            if ( !wp_verify_nonce( $_POST['letsencrypt'], 'legenerate' ) ) {
                die( 'Unauthorized request' );
            }
            if ( empty($_POST['wple_email']) ) {
                wp_die( esc_html__( 'Please input valid email address', 'wp-letsencrypt-ssl' ) );
            }
            $leopts = array(
                'email'         => sanitize_email( $_POST['wple_email'] ),
                'date'          => date( 'd-m-Y' ),
                'expiry'        => '',
                'type'          => 'single',
                'send_usage'    => ( isset( $_POST['wple_send_usage'] ) ? 1 : 0 ),
                'include_www'   => ( isset( $_POST['wple_include_www'] ) ? 1 : 0 ),
                'agree_gws_tos' => ( isset( $_POST['wple_agree_gws_tos'] ) ? 1 : 0 ),
                'agree_le_tos'  => ( isset( $_POST['wple_agree_le_tos'] ) ? 1 : 0 ),
            );
            update_option( 'wple_opts', $leopts );
            require_once WPLE_DIR . 'classes/le-core.php';
            
            if ( isset( $_GET['dnsverify'] ) ) {
                new WPLE_Core(
                    $leopts,
                    true,
                    false,
                    true
                );
            } else {
                new WPLE_Core( $leopts );
            }
        
        }
        
        //force ssl
        
        if ( isset( $_POST['site-force-ssl'] ) ) {
            if ( !wp_verify_nonce( $_POST['site-force-ssl'], 'wpleforcessl' ) ) {
                die( 'Unauthorized request' );
            }
            $basedomain = str_ireplace( array( 'http://', 'https://' ), array( '', '' ), addslashes( site_url() ) );
            $streamContext = stream_context_create( [
                'ssl' => [
                'capture_peer_cert' => true,
            ],
            ] );
            $client = @stream_socket_client(
                "ssl://{$basedomain}:443",
                $errorNumber,
                $errorDescription,
                30,
                STREAM_CLIENT_CONNECT,
                $streamContext
            );
            if ( !$client ) {
                //not really stable solution
                //wp_die('Could not detect SSL certificate on your domain. Please make sure you have SSL certificate installed via cPanel before forcing https. Alternatively, You could use Really Simple SSL as additional plugin to force HTTPS.');
                //exit();
            }
            $reverter = uniqid( 'wple' );
            $leopts = get_option( 'wple_opts' );
            $leopts['force_ssl'] = ( isset( $_POST['wple_forcessl'] ) ? 1 : 0 );
            if ( $leopts['force_ssl'] == 1 ) {
                $leopts['revertnonce'] = $reverter;
            }
            update_option( 'wple_opts', $leopts );
            
            if ( $leopts['force_ssl'] == 1 ) {
                $this->wple_send_reverter_secret( $reverter );
                update_option( 'siteurl', str_ireplace( 'http:', 'https:', get_option( 'siteurl' ) ) );
                update_option( 'home', str_ireplace( 'http:', 'https:', get_option( 'home' ) ) );
            }
        
        }
    
    }
    
    /**
     * Ability to download cert files from plugin page
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_download_links()
    {
        $cert = ABSPATH . 'keys/certificate.crt';
        $leopts = get_option( 'wple_opts' );
        
        if ( file_exists( $cert ) && isset( $leopts['expiry'] ) ) {
            $list = '<ul>    
      <li class="le-expirydate">' . esc_html__( 'Your current SSL certificate expires on', 'wp-letsencrypt-ssl' ) . ': <b>' . esc_html( $leopts['expiry'] ) . '</b> (' . esc_html__( 'Major browsers like Chrome will start showing insecure site warning IF you fail to renew / re-generate certs before this expiry date. If you are using PRO version - SSL certificates will be auto renewed in background a week prior to expiry date.', 'wp-letsencrypt-ssl' ) . ')</li>
      </ul>';
            echo  $list ;
        }
    
    }
    
    /**
     * Download cert files based on clicked link
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_download_files()
    {
        
        if ( isset( $_GET['le'] ) && current_user_can( 'manage_options' ) ) {
            switch ( $_GET['le'] ) {
                case '1':
                    $file = uniqid() . '-cert.crt';
                    file_put_contents( $file, file_get_contents( ABSPATH . 'keys/certificate.crt' ) );
                    break;
                case '2':
                    $file = uniqid() . '-key.pem';
                    file_put_contents( $file, file_get_contents( ABSPATH . 'keys/private.pem' ) );
                    break;
                case '3':
                    $file = uniqid() . '-cabundle.crt';
                    file_put_contents( $file, file_get_contents( WPLE_DIR . 'cabundle/ca.crt' ) );
                    break;
            }
            header( 'Content-Description: File Transfer' );
            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Length: ' . filesize( $file ) );
            header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
            readfile( $file );
            exit;
        }
    
    }
    
    /**
     * Rate us admin notice
     *
     * @since 2.0.0
     * @return void
     */
    public function wple_rateus()
    {
        $cert = ABSPATH . 'keys/certificate.crt';
        ///global $current_screen;
        ///$base = $current_screen->base;
        
        if ( file_exists( $cert ) ) {
            ?>
        <div class="notice notice-success wplerateus">
          <p><?php 
            esc_html_e( 'Congrats on generating your SSL certificate successfully with', 'wp-letsencrypt-ssl' );
            echo  ' <b>WP Encryption</b>! ' ;
            esc_html_e( 'If that saved your precious time,', 'wp-letsencrypt-ssl' );
            ?>&nbsp;<a href="https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post" target="_blank"><?php 
            esc_html_e( 'Please give us a 5 star review (Opens in new tab)', 'wp-letsencrypt-ssl' );
            ?> </a><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span> <?php 
            ?>&nbsp;|&nbsp; <a href="<?php 
            echo  admin_url( '/admin.php?page=wp_encryption-pricing' ) ;
            ?>"><?php 
            esc_html_e( 'UPGRADE TO PRO', 'wp-letsencrypt-ssl' );
            ?></a><?php 
            ?>

          <span class="dashicons dashicons-dismiss wple-dismiss"></span>
          </p>
        </div>
  <?php 
        }
    
    }
    
    public function wple_dismiss_notice()
    {
        $opts = get_option( 'wple_opts' );
        $opts['wple_show_notice'] = 0;
        update_option( 'wple_opts', $opts );
        exit;
    }
    
    /**
     * Check if wp install is IP or subdir based
     *
     * @since 2.4.0
     * @return void
     */
    public function wple_subdir_ipaddress()
    {
        $siteURL = str_ireplace( array( 'http://', 'https://', 'www.' ), array( '', '', '' ), site_url() );
        $flg = 0;
        if ( filter_var( $siteURL, FILTER_VALIDATE_IP ) ) {
            $flg = 1;
        }
        if ( FALSE !== stripos( $siteURL, '/' ) || FALSE !== stripos( $siteURL, 'localhost' ) ) {
            $flg = 1;
        }
        
        if ( $flg ) {
            $html = '<div class="wrap" id="le-wrap">
      <div class="le-inner">
        <div class="wple-header">
          <img src="' . WPLE_URL . 'admin/assets/logo.png" class="wple-logo"/> <span class="wple-version">v' . esc_html( WPLE_VERSION ) . '</span>
        </div>
        <div class="wple-warning-notice">
        <h2>' . esc_html__( 'SSL Certificates cannot be issued for localhost, sub-directory, IP address based WordPress site. Please use this on your primary domain or sub-domain based WordPress.', 'wp-letsencrypt-ssl' ) . '</h2>      
        </div>
      </div>
      </div>';
            echo  $html ;
            wp_die();
        }
    
    }
    
    /**
     * Upgrade to PRO
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_upgrade_block( &$html )
    {
        $upgradeurl = admin_url( '/admin.php?page=wp_encryption-pricing' );
        $automatic = esc_html__( 'Automatic', 'wp-letsencrypt-ssl' );
        $manual = esc_html__( 'Manual', 'wp-letsencrypt-ssl' );
        $html .= ' 
      <div id="wple-upgradepro">
          <div class="wple-plans">
            <span class="free">* ' . esc_html__( 'FREE', 'wp-letsencrypt-ssl' ) . '</span>
            <span class="pro">* ' . esc_html__( 'PRO', 'wp-letsencrypt-ssl' ) . '</span>
          </div>
          <div class="wple-plan-compare">
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/verified.png"/>
              <h4>' . esc_html__( 'HTTP Verification', 'wp-letsencrypt-ssl' ) . '</h4>
              <span class="wple-free">' . $automatic . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/DNS.png"/>
              <h4>' . esc_html__( 'DNS Verification', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'In case of HTTP verification fail / not possible', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/Certificate.png"/>
              <h4>' . esc_html__( 'Certificate Issuance', 'wp-letsencrypt-ssl' ) . '</h4>
              <span class="wple-free">' . $automatic . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/Install.png"/>
              <h4>' . esc_html__( 'Certificate Installation', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'PRO - We offer one time free manual support for non-cPanel based sites', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/wildcard.png"/>
              <h4>' . esc_html__( 'Wildcard SSL', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'PRO - Your domain DNS must be managed by cPanel for full automation', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . esc_html__( 'Not Available', 'wp-letsencrypt-ssl' ) . '</span>
              <span class="wple-pro">' . esc_html__( 'Available', 'wp-letsencrypt-ssl' ) . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/renewal.png"/>
              <h4>' . esc_html__( 'Auto Renewal', 'wp-letsencrypt-ssl' ) . '</h4>
              <span class="wple-free">' . esc_html__( 'Not Available', 'wp-letsencrypt-ssl' ) . '</span>
              <span class="wple-pro">' . esc_html__( 'Available', 'wp-letsencrypt-ssl' ) . '</span>
            </div>
          </div>

          <div class="wple-upgrade-pro">
              <a href="' . $upgradeurl . '">' . esc_html__( 'UPGRADE TO PRO', 'wp-letsencrypt-ssl' ) . '</a>
          </div>
      </div><!--wple-upgradepro-->
      ';
    }
    
    /**
     * Success Message block
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_success_block( &$html )
    {
        //since 2.4.0
        
        if ( isset( $_GET['success'] ) ) {
            $html .= '
      <div id="wple-sslgenerator">
      <div class="wple-success-form">';
            $this->wple_send_success_mail();
            $html .= '<span class="dashicons dashicons-yes"></span><h2>' . $this->wple_kses( __( '<b>Congratulations!</b> SSL Certificate have been successfully generated for your site. You do not need to run this AGAIN! You have one final step to follow - Download Certificates from <b>"Download Certs"</b> tab below and install it via SSL/TLS on your cPanel following the below simple video tutorial (Our <b>PRO</b> version handles this installation process on its own!). Once after completion, Enable HTTPS using the below button.', 'wp-letsencrypt-ssl' ) ) . '</h2>

          <iframe width="560" height="315" src="https://www.youtube.com/embed/KQ2HYtplPEk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

          <ul>          
          <li>' . $this->wple_kses( __( '<b>Note:</b> Use below "Enable HTTPS" button ONLY after SSL certificate is successfully installed on your cPanel', 'wp-letsencrypt-ssl' ) ) . '</li>
          <li>' . $this->wple_kses( __( '<b>Dont have cPanel hosting?</b> Download the certs and send it to your hosting support to install it for you. Alternatively, upgrade to Pro version & let us handle this installation task.', 'wp-letsencrypt-ssl' ) ) . '</li>
          <li>' . esc_html__( 'By enabling HTTPS, We will change your site to https:// protocol. You will be prompted to re-login.', 'wp-letsencrypt-ssl' ) . '</li>
          <li>' . esc_html__( 'We will force all the assets, js, css, images to strictly load over https:// to avoid mixed content warnings.', 'wp-letsencrypt-ssl' ) . '</li>
          </ul>';
            if ( isset( $_GET['nossl'] ) ) {
                $html .= '<h2 style="color:red">' . esc_html__( 'We could not detect installed SSL on your site!. Anyhow you can completely ignore this step and enable the force SSL feature IF you have successfully installed the SSL certificates on your cPanel.', 'wp-letsencrypt-ssl' ) . '</h2>';
            }
            $html .= '<form method="post">
        ' . wp_nonce_field(
                'wplehttps',
                'sslready',
                false,
                false
            ) . '
        <button type="submit" name="wple-https">' . esc_html__( 'ENABLE HTTPS NOW', 'wp-letsencrypt-ssl' ) . '</button>
        </form>
        </div>
        </div><!--wple-sslgenerator-->';
        }
    
    }
    
    /**
     * Error Message block
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_error_block( &$html )
    {
        if ( isset( $_GET['error'] ) ) {
            $html .= '
      <div id="wple-sslgenerator" class="error">
        <div class="wple-error-message">
          ' . esc_html__( 'There was some issue while generating SSL for your site. Please check the full response below.', 'wp-letsencrypt-ssl' ) . '
        </div>
      </div><!--wple-sslgenerator-->';
        }
    }
    
    /**
     * FAQ block
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_faq_block( &$html )
    {
        $html .= '<h4>' . esc_html__( 'Does installing the plugin will instantly turn my site https?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html__( 'Installing SSL certificate is a server side process and not as simple as installing a ready widget and using it instantly. You will have to follow some simple steps to install SSL for your WordPress site. Our plugin acts like a tool to generate and install SSL for your WordPress site. On FREE version of plugin - You should manually go through the SSL certificate installation process following the simple video tutorial. Whereas, the SSL certificates are easily generated by our plugin by running a simple SSL generation form.', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'Response log shows SSL certificate is installed but why am I still not seeing green padlock on frontend site?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . $this->wple_kses( sprintf( __( 'Please change your WordPress and Site URL to https:// in <a href="%s">Settings->General</a>. If that still dont resolve the issue, use the <b>Force SSL</b> feature.', 'wp-letsencrypt-ssl' ), 'options-general.php' ), 'a' ) . '</p>      
      <hr>
      <h4>' . esc_html__( 'How to install SSL for both www & non-www version of my domain?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . $this->wple_kses( 'First of all, Please make sure you can access your site with and without www. Otherwise you will be not able to complete domain verification for both www & non-www together. Open <strong>WP Encryption</strong> page with <strong>&includewww=1</strong> appended to end of the URL (Ex: <strong>/wp-admin/admin.php?page=wp_encryption&includewww=1</strong>) and run the SSL form with <strong>"Generate SSL for both www & non-www"</strong> option checked.', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How to install generated SSL on cPanel?', 'wp-letsencrypt-ssl' ) . '</h4>      
      <p><iframe width="560" height="315" src="https://www.youtube.com/embed/KQ2HYtplPEk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
      <hr>
      <h4>' . esc_html__( 'How to install generated SSL for non-cPanel sites?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p><iframe width="560" height="315" src="https://www.youtube.com/embed/PANs_C2SI5Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
      <hr>
      <h4>' . esc_html__( 'How to add 2 new TXT based DNS records for domain verification?', 'wp-letsencrypt-ssl' ) . '</h4>      
      <p><iframe width="560" height="315" src="https://www.youtube.com/embed/DswZaY_fHfE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
      <hr>
      <h4>' . esc_html__( 'How do I renew my SSL certificate before expiry date?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . $this->wple_kses( __( 'Your SSL certificate will be auto renewed if you have <b>WP Encryption PRO</b> plugin purchased (SSL certs will be auto renewed in background just before the expiry date). If you have free version of plugin installed, You can use the same process of "Generate free SSL" to get new certs.', 'wp-letsencrypt-ssl' ) ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How do I install Wildcard SSL?', 'wp-letsencrypt-ssl' ) . '</h4>      
      <p>' . $this->wple_kses( __( 'If you have purchased the <b>WP Encryption PRO</b> version, You can notice a new tab for One click Wildcard SSL generation and installation.', 'wp-letsencrypt-ssl' ) ) . '</p>
      <hr>      
      <h4>' . esc_html__( 'How to test if my SSL installation is good?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . $this->wple_kses( sprintf( __( 'You can run a SSL test by entering your website url in <a href="%s" rel="%s">SSL Labs</a> site.', 'wp-letsencrypt-ssl' ), 'https://www.ssllabs.com/ssltest/', 'nofollow' ), 'a' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'Have a different question?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . $this->wple_kses( sprintf( __( 'Please use our <a href="%s" target="%s">Plugin support forum</a>. <b>PRO</b> users can register free account & use priority support at gowebsmarty.in', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/plugin/wp-letsencrypt-ssl/', '_blank' ), 'a' ) . '</p>';
    }
    
    /**
     * Send email to user on success
     * 
     * @since 3.0.0
     */
    private function wple_send_success_mail()
    {
        $opts = get_option( 'wple_opts' );
        $to = sanitize_email( $opts['email'] );
        $subject = esc_html__( 'Congratulations! Your SSL certificates have been generated using WP Encryption Plugin', 'wp-letsencrypt-ssl' );
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $body = '<h2>' . esc_html__( 'You are just one step behind enabling HTTPS for your WordPress site', 'wp-letsencrypt-ssl' ) . '</h2>';
        $body .= '<p>' . esc_html__( 'Download the generated SSL certificates from below given links and install it on your cPanel following the video tutorial', 'wp-letsencrypt-ssl' ) . ' (https://youtu.be/KQ2HYtplPEk). ' . esc_html__( 'These certificates expires on', 'wp-letsencrypt-ssl' ) . ' <b>' . esc_html( $opts['expiry'] ) . '</b></p>
        <br/>
        <a href="' . admin_url( '/admin.php?page=wp_encryption&le=1', 'http' ) . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px 10px 10px 0; font-weight: bold;">' . esc_html__( 'Download Cert File', 'wp-letsencrypt-ssl' ) . '</a>
      <a href="' . admin_url( '/admin.php?page=wp_encryption&le=2', 'http' ) . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px; font-weight: bold;">' . esc_html__( 'Download Key File', 'wp-letsencrypt-ssl' ) . '</a>
      <a href="' . admin_url( '/admin.php?page=wp_encryption&le=3', 'http' ) . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px; font-weight: bold;">' . esc_html__( 'Download CA File', 'wp-letsencrypt-ssl' ) . '</a>
      <br/>
      <p>' . $this->wple_kses( sprintf( __( 'We have spent several hours making this complicated process as simple as possible. <a href="%s"><b>Please take a moment to rate us with a 5 star review</b></a>', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post' ), 'a' ) . '</p>
      <br/>
        <img src="' . site_url( '/wp-content/plugins/wp-letsencrypt-ssl/admin/assets/free-vs-pro.png', 'http' ) . '"/><br /><br />';
        $body .= '<b>' . esc_html__( 'WP Encryption PRO can automate this entire process in one click including SSL installation on cPanel hosting and auto renewal of certificates every 90 days', 'wp-letsencrypt-ssl' ) . '!. <br><a href="' . admin_url( '/admin.php?page=wp_encryption-pricing', 'http' ) . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px 0; font-weight: bold;">' . esc_html__( 'UPGRADE TO PREMIUM NOW', 'wp-letsencrypt-ssl' ) . '</a></b><br /><br />';
        $body .= "<h3>" . esc_html__( "Don't have cPanel hosting?", 'wp-letsencrypt-ssl' ) . "</h3>";
        $body .= '<p>' . $this->wple_kses( __( 'We offer one time free manual support for Premium users for installing the generated SSL certificates via <b>SSH</b>. With free version, You can download and send these SSL certificates to your hosting support asking them to install these SSL certificates.', 'wp-letsencrypt-ssl' ) ) . '</p><br /><br />';
        wp_mail(
            $to,
            $subject,
            $body,
            $headers
        );
    }
    
    /**
     * Custom rewrite rule
     *
     * @since 3.0.0
     * @return void
     */
    public function wple_http_challenge_rewrite()
    {
        add_rewrite_rule( '.well-known/acme-challenge/(.*)$', '$1', 'top' );
    }
    
    /**
     * Ability to revert back to HTTP
     *
     * @since 3.3.0
     * @param string $revertcode
     * @return void
     */
    private function wple_send_reverter_secret( $revertcode )
    {
        $to = get_bloginfo( 'admin_email' );
        $sub = esc_html__( 'You have successfully forced HTTPS on your site', 'wp-letsencrypt-ssl' );
        $header = array( 'Content-Type: text/html; charset=UTF-8' );
        $rcode = sanitize_text_field( $revertcode );
        $body = $this->wple_kses( __( "HTTPS have been strictly forced on your site now!. In rare cases, this may cause issue / make the site un-accessible <b>IF</b> you dont have valid SSL certificate installed for your WordPress site. Kindly save the below <b>Secret code</b> to revert back to HTTP in such a case.", 'wp-letsencrypt-ssl' ) ) . "\r\n      <br><br>\r\n      <strong>{$rcode}</strong><br><br>" . $this->wple_kses( __( "Opening the revert url will <b>IMMEDIATELY</b> turn back your site to HTTP protocol & revert back all the force SSL changes made by WP Encryption in one go!. Please follow instructions given at https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/", 'wp-letsencrypt-ssl' ) ) . "<br>\r\n      <br>\r\n      " . esc_html__( "Revert url format", 'wp-letsencrypt-ssl' ) . ": http://yourdomainname.com/?reverthttps=SECRETCODE<br>\r\n      " . esc_html__( "Example:", 'wp-letsencrypt-ssl' ) . " http://gowebsmarty.in/?reverthttps=wple43643sg5qaw<br>\r\n      <br>\r\n      " . esc_html__( "We have spent several hours to craft this plugin to perfectness. Please take a moment to rate us with 5 stars", 'wp-letsencrypt-ssl' ) . " - https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post\r\n      <br />";
        wp_mail(
            $to,
            $sub,
            $body,
            $header
        );
    }
    
    /**
     * Escape html but retain bold
     *
     * @since 3.3.3
     * @param string $translated
     * @param string $additional Additional allowed html tags
     * @return void
     */
    private function wple_kses( $translated, $additional = '' )
    {
        $allowed = array(
            'strong' => array(),
            'b'      => array(),
        );
        if ( $additional == 'a' ) {
            $allowed['a'] = array(
                'href'   => array(),
                'rel'    => array(),
                'target' => array(),
                'title'  => array(),
            );
        }
        return wp_kses( $translated, $allowed );
    }

}