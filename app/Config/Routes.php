
<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Welcome;
use App\Controllers\Auth;
use App\Controllers\Admin\Academic\ConAdminAcademicRepeat;
use App\Controllers\Admin\Academic\ConAdminAcademinResult;
use App\Controllers\Admin\Academic\ConAdminClassRoom;
use App\Controllers\Admin\Academic\ConAdminClassSchedule;
use App\Controllers\Admin\Academic\ConAdminCourse;
use App\Controllers\Admin\Academic\ConAdminCheckPlan;
use App\Controllers\Admin\Academic\ConAdminDevelopStudents;
use App\Controllers\Admin\Academic\ConAdminEnroll;
use App\Controllers\Admin\Academic\ConAdminEvaluateEditGrade;
use App\Controllers\Admin\Academic\ConAdminExamSchedule;
use App\Controllers\Admin\Academic\ConAdminExtraSubject;
use App\Controllers\Admin\Academic\ConAdminHome;
use App\Controllers\Admin\Academic\ConAdminRegisRepeat;
use App\Controllers\Admin\Academic\ConAdminRegisterSubject;
use App\Controllers\Admin\Academic\ConAdminResearch;
use App\Controllers\Admin\Academic\ConAdminReportResult;
use App\Controllers\Admin\Academic\ConAdminRoomOnline;
use App\Controllers\Admin\Academic\ConAdminSaveScore;
use App\Controllers\Admin\Academic\ConAdminSettingAdminRoles;
use App\Controllers\Admin\Academic\ConAdminCharacteristics;
use App\Controllers\Admin\Academic\ConAdminRWL;
use App\Controllers\Admin\Academic\ConAdminBackup;
use App\Controllers\Admin\Academic\ConAdminStudents;
use App\Controllers\Admin\Affairs\ConAdminStudentHomeRoom;
use App\Controllers\Admin\Affairs\ConAdminStudentSupport;
use App\Controllers\Admin\General\ConAdminGeneralPersonnel;
use App\Controllers\Admin\General\ConAdminSettingAdminRoles as GeneralConAdminSettingAdminRoles; // Alias to avoid conflict
use App\Controllers\User\ConStudents;
use App\Controllers\User\ConUser_Home;
use App\Controllers\Session;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Welcome::class, 'index']);
$routes->get('welcome', [Welcome::class, 'index']);
$routes->get('debug-db', 'Admin\Academic\ConDebug::index');
$routes->group('diagnostic/register-class', function($routes) {
    $routes->get('', 'Admin\Academic\ConAdminRegisterClassFixer::index');
    $routes->get('audit-data', 'Admin\Academic\ConAdminRegisterClassFixer::getAuditData');
    $routes->post('process-fix', 'Admin\Academic\ConAdminRegisterClassFixer::processFix');
    $routes->get('missing-rooms', 'Admin\Academic\ConAdminRegisterClassFixer::scanMissingRooms'); // Keeping old for legacy
});

// CI3 Routes Migration
$routes->get('ClosePage', [Welcome::class, 'ClosePage']);

// Unify Login/Logout Routes - See Auth block below

// งานวิชาการ
$routes->get('Admin/Home', [ConAdminHome::class, 'AdminHome']);
$routes->match(['get', 'post'], 'Admin/SetSelectedYear', [ConAdminHome::class, 'setSelectedYear']);
$routes->get('Admin/GetSelectedYear', [ConAdminHome::class, 'getSelectedYear']);

// Enrollment Dashboard Stats API
$routes->post('Admin/Academic/ConAdminEnroll/getDashboardStats', [\App\Controllers\Admin\Academic\ConAdminEnroll::class, 'getDashboardStats']);

// Repeat Registration Dashboard Stats API
$routes->post('Admin/Academic/ConAdminRegisRepeat/getDashboardStats', [\App\Controllers\Admin\Academic\ConAdminRegisRepeat::class, 'getDashboardStats']);

