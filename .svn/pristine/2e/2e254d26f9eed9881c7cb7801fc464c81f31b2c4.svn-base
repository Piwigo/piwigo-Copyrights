<?php

// Add an event handler for a prefilter
add_event_handler('loc_begin_picture', 'copyrights_set_prefilter_add_to_pic_info', 55 );

// Change the variables used by the function that changes the template
add_event_handler('loc_begin_picture', 'copyrights_add_image_vars_to_template');

// Add the prefilter to the template
function copyrights_set_prefilter_add_to_pic_info()
{
	global $template;
	$template->set_prefilter('picture', 'copyrights_add_to_pic_info');
}

// Insert the template for the copyright display
function copyrights_add_to_pic_info($content)
{
	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';
	
	$replacement = 'class="imageInfoTable">
	<div id="Copyrights_name" class="imageInfo">
		<dt>{\'Copyright\'|@translate}</dt>
		<dd>
{if $CR_INFO_NAME}
			<a target="_blanc" href="{$CR_INFO_URL}" title="{$CR_INFO_NAME}: {$CR_INFO_DESCR}">{$CR_INFO_NAME}</a>
{else}
      {\'N/A\'|@translate}
{/if}
    </dd>
	</div>';

	return preg_replace($search, $replacement, $content, 1);
}

// Assign values to the variables in the template
function copyrights_add_image_vars_to_template()
{
	global $page, $template, $prefixeTable;

	// Show block only on the photo page
	if ( !empty($page['image_id']) )
	{
		// Get the copyright name, url and description that belongs to the current media_item
		$query = sprintf('
		  select cr_id, name, url, descr
		  FROM %s NATURAL JOIN %s
		  WHERE media_id = %s
		  AND visible = 1
		;',
		COPYRIGHTS_ADMIN, COPYRIGHTS_MEDIA, $page['image_id']);
		$result = pwg_query($query);
		$row = pwg_db_fetch_assoc($result);
		$name = '';
		$url = '';
		$descr = '';
		if (isset($row) and count($row) > 0) {
			// If its the authors default copyright, get the data from the author table, instead of the copyright table
			if ($row['cr_id'] == -1) {
				// Check if the extended author plugin is active
				$query = '
					SELECT *
					FROM '.$prefixeTable.'plugins
					WHERE id=\'Extended_author\'
					AND state=\'active\'
					;';
				$result = pwg_query($query);
				$row = pwg_db_fetch_assoc($result);
				
				// Only get the authors default copyright when it is active.
				if (count($row) > 0) {
					$query = sprintf('
						SELECT name, url, descr
						FROM %s
						WHERE cr_id IN (
							SELECT a.copyright
							FROM '.$prefixeTable.'images i, '.$prefixeTable.'author_extended a
							WHERE i.id = %d
							AND i.author = a.name
						)
						;',
						COPYRIGHTS_ADMIN, $page['image_id']);
					$result = pwg_query($query);
					$row = pwg_db_fetch_assoc($result);
				}
			}
		}
		// Get the data from the chosen row
		if (isset($row) and count($row) > 0) {
			$name = $row['name'];
			$url = $row['url'];
			$descr = $row['descr'];
		}
			
		// Sending data to the template
    $template->assign(
      array	(
        'CR_INFO_NAME' => $name,
        'CR_INFO_URL' => $url,
        'CR_INFO_DESCR' => $descr
      )
    );
	}
}

?>
