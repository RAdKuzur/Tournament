<?php

namespace App\Components\widget;

class DynamicFormWidget
{
    public const TEXT = 0;
    public const DROPDOWN = 1;
    public $attribute;
    public function render($type = self::TEXT)
    {
        switch ($type) {
            case self::TEXT:
                return view('widget.dynamic-form', [
                    'attribute' => $this->attribute
                ]);
            case self::DROPDOWN:
                return view('widget.dynamic-dropdown-form', [
                    'attribute' => $this->attribute
                ]);
        }

    }
}
