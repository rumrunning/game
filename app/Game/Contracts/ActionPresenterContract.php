<?php

namespace App\Game\Contracts;

interface ActionPresenterContract {

    public function setCode(string $code);

    public function getCode() : ?string;

    public function setDescription(string $description);

    public function getDescription() : ?string;

    public function setUserChance(int $userChance);

    public function getUserChance() : string;
}