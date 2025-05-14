<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LoanProductFormField extends Component
{
    public $field;
    public $value;

    public function __construct($field, $value = null)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.loan-product-form-field');
    }
}
