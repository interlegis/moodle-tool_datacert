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
 * Chapter edit form
 *
 * @package    tool_datacert
 * @copyright  2018 Billy Brian {billybrianm@gmail.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');


class mudardata_form extends moodleform {
    function definition() {
        global $CFG, $DB;

        $cpf = $this->_customdata['cpf'];

        $mform = $this->_form;
        
    	$user = $DB->get_records('user', array('username' => $cpf));

    	$mform->addElement('static', 'cpfstatic', 'Nome do usuário', current($user)->firstname.' '.current($user)->lastname);
    	$mform->addElement('static', 'cpfstatic', 'CPF usuário', current($user)->username);

    	$SQL = "SELECT c.id || ' - ' || c.fullname as fullname
					FROM {user} u
					INNER JOIN {user_enrolments} ue ON ue.userid = u.id
					INNER JOIN {enrol} e ON e.id = ue.enrolid
					INNER JOIN {course} c ON e.courseid = c.id
						WHERE u.id = ?
						ORDER BY c.id desc";

		$id = current($user)->id;
		$values = $DB->get_fieldset_sql($SQL, array($id));

    	$mform->addElement('select', 'courselist', 'Lista de cursos', $values);

    	$mform->addElement('date_selector', 'newdate', 'Nova data');

    	$this->add_action_buttons(false, 'Alterar data');
    
    }
}