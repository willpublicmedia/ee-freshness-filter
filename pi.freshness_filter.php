<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Freshness_filter
{
    public $return_data = '';

    public function __construct()
    {
        $this->return_data = $this->filter(
            ee()->TMPL->fetch_param('channels')
            // ee()->TMPL->fetch_param('datestring'),
            // ee()->TMPL->fetch_param('newer', true)
        );
    }

    public function filter(string $channels/* string $datestring, bool $newer */)
    {
        // assume we're filtering newer than 1 year
        $now = new DateTime('now');
        $cutoff = $now->modify('-1 year');

        return $cutoff->format('Y-m-d');
    }
}
