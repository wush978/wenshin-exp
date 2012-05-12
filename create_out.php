<?php
$config_files_raw = scandir('exam_config');
foreach ($config_files_raw as $file_name) {
	if (strpos($file_name, 'config') !== 0) {
		continue;
	}
	$hash = substr($file_name, 7, 32);
	$config_path = 'exam_config/' . $file_name;
	$out = 'out_' . $hash;
	$command = 'php app/console exam:generate vendor/wenshin/ ' . $config_path . ' ' . $out . ' ' . $hash;
	echo $command . "\n";
	echo system($command) . "\n";
	echo system('rm -rf out_' . $hash . '/.git') . "\n";
}
?>
