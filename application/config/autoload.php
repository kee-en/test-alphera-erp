<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = array('session', 'form_validation', 'database', 'email', 'user_agent', 'pagination');

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = array('cache');

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array('html', 'url', 'file', 'inflector', 'text');

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = array(
    "M_global" => "global",
    'M_login' => 'login',
    'M_training_certificate' => 'training_certificate',
    'M_license' => 'license',
    'M_position' => 'position',
    'M_points_of_interview' => 'points_of_interview',
    'M_evaluation_sheet_form' => 'evaluation_sheet_form',
    'M_vessel' => 'manage_vessel',
    'M_restore_vessel' => 'restore_vessel',
    'M_vessel_type' => 'vessel_type',
    'M_vessel_engine' => 'vessel_engine',
    'M_user_group' => 'user_group',
    'M_new_application' => 'new_applicant',
    'M_module' => 'module',
    'M_sub_module' => 'sub_module',
    'M_node' => 'node',
    'M_applicant_pending' => 'applicant_pending',
    'M_applicant_registered' => 'applicant_registered',
    'M_applicant_interview' => 'applicant_interview',
    'M_applicant_reserved' => 'applicant_reserved',
    'M_applicant_failed' => 'applicant_failed',
    'M_applicant_passed' => 'applicant_passed',
    'M_applicant_approval' => 'applicant_approval',
    'M_all_crew' => 'all_crew',
    'M_new_crew' => 'new_crew',
    'M_nre_crew' => 'nre_crew',
    'M_withdrawal_crew' => 'withdrawal_crew',
    'M_flight_monitoring' => 'flight_monitoring',
    'M_medical' => 'medical',
    'M_watchlisted' => 'watchlisted',
    'M_warning_letter' => 'warning_letter',
    'M_report' => 'report',
    'M_contracts' => 'contracts',
    'M_validations' => 'validations',
    'M_backup_db'   => 'm_backup_db',
    'M_crew_arc'   => 'm_crew_arc',
    'M_audit_trail' => 'audit_trail',
    'M_pre_joining' => 'pre_joining',
    'M_crew_management' => 'crew_management',
    'M_existing_crew' => 'existing_crew',
    'M_ex_crew' => 'ex_crew',
    'M_onboarding' => 'onboarding',
    'M_embark' => 'embark',
    'M_disembark' => 'disembark',
    'M_reporting' => 'reporting',
    'M_promotions' => 'promotions',
    'M_approval'  => 'approval',
    'M_routing_slip' => 'routing_slip',
    'M_general_crew_report' => 'gen_crew_report',
    'M_crew_grade_report' => 'crew_grade_report',
);
