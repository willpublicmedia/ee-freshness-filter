<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Freshness_filter
{
    public $return_data = '';

    private $allowed_time_units = [
        'year',
        'month',
        'day',
    ];

    public function __construct()
    {
        $channels = explode('|', ee()->TMPL->fetch_param('channels'));
        $age = intval(ee()->TMPL->fetch_param('age', 1));
        $unit = ee()->TMPL->fetch_param('unit', 'year');
        $allow_edits = ee()->TMPL->fetch_param('allow_edits', 'true') == 'true' ? true : false;

        if (!in_array($unit, $this->allowed_time_units)) {
            throw new Exception('Invalid time_unit. Allowed values are "year", "month", and "day".', 1);
        }

        $this->return_data = $this->filter(
            $channels,
            $age,
            $unit,
            $allow_edits
        );
    }

    public function filter(array $channels, int $age, string $unit, bool $allow_edits): string// json

    {
        $channels = ee()->db->escape_str($channels);
        $age = ee()->db->escape_str($age);
        $unit = ee()->db->escape_str($unit);
        $date_field = $allow_edits ? 'edit_date' : 'entry_date';

        $query = ee()->db->select('channel_name')->from('exp_channels')
            ->where_in('channel_name', $channels)
            ->join('exp_channel_titles', 'exp_channels.channel_id = exp_channel_titles.channel_id', 'Titles')
            ->where("exp_channel_titles.${date_field} >= unix_timestamp(DATE_SUB(now(), interval $age $unit))")
            ->group_by('exp_channel_titles.channel_id')
            ->having('count(exp_channel_titles.channel_id) >= 1')
            ->order_by('exp_channels.channel_title');

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
