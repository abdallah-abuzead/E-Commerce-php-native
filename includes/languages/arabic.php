<?php

function lang($phrase){
	static $lang = array(
		'message' => 'welcome in Arabic',
		'admin' => 'Arabic administrator'
	);
	return $lang[$phrase];
}