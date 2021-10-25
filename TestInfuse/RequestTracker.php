<?php

namespace TestInfuse;

class RequestTracker
{
    protected static $table = 'track';

    protected $headers;

    public function __construct($headers = null)
    {
        $this->headers = $headers ?? $_SERVER;
    }

    /**
     * Collect info about HTTP request and save it to a datastore.
     */
    public function handleRequest()
    {
        $data = [
            'ip_address' => $this->headers['REMOTE_ADDR'], // can be bin2hex(inet_pton($this->headers['REMOTE_ADDR']))
            'user_agent' => $this->headers['HTTP_USER_AGENT'], // can be md5($this->headers['HTTP_USER_AGENT'])
            'page_url' => $this->headers['HTTP_REFERER'], // also can be hashed
        ];

        $fields = [];

        foreach ($data as $field => $value) {
            $fields[] = "`$field` = :$field";
        }

        $sql = 'SELECT `views_count` FROM `' . static::$table . '` WHERE ' . implode(' AND ', $fields) . ' LIMIT 1 FOR UPDATE';

        $db = DataStore::getDb();
        $statement = $db->prepare($sql);

        if (! $statement->execute($data)) { // an error possibly should be logged
            return;
        }

        if (! $statement->fetch()) {
            // REPLACE is used instead of INSERT to avoid "Primary key exists" error if the same record was added shortly after SELECT
            $sql = 'REPLACE `' . static::$table . '` SET ' . implode(', ', $fields);
        } else {
            $sql = 'UPDATE `' . static::$table . '` SET `view_date` = NOW(), `views_count` = `views_count` + 1 WHERE ' . implode(' AND ', $fields)  . ' LIMIT 1';
        }

        $statement = $db->prepare($sql);

        $statement->execute($data); // an error possibly should be logged
    }
}