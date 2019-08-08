<?php
/**
 * Created by PhpStorm.
 * User: ck865
 * Date: 2019-08-08
 * Time: 9:10
 */

namespace HttpClient\Core;

class Response
{
    private $rawHeader;
    private $rawBody;

    private $code;
    private $totalTime;
    private $header;

    /**
     * Response constructor.
     * @param $result
     * @param $ch
     * @throws \Exception
     */
    public function __construct($result, $ch)
    {
        $result = explode("\r\n\r\n", $result);
        $this->rawBody   = array_pop($result);
        $this->rawHeader = array_pop($result);

        $this->code      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        $this->_parseHeader();
    }

    private function _parseHeader()
    {
        $headers = array_filter(explode("\r\n", $this->rawHeader));
        foreach ($headers as $field) {
            if (!is_array($field)) {
                $field = array_map('trim', explode(':', $field, 2));
            }
            if (count($field) == 2) {
                $this->header[$field[0]] = $field[1];
            }
        }
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getBody()
    {
        return $this->rawBody;
    }

    public function getJsonBody($assoc = true)
    {
        return json_decode($this->rawBody, $assoc);
    }

}