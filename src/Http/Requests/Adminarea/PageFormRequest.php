<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Requests\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class PageFormRequest extends FormRequest
{
    use Escaper;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $page = $this->route('page') ?? app('rinvex.pages.page');
        $page->updateRulesUniques();

        return $page->getRules();
    }
}
