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

if (!function_exists('relative_time')) {
    /**
     * Human-friendly relative time ("5 min ago", "2 days ago", or a date).
     */
    function relative_time(string $datetime): string
    {
        $ts = strtotime($datetime);
        if (!$ts) {
            return $datetime;
        }
        $diff = time() - $ts;
        if ($diff < 60) {
            return 'just now';
        }
        if ($diff < 3600) {
            return floor($diff / 60) . ' min ago';
        }
        if ($diff < 86400) {
            return floor($diff / 3600) . ' hr ago';
        }
        if ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        }
        return date('M d, Y', $ts);
    }
}