// Routes for ConAdminDevelopStudents (Clubs Management)
$routes->get('Admin/Acade/DevelopStudents/Clubs/Main', [ConAdminDevelopStudents::class, 'ClubsMain']);
$routes->post('admin/academic/developstudents/update_onoff_status', [ConAdminDevelopStudents::class, 'updateClubOnoffStatus']);
$routes->post('admin/academic/developstudents/update_onoff_dates', [ConAdminDevelopStudents::class, 'updateClubOnoffDates']);
$routes->post('admin/academic/developstudents/update_schedule', [ConAdminDevelopStudents::class, 'ClubUpdateSchedule']);
$routes->get('Admin/Acade/DevelopStudents/Clubs/All', [ConAdminDevelopStudents::class, 'ClubsAll']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubsShow', [ConAdminDevelopStudents::class, 'ClubsShow']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubsInsert', [ConAdminDevelopStudents::class, 'ClubsInsert']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubsUpdate', [ConAdminDevelopStudents::class, 'ClubsUpdate']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubsEdit/(:num)', [ConAdminDevelopStudents::class, 'ClubsEdit/$1']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubsDelete/(:num)', [ConAdminDevelopStudents::class, 'ClubsDelete/$1']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubsStudentList', [ConAdminDevelopStudents::class, 'ClubsStudentList']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubsTeacherList', [ConAdminDevelopStudents::class, 'ClubsTeacherList']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminDevelopStudents/ClubsAddStudentToClub', [ConAdminDevelopStudents::class, 'ClubsAddStudentToClub']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubsTbShowStudentList', [ConAdminDevelopStudents::class, 'ClubsTbShowStudentList']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubDeleteStudentToClub', [ConAdminDevelopStudents::class, 'ClubDeleteStudentToClub']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetClassroom', [ConAdminDevelopStudents::class, 'ClubGetClassroom']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetStudentRegisterClub', [ConAdminDevelopStudents::class, 'ClubGetStudentRegisterClub']);
$routes->get('admin/academic/develop-students/student-registrations', [ConAdminDevelopStudents::class, 'ClubsStudentRegistrationPage']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubSetOnoffYear', [ConAdminDevelopStudents::class, 'ClubSetOnoffYear']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetDateRegister', [ConAdminDevelopStudents::class, 'ClubGetDateRegister']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubSetDateRegister', [ConAdminDevelopStudents::class, 'ClubSetDateRegister']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks', [ConAdminDevelopStudents::class, 'ClubCreateWeeks']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate', [ConAdminDevelopStudents::class, 'ClubGetWeeksToUpdate']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubUpdateSchedule', [ConAdminDevelopStudents::class, 'ClubUpdateSchedule']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus', [ConAdminDevelopStudents::class, 'ClubUpdateStatus']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetAcademicYears', [ConAdminDevelopStudents::class, 'ClubGetAcademicYears']);
$routes->get('Admin/Acade/DevelopStudents/Clubs/Report', [ConAdminDevelopStudents::class, 'ClubsReport']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminDevelopStudents/ClubReportData', [ConAdminDevelopStudents::class, 'ClubReportData']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminDevelopStudents/ClubAttendanceReportData', [ConAdminDevelopStudents::class, 'ClubAttendanceReportData']);

