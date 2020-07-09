<?php

namespace App\Game\Traits;

trait PresentableAction {

    /**
     * @var string $code
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var integer $userChance
     */
    private $userChance = 0;

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function getCode() : ?string
    {
        return $this->code;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setUserChance(int $userChance)
    {
        $this->userChance = $userChance;
    }

    public function getUserChance() : string
    {
        return $this->userChance . "%";
    }
}