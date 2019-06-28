<?php

function lang($phrase){
	static $lang = array(
		'message' => 'welcome',
		'admin' => 'administrator'
	);
	return $lang[$phrase];
}