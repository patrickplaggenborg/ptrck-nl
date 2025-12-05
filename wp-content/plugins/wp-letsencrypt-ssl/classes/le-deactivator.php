<?php

class WPLE_Deactivator
{

  public static function deactivate()
  {
    $opts = get_option('wple_opts') === FALSE ? array('expiry' => '') : get_option('wple_opts');

    //disable ssl forcing
    $opts['force_ssl'] = 0;
    update_option('wple_opts', $opts);

    if (FALSE != get_option('wple_gdaddy')) {
      delete_option('wple_gdaddy');
    }

    if (file_exists(WPLE_DEBUGGER . 'debug.log')) {
      @unlink(WPLE_DEBUGGER . 'debug.log');
    }
  }
}
