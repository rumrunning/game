<?php

namespace App\Game\Presenters;

use App\Game\Collections\ActionCollection;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\PlayerContract;

class ActionsPresenter {

    /**
     * @var ActionCollection $actions
     */
    private $actions;

    /**
     * ActionsPresenter constructor.
     * @param array $actions
     */
    public function __construct(ActionCollection $actions)
    {
        $this->actions = $actions;
    }

    public function calculatedChancesAs(PlayerContract $player) : array
    {
        $presentable = $this->actions->map(function (ActionContract $action) use ($player) {
            $actionPresenter = $action->getPresenter();
            $chance = $player->getActionChanceCalculator($action)->getActionPercentage($action);

            $actionPresenter->setUserChance($chance);

            return $actionPresenter->toArray();
        })->all();

        return $presentable;
    }
}