<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'display/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
$route['maintenance'] = 'maintenance/index';

//GLOBAL FUNCTIONS
$route['get-all-in-signer-crew'] = 'global_function/get_all_in_signer_crew';
$route['get-training-certificate'] = 'global_function/get_training_certificate';
$route['get-license'] = 'global_function/get_license';
$route['get-all-position'] = 'global_function/get_all_position';
$route['get-position-by-position'] = 'global_function/get_position_by_position';
$route['get-all-suffix'] = 'global_function/get_all_suffix';
$route['get-all-civil-status'] = 'global_function/get_all_civil_status';
$route['get-all-religion'] = 'global_function/get_all_religion';
$route['get-all-nationality'] = 'global_function/get_all_nationality';
$route['get-all-province'] = 'global_function/get_all_province';
$route['get-all-city'] = 'global_function/get_all_city';
$route['get-cities'] = 'global_function/get_cities';
$route['get-all-source'] = 'global_function/get_all_source';
$route['get-all-contracts'] = 'global_function/get_all_contracts';
$route['get-training-certificates'] = 'global_function/get_training_certificates';
$route['get-all-licenses'] = 'global_function/get_all_licenses';
$route['get-position-details'] = 'global_function/get_position';
$route['get-interview-form-details'] = 'global_function/get_interview_form';
$route['get-general-interview-form'] = 'global_function/get_general_interview_form';
$route['get-technical-interview-form'] = 'global_function/get_technical_interview_form';
$route['get-evaluation-value'] = 'global_function/get_evaluation_value';
$route['get-all-type-vessels'] = 'global_function/get_all_type_vessels';
$route['get-all-vessels'] = 'global_function/get_all_vessels';
$route['get-vessel'] = 'global_function/get_vessel';
$route['get-vessel-type'] = 'global_function/get_vessel_type';
$route['get-vessel-type-vessel'] = 'global_function/get_vessel_type_by_vessel';
$route['get-vessel-engine'] = 'global_function/get_vessel_engine';
$route['get-account-details'] = 'global_function/get_account_details';
$route['get-user-group'] = 'global_function/get_user_group';
$route['get-sea-service'] = 'global_function/get_sea_service';
$route['get-sea-services'] = 'global_function/get_sea_services';
$route['get-module'] = 'global_function/get_module';
$route['get-sub-module'] = 'global_function/get_sub_module';
$route['get-node'] = 'global_function/get_node';
$route['get-civil-status'] = 'global_function/get_civil_status';
$route['get-religion'] = 'global_function/get_religion';
$route['get-city'] = 'global_function/get_city';
$route['get-province'] = 'global_function/get_province';
$route['get-nationality'] = 'global_function/get_nationality';
$route['get-applicant-information'] = 'global_function/get_applicant_information';
$route['get-working-gears'] = 'global_function/get_working_gears';
$route['get-educational-attainment'] = 'global_function/get_educational_attainment';
$route['get-next-of-kin'] = 'global_function/get_next_of_kin';
$route['get-licenses'] = 'global_function/get_licenses';
$route['get-certificates'] = 'global_function/get_certificates';
$route['get-sea-service-record'] = 'global_function/get_sea_service_record';
$route['get-offsigner-sea-service-record'] = 'global_function/get_offsigner_sea_service_record';
$route['get-evaluation-sheet'] = 'global_function/get_evaluation_sheet';
$route['get-general-interviews'] = 'global_function/get_general_interviews';
$route['get-technical-interview'] = 'global_function/get_technical_interview';
$route['get-employed-crew'] = 'global_function/get_employed_crew';
$route['get-applicants'] = 'global_function/get_applicants';
$route['get-crew-information'] = 'global_function/get_crew_information';
$route['get-general-interview'] = 'global_function/get_general_interview';
$route['get-interview-sheet'] = 'global_function/get_interview_sheet';
$route['get-list-licenses'] = 'global_function/get_list_licenses';
$route['get-list-certificates'] = 'global_function/get_list_certificates';
$route['get-list-sea-service-record'] = 'global_function/get_list_sea_service_record';
$route['get-list-flights'] = 'global_function/get_list_flights';
$route['get-crew-list-flights'] = 'global_function/get-crew-list-flights';
$route['update-applicant-status'] = 'global_function/update_applicant_status';
$route['update-crew-status'] = 'global_function/update_crew_status';
$route['applicant-not-qualified'] = 'global_function/applicant_not_qualified';
$route['get-total-sea-service'] = 'global_function/get_total_sea_service';
$route['get-failed-reason'] = 'global_function/get_failed_reason';
$route['get-applicant-photo'] = 'global_function/get_applicant_photo';
$route['get-all-training-certificates'] = 'global_function/get_all_certificates';
$route['get-position-scores'] = 'global_function/get_all_certificates_position';
$route['get-all-usertype'] = 'global_function/get_all_usertype';
$route['get-user-responsibility-list'] = 'global_function/get_user_responsibility_list';
$route['get-crew-position'] = 'global_function/get_crew_position';
$route['get-sea-service-total'] = 'global_function/getSeaserviceTotal';
$route['get-cmp-information'] = 'global_function/cmp_crew_details';
$route['get-crew-details'] = 'global_function/get_crew_details';
$route['get-vessel-history'] = 'global_function/get_vessel_history';
$route['get-offsigner-vessel-history'] = 'global_function/get_offsigner_vessel_history';
$route['get-cmp-sea-service'] = 'global_function/get_cmp_sea_service_record';
$route['get-applicant-type'] = 'global_function/get_applicant_type';
$route['get-crew-disembark'] = 'global_function/get_crew_disembark';
$route['get-all-department'] = 'global_function/get_all_department';
$route['get-all-licenses-docs'] = 'global_function/get_all_licenses_docs';
$route['get-licenses-by-positions'] = 'global_function/get_licenses_by_positions';
$route['get-list-positions'] = 'global_function/get_list_positions';
$route['check-technical-form'] = 'global_function/check_technical_form';
$route['get-warning-statuses'] = 'global_function/get_warning_statuses';
$route['get-all-toc-reasons'] = 'global_function/get_toc_reasons';

