<?php

namespace Database\Seeders;

use App\Models\EventSignupSettingDetail;
use App\Models\Language;
use Illuminate\Database\Seeder;

class EventSignupSettingOrganizerWebsiteSeeder extends Seeder
{
    /**
     * Seed organizer_website_label for English and Spanish in event_signup_setting_detail.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            'en' => [
                'organizer_contact_section_heading' => '2 of 4 - Organizer & Contact Information',
                'organizer_website_label' => 'Organizer Website',
                'your_profile_heading' => 'Your Profile',
                'the_organizer_heading' => 'The Organizer',
                'contact_person_heading' => 'Contact Person',
                'organizer_phone_label' => 'Phone',
                'mailing_address_label' => 'Mailing Address',
                'contact_name_label' => 'Full Name and Title',
                'contact_phone_label' => 'Contact Phone',
                'contact_phone_hint' => '(If different from the business phone)',
                'contact_email_label' => 'Email',
                'contact_email_hint' => '(If different from the login email)',
                'contact_photo_label' => "Contact Person's Photo",
                'contact_photo_tooltip' => 'Adding a photo helps other delegates and attendees recognize you at the event!',
                'main_event_image_label' => 'Main Event Image',
                'main_event_image_hint' => '(PNG, GIF, JPG, or JPEG format · 30 MB max)',
                'photo_gallery_heading' => 'Photo Gallery',
                'photo_gallery_label' => 'Photo Gallery',
                'photo_gallery_subtitle_featured' => '(Upload up to 20 images. Max 10 MB each. Supports PNG, GIF, or JPG)',
                'photo_gallery_subtitle_premium' => '(Upload up to 8 images. Max 10 MB each. Supports PNG, GIF, or JPG)',
                'update_btn_text' => 'Update',
                'privacy_heading' => 'Protecting your privacy is fundamental to our mission and business:',
                'privacy_bullet_1' => 'We never sell your data or information',
                'privacy_bullet_2' => 'We do not own the content that you upload on our website',
                'privacy_bullet_3' => 'We never send you junk e-mail',
            ],
            'es' => [
                'organizer_contact_section_heading' => '2 de 4 - Información del organizador y contacto',
                'organizer_website_label' => 'Sitio web del organizador',
                'your_profile_heading' => 'Tu perfil',
                'the_organizer_heading' => 'El organizador',
                'contact_person_heading' => 'Persona de contacto',
                'organizer_phone_label' => 'Teléfono',
                'mailing_address_label' => 'Dirección postal',
                'contact_name_label' => 'Nombre completo y cargo',
                'contact_phone_label' => 'Teléfono de contacto',
                'contact_phone_hint' => '(Si es diferente del teléfono del negocio)',
                'contact_email_label' => 'Correo electrónico',
                'contact_email_hint' => '(Si es diferente del correo de acceso)',
                'contact_photo_label' => 'Foto de la persona de contacto',
                'contact_photo_tooltip' => '¡Agregar una foto ayuda a otros delegados y asistentes a reconocerte en el evento!',
                'main_event_image_label' => 'Imagen principal del evento',
                'main_event_image_hint' => '(Formato PNG, GIF, JPG o JPEG · 30 MB máx.)',
                'photo_gallery_heading' => 'Galería de fotos',
                'photo_gallery_label' => 'Galería de fotos',
                'photo_gallery_subtitle_featured' => '(Sube hasta 20 imágenes. Máx. 10 MB cada una. Formatos PNG, GIF o JPG)',
                'photo_gallery_subtitle_premium' => '(Sube hasta 8 imágenes. Máx. 10 MB cada una. Formatos PNG, GIF o JPG)',
                'update_btn_text' => 'Actualizar',
                'privacy_heading' => 'Proteger su privacidad es fundamental para nuestra misión y negocio:',
                'privacy_bullet_1' => 'Nunca vendemos sus datos o información',
                'privacy_bullet_2' => 'No somos propietarios del contenido que carga en nuestro sitio web',
                'privacy_bullet_3' => 'Nunca le enviamos correo basura',
            ],
        ];

        foreach ($translations as $abbreviation => $labels) {
            $language = Language::where('abbreviation', $abbreviation)->first();
            if ($language) {
                foreach ($labels as $column => $value) {
                    EventSignupSettingDetail::where('language_id', $language->id)
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
                EventSignupSettingDetail::whereNull($column)->update([$column => $value]);
            }
        }
    }
}
