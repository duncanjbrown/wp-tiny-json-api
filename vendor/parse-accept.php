<?php

/**
 * Parse an Accept: header in a sensitive fashion.
 *
 * http://bililite.com/blog/2010/01/06/parsing-the-http-accept-header/
 */
function parse_accept_header($accept){
	$mimetypes = array( // associate types with file extensions
		'*/*' => 'html',
		'text/*' => 'txt',
		'text/plain' => 'txt',
		'text/html' => 'html',
		'text/csv' => 'csv',
		'text/javascript' => 'js',
		'image/*' => 'png',
		'image/png' => 'png',
		'image/gif' => 'gif',
		'image/jpeg' => 'jpg',
		'application/*' => 'js',
		'application/json' => 'js',
		'application/xml' => 'xml'
	);

	$types = array();
	foreach (explode(',', $accept) as $mediaRange){
		@list ($type, $qparam) = preg_split ('/\s*;\s*/', $mediaRange); // the q parameter must be the first one according to the RFC
		$q = substr ($qparam, 0, 2) == 'q=' ? floatval(substr($qparam,2)) : 1;
		if ($q <= 0) continue;
		if (substr($type, -1) == '*') $q -= 0.0001;
		if (@$type[0] == '*') $q -= 0.0001;
		$types[$type] = $q;
	}
	arsort ($types); // sort from highest to lowest q value
	foreach ($types as $type => $q){
		if (isset ($mimetypes[$type])) return $type;
	}
	return 'html';
}
