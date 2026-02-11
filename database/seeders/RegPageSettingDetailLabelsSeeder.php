<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\RegPageSettingDetail;
use Illuminate\Database\Seeder;

class RegPageSettingDetailLabelsSeeder extends Seeder
{
    /**
     * Seed reg page setting detail labels for English and Spanish.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            'en' => [
                'intro_subtitle' => "Join Canada's trusted export promotion platform and connect with global buyers. Choose the plan that fits your business stage.",
                'privacy_section_heading' => 'Your Privacy is Our Priority',
                'privacy_bullet_1' => 'We never sell your personal information',
                'privacy_bullet_2' => 'You retain full ownership of the content you share on our site',
                'privacy_bullet_3' => 'We never send spam or unwanted emails',
                'details_disclaimers_heading' => 'Details & Disclaimers:',
                'contact_person_heading' => 'Contact Person',
                'step_2_full_name_label' => 'Full Name',
                'step_2_full_name_placeholder' => 'Enter your full name',
                'step_2_job_title_label' => 'Job Title',
                'step_2_job_title_placeholder' => 'Enter your job title',
                'company_location_heading' => 'Company Location & Contact',
                'company_profile_heading' => 'Company Profile & Keywords',
                'password_hint' => '(Min. 8 characters. Must contain at least one lowercase and one uppercase)',
                'short_summary_hint' => '(Max. 30 words)',
                'full_description_hint' => '(Max. 300 words)',
                'cta_btn_hint' => '(Max. 5 words)',
                'mailing_address_lines_error' => 'Mailing Address must not contain more than {max} lines.',
                'payment_frequency_legend' => 'Payment frequency',
                'most_popular_label' => 'Most popular',
                'downgrade_message' => 'Membership downgrades cannot be processed automatically. Please contact us to adjust your plan.',
                'step_5_title_hint' => '(Max. 10 words)',
                'step_5_description_hint' => '(Max. 50 words)',
                'step_5_logo_format_hint' => '(PNG, GIF, JPG, or JPEG format, max 10 MB.)',
                'step_5_gallery_format_hint' => '(Up to {max} allowed, 5 MB max each, in PNG, GIF, JPG, or JPEG format.)',
                'select_payment_method_heading' => 'Select Payment Method',
            ],
            'es' => [
                'intro_subtitle' => 'Únase a la plataforma confiable de promoción de exportaciones de Canadá y conecte con compradores globales. Elija el plan que se adapte a su etapa de negocio.',
                'privacy_section_heading' => 'Su privacidad es nuestra prioridad',
                'privacy_bullet_1' => 'Nunca vendemos su información personal',
                'privacy_bullet_2' => 'Usted conserva la propiedad total del contenido que comparte en nuestro sitio',
                'privacy_bullet_3' => 'Nunca enviamos correo no deseado ni correos electrónicos no deseados',
                'details_disclaimers_heading' => 'Detalles y descargos de responsabilidad:',
                'contact_person_heading' => 'Persona de contacto',
                'step_2_full_name_label' => 'Nombre completo',
                'step_2_full_name_placeholder' => 'Ingrese su nombre completo',
                'step_2_job_title_label' => 'Cargo',
                'step_2_job_title_placeholder' => 'Ingrese su cargo',
                'company_location_heading' => 'Ubicación y contacto de la empresa',
                'company_profile_heading' => 'Perfil de la empresa y palabras clave',
                'password_hint' => '(Mín. 8 caracteres. Debe contener al menos una minúscula y una mayúscula)',
                'short_summary_hint' => '(Máx. 30 palabras)',
                'full_description_hint' => '(Máx. 300 palabras)',
                'cta_btn_hint' => '(Máx. 5 palabras)',
                'mailing_address_lines_error' => 'La dirección postal no debe contener más de {max} líneas.',
                'payment_frequency_legend' => 'Frecuencia de pago',
                'most_popular_label' => 'Más popular',
                'downgrade_message' => 'Las degradaciones de membresía no se pueden procesar automáticamente. Contáctenos para ajustar su plan.',
                'step_5_title_hint' => '(Máx. 10 palabras)',
                'step_5_description_hint' => '(Máx. 50 palabras)',
                'step_5_logo_format_hint' => '(Formato PNG, GIF, JPG o JPEG, máx. 10 MB.)',
                'step_5_gallery_format_hint' => '(Hasta {max} permitidos, 5 MB máx. cada uno, en formato PNG, GIF, JPG o JPEG.)',
                'select_payment_method_heading' => 'Seleccionar método de pago',
            ],
        ];

        foreach ($translations as $abbreviation => $labels) {
            $language = Language::where('abbreviation', $abbreviation)->first();
            if ($language) {
                foreach ($labels as $column => $value) {
                    RegPageSettingDetail::where('language_id', $language->id)
                        ->whereNull($column)
                        ->update([$column => $value]);
                }
            }
        }

        // Fallback: update any remaining null records with English default
        $defaultLang = Language::where('is_default', 1)->first() ?? Language::first();
        if ($defaultLang) {
            $defaultLabels = $translations[$defaultLang->abbreviation ?? ''] ?? $translations['en'];
            foreach ($defaultLabels as $column => $value) {
                RegPageSettingDetail::whereNull($column)->update([$column => $value]);
            }
        }
    }
}
