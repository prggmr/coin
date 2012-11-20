<?php
/**
 *  Copyright 2010 Nickolas Whiting
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 *
 * @author  Nickolas Whiting  <me@nwhiting.com>
 * @package  Coin
 * @copyright  Copyright (c), 2010 Nickolas Whiting
 */

/**
 * Coin is a simple means of generating tokens that are flexible, secure and
 * can contain an inifite amount of arbitrary data that is stored within the token
 * itself.
 *
 * A coin is generated using the SHA-1 hashing algorithm and a simple algorithm
 * that randomly inserts the data within the hash for extraction when needed.
 *
 * Usage
 * $coin = new Coin();
 * $token = $coin->generate('26545', 'safi374(&*G(PG&UT)&(UDB#(Hpoiugcb897ub-7fg)')."\n";
 *
 * Result
 * $token = 046a1-24-5-7fd294808e412962eb826545369499af191694b5
 */
class Coin
{

    /**
     * Generates a coin.
     *
     * @param  string  $data  String data to encode within the coin.
     * @param  string  $key  Private key.
     * @param  boolean  $compare  Returns the full generated coin prior to encoding.
     *
     * @return  string  Encoded coin string.
     */
    public static function generate($data, $key = null, $compare = false)
    {
        $token = substr(sha1($data.$key), 0, 20).substr(sha1($key.$data), 0, 20);
        if ($compare) return $token;
        $rand = rand(15, 39);
        $array = array();
        for ($i=0; $i != strlen($token); $i++) {
            $array[] = $token[$i];
        }
        $append = $array[$rand];
        $array[$rand] = $data;
        for ($i = 0; $i != strlen($token); $i++) {
            if (is_numeric($token[$i]) && strlen($token[$i]) == 1) {
                $loc = $token[$i];
                break;
            }
        }
        $prepend = $array[$loc];
        $array[$loc] = '-'.$rand.'-'.strlen($data).'-';
        $token = $prepend.implode('', $array).$append;
        return $token;
    }

    /**
     * Validates a coin.
     *
     * @param
     */
    public static function validate($data, $key = null, $boolean = false)
    {
        
        // This doesnt seem to match the data passed in:
        if (preg_match('^([\w\d]+)-([\d]+)-([\d]+)-([\w\d]+)^', $data) === false) {
            return false;
        }

        $explode = explode('-', $data);
        if (null == $explode[0]) {
            $place  = $explode[1];
            $length = $explode[2];
            $string = $explode[3];
        } else {
            $place  = $explode[1];
            $length = $explode[2];
            $append = substr($explode[0], 0, 1);
            $string = substr($explode[0], 1, strlen($explode[0]) - 1).$append.$explode[3];
        }

        if ($place <= 14) {
            return false;
        }

        $last = substr($string, -1, 1);
        $string = substr($string, 0, strlen($string) - 1);
        $return = substr($string, $place, $length);
        $string = substr_replace($string, $last, $place, $length);

        $matches = ($this->generate($return, $key, true) === $string);

        if ($matches) {
            if ($boolean) {
                return true;
            } else {
                return $return;
            }
        }

        return false;
    }
}