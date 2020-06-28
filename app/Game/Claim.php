<?php

namespace App\Game;

use App\Game\Contracts\CollectableContract;

class Claim {

    private $collectable;

    private $value;

    /**
     * Claim constructor.
     * @param $collectable
     */
    public function __construct(CollectableContract $collectable)
    {
        $this->collectable = $collectable;

        $this->value = $this->collectable->collect();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return CollectableContract
     */
    public function getCollectable(): CollectableContract
    {
        return $this->collectable;
    }
}