$route['update-sea-service'] = 'global_function/update_sea_service';

$route['get-crew-name-crew-code'] = 'global_function/get_crew_name_crwcode';

$route['get-crew-name'] = 'global_function/get_crew_name_cmpcode';
$route['get-crew-name-by-monitor'] = 'global_function/get_crew_name_mntrcode';

$route['get-cmpcrew-contract-table'] = 'global_function/cmp_crew_contract_table';
$route['get-cmpcrew-mlc-table'] = 'global_function/cmp_crew_mlc_table';

$route['get-cmp-medical-records-table'] = 'global_function/get_cmp_medical_records_table';

$route['get-list-licenses-cmp'] = 'global_function/get_list_licenses_cmp';
$route['get-list-certificates-cmp'] = 'global_function/get_list_certificates_cmp';

$route['get-crew-offsigner'] = 'global_function/get_crew_offsigner';


$route['check-crew-on-vacation'] = 'global_function/check_crew_on_vacation';
// DASHBOARD
$route['dashboard'] = 'admin_dashboard/index';
$route['get-dashboard-donut'] = 'admin_dashboard/dashboard_donut';
$route['get-dashboard-donut-peme'] = 'admin_dashboard/dashboard_peme_donut';
$route['get-expired-docs'] = 'admin_dashboard/get_all_expired_certs';
$route['get-expired-certs'] = 'admin_dashboard/get_all_expired_licenses';
$route['get-recruitment-performance'] = 'admin_dashboard/get_recruitment_performance_report';


// AUTH
$route['login'] = 'login/index';
$route['auth'] = 'login/auth';
$route['deAuth'] = 'login/deAuth';

// APPLICATION
$route['shipboard-employment-application'] = 'shipboard_application/index';
$route['save-shipboard-application'] = 'shipboard_application/save_shipboard_application';
$route['create-new-application'] = 'new_application/index';
$route['save-new-applicant'] = 'new_application/save_new_applicant';
$route['save-applicant-picture'] = 'shipboard_application/save_applicant_picture';
$route['crew-existing-application-form'] = 'existing_crew/index';
$route['save-existing-crew-application'] = 'existing_crew/add_existing_crew';
$route['generate-crew-list'] = 'existing_crew/get_crew_list';

//Existing
$route['get-technical-interview-form-existing'] = 'existing_crew/get_technical_interview_form';


// CREW
$route['crew-embarked'] = 'embarked/index';
$route['crew-embarked/(:any)'] = 'embarked/index/$1';
$route['crew-embarked-get-embark-disembark'] = 'embarked/crew_embarked_get_embark_disembark';
$route['crew-embarked-assign-offsigner'] = 'embarked/crew_embarked_assign_offsigner';


$route['crew-disembarked'] = 'disembarked/index';
$route['crew-disembarked/(:any)'] = 'disembarked/index/$1';
$route['crew-watchlisted'] = 'watchlisted/index';
$route['crew-watchlisted/(:any)'] = 'watchlisted/index/$1';
$route['crew-warning-letter'] = 'warning_letter/index';
$route['crew-warning-letter/(:any)'] = 'warning_letter/index/$1';
$route['admin-approval'] = 'admin_approval/index';
$route['admin-approval/(:any)'] = 'admin_approval/index/$1';
$route['contracts'] = 'contracts/index';
$route['contracts/(:any)'] = 'contracts/index/$1';

$route['get-mlc-details'] = 'contracts/get_mlc_details';
$route['get-poea-details'] = 'contracts/get_poea_details';
$route['get-view-poea-details'] = 'contracts/get_view_poea_details';
$route['get-crew-promotion-details'] = 'embarked/get_crew_details_promotion';

$route['update-mlc-promotion'] = 'embarked/update_mlc_promotion';
$route['update-poea-promotion'] = 'embarked/update_poea_promotion';
$route['update-pos-vess-promotion'] = 'embarked/promote_crew_onboard';
$route['promotion-list-report'] = 'crew_promotion/promotion_list_report';

$route['embarked-crew-search'] = 'embarked/embarked_crew_search';
$route['embarked-search-reset'] = 'embarked/embarked_search_reset';
$route['check-updated-promotion-req'] = 'embarked/check_promotion_details';

$route['disembarked-crew-search'] = 'disembarked/disembarked_crew_search';
$route['disembarked-search-reset'] = 'disembarked/disembarked_search_reset';

