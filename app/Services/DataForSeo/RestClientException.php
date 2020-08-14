<?php

namespace App\Services\DataForSeo;

use Exception;
/**
* Extended exceptions for PHP REST Client build with cURL
*
* @author Fabio Agostinho Boris <fabioboris@gmail.com>
*/
class RestClientException extends Exception
{
    protected $http_code;

    public function __construct($message, $code = 0, $http_code, Exception $previous = null)
    {
        $this->http_code = $http_code;
        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode()
    {
        return $this->http_code;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message} (HTTP status code: {$this->http_code})\n";
    }
}