$routes->get('Admin/Acade/Registration/Enroll', [ConAdminEnroll::class, 'AdminEnrollMain']);
$routes->get('Admin/Acade/Registration/Enroll/Add', [ConAdminEnroll::class, 'AdminEnrollAdd']);
$routes->get('Admin/Acade/Registration/Enroll/Add/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollAdd/$1/$2']);
$routes->get('Admin/Acade/Registration/Enroll/Edit/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollEdit']);
$routes->get('Admin/Acade/Registration/Enroll/Delete/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollDelete']);
$routes->get('Admin/Acade/Registration/Repeat', [ConAdminRegisRepeat::class, 'AdminRegisRepeatMain']);
$routes->get('Admin/Acade/Registration/Repeat/Detail/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminRegisRepeat::class, 'AdminRegisRepeatDetail']);
$routes->get('Admin/Acade/Registration/Repeat/Add', [ConAdminRegisRepeat::class, 'AdminRegisRepeatAdd']);
$routes->get('Admin/Acade/Registration/ExamSchedule', [ConAdminExamSchedule::class, 'AdminExamScheduleMain']);
$routes->get('Admin/Acade/Registration/ExamSchedule/add', [ConAdminExamSchedule::class, 'add']);
$routes->post('admin/academic/ConAdminExamSchedule/insert_exam_schedule', [ConAdminExamSchedule::class, 'insert_exam_schedule']);
$routes->post('admin/academic/ConAdminClassSchedule/insert_class_schedule', [ConAdminClassSchedule::class, 'insert_class_schedule']);
$routes->post('admin/academic/ConAdminClassSchedule/delete_class_schedule/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminClassSchedule::class, 'delete_class_schedule/$1/$2/$3/$4']);
$routes->post('admin/academic/ConAdminExamSchedule/upload_proxy', [ConAdminExamSchedule::class, 'upload_proxy']);
$routes->post('admin/academic/ConAdminExamSchedule/delete_proxy', [ConAdminExamSchedule::class, 'delete_proxy']);
$routes->post('Admin/Acade/ConAdminExamSchedule/delete_exam_schedule/(:segment)', [ConAdminExamSchedule::class, 'delete_exam_schedule/$1']);
$routes->post('admin/academic/ConAdminExamSchedule/update_status', [ConAdminExamSchedule::class, 'update_status']);
$routes->get('Admin/Acade/Registration/ClassRoom', [ConAdminClassRoom::class, 'AdminClassMain']);
$routes->get('Admin/Acade/Registration/ClassRoom/(:num)', [ConAdminClassRoom::class, 'AdminClassMain/$1']);
$routes->get('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/DeleteClassRoom/(:segment)', [ConAdminClassRoom::class, 'DeleteClassRoom']);
$routes->get('Admin/Acade/Registration/Students', [ConAdminStudents::class, 'AdminStudentsMain']);
$routes->get('Admin/Acade/Registration/Students/Data', [ConAdminStudents::class, 'AdminStudentsData']);
$routes->get('Admin/Acade/Registration/Students/Lifecycle', [ConAdminStudents::class, 'AdminStudentsLifecycle']);
$routes->get('Admin/Acade/Registration/Students/Add', [ConAdminStudents::class, 'AdminStudentsAdd']);
$routes->post('Admin/Acade/Registration/Students/CheckDuplicate', [ConAdminStudents::class, 'checkDuplicate']);
$routes->post('Admin/Acade/Registration/Students/Insert', [ConAdminStudents::class, 'processStudentAdd']);
$routes->post('Admin/Acade/Registration/Students/ImportGoogle', [ConAdminStudents::class, 'processGoogleSheetImport']);
    $routes->get('Admin/Acade/Registration/Students/ChangeYear/(:segment)', [ConAdminStudents::class, 'changeYear']);
    $routes->get('Admin/Acade/Registration/Students/DataFilters', [ConAdminStudents::class, 'getStudentsByFilters']);
$routes->post('Admin/Acade/Registration/Students/StatusUpdateBulk', [ConAdminStudents::class, 'processStatusUpdateBulk']);
$routes->post('Admin/Acade/Registration/Students/PromotionBulk', [ConAdminStudents::class, 'processPromotionBulk']);
$routes->get('Admin/Acade/Registration/Students/AdjustNumber', [ConAdminStudents::class, 'AdminStudentsAdjustNumber']);
$routes->get('Admin/Acade/Registration/Students/Edit', [ConAdminStudents::class, 'AdminStudentsEditSearch']);
$routes->get('Admin/Acade/Registration/Students/Edit/(:segment)', [ConAdminStudents::class, 'AdminStudentsEdit/$1']);
$routes->post('Admin/Acade/Registration/Students/AdjustNumberData', [ConAdminStudents::class, 'getStudentsByClassForNumbering']);
$routes->post('Admin/Acade/Registration/Students/AdjustNumberUpdate', [ConAdminStudents::class, 'updateStudentNumbers']);
$routes->post('Admin/Acade/Registration/Students/AdjustNumberGlobalSearch', [ConAdminStudents::class, 'getGlobalSearchStudents']);

$routes->get('Admin/Acade/Registration/Students/(:segment)', [ConAdminStudents::class, 'AdminStudentsNormal']);
$routes->match(['get', 'post'],'Admin/Acade/Registration/StudentsUpdate', [ConAdminStudents::class, 'AdminStudentsUpdate']);
$routes->match(['get', 'post'],'Admin/Acade/Registration/StudentsUpdate/(:segment)', [ConAdminStudents::class, 'AdminStudentsUpdate/$1']);

$routes->get('Admin/Academic/ConAdminStudents/get_student_details/(:num)', [ConAdminStudents::class, 'get_student_details/$1']);
$routes->post('Admin/Academic/ConAdminStudents/update_student_details', [ConAdminStudents::class, 'update_student_details']);
$routes->post('Admin/Academic/ConAdminStudents/AdminStudentsDelete/(:num)', [ConAdminStudents::class, 'AdminStudentsDelete/$1']);

$routes->get('Admin/Acade/Registration/ExtraSubject', [ConAdminExtraSubject::class, 'index']);
$routes->get('Admin/Acade/Registration/SettingSystem', [ConAdminExtraSubject::class, 'SystemMainExtraSubject']);
$routes->get('Admin/Acade/Registration/RoomOnline', [ConAdminRoomOnline::class, 'RoomOnlineMain']);
$routes->post('admin/room-online/data', [ConAdminRoomOnline::class, 'getRoomOnlineData']);

$routes->get('Admin/Acade/Course/ClassSchedule', [ConAdminClassSchedule::class, 'AdminClassScheduleMain']);
$routes->post('admin/academic/ConAdminClassSchedule/getDataByYear', [ConAdminClassSchedule::class, 'getDataByYear']);
$routes->get('Admin/Acade/Course/ClassSchedule/add', [ConAdminClassSchedule::class, 'add']);
$routes->get('Admin/Acade/Course/ClassSchedule/edit/(:segment)', [ConAdminClassSchedule::class, 'edit/$1']);
$routes->post('admin/academic/ConAdminClassSchedule/insert_class_schedule', [ConAdminClassSchedule::class, 'insert_class_schedule']);
$routes->post('admin/academic/ConAdminClassSchedule/delete_class_schedule/(:any)/(:any)/(:any)/(:any)', [ConAdminClassSchedule::class, 'delete_class_schedule/$1/$2/$3/$4']);
$routes->post('admin/academic/ConAdminClassSchedule/upload_proxy', [ConAdminClassSchedule::class, 'upload_proxy']);
$routes->get('Admin/Acade/Course/RegisterSubject', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectMain']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectSelect']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectEdit']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectUpdate']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectInsert', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectInsert']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectBulkInsert', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectBulkInsert']);
$routes->delete('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectDelete/(:num)', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectDelete/$1']);
$routes->get('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectEdit']);
$routes->get('Admin/Acade/Course/SendPlan', [ConAdminCourse::class, 'SendPlanMain']);
$routes->get('Admin/Acade/Course/(:segment)/(:segment)', [ConAdminCourse::class, 'UpdateSendPlanYear/$1/$2']);
$routes->match(['get', 'post'], 'admin/academic/course/get_filtered_plan_data', [ConAdminCourse::class, 'getFilteredPlanData']);
$routes->get('admin/academic/course/get_plan_details', [ConAdminCourse::class, 'getPlanDetails']);
$routes->post('admin/academic/course/update_teacher', [ConAdminCourse::class, 'UpdateSettingSendPlanTeacher']);
$routes->post('admin/academic/course/add_teacher_subject', [ConAdminCourse::class, 'UpdateSendPlanTeacher']);
$routes->post('admin/academic/course/delete_teacher_subject', [ConAdminCourse::class, 'delete_teacher_subject']);
$routes->post('admin/academic/course/update_setting', [ConAdminCourse::class, 'UpdateSettingSendPlan']);
$routes->get('admin/academic/course/getPlansTableData', [ConAdminCourse::class, 'getPlansTableData']);
$routes->get('admin/academic/course/getSubjectsByYear', [ConAdminCourse::class, 'getSubjectsByYear']);
$routes->post('Admin/Settings/UpdateSchoolYear', [ConAdminCourse::class, 'updateSchoolYear']);

