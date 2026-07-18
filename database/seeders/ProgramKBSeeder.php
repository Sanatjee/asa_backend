<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramKB;

class ProgramKBSeeder extends Seeder
{
    public function run(): void
    {
        $knowledgeBase = [

            // Eligibility
            [
                'title' => 'Who is eligible for the program?',
                'category' => 'Eligibility',
                'content' => 'The program is open to graduates and working professionals meeting the eligibility criteria specified for the program.',
                'is_active' => true,
            ],
            [
                'title' => 'Is work experience mandatory?',
                'category' => 'Eligibility',
                'content' => 'Work experience requirements vary depending on the program.',
                'is_active' => true,
            ],
            [
                'title' => 'Can final year students apply?',
                'category' => 'Eligibility',
                'content' => 'Some programs allow final year students to apply subject to eligibility conditions.',
                'is_active' => true,
            ],
            [
                'title' => 'Is there any entrance test?',
                'category' => 'Eligibility',
                'content' => 'Certain programs may include an aptitude test or interview.',
                'is_active' => true,
            ],
            [
                'title' => 'Are international students eligible?',
                'category' => 'Eligibility',
                'content' => 'International applicants can apply for selected programs.',
                'is_active' => true,
            ],

            // Fees
            [
                'title' => 'What is the program fee?',
                'category' => 'Fees',
                'content' => 'The total program fee is mentioned on the official program page.',
                'is_active' => true,
            ],
            [
                'title' => 'Are taxes included?',
                'category' => 'Fees',
                'content' => 'Applicable GST will be charged as per government regulations.',
                'is_active' => true,
            ],
            [
                'title' => 'Can fees change?',
                'category' => 'Fees',
                'content' => 'Fee structures are subject to revision before admissions open.',
                'is_active' => true,
            ],
            [
                'title' => 'Are there hidden charges?',
                'category' => 'Fees',
                'content' => 'No hidden charges apply unless explicitly mentioned.',
                'is_active' => true,
            ],
            [
                'title' => 'Can I download the fee receipt?',
                'category' => 'Fees',
                'content' => 'Yes, fee receipts are available after successful payment.',
                'is_active' => true,
            ],

            // Refund
            [
                'title' => 'What is the refund policy?',
                'category' => 'Refund',
                'content' => 'Refunds are processed according to the official refund policy.',
                'is_active' => true,
            ],
            [
                'title' => 'How long do refunds take?',
                'category' => 'Refund',
                'content' => 'Refunds typically take 7-14 working days.',
                'is_active' => true,
            ],
            [
                'title' => 'Can registration fees be refunded?',
                'category' => 'Refund',
                'content' => 'Registration fees may be non-refundable.',
                'is_active' => true,
            ],
            [
                'title' => 'How do I request a refund?',
                'category' => 'Refund',
                'content' => 'Refund requests can be submitted through the learner portal.',
                'is_active' => true,
            ],
            [
                'title' => 'Will GST be refunded?',
                'category' => 'Refund',
                'content' => 'GST refund depends on applicable regulations.',
                'is_active' => true,
            ],

            // Certificate
            [
                'title' => 'Will I receive a certificate?',
                'category' => 'Certificate',
                'content' => 'Yes, learners meeting completion criteria receive a certificate.',
                'is_active' => true,
            ],
            [
                'title' => 'Is the certificate from IIT Bombay?',
                'category' => 'Certificate',
                'content' => 'Eligible learners receive the certificate issued as per the program guidelines.',
                'is_active' => true,
            ],
            [
                'title' => 'Is the certificate digital?',
                'category' => 'Certificate',
                'content' => 'Certificates may be issued digitally.',
                'is_active' => true,
            ],
            [
                'title' => 'When will I receive the certificate?',
                'category' => 'Certificate',
                'content' => 'Certificates are issued after successful completion.',
                'is_active' => true,
            ],
            [
                'title' => 'Can I verify my certificate?',
                'category' => 'Certificate',
                'content' => 'Certificate verification options may be available.',
                'is_active' => true,
            ],

            // Placement
            [
                'title' => 'Does the program provide placement assistance?',
                'category' => 'Placement',
                'content' => 'Placement assistance depends on the program.',
                'is_active' => true,
            ],
            [
                'title' => 'Are interviews guaranteed?',
                'category' => 'Placement',
                'content' => 'Interviews are not guaranteed.',
                'is_active' => true,
            ],
            [
                'title' => 'Will resume reviews be provided?',
                'category' => 'Placement',
                'content' => 'Career support may include resume reviews.',
                'is_active' => true,
            ],
            [
                'title' => 'Are mock interviews conducted?',
                'category' => 'Placement',
                'content' => 'Some programs include mock interview sessions.',
                'is_active' => true,
            ],
            [
                'title' => 'Do companies recruit directly?',
                'category' => 'Placement',
                'content' => 'Recruitment opportunities vary by program.',
                'is_active' => true,
            ],

        ];

        foreach ($knowledgeBase as $item) {
            ProgramKB::create($item);
        }
    }
}