<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    /**
     * استقبال طلب تسجيل جديد (فردي أو فريق) وتخزينه.
     */
    public function store(Request $request): JsonResponse
    {
        $this->ensureRegistrationIsOpen();

        $maxTeamSize = (int) config('hackathon.max_team_size', 6);

        $data = $request->validate([
            'participationType' => ['required', 'string', 'in:فردي,فريق'],

            'applicant.fullName' => ['required', 'string', 'max:120'],
            'applicant.email' => ['required', 'string', 'email', 'max:150'],
            'applicant.phone' => ['required', 'string', 'max:30'],
            'applicant.university' => ['required', 'string', 'max:150'],
            'applicant.major' => ['required', 'string', 'max:120'],
            'applicant.year' => ['nullable', 'string', 'max:40'],
            'applicant.skills' => ['required', 'string', 'max:500'],
            'applicant.track' => ['required', 'string', 'max:120'],
            'applicant.experience' => ['nullable', 'string', 'max:40'],
            'applicant.links' => ['nullable', 'string', 'max:255'],
            'applicant.source' => ['nullable', 'string', 'max:80'],

            'project.idea' => ['nullable', 'string', 'max:3000'],

            'team.name' => ['nullable', 'required_if:participationType,فريق', 'string', 'max:120'],
            'team.size' => ['nullable', 'required_if:participationType,فريق', 'integer', "between:2,{$maxTeamSize}"],
            'team.members' => ['nullable', 'required_if:participationType,فريق', 'array', 'min:1', 'max:'.($maxTeamSize - 1)],
            'team.members.*.name' => ['required', 'string', 'max:120'],
            'team.members.*.email' => ['required', 'string', 'email', 'max:150'],
            'team.members.*.phone' => ['nullable', 'string', 'max:30'],
            'team.members.*.role' => ['nullable', 'string', 'max:40'],
            'team.members.*.major' => ['nullable', 'string', 'max:120'],
        ], $this->messages(), $this->attributes());

        $email = (string) data_get($data, 'applicant.email');
        $members = data_get($data, 'team.members', []);

        $this->ensureEmailIsNotRegistered($email, $members);

        $registration = Registration::create([
            'reference' => $this->uniqueReference(),
            'participation_type' => $data['participationType'],

            'full_name' => data_get($data, 'applicant.fullName'),
            'email' => $email,
            'phone' => data_get($data, 'applicant.phone'),
            'university' => data_get($data, 'applicant.university'),
            'major' => data_get($data, 'applicant.major'),
            'study_year' => data_get($data, 'applicant.year'),
            'skills' => data_get($data, 'applicant.skills'),
            'track' => data_get($data, 'applicant.track'),
            'experience' => data_get($data, 'applicant.experience'),
            'portfolio' => data_get($data, 'applicant.links'),
            'source' => data_get($data, 'applicant.source'),

            'team_name' => data_get($data, 'team.name'),
            'team_size' => data_get($data, 'team.size'),
            'team_members' => $members ?: null,

            'idea' => data_get($data, 'project.idea'),

            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 255, ''),
        ]);

        return response()->json([
            'ok' => true,
            'reference' => $registration->reference,
            'message' => 'تم استلام طلب التسجيل بنجاح.',
        ], 201);
    }

    /**
     * التأكد إن باب التسجيل لسا مفتوح.
     */
    protected function ensureRegistrationIsOpen(): void
    {
        if (! config('hackathon.registration_open')) {
            throw ValidationException::withMessages([
                'registration' => 'التسجيل على الهاكاثون متوقف حالياً.',
            ]);
        }

        $deadline = Carbon::parse(config('hackathon.deadline'));

        if (now()->greaterThan($deadline)) {
            throw ValidationException::withMessages([
                'registration' => 'انتهى موعد التقديم على الهاكاثون.',
            ]);
        }
    }

    /**
     * منع تكرار التسجيل بنفس البريد الإلكتروني.
     *
     * @param  array<int, array<string, string>>  $members
     */
    protected function ensureEmailIsNotRegistered(string $email, array $members): void
    {
        $emails = array_filter(array_merge(
            [$email],
            array_column($members, 'email'),
        ));

        if (Registration::whereIn('email', array_unique($emails))->exists()) {
            throw ValidationException::withMessages([
                'applicant.email' => 'هذا البريد الإلكتروني مسجَّل مسبقاً في طلب آخر.',
            ]);
        }
    }

    /**
     * توليد رقم طلب مرجعي غير مكرّر.
     */
    protected function uniqueReference(): string
    {
        do {
            $reference = 'CAI26-'.strtoupper(Str::random(4)).random_int(10, 99);
        } while (Registration::where('reference', $reference)->exists());

        return $reference;
    }

    /**
     * رسائل التحقق بالعربي.
     *
     * @return array<string, string|array<string, string>>
     */
    protected function messages(): array
    {
        return [
            'required' => 'حقل «:attribute» مطلوب.',
            'required_if' => 'حقل «:attribute» مطلوب عند التسجيل كفريق.',
            'email' => 'صيغة البريد الإلكتروني في «:attribute» غير صحيحة.',
            'string' => 'حقل «:attribute» يجب أن يكون نصاً.',
            'integer' => 'حقل «:attribute» يجب أن يكون رقماً.',
            'in' => 'القيمة المختارة في «:attribute» غير صحيحة.',
            'array' => 'حقل «:attribute» يجب أن يكون قائمة.',
            'between' => [
                'numeric' => 'حقل «:attribute» يجب أن يكون بين :min و :max.',
                'array' => 'حقل «:attribute» يجب أن يحتوي بين :min و :max عنصر.',
                'string' => 'حقل «:attribute» يجب أن يكون بين :min و :max حرفاً.',
            ],
            'min' => [
                'numeric' => 'حقل «:attribute» يجب ألا يقل عن :min.',
                'array' => 'حقل «:attribute» يجب أن يحتوي :min عنصر على الأقل.',
                'string' => 'حقل «:attribute» يجب ألا يقل عن :min حرفاً.',
            ],
            'max' => [
                'numeric' => 'حقل «:attribute» يجب ألا يزيد عن :max.',
                'array' => 'حقل «:attribute» يجب ألا يزيد عن :max عنصر.',
                'string' => 'حقل «:attribute» يجب ألا يزيد عن :max حرفاً.',
            ],
        ];
    }

    /**
     * أسماء الحقول بالعربي داخل رسائل التحقق.
     *
     * @return array<string, string>
     */
    protected function attributes(): array
    {
        return [
            'participationType' => 'نوع المشاركة',
            'applicant.fullName' => 'الاسم الكامل',
            'applicant.email' => 'البريد الإلكتروني',
            'applicant.phone' => 'رقم الجوال',
            'applicant.university' => 'الجامعة / الجهة',
            'applicant.major' => 'التخصص',
            'applicant.year' => 'السنة الدراسية',
            'applicant.skills' => 'المهارات الأساسية',
            'applicant.track' => 'المسار المفضّل',
            'applicant.experience' => 'مستوى الخبرة',
            'applicant.links' => 'حساب GitHub / Portfolio',
            'applicant.source' => 'مصدر المعرفة بالهاكاثون',
            'project.idea' => 'فكرة المشروع',
            'team.name' => 'اسم الفريق',
            'team.size' => 'عدد أعضاء الفريق',
            'team.members' => 'أعضاء الفريق',
            'team.members.*.name' => 'اسم العضو',
            'team.members.*.email' => 'بريد العضو',
            'team.members.*.phone' => 'جوال العضو',
            'team.members.*.role' => 'التخصص في الفريق',
            'team.members.*.major' => 'تخصص العضو',
        ];
    }
}
