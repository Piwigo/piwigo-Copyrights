<?php

// Add a prefilter
add_event_handler('loc_begin_admin', 'CR_set_prefilter_modify', 50 );
add_event_handler('loc_begin_admin_page', 'CR_modify_submit', 45 );

// Change the variables used by the function that changes the template
add_event_handler('loc_begin_admin_page', 'CR_add_modify_vars_to_template');

function CR_set_prefilter_modify()
{
	global $template;
	$template->set_prefilter('picture_modify', 'CR_modify');
}

function CR_modify($content)
{
	$search = "#<strong>{'Creation date'#"; // Not ideal, but ok for now :)

	// We use the <tr> from the Creation date, and give them a new <tr>
	$replacement = '<strong>{\'Copyright\'|@translate}</strong>
		<br>
			<select id="copyrightID" name="copyrightID">
				<option value="">--</option>
				{html_options options=$CRoptions selected=$CRid}
			</select>
		</p>
	
	</p>
  <p>
		<strong>{\'Creation date\'';

    return preg_replace($search, $replacement, $content);
}

function CR_add_modify_vars_to_template()
{
	if (isset($_GET['page']) and 'photo' == $_GET['page'] and isset($_GET['image_id']))
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
		
		// Get the current Copyright
		$image_id = $_GET['image_id'];
		$query = sprintf(
			'SELECT `media_id`, `cr_id`
			FROM %s
			WHERE `media_id` = %d
			;',
			COPYRIGHTS_MEDIA, $image_id);
		$result = pwg_query($query);
		
		$CRid = 0; // Default is '--'
		while ($row = pwg_db_fetch_assoc($result)) {
			$CRid = $row['cr_id'];
		}
		$template->assign('CRid', $CRid);
	}
}

function CR_modify_submit()
{
  if (isset($_GET['page']) and 'photo' == $_GET['page'] and isset($_GET['image_id']))
	{
		if (isset($_POST['submit']))
		{
			// The data from the submit
			$image_id = $_GET['image_id'];
			$CRid = $_POST['copyrightID'];

			// Delete the Copyright if it allready exists
			$query = sprintf(
				'DELETE
				FROM %s
				WHERE `media_id` = %d
				;',
				COPYRIGHTS_MEDIA, $image_id);
			pwg_query($query);

			// If you assign no copyright, dont put it in the table
			if ($CRid != '') {
				// Insert the Copyright
				$query = sprintf(
					'INSERT INTO %s
					VALUES (%d, %d)
					;',
					COPYRIGHTS_MEDIA, $image_id, $CRid);
				pwg_query($query);
			}
		}
	}
}

?>