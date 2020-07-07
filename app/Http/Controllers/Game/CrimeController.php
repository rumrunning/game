<?php

namespace App\Http\Controllers\Game;

use App\Game\ActionOutcomeMessage;
use App\Game\ChanceCalculators\HundredChanceCalculator;
use App\Game\Contracts\GameContract;
use App\Http\Controllers\Controller;
use App\RumRunning\Crimes\Exceptions\NoSuchCrimeAvailable;
use Illuminate\Http\Request;

class CrimeController extends Controller  {

    private $game;

    public function __construct(GameContract $game)
    {
        $this->game = $game;
    }

    public function index(Request $request)
    {
        return $this->game->crimes()->withCalculatedChances(static::getChanceCalculator());
    }

    public function commit(Request $request)
    {
        $request->validate([
            'crime' => ['required'],
        ]);

        $crimes = $this->game->crimes();
        $crime = $crimes->select($request->get('crime', -1));

        $player = $request->user();
        $outcome = $player->attemptCrime($crime, static::getChanceCalculator());

        $player->collectClaimsFor($crime, $outcome->claims());

        $responseData = [
            'success' => $outcome->wasSuccessful(),
            'message' => (new ActionOutcomeMessage($crime, $outcome))->output(),
        ];

        if ($request->wantsJson()) {
            return $responseData;
        }

        return redirect()->back()->with($responseData);
    }

    private static function getChanceCalculator()
    {
        return new HundredChanceCalculator();
    }
}
