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

function plugin_install() {
	global $prefixeTable;
	$query = '
		CREATE TABLE IF NOT EXISTS '.$prefixeTable.'copyrights_admin (
			cr_id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(255) UNIQUE NOT NULL,
			url varchar(255) NOT NULL,
			descr text DEFAULT NULL,
			visible bool DEFAULT 0,
			PRIMARY KEY (cr_id)
		) ENGINE=MyISAM DEFAULT CHARACTER SET utf8
		;';
	pwg_query($query);

  $query = '
    CREATE TABLE IF NOT EXISTS '.$prefixeTable.'copyrights_media (
      media_id int(11) NOT NULL,
      cr_id int(11) NOT NULL,
      PRIMARY KEY (media_id)
    ) ENGINE = MyISAM DEFAULT CHARACTER SET utf8
    ;';
  pwg_query($query);
}

function plugin_activate() {
  global $prefixeTable;

  $query = '
    SELECT COUNT(*)
    FROM '.$prefixeTable.'copyrights_admin
    ;';
  list($counter) = pwg_db_fetch_row(pwg_query($query));
  if (0 == $counter) {
    copyrights_create_default();
  }
}

function plugin_uninstall() {
  global $prefixeTable;

  $query = '
    DROP TABLE '.$prefixeTable.'copyrights_admin
    ;';
  pwg_query($query);

  $query = '
    DROP TABLE '.$prefixeTable.'copyrights_media
    ;';
  pwg_query($query);
}

function copyrights_create_default() {
  global $prefixeTable;

  // Insert the copyrights of Creative Commons
  $inserts = array(
    array(
      'name' => 'Creative Commons (BY)',
      'url' => 'http://creativecommons.org/licenses/by/3.0/',
      'descr' => 'This license lets others distribute, remix, tweak, and build '
                .'upon your work, even commercially, as long as they credit you '
                .'for the original creation. This is the most accommodating of '
                .'licenses offered. Recommended for maximum dissemination and '
                .'use of licensed materials.',
      'visible' => 1
    ),
    array(
      'name' => 'Creative Commons (BY-SA)',
      'url' => 'http://creativecommons.org/licenses/by-sa/3.0/',
      'descr' => 'This license lets others remix, tweak, and build upon your '
                .'work even for commercial purposes, as long as they credit you '
                .'and license their new creations under the identical terms. This '
                .'license is often compared to “copyleft” free and open source '
                .'software licenses. All new works based on yours will carry the '
                .'same license, so any derivatives will also allow commercial '
                .'use. This is the license used by Wikipedia, and is recommended '
                .'for materials that would benefit from incorporating content '
                .'from Wikipedia and similarly licensed projects.',
      'visible' => 1
    ),
    array(
      'name' => 'Creative Commons (BY-ND)',
      'url' => 'http://creativecommons.org/licenses/by-nd/3.0/',
      'descr' => 'This license allows for redistribution, commercial and '
                .'non-commercial, as long as it is passed along unchanged and in '
                .'whole, with credit to you.',
      'visible' => 1
    ),
    array(
      'name' => 'Creative Commons (BY-NC)',
      'url' => 'http://creativecommons.org/licenses/by-nc/3.0/',
      'descr' => 'This license lets others remix, tweak, and build upon your '
                .'work non-commercially, and although their new works must also '
                .'acknowledge you and be non-commercial, they don’t have to '
                .'license their derivative works on the same terms.',
      'visible' => 1
    ),
    array(
      'name' => 'Creative Commons (BY-NC-SA)',
      'url' => 'http://creativecommons.org/licenses/by-nc-sa/3.0/',
      'descr' => 'This license lets others remix, tweak, and build upon your '
                .'work non-commercially, as long as they credit you and license '
                .'their new creations under the identical terms.',
      'visible' => 1
    ),
    array(
      'name' => 'Creative Commons (BY-NC-ND)',
      'url' => 'http://creativecommons.org/licenses/by-nc-nd/3.0/',
      'descr' => 'This license is the most restrictive of our six main licenses, '
                .'only allowing others to download your works and share them with '
                .'others as long as they credit you, but they can’t change them '
                .'in any way or use them commercially.',
      'visible' => 1
    )
  );

  mass_inserts(
    $prefixeTable.'copyrights_admin',
    array_keys($inserts[0]),
    $inserts
  );
}

?>