// Research Submission Settings Routes
$routes->get('Admin/Acade/Research/Setup', [ConAdminResearch::class, 'index']);
$routes->match(['get', 'post'], 'Admin/Acade/Research/Report', [ConAdminResearch::class, 'research_report']);
$routes->match(['get', 'post'], 'admin/academic/research/update_setting', [ConAdminResearch::class, 'update_setting']);

$routes->get('admin/academic/checkplan', [ConAdminCheckPlan::class, 'index']);
$routes->post('admin/academic/checkplan/update', [ConAdminCheckPlan::class, 'updatePlanStatus']);
$routes->post('admin/academic/checkplan/updateplanstatus', [ConAdminCheckPlan::class, 'updatePlanStatus']);
$routes->get('admin/academic/checkplan/plans/(:segment)', [ConAdminCheckPlan::class, 'plansByGroup/$1']);
$routes->get('admin/academic/checkplan/teacherplans/(:segment)', [ConAdminCheckPlan::class, 'getTeacherPlans/$1']);
$routes->get('admin/academic/checkplan/plandetails/(:segment)', [ConAdminCheckPlan::class, 'getPlanDetails/$1']);
$routes->get('admin/academic/api', [\App\Controllers\Admin\Academic\ConAdminApi::class, 'index']);
$routes->get('admin/academic/report/checkplan', [ConAdminCheckPlan::class, 'report']);

// Timetable Management System
$routes->get('db-check', 'DbCheck::index');