//Repatriated Report
$route['vessel-report'] = 'vessel_report/index';
$route['nre-report'] = 'NRE_crew/get_nre_report';
$route['crew-grade-report'] = 'crew_grade_report/index';
$route['toc-report'] = 'transfer_company/get_toc_report';
$route['repatriation-report'] = 'repatriation_report/index';
$route['illness-injury-report'] = 'illness_injury_report/index';
$route['warning-letter-report'] = 'Warning_letter_report/index';
$route['recruitment-performance'] = 'recruitment_performance/index';

$route['reset-toc-report'] = 'transfer_company/reset_toc_filter';
$route['set-toc-report'] = 'transfer_company/set_toc_filter';
$route['set-nre-report'] = 'NRE_crew/set_nre_report_filter';
$route['reset-nre-report'] = 'NRE_crew/reset_nre_report_filter';

$route['get-vessels-report'] = 'vessel_report/get_vessel_report';
$route['get-crew-grade-report'] = 'crew_grade_report/get_crew_grade_report';
$route['get-gen-crew-report'] = 'repatriation_report/generate_crew_gen_report';
$route['get-illness-injury-rate'] = 'illness_injury_report/get_illness_injury_rate';
$route['get-warning-letter-report'] = 'Warning_letter_report/get_warning_letter_report';

//Crew shortage
$route['crew-shortage-report'] = 'Crew_shortage/index';
//Evaluation Report
$route['evaluation-rate-report'] = 'Evaluation_rate_report/index';

// REPORTING
$route['for-reporting'] = 'for_reporting/index';
$route['create-on-vacation-crew'] = 'for_reporting/create_on_vacation_crew';

$route['reporting-crew-search'] = 'for_reporting/reporting_crew_search';
$route['reporting-search-reset'] = 'for_reporting/reporting_search_reset';
//ONBOARDING
$route['for-onboarding'] = 'for_onboarding/index';
$route['add-crew-cmplan'] = 'for_onboarding/add_crew_cmplan';
$route['add-crew-flight'] = 'for_onboarding/add_crew_flight';

$route['onboarding-crew-search'] = 'for_onboarding/onboarding_crew_search';
$route['onboarding-search-reset'] = 'for_onboarding/onboarding_search_reset';

// VESSELS
$route['manage-vessel'] = 'manage_vessel/index';
$route['archive-vessel'] = 'archive_vessel/index';
$route['type-of-engine'] = 'type_of_engine/index';
$route['type-of-vessel'] = 'type_of_vessel/index';

// USERS
$route['register-user'] = 'register_user/index';
$route['user-group'] = 'user_group/index';
$route['user-responsibility'] = 'user_responsibility/index';
$route['manage-users'] = 'manage_users/index';
$route['get-all-users'] = 'manage_users/get_all_users';
$route['get-user-details'] = 'manage_users/get_user_details';
$route['update-user-type'] = 'manage_users/update_user_type';
$route['update-user-password'] = 'manage_users/update_user_password';
$route['deactivate-user-account'] = 'manage_users/deactivate_user_account';

// SETTINGS
$route['evaluation-sheet'] = 'evaluation_sheet/index';
$route['position'] = 'position/index';
$route['manage-requirements'] = 'position/manage_requirements';
$route['points-interview-form'] = 'points_interview_form/index';
$route['manage-points-of-interview'] = 'points_interview_form/manage_points_of_interview';
$route['backup-db'] = 'backup_db/index';
$route['backup-db/(:any)'] = 'backup_db/index/$1';
$route['backup-database-function'] = 'backup_db/DB_archived';
$route['delete-backup-db'] = 'backup_db/Delete_db';
$route['download-backup-db'] = 'backup_db/Download_db';
$route['update-position-certificates'] = 'position/update_position_certificates';
$route['get-all-points'] = 'points_interview_form/display_points_list';
$route['update-position-points'] = 'points_interview_form/update_position_points';
$route['watchlisted-reasons'] = 'watchlisted_reasons/index';

// MANAGE LICENSES
$route['manage-licenses'] = 'manage_licenses/index';
$route['save-licenses-by-position'] = 'manage_licenses/save_licenses_by_position';
$route['get-selected-licenses-per-position'] = 'manage_licenses/get_selected_licenses_per_position';



$route['audit-trail'] = 'audit_trail/index';
$route['audit-trail/(:any)'] = 'audit_trail/index/$1';

// DEVELOPER
$route['module'] = 'module/index';
$route['sub-module'] = 'sub_module/index';
$route['node'] = 'node/index';

//TRAINING CERTIFICATES
$route['training-certificate'] = 'training_certificate/index';
$route['add-training-certificate'] = 'training_certificate/add_training_certificate';
$route['get-training-certificate-table'] = 'training_certificate/get_training_certificate_table';
$route['remove-training-certificates'] = 'training_certificate/remove_training_certificates';
$route['save-edit-training-certificate'] = 'training_certificate/save_edit_training_certificate';

//LICENSES
$route['licenses'] = 'licenses/index';
$route['get-license-table'] = 'licenses/get_license_table';
$route['add-license'] = 'licenses/add_license';
$route['remove-license'] = 'licenses/remove_license';
$route['save-edit-license'] = 'licenses/save_edit_license';
$route['get-numbers'] = 'licenses/get_document_numbers';

// POSITION
$route['get-position-table'] = 'position/get_position_table';
$route['add-position'] = 'position/add_position';
$route['remove-position'] = 'position/remove_position';
$route['save-edit-position'] = 'position/save_edit_position';

