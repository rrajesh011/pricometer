<?php

/**
 * Created by PhpStorm.
 * User: RRajesh
 * Date: 12/4/2016
 * Time: 5:54 PM
 */

/**
 * Class MY_Model
 * @property  CI_Loader $load
 * @property CI_DB_active_record $db
 * @property Auth_m $auth_m
 */
class MY_Model extends CI_Model {

    public $image_dir = FCPATH . '../assets/uploads/images/products/';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function token($length = 32) {
        // Create random token
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $max = strlen($string) - 1;

        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[mt_rand(0, $max)];
        }

        return $token;
    }

    public function et_arrays_clear_data($array) {
        $new_array = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $new_array[utf8_encode($key)] = $this->et_arrays_clear_data($value);
            } else {
                $new_array[utf8_encode($key)] = utf8_encode($value);
            }
        }
        return $new_array;
    }

    public function et_decode_four_spaced_json($four_spaced_json, $level = 0) {

        $array = array();

        $no_of_spaces = (1 + $level) * 4;
        $splits = preg_split('/^ {' . $no_of_spaces . '}(?! )/m', $four_spaced_json); // /m allows ^ (start of line) and $ (end of line), {4} for four spaces, (?! ) for negative lookahead
        for ($i = 1; $i < count($splits); $i++) {

            $no_of_spaces = (1 + $level + 1) * 4;
            $split_in_two = preg_split('/^ {' . $no_of_spaces . '}(?! )/m', $splits[$i], 2);
            // var_dump($split_in_two);
            if (count($split_in_two) == 2) { // its an array
                $key = $this->et_decode_four_spaced_json_data($split_in_two[0]);
                $value = $this->et_decode_four_spaced_json(str_repeat(' ', $no_of_spaces) . $split_in_two[1], $level + 1);
                $array[$key] = $value;
            } else { // its a value or a key value
                $split_in_two = explode('::', $splits[$i], 2);
                if (count($split_in_two) == 2) { // its a key value pair
                    $key = $this->et_decode_four_spaced_json_data($split_in_two[0]);
                    $value = $this->et_decode_four_spaced_json_data($split_in_two[1]);
                    $array[$key] = $value;
                } else { // its a value
                    $value = $this->et_decode_four_spaced_json_data($splits[$i]);
                    $array[] = $value;
                }
            }
        }

        return $array;
    }

    public function et_decode_four_spaced_json_data($str) {
        $str = '' . $str;
        $str = str_replace(array("\n&nbsp;   ", "&#58;&#58;"), array("\n    ", "::"), $str);
        $str = trim($str);
        return $str;
    }

}
