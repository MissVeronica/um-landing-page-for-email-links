<?php

add_filter( 'wp_mail', 'my_wp_mail_filter', 10, 1 );
add_shortcode( 'um-landing-page', 'um_landing_page' );

function my_wp_mail_filter( $compact ) {

    $compact['message'] = str_replace( '?act=activate_via_email', '/um-landing-page?myact=landing_for_activate', $compact['message'] );
    if( strpos( $compact['message'], '?act=reset_password' ) > 0 ) {
        $reset_page = str_replace( get_bloginfo( 'url' ), '', get_permalink( UM()->config()->permalinks['password-reset'] ));
        $compact['message'] = str_replace( $reset_page . '?act=reset_password', '/um-landing-page/?myact=landing_for_password', $compact['message'] );
    }
    return $compact;
}

function um_landing_page() {
    
    if( isset( $_REQUEST['myact'] )) {

        if( $_REQUEST['myact'] == 'landing_for_activate' ) {
?>
            <div>Please click the following button to activate your account.</div>
                <div>
                    <form id="account-activation-form" action="" method="post">
                        <input type="hidden" id="act" name="act" value="activate_via_email">
                        <input type="hidden" name="hash" value="<?php echo $_REQUEST['hash'];?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
                        <p><button data-action='submit'><?php echo 'Activate now'; ?></button></p>
                    </form>
                </div>
                <div>Need help?<p><a href="mailto:<?php echo get_bloginfo( 'admin_email' );?>">Contact  us</a> today.</p></div>
            </div>
            
            <div>
                <div>Thank you!</div>
                <div>The <a href="<?php echo get_bloginfo( 'url' );?>"><?php echo get_bloginfo( 'name' );?></a> Team</div>
            </div>
<?php
        }
        
        if( $_REQUEST['myact'] == 'landing_for_password' ) {
            $reset_page = str_replace( get_bloginfo( 'url' ), '', get_permalink( UM()->config()->permalinks['password-reset'] ));
?>
            <div>Please click the following button to reset your password.</div>
                <div>
                    <form id="account-password-form" action="<?php echo $reset_page;?>" method="get">
                        <input type="hidden" id="act" name="act" value="reset_password">
                        <input type="hidden" name="hash" value="<?php echo $_REQUEST['hash'];?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
                        <p><button data-action='submit'><?php echo 'Reset password now'; ?></button></p>
                    </form>
                </div>
                <div>Need help?<p><a href="mailto:<?php echo get_bloginfo( 'admin_email' );?>">Contact  us</a> today.</p></div>
            </div>
            
            <div>
                <div>Thank you!</div>
                <div>The <a href="<?php echo get_bloginfo( 'url' );?>"><?php echo get_bloginfo( 'name' );?></a> Team</div>
            </div>
<?php
        }
    }
}
