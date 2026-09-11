<?php

declare(strict_types=1);

namespace jeremykenedy\laravel2step\Test\Support;

use Illuminate\Support\Collection;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\App\Traits\Laravel2StepTrait;

/**
 * Exposes the trait internals so they can be exercised directly.
 */
class TwoStepTester
{
    use Laravel2StepTrait;

    public function makeCode(int $length = 4, string $prefix = '', string $suffix = ''): string
    {
        return $this->generateCode($length, $prefix, $suffix);
    }

    public function findOrCreateStatus(int $userId): TwoStepAuth
    {
        return $this->checkTwoStepAuthStatus($userId);
    }

    public function findStatus(int $userId): TwoStepAuth
    {
        return $this->getTwoStepAuthStatus($userId);
    }

    public function resetStatus(TwoStepAuth $twoStepAuth): TwoStepAuth
    {
        return $this->resetAuthStatus($twoStepAuth);
    }

    public function verificationHasExpired(TwoStepAuth $twoStepAuth): bool
    {
        return $this->checkTimeSinceVerified($twoStepAuth);
    }

    public function lockHasExpired(string $time): bool
    {
        return $this->checkExceededTime($time);
    }

    public function parseExceededTime(string $time): Collection
    {
        return $this->exceededTimeParser($time);
    }

    public function resetLock(TwoStepAuth $twoStepAuth): TwoStepAuth
    {
        return $this->resetExceededTime($twoStepAuth);
    }

    public function activate(TwoStepAuth $twoStepAuth): void
    {
        $this->resetActivationCountdown($twoStepAuth);
    }

    public function sendCode(TwoStepAuth $twoStepAuth): void
    {
        $this->sendVerificationCodeNotification($twoStepAuth);
    }
}
