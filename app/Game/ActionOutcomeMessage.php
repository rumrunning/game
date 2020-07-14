<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;

class ActionOutcomeMessage {

    private $action;

    private $outcome;

    /**
     * ActionOutcomeMessage constructor.
     * @param ActionContract $action
     * @param Outcome $outcome
     */
    public function __construct(ActionContract $action, Outcome $outcome)
    {
        $this->action = $action;
        $this->outcome = $outcome;
    }

    public function output() : string
    {
        if ($this->outcome->wasSuccessful()) {
            return $this->successMessage();
        }

        return $this->failureMessage();
    }

    private function successMessage() : string
    {
        return "You successfully " . $this->action->getDescription();
    }

    private  function failureMessage() : string
    {
        return "You failed to " . $this->action->getDescription();
    }
}