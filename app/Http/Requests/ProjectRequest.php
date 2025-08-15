<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    // id_project format: PYYLNNN where YY = last two digits of year, L = A-L for month, NNN = sequence
    $idProjectRules = ['required', 'string', 'regex:/^P\d{2}[A-L]\d{3}$/'];

    if ($this->isMethod('post')) {
      $idProjectRules[] = 'unique:projects,id_project';
    } else {
      // For update, ignore the current id_project value
      $current = $this->route('project') ?? $this->route('id_project');
      $idProjectRules[] = Rule::unique('projects', 'id_project')->ignore($current, 'id_project');
    }

    return [
      'id_project' => $idProjectRules,
      'customer_name' => 'required|string|max:255',
      'project_name' => 'required|string|max:255',
      'location' => 'required|string|max:255',
      'submit_date' => 'nullable|date',
      'briefing_date' => 'nullable|date',
      'deadline' => 'nullable|date',
      'remarks' => ['nullable', Rule::in(['APPROVED', 'PROGRESS', 'PENDING', 'CANCEL'])],
      'notes' => 'nullable|string',
    ];
  }
}