$routes->group('admin/academic/timetable', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('', 'Admin\Academic\ConAdminTimetable::index');
    $routes->get('create', 'Admin\Academic\ConAdminTimetable::create');
    $routes->get('full', 'Admin\Academic\ConAdminTimetable::full');
    $routes->get('get-progress', 'Admin\Academic\ConAdminTimetable::getProgress');
    $routes->post('change-year', 'Admin\Academic\ConAdminTimetable::changeYear');
    $routes->get('audit', 'Admin\Academic\ConAdminTimetable::auditTimetable');
    $routes->get('class-timetables', 'Admin\Academic\ConAdminTimetable::classTimetables');
    $routes->get('teacher-timetables', 'Admin\Academic\ConAdminTimetable::teacherTimetables');
    $routes->get('view-class', 'Admin\Academic\ConAdminTimetable::viewClass');
    $routes->get('view-teacher', 'Admin\Academic\ConAdminTimetable::viewTeacher');
    $routes->get('edit/(:num)', 'Admin\Academic\ConAdminTimetable::edit/$1');
    $routes->post('save-assignment', 'Admin\Academic\ConAdminTimetable::saveAssignment');
    $routes->post('update-assignment/(:num)', 'Admin\Academic\ConAdminTimetable::updateAssignment/$1');
    $routes->post('quick-add-subject', 'Admin\Academic\ConAdminTimetable::quickAddSubject');
    $routes->post('delete-assignment', 'Admin\Academic\ConAdminTimetable::deleteAssignment');
    $routes->match(['get', 'post'], 'save-teaching-group', 'Admin\Academic\ConAdminTimetable::saveTeachingGroup');
    $routes->match(['get', 'post'], 'delete-teaching-group', 'Admin\Academic\ConAdminTimetable::deleteTeachingGroup');
    $routes->get('subject-groups', 'Admin\Academic\ConAdminTimetable::subjectGroups');
    $routes->post('save-joint-group', 'Admin\Academic\ConAdminTimetable::saveSubjectGroup');
    $routes->post('delete-joint-group/(:num)', 'Admin\Academic\ConAdminTimetable::deleteSubjectGroup/$1');
    $routes->get('get-suggested-teachers', 'Admin\Academic\ConAdminTimetable::getSuggestedTeachers');

    // Subjects for Timetable
    $routes->get('subjects', 'Admin\Academic\ConAdminTimetable::subjects');
    $routes->post('save-subject', 'Admin\Academic\ConAdminTimetable::saveTimetableSubject');
    $routes->post('import-subjects', 'Admin\Academic\ConAdminTimetable::importSubjects');
    $routes->post('delete-subject', 'Admin\Academic\ConAdminTimetable::deleteTimetableSubject');

    // Timetable Processing
    $routes->get('process', 'Admin\Academic\ConAdminTimetable::process');
    $routes->match(['get', 'post'], 'auto-generate', 'Admin\Academic\ConAdminTimetable::autoGenerate');
    $routes->get('get-class-timetable', 'Admin\Academic\ConAdminTimetable::getClassTimetable');
    $routes->get('view-class-timetable', 'Admin\Academic\ConAdminTimetable::viewClassTimetable');
    $routes->get('get-constraint-grid', 'Admin\Academic\ConAdminTimetable::getConstraintGrid');
    $routes->get('get-master-lock-grid', 'Admin\Academic\ConAdminTimetable::getMasterLockGrid');
    $routes->post('save-subject-lock', 'Admin\Academic\ConAdminTimetable::saveSubjectLock');
    $routes->get('editor', 'Admin\Academic\ConAdminTimetable::editor');
    $routes->post('save-slot', 'Admin\Academic\ConAdminTimetable::saveSlot');
    $routes->post('delete-slot', 'Admin\Academic\ConAdminTimetable::deleteSlot');
    $routes->match(['get', 'post'], 'move-slot', 'Admin\Academic\ConAdminTimetable::moveSlot');
    $routes->post('clear-class-timetable', 'Admin\Academic\ConAdminTimetable::clearClassTimetable');
    $routes->post('reset-all-data', 'Admin\Academic\ConAdminTimetable::resetAllData');

    // Timetable Settings
    $routes->get('settings', 'Admin\Academic\ConAdminTimetable::settings');
    $routes->post('update-day', 'Admin\Academic\ConAdminTimetable::updateDay');
    $routes->post('save-period', 'Admin\Academic\ConAdminTimetable::savePeriod');
    $routes->post('delete-period', 'Admin\Academic\ConAdminTimetable::deletePeriod');
    $routes->post('toggle-lock', 'Admin\Academic\ConAdminTimetable::toggleLock');
    $routes->get('master-settings', 'Admin\Academic\ConAdminTimetable::masterSettings');
    $routes->post('save-master-slot', 'Admin\Academic\ConAdminTimetable::saveMasterSlot');
    $routes->post('reset-all-data', 'Admin\Academic\ConAdminTimetable::resetAllData');

    // Teacher Constraints
    $routes->get('teacher-constraints', 'Admin\Academic\ConAdminTimetable::teacherConstraints');
    $routes->get('get-master-teacher-lock-grid', 'Admin\Academic\ConAdminTimetable::getMasterTeacherLockGrid');
    $routes->get('get-teacher-constraint-grid', 'Admin\Academic\ConAdminTimetable::getTeacherConstraintGrid');
    $routes->get('get-teacher-constraint-summary', 'Admin\Academic\ConAdminTimetable::getTeacherConstraintSummary');
    $routes->post('save-teacher-constraint', 'Admin\Academic\ConAdminTimetable::saveTeacherConstraint');

    // Subject Constraints
    $routes->get('subject-constraints', 'Admin\Academic\ConAdminTimetable::subjectConstraints');
    $routes->post('save-subject-lock', 'Admin\Academic\ConAdminTimetable::saveSubjectLock');

});

