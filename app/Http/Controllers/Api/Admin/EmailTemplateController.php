<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EmailTemplateResource;
use App\Models\EmailTemplate;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $templates = EmailTemplate::orderBy('key')->get();
        return $this->apiSuccessResponse(EmailTemplateResource::collection($templates), 'Email templates fetched successfully');
    }

    public function show(EmailTemplate $emailTemplate)
    {
        return $this->apiSuccessResponse(new EmailTemplateResource($emailTemplate), 'Email template fetched successfully');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'key' => 'required|string|max:191|unique:email_templates,key',
            'name' => 'required|string|max:191',
            'subject' => 'required|string',
            'body_html' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $template = EmailTemplate::create([
            'key' => $data['key'],
            'name' => $data['name'],
            'subject' => $data['subject'],
            'body_html' => $data['body_html'],
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $this->apiSuccessResponse(new EmailTemplateResource($template), 'Email template created successfully');
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $data = $this->validate($request, [
            'key' => 'sometimes|required|string|max:191|unique:email_templates,key,' . $emailTemplate->id,
            'name' => 'sometimes|required|string|max:191',
            'subject' => 'sometimes|required|string',
            'body_html' => 'sometimes|required|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $emailTemplate->update($data);
        return $this->apiSuccessResponse(new EmailTemplateResource($emailTemplate), 'Email template updated successfully');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return $this->apiSuccessResponse([], 'Email template deleted successfully');
    }
}




