<?php

namespace App\Http\Controllers\Game;

use App\Game\ActionOutcomeMessage;
use App\Game\ChanceCalculators\HundredChanceCalculator;
use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\GameContract;
use App\Game\Presenters\ActionsPresenter;
use App\Http\Controllers\Controller;
use App\RumRunning\Crimes\Exceptions\NoSuchCrimeAvailable;
use Illuminate\Http\Request;

class CrimeController extends Controller  {

    private $game;

    private $request;

    public function __construct(GameContract $game, Request $request)
    {
        $this->game = $game;

        $this->request = $request;
    }

    public function index()
    {
        $crimes = $this->game->crimes();
        $player = $this->request->user();

        return (new ActionsPresenter($crimes))->calculatedChancesAs($player);
    }

    public function commit(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $crimes = $this->game->crimes();
        $crime = $crimes->select($request->get('code', -1));

        $player = $request->user();
        $outcome = $player->attemptCrime($crime);

        $responseData = [
            'success' => $outcome->wasSuccessful(),
            'message' => (new ActionOutcomeMessage($crime, $outcome))->output(),
        ];

        if ($request->wantsJson()) {
            return $responseData;
        }

        return redirect()->back()->with($responseData);
    }
}
