
<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Welcome;
use App\Controllers\Control_login;
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
use App\Controllers\Admin\Academic\ConAdminReportResult;
use App\Controllers\Admin\Academic\ConAdminRoomOnline;
use App\Controllers\Admin\Academic\ConAdminSaveScore;
use App\Controllers\Admin\Academic\ConAdminSettingAdminRoles;
use App\Controllers\Admin\Academic\ConAdminStudents;
use App\Controllers\Admin\Affairs\ConAdminStudentHomeRoom;
use App\Controllers\Admin\Affairs\ConAdminStudentSupport;
use App\Controllers\Admin\General\ConAdminGeneralPersonnel;
use App\Controllers\Admin\General\ConAdminSettingAdminRoles as GeneralConAdminSettingAdminRoles; // Alias to avoid conflict
use App\Controllers\Student\ConStudentExtraSubject;
use App\Controllers\Student\ConStudentHome;
use App\Controllers\User\ConStudents;
use App\Controllers\User\ConUser_Home;
use App\Controllers\Session;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Welcome::class, 'index']);

// CI3 Routes Migration
$routes->get('ClosePage', [Welcome::class, 'ClosePage']);
$routes->get('LoginAdmin', [Control_login::class, 'LoginAdmin']);

// งานวิชาการ
$routes->get('Admin/Home', [ConAdminHome::class, 'AdminHome']);

// Routes for ConAdminDevelopStudents (Clubs Management)
$routes->get('Admin/Acade/DevelopStudents/Clubs/Main', [ConAdminDevelopStudents::class, 'ClubsMain']);
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
$routes->post('admin/academic/ConAdminDevelopStudents/ClubSetOnoffYear', [ConAdminDevelopStudents::class, 'ClubSetOnoffYear']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetDateRegister', [ConAdminDevelopStudents::class, 'ClubGetDateRegister']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubSetDateRegister', [ConAdminDevelopStudents::class, 'ClubSetDateRegister']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubSetDateRegister', [ConAdminDevelopStudents::class, 'ClubSetDateRegister']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubCreateWeeks', [ConAdminDevelopStudents::class, 'ClubCreateWeeks']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetWeeksToUpdate', [ConAdminDevelopStudents::class, 'ClubGetWeeksToUpdate']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubUpdateSchedule', [ConAdminDevelopStudents::class, 'ClubUpdateSchedule']);
$routes->post('admin/academic/ConAdminDevelopStudents/ClubUpdateStatus', [ConAdminDevelopStudents::class, 'ClubUpdateStatus']);
$routes->get('admin/academic/ConAdminDevelopStudents/ClubGetAcademicYears', [ConAdminDevelopStudents::class, 'ClubGetAcademicYears']);

$routes->get('Admin/Acade/Registration/Enroll', [ConAdminEnroll::class, 'AdminEnrollMain']);
$routes->get('Admin/Acade/Registration/Enroll/Add/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollAdd']);
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
$routes->post('admin/academic/ConAdminClassSchedule/getDataByYear', [ConAdminClassSchedule::class, 'getDataByYear']);
$routes->post('Admin/Acade/ConAdminExamSchedule/delete_exam_schedule/(:segment)', [ConAdminExamSchedule::class, 'delete_exam_schedule/$1']);
$routes->get('Admin/Acade/Registration/ClassRoom', [ConAdminClassRoom::class, 'AdminClassMain']);
$routes->get('Admin/Acade/Registration/ClassRoom/(:num)', [ConAdminClassRoom::class, 'AdminClassMain/$1']);
$routes->get('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/DeleteClassRoom/(:segment)', [ConAdminClassRoom::class, 'DeleteClassRoom']);
$routes->get('Admin/Acade/Registration/Students', [ConAdminStudents::class, 'AdminStudentsMain']);
$routes->get('Admin/Acade/Registration/Students/Data', [ConAdminStudents::class, 'AdminStudentsData']);
$routes->get('Admin/Acade/Registration/Students/(:segment)', [ConAdminStudents::class, 'AdminStudentsNormal']);
$routes->match(['get', 'post'],'Admin/Acade/Registration/StudentsUpdate', [ConAdminStudents::class, 'AdminStudentsUpdate']);

$routes->get('Admin/Academic/ConAdminStudents/get_student_details/(:num)', [ConAdminStudents::class, 'get_student_details/$1']);
$routes->post('Admin/Academic/ConAdminStudents/update_student_details', [ConAdminStudents::class, 'update_student_details']);
$routes->post('Admin/Academic/ConAdminStudents/AdminStudentsDelete/(:num)', [ConAdminStudents::class, 'AdminStudentsDelete/$1']);

