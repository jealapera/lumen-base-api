<?php // Helpers

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

/**
 * @param $array
 * @return boolean
 */
function array_has_dupes($array) 
{
   return count($array) !== count(array_unique($array));
}

/**
 * @param $array
 * @return array
 */
function array_iunique($array) 
{
	foreach($array as $value)
    {
        $iuniq[] = array_strtolower($value);
    }

    return array_unique($iuniq, SORT_REGULAR);
}

/**
 * @param $array
 * @return array
 */
function array_strtolower($array) 
{
	foreach($array as $key => $value)
	{
		$arraytolower[$key] = array();
		$arraytolower[$key] = strtolower($value);
	}
	
	return $arraytolower;
}

/**
 * @param $length
 * @return mixed
 */
function generate_code($length) 
{
    $result = '';
    
    for($i = 0; $i < $length; $i++)
    {
        $result .= mt_rand(0, 9);
    }

    return $result;
}

/**
 * @param $prefix, $extension
 * @return filename
 */
function generate_filename($prefix, $extension) 
{
    return $prefix.time().uniqid().'.'.$extension;
}

/**
 * @return mixed
 */
function generate_password() 
{
    return str_shuffle(uniqid());
}

/**
 * @param $number, $precision
 * @return int/float
 */
function modify_by_precision($number, $precision = 0) 
{
	$numberOfDecimalPlaces = strlen(substr(strrchr($number, "."), 1));

	if($numberOfDecimalPlaces <= $precision)
	{
		switch($precision) 
	    {
	    	case 1:
	    		$number = $number + 0.1;
	    		break;
	    	case 2:
	    		$number = $number + 0.001;
	    		break;
	    	case 3:
	    		$number = $number + 0.0001;
	    		break;
	    	case 4:
	    		$number = $number + 0.00001;
	    		break;
	    	
	    	default:
	    		# code...
	    		break;
	    }
	}

    return $number;
}

/**
 * @param $number, $precision
 * @return int/float
 */
function round_up($number, $precision = 0) 
{
    return ceil($number * pow(10, $precision)) / pow(10, $precision);
}

/**
 * @param $number, $precision
 * @return int/float
 */
function round_down($number, $precision = 0)
{
    return floor($number * pow(10, $precision)) / pow(10, $precision);
}

/**
 * @param $template, $data
 */
function send_email($template, $data)
{	
	Mail::send($template, $data, function($message) use($data) 
	{
        $message->subject($data['subject']);
        $message->to($data['email']);
    });
}