<?php

// Add event handlers for the prefilter
add_event_handler('loc_end_element_set_unit', 'CR_set_prefilter_batch_single', 55 );
add_event_handler('loc_begin_element_set_unit', 'CR_batch_single_submit', 50 );

// Change the variables used by the function that changes the template
add_event_handler('loc_end_element_set_unit', 'CR_add_batch_single_vars_to_template');

// Add a prefilter to the template
function CR_set_prefilter_batch_single()
{
	global $template;
	$template->set_prefilter('batch_manager_unit', 'CR_batch_single');
}

// Insert the copyright selector to the template
function CR_batch_single($content)
{
	$search = "#<td><strong>{'Creation date'#";

	// We use the <tr> from the Creation date, and give them a new <tr>
	$replacement = '<td><strong>{\'Copyright\'|@translate}</strong></td>
		<td>
			<select id="copyright-{$element.ID}" name="copyright-{$element.ID}">
				<option value="">--</option>
				{html_options options=$CRoptions selected=$CRcopyrights[$element.ID]}
			</select>
		</td>
	</tr>
	
	<tr>
		<td><strong>{\'Creation date\'';

  return preg_replace($search, $replacement, $content);
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

// Catch the submit and update the copyrights tables
function CR_batch_single_submit()
{
	if (isset($_POST['submit']))
	{
		// The image id's:
		$collection = explode(',', $_POST['element_ids']);

		// Delete all existing id's of which the copyright is going to be set
		if (count($collection) > 0) {
			$query = sprintf(
				'DELETE
				FROM %s
				WHERE media_id IN (%s)
				;',
				COPYRIGHTS_MEDIA, implode(',', $collection));
			pwg_query($query);
		}

		// Add all copyrights to an array
		$edits = array();
		foreach ($collection as $image_id) {
			// The copyright id's
			$crID = pwg_db_real_escape_string($_POST['copyright-'.$image_id]);

			// If you assign no copyright, dont put them in the table
			if ($crID != '') {
				array_push(
					$edits,
					array(
						'media_id' => $image_id,
						'cr_id' => $crID,
					)
				);
			}
		}

		if (count($edits) > 0) {
			// Insert the array to the database
			mass_inserts(
				COPYRIGHTS_MEDIA,        // Table name
				array_keys($edits[0]),   // Columns
				$edits                   // Data
			);
		}
	}
}

?>
