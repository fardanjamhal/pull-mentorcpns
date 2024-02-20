<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\PhysicalCalculationRequest;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? [];
        if($setting && $setting->theme != 0) {
            return view('landing_page.theme_'.$setting->theme.'.index', compact('setting'));
        } else {
            return redirect()->route('login');
        }
    }

    public function physicalCalculation()
    {
        return view('landing_page.theme_2.physical_calculation');
    }

    public function physicalCalculate(PhysicalCalculationRequest $request)
    {
        $sex = $request->sex;
        
        $resultRunning = str_replace(",", ".",  $request->running);
        $resultPullUp = str_replace(",", ".",  $request->pull_up);
        $resultChinning = str_replace(",", ".",  $request->chinning);
        $resultSitUp = str_replace(",", ".",  $request->sit_up);
        $resultPushUp = str_replace(",", ".",  $request->push_up);
        $resultShuttleRun = str_replace(",", ".",  $request->shuttle_run);
        $resultSwimming = str_replace(",", ".",  $request->swimming);

        $gradeRunning = 0;
        $gradePullUp = 0;
        $gradeChinning = 0;
        $gradeSitUp = 0;
        $gradePushUp = 0;
        $gradeShuttleRun = 0;
        $gradeSwimming = 0;

        $runningData = json_decode(file_get_contents(public_path('assets/physical-calculate/running.json')));
        $pullUpData = json_decode(file_get_contents(public_path('assets/physical-calculate/pull_up.json')));
        $chinningData = json_decode(file_get_contents(public_path('assets/physical-calculate/chinning.json')));
        $sitUpData = json_decode(file_get_contents(public_path('assets/physical-calculate/sit_up.json')));
        $pushUpData = json_decode(file_get_contents(public_path('assets/physical-calculate/push_up.json')));
        $shuttleRunData = json_decode(file_get_contents(public_path('assets/physical-calculate/shuttle_run.json')));

        $swimmingData = json_decode(file_get_contents(public_path('assets/physical-calculate/swimming.json')));

        $gradeRunning = array_reduce($runningData, function ($carry, $running) use ($sex, $resultRunning) {
            if ($running->sex == $sex && $resultRunning >= $running->result) {
                return $running->grade;
            }
            return $carry;
        }, 0);

        $gradePullUp = array_reduce($pullUpData, function ($carry, $pullUp) use ($sex, $resultPullUp) {
            if ($pullUp->sex == $sex && $resultPullUp >= $pullUp->result) {
                return $pullUp->grade;
            }
            return $carry;
        }, 0);

        $gradeChinning = array_reduce($chinningData, function ($carry, $chinning) use ($sex, $resultChinning) {
            if ($chinning->sex == $sex && $resultChinning >= $chinning->result) {
                return $chinning->grade;
            }
            return $carry;
        }, 0);

        $gradeSitUp = array_reduce($sitUpData, function ($carry, $sitUp) use ($sex, $resultSitUp) {
            if ($sitUp->sex == $sex && $resultSitUp >= $sitUp->result) {
                return $sitUp->grade;
            }
            return $carry;
        }, 0);

        $gradePushUp = array_reduce($pushUpData, function ($carry, $pushUp) use ($sex, $resultPushUp) {
            if ($pushUp->sex == $sex && $resultPushUp >= $pushUp->result) {
                return $pushUp->grade;
            }
            return $carry;
        }, 0);

        $gradeShuttleRun = $this->shuttleRunGrade($resultShuttleRun, $sex, $shuttleRunData);

        $gradeSwimming = $this->swimmingGrade($resultSwimming, $sex, $swimmingData);


        $samaptaA = $gradeRunning;
        $samaptaB = (($sex == 1 ? $gradePullUp : $gradeChinning) + $gradeSitUp + $gradePushUp + $gradeShuttleRun) / 4;
        $gradeSamapta = ($gradeRunning + $samaptaB) / 2;

        // return $gradeRunning;
        return view('landing_page.theme_2.physical_calculation')->with([
            'sex' => $request->sex,
            'running' => $request->running,
            'pull_up' => $request->pull_up,
            'chinning' => $request->chinning,
            'sit_up' => $request->sit_up,
            'push_up' => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'swimming' => $request->swimming,

            'gradeRunning' => $gradeRunning,
            'gradePullUp' => $gradePullUp,
            'gradeChinning' => $gradeChinning,
            'gradeSitUp' => $gradeSitUp,
            'gradePushUp' => $gradePushUp,
            'gradeShuttleRun' => $gradeShuttleRun,
            'gradeSwimming' => $gradeSwimming,
            "gradeSamaptaA" => $gradeRunning,
            "gradeSamaptaB" => $samaptaB,
            "finalSamapta" => $gradeSamapta,
            "finalSwimming" => $gradeSwimming,
            "finalGrade" => (($gradeSamapta * 70) + ($gradeSwimming * 30)) / 100, 
        ]);
    }

    function shuttleRunGrade($result, $sex, $shuttleRunGrades) {
        $grade = 100;
    
        foreach ($shuttleRunGrades as $index => $number) {
            if ($result >= $number->result && $number->sex == $sex) {
                $grade = $number->grade;
                break;
            }
        }
    
        if (empty($result) || $result == 0) {
            $grade = 0;
        }
    
        return $grade;
    }

    function swimmingGrade($result, $sex, $swimmingGrades) {
        $grade = 100;
    
        foreach ($swimmingGrades as $index => $number) {
            if ($result >= $number->result && $number->sex == $sex) {
                $grade = $number->grade;
                break;
            }
        }
    
        if (empty($result) || $result == 0) {
            $grade = 0;
        }
    
        return $grade;
    }
}
