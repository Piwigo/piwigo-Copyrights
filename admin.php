<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based picture gallery                                  |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2011 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined("PHPWG_ROOT_PATH")){
  die("Hacking attempt!");
}

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
load_language('plugin.lang', COPYRIGHTS_PATH);

// Check access and exit when user status is not ok
check_status(ACCESS_ADMINISTRATOR);

// Default is to create a copyright, if changed to 1, show the edit page
$edit = 0;

// The values for the form fields
$CRid = 0;
$CRname = '';
$CRurl = '';
$CRdescr = '';
$CRvisible = 0;

// Do managing of copyrights
if (isset($_GET['tab'])) {
  // Create a new copyright
  if ($_GET['tab'] == 'create') {
    // Fetch the values from the form
    $name = pwg_db_real_escape_string($_REQUEST['name']);
    $url = pwg_db_real_escape_string($_REQUEST['url']);
    $descr = pwg_db_real_escape_string($_REQUEST['descr']);
    $visible = (isset($_REQUEST['visible']) ? 1 : 0);

    // Check whether a copyright with such a name exists
    // Therefore count the number of copyrights with that name
    $query = sprintf(
      'SELECT COUNT(*)
      FROM %s
      WHERE `name` = \'%s\'
      ;',
      COPYRIGHTS_ADMIN, $name);
    list($counter) = pwg_db_fetch_row(pwg_query($query));

    if ($counter != 0) { // The copyright exists already
      array_push($page['errors'], l10n('This copyright already exists.'));
    } else { // The copyright did not yet exist
      // Compose a query to insert the copyright
      $query = sprintf(
        'INSERT INTO %s
        (`name`,`url`,`descr`,`visible`) VALUES
        ("%s","%s","%s",%d)
        ;',
        COPYRIGHTS_ADMIN, $name, $url, $descr, $visible);
      pwg_query($query); // Execute the query
    }
  }

  // Edit an existing copyright
  if ($_GET['tab'] == 'edit') {
    $edit = 1; // Show the edit page
    $CRid = $_REQUEST['id']; // Fetch the id of the copyright to be edited

    // Fetch the current attributes to the copyright
    $query = sprintf(
      'SELECT *
      FROM %s
      WHERE `cr_id`=%d
      ;',
      COPYRIGHTS_ADMIN, $CRid);
    $result = pwg_query($query);
    $row = pwg_db_fetch_assoc($result);

    // Save the attributes in convenient variables
    $CRname = $row['name'];
    $CRurl = $row['url'];
    $CRdescr = $row['descr'];
    $CRvisible = $row['visible'];
  }

  // Update an existing copyright
  if ($_GET['tab'] == 'update') {
    // Fetch the values from the edit form
    $id = pwg_db_real_escape_string($_REQUEST['id']);
    $name = pwg_db_real_escape_string($_REQUEST['name']);
    $url = pwg_db_real_escape_string($_REQUEST['url']);
    $descr= pwg_db_real_escape_string($_REQUEST['descr']);
    $visible = (isset($_REQUEST['visible']) ? 1 : 0);

    // Compose a query to update the copyright
    $query = sprintf(
      'UPDATE %s
      SET `name`="%s", `url`="%s", `descr`="%s", `visible`=%d
      WHERE `cr_id`=%d
      ;',
      COPYRIGHTS_ADMIN, $name, $url, $descr, $visible, $id);
    pwg_query($query); // Execute the query
  }

  // Delete an existing copyright
  if ($_GET['tab'] == 'delete') {
    $id = $_REQUEST['id']; // Fetch the id of the copyright to be deleted

    // Compose a query to delete the copyright
    $query = sprintf(
      'DELETE FROM %s
      WHERE `cr_id`=%d
      ;',
      COPYRIGHTS_ADMIN, $id);
    pwg_query($query); // Execute the query
  }
}

/* Assign variables to the template */
global $template;

// Add the admin.tpl template
$template->set_filenames(
  array(
    'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
  )
);

// Select the existing copyrights
$query = sprintf(
  'SELECT *
  FROM %s
  WHERE cr_id <> -1
  ORDER BY cr_id ASC
  ;',
  COPYRIGHTS_ADMIN);
$result = pwg_query($query);

// Append the copyrights to the Smarty array
while ($row = pwg_db_fetch_assoc($result)) {
  $template->append(
    'CRs',
    array(
      'cr_id'   => $row['cr_id'],
      'name'    => $row['name'],
      'url'     => $row['url'],
      'descr'    => $row['descr'],
      'visible' => $row['visible']
    )
  );
}

// Assign the path for URL forming
$template->assign(
  'COPYRIGHTS_PATH',
  COPYRIGHTS_WEB_PATH
);

// Assign all the variables we constructed above
$template->assign('edit', $edit);
$template->assign('CRid', $CRid);
$template->assign('CRname', $CRname);
$template->assign('CRurl', $CRurl);
$template->assign('CRdescr', $CRdescr);
$template->assign('CRvisible', $CRvisible);

// Get it up and running
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>
