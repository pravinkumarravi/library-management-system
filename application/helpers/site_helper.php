<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Small application helper functions.
 */

if (!function_exists('is_active')) {
    /**
     * Return the active CSS class when the given URI segment matches.
     */
    function is_active(string $segment): string
    {
        $ci =& get_instance();
        $first = $ci->uri->segment(1);
        return ($first === $segment) ? 'bg-brand-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white';
    }
}

if (!function_exists('money')) {
    /**
     * Format a numeric amount as Indian Rupees.
     */
    function money(int|float|string $amount): string
    {
        return '₹' . number_format((float) $amount, 2);
    }
}
