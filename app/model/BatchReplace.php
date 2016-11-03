<?php

namespace DataMapper;

class BatchReplace
{
    /** @var \DataMapper\Mapper */
    private $mapper;

    /** @var array */
    private $data;

    /** @var string */
    private $field;

    /** @var \DataMapper\Entity */
    private $entity;

    /** @var array */
    private $keyReplacements = array();

    public function __construct(\DataMapper\Mapper $mapper, array $data, $field)
    {
        $this->mapper = $mapper;

        $this->data = $data;

        $this->field = $field;
    }


    public function setEntityScope(\DataMapper\Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function setKeyReplacements($keyReplacements)
    {
        $this->keyReplacements = $keyReplacements;
    }

    public function save()
    {
        if($this->entity !== NULL) {
            $this->mapper->scope($this->entity);
        }

        foreach($this->data as &$value) {
            if(isset($this->keyReplacements[$value])) {
                $value = $this->keyReplacements[$value];
            }
        }

        $this->mapper->replace($this->data, $this->field);

        return array();
    }
}