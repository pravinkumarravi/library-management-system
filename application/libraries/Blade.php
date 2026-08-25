<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use eftec\bladeone\BladeOne;

/**
 * BladeOne view integration for CodeIgniter 3.
 *
 * Renders .blade.php templates located in application/views using
 * eftec/bladeone (Laravel's Blade templating engine).
 */
class Blade
{
    protected BladeOne $blade;

    public function __construct()
    {
        $CI =& get_instance();

        $views = APPPATH . 'views';
        $cache = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'blade';

        if (!is_dir($cache)) {
            mkdir($cache, 0777, TRUE);
        }

        $mode = (ENVIRONMENT === 'production')
            ? BladeOne::MODE_SLOW
            : BladeOne::MODE_AUTO;

        $this->blade = new BladeOne($views, $cache, $mode);

        // Variables shared with every template.
        $this->blade->share('site_name', 'Library Management System');
        $this->blade->share('base_url', base_url());
        $this->blade->share('current_uri', $CI->uri->uri_string());
        $this->blade->share('auth_user', $CI->session->userdata('user') ?: NULL);
    }

    /**
     * Render a Blade template and return the HTML.
     */
    public function view(string $template, array $data = []): string
    {
        $CI =& get_instance();

        $template = $this->normalize($template);

        $message = $CI->session->flashdata('message');
        $this->blade->share('message', $message ?: NULL);

        return $this->blade->run($template, $data);
    }

    /**
     * BladeOne treats template names containing a slash as literal paths and
     * does not append the .blade.php extension, so we normalise them here.
     */
    protected function normalize(string $template): string
    {
        if (substr($template, -10) === '.blade.php') {
            return $template;
        }

        if (strpos($template, '/') !== FALSE) {
            return $template . '.blade.php';
        }

        return str_replace('.', '/', $template) . '.blade.php';
    }
}
