<?php

use Illuminate\Support\Facades\Route;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\NotificationHandler;

use App\Http\Controllers\Admin\GradeGeneratorController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\MasterData\SubCategoryController;
use App\Http\Controllers\Admin\MasterData\AnnouncementController;
use App\Http\Controllers\Admin\MasterData\FaqController;

use App\Http\Controllers\Admin\User\UserController;

use App\Http\Controllers\Admin\Lesson\LessonCategoryController;
use App\Http\Controllers\Admin\Lesson\LessonController;
use App\Http\Controllers\Admin\Lesson\ValueCategoryController;
use App\Http\Controllers\Admin\Lesson\DetailValueCategoryController;
use App\Http\Controllers\Admin\Lesson\QuestionTitleController;
use App\Http\Controllers\Admin\Lesson\QuestionController;

use App\Http\Controllers\Admin\Exam\ExamController;
use App\Http\Controllers\Admin\Exam\ExamGroupController;
use App\Http\Controllers\Admin\Exam\ExamGroupDetailController;

use App\Http\Controllers\Admin\Material\ModuleController;
use App\Http\Controllers\Admin\Material\VideoModuleController;

use App\Http\Controllers\Admin\Transaction\BankController;
use App\Http\Controllers\Admin\Transaction\VoucherController;
use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Admin\User\AccountBalanceController;

use App\Http\Controllers\Admin\Region\RegionController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\AnnouncementController as UserAnnouncementController;
use App\Http\Controllers\User\FaqController as UserFaqController;

use App\Http\Controllers\User\TryOut\CategoryController as UserCategoryController;
use App\Http\Controllers\User\TryOut\LessonCategoryController as UserLessonCategoryController;
use App\Http\Controllers\User\TryOut\LessonController as UserLessonController;
use App\Http\Controllers\User\TryOut\ExamController as UserExamController;
use App\Http\Controllers\User\TryOut\GradeController as UserGradeController;
use App\Http\Controllers\User\TryOut\ExamGroupController as UserExamGroupController;

use App\Http\Controllers\User\Transaction\VoucherController as UserVoucherController;
use App\Http\Controllers\User\Transaction\TransactionController as UserTransactionController;
use App\Http\Controllers\User\Transaction\VoucherActivationController as UserVoucherActivationController;

use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\AccountBalanceController as UserAccountBalanceController;

use App\Http\Controllers\User\Material\ModuleController as UserModuleController;
use App\Http\Controllers\User\Material\VideoModuleController as UserVideoModuleController;

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\TestingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    return 'Config cache cleared';
});

Route::get('testing-wa', [TestingController::class, 'testingWa']);
Route::get('testing', [TestingController::class, 'index']);
Route::get('json-testing', [TestingController::class, 'jsonRelation']);
Route::get('local-storage', [TestingController::class, 'localStorage']);
Route::get('on-progress', [TestingController::class, 'onprogress']);

Route::get('check-connection', [TestingController::class, 'checkConnection']);

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/physical-calculations', [HomeController::class,'physicalCalculation'])->name('landing_page.physical-calculations');
Route::post('/physical-calculations', [HomeController::class,'physicalCalculate'])->name('landing_page.physical-calculations.store');

Route::post('upload', [DashboardController::class, 'upload'])->name('upload');

