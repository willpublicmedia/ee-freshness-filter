<?php if (!defined('BASEPATH')) {exit('No direct script access allowed.');}

require_once __DIR__ . '/constants.php';
use IllinoisPublicMedia\FreshnessFilter\Constants;

return [
    'author' => Constants::AUTHOR,
    'author_url' => Constants::AUTHOR_URL,
    'description' => Constants::DESCRIPTION,
    'docs_url' => Constants::DOCS_URL,
    'name' => Constants::NAME,
    'namespace' => Constants::NAMESPACE,
    'version' => Constants::VERSION,
];
