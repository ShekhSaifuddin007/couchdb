<?php

namespace App\Traits;

trait CouchDBConnection
{
    protected $db;
    protected $url;

    public function __construct()
    {
        $this->db = config('couchdb.db');
        $this->url = config('couchdb.url');
    }
}