// admin site
Route::group(['middleware' => ['auth', 'admin', 'accountIsActive']], function() {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('/grade-generators', GradeGeneratorController::class)->only(['index', 'store']);
        Route::get('/grade-generators/delete-all', [GradeGeneratorController::class, 'deleteAll']);
        Route::get('/grade-generators/{id}/export-pdf', [GradeGeneratorController::class, 'exportPdf']);

        Route::resource('/settings', SettingController::class)->only(['index', 'store']);

        Route::resource('/categories', CategoryController::class)->except(['show']);
        Route::get('categories/{id}/lesson-categories', [CategoryController::class, 'getLessonCategory'])->name('categories.lesson-categories');
        Route::get('categories/{id}/sub-categories', [CategoryController::class, 'getSubCategory'])->name('categories.sub-categories');
        
        Route::resource('/sub-categories', SubCategoryController::class)->except(['show']);
    
        Route::resource('announcements', AnnouncementController::class);
        
        Route::resource('faqs', FaqController::class);

        Route::resource('lesson-categories', LessonCategoryController::class)->except(['show']);
        Route::get('lesson-categories/{id}/lessons', [LessonCategoryController::class, 'getLesson']);

        Route::resource('lessons', LessonController::class);
        Route::get('lessons/{id}/question-titles', [LessonController::class, 'getQuestionTitle'])->name('lessons.question-titles');

        Route::resource('value-categories', ValueCategoryController::class)->except(['show']);

        Route::resource('value-categories.detail-value-categories', DetailValueCategoryController::class)->except(['show']);

        Route::resource('question-titles', QuestionTitleController::class)->except(['show']);
        Route::get('question-titles/{id}/format-import-excel', [QuestionTitleController::class, 'importExcelFormat'])->name('question-titles.format-import-excel');

        Route::resource('question-titles.questions', QuestionController::class);
        Route::get('question-titles/{id}/delete-question', [QuestionController::class, 'deleteQuestion'])->name('question-titles.questions.delete-question');
        Route::post('question-titles/{id}/import-excel', [QuestionController::class, 'importExcel'])->name('question-titles.questions.import-excel');
        Route::get('question-titles/{id}/export-excel', [QuestionController::class, 'exportExcel'])->name('question-titles.questions.export-excel');
        Route::post('question-titles/{id}/questions/generate-question', [QuestionController::class, 'generateQuestion'])->name('question_titles.questions.generate_question');


        Route::resource('users', UserController::class);
        Route::get('users/{user}/send-activation-link', [UserController::class, 'sendActivationLink'])->name('users.send_activation_link');
        Route::get('users/{user}/activation-reminder', [UserController::class, 'activationReminder'])->name('users.activation_reminder');
        Route::get('users/{user}/member-reminder', [UserController::class, 'memberReminder'])->name('users.member_reminder');
        Route::delete('users/{user}/user-member-categories/{memberCategoryId}', [UserController::class, 'destroyUserMemberCategory'])->name('users.destroy_member_category');

        Route::resource('exams', ExamController::class);
        Route::get('exams/{id}/export-pdf', [ExamController::class, 'exportPdf']);
        Route::get('exams/{id}/export-excel', [ExamController::class, 'exportExcel']);
        Route::get('exams/{id}/regenerate-block-tokens', [ExamController::class, 'regenerateBlockToken']);
        Route::delete('exams/grades/{id}/destroy', [ExamController::class, 'deleteExam']);
        
        Route::resource('exam-groups', ExamGroupController::class);
        Route::get('exam-groups/{id}/regenerate-block-tokens', [ExamGroupController::class, 'regenerateBlockToken']);
        Route::resource('exam-groups.exam-group-details', ExamGroupDetailController::class);
        Route::get('exam-groups/{id}/exam-group-details/{exam_id}/export-pdf', [ExamGroupDetailController::class, 'exportPdf']);
        Route::get('exam-groups/{id}/exam-group-details/{exam_id}/export-excel', [ExamGroupDetailController::class, 'exportExcel']);
        Route::get('exam-groups/{id}/students', [ExamGroupController::class, 'examGroupStudent']);
        Route::get('exam-groups/{id}/export-pdf', [ExamGroupController::class, 'examGroupExportPdf']);
        Route::get('exam-groups/{id}/export-excel', [ExamGroupController::class, 'examGroupExportExcel']);
        Route::get('exam-groups/{id}/students/{exam_group_user_id}/grades', [ExamGroupController::class, 'examGroupStudentGrade']);
        Route::get('exam-groups/{id}/students/{exam_group_user_id}/regenerate-scores', [ExamGroupController::class, 'regenerateScore']);
        Route::get('exam-groups/{id}/students/{exam_group_user_id}/export-pdf', [ExamGroupController::class, 'examGroupStudentExportPdf']);
        Route::delete('exam-groups/{id}/exam-group-users', [ExamGroupController::class, 'examGroupUserDestroy']);

        Route::resource('banks', BankController::class)->except(['show']);

        Route::resource('vouchers', VoucherController::class)->except(['show']);

        Route::resource('modules', ModuleController::class)->except(['show']);

        Route::resource('video-modules', VideoModuleController::class)->except(['show']);

        Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
        Route::resource('transactions', TransactionController::class);
        Route::get('transactions/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');

        Route::resource('account-balances', AccountBalanceController::class)->only(['index', 'show', 'update']);
    });
});

