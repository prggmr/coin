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
 * @author  Nickolas Whiting  <prggmr@gmail.com>
 * @copyright  Copyright (c), 2010 Nickolas Whiting
 */

if (!defined('COIN_SECRET')) {
    define('COIN_SECRET', null);
}

/**
 * @docblock  method  Coin::generate
 */
function coin($data, $key = COIN_SECRET, $compare = false) {
    return (new Coin())->generate($data, $key, $compare);
}

/**
 * @docblock  method  Coin::validate
 */
function coin_validate($data, $key = COIN_SECRET, $boolean = false) {
    return (new Coin())->validate($data, $key, $compare);
}

/**
 * Coin stores strings using the SHA-1 hashing algorithm and a trick.
 *
 * It also extracts and validates it.
 *
 * @example
 * 
 * .. code-block:: php
 *
 *    <?php
 *    
 *    // Generate a coin
 *    $coin = coin('helloworld');
 *  
 *    // Your shiny new coin!
 *    // 046a1-24-5-7fd294808e412962eb826545369499af191694b5
 */
class Coin
{

    /**
     * Generates a coin.
     *
     * @param  string  $data  String to coin.
     * 
     * @optional
     * @param  string  $key  The Secret key.
     *
     * @optional
     * @param  boolean  $compare  Compare coins.
     *
     * @return  string  A shiny new coin.
     *
     * @example
     *
     * .. code-block:: php
     *
     *    <?php
     *    // Create a coin
     *    coin('helloworld')
     */
    public static function generate($data, $key = COIN_SECRET, $compare = false)
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
    public static function validate($data, $key = COIN_SECRET, $boolean = false)
    {
        
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
