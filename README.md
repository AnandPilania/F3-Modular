"# F3Module" 

## KNOWN ISSUES
	1: Rendering modules views:
		This issue can be resolved by modifying `Preview->render` as below:
			if(is_file($view = $f3->fixslashes($dir.$file))) // REPLACE THIS WITH


			$_f = $fw->fixslashes($dir.$file);
			$_fr = str_ireplace('./', '', $_f);
			$view = (is_file($_f) ? $_f : (is_file($_fr) ? $_fr : null));
			if ($view) {