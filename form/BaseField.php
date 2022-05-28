<?php

namespace paul_core\paul_core\form;

use paul_core\paul_core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput(): string;
    public function __toString()
    {
        return sprintf('
            <label>%s</label>
            %s
            <div class="invalid-feedback">
                %s
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}