$routes->get('Admin/Acade/Report', [ConAdminExtraSubject::class, 'ExtraReport']);

$routes->get('Admin/Acade/Setting/AdminRoles', [ConAdminSettingAdminRoles::class, 'AcademicSettingAdminRoles']);
$routes->group('ConAdminSettingAdminRoles', function ($routes) {
    $routes->post('AcademicSettingManager', [ConAdminSettingAdminRoles::class, 'AcademicSettingManager']);
    $routes->post('AcademicSettingDeputy', [ConAdminSettingAdminRoles::class, 'AcademicSettingDeputy']);
    $routes->post('AcademicSettingLeader', [ConAdminSettingAdminRoles::class, 'AcademicSettingLeader']);
    $routes->post('SelectWork', [ConAdminSettingAdminRoles::class, 'SelectWork']);
    $routes->post('addAcademicStaff', [ConAdminSettingAdminRoles::class, 'addAcademicStaff']);
    $routes->post('deleteAcademicStaff', [ConAdminSettingAdminRoles::class, 'deleteAcademicStaff']);
    $routes->post('updateStaffDetails', [ConAdminSettingAdminRoles::class, 'updateStaffDetails']);
});

// Database Backup (Superadmin Only)
$routes->get('admin/academic/backup', [ConAdminBackup::class, 'index']);
$routes->post('admin/academic/backup/run', [ConAdminBackup::class, 'runBackup']);

// Routes for Desirable Characteristics Settings
$routes->get('admin/academic/characteristics/settings', [ConAdminCharacteristics::class, 'index']);
$routes->post('admin/academic/characteristics/update', [ConAdminCharacteristics::class, 'update']);

// Routes for Reading, Writing, Learning (RWL) Settings
$routes->get('admin/academic/rwl/settings', [ConAdminRWL::class, 'index']);
$routes->post('admin/academic/rwl/update', [ConAdminRWL::class, 'update']);

