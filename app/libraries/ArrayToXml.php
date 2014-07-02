<?php

/* class XmlSend  { 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArrayToXml {

    public static function buildXMLData($data, $startElement = 'fx_request', $xml_version = '1.0', $xml_encoding = 'UTF-8') {
        if (!is_array($data)) {
            $err = 'Invalid variable type supplied, expected array not found on line ' . __LINE__ . " in Class: " . __CLASS__ . " Method: " . __METHOD__;
            trigger_error($err);
            if ($this->_debug)
                echo $err;
            return false; //return false error occurred
        }
        $xml = new XmlWriter();
        $xml->openMemory();
        $xml->startDocument($xml_version, $xml_encoding);
        $xml->startElement($startElement);

        /**
         * Write XML as per Associative Array
         * @param object $xml XMLWriter Object
         * @param array $data Associative Data Array
         */
        function write(XMLWriter $xml, $data) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {                
                    $xml->startElement($key);
                    write($xml, $value);
                    $xml->endElement();
                    continue;
                }
                $xml->writeElement($key, $value);
            }
        }

        write($xml, $data);

        $xml->endElement(); //write end element
        //Return the XML results
        return $xml->outputMemory(true);
    }

}
