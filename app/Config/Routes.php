
<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Welcome;
use App\Controllers\Control_login;
use App\Controllers\Admin\Academic\ConAdminAcademicRepeat;
use App\Controllers\Admin\Academic\ConAdminAcademinResult;
use App\Controllers\Admin\Academic\ConAdminClassRoom;
use App\Controllers\Admin\Academic\ConAdminClassSchedule;
use App\Controllers\Admin\Academic\ConAdminCourse;
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

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Welcome::class, 'index']);

// CI3 Routes Migration
$routes->get('ClosePage', [Welcome::class, 'ClosePage']);
$routes->get('LoginAdmin', [Control_login::class, 'LoginAdmin']);

// งานวิชาการ
$routes->get('Admin/Home', [ConAdminHome::class, 'AdminHome']);
$routes->get('Admin/Acade/Registration/Enroll', [ConAdminEnroll::class, 'AdminEnrollMain']);
$routes->get('Admin/Acade/Registration/Enroll/Add/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollAdd']);
$routes->get('Admin/Acade/Registration/Enroll/Edit/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollEdit']);
$routes->get('Admin/Acade/Registration/Enroll/Delete/(:segment)/(:segment)', [ConAdminEnroll::class, 'AdminEnrollDelete']);
$routes->get('Admin/Acade/Registration/Repeat', [ConAdminRegisRepeat::class, 'AdminRegisRepeatMain']);
$routes->get('Admin/Acade/Registration/Repeat/Detail/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminRegisRepeat::class, 'AdminRegisRepeatDetail']);
$routes->get('Admin/Acade/Registration/Repeat/Add', [ConAdminRegisRepeat::class, 'AdminRegisRepeatAdd']);
$routes->get('Admin/Acade/Registration/ExamSchedule', [ConAdminExamSchedule::class, 'AdminExamScheduleMain']);
$routes->get('Admin/Acade/Registration/ExamSchedule/add', [ConAdminExamSchedule::class, 'add']);
$routes->get('Admin/Acade/Registration/ClassRoom', [ConAdminClassRoom::class, 'AdminClassMain']);
$routes->get('Admin/Acade/Registration/ClassRoom/(:num)', [ConAdminClassRoom::class, 'AdminClassMain/$1']);
$routes->get('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/AddClassRoom', [ConAdminClassRoom::class, 'AddClassRoom']);
$routes->post('admin/academic/ConAdminClassRoom/DeleteClassRoom/(:segment)', [ConAdminClassRoom::class, 'DeleteClassRoom']);
$routes->get('Admin/Acade/Registration/Students', [ConAdminStudents::class, 'AdminStudentsMain']);
$routes->get('Admin/Acade/Registration/Students/Data', [ConAdminStudents::class, 'AdminStudentsData']);
$routes->get('Admin/Acade/Registration/Students/(:segment)', [ConAdminStudents::class, 'AdminStudentsNormal']);
$routes->post('Admin/Acade/Registration/StudentsUpdate', [ConAdminStudents::class, 'AdminStudentsUpdate']);

$routes->get('Admin/Acade/Registration/ExtraSubject', [ConAdminExtraSubject::class, 'index']);
$routes->get('Admin/Acade/Registration/SettingSystem', [ConAdminExtraSubject::class, 'SystemMainExtraSubject']);
$routes->get('Admin/Acade/Registration/RoomOnline', [ConAdminRoomOnline::class, 'RoomOnlineMain']);

$routes->get('Admin/Acade/Course/ClassSchedule', [ConAdminClassSchedule::class, 'AdminClassScheduleMain']);
$routes->get('Admin/Acade/Course/ClassSchedule/add', [ConAdminClassSchedule::class, 'add']);
$routes->get('Admin/Acade/Course/RegisterSubject', [ConAdminRegisterSubject::class, 'AdminRegisterSubjectMain']);
$routes->get('Admin/Acade/Course/SendPlan', [ConAdminCourse::class, 'SendPlanMain']);

$routes->get('Admin/Acade/Report', [ConAdminExtraSubject::class, 'ExtraReport']);

$routes->get('Admin/Acade/Setting/AdminRoles', [ConAdminSettingAdminRoles::class, 'AcademicSettingAdminRoles']);

$routes->get('Admin/Acade/Evaluate/AcademicRepeat/(:segment)/(:segment)', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatMain']);
$routes->get('Admin/Acade/Evaluate/AcademicRepeat/(:segment)/(:segment)/(:segment)', [ConAdminAcademicRepeat::class, 'AdminAcademicRepeatGrade']);
$routes->get('Admin/Acade/Evaluate/AcademicResult', [ConAdminAcademinResult::class, 'AdminAcademinResultMain']);
$routes->get('Admin/Acade/Evaluate/EditGrade/(:segment)/(:segment)', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeMain']);
$routes->get('Admin/Acade/Evaluate/EditGrade/(:segment)/(:segment)/(:segment)', [ConAdminEvaluateEditGrade::class, 'AdminEvaluateEditGradeUpdate']);
$routes->get('Admin/Acade/Evaluate/SaveScore', [ConAdminSaveScore::class, 'AdminSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/SaveScoreGrade/(:segment)/(:segment)/(:segment)', [ConAdminSaveScore::class, 'AdminSaveScoreGrade']);
$routes->get('Admin/Acade/Evaluate/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Evaluate/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Evaluate/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->get('Admin/Acade/Evaluate/ReportSummaryTeacher', [ConAdminReportResult::class, 'AdminReportSummaryTeacher']);
$routes->get('Admin/Acade/Evaluate/ReportAcademicSummaryRoyalRoseStandard', [ConAdminReportResult::class, 'AdminReportAcademicSummaryRoyalRoseStandard']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Evaluate/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Evaluate/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);



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


$routes->get('Admin/Acade/DevelopStudents/Clubs/Main', [ConAdminDevelopStudents::class, 'ClubsMain']);
$routes->get('Admin/Acade/DevelopStudents/Clubs/All', [ConAdminDevelopStudents::class, 'ClubsAll']);

// ผู้บริหารสถานศึกษา
$routes->get('Admin/Acade/Executive/ReportPerson', [ConAdminReportResult::class, 'AdminReportPersonMain']);
$routes->get('Admin/Acade/Executive/ReportPerson/(:segment)', [ConAdminReportResult::class, 'AdminStudentsScore']);
$routes->get('Admin/Acade/Executive/ReportRoom', [ConAdminReportResult::class, 'AdminReportRoomMain']);
$routes->get('Admin/Acade/Executive/ReportSummaryTeacher', [ConAdminReportResult::class, 'AdminReportSummaryTeacher']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScore/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreMain']);
$routes->get('Admin/Acade/Executive/ReportTeacherSaveScoreCheck/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'AdminReportTeacherSaveScoreCheck']);
$routes->get('Admin/Acade/Executive/ReportScoreRoomMain/(:segment)/(:segment)/(:segment)/(:segment)', [ConAdminReportResult::class, 'ReportScoreRoomMain']);
$routes->get('Admin/Acade/Executive/ReportEnroll/Main', [ConAdminReportResult::class, 'AdminReportEnrollMain']);
$routes->get('Admin/Acade/Executive/ReportEnroll/ID/(:segment)', [ConAdminReportResult::class, 'AdminReportEnrollDetailStudent']);

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
