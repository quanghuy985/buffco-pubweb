<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class THUVIEN {

    static function wordLimit($string, $limit = 50) {  // truncates the string
        return implode('', array_slice(preg_split('/([\s,\.;\?\!]+)/', $string, $limit * 2 + 1, PREG_SPLIT_DELIM_CAPTURE), 0, $limit * 2 - 1));
    }

}