$routes->get('Admin/Acade/Registration/ExtraSubject', [ConAdminExtraSubject::class, 'index']);
$routes->get('Admin/Acade/Registration/SettingSystem', [ConAdminExtraSubject::class, 'SystemMainExtraSubject']);
$routes->get('Admin/Acade/Registration/RoomOnline', [ConAdminRoomOnline::class, 'RoomOnlineMain']);
$routes->post('admin/room-online/data', [ConAdminRoomOnline::class, 'getRoomOnlineData']);

$routes->get('Admin/Acade/Course/ClassSchedule', [ConAdminClassSchedule::class, 'AdminClassScheduleMain']);
$routes->get('Admin/Acade/Course/ClassSchedule/add', [ConAdminClassSchedule::class, 'add']);
$routes->get('Admin/Acade/Course/RegisterSubject', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectMain']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectSelect', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectSelect']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectEdit', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectEdit']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectUpdate', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectUpdate']);
$routes->post('admin/academic/ConAdminRegisterSubject/AdminRegisterSubjectInsert', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectInsert']);
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
$routes->post('Admin/Settings/UpdateSchoolYear', [ConAdminCourse::class, 'updateSchoolYear']);
$routes->get('admin/academic/checkplan', [ConAdminCheckPlan::class, 'index']);
$routes->post('admin/academic/checkplan/update', [ConAdminCheckPlan::class, 'updatePlanStatus']);
$routes->post('admin/academic/checkplan/updateplanstatus', [ConAdminCheckPlan::class, 'updatePlanStatus']);
$routes->get('admin/academic/checkplan/plans/(:segment)', [ConAdminCheckPlan::class, 'plansByGroup/$1']);
$routes->get('admin/academic/checkplan/teacherplans/(:segment)', [ConAdminCheckPlan::class, 'getTeacherPlans/$1']);

$routes->get('Admin/Acade/Report', [ConAdminExtraSubject::class, 'ExtraReport']);

$routes->get('Admin/Acade/Setting/AdminRoles', [ConAdminSettingAdminRoles::class, 'AcademicSettingAdminRoles']);
$routes->group('ConAdminSettingAdminRoles', function ($routes) {
    $routes->post('AcademicSettingManager', [ConAdminSettingAdminRoles::class, 'AcademicSettingManager']);
    $routes->post('AcademicSettingDeputy', [ConAdminSettingAdminRoles::class, 'AcademicSettingDeputy']);
    $routes->post('AcademicSettingLeader', [ConAdminSettingAdminRoles::class, 'AcademicSettingLeader']);
    $routes->post('SelectWork', [ConAdminSettingAdminRoles::class, 'SelectWork']);
    $routes->post('addAcademicStaff', [ConAdminSettingAdminRoles::class, 'addAcademicStaff']);
    $routes->post('deleteAcademicStaff', [ConAdminSettingAdminRoles::class, 'deleteAcademicStaff']);
});

$routes->get('Admin/Acade/Evaluate/AcademicRepeat/(:segment)/(:segment)', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatMain']);
$routes->get('Admin/Acade/Evaluate/AcademicRepeat/(:segment)/(:segment)/(:segment)', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatGrade']);
$routes->get('Admin/Acade/Evaluate/AcademicResult', [ConAdminAcademinResult::class, 'AdminAcademinResultMain']);
    $routes->post('admin/academic/ConAdminAcademinResult/OnOffLevel', [ConAdminAcademinResult::class, 'OnOffLevel']);
    $routes->post('admin/academic/ConAdminAcademinResult/CheckOnOffDoGrade', [ConAdminAcademinResult::class, 'CheckOnOffDoGrade']);
    $routes->post('admin/academic/ConAdminAcademinResult/CheckOnOffOpenYear', [ConAdminAcademinResult::class, 'CheckOnOffOpenYear']);
$routes->get('Admin/Acade/Evaluate/EditGrade/(:segment)/(:segment)', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeMain']);
$routes->get('Admin/Acade/Evaluate/EditGrade/(:segment)/(:segment)/(:segment)', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeUpdate']);
$routes->get('Admin/Acade/Evaluate/SaveScore', [ConAdminSaveScore::class, 'AdminSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/SaveScoreGrade/(:segment)/(:segment)/(:segment)', [ConAdminSaveScore::class, 'AdminSaveScoreGrade']);
$routes->post('admin/academic/ConAdminSaveScore/CheckOnOffSaveScore', [ConAdminSaveScore::class, 'CheckOnOffSaveScore']);
$routes->get('Admin/Acade/Evaluate/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Evaluate/ReportPerson/(:num)/(:num)', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Evaluate/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Evaluate/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->post('Admin/Acade/Evaluate/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->post('Admin/Acade/Evaluate/exportRoomReportToExcel', [ConAdminReportResult::class, 'exportRoomReportToExcel']);

// Custom AJAX POST routes for ConAdminAcademicRepeat (for AdminEvaluateLearnRepeatGrade.php)
$routes->post('Admin/Acade/Evaluate/ConAdminAcademicRepeat/update_study_time', [ConAdminAcademicRepeat::class, 'update_study_time']);
$routes->post('Admin/Acade/Evaluate/ConAdminAcademicRepeat/update_score', [ConAdminAcademicRepeat::class, 'update_score']);
$routes->post('Admin/Acade/Evaluate/update_repeat_settings', [ConAdminAcademicRepeat::class, 'update_repeat_settings']);



$routes->post('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatAdd', [ConAdminRegisRepeat::class, 'AdminRegisRepeatAdd']);

$routes->post('admin/academic/ConAdminRegisRepeat/AdminRegisRepeatShow', [ConAdminRegisRepeat::class, 'AdminRegisRepeatShow']);

$routes->match(['get', 'post'], 'Admin/Academic/ConAdminStudents/AdminStudentsNormalShow/(:segment)', [ConAdminStudents::class, 'AdminStudentsNormalShow/$1']);

$routes->post('Admin/Academic/ConAdminEnroll/AdminEnrollSelect', [ConAdminEnroll::class, 'AdminEnrollSelect']);
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollUpdate', [ConAdminEnroll::class, 'AdminEnrollUpdate']); // Added route
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollShow', [ConAdminEnroll::class, 'AdminEnrollShow']); // Added route for AJAX call
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollCancel', [ConAdminEnroll::class, 'AdminEnrollCancel']); // Added route for AJAX call
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollChangeSubjectToTeacher', [ConAdminEnroll::class, 'AdminEnrollChangeSubjectToTeacher']); // Added route for AJAX call
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollInsert', [ConAdminEnroll::class, 'AdminEnrollInsert']); // Added route for AJAX call
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollDel', [ConAdminEnroll::class, 'AdminEnrollDel']); // Added route for AJAX call
$routes->post('admin/academic/ConAdminEnroll/AdminEnrollChangeTeacher', [ConAdminEnroll::class, 'AdminEnrollChangeTeacher']);

// Route สำหรับ AdminEnrollSubject
$routes->get('Admin/Academic/ConAdminEnroll/AdminEnrollSubject', [ConAdminEnroll::class, 'AdminEnrollSubject']);
$routes->post('Admin/Academic/ConAdminEnroll/AdminEnrollSubject', [ConAdminEnroll::class, 'AdminEnrollSubject']);


$routes->match(['get', 'post'], 'admin/academic/ConAdminStudents/getDashboardData', [ConAdminStudents::class, 'getDashboardData']);

$routes->get('Admin/Acade/DevelopStudents/Clubs/Main', [ConAdminDevelopStudents::class, 'ClubsMain']);
$routes->get('Admin/Acade/DevelopStudents/Clubs/All', [ConAdminDevelopStudents::class, 'ClubsAll']);

// ผู้บริหารสถานศึกษา
$routes->get('Admin/Acade/Executive/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Executive/ReportPerson/(:num)/(:num)', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Executive/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Executive/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->get('Admin/Acade/Executive/ReportSummaryTeacher', [ConAdminReportResult::class, 'AdminReportSummaryTeacher']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Executive/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Evaluate/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Executive/ReportEnroll/Main', [ConAdminReportResult::class, 'AdminReportEnrollMain']);
$routes->get('Admin/Acade/Executive/ReportEnroll/ID/(:segment)', [ConAdminReportResult::class, 'AdminReportEnrollDetailStudent']);
$routes->post('Admin/Acade/Executive/exportRoomReportToExcel', [ConAdminReportResult::class, 'exportRoomReportToExcel']);
$routes->get('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard', [ConAdminReportResult::class, 'AdminReportAcademicSummaryRoyalRoseStandard']);
$routes->get('Admin/Acade/Evaluate/ReportAcademicSummary', [ConAdminReportResult::class, 'AdminReportAcademicSummary']);

// Session check for auto-logout
$routes->get('session/check', [Session::class, 'check']);

// Login
$routes->get('Logout', [Control_login::class, 'logout']);
$routes->get('LogoutTeacher', [Control_login::class, 'logoutGoogle']);
$routes->get('LoginStudent', [Control_login::class, 'LoginStudent']);
$routes->get('LoginTeacher', [Control_login::class, 'LoginTeacher']);
$routes->get('LoginMenager', [Welcome::class, 'LoginMenager']);
$routes->get('LoginMenager_callback', [Control_login::class, 'LoginMenager_callback']);

// Student
$routes->get('Student/AcademicResult', [ConStudentHome::class, 'score']);
$routes->get('Student/Home', [ConStudentHome::class, 'Home']);
$routes->get('Student/Extra/Subject', [ConStudentExtraSubject::class, 'ExtraSubject']);
$routes->get('Student/Extra/ReadMe', [ConStudentExtraSubject::class, 'ReadMe']);
$routes->get('Student/Extra/CheckRegister', [ConStudentExtraSubject::class, 'CheckRegister']);

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
