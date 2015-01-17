<?php
/**
 * @package table-display-form-for-fresta
 * @version 1.0
*/

/*
Plugin Name: table display form for fresta
Plugin URI: 
Description: This is used to make a dedicated form for users to browse apps in the server.
Version: 1.0
Author: Ze Ni
Author URI: https://www.sics.se/people/ze-ni
License: GPL
*/

require_once("install_handle.php");

/*  Copyright 2013  table display form for fresta  (email : zeni@sics.se)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function apps_display_form(){
	global $wpdb;
	
// 	$conn = mysql_connect("localhost:3306", "fresta", "turbine_r4d4r_pLOw");
// 	echo "conn: $conn";
	
	$apps = $wpdb->get_results("SELECT * FROM Application ORDER BY applicationName, version");
	?>
		
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
		<thead>
			<tr>
				<th width="30%">Application</th>
				<th width="20%">Publisher</th>
				<th width="20%">Version</th>
				<th width="15%">Squawk</th>
				<th width="15%">JDK</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$app_nr = 0;
			foreach ($apps as $app) {
				echo "<tr>\r\n";
				echo "<td>$app->applicationName</td>\r\n";
				echo "<td>$app->publisher</td>\r\n";
				echo "<td>$app->version</td>\r\n";
				echo "<td><form method=\"post\"><input type='hidden' name='app_row' value='$app_nr'/><input type='hidden' name='app_id' value='$app->applicationId'/><input name='Squawk_install' type='image' src='wordpress/custom/images/install.png' alt='Install'/></form></td>\r\n";
				echo "<td><form method=\"post\"><input type='hidden' name='app_row' value='$app_nr'/><input type='hidden' name='app_id' value='$app->applicationId'/><input name='Jdk_install' type='image' src='wordpress/custom/images/install.png' alt='Install'/></form></td>\r\n";
				echo "</tr>\r\n";
				$app_nr++;
			}
			
			mysql_close($conn);
			?>
	<!-- 		<tr> -->
	<!-- 			<td colspan=\"6\" class=\"dataTables_empty\">Loading data from server...</td> -->
	<!-- 		</tr> -->
		</tbody>
		<tfoot>
			<tr>
				<th>Application</th>
				<th>Publisher</th>
				<th>Version</th>
				<th>Squawk</th>
				<th>JDK</th>
			</tr>
		</tfoot>
	</table>
	<div id="feedback"></div>
	
	<?php 
	if (isset($_POST['Jdk_install_x'])) {
		$ret = invoke_install_webservice($_POST['app_id'], 'jdk');
	}
	else if (isset($_POST['Squawk_install_x'])) {
		$ret = invoke_install_webservice($_POST['app_id'], 'Squawk');
	}
}
add_shortcode('apps_display_form', 'apps_display_form');
?>