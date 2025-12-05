<?php

class WPLE_Activator
{
    public static function activate()
    {
        $opts = ( get_option( 'wple_opts' ) === FALSE ? array(
            'expiry' => '',
        ) : get_option( 'wple_opts' ) );
        //initial disable ssl forcing
        $opts['force_ssl'] = 0;
        update_option( 'wple_opts', $opts );
    }

}