<?php

// https://github.com/MissVeronica/um-landing-page-for-email-links
//
// Ultimate Member Landing Page for Email Links - Version 2 
// Date: 2021-12-19


add_filter( 'wp_mail', 'my_wp_mail_filter', 10, 1 );
add_shortcode( 'um-landing-page', 'um_landing_page' );

function my_wp_mail_filter( $compact ) {

    if( strpos( $compact['message'], '?act=reset_password' ) > 0 ) {
        $reset_page = str_replace( get_bloginfo( 'url' ), '', get_permalink( UM()->config()->permalinks['password-reset'] ));
        $compact['message'] = str_replace( $reset_page . '?act=reset_password', '/um-landing-page/?myact=landing_for_password', $compact['message'] );
    }
    if( strpos( $compact['message'], '?act=activate_via_email' ) > 0 ) {
        $compact['message'] = str_replace( '?act=activate_via_email', '/um-landing-page?myact=landing_for_activate', $compact['message'] );
        preg_match( '/\&user_id=\s*(\d+)/', $compact['message'], $matches );
        um_fetch_user( intval( $matches[1] ));
        $compact['message'] = preg_replace("/\&user_id=.*?\"/", '&login=' . esc_html( um_user( 'user_login' )) . '"', $compact['message'] );
    }
    return $compact;
}

function um_landing_page() {
    
    global $wpdb;

    if( isset( $_REQUEST['myact'] )) {

        if( $_REQUEST['myact'] == 'landing_for_activate' ) {
            
            $query = $wpdb->get_results( "SELECT user_id FROM {$wpdb->prefix}usermeta 
                                            WHERE meta_key='account_secret_hash' 
                                            AND meta_value LIKE '" . sanitize_text_field( $_REQUEST['hash'] ) . "' LIMIT 0,1", ARRAY_A );

            if( is_array( $query ) && isset( $query[0]['user_id'] )) {

                $user_id = $query[0]['user_id'];                
                um_fetch_user( $user_id );
                if( um_user( 'user_login') != sanitize_text_field( $_REQUEST['login'] )) $user_id = '';

            } else $user_id = '';

            if( empty( $user_id )) {
                echo '<h4>Sorry, your activation link is invalid or outdated.</h4>';
            } else {
?>
            <h4>Please click this button to activate your account.</h4>
                <div>
                    <form id="account-activation-form" action="" method="post">
                        <input type="hidden" id="act" name="act" value="activate_via_email">
                        <input type="hidden" name="hash" value="<?php echo esc_html( $_REQUEST['hash'] );?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo esc_html( $user_id );?>" />
                        <p><button data-action='submit'><?php echo 'Activate now'; ?></button></p>
                    </form>
                </div>
<?php
            }
?>
                <div>Need help?<p><a href="<?php echo esc_url( 'mailto:' . get_bloginfo( 'admin_email' ), array( 'mailto' ));?>">Contact  us</a> today.</p></div>
            
            <div>
                <div>Thank you!</div>
                <div>The <a href="<?php echo esc_url( get_bloginfo( 'url' ));?>"><?php echo esc_html( get_bloginfo( 'name' ));?></a> Team</div>
            </div>
<?php
        }
        
        if( $_REQUEST['myact'] == 'landing_for_password' ) {
            $reset_page = esc_url( str_replace( get_bloginfo( 'url' ), '', get_permalink( UM()->config()->permalinks['password-reset'] )));
?>
            <h4>Please click this button to reset your password.</h4>
                <div>
                    <form id="account-password-form" action="<?php echo $reset_page;?>" method="get">
                        <input type="hidden" id="act" name="act" value="reset_password">
                        <input type="hidden" name="hash" value="<?php echo esc_html( $_REQUEST['hash'] );?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo esc_html( $_REQUEST['user_id'] ); ?>" />
                        <p><button data-action='submit'><?php echo 'Reset password now'; ?></button></p>
                    </form>
                </div>
                <div>Need help?<p><a href="<?php echo esc_url( 'mailto:' . get_bloginfo( 'admin_email' ), array( 'mailto' ));?>">Contact  us</a> today.</p></div>
            
            <div>
                <div>Thank you!</div>
                <div>The <a href="<?php echo esc_url( get_bloginfo( 'url' ));?>"><?php echo esc_html( get_bloginfo( 'name' ));?></a> Team</div>
            </div>
<?php
        }
    }
}
