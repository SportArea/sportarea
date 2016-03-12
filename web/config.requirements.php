<?php
/**
 * A list of application requirements
 *
 */

$extensions		=	get_loaded_extensions();
$_requirements	=	array();
$_requirements['mandatory']	=	array(
	array	(
				'name'		=>	'PHP Version',
				'type'		=>	'phpVersion',
				'request'	=>	'5.3+',
				'current'	=>	phpversion(),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Directive: Default Charset (<a href="http://php.net/manual/en/ini.core.php#ini.default-charset" target="_blank">default_charset</a>)',
				'type'		=>	'ini',
				'request'	=>	'UTF-8',
				'current'	=>	(ini_get('default_charset') == 'UTF-8') ? 'UTF-8' : ini_get('default_charset'),
				'why'		=>	"This feature has been DEPRECATED as of PHP 5.3.0.<br />Relying on this feature is highly discouraged.",
			),

	array	(
				'name'		=>	'PHP Directive: Register Globals (<a href="http://php.net/manual/en/ini.core.php#ini.register-globals" target="_blank">register_globals</a>)',
				'type'		=>	'ini',
				'request'	=>	'off',
				'current'	=>	(ini_get('register_globals') == 1) ? 'on' : 'off',
				'why'		=>	"This feature has been DEPRECATED as of PHP 5.3.0.<br />Relying on this feature is highly discouraged.",
			),

	array	(
				'name'		=>	'PHP Directive: Short Open Tags (<a href="http://php.net/ini.core#ini.short-open-tag" target="_blank">short_open_tag</a>)',
				'type'		=>	'ini',
				'request'	=>	'on',
				'current'	=>	(ini_get('short_open_tag') == 1) ? 'on' : 'off',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Directive: Allow Url Fopen (<a href="http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen" target="_blank">allow_url_fopen</a>)',
				'type'		=>	'ini',
				'request'	=>	'on',
				'current'	=>	(ini_get('allow_url_fopen') == 1) ? 'on' : 'off',
				'why'		=>	null,
			),


	array	(
				'name'		=>	'PHP Directive:  (<a href="http://php.net/manual/en/ini.core.php#ini.post-max-size" target="_blank">post_max_size</a> & <a href="http://php.net/manual/en/ini.core.php#ini.upload-max-filesize" target="_blank">upload_max_filesize</a>)',
				'type'		=>	'maxUploadSize',
				'request'	=>	'64',
				'current'	=>	min( abs(intval(ini_get('post_max_size'))), abs(intval(ini_get('upload_max_filesize'))) ),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Directive:  (<a href="http://php.net/manual/en/ini.core.php#ini.max_execution_time" target="_blank">max_execution_time</a>)',
				'type'		=>	'maxExecutionTime',
				'request'	=>	'120',
				'current'	=>	abs(intval(ini_get('max_execution_time'))),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Directive:  (<a href="http://php.net/manual/en/info.configuration.php#ini.max-input-time" target="_blank">max_input_time</a>)',
				'type'		=>	'maxInputTime',
				'request'	=>	'120',
				'current'	=>	abs(intval(ini_get('max_input_time'))),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Directive:  (<a href="http://php.net/manual/en/ini.core.php#ini.memory-limit" target="_blank">memory_limit</a>)',
				'type'		=>	'memoryLimit',
				'request'	=>	'128',
				'current'	=>	abs(intval(ini_get('memory_limit'))),
				'why'		=>	null,
			),
	/*
	array	(
				'name'		=>	'PHP Extension: GD (<a href="http://php.net/manual/en/book.image.php" target="_blank">GD Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('gd', $extensions))) ? 'true' : 'false',
				'why'		=>	null,
			),
	*/
	array	(
				'name'		=>	'PHP Extension: MBString (<a href="http://php.net/manual/en/book.mbstring.php" target="_blank">MBString Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('mbstring', $extensions))) ? 'true' : 'false',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Extension: PDO (<a href="http://php.net/manual/en/book.pdo.php" target="_blank">PDO Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('PDO', $extensions))) ? 'true' : 'false',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Extension: MySQL (<a href="http://php.net/manual/en/ref.mysql.php" target="_blank">MySQL Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('mysql', $extensions)) OR is_numeric(array_search('mysqlnd', $extensions)) ) ? 'true' : 'false',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Extension: PDO MySQL (<a href="http://php.net/manual/en/ref.pdo-mysql.php" target="_blank">PDO MySQL Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('pdo_mysql', $extensions))) ? 'true' : 'false',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'PHP Extension: cURL (<a href="http://php.net/manual/en/book.curl.php" target="_blank">cURL</a>)',
				'type'		=>	'ext',
				'request'	=>	'true',
				'current'	=>	(is_numeric(array_search('curl', $extensions))) ? 'true' : 'false',
				'why'		=>	null,
			),

	array	(
				'name'		=>	'Directory permissions: CHMOD 0777 > <b>/cache/</b>',
				'type'		=>	'fil',
				'request'	=>	'writable',
				'current'	=>	(is_writable(ROOT.'/cache/')) ? 'writable' : @substr(sprintf('%o', fileperms(ROOT.'/cache/')), -4),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'Directory permissions: CHMOD 0777 > <b>/cache/settings.php</b>',
				'type'		=>	'fil',
				'request'	=>	'writable',
				'current'	=>	(is_writable(ROOT.'/cache/settings.php')) ? 'writable' : ((file_exists(ROOT.'/cache/settings.php')) ? @substr(sprintf('%o', fileperms(ROOT.'/cache/settings.php')), -4) : 'N/A'),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'Directory permissions: CHMOD 0777 > <b>/logs/</b>',
				'type'		=>	'fil',
				'request'	=>	'writable',
				'current'	=>	(is_writable(ROOT.'/logs/')) ? 'writable' : @substr(sprintf('%o', fileperms(ROOT.'/logs/')), -4),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'Directory permissions: CHMOD 0777 > <b>/repository/</b>',
				'type'		=>	'fil',
				'request'	=>	'writable',
				'current'	=>	(is_writable(ROOT.'/repository/')) ? 'writable' : @substr(sprintf('%o', fileperms(ROOT.'/repository/')), -4),
				'why'		=>	null,
			),

	array	(
				'name'		=>	'Directory permissions: CHMOD 0777 > <b>/repository/accounts/</b>',
				'type'		=>	'fil',
				'request'	=>	'writable',
				'current'	=>	(is_writable(ROOT.'/repository/accounts/')) ? 'writable' : @substr(sprintf('%o', fileperms(ROOT.'/repository/accounts/')), -4),
				'why'		=>	null,
			)
	);

$_requirements['optional'] = array(
	/*
	array	(
				'name'		=>	'PHP Extension: PECL uploadprogress  (<a href="http://pecl.php.net/package/uploadprogress" target="_blank">uploadprogress</a>)',
				'type'		=>	'ext',
				'request'	=>	'optional',
				'current'	=>	(function_exists('uploadprogress_get_info')) ? 'true' : 'false',
				'why'		=>	'Animated progress bar when upload videos',
			),

	array	(
				'name'		=>	'PHP Extension: OpenSSL (<a href="http://php.net/manual/en/book.openssl.php" target="_blank">OpenSSL Library</a>)',
				'type'		=>	'ext',
				'request'	=>	'optional',
				'current'	=>	(is_numeric(array_search('openssl', $extensions))) ? 'true' : 'false',
			)
	 */
	);