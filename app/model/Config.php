<?php

namespace App\Model;

class Config
{

    /** @var string */
    private $loc;

    /** @var string */
    private $app;

    public function __construct($loc, $app)
    {
        $this->loc = $loc;
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function getLoc(): string
    {
        return $this->loc;
    }

    /**
     * @return string
     */
    public function getApp(): string
    {
        return $this->app;
    }

}
