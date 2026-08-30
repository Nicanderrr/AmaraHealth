<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\ConsultationRequest;
use App\Models\CycleEntry;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\HealthArticle;
use App\Models\HealthResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $admin = User::updateOrCreate(
            ['email' => 'admin@amarahealth.test'],
            [
                'name' => 'Amara Admin',
                'display_name' => 'Amara Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'account_status' => 'active',
                'last_login_at' => $now->copy()->subMinutes(20),
            ]
        );

        $student = User::updateOrCreate(
            ['email' => 'student@amarahealth.test'],
            [
                'name' => 'Demo Student',
                'display_name' => 'Demo Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '12345678',
                'student_id_hash' => hash('sha256', '12345678'),
                'account_status' => 'active',
                'last_login_at' => $now->copy()->subHour(),
            ]
        );

        $studentTwo = User::updateOrCreate(
            ['email' => 'student2@amarahealth.test'],
            [
                'name' => 'Second Student',
                'display_name' => 'Second Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '87654321',
                'student_id_hash' => hash('sha256', '87654321'),
                'account_status' => 'active',
                'last_login_at' => $now->copy()->subHours(2),
            ]
        );

        $professional = User::updateOrCreate(
            ['email' => 'professional@amarahealth.test'],
            [
                'name' => 'Dr. Ama Mensah',
                'display_name' => 'Dr. Ama',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'professional_title' => 'Doctor',
                'university_email' => 'professional@amarahealth.test',
                'assigned_categories' => [
                    'Menstrual Health',
                    'Contraception',
                    'General Reproductive Health',
                ],
                'account_status' => 'active',
                'availability' => 'available',
                'last_login_at' => $now->copy()->subMinutes(45),
            ]
        );

        $nurse = User::updateOrCreate(
            ['email' => 'nurse@amarahealth.test'],
            [
                'name' => 'Nurse Efua Boateng',
                'display_name' => 'Nurse Efua',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'professional_title' => 'Nurse',
                'university_email' => 'nurse@amarahealth.test',
                'assigned_categories' => [
                    'STIs & Sexual Health',
                    'Pregnancy Concerns',
                ],
                'account_status' => 'active',
                'availability' => 'available',
                'last_login_at' => $now->copy()->subHours(3),
            ]
        );

        foreach ([
            [
                'user' => $student,
                'start_date' => $now->copy()->subMonths(2)->startOfMonth()->toDateString(),
                'end_date' => $now->copy()->subMonths(2)->startOfMonth()->addDays(5)->toDateString(),
                'cycle_length_days' => 28,
                'period_length_days' => 5,
                'flow_level' => 'moderate',
                'notes' => 'Steady cycle with mild cramps.',
            ],
            [
                'user' => $student,
                'start_date' => $now->copy()->subMonth()->startOfMonth()->toDateString(),
                'end_date' => $now->copy()->subMonth()->startOfMonth()->addDays(4)->toDateString(),
                'cycle_length_days' => 29,
                'period_length_days' => 4,
                'flow_level' => 'light',
                'notes' => 'Logged with less fatigue than prior month.',
            ],
        ] as $entry) {
            CycleEntry::updateOrCreate(
                [
                    'user_id' => $entry['user']->id,
                    'start_date' => $entry['start_date'],
                ],
                [
                    'end_date' => $entry['end_date'],
                    'cycle_length_days' => $entry['cycle_length_days'],
                    'period_length_days' => $entry['period_length_days'],
                    'flow_level' => $entry['flow_level'],
                    'notes' => $entry['notes'],
                ]
            );
        }

        foreach ([
            [
                'title' => 'Understanding menstrual cycles',
                'category' => 'Menstrual health',
                'summary' => 'A simple guide to cycle length, period flow, and when to seek care.',
                'content' => "Normal cycles vary, but patterns matter.\n\nTrack the start date, end date, and any severe pain or heavy bleeding. If your cycle changes suddenly or symptoms interfere with class attendance, book a clinic visit.",
                'is_featured' => true,
                'author' => $professional,
                'published_at' => $now->copy()->subDays(8),
                'status' => 'approved',
            ],
            [
                'title' => 'What to ask during a sexual health visit',
                'category' => 'Pre-consultation',
                'summary' => 'Questions that help you prepare before seeing a healthcare professional.',
                'content' => "Bring your symptoms, your dates, and the questions you are afraid to ask.\n\nAsk about tests, how results will be shared, what signs require urgent care, and how to follow up after the visit.",
                'is_featured' => true,
                'author' => $nurse,
                'published_at' => $now->copy()->subDays(5),
                'status' => 'approved',
            ],
            [
                'title' => 'Contraception basics for students',
                'category' => 'Contraception',
                'summary' => 'A neutral overview of common contraception choices and common side effects.',
                'content' => "Different methods suit different bodies and situations.\n\nA clinician can help compare options, discuss side effects, and suggest the best fit for your goals and medical history.",
                'is_featured' => false,
                'author' => $professional,
                'published_at' => $now->copy()->subDays(2),
                'status' => 'pending_approval',
            ],
        ] as $article) {
            HealthArticle::updateOrCreate(
                ['title' => $article['title']],
                [
                    'author_id' => $article['author']->id,
                    'slug' => Str::slug($article['title']),
                    'category' => $article['category'],
                    'summary' => $article['summary'],
                    'content' => $article['content'],
                    'is_featured' => $article['is_featured'],
                    'published_at' => $article['published_at'],
                    'status' => $article['status'],
                    'author_title' => $article['author']->professional_title ?? null,
                    'author_display_name' => $article['author']->display_name ?? $article['author']->name,
                    'rejection_reason' => null,
                ]
            );
        }

        foreach ([
            [
                'name' => 'University of Ghana Hospital',
                'service_type' => 'Clinic',
                'location' => 'Legon, University of Ghana campus',
                'contact_phone' => '+233 30 123 4567',
                'contact_email' => 'info@ughospital.example',
                'website' => 'https://www.ug.edu.gh',
                'description' => 'Primary referral point for campus health care and follow-up support.',
                'is_verified' => true,
            ],
            [
                'name' => 'Campus Counseling Centre',
                'service_type' => 'Support',
                'location' => 'Legon, University of Ghana campus',
                'contact_phone' => '+233 30 765 4321',
                'contact_email' => 'support@ug.example',
                'website' => 'https://www.ug.edu.gh',
                'description' => 'Confidential student support for wellbeing, stress, and care navigation.',
                'is_verified' => true,
            ],
            [
                'name' => 'Nearby Pharmacy Directory',
                'service_type' => 'Pharmacy',
                'location' => 'Legon and surrounding areas',
                'contact_phone' => null,
                'contact_email' => null,
                'website' => null,
                'description' => 'A general list of verified pharmacies near campus for quick access to supplies.',
                'is_verified' => true,
            ],
        ] as $resource) {
            HealthResource::updateOrCreate(
                ['name' => $resource['name']],
                $resource
            );
        }

        foreach ([
            [
                'user' => $student,
                'tracking_code' => 'CR-2026-0001',
                'subject' => 'Irregular period and severe cramps',
                'concern_category' => 'Menstrual Health',
                'concern_type' => 'Pain and irregular cycle',
                'symptoms' => 'Heavy cramping, late period, and lower back pain.',
                'questions' => 'Should I book a clinic visit before exams?',
                'urgency' => 'medium',
                'status' => 'response_ready',
                'reviewed_by' => $professional,
                'assigned_professional' => $professional,
                'submitted_at' => $now->copy()->subDays(6),
                'assigned_at' => $now->copy()->subDays(5),
                'responded_at' => $now->copy()->subDays(4),
                'recommendation' => [
                    'assessment_summary' => 'Symptoms are consistent with cycle disruption and pain management needs.',
                    'general_advice' => 'Track bleeding, use warmth and rest, and avoid delaying care if pain intensifies.',
                    'pre_visit_preparation' => 'Bring the last three cycle dates and note any medication used for pain.',
                    'visit_recommended' => 'yes',
                    'priority_level' => 'soon',
                    'urgent_reason' => null,
                    'follow_up_instructions' => 'Arrange a clinic review if bleeding becomes heavy or the pain spikes.',
                ],
                'response' => 'Symptoms are consistent with cycle disruption and pain management needs.\n\nTrack bleeding, use warmth and rest, and avoid delaying care if pain intensifies.\n\nBring the last three cycle dates and note any medication used for pain.\n\nArrange a clinic review if bleeding becomes heavy or the pain spikes.',
                'status_history' => [
                    ['status' => 'submitted', 'changed_at' => $now->copy()->subDays(6)->toISOString(), 'changed_by' => $student->id],
                    ['status' => 'assigned', 'changed_at' => $now->copy()->subDays(5)->toISOString(), 'changed_by' => $admin->id],
                    ['status' => 'response_ready', 'changed_at' => $now->copy()->subDays(4)->toISOString(), 'changed_by' => $professional->id],
                ],
            ],
            [
                'user' => $studentTwo,
                'tracking_code' => 'CR-2026-0002',
                'subject' => 'STI testing and anxiety',
                'concern_category' => 'STIs & Sexual Health',
                'concern_type' => 'Testing guidance',
                'symptoms' => 'No symptoms, but wants advice on testing after a new relationship.',
                'questions' => 'Where can I go confidentially on campus?',
                'urgency' => 'low',
                'status' => 'awaiting_student_response',
                'reviewed_by' => $nurse,
                'assigned_professional' => $nurse,
                'submitted_at' => $now->copy()->subDays(4),
                'assigned_at' => $now->copy()->subDays(4)->addHours(4),
                'responded_at' => null,
                'recommendation' => [
                    'assessment_summary' => 'No acute symptoms reported; case requires follow-up clarification before testing plan.',
                    'general_advice' => 'Testing is appropriate after exposure windows; keep the conversation confidential and documented.',
                    'pre_visit_preparation' => 'List any recent exposures and dates, then note if condoms were used.',
                    'visit_recommended' => 'no',
                    'priority_level' => 'routine',
                    'urgent_reason' => null,
                    'follow_up_instructions' => 'Reply with exposure dates so we can confirm the best test window.',
                ],
                'response' => 'No acute symptoms reported; case requires follow-up clarification before testing plan.\n\nTesting is appropriate after exposure windows; keep the conversation confidential and documented.\n\nList any recent exposures and dates, then note if condoms were used.\n\nReply with exposure dates so we can confirm the best test window.',
                'status_history' => [
                    ['status' => 'submitted', 'changed_at' => $now->copy()->subDays(4)->toISOString(), 'changed_by' => $studentTwo->id],
                    ['status' => 'under_review', 'changed_at' => $now->copy()->subDays(4)->addHours(4)->toISOString(), 'changed_by' => $nurse->id],
                    ['status' => 'awaiting_student_response', 'changed_at' => $now->copy()->subDays(3)->toISOString(), 'changed_by' => $nurse->id],
                ],
            ],
            [
                'user' => $student,
                'tracking_code' => 'CR-2026-0003',
                'subject' => 'Pregnancy concern after missed period',
                'concern_category' => 'Pregnancy Concerns',
                'concern_type' => 'Missed period',
                'symptoms' => 'Period late by 10 days and mild nausea.',
                'questions' => 'Do I need urgent care or just a test?',
                'urgency' => 'high',
                'status' => 'under_review',
                'reviewed_by' => null,
                'assigned_professional' => null,
                'submitted_at' => $now->copy()->subDays(2),
                'assigned_at' => null,
                'responded_at' => null,
                'recommendation' => null,
                'response' => null,
                'status_history' => [
                    ['status' => 'submitted', 'changed_at' => $now->copy()->subDays(2)->toISOString(), 'changed_by' => $student->id],
                    ['status' => 'under_review', 'changed_at' => $now->copy()->subDays(1)->toISOString(), 'changed_by' => $admin->id],
                ],
            ],
        ] as $consultation) {
            ConsultationRequest::updateOrCreate(
                ['tracking_code' => $consultation['tracking_code']],
                [
                    'user_id' => $consultation['user']->id,
                    'subject' => $consultation['subject'],
                    'concern_category' => $consultation['concern_category'],
                    'concern_type' => $consultation['concern_type'],
                    'symptoms' => $consultation['symptoms'],
                    'questions' => $consultation['questions'],
                    'questionnaire_responses' => [
                        'age_group' => '18-24',
                        'location' => 'Campus',
                        'previous_visit' => 'No',
                    ],
                    'urgency' => $consultation['urgency'],
                    'status' => $consultation['status'],
                    'response' => $consultation['response'],
                    'reviewed_by' => $consultation['reviewed_by']?->id,
                    'reviewed_at' => $consultation['reviewed_by'] ? $now->copy()->subDays(4) : null,
                    'assigned_professional_id' => $consultation['assigned_professional']?->id,
                    'assigned_at' => $consultation['assigned_at'],
                    'recommendation' => $consultation['recommendation'],
                    'status_history' => $consultation['status_history'],
                    'submitted_at' => $consultation['submitted_at'],
                    'responded_at' => $consultation['responded_at'],
                    'closed_at' => $consultation['status'] === 'closed' ? $now->copy()->subDay() : null,
                ]
            );
        }

        $forumOne = ForumTopic::updateOrCreate(
            ['title' => 'How do I manage cramps during exams?'],
            [
                'user_id' => $student->id,
                'anonymous_name' => 'Student A',
                'body' => 'I get painful cramps every month and exams make it worse. What helps most?',
                'is_locked' => false,
                'last_reply_at' => $now->copy()->subHours(3),
            ]
        );

        $forumTwo = ForumTopic::updateOrCreate(
            ['title' => 'Confidential testing options on campus'],
            [
                'user_id' => $studentTwo->id,
                'anonymous_name' => 'Student B',
                'body' => 'I want a discreet place to ask about testing and results.',
                'is_locked' => false,
                'last_reply_at' => $now->copy()->subDay(),
            ]
        );

        foreach ([
            [
                'topic' => $forumOne,
                'anonymous_name' => 'Moderator',
                'body' => 'Warm compresses, hydration, rest, and a clinic review if symptoms are severe or changing.',
            ],
            [
                'topic' => $forumTwo,
                'anonymous_name' => 'Moderator',
                'body' => 'Use the campus clinic or professional consultation flow for a confidential first step.',
            ],
        ] as $reply) {
            ForumReply::updateOrCreate(
                [
                    'forum_topic_id' => $reply['topic']->id,
                    'anonymous_name' => $reply['anonymous_name'],
                    'body' => $reply['body'],
                ],
                [
                    'user_id' => $admin->id,
                ]
            );
        }

        Notification::updateOrCreate(
            [
                'recipient_id' => $student->id,
                'type' => 'consultation_response',
                'linked_entity_type' => ConsultationRequest::class,
                'linked_entity_id' => 'CR-2026-0001',
            ],
            [
                'message' => 'Your health professional has responded to your consultation.',
                'read' => false,
            ]
        );

        Notification::updateOrCreate(
            [
                'recipient_id' => $studentTwo->id,
                'type' => 'consultation_follow_up',
                'linked_entity_type' => ConsultationRequest::class,
                'linked_entity_id' => 'CR-2026-0002',
            ],
            [
                'message' => 'Your health professional has asked for one more detail on your consultation.',
                'read' => false,
            ]
        );

        AuditLog::updateOrCreate(
            [
                'admin_id' => $admin->id,
                'action' => 'seed_demo_data',
                'target_entity_type' => User::class,
                'target_entity_id' => $professional->email,
            ],
            [
                'reason' => 'Seeded demo workspace including accounts, content, consultations, and moderation data.',
            ]
        );
    }
}