// INTERVIEW FORM
$route['get-interview-form-table'] = 'points_interview_form/get_interview_form_table';
$route['add-points-interview-form'] = 'points_interview_form/add_points_interview_form';
$route['remove-interview-form'] = 'points_interview_form/remove_interview_form';
$route['save-edit-points-interview-form'] = 'points_interview_form/save_edit_points_interview';

// EVALUATION SHEET FORM
$route['save-edit-evaluation-sheet-form'] = 'evaluation_sheet/save_edit_evaluation_sheet_form';

// MANAGE VESSEL
$route['get-vessel-table'] = 'manage_vessel/get_vessel_table';
$route['add-vessel'] = 'manage_vessel/add_vessel';
$route['save-edit-vessel'] = 'manage_vessel/save_edit_vessel';
$route['remove-vessel'] = 'manage_vessel/remove_vessel';

// ARCHIVE VESSEL
$route['get-archive-vessel-table'] = 'archive_vessel/get_archive_vessel_table';
$route['restore-vessel'] = 'archive_vessel/restore_vessel';
$route['permanently-delete-vessel'] = 'archive_vessel/permanently_delete_vessel';

// VESSEL TYPE
$route['get-vessel-type-table'] = 'type_of_vessel/vessel_type_table';
$route['add-vessel-type'] = 'type_of_vessel/add_vessel_type';
$route['save-edit-vessel-type'] = 'type_of_vessel/save_edit_vessel_type';
$route['remove-vessel-type'] = 'type_of_vessel/remove_vessel_type';

// VESSEL ENGINE
$route['get-engine-type-table'] = 'type_of_engine/engine_type_table';
$route['add-vessel-engine'] = 'type_of_engine/add_vessel_engine';
$route['save-edit-vessel-engine'] = 'type_of_engine/save_edit_vessel_engine';
$route['remove-vessel-engine'] = 'type_of_engine/remove_vessel_engine';

// USER RESPONSIBILITY
$route['get-user-group-table'] = 'user_responsibility/get_user_group_table';

// USER GROUP
$route['get-user-group-table'] = 'user_group/get_user_group_table';
$route['add-user-group'] = 'user_group/add_user_group';
$route['save-edit-user-group'] = 'user_group/save_edit_user_group';
$route['remove-user-group'] = 'user_group/remove_user_group';
$route['save-user-type'] = 'user_group/add_user_usertype';

// MODULE
$route['get-module-table'] = 'module/get_module_table';
$route['add-module'] = 'module/add_module';
$route['save-edit-module'] = 'module/save_edit_module';
$route['remove-module'] = 'module/remove_module';

// SUB MODULE
$route['get-sub-module-table'] = 'sub_module/get_sub_module_table';
$route['add-sub-module'] = 'sub_module/add_sub_module';
$route['save-edit-sub-module'] = 'sub_module/save_edit_sub_module';
$route['remove-sub-module'] = 'sub_module/remove_sub_module';

// NODE
$route['get-node-table'] = 'node/get_node_table';
$route['add-node'] = 'node/add_node';
$route['save-edit-node'] = 'node/save_edit_node';
$route['remove-node'] = 'node/remove_node';

// MY ACCOUNT
$route['my-account'] = 'my_account/index';

// REGISTERED
$route['registered-applicants'] = 'applicant_registered/index';
$route['registered-applicants/(:any)'] = 'applicant_registered/index/$1';
$route['search-registered'] = 'applicant_registered/search_registered';
$route['unset-search-data'] = 'applicant_registered/unset_search_data';

// PENDING
$route['pending-applicants'] = 'applicant_pending/index';
$route['pending-applicants/(:any)'] = 'applicant_pending/index/$1';
$route['search-pending'] = 'applicant_pending/search_pending';
$route['add-nat-result'] = 'applicant_pending/add_nat_result';
$route['unset-search-pending'] = 'applicant_pending/unset_search_pending';

// FOR INTERVIEW
$route['for-interview'] = 'applicant_interview/index';
$route['for-interview/(:any)'] = 'applicant_interview/index/$1';
$route['edit-shipboard-aplication'] = 'applicant_interview/edit_shipboard_aplication';
$route['save-evaluation-form'] = 'applicant_interview/save_evaluation_form';
$route['save-general-interview'] = 'applicant_interview/save_general_interview';
$route['save-technical-interview'] = 'applicant_interview/save_technical_interview';
$route['save-employed-crew-form'] = 'applicant_interview/save_employed_crew_form';
$route['save-interview-sheet'] = 'applicant_interview/save_interview_sheet';
$route['search-interview'] = 'applicant_interview/search_interview';
$route['unset-search-interview'] = 'applicant_interview/unset_search_interview';

// RESERVED APPLICANTS
$route['reserved-applicants'] = 'applicant_reserved/index';
$route['reserved-applicants/(:any)'] = 'applicant_reserved/index/$1';
$route['search-reserved'] = 'applicant_reserved/search_reserved';
$route['revert-applicant-status'] = 'applicant_reserved/revert_applicant_status';
$route['unset-search-reserve'] = 'applicant_reserved/unset_search_reserve';

// NOT QUALIFIED
$route['not-qualified'] = 'applicant_failed/index';
$route['not-qualified/(:any)'] = 'applicant_failed/index/$1';
$route['search-failed'] = 'applicant_failed/search_failed';
$route['unset-search-failed'] = 'applicant_failed/unset_search_failed';

