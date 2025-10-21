<?php

namespace jeremykenedy\laravel2step\App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\App\Notifications\SendVerificationCodeEmail;

trait Laravel2StepTrait
{
    /**
     * Check if the user is authorized.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function twoStepVerification($request)
    {
        $user = Auth::User();

        if ($user) {
            $twoStepAuthStatus = $this->checkTwoStepAuthStatus($user->id);

            if ($twoStepAuthStatus->authStatus !== true) {
                return false;
            } else {
                if ($this->checkTimeSinceVerified($twoStepAuthStatus)) {
                    return false;
                }
            }

            return true;
        }

        return true;
    }

    /**
     * Check time since user was last verified and take apprpriate action.
     *
     * @param collection $twoStepAuth
     *
     * @return bool
     */
    private function checkTimeSinceVerified($twoStepAuth)
    {
        $expireMinutes = (int) config('laravel2step.laravel2stepVerifiedLifetimeMinutes');
        $now = Carbon::now();
        $expire = Carbon::parse($twoStepAuth->authDate)->addMinutes($expireMinutes);
        $expired = $now->gt($expire);

        if ($expired) {
            $this->resetAuthStatus($twoStepAuth);

            return true;
        }

        return false;
    }

    /**
     * Reset TwoStepAuth collection item and code.
     *
     * @param collection $twoStepAuth
     *
     * @return collection
     */
    private function resetAuthStatus($twoStepAuth)
    {
        $twoStepAuth->authCode = $this->generateCode();
        $twoStepAuth->authCount = 0;
        $twoStepAuth->authStatus = 0;
        $twoStepAuth->authDate = null;
        $twoStepAuth->requestDate = null;

        $twoStepAuth->save();

        return $twoStepAuth;
    }

    /**
     * Generate Authorization Code.
     *
     * @param int    $length
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    private function generateCode(int $length = 4, string $prefix = '', string $suffix = '')
    {
        for ($i = 0; $i < $length; $i++) {
            $prefix .= random_int(0, 1) ? chr(random_int(65, 90)) : random_int(0, 9);
        }

        return $prefix.$suffix;
    }

    /**
     * Create/retreive 2step verification object.
     *
     * @param int $userId
     *
     * @return collection
     */
    private function checkTwoStepAuthStatus(int $userId)
    {
        $twoStepAuth = TwoStepAuth::firstOrCreate(
            [
                'userId' => $userId,
            ],
            [
                'userId'    => $userId,
                'authCode'  => $this->generateCode(),
                'authCount' => 0,
            ]
        );

        return $twoStepAuth;
    }

    /**
     * Retreive the Verification Status.
     *
     * @param int $userId
     *
     * @return collection || void
     */
    protected function getTwoStepAuthStatus(int $userId)
    {
        return TwoStepAuth::where('userId', $userId)->firstOrFail();
    }

    /**
     * Format verification exceeded timings with Carbon.
     *
     * @param string $time
     *
     * @return collection
     */
    protected function exceededTimeParser($time)
    {
        $exceededCountdownMinutes = (int) config('laravel2step.laravel2stepExceededCountdownMinutes');
        $exceededTime = Carbon::parse($time)->addMinutes($exceededCountdownMinutes);
        $tomorrow = $exceededTime->format('l, F jS Y h:i:sa');
        $remaining = $exceededTime->diffForHumans(null, true);

        $data = [
            'tomorrow'  => $tomorrow,
            'remaining' => $remaining,
        ];

        return collect($data);
    }

    /**
     * Check if time since account lock has expired and return true if account verification can be reset.
     *
     * @param string $time
     *
     * @return bool
     */
    protected function checkExceededTime($time)
    {
        $now = Carbon::now();
        $exceededCountdownMinutes = (int) config('laravel2step.laravel2stepExceededCountdownMinutes');
        $expire = Carbon::parse($time)->addMinutes($exceededCountdownMinutes);
        $expired = $now->gt($expire);

        if ($expired) {
            return true;
        }

        return false;
    }

    /**
     * Method to reset code and count.
     *
     * @param collection $twoStepEntry
     *
     * @return collection
     */
    protected function resetExceededTime($twoStepEntry)
    {
        $twoStepEntry->authCount = 0;
        $twoStepEntry->authCode = $this->generateCode();
        $twoStepEntry->save();

        return $twoStepEntry;
    }

    /**
     * Successful activation actions.
     *
     * @param collection $twoStepAuth
     *
     * @return void
     */
    protected function resetActivationCountdown($twoStepAuth)
    {
        $twoStepAuth->authCode = $this->generateCode();
        $twoStepAuth->authCount = 0;
        $twoStepAuth->authStatus = 1;
        $twoStepAuth->authDate = Carbon::now();
        $twoStepAuth->requestDate = null;

        $twoStepAuth->save();
    }

    /**
     * Send verification code via notify.
     *
     * @param array  $user
     * @param string $deliveryMethod (nullable)
     * @param string $code
     *
     * @return void
     */
    protected function sendVerificationCodeNotification($twoStepAuth, $deliveryMethod = null)
    {
        $user = Auth::User();
        if ($deliveryMethod === null) {
            $user->notify(new SendVerificationCodeEmail($user, $twoStepAuth->authCode));
        }
        $twoStepAuth->requestDate = Carbon::now();

        $twoStepAuth->save();
    }
}
