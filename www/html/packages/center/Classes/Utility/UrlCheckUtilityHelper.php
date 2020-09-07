<?php

/**
 * - Class UrlCheckUtilityHelper
 */
class UrlCheckUtilityHelper
{
	/**
	 * correct url parameters if the url already have parameters added
	 * @param $url string url from backend
	 * @param $parameters string additional parameters (from template)
	 * @return string result url (valid)
	 */
	public static function check($url, $parameters)
	{
		$url = $url . $parameters;
		// clean up url : keep only the first ? and replace the others to &
		$pos = strpos($url, '?');
		if ($pos !== false) {
			$url = substr($url, 0, $pos + 1) . str_replace('?', '&', substr($url, $pos + 1));
		}
		return self::correct_url($url);
	}

	/**
	 * corrects url and parameters
	 */
	public static function correct_url($url)
	{
		$result = parse_url($url);
		$result['query'] = str_replace("?", "&", $result["query"]);
		$values = [];
		parse_str($result["query"], $values);
		$result["query"] = http_build_query($values);
		// add /map if there is not in the path and the map is a 3d one
		if ((strpos($result["path"], "app.guide3d.com") >= 0) && !self::endsWith($result["path"], "map/")) {
			$result["path"] .= self::endsWith($result["path"], "/") ? "map/" : "/map/";
		}
		return self::unparse_url($result);
	}

	/**
	 * find if a string starts with the given string
	 * @param $haystack search in string
	 * @param $needle what to search in string
	 * @return boolean (string starts with the given string)
	 */
	public static function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 * find if a string ends with the given string
	 * @param $haystack search in string
	 * @param $needle what to search in string
	 * @return boolean (string ends with the given string)
	 */
	public static function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}
		return (substr($haystack, -$length) === $needle);
	}

	/**
	 * unparse url array to full url (reverse of php's parse_url)
	 * @param $parsed_url parsed url (array)
	 * @return unparsed url (string)
	 */
	public static function unparse_url($parsed_url)
	{
		$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
		$pass = ($user || $pass) ? "$pass@" : '';
		$path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}

	/**
	 * for test purpose only
	 */
	public static function test() {
		$url = "https://app.guide3d.com/100014/web/?project=100014&language=de&menu=end&url-action=popup&mobile=true?menu=end&language=de";
		$params = "?menu=end&language=de";
		$check = UrlCheckUtilityHelper::check($url, $params);
		var_dump($check);
	}
}

// UrlCheckUtilityHelper::test();