// PASSED
$route['passed-applicants'] = 'applicant_passed/index';
$route['passed-applicants/(:any)'] = 'applicant_passed/index/$1';
$route['move-cm-plan'] = 'applicant_passed/move_cm_plan';
$route['search-passed'] = 'applicant_passed/search_passed';
$route['unset-search-passed'] = 'applicant_passed/unset_search_passed';

// FOR APPROVAL
$route['for-approval'] = 'applicant_approval/index';
$route['for-approval/(:any)'] = 'applicant_approval/index/$1';
$route['search-approved'] = 'applicant_approval/search_approved';
$route['unset-search-approval'] = 'applicant_approval/unset_search_approval';
$route['get-approval-details'] = 'admin_approval/get_approval_request';
$route['approve-medical-request'] = 'admin_approval/approve_medical_request';
$route['reject-medical-request'] = 'admin_approval/reject_medical_request';
$route['approve-toc-request'] = 'admin_approval/approve_toc_request';
$route['reject-toc-request'] = 'admin_approval/reject_toc_request';
$route['approve-promotion-request'] = 'admin_approval/approve_promotion_request';
$route['reject-promotion-request'] = 'admin_approval/reject_promotion_request';

$route['view-promotion-request'] = 'admin_approval/view_promotion_request';

// PROMOTIONS
$route['crew-promotion'] = 'crew_promotion/index';
$route['crew-promotion/(:any)'] = 'crew_promotion/index/$1';
$route['crew-promotion-search'] = 'crew_promotion/crew_promotion_search';
$route['unset-crew-promotion-search'] = 'crew_promotion/unset_crew_promotion_search';
$route['get-data-for-promotion-details'] = 'crew_promotion/get_mlc_for_promotion';

// CMP
$route['crew-management-plan'] = 'crew_management_plan/index';
$route['crew-management-plan/(:any)'] = 'crew_management_plan/index/$1';
$route['select-on-signer'] = 'crew_management_plan/select_on_signer';
$route['remove-on-signer'] = 'crew_management_plan/remove_on_signer';
$route['cmp-search'] = 'crew_management_plan/cmp_search';
$route['cmp-search-reset'] = 'crew_management_plan/cmp_search_reset';
$route['get-cmp-details'] = 'crew_management_plan/get_cmp_details';
$route['update-cmp-form'] = 'crew_management_plan/update_cmp';
$route['update-crew-pos-vessel'] = 'crew_management_plan/update_crew_pos_vessel';

// ALL CREW
$route['all-crew'] = 'all_crew/index';
$route['all-crew/(:any)'] = 'all_crew/index/$1';
$route['all-crew-search'] = 'all_crew/all_crew_search';
$route['unset-crew-search'] = 'all_crew/unset_crew_search';
$route['save-edit-crew-information'] = 'all_crew/save_edit_crew_information';
$route['get-all-crew'] = 'all_crew/get_all_crew';

// NEW CREW
$route['new-crew'] = 'new_crew/index';
$route['new-crew/(:any)'] = 'new_crew/index/$1';
$route['new-crew-search'] = 'new_crew/new_crew_search';
$route['newcrew-search-reset'] = 'new_crew/newcrew_search_reset';

// EX CREW
$route['ex-crew'] = 'ex_crew/index';
$route['get-ex-crew-information'] = 'ex_crew/get_ex_crew_information';
$route['excrew-search'] = 'ex_crew/excrew_search';
$route['excrew-search-reset'] = 'ex_crew/excrew_search_reset';

// NRE CREW
$route['nre-crew'] = 'NRE_crew/index';
$route['nre-crew/(:any)'] = 'NRE_crew/index/$1';
$route['nre-crew-search'] = 'NRE_crew/nre_crew_search';
$route['reset-nre-crew-search'] = 'NRE_crew/nre_search_reset';

// WITHDRAWAL CREW
$route['withdrawal-crew'] = 'withdrawal_crew/index';
$route['withdrawal-crew/(:any)'] = 'withdrawal_crew/index/$1';
$route['un-withdrawal-crew'] = 'withdrawal_crew/un_withdrawal_crew';


//WATCH LIST CREW
$route['search-crew'] = 'watchlisted/search_crew_by_select';
$route['search-crew-id'] = 'watchlisted/search_crew_by_id';
$route['insert-watchlist-crew'] = 'watchlisted/save_watchlisted_crew';
$route['get-watchlisted-crew'] = 'watchlisted/get_watchlisted_crew';
$route['delete-watchlisted-crew'] = 'watchlisted/delete_watchlisted_crew';

//WARNING LETTER
$route['search-crew-warningletter'] = 'warning_letter/search_crew_warning_letter';
$route['get-warningletter-crew'] = 'warning_letter/get_warningletter_crew';
$route['get-warning-letter-details'] = 'warning_letter/get_warningletter_details';

$route['search-warningletter-id'] = 'warning_letter/search_warningletter_by_id';
// $route['search-warningletter-edit'] = 'warning_letter/search_warningletter_edit';
$route['delete-warningletter-crew'] = 'warning_letter/delete_warningletter_crew';
$route['insert-warningletter-crew'] = 'warning_letter/save_warningletter_crew';
$route['insert-dis-warningletter-crew'] = 'warning_letter/early_disembark_warning_letter';
// $route['update-warningletter-crew'] = 'warning_letter/edit_warning_letter_crew';

