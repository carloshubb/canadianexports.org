<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class EmailTemplateService
{
    public function render(string $key, array $data, ?string $fallbackSubject = null, ?string $fallbackBodyHtml = null): array
    {
        $template = EmailTemplate::where('key', $key)->where('is_active', true)->first();

        if ($template) {
            // Render subject with Blade (safe: usually plain variables)
            $subject = $this->renderString($template->subject, $data);
            // IMPORTANT: return the raw body so it can be compiled inside the mailable view
            // This avoids "No hint path defined for [mail]" when DB content uses mail components
            $body = $template->body_html;
            return ['subject' => $subject, 'body_html' => $body];
        }

        $subject = $fallbackSubject ? $this->renderString($fallbackSubject, $data) : '';
        $body = $fallbackBodyHtml ?? '';
        return ['subject' => $subject, 'body_html' => $body];
    }

    protected function renderString(string $template, array $data): string
    {
        try {
            // Blade::render handles full Blade syntax: @if, @php, @component, loops, etc.
            // Make data available as $data array plus individual variables for convenience
            // Ensure 'data' key exists and contains the full data array
            $viewData = array_merge(['data' => $data], $data);
            
            // Ensure all required keys exist in the $data array for template access
            if (!isset($viewData['data']['name'])) {
                $viewData['data']['name'] = $viewData['data']['name'] ?? $viewData['name'] ?? 'User';
            }
            
            return Blade::render($template, $viewData);
        } catch (\Exception $e) {
            // If Blade rendering fails, log error and return empty
            Log::error('Email template rendering failed: ' . $e->getMessage(), [
                'template' => substr($template, 0, 100),
                'data_keys' => array_keys($data),
                'exception' => $e->getMessage()
            ]);
            return '';
        }
    }
}



