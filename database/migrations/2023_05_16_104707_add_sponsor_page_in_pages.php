<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_page_setting', function(Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sponsor_page_setting_detail', function(Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_page_setting_id')->nullable()->constrained('sponsor_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            
            // Page Content Fields
            $table->string('page_title', 255)->nullable();
            $table->text('page_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            
            // Section Headings
            $table->string('main_heading', 255)->nullable();
            $table->text('main_subheading')->nullable();
            $table->string('benefits_heading', 255)->nullable();
            $table->string('packages_heading', 255)->nullable();
            $table->string('sponsors_heading', 255)->nullable();
            
            // Profile Status Labels
            $table->string('profile_status_label', 255)->nullable()->default('Your Profile Status:');
            $table->string('status_live_label', 255)->nullable()->default('Live');
            $table->string('status_pending_label', 255)->nullable()->default('Pending');
            $table->string('status_draft_label', 255)->nullable()->default('Draft');
            $table->string('status_inactive_label', 255)->nullable()->default('Inactive');
            $table->string('view_public_profile_label', 255)->nullable()->default('View Public Profile');
            
            // Sponsorship Status Labels
            $table->string('sponsorship_status_heading', 255)->nullable()->default('Sponsorship Status');
            $table->string('status_active_label', 255)->nullable()->default('✓ Active');
            $table->string('sponsorship_amount_label', 255)->nullable()->default('Sponsorship Amount');
            $table->string('paid_on_label', 255)->nullable()->default('Paid on');
            $table->string('payment_method_label', 255)->nullable()->default('Payment Method:');
            $table->string('beneficiary_label', 255)->nullable()->default('Beneficiary:');
            
            // Payment Status Labels
            $table->string('payment_status_paid_label', 255)->nullable()->default('💳 Paid');
            $table->string('payment_status_pending_label', 255)->nullable()->default('Payment Pending');
            $table->string('payment_status_not_required_label', 255)->nullable()->default('Contact Request');
            
            // Upgrade Plan Labels
            $table->string('upgrade_plan_text', 255)->nullable()->default('Upgrade your plan mid-cycle: we\'ll apply unused time from your current plan as credit toward the new one.');
            $table->string('upgrade_plan_button', 255)->nullable()->default('Upgrade plan');
            
            // Section Titles
            $table->string('company_information_heading', 255)->nullable()->default('Company Information');
            $table->string('company_description_heading', 255)->nullable()->default('Company Description');
            $table->string('company_media_heading', 255)->nullable()->default('Company Media');
            $table->string('your_password_heading', 255)->nullable()->default('Your Password');
            
            // Form Labels
            $table->string('company_name_label', 255)->nullable()->default('Company Name');
            $table->string('contact_name_label', 255)->nullable()->default('Contact Person');
            $table->string('email_label', 255)->nullable()->default('Email Address');
            $table->string('contact_label', 255)->nullable()->default('Contact Number');
            $table->string('company_website_label', 255)->nullable()->default('Company Website');
            $table->string('brief_description_label', 255)->nullable()->default('Brief Description');
            $table->string('detailed_description_label', 255)->nullable()->default('Detailed Description');
            $table->string('message_label', 255)->nullable()->default('Additional Message');
            $table->string('logo_label', 255)->nullable()->default('Company Logo');
            $table->string('featured_image_label', 255)->nullable()->default('Featured Image');
            
            // Placeholder Text
            $table->string('company_name_placeholder', 255)->nullable()->default('Your Company Inc.');
            $table->string('contact_name_placeholder', 255)->nullable()->default('John Doe');
            $table->string('email_placeholder', 255)->nullable()->default('john@company.com');
            $table->string('contact_placeholder', 255)->nullable()->default('15551234567');
            $table->string('website_placeholder', 255)->nullable()->default('https://www.yourcompany.com');
            $table->string('brief_description_placeholder', 255)->nullable()->default('A brief overview of your company...');
            $table->string('detailed_description_placeholder', 255)->nullable()->default('Tell us more about your company, products, and services...');
            $table->string('message_placeholder', 255)->nullable()->default('Any additional information...');
            
            // Media Upload Labels
            $table->string('logo_upload_note', 255)->nullable()->default('(Max 10MB, PNG/JPG/JPEG/GIF)');
            $table->string('current_logo_label', 255)->nullable()->default('Current Logo:');
            $table->string('current_featured_image_label', 255)->nullable()->default('Current Featured Image:');
            $table->string('logo_drag_drop_text', 255)->nullable()->default('Drag & Drop your logo or Browse');
            $table->string('featured_drag_drop_text', 255)->nullable()->default('Drag & Drop your featured image or Browse');
            
            // Password Labels
            $table->string('current_password_label', 255)->nullable()->default('Current Password');
            $table->string('new_password_label', 255)->nullable()->default('New Password');
            $table->string('confirm_password_label', 255)->nullable()->default('Confirm New Password');
            $table->string('password_note', 255)->nullable()->default('Leave these fields blank to keep your current password. Only enter a new password if you wish to update it.');
            
            // Package/Plan Labels
            $table->string('package_name_label', 255)->nullable()->default('Package Name');
            $table->string('package_price_label', 255)->nullable()->default('Price');
            $table->string('package_frequency_label', 255)->nullable()->default('Billing Frequency');
            $table->string('package_description_label', 255)->nullable()->default('Package Description');
            
            // Button Text
            $table->string('button_text', 255)->nullable()->default('Become a Sponsor');
            $table->string('submit_button_text', 255)->nullable()->default('Submit Application');
            $table->string('update_profile_button', 255)->nullable()->default('Update Profile');
            $table->string('reset_changes_button', 255)->nullable()->default('Reset Changes');
            $table->string('view_details_text', 255)->nullable()->default('View Details');
            $table->string('select_package_text', 255)->nullable()->default('Select Package');
            $table->string('updating_text', 255)->nullable()->default('Updating...');
            $table->string('processing_text', 255)->nullable()->default('Processing...');
            
            // Upgrade Modal Labels
            $table->string('upgrade_modal_title', 255)->nullable()->default('Upgrade your sponsorship plan');
            $table->string('upgrade_modal_description', 255)->nullable()->default('Your unused time on the current plan will be applied as credit. You pay: New plan price − credit.');
            $table->string('new_amount_label', 255)->nullable()->default('New amount per period ($)');
            $table->string('new_frequency_label', 255)->nullable()->default('New billing frequency');
            $table->string('see_upgrade_cost_button', 255)->nullable()->default('See upgrade cost');
            $table->string('loading_text', 255)->nullable()->default('Loading...');
            $table->string('unused_credit_label', 255)->nullable()->default('Unused credit from current plan:');
            $table->string('new_plan_price_label', 255)->nullable()->default('New plan price:');
            $table->string('amount_due_today_label', 255)->nullable()->default('Amount due today:');
            $table->string('downgrade_notice', 255)->nullable()->default('Your downgrade will take effect at the end of your current billing period. If you need an immediate downgrade, please contact support.');
            $table->string('cardholder_name_label', 255)->nullable()->default('Cardholder Name');
            $table->string('card_number_label', 255)->nullable()->default('Card Number');
            $table->string('card_credit_notice', 255)->nullable()->default('Your credit covers this upgrade; card will be used for future renewals.');
            $table->string('cancel_button', 255)->nullable()->default('Cancel');
            $table->string('submit_downgrade_button', 255)->nullable()->default('Submit downgrade request');
            $table->string('submitting_text', 255)->nullable()->default('Submitting...');
            $table->string('confirm_pay_button', 255)->nullable()->default('Confirm and pay');
            $table->string('confirm_upgrade_button', 255)->nullable()->default('Confirm upgrade');
            
            // Billing Frequency Options
            $table->string('frequency_monthly', 255)->nullable()->default('Monthly');
            $table->string('frequency_quarterly', 255)->nullable()->default('Quarterly');
            $table->string('frequency_annually', 255)->nullable()->default('Annually');
            
            // Validation Messages
            $table->string('required_field_text', 255)->nullable()->default('This field is required');
            $table->string('invalid_email_text', 255)->nullable()->default('Please enter a valid email address');
            $table->string('invalid_url_text', 255)->nullable()->default('Please enter a valid URL');
            $table->string('passwords_not_match', 255)->nullable()->default('Passwords do not match');
            
            // Success/Error Messages
            $table->text('success_message')->nullable()->default('Thank you for your sponsorship application. We will contact you shortly.');
            $table->text('error_message')->nullable()->default('An error occurred. Please try again.');
            $table->text('profile_updated_message')->nullable()->default('Profile updated successfully!');
            $table->text('profile_update_failed_message')->nullable()->default('Failed to update profile');
            
            // Additional Content
            $table->text('terms_and_conditions')->nullable();
            $table->text('sponsorship_benefits')->nullable();
            $table->text('contact_info')->nullable();
            
            // Unique constraint to prevent duplicate language entries
            $table->unique(['sponsor_page_setting_id', 'language_id'], 'sponsor_setting_lang_unique');
            
            $table->timestamps();
        });

        // Update pages template enum
        //\DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template', 'sponsor_template')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("sponsor_page_setting_detail");
        Schema::dropIfExists("sponsor_page_setting");
        
        // Restore original template enum
        //\DB::statement("ALTER TABLE pages MODIFY template ENUM('login_template','register_template','home_template', 'about_us_template', 'contact_us_template', 'inquiries_to_buy_template', 'testimonial_template', 'info_letter_template', 'event_template')");
    }
};