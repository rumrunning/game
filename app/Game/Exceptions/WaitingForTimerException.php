<?php

namespace App\Game\Exceptions;

use App\Game\Contracts\ActionContract;
use Illuminate\Http\Request;

class WaitingForTimerException extends \Exception {

    /**
     * @var string $timer
     */
    private $timer;

    /**
     * @return ActionContract
     */
    public function getAction(): ActionContract
    {
        return $this->action;
    }

    /**
     * @param ActionContract $action
     */
    public function setAction(ActionContract $action): void
    {
        $this->action = $action;
    }

    /**
     * @var ActionContract $action
     */
    private $action;

    /**
     * @return string
     */
    public function getTimer(): string
    {
        return $this->timer;
    }

    /**
     * @param string $timer
     */
    public function setTimer(string $timer): void
    {
        $this->timer = $timer;
    }

    public function render(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'You must wait 30 seconds between each crime']);
        }
    }
}