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
        $mod_channels = ee()->functions->sql_andor_string($channels, 'channel_name');

        $query = ee()->db->select('channel_name')->from('channels');
        $query->where_in('channel_name', explode('|', $channels));

        $results = $query->get();

        if ($results === null || $results->num_rows() === 0) {
            $results->free_result();
            return ee()->TMPL->no_results();
        }

        $result_array = $results->result_array();
        $results->free_result();
        return $result_array;
    }
}