// FLIGHT MONITORING
$route['flight-monitoring'] = 'flight_monitoring/index';
$route['flight-monitoring-table'] = 'flight_monitoring/flight_monitoring_table';
$route['save-flight-information'] = 'flight_monitoring/save_flight_information';
$route['get-all-flights'] = 'flight_monitoring/get_all_flights';
$route['remove-flight-information'] = 'flight_monitoring/remove_flight_information';

// CREW MONITORING
$route['medical'] = 'medical/index';
$route['medical/(:any)'] = 'medical/index/$1';
$route['get-medical-records-table'] = 'medical/get_medical_records_table';
$route['save-medical-record-form'] = 'medical/save_medical_record_form';
$route['remove-medical-record'] = 'medical/remove_medical_record';
$route['get-medical-record'] = 'medical/get_medical_details';
$route['edit-medical-record-form'] = 'medical/edit_medical_record_form';
$route['pre-joining-visa'] = 'pre_joining_visa/index';
$route['pre-joining-visa/(:any)'] = 'pre_joining_visa/index/$1';
$route['search-crew-id-contract'] = 'contracts/search_crew_by_id';
$route['create-poea-contract'] = 'contracts/create_poea_contract';
$route['create-mlc-contract'] = 'contracts/create_mlc_contract';
$route['get-crew-contract'] = 'contracts/get_crew_contract';
$route['get-crew-contract-table'] = 'contracts/contract_table';
$route['get-crew-mlc-table'] = 'contracts/mlc_table';
$route['save-crew-licenses'] = 'pre_joining_visa/save_crew_licenses';
$route['save-crew-trainings'] = 'pre_joining_visa/save_crew_trainings';

$route['pre-joining-search'] = 'pre_joining_visa/prejoining_crew_search';
$route['prejoining-search-reset'] = 'pre_joining_visa/prejoining_search_reset';
$route['medical-search'] = 'medical/medical_crew_search';
$route['medical-search-reset'] = 'medical/medical_search_reset';
$route['contract-crew-search'] = 'contracts/contract_crew_search';
$route['contract-search-reset'] = 'contracts/contract_search_reset';

$route['remove-poe-contract'] = 'contracts/remove_poea_contract';
$route['remove-mlc-contract'] = 'contracts/remove_mlc_contract';
$route['update-mlc'] = 'contracts/update_mlc_promotion';
$route['update-poea'] = 'contracts/update_poea_promotion';

$route['medical-approval-report'] = 'medical/medical_approval_report';
$route['set-medical-approval-report'] = 'medical/set_mar_filter';
$route['reset-medical-approval-report'] = 'medical/unset_mar_filter';
// PREJOINING MONITORING
$route['manage-prejoining'] = 'manage_prejoining/index';
$route['manage-prejoining/(:any)'] = 'manage_prejoining/index/$1';
$route['get-routing-slip'] = 'manage_prejoining/get_routing_slip';
$route['save-routing-slip'] = 'manage_prejoining/save_routing_slip';
$route['get-crew-disembark-routing'] = 'manage_prejoining/get_disembark_routing_slip';
$route['save-disembark-routing-slip'] = 'manage_prejoining/save_disembark_routing_slip';

// TOC
$route['withdrawal'] = 'transfer_company/index';
$route['save-crew-toc'] = 'transfer_company/crew_toc';

//CREW LINEUP
$route['generate-crew-lineup'] = 'crew_lineup/generate_crew_lineup';
$route['transfer-lineup-ga'] = 'crew_lineup/transfer_lineup_toga';
$route['crew-lineup-for-approval'] = 'crew_lineup/crew_lineup_for_approval';
$route['view-crewlineup-request'] = 'crew_lineup/view_crewlineup_approval';
$route['approve-crew-lineup'] = 'crew_lineup/approve_crew_lineup';
$route['reject-crew-lineup'] = 'crew_lineup/reject_crew_lineup';

//REPORTS
$route['print-registered-applicant-xl'] = 'reports/print_registered_applicant_xl';
$route['print-registered-applicant-csv'] = 'reports/print_registered_applicant_csv';
$route['print-registered-applicant-pdf'] = 'reports/print_registered_applicant_pdf';

$route['print-pending-applicant-xl'] = 'reports/print_pending_applicant_xl';
$route['print-pending-applicant-csv'] = 'reports/print_pending_applicant_csv';
$route['print-pending-applicant-pdf'] = 'reports/print_pending_applicant_pdf';

$route['print-interviewed-applicant-csv'] = 'reports/print_interview_applicant_csv';
$route['print-interviewed-applicant-xl'] = 'reports/print_interview_applicant_xl';
$route['print-interviewed-applicant-pdf'] = 'reports/print_interview_applicant_pdf';

$route['print-notqualified-applicant-csv'] = 'reports/print_notqualified_applicant_csv';
$route['print-notqualified-applicant-xl'] = 'reports/print_notqualified_applicant_xl';
$route['print-notqualified-applicant-pdf'] = 'reports/print_notqualified_applicant_pdf';

$route['print-approval-applicant-csv'] = 'reports/print_approval_applicant_csv';
$route['print-approval-applicant-xl'] = 'reports/print_approval_applicant_xl';
$route['print-approval-applicant-pdf'] = 'reports/print_approval_applicant_pdf';

