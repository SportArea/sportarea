<?php

namespace SportArea\Core;

/**
 * Utils/General class with all kind of functions
 * All function are/must be static
 *
 */
class Utils
{

    /**
     * Kind of print_r
     *
     * @param   array   $array
     * @param   boolean $exit
     */
    public static function printR($array, $exit = false)
    {
        echo "<pre>\n";
        print_r($array);
        echo "\n</pre>";

        ($exit === true) ? exit(0) : null;
    }

	/**
     * Generate a random string
     *
	 * @param   integer      $length
	 * @param   multi-array $keysToUse
	 * @return  string
	 */
	public static function randomString($length = 12, $keysToUse = array())
    {
		if(is_array($keysToUse) AND count($keysToUse) == 0) {
			$keysToUse = array(
				'abcdefghijklmnopqrstuwxyz',
				'ABCDEFGHIJKLMNOPQRSTUWXYZ',
				'0123456789',
				'!@#$%^&*+='
			);
		}

		$password = '';
		$i = 0;
		while (true) {
			if ($i > (count($keysToUse)-1) ) {
				$i = 0;
			}

			$password .= $keysToUse[$i][mt_rand(0, (strlen($keysToUse[$i])-1))];

			if (strlen($password) >= $length) {
				break;
			}

			++$i;
		}

		return $password;
	}

    /**
     * Compress multiple spaces
     *
     * @param	string $string
     * @return	string
     */
    public static function compressSpaces($string)
    {
        return preg_replace('/\s+/', ' ', $string);
    }

    /**
     * Compress slasses (from many ///// to one /)
     *
     * @param	string $string
     * @return	string
     */
    function compressSlashes($string)
    {
        return preg_replace('/\\/+/', '/', $string);
    }

    /**
     * @param   string/html    $buffer
     * @return  string/html
     */
	public static function htmlMinifier($buffer)
    {
        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'     // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }

    /**
     * Transform a lower_case string to CamelCase
     *
     * @param   string  $string
     * @return  string
     */
    public static function lowerCaseToCamelCase($string)
    {
        if (strpos($string, '_')) {
            $function = create_function('$c', 'return strtoupper($c[1]);');
            return preg_replace_callback('/_([a-z])/', $function, $string);
        } else {
            return $string;
        }
    }

    /**
     * Transform a camelCase string to lower_case
     *
     * @param   string  $string
     * @return  string
     */
    public static function camelCaseToLowerCase($string)
    {
        $string[0] = strtolower($string[0]);
        $function = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $function, $string);
    }

    /**
     * Get real IP address
     *
     * @param   boolean $ip2Long
     * @return  string
     */
	public static function getRealIp($ip2Long = false)
    {

		// Set a degault ip
		$ip = $_SERVER['REMOTE_ADDR'];

		// check ip from share internet
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];

		// to check ip is pass from proxy
		} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		// Return the ip
		if($ip2Long == true) {
			return ip2long($ip);
		} else {
			return $ip;
		}
	}

    /**
     * Get string between two tags
     *
     * @param   string  $string
     * @param   string  $start
     * @param   string  $end
     * @return  string
     */
    public static function getStringBetweenTags($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function redirect($url, $status = 302, $headers = array()) {

        $content = sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="refresh" content="1;url=%1$s" />

        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8'));

    }

	/**
	 * @param	boolean	$urlEncode
	 * @param	boolean	$base64encode
	 * @return	string
	 *
	 */
	public static function whereIAm($urlEncode = false, $base64encode = false) {

		// If no HTTPS
		if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') {
			$whereIAm = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		// If HTTPS
		} else {
			$whereIAm = 'https://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		if($urlEncode) {
			$whereIAm = urlencode($whereIAm);
		}

		if($base64encode) {
			$whereIAm = base64_encode($whereIAm);
		}

		return $whereIAm;
	}


    /**
     * Extract birth date from a RO CNP
     *
     * @param   integer $CNP
     * @return  date/null
     */
    public static function extractBirthDateFromCNP($CNP)
    {
        if(Validate::valideazaCNP($CNP)) {
            return '20'. substr($CNP, 1, 2) .'-'. substr($CNP, 3, 2) .'-'. substr($CNP, 5, 2);

        } else {
            return false;
        }
    }

	public static function printLimitedString($string, $limit = '10', $postText = '...', $cut = 'right') {
		if(strlen($string) > $limit) {

			if($cut == 'right')  {
				return mb_substr($string, 0, ($limit-count($postText)), 'UTF-8').$postText;

			} elseif($cut == 'middle' OR $cut == 'center')  {
				$return = mb_substr($string, 0, (round($limit/2)-count($postText)), 'UTF-8');
				$return .= $postText;
				$return .= mb_substr($string, count($string)-round($limit/2), 1000, 'UTF-8');

				return $return;
			}

		} else {
			return $string;
		}
	}

	/**
	 * makeTeaser returns a cleanly truncated teaser string from the
	 * beginning of the article along with a link to
	 * the full article. Truncation will follow the following Rules...
	 * Truncation preferably happens at the nearest white space character
	 * (space, newline, tab) or
	 * punctuation character (comma, fullstop, colon, semicolon,
	 * exclamation) that is less than maxLength specified.
	 *
	 * Additional Information:
	 * All characters are single byte latin-1 characters.
	 * Content is expected to be in plain text, please assume that there
	 * are no HTML or SGML tags. *
	 * @param $content - String, Full/Partial Content of the article
	 * @param $url - String, Absolute URL to the Full article
	 * @param $linkText - String, Text to show for the link
	 * @param $minLength - Number, Preferred minimum length of the teaser
	 * (non binding)
	 * @param $maxLength - Number, Maximum length of the teaser, optional.
	 * If not set, maxLength = minLength+50
	 * @return String Teaser That will be displayed
	 */
	public static function teaser($content, $url, $linkText, $minLength = 0, $maxLength = NULL)
    {

		if($minLength == 0 OR $maxLength == NULL OR $minLength > $maxLength) {
			$maxLength = ($minLength+50);
		}

		// Set the breakers
		$breakers = array('\s', '\n', '\t', ',', '\.', ':', ';', '\!');

		// Match all breakers and position in the given string
		preg_match_all('/'. implode('|', $breakers) .'/', $content, $breakersPosition, PREG_OFFSET_CAPTURE);

		// If the content lenght is shorten than the maximum lenght
		if(strlen($content) < $maxLength) {
			$choosenBreakerPosition = strlen($content);

		// Else if the content lenght is longer than the maximum lenght
		} else {
			$choosenBreakerPosition = 0;
			foreach ($breakersPosition[0] as $breakerPosition) {

				// The distance between the pointer and the maximum length
				$distante = ($maxLength-$breakerPosition[1]);

				// If positive distance, and the current breaker position is higher than the previous breaker position
				if($distante >= 0 AND $breakerPosition[1] > $choosenBreakerPosition) {
					$choosenBreakerPosition = $breakerPosition[1];
				}
			}
		}

		// Return the teaser and the 'read more' link
        if(!empty($url)) {
            return substr($content, 0, $choosenBreakerPosition) .' (<a href="'. $url .'">'. $linkText .'</a>)';
        } else {
            return substr($content, 0, $choosenBreakerPosition) .' ...';
        }
	}

    public static function htmlPurify($html)
    {

        $search = array(
            '@<script[^>]*?>.*?</script>@si',	// Strip out javascript
            /*'@<[\/\!]*?[^<>]*?>@si',			// Strip out HTML tags*/
            '@<style[^>]*?>.*?</style>@siU',	// Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'			// Strip multi-line comments
        );

        return preg_replace($search, '', $html);
    }
}