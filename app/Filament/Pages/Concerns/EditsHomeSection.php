<?php

namespace App\Filament\Pages\Concerns;

use App\Support\HomeContent;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/** @property Schema $form */
trait EditsHomeSection
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    abstract protected static function sectionKey(): string;

    public static function getNavigationGroup(): ?string
    {
        return 'محتوى الصفحة الرئيسية';
    }

    public function getSubheading(): ?string
    {
        return config('home-content.sections.'.static::sectionKey().'.description');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ التعديلات')
                ->icon('heroicon-o-check')
                ->action(fn () => $this->save())
                ->keyBindings(['mod+s']),
            Action::make('preview')
                ->label('معاينة الرئيسية')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(route('home'))
                ->openUrlInNewTab()
                ->color('gray'),
        ];
    }

    public function mount(): void
    {
        $this->form->fill(HomeContent::section(static::sectionKey()));
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components($this->fields())->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(config('home-content.sections.'.static::sectionKey().'.label'))
                ->description(config('home-content.sections.'.static::sectionKey().'.description'))
                ->schema([EmbeddedSchema::make('form')]),
        ]);
    }

    public function save(): void
    {
        HomeContent::save(static::sectionKey(), $this->form->getState());

        Notification::make()->success()->title('تم حفظ محتوى القسم')->body('ظهرت التعديلات الآن في الصفحة الرئيسية.')->send();
    }

    /** @return array<Component> */
    protected function fields(): array
    {
        return match (static::sectionKey()) {
            'identity' => $this->identityFields(),
            'appearance' => $this->appearanceFields(),
            'hero' => $this->heroFields(),
            'about' => $this->aboutFields(),
            'tracks' => $this->tracksFields(),
            'timeline' => $this->timelineFields(),
            'prizes_rules' => $this->prizesRulesFields(),
            'faq' => $this->faqFields(),
            'registration' => $this->registrationFields(),
            'footer' => $this->footerFields(),
            default => throw new \LogicException('Unknown homepage section.'),
        };
    }

    protected function text(string $name, string $label, bool $required = true): TextInput
    {
        return TextInput::make($name)->label($label)->required($required)->maxLength(255);
    }

    protected function area(string $name, string $label, int $rows = 3): Textarea
    {
        return Textarea::make($name)->label($label)->required()->rows($rows)->columnSpanFull();
    }

    /** @return array<Component> */
    protected function headingFields(): array
    {
        return [$this->text('eyebrow', 'العنوان الصغير'), $this->text('title', 'العنوان الرئيسي'), $this->area('description', 'الوصف')];
    }

    protected function cards(string $name, string $label): Repeater
    {
        return Repeater::make($name)->label($label)->schema([
            $this->text('title', 'العنوان'), $this->area('description', 'الوصف', 2),
        ])->columns(2)->collapsible()->reorderable()->columnSpanFull();
    }

    /** @return array<Component> */
    protected function appearanceFields(): array
    {
        return [
            Section::make('وضع الصفحة')
                ->description('يحدّد خلفية الصفحة الرئيسية وألوان النصوص والأسطح.')
                ->schema([
                    ToggleButtons::make('mode')
                        ->label('وضع الألوان')
                        ->options(['light' => 'فاتح', 'dark' => 'داكن'])
                        ->default('light')
                        ->inline()
                        ->required()
                        ->helperText('الوضع الفاتح هو الافتراضي، والداكن يستخدم نفس ألوان الهوية على خلفية غامقة.'),
                ]),

            Section::make('الألوان الأساسية')
                ->description('كل الألوان على الصفحة مشتقّة من هذه الألوان الثلاثة.')
                ->schema([
                    ColorPicker::make('primary_color')->label('اللون الأساسي (Primary)')->default('#F1791E')->required()->helperText('اللون الأبرز: أزرار الإجراء الأساسية والعناوين المميزة.'),
                    ColorPicker::make('secondary_color')->label('اللون الثانوي (Secondary)')->default('#66AC2F')->required()->helperText('اللون المساند: الشارات وعلامات الصح والتأكيدات.'),
                    ColorPicker::make('base_color')->label('اللون الداكن (Base)')->default('#2A3876')->required()->helperText('يُستخدم للنصوص والعناوين والأسطح الداكنة مثل التذييل والشريط العلوي.'),
                ])
                ->columns(3),

            Section::make('نسبة توزيع اللونين')
                ->description('تتحكّم بمقدار ظهور اللون الأساسي مقابل اللون الثانوي في التدرّجات والشريط الملوّن.')
                ->schema([
                    Slider::make('tone_split')
                        ->label('نسبة اللون الأساسي مقابل اللون الثانوي')
                        ->range(0, 100)
                        ->step(5)
                        ->default(50)
                        ->helperText('0% = اللون الثانوي فقط، 50% = مناصفة، 100% = اللون الأساسي فقط.'),
                ]),

            Section::make('خلفية الصفحة')
                ->description('الشبكة المتحركة خلف المحتوى.')
                ->schema([
                    Toggle::make('background_enabled')
                        ->label('تشغيل الخلفية المتحركة')
                        ->default(true)
                        ->helperText('عند إيقافها تصبح الخلفية لونًا صافيًا بدون حركة.'),
                ]),
        ];
    }
    /** @return array<Component> */
    protected function identityFields(): array
    {
        return [
            Section::make('الأيقونة')
                ->description('شعار الموقع وأيقونة المتصفح وصورة المشاركة. الملفات المرفوعة تُخزَّن في storage/app/public/branding.')
                ->schema([
                    FileUpload::make('logo_light_path')->label('شعار الموقع — الوضع الفاتح')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072)->helperText('يظهر في الهيدر والتذييل بالوضع الفاتح.'),
                    FileUpload::make('logo_dark_path')->label('شعار الموقع — الوضع الداكن')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072)->helperText('يظهر في الهيدر والتذييل بالوضع الداكن. لو تركته فارغًا بيُستخدم شعار الوضع الفاتح.'),
                    FileUpload::make('icon_path')->label('أيقونة الموقع (Favicon)')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(1024)->helperText('الأيقونة الصغيرة في تبويب المتصفح — مربّعة يُفضّل.'),
                    FileUpload::make('share_image_path')->label('صورة المشاركة على السوشيال ميديا')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(5120)->helperText('تظهر عند مشاركة رابط الصفحة. المقاس المفضّل 1200×630، ولو تركتها فارغة بيُستخدم شعار الموقع.'),
                ])
                ->columns(2),

            Section::make('شعارات الجهتين')
                ->description('شعار النادي الهندسي وشعار حاضنة يوكاس التكنولوجية. لكل واحد نسخة للوضع الفاتح ونسخة للوضع الداكن — لو رفعت نسخة واحدة بتُستخدم في الوضعين، ولو ما رفعت شي بيظهر مكان الشعار الفاضي.')
                ->schema([
                    FileUpload::make('engineering_logo_light_path')->label('شعار النادي الهندسي — الوضع الفاتح')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072),
                    FileUpload::make('engineering_logo_dark_path')->label('شعار النادي الهندسي — الوضع الداكن')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072)->helperText('لو فارغ بيُستخدم شعار الوضع الفاتح.'),
                    FileUpload::make('incubator_logo_light_path')->label('شعار حاضنة يوكاس — الوضع الفاتح')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072),
                    FileUpload::make('incubator_logo_dark_path')->label('شعار حاضنة يوكاس — الوضع الداكن')->image()->disk('public')->directory('branding')->visibility('public')->maxSize(3072)->helperText('لو فارغ بيُستخدم شعار الوضع الفاتح.'),
                ])
                ->columns(2),
            Section::make('محركات البحث')->schema([$this->text('page_title', 'عنوان الصفحة'), $this->area('meta_description', 'وصف الصفحة')]),
            Section::make('هوية الحدث')->schema([$this->text('brand_ar', 'الاسم بالعربية'), $this->text('brand_en', 'الاسم بالإنجليزية'), $this->text('location', 'الموقع'), $this->text('email', 'البريد')->email(), $this->text('phone', 'رقم الهاتف')])->columns(2),
            Section::make('روابط التواصل')->schema([$this->text('facebook_url', 'فيسبوك', false)->url(), $this->text('instagram_url', 'إنستغرام', false)->url(), $this->text('telegram_url', 'تيليجرام', false)->url(), $this->text('linkedin_url', 'لينكدإن', false)->url()])->columns(2)->collapsed(),
            Section::make('تسميات القائمة')->schema([$this->text('nav.about', 'عن الهاكاثون'), $this->text('nav.tracks', 'المسارات'), $this->text('nav.timeline', 'الجدول'), $this->text('nav.prizes', 'الجوائز'), $this->text('nav.rules', 'الشروط'), $this->text('nav.faq', 'الأسئلة'), $this->text('nav.register', 'زر التسجيل')])->columns(2),
            Section::make('النصوص البديلة وإمكانية الوصول')->schema([$this->text('accessibility.main_nav', 'وصف التنقل'), $this->text('accessibility.home', 'وصف رابط الرئيسية'), $this->text('accessibility.open_menu', 'وصف زر القائمة'), $this->text('accessibility.participation_type', 'وصف اختيار المشاركة'), $this->text('accessibility.back_to_top', 'وصف زر العودة'), $this->text('logo_alt', 'وصف شعار الحدث'), $this->text('logo_placeholder', 'بديل شعار الحدث'), $this->text('engineering_logo_alt', 'وصف شعار النادي'), $this->text('engineering_logo_placeholder', 'بديل شعار النادي'), $this->text('incubator_logo_alt', 'وصف شعار الحاضنة'), $this->text('incubator_logo_placeholder', 'بديل شعار الحاضنة')])->columns(2)->collapsed(),
        ];
    }

    /** @return array<Component> */
    protected function heroFields(): array
    {
        return [
            Section::make('حالة التسجيل')->schema([Toggle::make('registration_open')->label('التسجيل مفتوح')->helperText('عند إغلاقه تتغير الشارة ويتوقف إرسال النموذج.'), $this->text('status_open', 'نص الحالة المفتوحة'), $this->text('status_closed', 'نص الحالة المغلقة'), $this->text('deadline', 'موعد الإغلاق بصيغة ISO', false)->placeholder('2026-10-01T18:00:00+03:00')])->columns(2),
            Section::make('المقدمة الرئيسية')->schema([$this->text('partner_badge', 'شارة الشركاء'), $this->text('title_top', 'السطر الإنجليزي الأول'), $this->text('title_main', 'الكلمة الرئيسية'), $this->text('title_year', 'السنة'), $this->text('subtitle', 'العنوان العربي'), $this->area('description', 'الوصف الرئيسي', 5), $this->text('terminal_text', 'سطر الطرفية'), $this->text('primary_button', 'الزر الرئيسي'), $this->text('secondary_button', 'الزر الثانوي')])->columns(2),
            Section::make('بيانات سريعة والعداد')->schema([$this->text('event_dates', 'تواريخ الحدث'), $this->text('duration', 'المدة'), $this->text('team_format', 'تكوين الفريق'), $this->text('countdown_title', 'عنوان العداد'), $this->text('deadline_label', 'تسمية الموعد'), $this->text('countdown_units.days', 'وحدة الأيام'), $this->text('countdown_units.hours', 'وحدة الساعات'), $this->text('countdown_units.minutes', 'وحدة الدقائق'), $this->text('countdown_units.seconds', 'وحدة الثواني'), $this->text('deadline_ended', 'رسالة انتهاء الموعد'), $this->text('registration_paused', 'رسالة إيقاف التسجيل'), $this->text('remaining_prefix', 'بادئة الوقت المتبقي'), $this->area('closed_message', 'رسالة انتهاء التسجيل'), TagsInput::make('ticker')->label('عبارات الشريط المتحرك')->separator(',')->columnSpanFull()])->columns(2),
        ];
    }

    /** @return array<Component> */
    protected function aboutFields(): array
    {
        return [Section::make('الشركاء')->schema([$this->area('partners_note', 'عبارة الشركاء')]), Section::make('مقدمة القسم')->schema($this->headingFields())->columns(2), Section::make('بطاقات التعريف')->schema([$this->cards('cards', 'البطاقات')]), Section::make('برنامج الساعات')->schema([Repeater::make('schedule')->label('المحطات')->schema([$this->text('time', 'الوقت'), $this->text('text', 'النص')])->columns(2)->reorderable()->collapsible()])];
    }

    /** @return array<Component> */
    protected function tracksFields(): array
    {
        return [Section::make('عنوان القسم')->schema($this->headingFields())->columns(2), Section::make('المسارات')->schema([$this->cards('items', 'مسارات التحدي')]), Section::make('المزايا المختصرة')->schema([TagsInput::make('chips')->label('المزايا')->columnSpanFull()])];
    }

    /** @return array<Component> */
    protected function timelineFields(): array
    {
        return [Section::make('عنوان القسم')->schema($this->headingFields())->columns(2), Section::make('المراحل')->schema([Repeater::make('items')->label('المراحل الزمنية')->schema([$this->text('date', 'التاريخ'), $this->text('title', 'العنوان'), $this->area('description', 'الوصف', 2)])->columns(2)->reorderable()->collapsible()]), Section::make('بطاقات جانبية')->schema([$this->cards('notes', 'الرسائل')])];
    }

    /** @return array<Component> */
    protected function prizesRulesFields(): array
    {
        return [
            Section::make('قسم الجوائز')->schema([$this->text('prizes_eyebrow', 'العنوان الصغير'), $this->text('prizes_title', 'العنوان'), $this->area('prizes_description', 'الوصف'), Repeater::make('prizes')->label('المراكز')->schema([$this->text('rank', 'الترتيب'), $this->text('amount', 'قيمة الجائزة'), $this->text('title', 'اسم المركز'), $this->area('description', 'التفاصيل', 2)])->columns(2)->reorderable(), TagsInput::make('extra_prizes')->label('جوائز ومزايا إضافية')]),
            Section::make('قسم الشروط')->schema([$this->text('rules_eyebrow', 'العنوان الصغير'), $this->text('rules_title', 'العنوان'), $this->area('rules_description', 'الوصف'), $this->text('eligibility_title', 'عنوان شروط الأهلية'), TagsInput::make('eligibility')->label('شروط الأهلية'), $this->text('event_rules_title', 'عنوان قواعد الحدث'), TagsInput::make('event_rules')->label('قواعد الحدث')]),
        ];
    }

    /** @return array<Component> */
    protected function faqFields(): array
    {
        return [Section::make('عنوان القسم')->schema($this->headingFields())->columns(2), Section::make('الأسئلة والأجوبة')->schema([Repeater::make('items')->label('الأسئلة')->schema([$this->text('question', 'السؤال'), $this->area('answer', 'الإجابة', 2)])->reorderable()->collapsible()->itemLabel(fn (array $state): ?string => $state['question'] ?? null)])];
    }

    /** @return array<Component> */
    protected function registrationFields(): array
    {
        return [
            Section::make('مقدمة التسجيل')->schema(array_merge($this->headingFields(), [$this->text('deadline_card_title', 'عنوان بطاقة الموعد'), $this->text('venue_card_title', 'عنوان بطاقة المكان'), $this->text('contact_card_title', 'عنوان بطاقة التواصل'), $this->text('preparation_title', 'عنوان قائمة التحضير'), TagsInput::make('preparation_items')->label('عناصر قائمة التحضير'), $this->text('individual_tab', 'تبويب الفردي'), $this->text('team_tab', 'تبويب الفريق'), $this->text('participant_title', 'عنوان بيانات الفرد'), $this->text('leader_title', 'عنوان بيانات قائد الفريق')]))->columns(2),
            Section::make('تسميات حقول النموذج')->schema(array_map(fn (string $key) => $this->text("fields.{$key}", str($key)->replace('_', ' ')->headline()), ['full_name', 'email', 'phone', 'university', 'major', 'year', 'skills', 'track', 'experience', 'team_data', 'team_name', 'team_size', 'members', 'add_member', 'project', 'idea', 'links', 'source']))->columns(2)->collapsed(),
            Section::make('النصوص المساعدة')->schema(array_map(fn (string $key) => $this->text("placeholders.{$key}", "مثال: {$key}"), ['full_name', 'university', 'major', 'skills', 'team_name', 'idea']))->columns(2)->collapsed(),
            Section::make('خيارات القوائم')->schema([TagsInput::make('year_options')->label('السنوات الدراسية'), TagsInput::make('experience_options')->label('مستويات الخبرة'), TagsInput::make('source_options')->label('مصادر معرفة الحدث'), TagsInput::make('team_sizes')->label('أحجام الفرق'), TagsInput::make('role_options')->label('تخصصات أعضاء الفريق'), $this->text('select_placeholder', 'عبارة الاختيار'), $this->text('track_placeholder', 'عبارة اختيار المسار'), $this->text('track_unsure', 'خيار غير محدد')])->columns(2)->collapsed(),
            Section::make('حقول أعضاء الفريق')->schema([$this->text('member_label', 'تسمية العضو'), $this->text('remove_member', 'زر حذف العضو'), $this->text('member_name_placeholder', 'مثال اسم العضو'), $this->text('member_role_label', 'تسمية تخصص العضو'), $this->text('member_skill_label', 'تسمية دور العضو'), $this->text('member_skill_placeholder', 'مثال دور العضو'), $this->text('members_hint', 'ملاحظة الأعضاء'), $this->area('idea_hint', 'ملاحظة فكرة المشروع')])->columns(2)->collapsed(),
            Section::make('رسائل التحقق والحالة')->schema(array_map(fn (string $key) => $this->text("client_messages.{$key}", str($key)->replace('_', ' ')->headline()), ['full_name_required', 'email_required', 'phone_required', 'university_required', 'major_required', 'skills_required', 'track_required', 'invalid_email', 'invalid_phone', 'team_name_required', 'team_size_required', 'member_name_required', 'member_email_required', 'agreement_required', 'fix_fields', 'registration_closed', 'sending', 'send_failed', 'max_members']))->columns(2)->collapsed(),
            Section::make('التعليمات والإرسال')->schema([$this->area('team_note', 'ملاحظة تكوين الفريق'), $this->area('agreement', 'نص التعهد'), $this->text('submit', 'زر الإرسال'), $this->area('privacy_note', 'ملاحظة الخصوصية')])->columns(2),
            Section::make('نافذة النتيجة')->schema([$this->text('success_title', 'عنوان النجاح'), $this->area('success_message', 'رسالة النجاح'), $this->text('failure_title', 'عنوان الفشل'), $this->area('failure_message', 'رسالة الفشل'), $this->text('reference_label', 'تسمية رقم الطلب'), $this->text('whatsapp_button', 'زر واتساب'), $this->text('download_button', 'زر التحميل'), $this->text('close_button', 'زر الإغلاق')])->columns(2),
        ];
    }

    /** @return array<Component> */
    protected function footerFields(): array
    {
        return [Section::make('محتوى التذييل')->schema([$this->area('description', 'وصف الجهة المنظمة'), $this->text('quick_links_title', 'عنوان الروابط'), $this->text('contact_title', 'عنوان التواصل'), $this->text('partner_line', 'سطر الشريك'), $this->text('copyright', 'حقوق النشر'), $this->text('signature', 'التوقيع الإنجليزي')])->columns(2)];
    }
}
