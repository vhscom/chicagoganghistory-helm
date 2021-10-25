<?php
{% if WP_OPENID_CONNECT_ROLE_MAPPING_ENABLED %}
add_action('openid-connect-generic-update-user-using-current-claim', function( $user, $user_claim) {
    // Based on some data in the user_claim, modify the user.
    if ( array_key_exists( '{{ WP_OPENID_CONNECT_SETTINGS.role_key }}', $user_claim ) ) {
        if ( in_array('admin',$user_claim['{{ WP_OPENID_CONNECT_SETTINGS.role_key }}'] )) {
            $user->set_role( 'administrator' );
        }
        else {
            $user->set_role( 'contributor' );
        }
    }
}, 10, 2);
{% endif %}
{% if WP_SMTP_ENABLED %}
    // SMTP Authentication
    add_action( 'phpmailer_init', 'send_smtp_email' );
    function send_smtp_email( $phpmailer ) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = SMTP_HOST;
        $phpmailer->SMTPAuth   = SMTP_AUTH;
        $phpmailer->Port       = SMTP_PORT;
        $phpmailer->Username   = SMTP_USER;
        $phpmailer->Password   = SMTP_PASS;
        $phpmailer->SMTPSecure = SMTP_SECURE;
        $phpmailer->From       = SMTP_FROM;
        $phpmailer->FromName   = SMTP_NAME;
    }
{% endif %}
