<?php

namespace Database\Seeders;

use App\Models\BecomeSponsorSettingDetail;
use App\Models\Language;
use Illuminate\Database\Seeder;

class BecomeSponsorFormLabelsSeeder extends Seeder
{
    /**
     * Seed become sponsor form labels for English and Spanish.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            'en' => [
                'sponsorship_section_heading' => 'Select Your Sponsorship Amount & Frequency',
                'enter_amount_placeholder' => 'Enter your own amount',
                'talk_to_us_first_label' => 'Talk to Us First',
                'talk_to_us_first_description' => "We're happy to discuss your goals and our partnership opportunities in detail before you make a selection.",
                'no_amounts_message' => 'No sponsorship amounts available for this frequency.',
                'contact_preferences_heading' => 'Contact Preferences',
                'best_time_to_call_label' => 'Best Time to Call',
                'preferred_date_label' => 'Preferred Date (Optional)',
                'call_time_morning' => 'Morning (9 AM - 12 PM)',
                'call_time_afternoon' => 'Afternoon (12 PM - 5 PM)',
                'call_time_evening' => 'Evening (5 PM - 8 PM)',
                'account_details_heading' => 'Account Details',
                'contact_name_placeholder' => 'Please include your full name and the title you would like to be addressed by, separated by a dash or hyphen. For example, John Smith - Sales Manager',
                'email_hint' => 'Used for both login and contact.',
                'password_label' => 'Password',
                'password_hint' => '(Min. 8 characters. Must contain at least one lowercase and one uppercase)',
                'confirm_password_label' => 'Confirm Password',
                'optional_text' => '(Optional)',
                'brand_story_heading' => 'Brand Story & Media',
                'featured_image_hint' => 'This is your main "hero" photo. It will be the large image on your homepage card and the banner at the top of your profile page. JPG, JPEG, or PNG, max 10MB',
                'logo_hint' => 'Your primary brand mark. This will appear in search results, on the Our Sponsors page, and on your profile sidebar. JPG, JPEG, or PNG, max 5MB',
                'summary_placeholder_long' => "In 30 words or less, share your company's mission or a message of support. This text will appear on the Homepage to highlight your status as an Official Partner of Canadian Exports and Canadian export community.",
                'detail_description_placeholder_long' => 'Use this space (up to 300 words) to share your company\'s story and your commitment to supporting Canadian growth. You can outline your services or explain why you\'ve chosen to champion small businesses, startups, and diverse entrepreneurs through this sponsorship.',
                'message_placeholder_long' => 'Please use this space to share any specific goals, questions, or details you\'d like us to review before we get in touch. We want to ensure our partnership is perfectly tailored to your needs.',
                'featured_image_idle' => 'Drag & Drop your featured image or Browse',
                'logo_idle' => 'Drag & Drop your profile image or Browse',
                'payment_method_heading' => 'Payment Method',
                'debit_credit_label' => 'Debit or Credit Card',
                'cardholder_name_label' => 'Cardholder Name',
                'terms_privacy_label' => 'I agree to the Terms & Conditions and Privacy Policy of Canadian Exports.',
                'donation_non_refundable_label' => 'I understand that this payment is a donation to support the Canadian Exports platform and is non-refundable.',
                'processing_text' => 'Processing...',
                'reactivate_btn_text' => 'Reactivate Sponsorship',
                'become_sponsor_btn_text' => 'Become a Sponsor',
            ],
            'es' => [
                'sponsorship_section_heading' => 'Seleccione su monto y frecuencia de patrocinio',
                'enter_amount_placeholder' => 'Ingrese su propio monto',
                'talk_to_us_first_label' => 'Hable con nosotros primero',
                'talk_to_us_first_description' => 'Estaremos encantados de discutir sus objetivos y nuestras oportunidades de asociación en detalle antes de que realice una selección.',
                'no_amounts_message' => 'No hay montos de patrocinio disponibles para esta frecuencia.',
                'contact_preferences_heading' => 'Preferencias de contacto',
                'best_time_to_call_label' => 'Mejor hora para llamar',
                'preferred_date_label' => 'Fecha preferida (opcional)',
                'call_time_morning' => 'Mañana (9:00 - 12:00)',
                'call_time_afternoon' => 'Tarde (12:00 - 17:00)',
                'call_time_evening' => 'Noche (17:00 - 20:00)',
                'account_details_heading' => 'Detalles de la cuenta',
                'contact_name_placeholder' => 'Incluya su nombre completo y el título por el que desea ser dirigido, separados por un guión. Por ejemplo, Juan Pérez - Gerente de Ventas',
                'email_hint' => 'Se utiliza tanto para inicio de sesión como para contacto.',
                'password_label' => 'Contraseña',
                'password_hint' => '(Mín. 8 caracteres. Debe contener al menos una minúscula y una mayúscula)',
                'confirm_password_label' => 'Confirmar contraseña',
                'optional_text' => '(Opcional)',
                'brand_story_heading' => 'Historia de marca y medios',
                'featured_image_hint' => 'Esta es su foto principal "hero". Será la imagen grande en la tarjeta de su página de inicio y el banner en la parte superior de su página de perfil. JPG, JPEG o PNG, máx. 10MB',
                'logo_hint' => 'Su marca principal. Aparecerá en los resultados de búsqueda, en la página Nuestros Patrocinadores y en la barra lateral de su perfil. JPG, JPEG o PNG, máx. 5MB',
                'summary_placeholder_long' => 'En 30 palabras o menos, comparta la misión de su empresa o un mensaje de apoyo. Este texto aparecerá en la página de inicio para destacar su condición de Socio Oficial de Canadian Exports y la comunidad exportadora canadiense.',
                'detail_description_placeholder_long' => 'Use este espacio (hasta 300 palabras) para compartir la historia de su empresa y su compromiso de apoyar el crecimiento canadiense. Puede describir sus servicios o explicar por qué ha elegido apoyar a pequeñas empresas, startups y emprendedores diversos a través de este patrocinio.',
                'message_placeholder_long' => 'Utilice este espacio para compartir cualquier meta, pregunta o detalle específico que desee que revisemos antes de comunicarnos. Queremos asegurarnos de que nuestra asociación se adapte perfectamente a sus necesidades.',
                'featured_image_idle' => 'Arrastre y suelte su imagen destacada o explore',
                'logo_idle' => 'Arrastre y suelte la imagen de su perfil o explore',
                'payment_method_heading' => 'Método de pago',
                'debit_credit_label' => 'Tarjeta de débito o crédito',
                'cardholder_name_label' => 'Nombre del titular de la tarjeta',
                'terms_privacy_label' => 'Acepto los Términos y Condiciones y la Política de Privacidad de Canadian Exports.',
                'donation_non_refundable_label' => 'Entiendo que este pago es una donación para apoyar la plataforma Canadian Exports y no es reembolsable.',
                'processing_text' => 'Procesando...',
                'reactivate_btn_text' => 'Reactivar patrocinio',
                'become_sponsor_btn_text' => 'Convertirse en patrocinador',
            ],
        ];

        foreach ($translations as $abbreviation => $labels) {
            $language = Language::where('abbreviation', $abbreviation)->first();
            if ($language) {
                foreach ($labels as $column => $value) {
                    BecomeSponsorSettingDetail::where('language_id', $language->id)
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
                BecomeSponsorSettingDetail::whereNull($column)->update([$column => $value]);
            }
        }
    }
}
