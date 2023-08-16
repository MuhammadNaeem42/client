<?php

namespace App\StateMachines;

use App\Exceptions\TransitionNotAllowedException;
use Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class StatusStateApplication extends StateMachine
{
    const APPLICATION = 'application';
    const CANCEL_APPLICATION = 'cancel_application';
    const RESERVATION = 'reservation'; // Reservation
    const PRINT_SPONSOR_RECEIPT = 'print_sponsor_receipt'; // Print Sponsor Receipt
    const VISA = 'visa'; // Visa
    const EXPECTED_ARRIVAL = 'expected_arrival'; // Expected ApplicationArrival
    const ARRIVAL = 'arrival'; // ApplicationArrival
    const DELIVER_PAID_FULL = 'deliver_paid_full'; // Delivered Paid Full
    const DELIVER_PAID_PARTIAL = 'deliver_paid_partial'; // Delivered Paid Partial
    const RESELL = 'resell'; // Re-Sell
    const RETURN_BACK = 'return_back'; // Return Back From First Sponsor
    const SELL_AS_TEST = 'sell_as_test'; // Sell As Test
    const SELL_AS_FINAL = 'sell_as_final'; // Sell As Final
    const REJECTED_BY_SPONSOR = 'rejected_by_sponsor'; // Rejected By Sponsor
    const RETURN_BACK_AGAIN = 'return_back_again'; // Return Back From Last Sponsor
    const BACK_TO_COUNTRY = 'back_to_country'; // Back to Country After First Sponsor
    const BACK_TO_COUNTRY_AGAIN = 'back_to_country_again'; // Back to Country After Last Sponsor
    const DEPORTATION = 'deportation'; // Back to Country


    const STATES = [
        self::APPLICATION,
        self::CANCEL_APPLICATION,
        self::RESERVATION,
        self::PRINT_SPONSOR_RECEIPT,
        self::VISA,
        self::DEPORTATION,
        self::EXPECTED_ARRIVAL,
        self::ARRIVAL,
        self::DELIVER_PAID_FULL,
        self::DELIVER_PAID_PARTIAL,
        self::RESELL,
        self::RETURN_BACK,
        self::SELL_AS_TEST,
        self::SELL_AS_FINAL,
        self::REJECTED_BY_SPONSOR,
        self::RETURN_BACK_AGAIN,
        self::BACK_TO_COUNTRY,
        self::BACK_TO_COUNTRY_AGAIN,
        self::DEPORTATION,
    ];

    public function transitions(): array
    {
        return [
            self::APPLICATION => [self::CANCEL_APPLICATION, self::RESERVATION],
            self::CANCEL_APPLICATION => [self::APPLICATION],
            self::RESERVATION => [self::APPLICATION, self::VISA , self::DEPORTATION],
            self::VISA => [self::RESERVATION , self::EXPECTED_ARRIVAL ,self::DEPORTATION],
            self::EXPECTED_ARRIVAL => [self::VISA , self::ARRIVAL , self::DEPORTATION],
            self::ARRIVAL => [self::EXPECTED_ARRIVAL, self::RESELL, self::DELIVER_PAID_FULL, self::DELIVER_PAID_PARTIAL , self::DEPORTATION],
            self::DEPORTATION => [self::ARRIVAL],
            self::DELIVER_PAID_FULL => [self::ARRIVAL , self::RESELL],
            self::DELIVER_PAID_PARTIAL => [self::ARRIVAL , self::RESELL],
            self::RESELL => [self::RESERVATION],
        ];
    }

    public function defaultState(): ?string
    {
        return self::APPLICATION;
    }

    /**
     * @param $from
     * @param $to
     * @param array $customProperties
     * @param null|mixed $responsible
     * @throws TransitionNotAllowedException
     * @throws ValidationException
     */
    public function transitionTo($from, $to, $customProperties = [], $responsible = null)
    {
        if ($to === $this->currentState()) {
            return;
        }

        if (!$this->canBe($from, $to)) {
            throw new TransitionNotAllowedException($from, $to, get_class($this->model));
        }

        $validator = $this->validatorForTransition($from, $to, $this->model);
        if ($validator !== null && $validator->fails()) {
            throw new ValidationException($validator);
        }

        $beforeTransitionHooks = $this->beforeTransitionHooks()[$from] ?? [];

        collect($beforeTransitionHooks)
            ->each(function ($callable) use ($to) {
                $callable($to, $this->model);
            });

        $field = $this->field;
        $this->model->$field = $to;

        $changedAttributes = $this->model->getChangedAttributes();

        $this->model->save();

        if ($this->recordHistory()) {
            $responsible = $responsible ?? auth()->user();

            $this->model->recordState($field, $from, $to, $customProperties, $responsible, $changedAttributes);
        }

        $afterTransitionHooks = $this->afterTransitionHooks()[$to] ?? [];

        collect($afterTransitionHooks)
            ->each(function ($callable) use ($from) {
                $callable($from, $this->model);
            });

        $this->cancelAllPendingTransitions();
    }

    public function recordHistory(): bool
    {
        return true;
    }

    /**
     * @param $from
     * @param $to
     * @param Carbon $when
     * @param array $customProperties
     * @param null $responsible
     * @return null|PendingTransition
     * @throws TransitionNotAllowedException
     */
    public function postponeTransitionTo($from, $to, Carbon $when, $customProperties = [], $responsible = null): ?PendingTransition
    {
        if ($to === $this->currentState()) {
            return null;
        }

        if (!$this->canBe($from, $to)) {
            throw new TransitionNotAllowedException($from, $to, get_class($this->model));

        }

        $responsible = $responsible ?? auth()->user();

        return $this->model->recordPendingTransition(
            $this->field,
            $from,
            $to,
            $when,
            $customProperties,
            $responsible
        );
    }


}