$route['print-passed-applicant-csv'] = 'reports/print_passed_applicant_csv';
$route['print-passed-applicant-xl'] = 'reports/print_passed_applicant_xl';
$route['print-passed-applicant-pdf'] = 'reports/print_passed_applicant_pdf';

$route['print-reserved-applicant-csv'] = 'reports/print_reserved_applicant_csv';
$route['print-reserved-applicant-xl'] = 'reports/print_reserved_applicant_xl';
$route['print-reserved-applicant-pdf'] = 'reports/print_reserved_applicant_pdf';

$route['print-general-applicant/(:any)/(:any)'] = 'reports/print_general_applicant/$1/$2';
$route['print-technical-form/(:any)/(:any)'] = 'reports/print_technical_form/$1/$2';
$route['print-interview-sheet-pdf/(:any)'] = 'reports/print_interview_sheet/$1';
$route['print-evaluation-applicant-pdf/(:any)'] = 'reports/print_evaluation_applicant_pdf/$1';
$route['print-evaluation-applicant-xl/(:any)'] = 'reports/print_evaluation_applicant_xl/$1';
$route['print-employed-form/(:any)/(:any)'] = 'reports/print_employed_form/$1/$2';
$route['print-interview-form/(:any)/(:any)'] = 'reports/print_interview_form/$1/$2';

$route['print-contract-poea/(:any)'] = 'print_contract/Print_POEA/$1';
$route['print-contract-mlc-korean/(:any)'] = 'print_contract/Print_MLC_korean/$1';
$route['print-contract-mlc-panama/(:any)'] = 'print_contract/Print_MLC_panama/$1';
$route['print-contract-mlc-marshall/(:any)'] = 'print_contract/Print_MLC_marshall/$1';

$route['print-cmp-report/(:any)'] = 'Report_Manager/print_cmp_report/$1';
$route['print-us-visa-report'] = 'Report_Manager/print_us_visa_report';
$route['print-on-off-report'] = 'Report_Manager/print_on_off_signer_report';
$route['print-prejoining-monitoring'] = 'Report_Manager/print_prejoining_report';
$route['print-daily-departure-report/(:any)'] = 'Report_Manager/print_daily_departure/$1';
$route['print-panama-monitoring'] = 'Report_Manager/print_panama_monitoring_report';
$route['print-marshall-monitoring'] = 'Report_Manager/print_marshall_report';
$route['print-medical-monitoring'] = 'Report_Manager/print_medical_report';

$route['print-cmp/(:any)'] = 'Report_Manager/PrintCMPGeneral/$1';
$route['print-prejoining/(:any)'] = 'Report_Manager/PrejoiningReportGeneral/$1';
$route['print-prejoining-visa/(:any)'] = 'Report_Manager/PrejoiningVisaReport/$1';
$route['print-contract/(:any)'] = 'Report_Manager/ContractReportGeneral/$1';
$route['print-medical/(:any)'] = 'Report_Manager/printMedicalGeneral/$1';
$route['print-onboarding/(:any)'] = 'reports/print_onboarding_report/$1';
$route['print-embarked/(:any)'] = 'Report_Manager/EmbarkedCrew/$1/$2';
$route['print-disembarked/(:any)'] = 'Report_Manager/DisembarkedCrew/$1';
$route['print-for-reporting/(:any)'] = 'reports/print_for_reporting_report/$1';
$route['print-watchlisted/(:any)'] = 'reports/print_watchlisted_report/$1';
$route['print-warning-letter/(:any)'] = 'reports/print_warning_letter_crew/$1';
$route['print-withdrawal/(:any)'] = 'reports/print_withdraw_crew/$1';
$route['print-flight-monitoring/(:any)'] = 'reports/print_flightmonitoring_report/$1';

//PRINT SHIPBOARD
$route['print-shipboard-application/(:any)'] = 'print_shipboard/print_shipboard_application/$1';

//Crew Reports
$route['print-crew-xl/(:any)'] = 'reports/print_crew_xl/$1';
$route['print-crew-csv/(:any)'] = 'reports/print_crew_csv/$1';

$route['print-all-crew-pdf/(:any)'] = 'reports/print_all_crew_pdf/$1';
$route['print-new-crew-pdf'] = 'reports/print_new_crew_pdf';
$route['print-withdraw-crew-pdf'] = 'reports/print_withdraw_crew_pdf';

$route['print-xl-report/(:any)'] = 'reports/print_xl_report/$1';
$route['print-csv-report/(:any)'] = 'reports/print_csv_report/$1';
$route['print-pdf-report/(:any)'] = 'reports/print_pdf_report/$1';

$route['print-xl-report/(:any)/(:any)'] = 'reports/print_xl_report/$1/$2';
$route['print-csv-report/(:any)/(:any)'] = 'reports/print_csv_report/$1/$2';
$route['print-pdf-report/(:any)/(:any)'] = 'reports/print_pdf_report/$1/$2';

$route['print-promotion-report/(:any)'] = 'Report_Manager/print_crew_promotion_report/$1';
$route['template/(:any)'] = 'contracts/view_template/$1';

// General Reports
$route['cmp-summary'] = 'manage_reports/cmp_summary';
$route['crew-daily-departure'] = 'manage_reports/crew_daily_departure';
$route['us-visa-status'] = 'manage_reports/us_visa';
$route['prejoining-monitoring'] = 'manage_reports/prejoining_monitoring';
$route['list-signers'] = 'manage_reports/on_off_signers';
$route['panama-monitoring'] = 'manage_reports/panama_monitoring';
$route['marshall-monitoring'] = 'manage_reports/marshall_monitoring';
$route['medical-monitoring'] = 'manage_reports/medical_monitoring';

