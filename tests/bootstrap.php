<?php

set_include_path(
	  realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library')
	. PATH_SEPARATOR
	. get_include_path()
);

spl_autoload_register(function($class){
	if (strpos($class, 'Slam') === 0) {
		include str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class) . '.php';
	}
});
