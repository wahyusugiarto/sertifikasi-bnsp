<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// To use reCAPTCHA, you need to sign up for an API key pair for your site.
// untuk localhost
// $config['recaptcha_site_key'] = '6LcJeCkUAAAAAI35F3ccfQc_T_kRy2qvSX3tfZbn';
// $config['recaptcha_secret_key'] = '6LcJeCkUAAAAAOEVsagmcxRyco7RH_B7hLmlCxfb';

// untuk belanjaweb
$config['recaptcha_site_key'] = '6LdawLYUAAAAAFYCXfD12bcd-6XOqvaOr9jJBgWH';
$config['recaptcha_secret_key'] = '6LdawLYUAAAAAC_lna2DzklclPdZPZOFVo9Jh_O0';

// reCAPTCHA supported 40+ languages listed here:
// https://developers.google.com/recaptcha/docs/language
$config['recaptcha_lang'] = 'en';

/* End of file recaptcha.php */
/* Location: ./application/config/recaptcha.php */
