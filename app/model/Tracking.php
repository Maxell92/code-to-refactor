<?php

namespace App\Model;

use DataMapper\Mapper;

class Tracking
{

    /** @var Mapper */
    private $mapper;

    /** @var ClIdentity */
    private $clIdentity;

    public function __construct(Mapper $mapper, ClIdentity $clIdentity)
    {
        $this->mapper = $mapper;
        $this->clIdentity = $clIdentity;
    }

    /**
     * @return \DateTime|NULL
     */
    public function getRunningTracking()
    {
        return $this->mapper
          ->getDb()
          ->select('dt')
          ->from('tracking')
          ->where("person_id = %i AND [in] IS NULL", $this->clIdentity->getPersonId())
          ->execute()
          ->fetchSingle();
    }

}
