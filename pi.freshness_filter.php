<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Freshness_filter
{
    public $return_data = '';

    public function __construct()
    {
        $channels = ee()->TMPL->fetch_param('channels');
        $this->return_data = $this->filter(
            $channels
            // ee()->TMPL->fetch_param('datestring'),
            // ee()->TMPL->fetch_param('newer', true)
        );
    }

    public function filter(string $channels/* string $datestring, bool $newer */)
    {
        // assume we're filtering newer than 1 year
        $now = new DateTime('now');
        $cutoff = $now->modify('-1 year');
        $channel_sql = ee()->functions->sql_andor_string($channels, 'channel_name');

        return $channel_sql;
    }
}
