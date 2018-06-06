<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Muda a data de um certificado de um aluno específico e curso específico.
 *
 * @package    tool
 * @subpackage datacert
 * @copyright  2018 Billy Brian {billybrianm@gmail.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once('datacert_form.php');

global $DB;

admin_externalpage_setup('tooldatacert');
$url = new moodle_url('/admin/tool/datacert/index.php');


echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'tool_datacert'));
	
$mform = new datacert_form();

if ($data = $mform->get_data()) {

	$mform = new datacert_form(null, array('cpf' => $data->cpf));

	if($mform->get_submit_value("newdate")) {
		$date = new DateTime(($mform->get_submit_value("newdate")['day']).'-'.($mform->get_submit_value("newdate")['month']).'-'.($mform->get_submit_value("newdate")['year']));

		$date->

		$curso_split = explode(" ",$mform->get_submit_value("courselist"));
		
		$user = $DB->get_records('user', array('username' => $mform->get_submit_value("userv")));
		$u_id = current($user)->id;
		$u_username = current($user)->username;
		$u_firstname = current($user)->firstname;
		$u_lastname = current($user)->lastname;

		$DB->update_record('user', array('id' => $u_id, 'firstaccess' => $date->getTimestamp()));

		print('Data do certificado de '.$u_firstname.' '.$u_lastname.' (cpf '.$u_username.') trocada para '.($mform->get_submit_value("newdate")['day']).'-'.($mform->get_submit_value("newdate")['month']).'-'.($mform->get_submit_value("newdate")['year']).' com sucesso!');
	}
	$mform->display();
}

else {
	$mform->display();
}

echo $OUTPUT->footer();
