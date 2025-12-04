<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoffeeWallFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            // Donor FAQs
            [
                'type' => 'donor',
                'question' => 'What is the "Coffee on the Wall" initiative?',
                'answer' => 'The "Coffee on the Wall" initiative is a pay-it-forward concept where donors can contribute to help students in need access educational services. Your donation will help students who cannot afford our services to get the education they deserve.',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'donor',
                'question' => 'How much should I donate?',
                'answer' => 'You can donate any amount you feel comfortable with. We offer preset amounts starting from $10, or you can enter a custom amount. Every contribution, no matter how small, makes a difference in a student\'s life.',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'donor',
                'question' => 'Can I set up a recurring donation?',
                'answer' => 'Yes! You can choose to make your donation one-time, weekly, or monthly. Recurring donations help us provide consistent support to students in need throughout their educational journey.',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'donor',
                'question' => 'Is my donation tax-deductible?',
                'answer' => 'Please consult with your tax advisor regarding the deductibility of your donation. We can provide you with a receipt for your contribution upon request.',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'donor',
                'question' => 'Can I donate anonymously?',
                'answer' => 'Yes, you have the option to make your donation anonymous by checking the "Make donation anonymous" box during the donation process. Your privacy is important to us.',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Beneficiary FAQs
            [
                'type' => 'beneficiary',
                'question' => 'Who can claim a "Coffee from the Wall"?',
                'answer' => 'Any student who cannot afford our educational services is welcome to claim a "Coffee from the Wall". This initiative is designed specifically for students in need, regardless of their country or background.',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'beneficiary',
                'question' => 'How do I claim my coffee?',
                'answer' => 'To claim your coffee, please fill out the beneficiary form on our website. We will review your request and get back to you within 2-3 business days with information about accessing our services.',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'beneficiary',
                'question' => 'What services can I access with this program?',
                'answer' => 'Beneficiaries can access various educational services offered by ProxiCare from Proxima Study. These services are designed to help you succeed in your educational journey, even if you cannot afford them on your own.',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'beneficiary',
                'question' => 'Is there a limit to how many times I can benefit from this program?',
                'answer' => 'We want to help as many students as possible. While there may be usage guidelines to ensure fair distribution of resources, we encourage you to reach out and discuss your specific needs with us.',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'beneficiary',
                'question' => 'Do I need to pay back the support I receive?',
                'answer' => 'No, this is not a loan. The "Coffee on the Wall" has been donated specifically for you. However, we encourage you to pay it forward when you are able to help other students in need in the future.',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('coffee_wall_faqs')->insert($faqs);
    }
}
