<?php

namespace App\Game\Contracts;

interface ActionContract {

    public function getDescription();

    public function getRewards();

    public function getPunishments();

    public function getDifficulty();
}