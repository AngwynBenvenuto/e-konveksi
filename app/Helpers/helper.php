<?php
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

if(!function_exists('set_active')) {
    function set_active($uri, $output = 'active') {
        if( is_array($uri) ) {
            foreach ($uri as $u) {
                if (\Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (\Route::is($uri)){
                return $output;
            }
        }
    }
}

if(!function_exists('__generate_password')) {
    function __generate_password() {
        $str = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789");
        shuffle($str);
        $salt = '';
        foreach (array_rand($str, 8) as $key) {
            $salt .= $str[$key];
        }
        return $salt;
    }
}

if(!function_exists('__generate_token')) {
    function __generate_token($email = NULL) {
        $data = $email.date('Y-m-d H:i:s');
        return md5($data);
    }
}

if ( ! function_exists('force_download'))
{
	/**
	 * Force Download
	 *
	 * Generates headers that force a download to happen
	 *
	 * @param	string	filename
	 * @param	mixed	the data to be downloaded
	 * @param	bool	whether to try and send the actual file MIME type
	 * @return	void
	 */
	function force_download($filename = '', $data = '', $set_mime = FALSE)
	{
		if ($filename === '' OR $data === '')
		{
			return;
		}
		elseif ($data === NULL)
		{
			if ( ! @is_file($filename) OR ($filesize = @filesize($filename)) === FALSE)
			{
				return;
			}

			$filepath = $filename;
			$filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
			$filename = end($filename);
		}
		else
		{
			$filesize = strlen($data);
		}

		// Set the default MIME type to send
		$mime = 'application/octet-stream';

		$x = explode('.', $filename);
		$extension = end($x);

		if ($set_mime === TRUE)
		{
			if (count($x) === 1 OR $extension === '')
			{
				/* If we're going to detect the MIME type,
				 * we'll need a file extension.
				 */
				return;
			}

			// Load the mime types
			$mimes =& get_mimes();

			// Only change the default MIME if we can find one
			if (isset($mimes[$extension]))
			{
				$mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
			}
		}

		/* It was reported that browsers on Android 2.1 (and possibly older as well)
		 * need to have the filename extension upper-cased in order to be able to
		 * download it.
		 *
		 * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
		 */
		if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT']))
		{
			$x[count($x) - 1] = strtoupper($extension);
			$filename = implode('.', $x);
		}

		if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE)
		{
			return;
		}

		// Clean output buffer
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE)
		{
			@ob_clean();
		}

		// Generate the server headers
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.$filesize);
		header('Cache-Control: private, no-transform, no-store, must-revalidate');

		// If we have raw data - just dump it
		if ($data !== NULL)
		{
			exit($data);
		}

		// Flush 1MB chunks of data
		while ( ! feof($fp) && ($data = fread($fp, 1048576)) !== FALSE)
		{
			echo $data;
		}
		fclose($fp);
		exit;
	}
}
