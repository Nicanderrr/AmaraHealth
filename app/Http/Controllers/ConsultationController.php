<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    private const CATEGORY_QUESTIONS = [
        'Menstrual Health' => [
            ['id' => 'main_concern', 'label' => 'How would you describe your main concern?', 'type' => 'single', 'options' => ['Irregular periods', 'Heavy bleeding', 'Painful periods', 'Absent periods', 'Spotting between periods', 'Other']],
            ['id' => 'last_period', 'label' => 'When did you last have a period?', 'type' => 'duration', 'options' => ['Within the last month', '1-2 months ago', '2-3 months ago', 'More than 3 months ago', 'I am not sure']],
            ['id' => 'pain_level', 'label' => 'How would you rate your pain level during your period?', 'type' => 'scale', 'options' => [1, 2, 3, 4, 5]],
            ['id' => 'flow', 'label' => 'How heavy is your flow on your heaviest day?', 'type' => 'single', 'options' => ['Light (1-2 pads/day)', 'Moderate (3-4 pads/day)', 'Heavy (5+ pads/day)', 'I change protection more than hourly']],
            ['id' => 'symptoms', 'label' => 'Have you noticed any of the following alongside your concern?', 'type' => 'multi', 'options' => ['Nausea', 'Vomiting', 'Bloating', 'Dizziness', 'Fatigue', 'Clots in blood', 'None of the above']],
            ['id' => 'duration', 'label' => 'How long has this concern been present?', 'type' => 'duration', 'options' => ['Less than 1 week', '1-4 weeks', '1-3 months', 'More than 3 months']],
            ['id' => 'medication', 'label' => 'Are you currently taking any medication, supplements, or contraception?', 'type' => 'single', 'options' => ['Yes', 'No', 'I am not sure']],
            ['id' => 'extra_notes', 'label' => 'Anything else the health professional should know?', 'type' => 'text', 'max' => 200],
        ],
        'STIs & Sexual Health' => [
            ['id' => 'main_concern', 'label' => 'What is your main concern?', 'type' => 'single', 'options' => ['Unusual discharge', 'Sores or blisters', 'Itching or burning', 'Pain during sex', 'Concern after unprotected sex', 'I may have been exposed to an STI', 'Other']],
            ['id' => 'noticed', 'label' => 'When did you first notice this concern?', 'type' => 'duration', 'options' => ['Within the last week', '1-2 weeks ago', '2-4 weeks ago', 'More than 1 month ago']],
            ['id' => 'symptoms', 'label' => 'Have you experienced any of the following?', 'type' => 'multi', 'options' => ['Fever', 'Lower abdominal pain', 'Rash', 'Painful urination', 'Swollen glands', 'None of the above']],
            ['id' => 'tested', 'label' => 'Have you previously been tested for STIs?', 'type' => 'single', 'options' => ['Yes, and results were negative', 'Yes, and I was treated for an STI', 'No', 'I prefer not to say']],
            ['id' => 'unprotected', 'label' => 'Have you had unprotected sexual contact recently?', 'type' => 'single', 'options' => ['Yes', 'No', 'I prefer not to say']],
            ['id' => 'contraception', 'label' => 'Are you currently using any form of contraception?', 'type' => 'single', 'options' => ['Yes', 'No', 'I prefer not to say']],
            ['id' => 'medication', 'label' => 'Are you currently taking any medication?', 'type' => 'single', 'options' => ['Yes', 'No', 'I am not sure']],
            ['id' => 'extra_notes', 'label' => 'Anything else the health professional should know?', 'type' => 'text', 'max' => 200],
        ],
        'Contraception' => [
            ['id' => 'main_concern', 'label' => 'What is your main concern or question about contraception?', 'type' => 'single', 'options' => ['I want to start contraception', 'I want to change my current method', 'I am having side effects', 'I missed a pill or dose', 'I need emergency contraception', 'I want to stop contraception', 'General information']],
            ['id' => 'using', 'label' => 'Are you currently using any form of contraception?', 'type' => 'single', 'options' => ['Yes', 'No']],
            ['id' => 'method', 'label' => 'If yes, which method are you using?', 'type' => 'single', 'options' => ['Combined oral pill', 'Progestogen-only pill', 'Injection', 'Implant', 'IUD (coil)', 'Condoms', 'Emergency contraception', 'None', 'Other']],
            ['id' => 'duration', 'label' => 'How long have you been using your current method?', 'type' => 'duration', 'options' => ['Less than 1 month', '1-6 months', '6-12 months', 'More than 1 year', 'Not applicable']],
            ['id' => 'side_effects', 'label' => 'Are you experiencing any side effects?', 'type' => 'multi', 'options' => ['Irregular bleeding', 'Nausea', 'Mood changes', 'Headaches', 'Weight changes', 'Reduced sex drive', 'No side effects', 'Not applicable']],
            ['id' => 'conditions', 'label' => 'Do you have any of the following health conditions?', 'type' => 'multi', 'options' => ['High blood pressure', 'Migraines with aura', 'Blood clotting disorder', 'Liver disease', 'Breast cancer history', 'None of the above', 'I am not sure']],
            ['id' => 'extra_notes', 'label' => 'Anything else the health professional should know?', 'type' => 'text', 'max' => 200],
        ],
        'Pregnancy Concerns' => [
            ['id' => 'main_concern', 'label' => 'What is your main concern?', 'type' => 'single', 'options' => ['I think I may be pregnant', 'I have taken a pregnancy test and it was positive', 'I am pregnant and have questions', 'I have had a recent miscarriage', 'I have concerns about a previous pregnancy', 'Other']],
            ['id' => 'lmp', 'label' => 'When was your last menstrual period?', 'type' => 'duration', 'options' => ['Within the last month', '1-2 months ago', '2-3 months ago', 'More than 3 months ago', 'I am not sure']],
            ['id' => 'test', 'label' => 'Have you taken a pregnancy test?', 'type' => 'single', 'options' => ['Yes - positive result', 'Yes - negative result', 'No']],
            ['id' => 'symptoms', 'label' => 'Are you experiencing any of the following?', 'type' => 'multi', 'options' => ['Nausea or vomiting', 'Breast tenderness', 'Fatigue', 'Cramping', 'Bleeding or spotting', 'None of the above']],
            ['id' => 'provider', 'label' => 'Have you spoken to a healthcare provider about this concern before?', 'type' => 'single', 'options' => ['Yes', 'No']],
            ['id' => 'medication', 'label' => 'Are you currently taking any medication or supplements?', 'type' => 'single', 'options' => ['Yes', 'No', 'I am not sure']],
            ['id' => 'conditions', 'label' => 'Do you have any existing health conditions we should know about?', 'type' => 'text', 'max' => 200],
            ['id' => 'extra_notes', 'label' => 'Anything else the health professional should know?', 'type' => 'text', 'max' => 200],
        ],
        'General Reproductive Health' => [
            ['id' => 'main_concern', 'label' => 'How would you describe your main concern?', 'type' => 'single', 'options' => ['Pelvic pain', 'Unusual vaginal discharge', 'Vulval irritation or soreness', 'Concerns about fertility', 'Concerns after a gynaecological procedure', 'General health question', 'Other']],
            ['id' => 'duration', 'label' => 'How long have you been experiencing this concern?', 'type' => 'duration', 'options' => ['Less than 1 week', '1-4 weeks', '1-3 months', 'More than 3 months']],
            ['id' => 'impact', 'label' => 'How would you rate the impact on your daily life?', 'type' => 'scale', 'options' => [1, 2, 3, 4, 5]],
            ['id' => 'experienced_before', 'label' => 'Have you experienced this concern before?', 'type' => 'single', 'options' => ['Yes', 'No', 'I am not sure']],
            ['id' => 'seen_provider', 'label' => 'Have you previously seen a healthcare provider for this concern?', 'type' => 'single', 'options' => ['Yes', 'No']],
            ['id' => 'medication', 'label' => 'Are you currently taking any medication or contraception?', 'type' => 'single', 'options' => ['Yes', 'No', 'I am not sure']],
            ['id' => 'extra_notes', 'label' => 'Anything else the health professional should know?', 'type' => 'text', 'max' => 200],
        ],
    ];

    public function index(Request $request): View
    {
        return view('consultations.index', [
            'requests' => $request->user()->consultationRequests()->with('assignedProfessional')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        $category = $request->string('category')->toString();
        $step = $request->string('step')->toString();
        $questions = $category ? $this->questionsFor($category) : [];
        $sessionWizard = session('consultation_wizard', ['category' => null, 'answers' => []]);

        return view('consultations.create', [
            'categories' => array_keys(self::CATEGORY_QUESTIONS),
            'selectedCategory' => $category ?: null,
            'questions' => $questions,
            'currentStep' => ctype_digit($step) ? (int) $step : null,
            'isReviewStep' => $step === 'review',
            'answers' => $sessionWizard['answers'] ?? [],
            'wizardCategory' => $sessionWizard['category'] ?? null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = $request->string('category')->toString();
        $questions = $this->questionsFor($category);

        if ($request->boolean('finalize')) {
            return $this->finalizeConsultation($request, $category, $questions);
        }

        $step = max(1, (int) $request->input('step', 1));
        $question = $questions[$step - 1] ?? null;

        abort_unless($question, 422, 'Invalid consultation step.');

        $answer = $this->normalizeAnswer($request, $question);

        $wizard = session('consultation_wizard', ['category' => $category, 'answers' => []]);
        $wizard['category'] = $category;
        $wizard['answers'][$question['id']] = $answer;
        session(['consultation_wizard' => $wizard]);

        if ($step >= count($questions)) {
            return redirect()->route('consultations.create', [
                'category' => $category,
                'step' => 'review',
            ]);
        }

        return redirect()->route('consultations.create', [
            'category' => $category,
            'step' => $step + 1,
        ]);
    }

    public function show(ConsultationRequest $consultationRequest, Request $request): View
    {
        abort_unless($consultationRequest->user_id === $request->user()->id || $request->user()->role === 'admin', 403);

        return view('consultations.show', [
            'consultation' => $consultationRequest->load('assignedProfessional'),
        ]);
    }

    private function finalizeConsultation(Request $request, string $category, array $questions): RedirectResponse
    {
        $wizard = session('consultation_wizard');

        if (! $wizard || ($wizard['category'] ?? null) !== $category) {
            return redirect()->route('consultations.create')->withErrors(['consultation' => 'Your consultation session expired. Please start again.']);
        }

        $openCount = $request->user()
            ->consultationRequests()
            ->whereNotIn('status', ['closed'])
            ->count();

        if ($openCount >= 3) {
            return redirect()->route('consultations.create', ['category' => $category])
                ->withErrors(['consultation' => 'You currently have 3 open consultations. Please wait for a professional response before submitting a new one.']);
        }

        $firstQuestion = $questions[0] ?? null;
        $subject = $this->makeSubject($category, $wizard['answers'][$firstQuestion['id']] ?? $category);
        $summary = $this->summarizeResponses($wizard['answers']);
        [$professional, $assignedStatus] = $this->assignProfessional($category);

        $consultation = ConsultationRequest::create([
            'tracking_code' => 'AMH-'.Str::upper(Str::random(8)),
            'user_id' => $request->user()->id,
            'subject' => $subject,
            'concern_category' => $category,
            'concern_type' => $category,
            'symptoms' => $summary,
            'questions' => $summary,
            'questionnaire_responses' => $wizard['answers'],
            'urgency' => $this->inferUrgency($wizard['answers']),
            'status' => $assignedStatus,
            'assigned_professional_id' => $professional?->id,
            'assigned_at' => $professional ? now() : null,
            'submitted_at' => now(),
            'status_history' => [
                ['status' => 'submitted', 'changed_at' => now()->toISOString(), 'changed_by' => $request->user()->id],
                ['status' => $assignedStatus, 'changed_at' => now()->toISOString(), 'changed_by' => $professional?->id ?? 'system'],
            ],
        ]);

        $this->createNotification(
            $request->user(),
            'consultation_submitted',
            'Your consultation has been submitted and is now being prepared for review.',
            $consultation
        );

        $this->notifyAdminsIfNeeded($consultation, $professional);

        if ($professional) {
            $this->createNotification(
                $professional,
                'consultation_assigned',
                'A new consultation has been assigned to you.',
                $consultation
            );
        }

        session()->forget('consultation_wizard');

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('status', 'Request submitted. Keep this tracking code for follow-up.');
    }

    private function questionsFor(string $category): array
    {
        return self::CATEGORY_QUESTIONS[$category] ?? [];
    }

    private function normalizeAnswer(Request $request, array $question): mixed
    {
        return match ($question['type']) {
            'multi' => array_values(array_filter((array) $request->input('answer', []))),
            default => trim((string) $request->input('answer', '')),
        };
    }

    private function summarizeResponses(array $answers): string
    {
        $lines = [];

        foreach ($answers as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            $lines[] = Str::headline(str_replace('_', ' ', (string) $key)).': '.$value;
        }

        return implode("\n", $lines);
    }

    private function makeSubject(string $category, mixed $firstAnswer): string
    {
        $firstAnswer = is_array($firstAnswer) ? implode(', ', $firstAnswer) : (string) $firstAnswer;
        $subject = trim($firstAnswer) !== '' ? $firstAnswer : $category;

        return Str::limit($subject, 120, '');
    }

    private function inferUrgency(array $answers): string
    {
        $text = strtolower(implode(' ', Arr::flatten($answers)));

        return str_contains($text, 'more than 3 months') || str_contains($text, 'severe') || str_contains($text, 'today') ? 'high' : 'medium';
    }

    private function assignProfessional(string $category): array
    {
        $professional = User::query()
            ->where('role', 'professional')
            ->where('account_status', 'active')
            ->where('availability', 'available')
            ->get()
            ->first(function (User $user) use ($category) {
                $assigned = $user->assigned_categories ?? [];

                return in_array($category, $assigned, true) || empty($assigned);
            });

        if (! $professional) {
            return [null, 'unassigned'];
        }

        return [$professional, 'assigned'];
    }

    private function notifyAdminsIfNeeded(ConsultationRequest $consultation, ?User $professional): void
    {
        if ($professional) {
            return;
        }

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(function (User $admin) use ($consultation) {
                $this->createNotification(
                    $admin,
                    'consultation_unassigned',
                    'A consultation is awaiting manual assignment.',
                    $consultation
                );
            });
    }

    private function createNotification(User $recipient, string $type, string $message, ConsultationRequest $consultation): void
    {
        Notification::create([
            'recipient_id' => $recipient->id,
            'type' => $type,
            'message' => $message,
            'linked_entity_type' => ConsultationRequest::class,
            'linked_entity_id' => (string) $consultation->getKey(),
        ]);
    }
}
