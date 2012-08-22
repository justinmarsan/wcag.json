<?php

	// Oh I love you dirty sloppy code
	$json_guidelines = (array) json_decode(file_get_contents('guidelines.json'));
	$json_sets = (array) json_decode(file_get_contents('sets.json'));
	$json_principles = (array) json_decode(file_get_contents('principles.json'));

	foreach($json_principles as $p) {
		$p->sets = array();
	}

	foreach($json_sets as $s) {
		$s->guidelines = array();
	}

	foreach($json_guidelines as $g) {
		$json_sets[$g->parent]->guidelines[] = $g;
	}

	foreach($json_sets as $s) {
		$json_principles[$s->parent]->sets[] = $s;
	}

	$build = array();
	foreach($json_principles as $p) {
		$build[] = $p;
	}

	$f_principles = fopen('wcag.json', 'a');
	fwrite($f_principles, json_encode($build));
		

?>