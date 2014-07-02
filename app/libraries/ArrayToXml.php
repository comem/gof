<?php

/* class XmlSend  { 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArrayToXml {

    public static function array_to_xml($night, &$xml_night_info) {
        foreach ($night as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml_night_info->addChild("$key");
                    ArrayToXml::array_to_xml($value, $subnode);
                } else {
                    $subnode = $xml_night_info->addChild("item$key");
                    ArrayToXml::array_to_xml($value, $subnode);
                }
            } else {
                $xml_night_info->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

}
