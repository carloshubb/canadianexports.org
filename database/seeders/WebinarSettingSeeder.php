<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\WebinarSetting;
use App\Models\WebinarSettingDetail;
use Illuminate\Database\Seeder;

class WebinarSettingSeeder extends Seeder
{
    /**
     * Seed webinar_setting and webinar_setting_detail.
     * language_id 1 = English, 13 = Spanish.
     *
     * @return void
     */
    public function run()
    {
        $pageId = Page::where('template', 'webinar_template')->value('id') ?? 88;

        $setting = WebinarSetting::first();
        if (!$setting) {
            $setting = WebinarSetting::create([
                'page_id' => $pageId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $setting->update(['page_id' => $pageId, 'updated_at' => now()]);
        }

        $english = $this->getEnglishLabels();
        $spanish = $this->getSpanishLabels();

        foreach ([1 => $english, 13 => $spanish] as $languageId => $labels) {
            WebinarSettingDetail::updateOrCreate(
                [
                    'webinar_setting_id' => $setting->id,
                    'language_id' => $languageId,
                ],
                array_merge($labels, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    protected function getEnglishLabels(): array
    {
        return [
            'page_heading' => 'Webinars',
            'no_webinars_message' => 'There are currently no webinars available. Please check back later.',
            'fully_booked_message' => 'This webinar is fully booked.',
            'registered_past_message' => 'You were registered',
            'registered_upcoming_message' => 'You are registered',
            'webinar_ended_message' => 'This webinar has already ended. Registration is no longer available.',
            'no_questions_message' => 'No questions yet. Be the first to ask!',
            'no_chat_message' => 'No messages yet. Start the conversation!',
            'private_message_intro' => 'Send a private message to the presenter.',
            'no_webinars_created_message' => "You haven't created any webinars yet.",
            'edit_webinar_heading' => 'Edit Webinar',
            'create_webinar_heading' => 'Create Webinar',
            'description_label' => 'Description',
            'presenter_bio_label' => 'Presenter Bio',
            'interaction_settings_heading' => 'Interaction Settings',
            'registrations_heading' => 'Registrations',
            'no_registrations_message' => 'No registrations yet',
            'qa_heading' => 'Q&A',
            'no_questions_message_my' => 'No questions yet',
            'not_answered_message' => 'Not answered yet',
            'delete_confirm_message' => 'Are you sure you want to delete this webinar?',
            'host_webinar_button' => '+ Host a Webinar',
            'past_badge' => 'Past',
            'upcoming_badge' => 'Upcoming',
            'date_time_label' => 'Date & time:',
            'duration_label' => 'Duration:',
            'seats_label' => 'Seats:',
            'unlimited_text' => 'Unlimited',
            'remaining_text' => 'remaining',
            'with_presenter_text' => 'With',
            'qa_tab' => 'Q&A',
            'chat_tab' => 'Chat',
            'private_message_tab' => 'Private Message',
            'ask_question_placeholder' => 'Ask a question...',
            'ask_anonymously' => 'Ask anonymously',
            'submit_question_button' => 'Submit Question',
            'sending_text' => 'Sending...',
            'answer_label' => 'Answer:',
            'type_message_placeholder' => 'Type a message...',
            'send_button' => 'Send',
            'you_label' => 'You',
            'presenter_label' => 'Presenter',
            'private_message_placeholder' => 'Write a private message to the presenter...',
            'send_private_message_button' => 'Send Private Message',
            'close_form_button' => 'Close form',
            'register_button' => 'Register',
            'name_label' => 'Name',
            'email_label' => 'Email',
            'phone_label' => 'Phone',
            'company_label' => 'Company',
            'submit_registration_button' => 'Submit registration',
            'submitting_text' => 'Submitting...',
            'type_live_interactive' => 'Live Interactive',
            'type_live_viewonly' => 'Live',
            'type_recorded' => 'On-Demand',
            'my_webinars_heading' => 'My Webinars',
            'host_webinar_button_my' => '+ Host a Webinar',
            'all_webinars_filter' => 'All Webinars',
            'draft_filter' => 'Draft',
            'published_filter' => 'Published',
            'completed_filter' => 'Completed',
            'cancelled_filter' => 'Cancelled',
            'loading_text' => 'Loading...',
            'create_first_webinar_button' => 'Create Your First Webinar',
            'edit_button' => 'Edit',
            'registrations_button' => 'Registrations',
            'qa_button' => 'Q&A',
            'delete_button' => 'Delete',
        ];
    }

    protected function getSpanishLabels(): array
    {
        return [
            'page_heading' => 'Seminarios web',
            'no_webinars_message' => 'No hay seminarios web disponibles en este momento. Vuelva a consultar más tarde.',
            'fully_booked_message' => 'Este seminario web está completo.',
            'registered_past_message' => 'Estaba registrado',
            'registered_upcoming_message' => 'Está registrado',
            'webinar_ended_message' => 'Este seminario web ya finalizó. El registro ya no está disponible.',
            'no_questions_message' => 'Aún no hay preguntas. ¡Sea el primero en preguntar!',
            'no_chat_message' => 'Aún no hay mensajes. ¡Inicie la conversación!',
            'private_message_intro' => 'Envíe un mensaje privado al presentador.',
            'no_webinars_created_message' => 'Aún no ha creado ningún seminario web.',
            'edit_webinar_heading' => 'Editar seminario web',
            'create_webinar_heading' => 'Crear seminario web',
            'description_label' => 'Descripción',
            'presenter_bio_label' => 'Biografía del presentador',
            'interaction_settings_heading' => 'Configuración de interacción',
            'registrations_heading' => 'Registros',
            'no_registrations_message' => 'Aún no hay registros',
            'qa_heading' => 'Preguntas y respuestas',
            'no_questions_message_my' => 'Aún no hay preguntas',
            'not_answered_message' => 'Aún sin responder',
            'delete_confirm_message' => '¿Está seguro de que desea eliminar este seminario web?',
            'host_webinar_button' => '+ Organizar un seminario web',
            'past_badge' => 'Pasado',
            'upcoming_badge' => 'Próximo',
            'date_time_label' => 'Fecha y hora:',
            'duration_label' => 'Duración:',
            'seats_label' => 'Plazas:',
            'unlimited_text' => 'Ilimitado',
            'remaining_text' => 'restantes',
            'with_presenter_text' => 'Con',
            'qa_tab' => 'P y R',
            'chat_tab' => 'Chat',
            'private_message_tab' => 'Mensaje privado',
            'ask_question_placeholder' => 'Haga una pregunta...',
            'ask_anonymously' => 'Preguntar de forma anónima',
            'submit_question_button' => 'Enviar pregunta',
            'sending_text' => 'Enviando...',
            'answer_label' => 'Respuesta:',
            'type_message_placeholder' => 'Escriba un mensaje...',
            'send_button' => 'Enviar',
            'you_label' => 'Usted',
            'presenter_label' => 'Presentador',
            'private_message_placeholder' => 'Escriba un mensaje privado al presentador...',
            'send_private_message_button' => 'Enviar mensaje privado',
            'close_form_button' => 'Cerrar formulario',
            'register_button' => 'Registrarse',
            'name_label' => 'Nombre',
            'email_label' => 'Correo electrónico',
            'phone_label' => 'Teléfono',
            'company_label' => 'Empresa',
            'submit_registration_button' => 'Enviar registro',
            'submitting_text' => 'Enviando...',
            'type_live_interactive' => 'En vivo interactivo',
            'type_live_viewonly' => 'En vivo',
            'type_recorded' => 'A la carta',
            'my_webinars_heading' => 'Mis seminarios web',
            'host_webinar_button_my' => '+ Organizar un seminario web',
            'all_webinars_filter' => 'Todos los seminarios',
            'draft_filter' => 'Borrador',
            'published_filter' => 'Publicado',
            'completed_filter' => 'Completado',
            'cancelled_filter' => 'Cancelado',
            'loading_text' => 'Cargando...',
            'create_first_webinar_button' => 'Crear su primer seminario web',
            'edit_button' => 'Editar',
            'registrations_button' => 'Registros',
            'qa_button' => 'P y R',
            'delete_button' => 'Eliminar',
        ];
    }
}
