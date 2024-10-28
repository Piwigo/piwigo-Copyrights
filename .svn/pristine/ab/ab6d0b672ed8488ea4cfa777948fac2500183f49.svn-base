<?php

// Add copyrights drop down menu to the batch manager
add_event_handler('loc_end_element_set_global', 'copyrights_batch_global');
// Add handler to the submit event of the batch manager
add_event_handler('element_set_global_action', 'copyrights_batch_global_submit', 50, 2);

function copyrights_batch_global()
{
	global $template;

	load_language('plugin.lang', dirname(__FILE__).'/');

	// Assign the template for batch management
	$template->set_filename('CR_batch_global', dirname(__FILE__).'/batch_global.tpl');

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


	// Add info on the "choose action" dropdown in the batch manager
	$template->append('element_set_global_plugins_actions', array(
		'ID' => 'copyrights',				// ID of the batch manager action
		'NAME' => l10n('Set copyright'),	// Description of the batch manager action
		'CONTENT' => $template->parse('CR_batch_global', true)
		)
	);
}

// Process the submit action
function copyrights_batch_global_submit($action, $collection)
{
	// If its our plugin that is called
	if ($action == 'copyrights')
	{
		$crID = pwg_db_real_escape_string($_POST['copyrightID']);

		// Delete any previously assigned copyrights
		if (count($collection) > 0) {
			$query = sprintf(
				'DELETE
				FROM %s
				WHERE media_id IN (%s)
				;',
			COPYRIGHTS_MEDIA, implode(',', $collection));
			pwg_query($query);
		}

		// If you assign no copyright, dont put them in the table
		if ($crID != '') {
			// Add the copyrights from the submit form to an array
			$edits = array();
			foreach ($collection as $image_id) {
				array_push(
					$edits,
					array(
						'media_id' => $image_id,
						'cr_id' => $crID,
					)
				);
			}

			// Insert the array into the database
			mass_inserts(
				COPYRIGHTS_MEDIA,		// Table name
				array_keys($edits[0]),	// Columns
				$edits					// Data
			);
		}
	}
}

?>