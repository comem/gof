<?php

class HttpTools {

    public static function get($url, $headers = array())
    {
        return self::request($url, array(), 'GET', $headers);
    }

    public static function post($url, $data = array(), $headers = array())
    {
        return self::request($url, $data, 'POST', $headers);
    }

    public static function request($url, $data = array(), $method = 'GET',
            $headers = array())
    {
        // Fixe le content type par défaut
        if (!isset($headers['Content-type'])) {
            $headers['Content-type'] = 'application/x-www-form-urlencoded';
        }
        // Construit la chaines des "headers" HTTP
        $headerStr = '';
        foreach ($headers as $key => $val) {
            $headerStr .= "{$key}: {$val}\r\n";
        }
        $options = array(
            'http' => array(
                'header'  => $headerStr,
                'method'  => $method,
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }
}
