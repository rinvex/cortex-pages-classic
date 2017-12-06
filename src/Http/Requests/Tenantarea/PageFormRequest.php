<?php

declare(strict_types=1);

namespace Cortex\Pages\Http\Requests\Tenantarea;

use Illuminate\Foundation\Http\FormRequest;

class PageFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = $this->all();

        $data['domain'] = $this->getHost();

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $page = $this->route('page') ?? app('rinvex.pages.page');
        $page->updateRulesUniques();

        return $page->getRules();
    }
}
