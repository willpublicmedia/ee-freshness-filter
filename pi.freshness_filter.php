<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Freshness_filter
{
    public $return_data = '';

    public function __construct()
    {
        $channels = explode('|', ee()->TMPL->fetch_param('channels'));
        $interval = intval(ee()->TMPL->fetch_param('interval'), '1');

        $this->return_data = $this->filter(
            $channels,
            $interval
            // ee()->TMPL->fetch_param('datestring'),
            // ee()->TMPL->fetch_param('newer', true)
        );
    }

    public function filter(array $channels, int $interval/*bool $newer */)
    {
        // assume we're filtering newer than 1 year
        $now = new DateTime('now');
        $cutoff = $now->modify('-1 year');

        $query = ee()->db->select('channel_name')->from('exp_channels')
            ->where_in('channel_name', $channels)
            ->join('exp_channel_titles', 'exp_channels.channel_id = exp_channel_titles.channel_id', 'Titles')
            ->where("exp_channel_titles.edit_date >= unix_timestamp(DATE_SUB(now(), interval $interval year))")
            ->group_by('exp_channel_titles.channel_id')
            ->having('count(exp_channel_titles.channel_id) >= 1');

        $results = $query->get()->result_array();

        if (empty($results)) {
            return ee()->TMPL->no_results();
        }

        $fresh = array_map(function ($value) {
            return $value['channel_name'];
        }, $results);

        return json_encode($fresh);
    }
}
