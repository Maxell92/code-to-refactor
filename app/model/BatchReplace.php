<?php

namespace App\Model\DataMapper;

use DataMapper\Mapper;
use DataMapper\Entity;

class BatchReplace
{
    /** @var Mapper */
    private $mapper;

    /** @var Entity */
    private $entity;

    /** @var array */
    private $data;

    /** @var string */
    private $field;

    /** @var array */
    private $keyReplacements = [];

    public function __construct(Mapper $mapper, array $data, $field)
    {
        $this->mapper = $mapper;

        $this->data = $data;

        $this->field = $field;
    }


    public function setEntityScope(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @param array $keyReplacements
     * @deprecated
     */
    public function setKeyReplacements(array $keyReplacements)
    {
        trigger_error(__METHOD__ . '() is deprecated; use $this->addReplacement($what, $to) instead.', E_USER_DEPRECATED);
        $this->keyReplacements = $keyReplacements;
    }

    public function addReplacement($what, $to)
    {
        $this->keyReplacements[$what] = $to;
    }

    public function save()
    {
        if($this->entity !== NULL) {
            $this->mapper->scope($this->entity);
        }

        foreach($this->data as $key => $value) {
            if(!isset($this->keyReplacements[$value])) {
                continue;
            }
            $this->data[$key] = $this->keyReplacements[$value];
        }

        $this->mapper->replace($this->data, $this->field);

        return array();
    }
}