$routes->get('Admin/Acade/Evaluate/AcademicRepeat', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatMain']);
$routes->get('Admin/Acade/Evaluate/AcademicRepeat/(:segment)/(:segment)/(:segment)', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatGrade']);
$routes->get('Admin/Acade/Evaluate/AcademicResult', [ConAdminAcademinResult::class, 'AdminAcademinResultMain']);
    $routes->post('admin/academic/ConAdminAcademinResult/OnOffLevel', [ConAdminAcademinResult::class, 'OnOffLevel']);
    $routes->post('admin/academic/ConAdminAcademinResult/CheckOnOffDoGrade', [ConAdminAcademinResult::class, 'CheckOnOffDoGrade']);
    $routes->post('admin/academic/ConAdminAcademinResult/CheckOnOffOpenYear', [ConAdminAcademinResult::class, 'CheckOnOffOpenYear']);
$routes->get('Admin/Acade/Evaluate/EditGrade', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeMain']);
$routes->get('Admin/Acade/Evaluate/EditGrade/(:segment)/(:segment)/(:segment)', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeUpdate']);
$routes->get('Admin/Acade/Evaluate/SaveScore', [ConAdminSaveScore::class, 'AdminSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/SaveScoreGrade/(:segment)/(:segment)/(:segment)', [ConAdminSaveScore::class, 'AdminSaveScoreGrade']);
$routes->post('admin/academic/ConAdminSaveScore/CheckOnOffSaveScore', [ConAdminSaveScore::class, 'CheckOnOffSaveScore']);
$routes->get('Admin/Acade/Evaluate/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Evaluate/ReportPerson/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportPersonMain/$1/$2']);
$routes->post('Admin/Acade/Evaluate/ReportPerson/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportPersonMain/$1/$2']);
$routes->get('Admin/Acade/Evaluate/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Evaluate/PrintTranscript/(:segment)', [ConAdminReportResult::class, 'PrintTranscript/$1']);
$routes->get('Admin/Acade/Evaluate/PrintTranscript/(:segment)/(:segment)', [ConAdminReportResult::class, 'PrintTranscript/$1/$2']);
$routes->get('Admin/Acade/Evaluate/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->post('Admin/Acade/Evaluate/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->post('Admin/Acade/Evaluate/exportRoomReportToExcel', [ConAdminReportResult::class, 'exportRoomReportToExcel']);

// Custom AJAX POST routes for ConAdminAcademicRepeat (for AdminEvaluateLearnRepeatGrade.php)
$routes->post('Admin/Acade/Evaluate/ConAdminAcademicRepeat/update_study_time', [ConAdminAcademicRepeat::class, 'update_study_time']);
$routes->post('Admin/Acade/Evaluate/ConAdminAcademicRepeat/update_score', [ConAdminAcademicRepeat::class, 'update_score']);
$routes->post('Admin/Acade/Evaluate/update_repeat_settings', [ConAdminAcademicRepeat::class, 'update_repeat_settings']);



$routes->post('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd', [ConAdminRegisRepeat::class, 'AdminRegisRepeatAdd']);
$routes->post('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetails', [ConAdminRegisRepeat::class, 'getRepeatStudentDetails']);
$routes->post('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentDetailsBySubject', [ConAdminRegisRepeat::class, 'getRepeatStudentDetailsBySubject']); // New Route
$routes->post('Admin/Academic/ConAdminRegisRepeat/updateRepeatGlobalSettings', [ConAdminRegisRepeat::class, 'updateRepeatGlobalSettings']);
$routes->post('Admin/Academic/ConAdminRegisRepeat/getRepeatStudentsBySubjectGroup', [ConAdminRegisRepeat::class, 'getRepeatStudentsBySubjectGroup']);
$routes->post('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatCancel', [ConAdminRegisRepeat::class, 'AdminRegisRepeatCancel']);

$routes->match(['get', 'post'], 'admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow', [ConAdminRegisRepeat::class, 'AdminRegisRepeatShow']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowMainSubjects', [ConAdminRegisRepeat::class, 'AdminRegisRepeatShowMainSubjects']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShowPending', [ConAdminRegisRepeat::class, 'AdminRegisRepeatShowPending']);
$routes->get('Admin/Acade/Registration/Repeat/Report', [ConAdminRegisRepeat::class, 'AdminRegisRepeatReport']);
$routes->post('Admin/Academic/ConAdminRegisRepeat/getRepeatReportData', [ConAdminRegisRepeat::class, 'getRepeatReportData']);

$routes->match(['get', 'post'], 'Admin/Academic/ConAdminStudents/AdminStudentsNormalShow/(:segment)', [ConAdminStudents::class, 'AdminStudentsNormalShow/$1']);

$routes->match(['get', 'post'], 'Admin/Academic/ConAdminEnroll/AdminEnrollSelect', [ConAdminEnroll::class, 'AdminEnrollSelect']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollUpdate', [ConAdminEnroll::class, 'AdminEnrollUpdate']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollShow', [ConAdminEnroll::class, 'AdminEnrollShow']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollCancel', [ConAdminEnroll::class, 'AdminEnrollCancel']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollChangeSubjectToTeacher', [ConAdminEnroll::class, 'AdminEnrollChangeSubjectToTeacher']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/checkRepeatHistory', [ConAdminEnroll::class, 'checkRepeatHistory']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollInsert', [ConAdminEnroll::class, 'AdminEnrollInsert']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollDel', [ConAdminEnroll::class, 'AdminEnrollDel']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollChangeTeacherByRoom', [ConAdminEnroll::class, 'AdminEnrollChangeTeacherByRoom']);
$routes->match(['get', 'post'], 'admin/academic/ConAdminEnroll/AdminEnrollChangeTeacher', [ConAdminEnroll::class, 'AdminEnrollChangeTeacher']);

// Route สำหรับ AdminEnrollSubject
$routes->get('Admin/Academic/ConAdminEnroll/AdminEnrollSubject', [ConAdminEnroll::class, 'AdminEnrollSubject']);
$routes->post('Admin/Academic/ConAdminEnroll/AdminEnrollSubject', [ConAdminEnroll::class, 'AdminEnrollSubject']);


$routes->match(['get', 'post'], 'admin/academic/ConAdminStudents/getDashboardData', [ConAdminStudents::class, 'getDashboardData']);

$routes->get('Admin/Acade/DevelopStudents/Clubs/Main', [ConAdminDevelopStudents::class, 'ClubsMain']);
$routes->get('Admin/Acade/DevelopStudents/Clubs/All', [ConAdminDevelopStudents::class, 'ClubsAll']);

// ผู้บริหารสถานศึกษา
$routes->get('Admin/Acade/Executive/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Executive/ReportPerson/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportPersonMain/$1/$2']);
$routes->post('Admin/Acade/Executive/ReportPerson/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportPersonMain/$1/$2']);
$routes->get('Admin/Acade/Executive/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Executive/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->get('Admin/Acade/Executive/ReportSummaryTeacher', [ConAdminReportResult::class, 'AdminReportSummaryTeacher']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScore', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScore/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain/$1']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain/$1/$2']);

$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScore', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScore/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain/$1']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain/$1/$2']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Executive/ReportScoreRoomMain', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Executive/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Evaluate/ReportScoreRoomMain', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Evaluate/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Evaluate/ExportScoreRoomToExcel/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'exportScoreRoomToExcel']);
$routes->get('Admin/Acade/Executive/ExportScoreRoomToExcel/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'exportScoreRoomToExcel']);
$routes->get('Admin/Acade/Executive/ReportEnroll/Main', [ConAdminReportResult::class, 'AdminReportEnrollMain']);
$routes->post('Admin/Acade/Executive/ReportEnroll/Data', [ConAdminReportResult::class, 'AdminReportEnrollData']);
$routes->get('Admin/Acade/Executive/ReportEnroll/ID/(:segment)', [ConAdminReportResult::class, 'AdminReportEnrollDetailStudent']);
$routes->post('Admin/Acade/Executive/exportRoomReportToExcel', [ConAdminReportResult::class, 'exportRoomReportToExcel']);
$routes->get('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard', [ConAdminReportResult::class, 'AdminReportAcademicSummaryRoyalRoseStandard']);
$routes->post('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard', [ConAdminReportResult::class, 'AdminReportRoyalRoseResult']);
$routes->post('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard/Export', [ConAdminReportResult::class, 'exportRoyalRoseToExcel']);
$routes->get('Admin/Acade/Evaluate/ReportAcademicSummary', [ConAdminReportResult::class, 'AdminReportAcademicSummary']);

// Session check for auto-logout
$routes->get('session/check', [Session::class, 'check']);

// Auth Routes (Login / Logout / Google)
$routes->group('Auth', function ($routes) {
    $routes->get('login', [Auth::class, 'login']);
    $routes->post('doLogin', [Auth::class, 'doLogin']);
    $routes->match(['get', 'post'], 'googleLogin', [Auth::class, 'googleLogin']);
    $routes->get('logout', [Auth::class, 'logout']);
});

// Redirect the old routes to the new Auth controller
$routes->addRedirect('LoginAdmin', 'Auth/login');
$routes->addRedirect('Logout', 'Auth/logout');
$routes->addRedirect('LoginMenager', 'Auth/login');
$routes->addRedirect('LogoutTeacher', 'Auth/logout');
$routes->addRedirect('LoginTeacher', 'Auth/login');
$routes->addRedirect('LoginMenager_callback', 'Auth/googleLogin');

// User
$routes->get('ExamSchedule', [ConStudents::class, 'ExamSchedule']);
$routes->get('ExamScheduleOnline', [ConStudents::class, 'ExamScheduleOnline']);
$routes->get('Students', [ConStudents::class, 'index']); // Assuming index method for base URL
$routes->get('StudentsList', [ConStudents::class, 'StudentsList']);
$routes->get('StudentsList/Print/(:segment)/(:segment)/(:segment)', [ConStudents::class, 'StudentsPrintRoom']);
$routes->get('ClassSchedule', [ConStudents::class, 'ClassSchedule']);
$routes->get('ClassSchedule/Search', [ConStudents::class, 'SearchClassSchedule']);
$routes->get('LearningOnline', [ConStudents::class, 'LearningOnline']);
$routes->get('LearningOnline/(:segment)', [ConStudents::class, 'LearningOnlineDetail']);
$routes->get('ReportLearnOnline', [ConStudents::class, 'PageReportLearnOnline']);
$routes->get('user/searchclassschedule', [ConStudents::class, 'SearchClassSchedule']);
$routes->get('user/getscheduleyears', [ConStudents::class, 'getScheduleYears']);

/**
 * API V1 Routes
 */
$routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1'], function($routes) {
    $routes->get('students/stats', 'StudentApi::stats');
    $routes->get('students/graduation-stats', 'StudentApi::graduationStats');
    $routes->resource('personnel', ['controller' => 'PersonnelApi', 'only' => ['index', 'show']]);
    $routes->resource('students', ['controller' => 'StudentApi', 'only' => ['index', 'show']]);
    $routes->resource('subjects', ['controller' => 'SubjectApi', 'only' => ['index', 'show']]);
});

