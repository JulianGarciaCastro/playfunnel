<?php

use App\Models\Project;
use App\Models\Interaction;
use App\Models\User;
use App\Models\Library;
use App\Models\CrmCustomField;
use App\Models\CrmTag;
use App\Models\PlanSubscription;
use App\Models\PlanType;
use App\Models\UserConfig;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Middleware\LocaleCookieMiddleware;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\ImpersonationController;

use App\Http\Controllers\Auth\GoogleController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Carbon\Carbon;



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

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


Route::get('/', function () {
    if(Auth::check()){
        $user = User::find(Auth::id());

        if (!$user->hasVerifiedEmail()){
            return Redirect::to('/email/verify');
        }
        else{
            return Redirect::to('dashboard');
        }
    }
    return Redirect::to('login');
});

//---------------------------------------------------------------------------------------//

/*
Route::prefix('{locale}')->middleware(LocaleMiddleware::class)->group(function (){
    Route::get('login2', function ($locale) {
        return __('dashboard.projects');
    });
});
*/

Route::get('locale/{locale}',function($locale){
    return redirect()->back()->withCookie('locale',$locale);
});

Route::middleware(LocaleCookieMiddleware::class)->group(function (){
    //---------------------------------------------------------------------------------------//
    Route::get('/login', function (Request $request) {
        if(Auth::check()){
            $user = User::find(Auth::id());

            if (!$user->hasVerifiedEmail()){
                return Redirect::to('/email/verify');
            }
            else{
                return Redirect::to('dashboard');
            }
        }

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'LOGIN', 'GET');

        return view('login');
    });
    Route::post('/login', [App\Http\Controllers\Login::class, 'doLogin'])->name('login');
    Route::get('/logout', [App\Http\Controllers\Login::class, 'doLogout'])->name('logout');
    Route::post('/impersonation/leave', [ImpersonationController::class, 'leave'])->middleware(['auth'])->name('impersonation.leave');
    //---------------------------------------------------------------------------------------//
    //require __DIR__ . '/auth.php';



    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    //TODO Eliminar antes de salir a Pro.
    Route::get('/clearCache', function() {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });


    Route::get('/register', function (Request $request) {
        if(Auth::check()){
            $user = User::find(Auth::id());

            if (!$user->hasVerifiedEmail()){
                return Redirect::to('/email/verify');
            }
        }

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'REGISTER', 'GET');

        return view('register');
    });


    Route::post('/register', [App\Http\Controllers\Login::class, 'register'])->name('register');

    Route::get('/profile', function (Request $request){
        if(!Auth::check()){
            return redirect()->guest(route('login'));
            //return Redirect::intended('login');
        }

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'PROFILE', 'GET');

        $user = Auth::user();
        return View::make('profile', compact('user'));

    })->middleware(['auth','verified'])->name('profile'); //->middleware(['verified'])

    Route::post('/profile',  [App\Http\Controllers\Login::class, 'profile'])->name('profile.save');


    Route::get('/account', function (Request $request){
        if(!Auth::check())
            return redirect()->guest(route('login'));

        $user = Auth::user();
        $plans= PlanType::where('active', '1')->where('default','0')->get();

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'ACCOUNT', 'GET');

        return View::make('account', compact('user','plans'));

    })->middleware(['auth','verified'])->name('account'); //->middleware(['verified'])

    Route::post('/account', [App\Http\Controllers\Login::class, 'account'])->name('account.save');


    Route::get('/billing', function (Request $request){
        if(!Auth::check())
            return redirect()->guest(route('login'));

        $user = Auth::user();
        $plans= $user->getPlanSusbcription;

        $object = new StripePaymentController();

        $subscriptions = $object->stripeUserSubscriptions($request);

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'BILLING', 'GET');

        return View::make('billing', compact('user','plans'));

    })->middleware(['auth','verified'])->name('account'); //->middleware(['verified'])

    Route::get('/email/verify', function (Request $request) {
        //return view('auth.verify');

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'VERIRFY_EMAIL', 'GET');

        return view('emailVerify',['email' => Auth::user()->email]);

    })->middleware(['auth'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request) {  //EmailVerificationRequest

        $user = User::find($request->route('id')); //findOrFail

        if ($user == NULL){
            Log::debug('USUARIO ES NULL');
            return redirect()->back()->withErrors('Account doesnt exists');
        }

        if ($user->hasVerifiedEmail()) {
            Log::debug('USUARIO YA VALIDADO');
            return redirect()->back()->withErrors('Account already verified');
        }

        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            Log::debug('USUARIO NO ENCONTRADO');
            return redirect()->back()->withErrors('Account doesnt exists');
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            Log::debug('HASH NO COINCIDEN');
            return redirect()->back()->withErrors('Account verification error, plaease try again');
        }

        //$request->fulfill();
        $user->markEmailAsVerified();
        $user->status = 'ACTIVE';
        $user->save();
        event(new Verified($user));
        $user->subscribeDefaultPlan();
        Session::forget('url.intended');

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'VERIFY_EMAIL_ID_HASH', 'GET');

        return redirect('/login')->with(['status' => __('User verify correctly, please singin.')]);

    })->name('verification.verify');
    //->middleware(['auth', 'signed'])

    /*Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
*/
    Route::post('/email/verification-notification', [App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

    Route::get('/forgot_pass', function (Request $request) {

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'FORGOT_PASS', 'GET');

        return view('forgot_pass');
    })->middleware(['guest'])->name('password.request');



    Route::post('/forgot_pass', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink( $request->only('email') );

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'FORGOT_PWD', 'POST');

        return $status === Password::RESET_LINK_SENT
                            ? back()->with(['status' => __($status)])
                            : back()->withErrors(['email' => __($status)]);

    })->middleware(['guest'])->name('password.email');



    Route::get('/password/reset/{token}', function ($token) {

        return view('reset_pass', ['token' => $token]);

    })->middleware(['guest'])->name('password.reset');



    Route::post('/password/reset', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) use ($request) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            });

        $pageView = new PageViewController();
        $pageView->addPageView($request, 'PWD_RESET', 'POST');

        return $status == Password::PASSWORD_RESET
                        ? redirect()->route('login')->with('status', __($status))
                        : back()->withErrors(['email' => __($status)]);
    })->middleware(['guest'])->name('password.update');

    Route::post('ajax-profile-img', [App\Http\Controllers\Login::class, 'profileImg'])->middleware(['auth'])->name('profile.save');


    Route::post('ajax-addMedia', [App\Http\Controllers\LibraryController::class, 'addMedia'])->middleware(['auth'])->name('project.addMedia');

    Route::post('ajax-delMedia', [App\Http\Controllers\LibraryController::class, 'delMedia'])->middleware(['auth'])->name('project.delMedia');

    Route::post('ajax-loadMedia', [App\Http\Controllers\LibraryController::class, 'loadMedia'])->middleware(['auth'])->name('project.loadMedia');

    Route::post('ajax-newFolder', [App\Http\Controllers\LibraryController::class, 'newFolder'])->middleware(['auth'])->name('project.newFolder');

    Route::post('ajax-openFolder', [App\Http\Controllers\LibraryController::class, 'openFolder'])->middleware(['auth'])->name('project.openFolder');

    Route::get('projects', function (Request $request) {
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        $orderBy   = $request->get('order_by', 'name'); // default column
        $direction = $request->get('direction', 'asc'); // default direction
        $projects  = null;

        if ($request->filled('wordSearch')) {
            $search = $request->input('wordSearch');
            $projects = Project::where('name', 'like', "%{$search}%")->where('user_id', Auth::id())->orderBy($orderBy, $direction)->paginate(10);
        }
        else{
            $projects = Project::where('user_id', Auth::id())->orderBy($orderBy, $direction)->paginate(10);
        }

        $user = Auth::user();

        return View::make('projects', compact('projects','user'));

    })->middleware(['auth','verified'])->name('projects');


    Route::post('/addProject', [App\Http\Controllers\ProjectController::class, 'addProject'])->middleware(['auth'])->name('addProject');

    Route::post('/ajax-delProject', [App\Http\Controllers\ProjectController::class, 'delProject'])->middleware(['auth'])->name('delProject');

    Route::post('ajax-addProjectLib', [App\Http\Controllers\ProjectController::class, 'addProjectLib'])->middleware(['auth'])->name('project.addProjectLib');

    Route::post('ajax-changeProjectLib', [App\Http\Controllers\ProjectController::class, 'changeProjectLib'])->middleware(['auth'])->name('project.changeProjectLib');

    //Route::post('ajax-getProjectLib', [App\Http\Controllers\ProjectController::class, 'getProjectLibrary'])->middleware(['auth'])->name('project.getProjectLib');

    Route::post('ajax-updateProjectLib', [App\Http\Controllers\ProjectController::class, 'updateProjectLib'])->middleware(['auth'])->name('project.updateProjectLib');

    Route::post('ajax-delProjectLib', [App\Http\Controllers\ProjectController::class, 'delProjectLib'])->middleware(['auth'])->name('project.delProjectLib');

    //Route::post('ajax-setProjectLibPositions', [App\Http\Controllers\ProjectController::class, 'setProjectLibPositions'])->middleware(['auth'])->name('project.setProjectLibPositions');

    //Route::post('ajax-getProjectLibInfo', [App\Http\Controllers\ProjectController::class, 'getProjectLibInfo'])->middleware(['auth'])->name('project.getProjectLibInfo');

    //Route::post('ajax-setProjectLibInfo', [App\Http\Controllers\ProjectController::class, 'setProjectLibInfo'])->middleware(['auth'])->name('project.setProjectLibInfo');




    Route::get('library', function () {

        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        $library = Library::where('createdby', Auth::id())->get();
        $user = Auth::user();

        return View::make('library', compact('library','user'));

    })->middleware(['auth','verified'])->name('library');



    /* STEP_1 */
    Route::get('addVideo', function (Request $request) {

        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $projectLibs = $project->projectLibrary;

        $library = Library::where('createdby', Auth::id())->get();
        $user = Auth::user();

        return View::make('add-video', compact('project', 'projectLibs', 'library','user'));

    })->middleware(['auth','verified'])->name('addVideo');




    /* STEP_2 */
    Route::get('cuePoints', function (Request $request) {

        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $projectLibs = $project->projectLibrary;

        if($projectLibs  && count($projectLibs)<=0){
            Log::debug('El proyecto no tiene libreria');
            return redirect()->back()->withErrors(['error' => __('Before continuing you must add a Video to the project.')]);
        }

        $user = Auth::user();

        return View::make('step2', compact('project', 'projectLibs', 'user'));

    })->middleware(['auth','verified'])->name('cuePoints');


    Route::post('ajax-addCuepoint', [App\Http\Controllers\ProjectController::class, 'addCuepoint'])->middleware(['auth'])->name('project.addCuepoint');

    Route::post('ajax-delCuepoint', [App\Http\Controllers\ProjectController::class, 'delCuepoint'])->middleware(['auth'])->name('project.delCuepoint');

    Route::post('ajax-updCuepoint', [App\Http\Controllers\ProjectController::class, 'updCuepoint'])->middleware(['auth'])->name('project.updCuepoint');

    Route::post('ajax-getCuepointList', [App\Http\Controllers\ProjectController::class, 'getCuepointList'])->middleware(['auth'])->name('project.getCuepointList');


    //Route::post('ajax-getCuepointData', [App\Http\Controllers\ProjectController::class, 'getCuepointData'])->middleware(['auth'])->name('project.getCuepointData');

    Route::post('ajax-setCuepointData', [App\Http\Controllers\ProjectController::class, 'setCuepointData'])->middleware(['auth'])->name('project.setCuepointData');

    Route::post('ajax-setPublishData', [App\Http\Controllers\ProjectController::class, 'setPublishData'])->middleware(['auth'])->name('project.setPublishData');


    //Route::post('ajax-getProjectCuepointData', [App\Http\Controllers\ProjectController::class, 'getProjectCuepointData'])->middleware(['auth'])->name('project.getProjectCuepointData');




    /* STEP_3 */
    Route::get('actions', function (Request $request) {
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $projectLibs = $project->projectLibrary;

        if($projectLibs  && count($projectLibs)<=0){
            Log::debug('El proyecto no tiene libreria');
            return redirect()->back()->withErrors(['error' => __('Before continuing you must add a Video to the project.')]);
        }

        $cuePoints   = $project->cuePoints;
        $library = Library::where('createdby', Auth::id())->get();
        $user = Auth::user();

        $crmCustomFields = CrmCustomField::where('userid', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        $crmTags = collect();
        if (Schema::hasTable('crm_tags')) {
            $crmTags = CrmTag::where('userid', Auth::id())
                ->orderBy('name', 'asc')
                ->get();
        }

        return View::make('step3', compact('project', 'projectLibs', 'cuePoints', 'library', 'user', 'crmCustomFields', 'crmTags'));

    })->middleware(['auth','verified'])->name('cuePoints');


    Route::get('stream/{video}', function (Request $request) {
        /*
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }*/
        $video_id =  $request->route('video');

        //$library = Library::where('createdby', Auth::id())
        $library = Library::where('id', $video_id)->first();

        $tmp = new App\Http\Controllers\VideoStream($library->url);
        $tmp->start();
    })->name('stream');

    /* STEP_4 */
    Route::get('publish', function (Request $request) {
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $projectLibs = $project->projectLibrary;

        if($projectLibs  && count($projectLibs)<=0){
            Log::debug('El proyecto no tiene libreria');
            return redirect()->back()->withErrors(['error' => __('Before continuing you must add a Video to the project.')]);
        }

        $library = Library::where('createdby', Auth::id())->get();

        $library_img = Library::where('id', $project->publish_library_img)->first();

        $publish_library_img = 'images/SVG/imageEmpty.svg';
        if($library_img){
            if($library_img->url){
                $publish_library_img = $library_img->url;
            }
        }
        $user = Auth::user();

        return View::make('step4', compact('project','library','publish_library_img','user','projectLibs'));

    })->middleware(['auth','verified'])->name('publish');



    /* Preview */
    Route::get('preview', function (Request $request) {

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $projectLibs = $project->projectLibrary;
        $cuePoints   = $project->cuePoints;

        return View::make('preview', compact('project', 'projectLibs', 'cuePoints'));

    })->middleware(['auth','verified'])->name('preview');


    /* Embed */
    Route::get('embed', function (Request $request) {

        $request->project=openssl_decrypt ($request->project, $ciphering="AES-128-CTR",
                                            $decryption_key="PlayFunnel", $options=0, $decryption_iv="1234567891011121");

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::find($request->project);

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $user = $project->user;

        //validar si tiene plan activo
        $activePlan = $user ? $user->isPlanSusbcriptionActive() : false;
        $userStatus = $user ? ($user->status == 'ACTIVE' ? true : false) : false;
        $projectStatus = $project->project_status_id == 1 ? true : false;

        if(!$activePlan || !$userStatus || !$projectStatus){
            $html = '<div style=" align-content: center; width: 100%; height: 100%;">
                        <a href="https://www.playfunnel.net" target="_blank">
                          <img src="https://content.app-sources.com/s/25931517362007711/uploads/PF/Logo-Horizontal-BgClear-7332418.svg?format=webp" alt="Play Funnel">
                        </a> </div>';

            return response($html, 200);
        }

        $projectLibs = $project->projectLibrary;
        $cuePoints   = $project->cuePoints;

        Log::debug('projectView Before: ' . $request->projectView );
        if(!$request->has('projectView')){
            $request->projectView = 1;
        }
        Log::debug('projectView After: ' . $request->projectView );

        if($request->projectView != 0){
            $pageView = new PageViewController();
            $pageView->addProjectVisit($request, 'EMBED', 'GET', $project->id);
        }

        return View::make('embed', compact('project', 'projectLibs', 'cuePoints'));

    })->name('embed');


    /* Landing Page */
    Route::get('landing', function (Request $request) {

        Log::debug('Before -> El proyecto: ' . $request->project);
        $request->project=openssl_decrypt ($request->project, $ciphering="AES-128-CTR", $decryption_key="PlayFunnel", $options=0, $decryption_iv="1234567891011121");

        if (! $request->project){
            return redirect()->guest(route('projects'));
        }

        Log::debug('After -> El proyecto: ' . $request->project);
        $project = Project::find($request->project);

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $user = $project->user;

        //validar si tiene plan activo
        $activePlan = $user ? $user->isPlanSusbcriptionActive() : false;

        if(!$activePlan){
            $html = '<div style=" align-content: center; width: 100%; height: 100%;">
                        <a href="https://www.playfunnel.net" target="_blank">
                          <img src="https://content.app-sources.com/s/25931517362007711/uploads/PF/Logo-Horizontal-BgClear-7332418.svg?format=webp" alt="Play Funnel">
                        </a> </div>';

            return response($html, 200);
        }

        $projectLibs = $project->projectLibrary;
        $cuePoints   = $project->cuePoints;

        $pageView = new PageViewController();
        $pageView->addProjectVisit($request, 'LANDING', 'GET', $project->id);

        return View::make('landing', compact('project', 'projectLibs', 'cuePoints'));

    })->name('landing');


    Route::get('/translations/{locale}.js', function ($locale) {
        $lang = app()->getLocale();

        $translations = json_encode(trans($locale));
        return response("window.".$locale."Msg = {$translations};")->header('Content-Type', 'text/javascript');
    });

    Route::post('ajax-register-interaction', [App\Http\Controllers\InteractionController::class, 'registerInteraction']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    Route::get('/crm', [App\Http\Controllers\CrmController::class, 'index'])->middleware(['auth', 'verified'])->name('crm');
    Route::post('crm-CustomerByProjectId', [App\Http\Controllers\CrmController::class, 'getCustomersByProject'])->middleware(['auth', 'verified'])->name('getCustomersByProject');
    Route::post('crm-CustomerById', [App\Http\Controllers\CrmController::class, 'getCutomerById'])->middleware(['auth', 'verified'])->name('getCutomerById');
    Route::post('crm-update-customer', [App\Http\Controllers\CrmController::class, 'updateCustomer'])->middleware(['auth', 'verified'])->name('updateCustomer');
    Route::post('crm-delete-customer', [App\Http\Controllers\CrmController::class, 'deleteCustomer'])->middleware(['auth', 'verified'])->name('deleteCustomer');
    Route::post('crm/visible-columns', [App\Http\Controllers\CrmController::class, 'saveVisibleColumns'])->middleware(['auth', 'verified'])->name('crm.visible-columns.save');
    Route::post('crm/custom-fields', [App\Http\Controllers\CrmController::class, 'storeCustomField'])->middleware(['auth', 'verified'])->name('crm.custom-fields.store');
    Route::put('crm/custom-fields/{id}', [App\Http\Controllers\CrmController::class, 'updateCustomField'])->middleware(['auth', 'verified'])->name('crm.custom-fields.update');
    Route::delete('crm/custom-fields/{id}', [App\Http\Controllers\CrmController::class, 'destroyCustomField'])->middleware(['auth', 'verified'])->name('crm.custom-fields.destroy');
    Route::post('crm/tags', [App\Http\Controllers\CrmController::class, 'storeTag'])->middleware(['auth', 'verified'])->name('crm.tags.store');
    Route::put('crm/tags/{id}', [App\Http\Controllers\CrmController::class, 'updateTag'])->middleware(['auth', 'verified'])->name('crm.tags.update');
    Route::delete('crm/tags/{id}', [App\Http\Controllers\CrmController::class, 'destroyTag'])->middleware(['auth', 'verified'])->name('crm.tags.destroy');

    Route::get('stripe', [App\Http\Controllers\StripePaymentController::class, 'stripe'])->middleware(['auth','verified'])->name('stripe');
    Route::post('stripe', [App\Http\Controllers\StripePaymentController::class, 'stripePost'])->middleware(['auth','verified'])->name('stripe.post');
    Route::post('ajax-stripeCancel', [App\Http\Controllers\StripePaymentController::class, 'stripeCancel'])->middleware(['auth','verified'])->name('stripe.cancel');

    Route::get('generate-bill-pdf', [App\Http\Controllers\PDFController::class, 'generateBillPDF'])->middleware(['auth','verified'])->name('generate-bill-pdf');

    Route::post('ajax-getChartData',            [App\Http\Controllers\DashboardController::class, 'getChartData'])->middleware(['auth'])->name('getChartData');
    Route::post('ajax-getTagOptionData',        [App\Http\Controllers\DashboardController::class, 'getTagOptionData'])->middleware(['auth'])->name('getTagOptionData');
    Route::post('ajax-getInteractionTableData', [App\Http\Controllers\DashboardController::class, 'getInteractionTableData'])->middleware(['auth'])->name('getInteractionTableData');
    Route::post('ajax-saveDateFilter',     [App\Http\Controllers\DashboardController::class, 'saveDateFilter']);

    Route::post('ajax-save-session-data', [App\Http\Controllers\DashboardController::class, 'saveSessionData'])->middleware(['auth'])->name('saveSessionData');


    // Email related routes
    Route::post('sendForm', [App\Http\Controllers\MailController::class, 'sendForm']);


    //CRM
    Route::post('crm-register', [App\Http\Controllers\CrmController::class, 'crmregister']);

    //Route::get('mailTest', [App\Http\Controllers\MailController::class, 'send']);
    // https://code.tutsplus.com/tutorials/how-to-send-emails-in-laravel--cms-30046
    // https://app.playfunnel.net/mail/send

    Route::get('duplicate', function (Request $request) {
        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }

        if (!$request->project){
            return redirect()->guest(route('projects'));
        }

        $project = Project::where('id', $request->project)->where('user_id', Auth::id())->first();

        if(!$project){
            return redirect()->guest(route('projects'));
        }

        $newProject = $project->replicate();
        $newProject->name = substr('Duplicado de: ' . $project->name, 0, 30);
        $newProject->creation_date =  Carbon::now();
        $newProject->save();

        $oldLanding = $newProject->landing_page;

        if($oldLanding){
        	$oldProjectCode = "embed?project=".openssl_encrypt($request->project, $ciphering = 'AES-128-CTR', $encryption_key = 'PlayFunnel', $options = 0, $encryption_iv = '1234567891011121');
        	$newProjectCode = "embed?project=".openssl_encrypt($newProject->id, $ciphering = 'AES-128-CTR', $encryption_key = 'PlayFunnel', $options = 0, $encryption_iv = '1234567891011121');
        	Log::debug('duplicate() landing Codigo Proyecto Origen: ' . $oldProjectCode);
        	Log::debug('duplicate() landing Codigo Proyecto Destino: ' . $newProjectCode);

        	$newLanding = str_replace($oldProjectCode, $newProjectCode, $oldLanding);

        	$newProject->landing_page = $newLanding;
        	$newProject->project_status_id = 0;
        	$newProject->save();
        }

        $projectLibSet = $project->projectLibrary;

        if($projectLibSet && count($projectLibSet)>0){
            foreach ($projectLibSet as $projectLib) {
                $newProjectLib = $projectLib->replicate();
                $newProjectLib->projectid = $newProject->id;
                $newProjectLib->save();


                $cuepointSet = $projectLib->cuePoints;

                if($cuepointSet  && count($cuepointSet)>0){
                    foreach ($cuepointSet as $cuePoint) {
                        $newCuePoint = $cuePoint->replicate();
                        $newCuePoint->projectid = $newProject->id;
                        $newCuePoint->projectlibraryid = $newProjectLib->id;
                        $newCuePoint->save();

                        $typeBrowse = $cuePoint->typeBrowse;

                        if($typeBrowse){
                            $typeBrowse = $typeBrowse->first();
                            $newTypeBrowse = $typeBrowse->replicate();
                            $newTypeBrowse->projectid = $newProject->id;
                            $newTypeBrowse->cuepointid = $newCuePoint->id;
                            $newTypeBrowse->save();
                        }


                        $typeOption = $cuePoint->typeOption;

                        if($typeOption){
                            $typeOption = $typeOption->first();
                            $newTypeOption = $typeOption->replicate();
                            $newTypeOption->projectid = $newProject->id;
                            $newTypeOption->cuepointid = $newCuePoint->id;
                            $newTypeOption->save();

                            $optionDataSet = $typeOption->typeOptionData;
                            if($optionDataSet && count($optionDataSet)>0){
                                foreach ($optionDataSet as $optionData) {

                                    $newOptionData = $optionData->replicate();
                                    $newOptionData->projectid = $newProject->id;
                                    $newOptionData->cuepointid = $newCuePoint->id;
                                    $newOptionData->save();
                                }
                            }
                        }

                        $typeForm = $cuePoint->typeForm;

                        if($typeForm){
                            $typeForm = $typeForm->first();
                            $newTypeForm = $typeForm->replicate();
                            $newTypeForm->projectid = $newProject->id;
                            $newTypeForm->cuepointid = $newCuePoint->id;
                            $newTypeForm->save();

                            $formDataSet = $typeForm->typeFormData;
                            if($formDataSet && count($formDataSet)){
                                foreach ($formDataSet as $formData) {
                                    Log::debug('Datos Formulario: ' . $formData );
                                    $newFormData = $formData->replicate();
                                    $newFormData->projectid = $newProject->id;
                                    $newFormData->cuepointid = $newCuePoint->id;
                                    $newFormData->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        return redirect()->guest(route('projects'));

    })->middleware(['auth','verified'])->name('duplicate');

});
