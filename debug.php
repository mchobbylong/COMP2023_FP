<?php
	// Help to debug php via console
	
	function console($log = ''){
		if (!isset($GLOBALS['console'])) $GLOBALS['console'] = '';
		if (empty($log) == FALSE){
			$output = json_encode($log);
			$GLOBALS['console'] .= 'console.log(' . $output . ');';
		}
		else
			echo '<script>' . $GLOBALS['console'] . '</script>';
	}
?>