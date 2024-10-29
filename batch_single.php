<?php

// Add event handlers for the prefilter
add_event_handler('loc_end_element_set_unit', 'copyrights_loc_end_element_set_unit');
// Change the variables used by the function that changes the template
add_event_handler('loc_end_element_set_unit', 'CR_add_batch_single_vars_to_template');

function copyrights_loc_end_element_set_unit()
{
    global $template, $page;
    
    $template->assign(array(
        'COPYRIGHTS_PATH' => COPYRIGHTS_PATH,
    ));
    $template->append('PLUGINS_BATCH_MANAGER_UNIT_ELEMENT_SUBTEMPLATE', 'plugins/Copyrights/batch_single.tpl');
}

// Assign the variables to the Smarty template
function CR_add_batch_single_vars_to_template()
{
	global $template;

	load_language('plugin.lang', dirname(__FILE__).'/');

	// Fetch all the copyrights and assign them to the template
	$query = sprintf(
		'SELECT `cr_id`,`name`
		FROM %s
		WHERE `visible`<>0
		ORDER BY cr_id ASC
		;',
		COPYRIGHTS_ADMIN);
	$result = pwg_query($query);

	$CRoptions = array();
	while ($row = pwg_db_fetch_assoc($result)) {
		$CRoptions[$row['cr_id']] = $row['name'];
	}
	$template->assign('CRoptions', $CRoptions);
	
	// Get the copyright for each element
	$query = sprintf(
		'SELECT `media_id`, `cr_id`
		FROM %s
		;',
		COPYRIGHTS_MEDIA);
	$result = pwg_query($query);
	
	$CRcopyrights = array();
	while ($row = pwg_db_fetch_assoc($result)) {
		$CRcopyrights[$row['media_id']] = $row['cr_id'];
  }

  // Assign the copyrights to the template
	$template->assign('CRcopyrights', $CRcopyrights);
}

?>
