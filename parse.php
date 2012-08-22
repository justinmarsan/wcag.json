<?php
	
	$wcag = json_decode(file_get_contents("wcag.json"));

	$principles = $sets = $guidelines = array();

	$p_counter = 1;
	foreach($wcag->principles as $p) {
		$p_uuid = $p_counter.' '.$p->title;
		$principles[$p_uuid] = $p;
		$set = $principles[$p_uuid]->sets;
		unset($principles[$p_uuid]->sets);

		$s_counter = 1;
		foreach($set as $s) {
			$s_uuid = $p_counter.'.'.$s_counter.' '.$s->title;
			$sets[$s_uuid] = $s;
			$sets[$s_uuid]->parent = $p_uuid;
			$guides = $sets[$s_uuid]->guidelines;
			unset($sets[$s_uuid]->guidelines);

			$g_counter = 1;
			foreach($guides as $g) {
				$g_uuid = $p_counter.'.'.$s_counter.'.'.$g_counter.' '.$g->title;
				$guidelines[$g_uuid] = $g;
				$guidelines[$g_uuid]->parent = $s_uuid;
			}

			$s_counter++;
		}

		$p_counter++;
	}

	$f_principles = fopen('principles.json', 'a');
	fwrite($f_principles, json_encode($principles));

	$f_sets = fopen('sets.json', 'a');
	fwrite($f_sets, json_encode($sets));

	$f_guidelines = fopen('guidelines.json', 'a');
	fwrite($f_guidelines, json_encode($guidelines));

?>