//VALIDATION
$route['shipboard-application-validation'] = 'validations/shipboard_application_validation';
$route['add-module-form-validation'] = 'validations/add_module_form_validation';
$route['edit-module-form-validation'] = 'validations/edit_module_form_validation';
$route['add-sub-module-form-validation'] = 'validations/add_sub_module_form_validation';
$route['edit-sub-module-form-validation'] = 'validations/edit_sub_module_form_validation';
$route['add-node-form-validation'] = 'validations/add_node_form_validation';
$route['edit-node-form-validation'] = 'validations/edit_node_form_validation';
$route['nat-score-validation'] = 'validations/add_nat_score_validation';
$route['add-training-certificate-validation'] = 'validations/add_training_certificate_validation';
$route['edit-training-certificate-validation'] = 'validations/edit_training_certificate_validation';
$route['add-license-validation'] = 'validations/add_licenses_validation';
$route['edit-license-validation'] = 'validations/edit_licenses_validation';
$route['add-position-validation'] = 'validations/add_position_validation';
$route['edit-position-validation'] = 'validations/edit_position_validation';
$route['add-interview-validation'] = 'validations/add_interview_validation';
$route['edit-interview-validation'] = 'validations/edit_interview_validation';
$route['add-vessel-validation'] = 'validations/add_vessel_validation';
$route['edit-vessel-validation'] = 'validations/edit_vessel_validation';
$route['add-vessel-type-validation'] = 'validations/add_vessel_type_validation';
$route['edit-vessel-type-validation'] = 'validations/edit_vessel_type_validation';
$route['add-engine-type-validation'] = 'validations/add_engine_type_validation';
$route['edit-engine-type-validation'] = 'validations/edit_engine_type_validation';
$route['add-existing-crew-validation'] = 'validations/existing_shipboard_application_validation';
$route['add-user-type-validation'] = 'validations/add_user_type_validation';
$route['update-user-password-validation'] = 'validations/update_user_password_validation';
$route['update-position-certificates-validation'] = 'validations/update_position_certificates_validation';
$route['update-position-points-validation'] = 'validations/update_position_points_validation';
$route['existing-validation'] = 'validations/update_position_points_validation';
$route['add-poea-contract-validation'] = 'validations/add_poea_contract_validation';
$route['add-mlc-contract-validation'] = 'validations/add_mlc_contract_validation';
$route['add-watchlisted-validation'] = 'validations/add_watchlisted_validation';
$route['add-warning-letter-validation'] = 'validations/add_warning_letter_validation';
$route['add-early-dis-warning-letter-validation'] = 'validations/add_early_disembark_warning_letter_validation';
$route['add-flight-information-validation'] = 'validations/add_flight_information_validation';
$route['add-medical-validation'] = 'validations/add_medical_validation';
$route['edit-medical-validation'] = 'validations/edit_medical_validation';
$route['e-shipboard-application'] = 'validations/edit_shipboard_validation';
$route['v-e-crew-info-validation'] = 'validations/v_e_crew_info_validation';
$route['add-toc-validation'] = 'validations/add_toc_validation';
$route['position-licenses-validation'] = 'validations/position_licenses_validation';
$route['assign-onsigner-validation'] = 'validations/assign_onsigner_validation';


// RECRUITMENTS PDF REPORS
$route['print-registered-applicants'] = "report_recruitment_module/print_registered_applicants";
$route['print-pending-applicants'] = "report_recruitment_module/print_pending_applicants";
$route['print-for-interview-applicants'] = "report_recruitment_module/print_for_interview_applicants";
$route['print-principal-approval-applicants'] = "report_recruitment_module/print_principal_approval_applicants";
$route['print-passed-applicants'] = "report_recruitment_module/print_passed_applicants";
$route['print-not-qualified-applicants'] = "report_recruitment_module/print_not_qualified_applicants";
$route['print-reserved-applicants'] = "report_recruitment_module/print_reserved_applicants";

// CREW MODULE PDF REPORTS
$route['print-cm-plan'] = 'report_crew_module/print_cm_plan';
$route['print-all-crews'] = 'report_crew_module/print_all_crews';
$route['print-new-crews'] = 'report_crew_module/print_new_crews';
$route['print-ex-crews'] = 'report_crew_module/print_ex_crews';
$route['print-nre-crews'] = 'report_crew_module/print_nre_crews';
$route['print-pre-joining-crews'] = 'report_crew_module/print_pre_joining_crews';
$route['print-prejoining-visa-crews'] = 'report_crew_module/print_prejoining_visa_crews';
$route['print-crew-monitoring-contracts'] = 'report_crew_module/print_crew_monitoring_contracts';
$route['print-medical-crews'] = 'report_crew_module/print_medical_crews';
$route['print-flight-monitoring'] = 'report_crew_module/print_flight_monitoring';
$route['print-for-onboarding'] = 'report_crew_module/print_for_onboarding';
$route['print-embarked-crews'] = 'report_crew_module/print_embarked_crews';
$route['print-disembarked-crews'] = 'report_crew_module/print_disembarked_crews';