// user site
Route::group(['middleware' => ['auth', 'accountIsActive']], function() {
    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        // dashboard
        Route::get('dashboard', UserDashboardController::class)->name('user.dashboard');

        Route::resource('account-balances', UserAccountBalanceController::class)->only(['index', 'store']);
        Route::get('account-balances/buy-exam/{examId}', [UserAccountBalanceController::class, 'buyExam']);

        Route::resource('announcements', UserAnnouncementController::class)->only(['index', 'show']);

        Route::resource('faqs', UserFaqController::class)->only(['index']);

        Route::resource('categories', UserCategoryController::class)->only(['index']);

        Route::resource('categories.lesson-categories', UserLessonCategoryController::class)->only(['index']);

        Route::resource('categories.lesson-categories.lessons', UserLessonController::class)->only(['index']);
        
        Route::resource('categories.lesson-categories.lessons.exams', UserExamController::class)->only(['index', 'show']);
        Route::get('exams/{id}/exam-start', [UserExamController::class, 'examStart'])->name('exams.exam-start');
        Route::get('exams/{id}/exam-reset', [UserExamController::class, 'examReset'])->name('exams.exam-reset');
        Route::get('exams/{exam_id}/grades/{grade_id}/sections/{section}', [UserExamController::class, 'examShowQuestion'])->name('exams.exam-show-questions');
        Route::post('exams/{id}/exam-end', [UserExamController::class, 'endExam'])->name('exams.exam-end');
        Route::post('exams/{id}/decrement-tolerance', [UserExamController::class, 'decrementTolerance'])->name('exams.decrement-tolerance');
        Route::get('exams/{exam_id}/grades/{grade_id}/unblocked', [UserExamController::class, 'unblocked']);

        Route::resource('grades', UserGradeController::class)->only(['index', 'show']);
        Route::get('grades/{grade_id}/questions', [UserGradeController::class, 'question'])->name('grades.questions');

        Route::get('exam-groups/{id}/exam-start', [UserExamGroupController::class, 'examStart'])->name('exam-groups.exam-start');
        Route::get('exam-groups/{id}/exam-reset', [UserExamController::class, 'examReset'])->name('exam-groups.exam-reset');
        Route::get('exam-groups/{id}/sections/{section}', [UserExamGroupController::class, 'examShowQuestion'])->name('exam-groups.exam-show-questions');
        Route::post('exam-groups/{id}/exam-end', [UserExamGroupController::class, 'endExam'])->name('exam-groups.exam-end');
        Route::post('exam-groups/{id}/decrement-tolerance', [UserExamGroupController::class, 'decrementTolerance'])->name('exam-groups.decrement-tolerance');
        Route::get('exam-groups/{exam_group_id}/grades/{exam_group_user_id}/unblocked', [UserExamGroupController::class, 'unblocked']);

        Route::get('exam-groups', [UserExamGroupController::class, 'index']);
        Route::get('exam-groups/histories', [UserExamGroupController::class, 'examGroupHistory']);
        Route::get('exam-groups/histories/{id}', [UserExamGroupController::class, 'examGroupHistoryDetail']);
        Route::get('exam-groups/{id}/export-pdf', [UserExamGroupController::class, 'examGroupStudentExportPdf']);
        Route::get('exam-groups/{id}/lesson-categories', [UserExamGroupController::class, 'examGroupDetail']);
        Route::get('exam-groups/{id}/lesson-categories/{lessonCategoryId}/exams', [UserExamGroupController::class, 'examGroupList']);
        Route::get('exam-groups/{id}/lesson-categories/{lessonCategoryId}/exams/{examGroupId}', [UserExamGroupController::class, 'examGroupShow'])->name('exam_group.show');

        Route::resource('vouchers', UserVoucherController::class)->only(['index']);
        Route::get('vouchers/{voucher}/buy', [UserVoucherController::class, 'buy'])->name('vouchers.buy');
        Route::post('vouchers/{voucher}/buy', [UserVoucherController::class, 'buyStore'])->name('vouchers.buy.store');

        Route::resource('transactions', UserTransactionController::class)->only(['index', 'show']);
        Route::get('transactions/{transaction}/payment-confirmations', [UserTransactionController::class, 'paymentConfirmation'])->name('transactions.payment-confirmations');
        Route::post('transactions/{transaction}/payment-confirmations', [UserTransactionController::class, 'storePaymentConfirmation']);

        Route::resource('modules', UserModuleController::class)->only(['index', 'show']);

        Route::resource('video-modules', UserVideoModuleController::class)->only(['index', 'show']);

        Route::resource('voucher-activations', UserVoucherActivationController::class)->only(['index', 'store']);

        Route::resource('users', UserUserController::class)->only(['index', 'edit', 'update']);
    });
});

    // regional
    Route::get('region/province', [RegionController::class, 'province']);
    Route::get('region/city/{provinsi_id}', [RegionController::class, 'city']);
    Route::get('region/district/{city_id}', [RegionController::class, 'district']);
    Route::get('region/village/{district_id}', [RegionController::class, 'village']);

Route::get('user/{id}/activation', [ActivationController::class, 'activation']);
Route::get('user/{id}/activation/actived', [ActivationController::class, 'actived']);
Route::get('user/forgot-password', [ActivationController::class, 'forgotPassword']);
Route::post('user/forgot-password', [ActivationController::class, 'storeForgotPassword']);
