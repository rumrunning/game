<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\CollectableContract;
use App\Game\Contracts\PlayerContract;

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

        $this->value = $this->collectable->prepareForCollection();
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