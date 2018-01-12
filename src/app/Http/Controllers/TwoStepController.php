<?php

namespace jeremykenedy\laravel2step\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\App\Traits\Laravel2StepTrait;


use Illuminate\Support\Facades\Log;

class TwoStepController extends Controller
{
    use Laravel2StepTrait;

    private $_user;
    private $_twoStepAuth;
    private $_authCount;
    private $_authStatus;
    private $_remainingAttempts;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next)
        {
            $this->setUser2StepData();

            return $next($request);
        });
    }

    /**
     * Set the User2Step Variables
     */
    private function setUser2StepData()
    {
        $user                       = Auth::User();
        $twoStepAuth                = $this->getTwoStepAuthStatus($user->id);
        $authCount                  = $twoStepAuth->authCount;
        $this->_user                = $user;
        $this->_twoStepAuth         = $twoStepAuth;
        $this->_authCount           = $authCount;
        $this->_authStatus          = $twoStepAuth->authStatus;
        $this->_remainingAttempts   = config('laravel2step.laravel2stepExceededCount') - $authCount;
    }

    /**
     * Show the twostep verification form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVerification()
    {
        $twoStepAuth        = $this->_twoStepAuth;
        $authStatus         = $this->_authStatus;

        if ($this->checkExceededTime($twoStepAuth->updated_at)) {
            $this->resetExceededTime($twoStepAuth);
        }

        $data = [
            'user'              => $this->_user,
            'remainingAttempts' => $this->_remainingAttempts + 1,
        ];

        if ($this->_authCount > config('laravel2step.laravel2stepExceededCount')) {

            $exceededTimeDetails = $this->exceededTimeParser($twoStepAuth->updated_at);

            $data['timeUntilUnlock']     = $exceededTimeDetails['tomorrow'];
            $data['timeCountdownUnlock'] = $exceededTimeDetails['remaining'];

            return View('laravel2step::twostep.exceeded')->with($data);
        }

        return View('laravel2step::twostep.verification')->with($data);
    }

    /**
     * [verify description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function verify(Request $request)
    {
        if($request->ajax()) {

            // @TODO: NEW RULES & VALIDATION

            $code       = $request->v_input_1 . $request->v_input_2 . $request->v_input_3 . $request->v_input_4;
            $validCode  = $this->_twoStepAuth->authCode;

            if ($validCode != $code) {

                $this->_authCount = $this->_twoStepAuth->authCount += 1;
                $this->_twoStepAuth->save();

                $returnData = [
                    'message'           => trans('laravel2step::laravel-verification.titleFailed'),
                    'authCount'         => $this->_authCount,
                    'remainingAttempts' => $this->_remainingAttempts,
                ];

                return response()->json($returnData, 418);
            }

            $this->resetActivationCountdown($this->_twoStepAuth);

            $returnData = [
                'nextUri' => session('nextUri', '/'),
                'message' => trans('laravel2step::laravel-verification.titlePassed'),
            ];

            return response()->json($returnData, 200);

        }

        else {
            abort(404);
        }
    }

}
