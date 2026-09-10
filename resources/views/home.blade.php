<!doctype html>
    @php
            $identity = $home['identity']; $hero = $home['hero']; $about = $home['about'];
            $tracks = $home['tracks']; $timeline = $home['timeline']; $prizesRules = $home['prizes_rules'];
            $faq = $home['faq']; $registration = $home['registration']; $footer = $home['footer'];
            $appearance = $home['appearance'];
            $primaryColor = $appearance['primary_color'] ?? '#F1791E';
            $secondaryColor = $appearance['secondary_color'] ?? '#66AC2F';
            $baseColor = $appearance['base_color'] ?? '#2A3876';
            $toneSplit = (int) ($appearance['tone_split'] ?? 50);
            $themeMode = ($appearance['mode'] ?? 'light') === 'dark' ? 'dark' : 'light';
            $backgroundOn = (bool) ($appearance['background_enabled'] ?? true);

            // صور الهوية: لكل شعار نسخة فاتحة ونسخة داكنة، ومع الرجوع للنسخة
            // الثانية ثم للشعار المشترك ثم للملف الافتراضي (App\Support\BrandAssets).
            $logo = \App\Support\BrandAssets::info(\App\Support\BrandAssets::upload($identity, 'logo', $themeMode), 'images/hackathon-logo.png');
            $clubLogo = \App\Support\BrandAssets::info(\App\Support\BrandAssets::upload($identity, 'engineering_logo', $themeMode), 'images/eng-club.png');
            $incubatorLogo = \App\Support\BrandAssets::info(\App\Support\BrandAssets::upload($identity, 'incubator_logo', $themeMode), 'images/ucas.png');

            $iconUpload = trim((string) ($identity['icon_path'] ?? ''));
            $icon = \App\Support\BrandAssets::info($iconUpload, 'favicon.ico');
            $appleIcon = \App\Support\BrandAssets::info($iconUpload, 'apple-touch-icon.png');

            $shareUpload = trim((string) ($identity['share_image_path'] ?? ''));
            $share = $shareUpload !== ''
                ? \App\Support\BrandAssets::info($shareUpload, 'images/hackathon-logo.png')
                : \App\Support\BrandAssets::info('', 'images/share-default.png');

            $logoSrc = $logo['url'];
            $clubLogoSrc = $clubLogo['url'];
            $incubatorLogoSrc = $incubatorLogo['url'];
            $iconSrc = $icon['url'];
            $shareSrc = $share['url'];    @endphp
<html lang="ar" dir="rtl" data-theme="{{ $themeMode }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ $identity['page_title'] }}</title>
        <meta
            name="description"
            content="{{ $identity['meta_description'] }}"
        />
        <meta name="theme-color" content="{{ $themeMode === 'dark' ? '#0A0F1F' : '#FFFFFF' }}" />

        <link rel="canonical" href="{{ url()->current() }}" />

        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="{{ $identity['brand_ar'] }}" />
        <meta property="og:locale" content="ar_AR" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="{{ $identity['page_title'] }}" />
        <meta
            property="og:description"
            content="{{ $identity['meta_description'] }}"
        />
        <meta property="og:image" content="{{ $shareSrc }}" />
        @if (str_starts_with($shareSrc, "https://"))
            <meta property="og:image:secure_url" content="{{ $shareSrc }}" />
        @endif
        <meta property="og:image:type" content="{{ $share['mime'] }}" />
        @if ($share['width'] > 0 && $share['height'] > 0)
            <meta property="og:image:width" content="{{ $share['width'] }}" />
            <meta property="og:image:height" content="{{ $share['height'] }}" />
        @endif
        <meta property="og:image:alt" content="{{ $identity['logo_alt'] }}" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $identity['page_title'] }}" />
        <meta name="twitter:description" content="{{ $identity['meta_description'] }}" />
        <meta name="twitter:image" content="{{ $shareSrc }}" />

        <link rel="icon" href="{{ $iconSrc }}" sizes="any" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon-32.png') }}" />
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon-192.png') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleIcon['url'] }}" />
        <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Orbitron:wght@600;800;900&family=Share+Tech+Mono&display=swap"
            rel="stylesheet"
        />

        <script>
            // علامة إن الجافاسكربت شغّال — بتفعّل أنيميشن الظهور فقط عندها
            document.documentElement.classList.add('js');
        </script>

        <style>
            /* =========================================================
               هاكاثون السايبر والذكاء الاصطناعي 2026
               النادي الهندسي — لجنة الأنشطة — هندسة الحاسوب
               الوضع النهاري (Light Mode) + ألوان الهوية الرسمية
               ========================================================= */

            :root {
                /* ===== الألوان القابلة للتحكم من لوحة الإدارة ===== */
                --primary: {{ $primaryColor }};
                --secondary: {{ $secondaryColor }};
                --base: {{ $baseColor }};
                /* نسبة اللون الأساسي مقابل الثانوي (0 = الثانوي فقط، 100 = الأساسي فقط) */
                --tone-split: {{ $toneSplit }}%;

                /* ===== اشتقاقات تلقائية من الألوان الثلاثة ===== */
                --primary-ink: color-mix(in srgb, var(--primary) 78%, #000000);
                --secondary-ink: color-mix(in srgb, var(--secondary) 78%, #000000);
                --base-dark: color-mix(in srgb, var(--base) 78%, #000000);
                --strong: var(--base);
                --primary-soft: color-mix(in srgb, var(--primary) 9%, var(--surface));
                --secondary-soft: color-mix(in srgb, var(--secondary) 10%, var(--surface));
                --base-soft: color-mix(in srgb, var(--base) 6%, var(--surface));
                --danger: var(--danger);
                --danger-ink: var(--danger-ink);
                --danger-soft: var(--danger-soft);

                /* تدرّج اللونين — يتحكّم فيه شريط النسبة */
                --two-tone: linear-gradient(
                    100deg,
                    var(--primary) 0%,
                    var(--primary) calc(var(--tone-split) - 6%),
                    var(--secondary) calc(var(--tone-split) + 6%),
                    var(--secondary) 100%
                );

                /* خلفية الحروف المتحركة */
                --matrix-fade: rgba(255, 255, 255, 0.09);
                --matrix-head: color-mix(in srgb, var(--base) 26%, transparent);
                --matrix-accent: color-mix(in srgb, var(--primary) 42%, transparent);
                --matrix-body: color-mix(in srgb, var(--secondary) 18%, transparent);

                /* ===== مرادفات للأنماط الحالية ===== */
                --orange: var(--primary);
                --orange-dark: var(--primary-ink);
                --orange-soft: var(--primary-soft);
                --green: var(--secondary);
                --green-dark: var(--secondary-ink);
                --green-soft: var(--secondary-soft);
                --navy: var(--strong);
                --navy-dark: var(--base-dark);
                --navy-soft: var(--base-soft);

                /* ===== الوضع الفاتح (الافتراضي) ===== */
                --surface: #ffffff;
                --bg: #ffffff;
                --header-bg: color-mix(in srgb, var(--bg) 88%, transparent);
                --logo-card-bg: #ffffff;
                --bg-soft: #f6f8fc;
                --ink: #1b2244;
                --ink-2: #37406b;
                --muted: #5d6684;
                --line: color-mix(in srgb, var(--base) 13%, transparent);
                --line-2: color-mix(in srgb, var(--base) 9%, transparent);
                --shadow-sm: 0 1px 2px rgba(27, 34, 68, 0.04), 0 4px 14px -8px rgba(27, 34, 68, 0.14);
                --shadow: 0 20px 45px -28px color-mix(in srgb, var(--base) 45%, transparent);

                --radius: 18px;
                --radius-sm: 12px;
                --wrap: 1180px;

                --font-ar: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
                --font-mono: 'Share Tech Mono', ui-monospace, Consolas, monospace;
                --font-en: 'Cairo', 'Segoe UI', sans-serif;
            }

            /* ===== الوضع الداكن ===== */
            [data-theme='dark'] {
                --surface: #131a33;
                --bg: #0a0f1f;
                --header-bg: color-mix(in srgb, var(--bg) 86%, transparent);
                --logo-card-bg: rgba(255, 255, 255, 0.07);
                --bg-soft: #172042;
                --ink: #eef2ff;
                --ink-2: #c6d0ee;
                --muted: #94a1c6;
                --line: rgba(255, 255, 255, 0.14);
                --line-2: rgba(255, 255, 255, 0.08);
                --strong: color-mix(in srgb, var(--base) 32%, #ffffff);
                --primary-ink: color-mix(in srgb, var(--primary) 60%, #ffffff);
                --secondary-ink: color-mix(in srgb, var(--secondary) 60%, #ffffff);
                --base-dark: color-mix(in srgb, var(--base) 55%, #000000);
                --primary-soft: color-mix(in srgb, var(--primary) 18%, var(--surface));
                --secondary-soft: color-mix(in srgb, var(--secondary) 18%, var(--surface));
                --base-soft: color-mix(in srgb, var(--base) 28%, var(--surface));
                --danger-ink: #ff9b9b;
                --danger-soft: color-mix(in srgb, var(--danger) 18%, var(--surface));
                --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.5), 0 4px 14px -8px rgba(0, 0, 0, 0.6);
                --shadow: 0 20px 45px -28px rgba(0, 0, 0, 0.95);
                --matrix-fade: rgba(10, 15, 31, 0.13);
                --matrix-head: rgba(255, 255, 255, 0.12);
                --matrix-accent: color-mix(in srgb, var(--primary) 55%, transparent);
                --matrix-body: color-mix(in srgb, var(--secondary) 14%, transparent);
            }
            * {
                box-sizing: border-box;
            }

            /* لازم: بعض العناصر عندها display صريح وبيتغلّب على خاصية hidden */
            [hidden] {
                display: none !important;
            }

            html {
                scroll-behavior: smooth;
                scroll-padding-top: 96px;
                -webkit-text-size-adjust: 100%;
            }

            body {
                margin: 0;
                background: var(--bg);
                color: var(--ink);
                font-family: var(--font-ar);
                font-size: 16px;
                line-height: 1.75;
                overflow-x: hidden;
                -webkit-font-smoothing: antialiased;
            }

            body.is-locked {
                overflow: hidden;
            }

            img {
                max-width: 100%;
                display: block;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            button {
                font: inherit;
                color: inherit;
            }

            h1,
            h2,
            h3,
            h4 {
                margin: 0;
                line-height: 1.3;
                font-weight: 800;
                letter-spacing: -0.01em;
                color: var(--ink);
            }

            p {
                margin: 0;
            }

            ::selection {
                background: var(--orange);
                color: #fff;
            }

            :focus-visible {
                outline: 2px solid var(--navy);
                outline-offset: 3px;
                border-radius: 6px;
            }

            /* ---------- خلفيات الصفحة ---------- */
            #matrix {
                position: fixed;
                inset: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                opacity: 1;
                pointer-events: none;
            }

            .fx {
                position: fixed;
                inset: 0;
                z-index: 1;
                pointer-events: none;
            }

            .fx-grid {
                position: absolute;
                inset: -1px;
                background-image: linear-gradient(
                        to right,
                        color-mix(in srgb, var(--base) 5%, transparent) 1px,
                        transparent 1px
                    ),
                    linear-gradient(
                        to bottom,
                        color-mix(in srgb, var(--base) 5%, transparent) 1px,
                        transparent 1px
                    );
                background-size: 64px 64px;
                mask-image: radial-gradient(
                    ellipse 90% 65% at 50% 0%,
                    #000 15%,
                    transparent 75%
                );
                -webkit-mask-image: radial-gradient(
                    ellipse 90% 65% at 50% 0%,
                    #000 15%,
                    transparent 75%
                );
            }

            /* لمسات لونية ناعمة بدل الخلفية الداكنة */
            .fx-vignette {
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(
                        ellipse 70% 50% at 100% 0%,
                        color-mix(in srgb, var(--primary) 9%, transparent),
                        transparent 62%
                    ),
                    radial-gradient(
                        ellipse 60% 45% at 0% 8%,
                        color-mix(in srgb, var(--secondary) 9%, transparent),
                        transparent 62%
                    ),
                    radial-gradient(
                        ellipse 90% 60% at 50% 100%,
                        color-mix(in srgb, var(--base) 5%, transparent),
                        transparent 70%
                    );
            }

            .fx-scan,
            .fx-noise {
                display: none;
            }

            #cursorGlow {
                position: fixed;
                top: 0;
                right: 0;
                width: 520px;
                height: 520px;
                margin: -260px -260px 0 0;
                border-radius: 50%;
                background: radial-gradient(
                    circle,
                    color-mix(in srgb, var(--secondary) 9%, transparent),
                    color-mix(in srgb, var(--primary) 6%, transparent) 42%,
                    transparent 68%
                );
                z-index: 1;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.4s ease;
                will-change: transform;
            }

            @media (pointer: fine) {
                #cursorGlow.on {
                    opacity: 1;
                }
            }

            #progress {
                position: fixed;
                top: 0;
                right: 0;
                height: 3px;
                width: 0%;
                z-index: 90;
                background: var(--two-tone);
            }

            [data-theme='dark'] #matrix {
                opacity: 0.62;
            }

            /* ---------- أدوات عامة ---------- */
            .wrap {
                width: 100%;
                max-width: var(--wrap);
                margin-inline: auto;
                padding-inline: 22px;
                position: relative;
                z-index: 2;
            }

            .mono {
                font-family: var(--font-mono);
                letter-spacing: 0.02em;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                font-family: var(--font-mono);
                font-size: 13px;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: var(--orange-dark);
            }

            .eyebrow::before {
                content: '';
                width: 26px;
                height: 2px;
                border-radius: 2px;
                background: linear-gradient(90deg, transparent, var(--orange));
            }

            .sec {
                padding: 92px 0;
                position: relative;
            }

            .sec-head {
                max-width: 760px;
                margin-bottom: 48px;
            }

            .sec-head h2 {
                font-size: clamp(1.7rem, 4.2vw, 2.6rem);
                margin: 14px 0;
            }

            .sec-head p {
                color: var(--muted);
                font-size: 1.03rem;
            }

            .grad {
                background: var(--two-tone);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .card {
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: var(--radius);
                padding: 26px;
                position: relative;
                overflow: hidden;
                box-shadow: var(--shadow-sm);
                transition:
                    transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1),
                    border-color 0.35s,
                    box-shadow 0.35s;
            }

            .card::before {
                content: '';
                position: absolute;
                inset: 0 0 auto;
                height: 3px;
                background: var(--two-tone);
                opacity: 0;
                transition: opacity 0.35s;
            }

            .card:hover {
                transform: translateY(-5px);
                border-color: color-mix(in srgb, var(--base) 20%, transparent);
                box-shadow: 0 24px 50px -30px color-mix(in srgb, var(--base) 55%, transparent);
            }

            .card:hover::before {
                opacity: 1;
            }

            /* ---------- الأزرار ---------- */
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                padding: 15px 30px;
                border-radius: 999px;
                font-weight: 800;
                font-size: 1rem;
                border: 1px solid transparent;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                transition:
                    transform 0.25s,
                    box-shadow 0.3s,
                    background 0.3s,
                    border-color 0.3s,
                    color 0.3s;
                white-space: nowrap;
            }

            .btn:active {
                transform: translateY(1px) scale(0.99);
            }

            .btn-primary {
                background: linear-gradient(100deg, var(--orange), color-mix(in srgb, var(--primary) 78%, #ffffff));
                color: #fff;
                box-shadow: 0 14px 30px -16px color-mix(in srgb, var(--primary) 95%, transparent);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 40px -18px color-mix(in srgb, var(--primary) 100%, transparent);
            }

            .btn-ghost {
                background: var(--surface);
                border-color: var(--line);
                color: var(--navy);
                box-shadow: var(--shadow-sm);
            }

            .btn-ghost:hover {
                border-color: var(--navy);
                background: var(--navy-soft);
                transform: translateY(-2px);
            }

            .btn-green {
                background: linear-gradient(100deg, var(--green), color-mix(in srgb, var(--secondary) 78%, #ffffff));
                color: #fff;
                box-shadow: 0 14px 30px -16px color-mix(in srgb, var(--secondary) 95%, transparent);
            }

            .btn-green:hover {
                transform: translateY(-2px);
            }

            .btn-navy {
                background: var(--base);
                color: #fff;
            }

            .btn-navy:hover {
                background: var(--base-dark);
                transform: translateY(-2px);
            }

            .btn-block {
                width: 100%;
            }

            .btn[disabled] {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none !important;
            }

            /* أنيميشن الظهور عند التمرير.
               مربوط بكلاس .js على <html> — لو الجافاسكربت متوقّف
               بيضل المحتوى ظاهر وما بتطلع الصفحة فاضية. */
            .js [data-reveal] {
                opacity: 0;
                transform: translateY(26px);
                transition:
                    opacity 0.7s cubic-bezier(0.2, 0.7, 0.2, 1),
                    transform 0.7s cubic-bezier(0.2, 0.7, 0.2, 1);
            }

            .js [data-reveal].in {
                opacity: 1;
                transform: none;
            }

            /* ---------- الهيدر ---------- */
            header {
                position: fixed;
                top: 0;
                right: 0;
                left: 0;
                z-index: 80;
                transition:
                    background 0.4s,
                    border-color 0.4s,
                    box-shadow 0.4s;
                border-bottom: 1px solid transparent;
            }

            header.stuck {
                background: var(--header-bg);
                backdrop-filter: blur(16px) saturate(1.4);
                border-bottom-color: var(--line);
                box-shadow: var(--shadow-sm);
            }

            .nav {
                display: flex;
                align-items: center;
                gap: 18px;
                min-height: 78px;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-shrink: 0;
            }

            .brand-card {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 52px;
                padding: 0 12px;
                border-radius: 12px;
                background: var(--surface);
                border: 1px solid var(--line);
                box-shadow: var(--shadow-sm);
                flex-shrink: 0;
            }

            .brand-card img {
                height: 36px;
                width: auto;
                max-width: 190px;
                object-fit: contain;
            }

            .brand-card.lg {
                height: 62px;
                padding: 0 14px;
            }

            .brand-card.lg img {
                height: 44px;
                max-width: 240px;
            }

            .brand-card img + .slot-hint {
                display: none;
            }

            .brand-card:not(:has(img)) {
                background: var(--navy-soft);
                border: 1.5px dashed color-mix(in srgb, var(--base) 35%, transparent);
                box-shadow: none;
            }

            .brand-txt {
                display: flex;
                flex-direction: column;
                line-height: 1.25;
            }

            .brand-txt b {
                font-size: 0.92rem;
                font-weight: 800;
                color: var(--ink);
            }

            .brand-txt span {
                font-family: var(--font-mono);
                font-size: 10.5px;
                letter-spacing: 0.14em;
                color: var(--orange-dark);
                text-transform: uppercase;
            }

            .nav-links {
                display: flex;
                align-items: center;
                gap: 4px;
                margin-inline-start: auto;
            }

            .nav-links a {
                padding: 9px 13px;
                border-radius: 10px;
                font-size: 0.93rem;
                font-weight: 700;
                color: var(--ink-2);
                transition:
                    color 0.2s,
                    background 0.2s;
            }

            .nav-links a:hover {
                color: var(--navy);
                background: var(--navy-soft);
            }

            .nav-cta {
                margin-inline-start: 10px;
                padding: 12px 22px !important;
                font-size: 0.92rem;
            }

            .burger {
                display: none;
                width: 46px;
                height: 46px;
                border-radius: 12px;
                border: 1px solid var(--line);
                background: var(--surface);
                align-items: center;
                justify-content: center;
                cursor: pointer;
                margin-inline-start: auto;
                box-shadow: var(--shadow-sm);
            }

            .burger span {
                display: block;
                width: 20px;
                height: 2px;
                background: var(--navy);
                position: relative;
            }

            .burger span::before,
            .burger span::after {
                content: '';
                position: absolute;
                right: 0;
                width: 20px;
                height: 2px;
                background: var(--navy);
                transition: transform 0.3s;
            }

            .burger span::before {
                top: -6px;
            }

            .burger span::after {
                top: 6px;
            }

            .burger.open span {
                background: transparent;
            }

            .burger.open span::before {
                transform: translateY(6px) rotate(45deg);
            }

            .burger.open span::after {
                transform: translateY(-6px) rotate(-45deg);
            }

            .drawer {
                display: none;
                flex-direction: column;
                gap: 4px;
                padding: 12px 22px 26px;
                background: var(--surface);
                border-bottom: 1px solid var(--line);
                box-shadow: 0 24px 40px -30px rgba(27, 34, 68, 0.6);
            }

            .drawer.open {
                display: flex;
            }

            .drawer a {
                padding: 14px 12px;
                border-radius: 12px;
                font-weight: 700;
                border-bottom: 1px solid var(--line-2);
            }

            /* ---------- مكان الشعار ---------- */
            .logo-slot {
                position: relative;
                display: grid;
                place-items: center;
                width: 100%;
                height: 100%;
                min-width: 120px;
                padding: 12px 18px;
                border-radius: 14px;
                border: 1.5px dashed color-mix(in srgb, var(--base) 30%, transparent);
                background: var(--navy-soft);
                text-align: center;
                transition:
                    border-color 0.3s,
                    background 0.3s;
            }

            .logo-slot img {
                max-width: 100%;
                max-height: 84px;
                width: auto;
                height: auto;
                object-fit: contain;
            }

            .partner .logo-slot img {
                max-height: 92px;
            }

            .foot-orgs .logo-slot img {
                max-height: 58px;
            }

            .logo-slot img + .slot-hint {
                display: none;
            }

            .logo-slot:has(img) {
                border-color: transparent;
                background: transparent;
                padding: 0;
            }

            .logo-slot.slot-light:has(img) {
                background: var(--logo-card-bg);
                padding: 10px 14px;
                border: 1px solid var(--line);
                border-radius: 14px;
                box-shadow: var(--shadow-sm);
            }

            .slot-hint {
                font-size: 12.5px;
                font-weight: 700;
                color: var(--navy);
                line-height: 1.5;
                opacity: 0.7;
            }

            .slot-hint small {
                display: block;
                font-family: var(--font-mono);
                font-size: 9.5px;
                letter-spacing: 0.1em;
                color: var(--orange-dark);
                margin-top: 3px;
            }

            /* ---------- الهيرو ---------- */
            .hero {
                position: relative;
                padding: 148px 0 66px;
                min-height: 100svh;
                display: flex;
                align-items: center;
            }

            .hero-grid {
                display: grid;
                grid-template-columns: 1.15fr 0.85fr;
                gap: 46px;
                align-items: center;
            }

            .hero-badges {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 22px;
            }

            .badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 7px 14px;
                border-radius: 999px;
                font-size: 12.5px;
                font-weight: 700;
                border: 1px solid var(--line);
                background: var(--surface);
                color: var(--ink-2);
                box-shadow: var(--shadow-sm);
            }

            .badge-live {
                border-color: color-mix(in srgb, var(--secondary) 40%, transparent);
                background: var(--green-soft);
                color: var(--green-dark);
            }

            .dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: var(--green);
                box-shadow: 0 0 0 0 color-mix(in srgb, var(--secondary) 60%, transparent);
                animation: pulse 1.9s infinite;
            }

            @keyframes pulse {
                70% {
                    box-shadow: 0 0 0 9px transparent;
                }
                100% {
                    box-shadow: 0 0 0 0 transparent;
                }
            }

            .hero h1 {
                font-family: var(--font-ar);
                font-weight: 900;
                font-size: clamp(2.1rem, 6vw, 4rem);
                line-height: 1.08;
                letter-spacing: -0.02em;
                margin-bottom: 6px;
                text-transform: uppercase;
            }

            .hero h1 .line-1 {
                display: block;
                color: var(--navy);
            }

            .hero h1 .line-2 {
                display: block;
                background: var(--two-tone);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .hero h1 .yr {
                color: var(--green);
                -webkit-text-stroke: 0;
            }

            .glitch {
                position: relative;
                display: inline-block;
            }

            .glitch::before,
            .glitch::after {
                content: attr(data-text);
                position: absolute;
                inset: 0;
                background: var(--bg);
                overflow: hidden;
                pointer-events: none;
            }

            .glitch::before {
                color: var(--orange);
                animation: glitch-a 3.4s infinite steps(2, end);
                left: 2px;
                clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
                mix-blend-mode: multiply;
                opacity: 0.5;
            }

            .glitch::after {
                color: var(--navy);
                animation: glitch-b 2.9s infinite steps(2, end);
                right: 2px;
                clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
                mix-blend-mode: multiply;
                opacity: 0.45;
            }

            @keyframes glitch-a {
                0%,
                88%,
                100% {
                    transform: none;
                    opacity: 0;
                }
                89% {
                    transform: translate(-3px, -2px);
                    opacity: 0.5;
                }
                92% {
                    transform: translate(3px, 1px);
                }
                95% {
                    transform: translate(-2px, 2px);
                }
            }

            @keyframes glitch-b {
                0%,
                90%,
                100% {
                    transform: none;
                    opacity: 0;
                }
                91% {
                    transform: translate(3px, 2px);
                    opacity: 0.45;
                }
                94% {
                    transform: translate(-3px, -1px);
                }
                97% {
                    transform: translate(2px, -2px);
                }
            }

            .hero h2 {
                font-size: clamp(1.2rem, 3.1vw, 1.8rem);
                font-weight: 800;
                margin: 18px 0 16px;
                color: var(--navy);
            }

            .hero-desc {
                color: var(--muted);
                font-size: 1.05rem;
                max-width: 640px;
            }

            .hero-desc b {
                color: var(--ink);
                font-weight: 800;
            }

            .term-line {
                margin-top: 22px;
                font-family: var(--font-mono);
                font-size: 14px;
                color: var(--green-dark);
                min-height: 24px;
                direction: ltr;
                text-align: left;
            }

            .term-line .caret {
                display: inline-block;
                width: 9px;
                height: 17px;
                background: var(--green-dark);
                vertical-align: -3px;
                margin-left: 3px;
                animation: blink 1s steps(1) infinite;
            }

            @keyframes blink {
                50% {
                    opacity: 0;
                }
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 34px;
            }

            .hero-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 12px 22px;
                margin-top: 32px;
                padding-top: 26px;
                border-top: 1px solid var(--line);
            }

            .hero-meta div {
                display: flex;
                align-items: center;
                gap: 9px;
                font-size: 0.92rem;
                color: var(--ink-2);
                font-weight: 600;
            }

            .hero-meta svg {
                flex-shrink: 0;
                color: var(--orange);
            }

            /* ---------- العداد ---------- */
            .count-card {
                position: relative;
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 22px;
                padding: 26px 22px;
                box-shadow: 0 30px 60px -40px color-mix(in srgb, var(--base) 70%, transparent);
                overflow: hidden;
            }

            .count-card::after {
                content: '';
                position: absolute;
                top: -60%;
                right: -30%;
                width: 260px;
                height: 260px;
                background: radial-gradient(circle, color-mix(in srgb, var(--primary) 12%, transparent), transparent 68%);
                pointer-events: none;
            }

            .count-title {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 18px;
                position: relative;
            }

            .count-title b {
                font-size: 1.02rem;
                color: var(--navy);
            }

            .count-title span {
                font-family: var(--font-mono);
                font-size: 10.5px;
                letter-spacing: 0.12em;
                color: var(--orange-dark);
                border: 1px solid color-mix(in srgb, var(--primary) 35%, transparent);
                background: var(--orange-soft);
                padding: 3px 9px;
                border-radius: 999px;
                text-transform: uppercase;
            }

            .count-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
                position: relative;
            }

            .count-cell {
                background: var(--bg-soft);
                border: 1px solid var(--line-2);
                border-radius: 14px;
                padding: 14px 6px 11px;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .count-cell::before {
                content: '';
                position: absolute;
                inset: auto 0 0;
                height: 3px;
                background: linear-gradient(90deg, transparent, var(--green), transparent);
                opacity: 0.8;
            }

            .count-num {
                font-family: var(--font-mono);
                font-size: clamp(1.5rem, 4.4vw, 2.3rem);
                line-height: 1;
                color: var(--navy);
                direction: ltr;
                display: block;
            }

            .count-num.tick {
                animation: tick 0.45s cubic-bezier(0.2, 0.8, 0.2, 1);
            }

            @keyframes tick {
                0% {
                    transform: translateY(-38%) scale(1.12);
                    opacity: 0;
                }
                100% {
                    transform: none;
                    opacity: 1;
                }
            }

            .count-lbl {
                display: block;
                font-size: 11.5px;
                color: var(--muted);
                margin-top: 8px;
                font-weight: 700;
            }

            .count-foot {
                margin-top: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 9px;
                font-size: 12.5px;
                color: var(--ink-2);
                text-align: center;
                flex-wrap: wrap;
                position: relative;
            }

            .count-foot svg {
                color: var(--orange);
            }

            .count-foot b {
                color: var(--navy);
            }

            .count-closed {
                display: none;
                text-align: center;
                padding: 16px 8px;
                color: var(--orange-dark);
                font-weight: 800;
            }

            .count-card.closed .count-grid,
            .count-card.closed .count-foot {
                display: none;
            }

            .count-card.closed .count-closed {
                display: block;
            }

            /* ---------- الشريط المتحرك ---------- */
            .ticker {
                border-block: 1px solid var(--line);
                background: var(--base);
                overflow: hidden;
                padding: 13px 0;
                position: relative;
                z-index: 2;
            }

            .ticker-track {
                display: flex;
                gap: 34px;
                width: max-content;
                animation: slide 38s linear infinite;
                direction: ltr;
            }

            .ticker-track span {
                font-family: var(--font-mono);
                font-size: 13px;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.85);
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 34px;
            }

            .ticker-track span::after {
                content: '◆';
                color: var(--orange);
                font-size: 9px;
            }

            @keyframes slide {
                to {
                    transform: translateX(-50%);
                }
            }

            /* ---------- الشركاء ---------- */
            .partners {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                gap: 26px;
                align-items: center;
                padding: 34px 30px;
                border: 1px solid var(--line);
                border-radius: var(--radius);
                background: var(--surface);
                box-shadow: var(--shadow-sm);
            }

            .partner {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .partner .logo-slot {
                height: 104px;
                max-width: 320px;
            }

            .x-sign {
                font-family: var(--font-mono);
                font-size: 1.5rem;
                color: var(--orange);
            }

            .partners-note {
                grid-column: 1 / -1;
                text-align: center;
                font-size: 0.88rem;
                color: var(--muted);
                padding-top: 16px;
                border-top: 1px dashed var(--line);
                margin-top: 6px;
            }

            .partners-note b {
                color: var(--navy);
            }

            /* ---------- الشبكات ---------- */
            .grid-2 {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .grid-3 {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }

            .grid-4 {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 18px;
            }

            .icon-box {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                margin-bottom: 16px;
                background: var(--navy-soft);
                border: 1px solid var(--line);
                color: var(--navy);
            }

            .card:nth-child(even) .icon-box {
                background: var(--green-soft);
                color: var(--green-dark);
            }

            .card h3 {
                font-size: 1.12rem;
                margin-bottom: 9px;
                color: var(--navy);
            }

            .card p {
                color: var(--muted);
                font-size: 0.95rem;
            }

            .card .idx {
                position: absolute;
                top: 14px;
                left: 18px;
                font-family: var(--font-mono);
                font-size: 11px;
                color: var(--orange);
                opacity: 0.85;
            }

            /* ---------- التيرمنال (كتلة داكنة بالهوية) ---------- */
            .terminal {
                border-radius: var(--radius);
                border: 1px solid var(--navy-dark);
                background: linear-gradient(160deg, var(--base), var(--base-dark));
                overflow: hidden;
                box-shadow: 0 34px 60px -38px color-mix(in srgb, var(--base) 95%, transparent);
            }

            .terminal-bar {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 11px 14px;
                background: rgba(255, 255, 255, 0.08);
                border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            }

            .terminal-bar i {
                width: 11px;
                height: 11px;
                border-radius: 50%;
                display: block;
            }

            .terminal-bar i:nth-child(1) {
                background: var(--primary);
            }
            .terminal-bar i:nth-child(2) {
                background: #ffd166;
            }
            .terminal-bar i:nth-child(3) {
                background: var(--secondary);
            }

            .terminal-bar b {
                font-family: var(--font-mono);
                font-size: 11.5px;
                color: rgba(255, 255, 255, 0.6);
                font-weight: 400;
                margin-inline-start: 8px;
                direction: ltr;
            }

            .terminal-body {
                padding: 18px;
                font-family: var(--font-mono);
                font-size: 13.2px;
                line-height: 2.05;
                min-height: 292px;
                direction: rtl;
                text-align: right;
            }

            .terminal-body .l {
                display: block;
                opacity: 0;
                animation: fadein 0.4s forwards;
            }

            .terminal-body .l .t {
                color: rgba(255, 255, 255, 0.42);
                direction: ltr;
                display: inline-block;
            }

            .terminal-body .ok .m {
                color: #a9e06b;
            }
            .terminal-body .warn .m {
                color: #ffd166;
            }
            .terminal-body .bad .m {
                color: #ff9f8f;
            }
            .terminal-body .info .m {
                color: #c8d3f5;
            }

            @keyframes fadein {
                to {
                    opacity: 1;
                }
            }

            /* ---------- الجدول الزمني ---------- */
            .tl {
                position: relative;
                padding-inline-start: 34px;
            }

            .tl::before {
                content: '';
                position: absolute;
                inset-block: 8px;
                inset-inline-start: 9px;
                width: 2px;
                background: linear-gradient(to bottom, var(--green), var(--orange), var(--line));
            }

            .tl-item {
                position: relative;
                padding-bottom: 26px;
            }

            .tl-item:last-child {
                padding-bottom: 0;
            }

            .tl-item::before {
                content: '';
                position: absolute;
                inset-inline-start: -32px;
                top: 6px;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                border: 3px solid var(--green);
                background: var(--surface);
                box-shadow: 0 0 0 4px color-mix(in srgb, var(--secondary) 16%, transparent);
            }

            .tl-item.now::before {
                border-color: var(--orange);
                box-shadow: 0 0 0 5px color-mix(in srgb, var(--primary) 18%, transparent);
                animation: pulse 1.9s infinite;
            }

            .tl-date {
                font-family: var(--font-mono);
                font-size: 12.5px;
                color: var(--orange-dark);
                font-weight: 700;
            }

            .tl-item h4 {
                font-size: 1.06rem;
                margin: 5px 0;
                color: var(--navy);
            }

            .tl-item p {
                color: var(--muted);
                font-size: 0.93rem;
            }

            .tl-tag {
                display: inline-block;
                font-size: 11px;
                font-weight: 800;
                padding: 2px 10px;
                border-radius: 999px;
                margin-inline-start: 8px;
                vertical-align: 3px;
            }

            .tl-tag.now {
                background: var(--orange-soft);
                color: var(--orange-dark);
                border: 1px solid color-mix(in srgb, var(--primary) 35%, transparent);
            }

            /* ---------- الجوائز ---------- */
            .prize {
                text-align: center;
                padding: 34px 22px;
            }

            .prize .rank {
                font-family: var(--font-ar);
                font-weight: 900;
                font-size: 3rem;
                line-height: 1;
                margin-bottom: 6px;
            }

            .prize.p1 {
                border-color: color-mix(in srgb, var(--primary) 45%, transparent);
                box-shadow: 0 26px 55px -34px color-mix(in srgb, var(--primary) 90%, transparent);
            }

            .prize.p1 .rank {
                color: var(--orange);
            }

            .prize.p2 .rank {
                color: var(--navy);
            }
            .prize.p3 .rank {
                color: var(--green-dark);
            }

            .prize .amount {
                font-family: var(--font-mono);
                font-size: 1.32rem;
                color: var(--green-dark);
                direction: ltr;
                margin-bottom: 12px;
                font-weight: 700;
            }

            .prize-use {
                font-size: 0.9rem;
                color: var(--muted);
            }

            .chips {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 22px;
            }

            .chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border-radius: 12px;
                border: 1px solid var(--line);
                background: var(--surface);
                font-size: 0.9rem;
                font-weight: 700;
                color: var(--ink-2);
                box-shadow: var(--shadow-sm);
            }

            .ul-check {
                list-style: none;
                margin: 0;
                padding: 0;
                display: grid;
                gap: 13px;
            }

            .ul-check li {
                display: flex;
                gap: 12px;
                align-items: flex-start;
                color: var(--ink-2);
                font-size: 0.96rem;
            }

            .ul-check svg {
                flex-shrink: 0;
                margin-top: 5px;
                color: var(--green);
            }

            /* صندوق ملاحظة */
            .note-box {
                display: flex;
                gap: 12px;
                align-items: flex-start;
                padding: 16px 18px;
                border-radius: var(--radius-sm);
                background: var(--navy-soft);
                border: 1px solid var(--line);
                font-size: 0.92rem;
                color: var(--ink-2);
            }

            .note-box svg {
                flex-shrink: 0;
                margin-top: 4px;
                color: var(--navy);
            }

            .note-box b {
                color: var(--navy);
            }

            /* ---------- FAQ ---------- */
            .faq {
                display: grid;
                gap: 12px;
                max-width: 880px;
            }

            details.qa {
                border: 1px solid var(--line);
                border-radius: var(--radius-sm);
                background: var(--surface);
                overflow: hidden;
                box-shadow: var(--shadow-sm);
                transition:
                    border-color 0.3s,
                    box-shadow 0.3s;
            }

            details.qa[open] {
                border-color: color-mix(in srgb, var(--base) 25%, transparent);
                box-shadow: 0 18px 40px -30px color-mix(in srgb, var(--base) 60%, transparent);
            }

            details.qa summary {
                cursor: pointer;
                padding: 17px 20px;
                font-weight: 700;
                font-size: 1rem;
                color: var(--navy);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                list-style: none;
            }

            details.qa summary::-webkit-details-marker {
                display: none;
            }

            details.qa summary::after {
                content: '+';
                font-family: var(--font-mono);
                font-size: 1.3rem;
                color: var(--orange);
                transition: transform 0.3s;
                line-height: 1;
            }

            details.qa[open] summary::after {
                content: '−';
                transform: rotate(180deg);
            }

            details.qa .ans {
                padding: 0 20px 18px;
                color: var(--muted);
                font-size: 0.95rem;
            }

            /* ---------- الفورم ---------- */
            .reg-shell {
                display: grid;
                grid-template-columns: 0.78fr 1.22fr;
                gap: 26px;
                align-items: start;
            }

            .reg-aside {
                position: sticky;
                top: 100px;
                display: grid;
                gap: 14px;
            }

            .aside-box {
                border: 1px solid var(--line);
                border-radius: var(--radius-sm);
                padding: 18px;
                background: var(--surface);
                box-shadow: var(--shadow-sm);
            }

            .aside-box h4 {
                font-size: 0.98rem;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--navy);
            }

            .aside-box h4 svg {
                color: var(--orange);
                flex-shrink: 0;
            }

            .aside-box p,
            .aside-box li {
                color: var(--muted);
                font-size: 0.89rem;
            }

            .aside-box ul {
                margin: 0;
                padding-inline-start: 18px;
                display: grid;
                gap: 6px;
            }

            .form-card {
                border: 1px solid var(--line);
                border-radius: var(--radius);
                background: var(--surface);
                padding: 30px;
                box-shadow: 0 28px 60px -45px color-mix(in srgb, var(--base) 75%, transparent);
            }

            .mode-switch {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                padding: 6px;
                border-radius: 999px;
                background: var(--bg-soft);
                border: 1px solid var(--line);
                margin-bottom: 26px;
            }

            .mode-switch button {
                border: 0;
                background: transparent;
                padding: 13px 10px;
                border-radius: 999px;
                cursor: pointer;
                font-weight: 800;
                font-size: 0.96rem;
                color: var(--muted);
                transition:
                    color 0.25s,
                    background 0.35s,
                    box-shadow 0.35s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 9px;
            }

            .mode-switch button.active {
                color: #fff;
                background: var(--base);
                box-shadow: 0 10px 24px -14px color-mix(in srgb, var(--base) 95%, transparent);
            }

            fieldset {
                border: 0;
                margin: 0 0 24px;
                padding: 0;
                min-width: 0;
            }

            .fs-title {
                display: flex;
                align-items: center;
                gap: 11px;
                font-family: var(--font-mono);
                font-size: 12.5px;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--navy);
                margin-bottom: 16px;
            }

            .fs-title::after {
                content: '';
                flex: 1;
                height: 1px;
                background: linear-gradient(90deg, var(--line), transparent);
            }

            .form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 7px;
                min-width: 0;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            .field label {
                font-size: 0.89rem;
                font-weight: 700;
                color: var(--ink-2);
            }

            .field label .req {
                color: var(--orange);
            }

            .field input,
            .field select,
            .field textarea {
                width: 100%;
                padding: 13px 15px;
                border-radius: var(--radius-sm);
                border: 1px solid var(--line);
                background: var(--bg-soft);
                color: var(--ink);
                font-family: inherit;
                font-size: 0.95rem;
                transition:
                    border-color 0.25s,
                    box-shadow 0.25s,
                    background 0.25s;
                appearance: none;
            }

            .field textarea {
                min-height: 104px;
                resize: vertical;
                line-height: 1.7;
            }

            .field select {
                background-image: linear-gradient(45deg, transparent 50%, var(--navy) 50%),
                    linear-gradient(135deg, var(--navy) 50%, transparent 50%);
                background-position:
                    calc(18px) calc(50% - 2px),
                    calc(23px) calc(50% - 2px);
                background-size:
                    5px 5px,
                    5px 5px;
                background-repeat: no-repeat;
                padding-inline-start: 42px;
            }

            .field input::placeholder,
            .field textarea::placeholder {
                color: #9aa3bd;
            }

            .field input:focus,
            .field select:focus,
            .field textarea:focus {
                outline: none;
                border-color: var(--navy);
                background: var(--surface);
                box-shadow: 0 0 0 4px color-mix(in srgb, var(--base) 10%, transparent);
            }

            .field.bad input,
            .field.bad select,
            .field.bad textarea {
                border-color: var(--danger);
                background: var(--danger-soft);
                box-shadow: 0 0 0 4px color-mix(in srgb, var(--danger) 10%, transparent);
            }

            .err {
                font-size: 0.79rem;
                color: var(--danger-ink);
                display: none;
            }

            .field.bad .err {
                display: block;
            }

            .err.shown {
                display: block;
            }

            .hint {
                font-size: 0.78rem;
                color: #8b93ab;
            }

            .member {
                border: 1px solid var(--line);
                border-radius: var(--radius-sm);
                padding: 18px;
                background: var(--bg-soft);
                margin-bottom: 12px;
                animation: slide-in 0.35s ease;
            }

            @keyframes slide-in {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }
            }

            .member-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 14px;
            }

            .member-head b {
                font-size: 0.92rem;
                color: var(--navy);
                font-family: var(--font-mono);
            }

            .rm {
                border: 1px solid color-mix(in srgb, var(--danger) 30%, transparent);
                background: var(--danger-soft);
                color: var(--danger-ink);
                border-radius: 9px;
                padding: 6px 12px;
                cursor: pointer;
                font-size: 0.8rem;
                font-weight: 700;
                transition: background 0.25s;
            }

            .rm:hover {
                background: color-mix(in srgb, var(--danger) 18%, var(--surface));
            }

            .add-member {
                width: 100%;
                border: 1.5px dashed color-mix(in srgb, var(--base) 30%, transparent);
                background: var(--navy-soft);
                color: var(--navy);
                border-radius: var(--radius-sm);
                padding: 14px;
                cursor: pointer;
                font-weight: 800;
                font-size: 0.92rem;
                transition:
                    background 0.25s,
                    border-color 0.25s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 9px;
            }

            .add-member:hover {
                background: color-mix(in srgb, var(--base) 12%, var(--surface));
                border-color: var(--navy);
            }

            .add-member[disabled] {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .agree {
                display: flex;
                gap: 12px;
                align-items: flex-start;
                padding: 16px;
                border: 1px solid var(--line);
                border-radius: var(--radius-sm);
                background: var(--bg-soft);
                font-size: 0.9rem;
                color: var(--ink-2);
            }

            .agree input {
                width: 20px;
                height: 20px;
                accent-color: var(--green);
                margin-top: 3px;
                flex-shrink: 0;
                cursor: pointer;
            }

            .agree.bad {
                border-color: var(--danger);
                background: var(--danger-soft);
            }

            /* ---------- التوست والمودال ---------- */
            .toast {
                position: fixed;
                z-index: 200;
                inset-inline: 0;
                bottom: 26px;
                margin-inline: auto;
                width: fit-content;
                max-width: calc(100% - 40px);
                padding: 13px 22px;
                border-radius: 999px;
                background: var(--base);
                border: 1px solid var(--base-dark);
                color: #fff;
                font-weight: 700;
                font-size: 0.9rem;
                box-shadow: 0 24px 50px -24px color-mix(in srgb, var(--base) 90%, transparent);
                transform: translateY(140%);
                transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
                display: flex;
                align-items: center;
                gap: 10px;
                text-align: center;
            }

            .toast.show {
                transform: none;
            }

            .toast.bad {
                background: #b3261e;
                border-color: #8f1d17;
            }

            .modal {
                position: fixed;
                inset: 0;
                z-index: 300;
                display: none;
                align-items: center;
                justify-content: center;
                padding: 22px;
                background: rgba(27, 34, 68, 0.55);
                backdrop-filter: blur(6px);
            }

            .modal.open {
                display: flex;
            }

            .modal-box {
                width: 100%;
                max-width: 560px;
                max-height: 88vh;
                overflow: auto;
                border-radius: 22px;
                border: 1px solid var(--line);
                background: var(--surface);
                padding: 34px 30px;
                text-align: center;
                box-shadow: 0 40px 90px -50px rgba(27, 34, 68, 0.9);
                animation: pop 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            }

            @keyframes pop {
                from {
                    opacity: 0;
                    transform: scale(0.94) translateY(14px);
                }
            }

            .modal-box .ok-ring {
                width: 76px;
                height: 76px;
                margin: 0 auto 18px;
                border-radius: 50%;
                display: grid;
                place-items: center;
                background: var(--green-soft);
                border: 1px solid color-mix(in srgb, var(--secondary) 40%, transparent);
                color: var(--green-dark);
            }

            .modal-box h3 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: var(--navy);
            }

            .modal-box p {
                color: var(--muted);
                font-size: 0.95rem;
            }

            .ref {
                margin: 20px auto;
                padding: 14px;
                border-radius: var(--radius-sm);
                border: 1px dashed color-mix(in srgb, var(--secondary) 50%, transparent);
                background: var(--green-soft);
            }

            .ref span {
                display: block;
                font-family: var(--font-mono);
                font-size: 10.5px;
                letter-spacing: 0.14em;
                color: var(--muted);
                text-transform: uppercase;
                margin-bottom: 5px;
            }

            .ref b {
                font-family: var(--font-mono);
                font-size: 1.28rem;
                color: var(--green-dark);
                direction: ltr;
                display: block;
            }

            .modal-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
                margin-top: 22px;
            }

            /* ---------- الفوتر ---------- */
            footer {
                background: linear-gradient(170deg, var(--base), var(--base-dark));
                color: #fff;
                padding: 56px 0 26px;
                position: relative;
                z-index: 2;
            }

            .foot-grid {
                display: grid;
                grid-template-columns: 1.4fr 1fr 1fr;
                gap: 34px;
                margin-bottom: 30px;
            }

            footer h4 {
                font-size: 0.98rem;
                margin-bottom: 14px;
                color: #fff;
            }

            footer p,
            footer a,
            footer li {
                color: rgba(255, 255, 255, 0.72);
                font-size: 0.91rem;
            }

            footer ul {
                list-style: none;
                margin: 0;
                padding: 0;
                display: grid;
                gap: 9px;
            }

            footer a:hover {
                color: #fff;
            }

            footer .brand-card {
                border-color: rgba(255, 255, 255, 0.25);
                box-shadow: none;
            }

            .socials {
                display: flex;
                gap: 10px;
                margin-top: 16px;
            }

            .socials a {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: grid;
                place-items: center;
                border: 1px solid rgba(255, 255, 255, 0.22);
                background: rgba(255, 255, 255, 0.08);
                transition:
                    border-color 0.25s,
                    transform 0.25s,
                    background 0.25s;
            }

            .socials a:hover {
                border-color: var(--orange);
                background: color-mix(in srgb, var(--primary) 18%, transparent);
                transform: translateY(-3px);
            }

            .foot-orgs {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 190px));
                gap: 18px;
                align-items: center;
                padding: 22px 0;
                border-top: 1px dashed rgba(255, 255, 255, 0.2);
                border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
                margin-bottom: 24px;
            }

            .foot-orgs .logo-slot {
                height: 74px;
            }

            .foot-bottom {
                padding-top: 6px;
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                justify-content: space-between;
                align-items: center;
                font-size: 0.84rem;
                color: rgba(255, 255, 255, 0.6);
            }

            .to-top {
                position: fixed;
                inset-inline-start: 22px;
                bottom: 22px;
                width: 46px;
                height: 46px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: var(--surface);
                border: 1px solid var(--line);
                color: var(--navy);
                cursor: pointer;
                z-index: 70;
                opacity: 0;
                pointer-events: none;
                transition:
                    opacity 0.3s,
                    transform 0.3s;
                box-shadow: var(--shadow-sm);
            }

            .to-top.on {
                opacity: 1;
                pointer-events: auto;
            }

            .to-top:hover {
                transform: translateY(-3px);
            }

            /* ---------- الجوال ---------- */
            @media (max-width: 1024px) {
                .hero-grid,
                .reg-shell {
                    grid-template-columns: 1fr;
                }

                .reg-aside {
                    position: static;
                }

                .grid-4 {
                    grid-template-columns: repeat(2, 1fr);
                }

                .nav-links {
                    display: none;
                }

                .burger {
                    display: flex;
                }

                .foot-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 720px) {
                .sec {
                    padding: 68px 0;
                }

                .hero {
                    padding-top: 118px;
                    min-height: auto;
                }

                .hero-grid {
                    gap: 32px;
                }

                .grid-2,
                .grid-3,
                .grid-4,
                .form-grid,
                .foot-grid {
                    grid-template-columns: 1fr;
                }

                .partners {
                    grid-template-columns: 1fr;
                    padding: 24px 18px;
                }

                .x-sign {
                    transform: rotate(90deg);
                }

                .count-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .form-card {
                    padding: 20px;
                }

                .brand-txt {
                    display: none;
                }

                .foot-orgs {
                    grid-template-columns: 1fr 1fr;
                }

                .partner .logo-slot {
                    height: 88px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                html {
                    scroll-behavior: auto;
                }

                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }

                .js [data-reveal] {
                    opacity: 1;
                    transform: none;
                }

                #matrix,
                #cursorGlow {
                    display: none !important;
                }
            }

            @media print {
                #matrix,
                .fx,
                header,
                .to-top,
                #progress {
                    display: none !important;
                }

                body {
                    background: var(--surface);
                    color: #000;
                }
            }
        </style>
    </head>

    <body>
        {{-- ================= الخلفيات المتحركة ================= --}}
        <canvas id="matrix" aria-hidden="true"></canvas>
        <div class="fx" aria-hidden="true">
            <div class="fx-vignette"></div>
            <div class="fx-grid"></div>
            <div class="fx-scan"></div>
            <div class="fx-noise"></div>
        </div>
        <div id="cursorGlow" aria-hidden="true"></div>
        <div id="progress" aria-hidden="true"></div>

        {{-- ================= الهيدر ================= --}}
        <header id="hdr">
            <div class="wrap">
                <nav class="nav" aria-label="{{ $identity['accessibility']['main_nav'] }}">
                    <a href="#top" class="brand" aria-label="{{ $identity['accessibility']['home'] }}">
                        <span class="brand-card">
                            <img
                                src="{{ $logoSrc }}"
                                alt="{{ $identity['logo_alt'] }}"
                                onerror="this.remove()"
                            />
                            <span class="slot-hint">{{ $identity['logo_placeholder'] }}<small>LOGO</small></span>
                        </span>
                        <span class="brand-txt">
                            <b>{{ $identity['brand_ar'] }}</b>
                            <span>{{ $identity['brand_en'] }}</span>
                        </span>
                    </a>

                    <div class="nav-links">
                        <a href="#about">{{ $identity['nav']['about'] }}</a>
                        <a href="#tracks">{{ $identity['nav']['tracks'] }}</a>
                        <a href="#timeline">{{ $identity['nav']['timeline'] }}</a>
                        <a href="#prizes">{{ $identity['nav']['prizes'] }}</a>
                        <a href="#faq">{{ $identity['nav']['faq'] }}</a>
                        <a href="#register" class="btn btn-primary nav-cta">{{ $identity['nav']['register'] }}</a>
                    </div>

                    <button
                        class="burger"
                        id="burger"
                        aria-label="{{ $identity['accessibility']['open_menu'] }}"
                        aria-expanded="false"
                        aria-controls="drawer"
                    >
                        <span></span>
                    </button>
                </nav>
            </div>
            <div class="drawer" id="drawer">
                <a href="#about">{{ $identity['nav']['about'] }}</a>
                <a href="#tracks">{{ $identity['nav']['tracks'] }}</a>
                <a href="#timeline">{{ $identity['nav']['timeline'] }}</a>
                <a href="#prizes">{{ $identity['nav']['prizes'] }}</a>
                <a href="#rules">{{ $identity['nav']['rules'] }}</a>
                <a href="#faq">{{ $identity['nav']['faq'] }}</a>
                <a href="#register" style="color: var(--orange)">← {{ $identity['nav']['register'] }}</a>
            </div>
        </header>

        <main id="top">
            {{-- ================= الهيرو ================= --}}
            <section class="hero">
                <div class="wrap">
                    <div class="hero-grid">
                        <div>
                            <div class="hero-badges" data-reveal>
                                <span class="badge badge-live">
                                    <i class="dot"></i> {{ $hero['registration_open'] ? $hero['status_open'] : $hero['status_closed'] }}
                                </span>
                                <span class="badge">{{ $hero['partner_badge'] }}</span>
                                <span class="badge">{{ $identity['location'] }}</span>
                            </div>

                            <h1 data-reveal>
                                <span class="line-1">{{ $hero['title_top'] }}</span>
                                <span class="line-2 glitch" data-text="{{ $hero['title_main'] }}">{{ $hero['title_main'] }}</span>
                                <span class="line-1 yr">{{ $hero['title_year'] }}</span>
                            </h1>

                            <h2 data-reveal>
                                <span class="grad">{{ $hero['subtitle'] }}</span>
                            </h2>

                            <p class="hero-desc" data-reveal>
                                {{ $hero['description'] }}
                            </p>

                            <div class="term-line" id="termLine">
                                <span class="caret"></span>
                            </div>

                            <div class="hero-actions" data-reveal>
                                <a href="#register" class="btn btn-primary">
                                    {{ $hero['primary_button'] }}
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7" /></svg>
                                </a>
                                <a href="#about" class="btn btn-ghost">{{ $hero['secondary_button'] }}</a>
                            </div>

                            <div class="hero-meta" data-reveal>
                                <div>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" /></svg>
                                    <span id="metaDates">{{ $hero['event_dates'] }}</span>
                                </div>
                                <div>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                                    {{ $identity['location'] }}
                                </div>
                                <div>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" /></svg>
                                    {{ $hero['duration'] }}
                                </div>
                                <div>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /></svg>
                                    {{ $hero['team_format'] }}
                                </div>
                            </div>
                        </div>

                        {{-- العداد التنازلي --}}
                        <div data-reveal>
                            <div class="count-card" id="countCard">
                                <div class="count-title">
                                    <b>{{ $hero['countdown_title'] }}</b>
                                    <span>Deadline</span>
                                </div>

                                <div class="count-grid" role="timer" aria-live="polite">
                                    <div class="count-cell">
                                        <b class="count-num" id="cd-d">--</b>
                                        <span class="count-lbl">{{ $hero['countdown_units']['days'] }}</span>
                                    </div>
                                    <div class="count-cell">
                                        <b class="count-num" id="cd-h">--</b>
                                        <span class="count-lbl">{{ $hero['countdown_units']['hours'] }}</span>
                                    </div>
                                    <div class="count-cell">
                                        <b class="count-num" id="cd-m">--</b>
                                        <span class="count-lbl">{{ $hero['countdown_units']['minutes'] }}</span>
                                    </div>
                                    <div class="count-cell">
                                        <b class="count-num" id="cd-s">--</b>
                                        <span class="count-lbl">{{ $hero['countdown_units']['seconds'] }}</span>
                                    </div>
                                </div>

                                <div class="count-foot">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" /></svg>
                                    {{ $hero['deadline_label'] }} <b id="deadlineTxt">—</b>
                                </div>

                                <div class="count-closed">
                                    {{ $hero['closed_message'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= الشريط المتحرك ================= --}}
            <div class="ticker" aria-hidden="true">
                <div class="ticker-track">
                    @foreach(array_merge($hero['ticker'], $hero['ticker']) as $ticker)<span>{{ $ticker }}</span>@endforeach
                </div>
            </div>

            {{-- ================= الشركاء ================= --}}
            <section class="sec" id="partners" style="padding-bottom: 0">
                <div class="wrap">
                    <div class="partners" data-reveal>
                        <div class="partner">
                            {{--
                                ▓▓▓ مكان شعار النادي الهندسي ▓▓▓
                                لتبديله: حطّ الصورة في  public/images/eng-club.png
                                أو غيّر المسار بالوسم <img> بالأسفل.
                            --}}
                            <div class="logo-slot slot-light">
                                <img
                                    src="{{ $clubLogoSrc }}"
                                    alt="{{ $identity['engineering_logo_alt'] }}"
                                    onerror="this.remove()"
                                />
                                <span class="slot-hint">
                                    {{ $identity['engineering_logo_placeholder'] }}
                                    <small>ENGINEERING CLUB</small>
                                </span>
                            </div>
                        </div>

                        <div class="x-sign" aria-hidden="true">×</div>

                        <div class="partner">
                            {{--
                                ▓▓▓ مكان شعار حاضنة يوكاس التكنولوجية ▓▓▓
                                لتبديله: حطّ الصورة في  public/images/ucas.png
                            --}}
                            <div class="logo-slot slot-light">
                                <img
                                    src="{{ $incubatorLogoSrc }}"
                                    alt="{{ $identity['incubator_logo_alt'] }}"
                                    onerror="this.remove()"
                                />
                                <span class="slot-hint">
                                    {{ $identity['incubator_logo_placeholder'] }}
                                    <small>UCAS TECH INCUBATOR</small>
                                </span>
                            </div>
                        </div>

                        <p class="partners-note">
                            {{ $about['partners_note'] }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- ================= عن الهاكاثون ================= --}}
            <section class="sec" id="about">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $about['eyebrow'] }}</span>
                        <h2>{{ $about['title'] }}</h2>
                        <p>{{ $about['description'] }}</p>
                    </div>

                    <div class="grid-2" style="align-items: start; gap: 26px">
                        <div style="display: grid; gap: 20px">
                            @foreach($about['cards'] as $card)
                            <div class="card" data-reveal>
                                <span class="idx">[ {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} ]</span>
                                <div class="icon-box">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
                                </div>
                                <h3>{{ $card['title'] }}</h3>
                                <p>{{ $card['description'] }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div data-reveal>
                            <div class="terminal">
                                <div class="terminal-bar">
                                    <i></i><i></i><i></i>
                                    <b>hackathon@eng-club:~/mission</b>
                                </div>
                                <div class="terminal-body" id="termBody">
                                    @foreach($about['schedule'] as $item)
                                    <span class="l {{ ['ok', 'info', 'warn', 'bad'][$loop->index % 4] }}"><span class="t">[{{ $item['time'] }}]</span> <span class="m">{{ $item['text'] }}</span></span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= المسارات ================= --}}
            <section class="sec" id="tracks">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $tracks['eyebrow'] }}</span>
                        <h2>{{ $tracks['title'] }}</h2>
                        <p>{{ $tracks['description'] }}</p>
                    </div>

                    <div class="grid-4">
                        @foreach($tracks['items'] as $track)
                        <div class="card" data-reveal>
                            <span class="idx">[ T{{ $loop->iteration }} ]</span>
                            <div class="icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 6v6c0 5 3.4 9.4 8 10 4.6-.6 8-5 8-10V6l-8-4Z" /><path d="m9 12 2 2 4-4" /></svg>
                            </div>
                            <h3>{{ $track['title'] }}</h3>
                            <p>{{ $track['description'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="chips" data-reveal>
                        @foreach($tracks['chips'] as $chip)<span class="chip">{{ $chip }}</span>@endforeach
                    </div>
                </div>
            </section>

            {{-- ================= الجدول الزمني ================= --}}
            <section class="sec" id="timeline">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $timeline['eyebrow'] }}</span>
                        <h2>{{ $timeline['title'] }}</h2>
                        <p>{{ $timeline['description'] }}</p>
                    </div>

                    <div class="grid-2" style="gap: 40px">
                        <div class="tl" data-reveal>
                            @foreach($timeline['items'] as $item)
                            <div class="tl-item {{ $loop->first ? 'now' : '' }}" @if($loop->first) id="tl-open" @elseif($loop->iteration === 2) id="tl-deadline" @endif>
                                <span class="tl-date" id="tl{{ $loop->iteration }}">{{ $item['date'] }}</span>
                                @if($loop->first)<span class="tl-tag now">{{ $hero['registration_open'] ? $hero['status_open'] : $hero['status_closed'] }}</span>@endif
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['description'] }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div style="display: grid; gap: 18px; align-content: start">
                            @foreach($timeline['notes'] as $note)
                            <div class="card" data-reveal>
                                <div class="icon-box">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 6 9 17l-5-5" /></svg>
                                </div>
                                <h3>{{ $note['title'] }}</h3>
                                <p>{{ $note['description'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= الجوائز ================= --}}
            <section class="sec" id="prizes">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $prizesRules['prizes_eyebrow'] }}</span>
                        <h2>{{ $prizesRules['prizes_title'] }}</h2>
                        <p>{{ $prizesRules['prizes_description'] }}</p>
                    </div>

                    <div class="grid-3">
                        @foreach($prizesRules['prizes'] as $prize)
                        <div class="card prize p{{ $prize['rank'] }}" data-reveal>
                            <div class="rank">{{ $prize['rank'] }}</div>
                            <div class="amount">{{ $prize['amount'] }}</div>
                            <h3>{{ $prize['title'] }}</h3>
                            <p class="prize-use">{{ $prize['description'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="chips" data-reveal>
                        @foreach($prizesRules['extra_prizes'] as $prize)<span class="chip">{{ $prize }}</span>@endforeach
                    </div>
                </div>
            </section>

            {{-- ================= الشروط ================= --}}
            <section class="sec" id="rules">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $prizesRules['rules_eyebrow'] }}</span>
                        <h2>{{ $prizesRules['rules_title'] }}</h2>
                        <p>{{ $prizesRules['rules_description'] }}</p>
                    </div>

                    <div class="grid-2">
                        <div class="card" data-reveal>
                            <h3 style="margin-bottom: 16px">{{ $prizesRules['eligibility_title'] }}</h3>
                            <ul class="ul-check">
                                @foreach($prizesRules['eligibility'] as $rule)
                                <li>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 6 9 17l-5-5" /></svg>
                                    {{ $rule }}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card" data-reveal>
                            <h3 style="margin-bottom: 16px">{{ $prizesRules['event_rules_title'] }}</h3>
                            <ul class="ul-check">
                                @foreach($prizesRules['event_rules'] as $rule)
                                <li>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 6 9 17l-5-5" /></svg>
                                    {{ $rule }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= الأسئلة الشائعة ================= --}}
            <section class="sec" id="faq">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $faq['eyebrow'] }}</span>
                        <h2>{{ $faq['title'] }}</h2>
                        <p>{{ $faq['description'] }}</p>
                    </div>

                    <div class="faq" data-reveal>
                        @foreach($faq['items'] as $item)
                        <details class="qa" @if($loop->first) open @endif>
                            <summary>{{ $item['question'] }}</summary>
                            <div class="ans">{{ $item['answer'] }}</div>
                        </details>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ================= التسجيل ================= --}}
            <section class="sec" id="register">
                <div class="wrap">
                    <div class="sec-head" data-reveal>
                        <span class="eyebrow">{{ $registration['eyebrow'] }}</span>
                        <h2>{{ $registration['title'] }}</h2>
                        <p>{{ $registration['description'] }}</p>
                    </div>

                    <div class="reg-shell">
                        {{-- العمود الجانبي --}}
                        <aside class="reg-aside" data-reveal>
                            <div class="aside-box">
                                <h4>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" /></svg>
                                    {{ $registration['deadline_card_title'] }}
                                </h4>
                                <p id="asideDeadline">—</p>
                                <p style="margin-top: 8px; color: var(--orange); font-weight: 700" id="asideLeft">—</p>
                            </div>

                            <div class="aside-box">
                                <h4>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4" /><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" /></svg>
                                    {{ $registration['preparation_title'] }}
                                </h4>
                                <ul>
                                    @foreach($registration['preparation_items'] as $item)<li>{{ $item }}</li>@endforeach
                                </ul>
                            </div>

                            <div class="aside-box">
                                <h4>
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4h16v12H5.2L4 17.5V4Z" /></svg>
                                    {{ $registration['contact_card_title'] }}
                                </h4>
                                <p>
                                    <a href="mailto:{{ $identity['email'] }}" style="color: var(--green-dark)" id="asideMail">{{ $identity['email'] }}</a>
                                </p>
                            </div>
                        </aside>

                        {{-- النموذج --}}
                        <div class="form-card" data-reveal>
                            <div class="mode-switch" role="tablist" aria-label="{{ $identity['accessibility']['participation_type'] }}">
                                <button type="button" id="modeIndividual" class="active" role="tab" aria-selected="true" aria-controls="paneIndividual">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="8" r="4" /><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6" /></svg>
                                    {{ $registration['individual_tab'] }}
                                </button>
                                <button type="button" id="modeTeam" role="tab" aria-selected="false" aria-controls="paneTeam">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="9" cy="8" r="3.4" /><path d="M2.5 20c0-3.4 3-5.2 6.5-5.2s6.5 1.8 6.5 5.2" /><path d="M17 8.2a3 3 0 1 1 0 6M18 20c0-2.2-.6-3.6-1.6-4.6" /></svg>
                                    {{ $registration['team_tab'] }}
                                </button>
                            </div>

                            <form id="regForm" novalidate>
                                <fieldset>
                                    <div class="fs-title"><span id="leadTitle">{{ $registration['participant_title'] }}</span></div>

                                    <div class="form-grid">
                                        <div class="field">
                                            <label for="fullName">{{ $registration['fields']['full_name'] }} <span class="req">*</span></label>
                                            <input id="fullName" name="fullName" type="text" autocomplete="name" placeholder="{{ $registration['placeholders']['full_name'] }}" required />
                                            <span class="err" data-err-for="fullName"></span>
                                        </div>

                                        <div class="field">
                                            <label for="email">{{ $registration['fields']['email'] }} <span class="req">*</span></label>
                                            <input id="email" name="email" type="email" autocomplete="email" placeholder="name@example.com" dir="ltr" required />
                                            <span class="err" data-err-for="email"></span>
                                        </div>

                                        <div class="field">
                                            <label for="phone">{{ $registration['fields']['phone'] }} <span class="req">*</span></label>
                                            <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="05xxxxxxxx" dir="ltr" required />
                                            <span class="err" data-err-for="phone"></span>
                                        </div>

                                        <div class="field">
                                            <label for="university">{{ $registration['fields']['university'] }} <span class="req">*</span></label>
                                            <input id="university" name="university" type="text" placeholder="{{ $registration['placeholders']['university'] }}" required />
                                            <span class="err" data-err-for="university"></span>
                                        </div>

                                        <div class="field">
                                            <label for="major">{{ $registration['fields']['major'] }} <span class="req">*</span></label>
                                            <input id="major" name="major" type="text" placeholder="{{ $registration['placeholders']['major'] }}" required />
                                            <span class="err" data-err-for="major"></span>
                                        </div>

                                        <div class="field">
                                            <label for="year">{{ $registration['fields']['year'] }}</label>
                                            <select id="year" name="year">
                                                <option value="">{{ $registration['select_placeholder'] }}</option>
                                                @foreach($registration['year_options'] as $option)<option>{{ $option }}</option>@endforeach
                                            </select>
                                            <span class="err" data-err-for="year"></span>
                                        </div>

                                        <div class="field full">
                                            <label for="skills">{{ $registration['fields']['skills'] }} <span class="req">*</span></label>
                                            <input id="skills" name="skills" type="text" placeholder="{{ $registration['placeholders']['skills'] }}" required />
                                            <span class="err" data-err-for="skills"></span>
                                        </div>

                                        <div class="field">
                                            <label for="track">{{ $registration['fields']['track'] }} <span class="req">*</span></label>
                                            <select id="track" name="track" required>
                                                <option value="">{{ $registration['track_placeholder'] }}</option>
                                                @foreach($tracks['items'] as $track)<option>{{ $track['title'] }}</option>@endforeach
                                                <option>{{ $registration['track_unsure'] }}</option>
                                            </select>
                                            <span class="err" data-err-for="track"></span>
                                        </div>

                                        <div class="field">
                                            <label for="experience">{{ $registration['fields']['experience'] }}</label>
                                            <select id="experience" name="experience">
                                                <option value="">{{ $registration['select_placeholder'] }}</option>
                                                @foreach($registration['experience_options'] as $option)<option>{{ $option }}</option>@endforeach
                                            </select>
                                            <span class="err" data-err-for="experience"></span>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="teamBlock" hidden>
                                    <div class="fs-title"><span>{{ $registration['fields']['team_data'] }}</span></div>

                                    <div class="note-box" style="margin-bottom: 18px">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9" /><path d="M12 16v-5M12 8h.01" /></svg>
                                        <span>
                                            {{ $registration['team_note'] }}
                                        </span>
                                    </div>

                                    <div class="form-grid">
                                        <div class="field">
                                            <label for="teamName">{{ $registration['fields']['team_name'] }} <span class="req">*</span></label>
                                            <input id="teamName" name="teamName" type="text" placeholder="{{ $registration['placeholders']['team_name'] }}" />
                                            <span class="err" data-err-for="teamName"></span>
                                        </div>

                                        <div class="field">
                                            <label for="teamSize">{{ $registration['fields']['team_size'] }} <span class="req">*</span></label>
                                            <select id="teamSize" name="teamSize">
                                                <option value="">{{ $registration['select_placeholder'] }}</option>
                                                @foreach($registration['team_sizes'] as $option)<option value="{{ (int) $option }}">{{ $option }}</option>@endforeach
                                            </select>
                                            <span class="err" data-err-for="teamSize"></span>
                                        </div>
                                    </div>

                                    <div style="margin-top: 20px">
                                        <div class="fs-title" style="margin-bottom: 12px">
                                            <span>
                                                {{ $registration['fields']['members'] }}
                                                <small class="hint" style="text-transform: none; letter-spacing: 0">— {{ $registration['members_hint'] }}</small>
                                            </span>
                                        </div>

                                        <div id="members"></div>

                                        <button type="button" class="add-member" id="addMember">
                                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="M12 5v14M5 12h14" /></svg>
                                            {{ $registration['fields']['add_member'] }}
                                        </button>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="fs-title"><span>{{ $registration['fields']['project'] }}</span></div>

                                    <div class="form-grid">
                                        <div class="field full">
                                            <label for="idea">{{ $registration['fields']['idea'] }}</label>
                                            <textarea id="idea" name="idea" placeholder="{{ $registration['placeholders']['idea'] }}"></textarea>
                                            <span class="hint">{{ $registration['idea_hint'] }}</span>
                                        </div>

                                        <div class="field">
                                            <label for="links">{{ $registration['fields']['links'] }}</label>
                                            <input id="links" name="links" type="text" dir="ltr" placeholder="https://github.com/username" />
                                        </div>

                                        <div class="field">
                                            <label for="source">{{ $registration['fields']['source'] }}</label>
                                            <select id="source" name="source">
                                                <option value="">{{ $registration['select_placeholder'] }}</option>
                                                @foreach($registration['source_options'] as $option)<option>{{ $option }}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="agree" id="agreeWrap">
                                    <input type="checkbox" id="agree" />
                                    <label for="agree" style="cursor: pointer">
                                        {{ $registration['agreement'] }} <span class="req">*</span>
                                    </label>
                                </div>
                                <span class="err" data-err-for="agree" style="margin-top: 8px"></span>

                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn" style="margin-top: 22px">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z" /></svg>
                                    {{ $registration['submit'] }}
                                </button>

                                <p class="hint" style="text-align: center; margin-top: 14px">
                                    {{ $registration['privacy_note'] }}
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- ================= الفوتر ================= --}}
        <footer>
            <div class="wrap">
                <div class="foot-grid">
                    <div>
                        <a href="#top" class="brand" style="margin-bottom: 14px">
                            <span class="brand-card lg">
                                <img
                                    src="{{ $logoSrc }}"
                                    alt="{{ $identity['logo_alt'] }}"
                                    onerror="this.remove()"
                                />
                                <span class="slot-hint">{{ $identity['logo_placeholder'] }}<small>LOGO</small></span>
                            </span>
                        </a>
                        <p>{{ $footer['description'] }}</p>
                        <div class="socials">
                            <a href="{{ $identity['facebook_url'] ?: '#' }}" aria-label="فيسبوك">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.25-1.5 1.55-1.5h1.65V4.6c-.29-.04-1.27-.13-2.41-.13-2.39 0-4.02 1.46-4.02 4.13v2.3H7.5V14h2.77v8h3.23Z" /></svg>
                            </a>
                            <a href="{{ $identity['instagram_url'] ?: '#' }}" aria-label="إنستغرام">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" /><circle cx="17.2" cy="6.8" r="1.2" fill="currentColor" stroke="none" /></svg>
                            </a>
                            <a href="{{ $identity['telegram_url'] ?: '#' }}" aria-label="تيليجرام">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M21.6 4.3 2.9 11.5c-.9.35-.9.85-.15 1.06l4.3 1.35 1.65 5.05c.2.55.36.77.72.77.35 0 .5-.16.7-.35l2.05-2 4.25 3.15c.78.43 1.34.2 1.53-.72l2.76-13c.28-1.13-.4-1.65-1.1-1.35Z" /></svg>
                            </a>
                            <a href="{{ $identity['linkedin_url'] ?: '#' }}" aria-label="لينكدإن">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 5A1.94 1.94 0 1 1 5 6.94 1.94 1.94 0 0 1 6.94 5ZM5.3 8.9h3.3V19H5.3V8.9Zm5.4 0h3.16v1.38h.05c.44-.77 1.5-1.58 3.1-1.58 3.3 0 3.9 2.02 3.9 4.65V19h-3.3v-4.86c0-1.16-.02-2.65-1.7-2.65-1.7 0-2.96 1.26-2.96 2.57V19h-3.3V8.9Z" /></svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4>{{ $footer['quick_links_title'] }}</h4>
                        <ul>
                            <li><a href="#about">{{ $identity['nav']['about'] }}</a></li>
                            <li><a href="#tracks">{{ $identity['nav']['tracks'] }}</a></li>
                            <li><a href="#timeline">{{ $identity['nav']['timeline'] }}</a></li>
                            <li><a href="#prizes">{{ $identity['nav']['prizes'] }}</a></li>
                            <li><a href="#rules">{{ $identity['nav']['rules'] }}</a></li>
                            <li><a href="#register">{{ $identity['nav']['register'] }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>{{ $footer['contact_title'] }}</h4>
                        <ul>
                            <li><a href="mailto:{{ $identity['email'] }}" dir="ltr">{{ $identity['email'] }}</a></li>
                            <li><a href="tel:{{ preg_replace('/\s+/', '', $identity['phone']) }}" dir="ltr">{{ $identity['phone'] }}</a></li>
                            <li>{{ $identity['location'] }}</li>
                            <li>{{ $footer['partner_line'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="foot-orgs">
                    {{-- مكان شعار النادي الهندسي (يوصل لاحقاً) --}}
                    <div class="logo-slot slot-light">
                        <img src="{{ $clubLogoSrc }}" alt="{{ $identity['engineering_logo_alt'] }}" onerror="this.remove()" />
                        <span class="slot-hint">{{ $identity['engineering_logo_placeholder'] }}<small>ENG CLUB</small></span>
                    </div>
                    {{-- مكان شعار حاضنة يوكاس (يوصل لاحقاً) --}}
                    <div class="logo-slot slot-light">
                        <img src="{{ $incubatorLogoSrc }}" alt="{{ $identity['incubator_logo_alt'] }}" onerror="this.remove()" />
                        <span class="slot-hint">{{ $identity['incubator_logo_placeholder'] }}<small>UCAS INCUBATOR</small></span>
                    </div>
                </div>

                <div class="foot-bottom">
                    <span>
                        © <span id="yr">{{ $hero['title_year'] }}</span> {{ $footer['copyright'] }}
                    </span>
                    <span class="mono" style="direction: ltr">{{ $footer['signature'] }}</span>
                </div>
            </div>
        </footer>

        <button class="to-top" id="toTop" aria-label="{{ $identity['accessibility']['back_to_top'] }}">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7" /></svg>
        </button>

        {{-- ================= التوست والمودال ================= --}}
        <div class="toast" id="toast" role="status" aria-live="polite"></div>

        <div class="modal" id="okModal" role="dialog" aria-modal="true" aria-labelledby="okTitle">
            <div class="modal-box">
                <div class="ok-ring">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
                </div>
                <h3 id="okTitle">{{ $registration['success_title'] }}</h3>
                <p id="okMsg">{{ $registration['success_message'] }}</p>

                <div class="ref">
                    <span>{{ $registration['reference_label'] }}</span>
                    <b id="okRef">—</b>
                </div>

                <div class="modal-actions">
                    <a class="btn btn-green" id="okWa" href="#" target="_blank" rel="noopener" hidden>{{ $registration['whatsapp_button'] }}</a>
                    <button class="btn btn-ghost" id="okDownload" type="button">{{ $registration['download_button'] }}</button>
                    <button class="btn btn-ghost" id="okClose" type="button">{{ $registration['close_button'] }}</button>
                </div>
            </div>
        </div>

        {{-- قالب عضو الفريق --}}
        <template id="memberTpl">
            <div class="member">
                <div class="member-head">
                    <b>{{ $registration['member_label'] }} #<span class="mnum"></span></b>
                    <button type="button" class="rm">{{ $registration['remove_member'] }}</button>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label>{{ $registration['fields']['full_name'] }} <span class="req">*</span></label>
                        <input type="text" data-m="name" placeholder="{{ $registration['member_name_placeholder'] }}" />
                        <span class="err"></span>
                    </div>
                    <div class="field">
                        <label>{{ $registration['fields']['email'] }} <span class="req">*</span></label>
                        <input type="email" data-m="email" dir="ltr" placeholder="name@example.com" />
                        <span class="err"></span>
                    </div>
                    <div class="field">
                        <label>{{ $registration['fields']['phone'] }}</label>
                        <input type="tel" data-m="phone" dir="ltr" placeholder="05xxxxxxxx" />
                        <span class="err"></span>
                    </div>
                    <div class="field">
                        <label>{{ $registration['member_role_label'] }}</label>
                        <select data-m="role">
                            <option value="">{{ $registration['select_placeholder'] }}</option>
                            @foreach($registration['role_options'] as $option)<option>{{ $option }}</option>@endforeach
                        </select>
                        <span class="err"></span>
                    </div>
                    <div class="field">
                        <label>{{ $registration['member_skill_label'] }}</label>
                        <input type="text" data-m="major" placeholder="{{ $registration['member_skill_placeholder'] }}" />
                        <span class="err"></span>
                    </div>
                </div>
            </div>
        </template>

        <script>
            /* =========================================================
               1) الإعدادات — عدّل من هنا فقط
               ========================================================= */
            const CONFIG = {
                /* آخر موعد للتقديم (بتوقيت غزة +03:00) */
                deadline: @json($hero['deadline']),

                /* تواريخ الحدث كما تظهر بالصفحة */
                eventDates: @json($hero['event_dates']),

                /* إغلاق التسجيل يدوياً عند الحاجة */
                registrationOpen: {{ $hero['registration_open'] ? 'true' : 'false' }},

                /* راوت Laravel اللي بيستقبل الطلب */
                endpoint: '{{ route('registrations.store') }}',

                /* رقم واتساب بصيغة دولية بدون + (يظهر زر إرسال نسخة إذا تعبّى) */
                whatsapp: @json(config('hackathon.whatsapp')),

                participantTitle: @json($registration['participant_title']),
                leaderTitle: @json($registration['leader_title']),
                successTitle: @json($registration['success_title']),
                successMessage: @json($registration['success_message']),
                failureTitle: @json($registration['failure_title']),
                failureMessage: @json($registration['failure_message']),
                terminalText: @json($hero['terminal_text']),
                deadlineEnded: @json($hero['deadline_ended']),
                registrationPaused: @json($hero['registration_paused']),
                remainingPrefix: @json($hero['remaining_prefix']),
                countdownUnits: @json($hero['countdown_units']),
                messages: @json($registration['client_messages']),
                addMemberText: @json($registration['fields']['add_member']),

                /* الحد الأعلى لعدد أعضاء الفريق (بما فيهم القائد) */
                maxTeamSize: {{ (int) config('hackathon.max_team_size', 6) }},

                /* حفظ مسودة التسجيل في متصفح المشارك */
                saveDraft: true,
            };

            const $ = (s, r = document) => r.querySelector(s);
            const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
            /* خلفية الصفحة المتحركة — تُضبط من لوحة الإدارة */
            const BACKGROUND_ENABLED = {{ $backgroundOn ? 'true' : 'false' }};

            /* =========================================================
               2) العداد التنازلي
               ========================================================= */
            (function countdown() {
                const card = $('#countCard');
                const deadline = new Date(CONFIG.deadline);
                if (isNaN(deadline.getTime())) return;

                const fmtDate = new Intl.DateTimeFormat('ar-EG-u-nu-latn', { dateStyle: 'full' });
                const fmtTime = new Intl.DateTimeFormat('ar-EG-u-nu-latn', { hour: '2-digit', minute: '2-digit' });
                const full = fmtDate.format(deadline) + ' — ' + fmtTime.format(deadline);

                const d1 = $('#deadlineTxt');
                const d2 = $('#asideDeadline');
                const d3 = $('#tl2');
                if (d1) d1.textContent = full;
                if (d2) d2.textContent = full;
                if (d3) d3.textContent = fmtDate.format(deadline);

                const els = { d: $('#cd-d'), h: $('#cd-h'), m: $('#cd-m'), s: $('#cd-s') };
                const prev = { d: null, h: null, m: null, s: null };

                function set(key, val) {
                    const el = els[key];
                    if (!el) return;
                    const txt = String(val).padStart(2, '0');
                    if (prev[key] === txt) return;
                    el.textContent = txt;
                    prev[key] = txt;
                    if (!reduceMotion) {
                        el.classList.remove('tick');
                        void el.offsetWidth;
                        el.classList.add('tick');
                    }
                }

                function tick() {
                    const diff = deadline.getTime() - Date.now();
                    const open = CONFIG.registrationOpen && diff > 0;

                    if (!open) {
                        card.classList.add('closed');
                        const n = $('#asideLeft');
                        if (n) n.textContent = CONFIG.registrationOpen ? CONFIG.deadlineEnded : CONFIG.registrationPaused;
                        const tl = $('#tl-open');
                        if (tl) tl.classList.remove('now');
                        return;
                    }

                    card.classList.remove('closed');
                    const days = Math.floor(diff / 864e5);
                    const hrs = Math.floor((diff % 864e5) / 36e5);
                    const mins = Math.floor((diff % 36e5) / 6e4);
                    const secs = Math.floor((diff % 6e4) / 1000);
                    set('d', days);
                    set('h', hrs);
                    set('m', mins);
                    set('s', secs);

                    const n = $('#asideLeft');
                    if (n) n.textContent = CONFIG.remainingPrefix + ' ' + days + ' ' + CONFIG.countdownUnits.days + ' و ' + hrs + ' ' + CONFIG.countdownUnits.hours + ' و ' + mins + ' ' + CONFIG.countdownUnits.minutes;
                }

                tick();
                setInterval(tick, 1000);

                const md = $('#metaDates');
                if (md) md.textContent = CONFIG.eventDates;
            })();

            /* =========================================================
               3) خلفية المطر الرقمي
               ========================================================= */
            (function matrix() {
                const cv = $('#matrix');
                if (!cv || reduceMotion || !BACKGROUND_ENABLED) return;
                const ctx = cv.getContext('2d', { alpha: true });
                if (!ctx) return;

                // حروف إنجليزية وأرقام ورموز فقط (بدون أي حروف عربية)
                const GLYPHS = '01ABCDEF#$%&@{}[]<>/\\+=*?23456789'.split('');
                // كم صف بتتحرك القطرة بكل إطار — كل ما قلّ الرقم كل ما صار أبطأ
                const SPEED = 0.12;

                // الألوان تُقرأ من متغيّرات CSS، يعني بتتبع الوضع والألوان المختارة
                // من لوحة الإدارة. منمرّرها على عنصر مؤقت حتى تتحوّل لقيمة
                // rgb/rgba صريحة يفهمها الـ canvas.
                const palette = {
                    fade: 'rgba(255,255,255,0.09)',
                    head: 'rgba(42,56,118,0.26)',
                    accent: 'rgba(241,121,30,0.42)',
                    body: 'rgba(102,172,47,0.18)',
                };

                function readPalette() {
                    const cs = getComputedStyle(document.documentElement);
                    const probe = document.createElement('span');
                    probe.style.cssText = 'position:absolute;visibility:hidden;pointer-events:none';
                    document.body.appendChild(probe);

                    const resolve = (name, fallback) => {
                        const raw = (cs.getPropertyValue(name) || '').trim();
                        if (!raw) return fallback;
                        probe.style.color = 'rgb(1, 2, 3)';
                        probe.style.color = raw;
                        const out = getComputedStyle(probe).color;
                        return out === 'rgb(1, 2, 3)' ? fallback : out;
                    };

                    palette.fade = resolve('--matrix-fade', palette.fade);
                    palette.head = resolve('--matrix-head', palette.head);
                    palette.accent = resolve('--matrix-accent', palette.accent);
                    palette.body = resolve('--matrix-body', palette.body);
                    probe.remove();
                }
                readPalette();

                let cols = 0,
                    drops = [],
                    rows = [],
                    dpr = 1,
                    fs = 16,
                    raf = null;

                function resize() {
                    dpr = Math.min(window.devicePixelRatio || 1, 2);
                    cv.width = Math.floor(window.innerWidth * dpr);
                    cv.height = Math.floor(window.innerHeight * dpr);
                    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                    fs = window.innerWidth < 720 ? 14 : 17;
                    cols = Math.ceil(window.innerWidth / fs);
                    drops = new Array(cols).fill(0).map(() => Math.random() * -40);
                    rows = new Array(cols).fill(-1);
                    ctx.clearRect(0, 0, cv.width, cv.height);
                }

                function draw() {
                    raf = requestAnimationFrame(draw);

                    ctx.fillStyle = palette.fade;
                    ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
                    ctx.font = fs + "px 'Share Tech Mono', monospace";
                    ctx.textBaseline = 'top';

                    for (let i = 0; i < cols; i++) {
                        drops[i] += SPEED;
                        const row = Math.floor(drops[i]);
                        // ما نرسم إلا لما يتغيّر الصف — بيمنع الوميض وبيهدّي الحركة
                        if (row === rows[i]) continue;
                        rows[i] = row;

                        const x = i * fs;
                        const y = row * fs;

                        // رأس القطرة
                        ctx.fillStyle = Math.random() > 0.99 ? palette.accent : palette.head;
                        ctx.fillText(GLYPHS[(Math.random() * GLYPHS.length) | 0], x, y);

                        // الحرف اللي فوقه بلون أهدأ
                        ctx.fillStyle = palette.body;
                        ctx.fillText(GLYPHS[(Math.random() * GLYPHS.length) | 0], x, y - fs);

                        if (y > window.innerHeight && Math.random() > 0.985) {
                            drops[i] = Math.random() * -20;
                            rows[i] = -1;
                        }
                    }
                }

                resize();
                draw();
                window.addEventListener('resize', resize, { passive: true });
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        cancelAnimationFrame(raf);
                        raf = null;
                    } else if (!raf) draw();
                });
            })();

            /* =========================================================
               4) تأثيرات الواجهة
               ========================================================= */
            (function ui() {
                const hdr = $('#hdr');
                const prog = $('#progress');
                const toTop = $('#toTop');
                const glow = $('#cursorGlow');

                function onScroll() {
                    const y = window.scrollY;
                    const max = document.documentElement.scrollHeight - window.innerHeight;
                    prog.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';
                    hdr.classList.toggle('stuck', y > 30);
                    toTop.classList.toggle('on', y > 700);
                }
                onScroll();
                window.addEventListener('scroll', onScroll, { passive: true });
                toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

                const items = $$('[data-reveal]');
                const show = (el) => el.classList.add('in');

                // إظهار العناصر اللي دخلت الشاشة.
                // ملاحظة: ما بنعتمد على requestAnimationFrame ولا على
                // IntersectionObserver كمسار وحيد — لأنهن بيتوقّفوا لما يكون
                // التاب مش مرسوم، وساعتها بتطلع الصفحة فاضية.
                function revealVisible() {
                    const vh = window.innerHeight || document.documentElement.clientHeight;
                    items.forEach((el) => {
                        if (el.classList.contains('in')) return;
                        const r = el.getBoundingClientRect();
                        if (r.top < vh * 0.94 && r.bottom > 0) show(el);
                    });
                }

                if (reduceMotion) {
                    items.forEach(show);
                } else {
                    window.addEventListener('scroll', revealVisible, { passive: true });
                    window.addEventListener('resize', revealVisible, { passive: true });
                    window.addEventListener('load', revealVisible);
                    document.addEventListener('visibilitychange', () => {
                        if (!document.hidden) revealVisible();
                    });
                    revealVisible();
                    [250, 800, 1800].forEach((t) => setTimeout(revealVisible, t));

                    // تحسين اختياري لما يكون المتصفح شغّال طبيعي
                    if ('IntersectionObserver' in window) {
                        const io = new IntersectionObserver(
                            (entries) => {
                                entries.forEach((e) => {
                                    if (!e.isIntersecting) return;
                                    show(e.target);
                                    io.unobserve(e.target);
                                });
                            },
                            { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
                        );
                        items.forEach((el) => io.observe(el));
                    }

                    // شبكة أمان أخيرة: لو ما انعرض ولا عنصر لأي سبب
                    setTimeout(() => {
                        if (!items.some((el) => el.classList.contains('in'))) items.forEach(show);
                    }, 2600);
                }

                const burger = $('#burger');
                const drawer = $('#drawer');
                burger.addEventListener('click', () => {
                    const open = drawer.classList.toggle('open');
                    burger.classList.toggle('open', open);
                    burger.setAttribute('aria-expanded', String(open));
                });
                $$('#drawer a').forEach((a) =>
                    a.addEventListener('click', () => {
                        drawer.classList.remove('open');
                        burger.classList.remove('open');
                        burger.setAttribute('aria-expanded', 'false');
                    })
                );

                if (glow && window.matchMedia('(pointer: fine)').matches && !reduceMotion) {
                    let tx = 0, ty = 0, cx = 0, cy = 0, shown = false;
                    window.addEventListener(
                        'mousemove',
                        (e) => {
                            tx = e.clientX;
                            ty = e.clientY;
                            if (!shown) {
                                cx = tx;
                                cy = ty;
                                glow.classList.add('on');
                                shown = true;
                            }
                        },
                        { passive: true }
                    );
                    (function loop() {
                        cx += (tx - cx) * 0.11;
                        cy += (ty - cy) * 0.11;
                        glow.style.transform = 'translate(' + cx + 'px,' + cy + 'px)';
                        requestAnimationFrame(loop);
                    })();
                }

                const line = $('#termLine');
                if (line) {
                    const caret = line.querySelector('.caret');
                    const words = [CONFIG.terminalText];
                    if (reduceMotion) {
                        line.insertBefore(document.createTextNode(words[0]), caret);
                    } else {
                        let wi = 0, ci = 0;
                        const txt = document.createTextNode('');
                        line.insertBefore(txt, caret);
                        (function type() {
                            const w = words[wi];
                            if (ci <= w.length) {
                                txt.nodeValue = w.slice(0, ci++);
                                setTimeout(type, 42);
                            } else {
                                setTimeout(() => {
                                    wi = (wi + 1) % words.length;
                                    ci = 0;
                                    txt.nodeValue = '';
                                    type();
                                }, 1900);
                            }
                        })();
                    }
                }

                $$('#termBody .l').forEach((el, i) => {
                    el.style.animationDelay = reduceMotion ? '0s' : i * 0.42 + 's';
                });
            })();

            /* =========================================================
               5) نموذج التسجيل
               ========================================================= */
            (function form() {
                const f = $('#regForm');
                const members = $('#members');
                const addBtn = $('#addMember');
                const teamBlock = $('#teamBlock');
                const teamSize = $('#teamSize');
                const leadTitle = $('#leadTitle');
                const tpl = $('#memberTpl');
                const agreeWrap = $('#agreeWrap');
                const submitBtn = $('#submitBtn');
                const DRAFT_KEY = 'cai2026_draft';
                let mode = 'individual';
                let sent = false;
                let lastPayload = null;

                /* ---------- أدوات ---------- */
                function setErr(input, msg) {
                    const field = input.closest('.field');
                    const err = field ? field.querySelector('.err') : null;
                    if (msg) {
                        if (field) field.classList.add('bad');
                        input.setAttribute('aria-invalid', 'true');
                        if (err) err.textContent = msg;
                    } else {
                        if (field) field.classList.remove('bad');
                        input.removeAttribute('aria-invalid');
                        if (err) err.textContent = '';
                    }
                }

                function setBlockErr(name, msg) {
                    const err = document.querySelector('[data-err-for="' + name + '"]');
                    if (!err) return;
                    err.textContent = msg || '';
                    err.classList.toggle('shown', !!msg);
                }

                const isEmail = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v);
                const isPhone = (v) =>
                    /^[+]?[\d\s\-()]{8,17}$/.test(v.trim()) && (v.match(/\d/g) || []).length >= 8;

                let toastTimer;
                function toast(msg, bad) {
                    const t = $('#toast');
                    t.textContent = msg;
                    t.classList.toggle('bad', !!bad);
                    t.classList.add('show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => t.classList.remove('show'), 4600);
                }

                /* ---------- فردي / فريق ---------- */
                const bInd = $('#modeIndividual');
                const bTeam = $('#modeTeam');

                function setMode(m) {
                    mode = m;
                    const ind = m === 'individual';
                    bInd.classList.toggle('active', ind);
                    bTeam.classList.toggle('active', !ind);
                    bInd.setAttribute('aria-selected', String(ind));
                    bTeam.setAttribute('aria-selected', String(!ind));
                    teamBlock.hidden = ind;
                    leadTitle.textContent = ind ? CONFIG.participantTitle : CONFIG.leaderTitle;
                    if (!ind && members.children.length === 0) {
                        const need = Math.max(1, (parseInt(teamSize.value, 10) || 4) - 1);

                        for (let i = 0; i < need; i++) addMember(true);
                    }
                    saveDraft();
                }

                bInd.addEventListener('click', () => setMode('individual'));
                bTeam.addEventListener('click', () => setMode('team'));

                /* ---------- الأعضاء ---------- */
                function renumber() {
                    $$('.member', members).forEach((el, i) => {
                        el.querySelector('.mnum').textContent = i + 2;
                    });
                    const max = CONFIG.maxTeamSize - 1;
                    const full = members.children.length >= max;
                    addBtn.disabled = full;
                    if (full) {
                        addBtn.textContent = CONFIG.messages.max_members.replace(':max', CONFIG.maxTeamSize);
                    } else {
                        addBtn.innerHTML =
                            '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg> ' + CONFIG.addMemberText;
                    }
                }

                function addMember(quiet) {
                    const max = CONFIG.maxTeamSize - 1;
                    if (members.children.length >= max) return;
                    const node = tpl.content.firstElementChild.cloneNode(true);
                    members.appendChild(node);
                    renumber();
                    if (!quiet) {
                        const inp = node.querySelector('input');
                        if (inp) inp.focus({ preventScroll: true });
                    }
                }

                addBtn.addEventListener('click', () => addMember(false));

                members.addEventListener('click', (e) => {
                    const btn = e.target.closest('.rm');
                    if (!btn) return;
                    btn.closest('.member').remove();
                    renumber();
                    saveDraft();
                });

                teamSize.addEventListener('change', () => {
                    const want = Math.max(0, (parseInt(teamSize.value, 10) || 0) - 1);
                    if (!want) return;
                    while (members.children.length < want) addMember(true);
                    while (members.children.length > want) members.lastElementChild.remove();
                    renumber();
                    saveDraft();
                });

                f.addEventListener('input', (e) => {
                    const t = e.target;
                    if (t.matches('input, select, textarea') && t.closest('.field')) setErr(t, '');
                    saveDraft();
                });
                f.addEventListener('change', saveDraft);

                /* ---------- المسودة ---------- */
                function collect() {
                    const data = { mode, fields: {}, members: [] };
                    $$('input[id], select[id], textarea[id]', f).forEach((el) => {
                        if (el.id === 'agree' || el.id === 'teamSize') return;
                        data.fields[el.id] = el.value;
                    });
                    $$('.member', members).forEach((m) => {
                        const o = {};
                        $$('input[data-m], select[data-m]', m).forEach((i) => (o[i.dataset.m] = i.value));
                        data.members.push(o);
                    });
                    return data;
                }

                function saveDraft() {
                    if (!CONFIG.saveDraft || sent) return;
                    try {
                        localStorage.setItem(DRAFT_KEY, JSON.stringify(collect()));
                    } catch (e) {
                        /* تجاهل */
                    }
                }

                function loadDraft() {
                    if (!CONFIG.saveDraft) return;
                    let raw;
                    try {
                        raw = localStorage.getItem(DRAFT_KEY);
                    } catch (e) {
                        return;
                    }
                    if (!raw) return;

                    let d;
                    try {
                        d = JSON.parse(raw);
                    } catch (e) {
                        return;
                    }

                    Object.entries(d.fields || {}).forEach(([k, v]) => {
                        const el = document.getElementById(k);
                        if (el) el.value = v;
                    });

                    if (d.mode === 'team') {
                        setMode('team');
                        (d.members || []).forEach((m) => {
                            addMember(true);
                            const node = members.lastElementChild;
                            if (!node) return;
                            Object.entries(m).forEach(([k, v]) => {
                                const i = node.querySelector('[data-m="' + k + '"]');
                                if (i) i.value = v;
                            });
                        });
                        renumber();
                    }
                }

                /* ---------- التحقق ---------- */
                function scrollToFirst(el) {
                    const box = el.closest('.member') || el;
                    box.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
                    setTimeout(() => el.focus({ preventScroll: true }), 280);
                }

                function validate() {
                    let ok = true;
                    let first = null;

                    const req = [
                        ['fullName', CONFIG.messages.full_name_required],
                        ['email', CONFIG.messages.email_required],
                        ['phone', CONFIG.messages.phone_required],
                        ['university', CONFIG.messages.university_required],
                        ['major', CONFIG.messages.major_required],
                        ['skills', CONFIG.messages.skills_required],
                        ['track', CONFIG.messages.track_required],
                    ];

                    req.forEach(([id, msg]) => {
                        const el = document.getElementById(id);
                        if (!el) return;
                        if (!(el.value || '').trim()) {
                            setErr(el, msg);
                            ok = false;
                            first = first || el;
                        } else setErr(el, '');
                    });

                    const em = $('#email');
                    if (em && em.value.trim() && !isEmail(em.value.trim())) {
                        setErr(em, CONFIG.messages.invalid_email);
                        ok = false;
                        first = first || em;
                    }

                    const ph = $('#phone');
                    if (ph && ph.value.trim() && !isPhone(ph.value)) {
                        setErr(ph, CONFIG.messages.invalid_phone);
                        ok = false;
                        first = first || ph;
                    }

                    if (mode === 'team') {
                        const tn = $('#teamName');
                        if (!tn.value.trim()) {
                            setErr(tn, CONFIG.messages.team_name_required);
                            ok = false;
                            first = first || tn;
                        } else setErr(tn, '');

                        const sizeVal = parseInt(teamSize.value, 10);
                        if (!sizeVal) {
                            setBlockErr('teamSize', CONFIG.messages.team_size_required);
                            ok = false;
                        } else if (members.children.length < sizeVal - 1) {
                            setBlockErr(
                                'teamSize',
                                'أضف بيانات ' + (sizeVal - 1) + ' من أعضاء الفريق (المطلوب ' + sizeVal + ' أعضاء)'
                            );
                            ok = false;
                        } else {
                            setBlockErr('teamSize', '');
                        }

                        $$('.member', members).forEach((m) => {
                            const name = m.querySelector('input[data-m="name"]');
                            const mail = m.querySelector('input[data-m="email"]');
                            if (!name.value.trim()) {
                                setErr(name, CONFIG.messages.member_name_required);
                                ok = false;
                                first = first || name;
                            } else setErr(name, '');

                            if (!mail.value.trim()) {
                                setErr(mail, CONFIG.messages.member_email_required);
                                ok = false;
                                first = first || mail;
                            } else if (!isEmail(mail.value.trim())) {
                                setErr(mail, CONFIG.messages.invalid_email);
                                ok = false;
                                first = first || mail;
                            } else setErr(mail, '');
                        });
                    }

                    const ag = $('#agree');
                    if (!ag.checked) {
                        agreeWrap.classList.add('bad');
                        setBlockErr('agree', CONFIG.messages.agreement_required);
                        ok = false;
                        first = first || ag;
                    } else {
                        agreeWrap.classList.remove('bad');
                        setBlockErr('agree', '');
                    }

                    if (!ok && first) {
                        scrollToFirst(first);
                        toast(CONFIG.messages.fix_fields, true);
                    }
                    return ok;
                }

                /* ---------- بناء الطلب ---------- */
                function buildPayload() {
                    const g = (id) => {
                        const el = document.getElementById(id);
                        return el ? el.value.trim() : '';
                    };

                    const payload = {
                        participationType: mode === 'individual' ? 'فردي' : 'فريق',
                        applicant: {
                            fullName: g('fullName'),
                            email: g('email'),
                            phone: g('phone'),
                            university: g('university'),
                            major: g('major'),
                            year: g('year'),
                            skills: g('skills'),
                            track: g('track'),
                            experience: g('experience'),
                            links: g('links'),
                            source: g('source'),
                        },
                        project: { idea: g('idea') },
                    };

                    if (mode === 'team') {
                        payload.team = {
                            name: g('teamName'),
                            size: g('teamSize'),
                            members: $$('.member', members).map((m) => ({
                                name: m.querySelector('input[data-m="name"]').value.trim(),
                                email: m.querySelector('input[data-m="email"]').value.trim(),
                                phone: m.querySelector('input[data-m="phone"]').value.trim(),
                                role: (m.querySelector('[data-m="role"]') || {}).value?.trim() || '',
                                major: (m.querySelector('input[data-m="major"]') || {}).value?.trim() || '',
                            })),
                        };
                    }

                    return payload;
                }

                /* تحويل أخطاء Laravel (422) لحقول النموذج */
                const SERVER_MAP = {
                    'applicant.fullName': 'fullName',
                    'applicant.email': 'email',
                    'applicant.phone': 'phone',
                    'applicant.university': 'university',
                    'applicant.major': 'major',
                    'applicant.skills': 'skills',
                    'applicant.track': 'track',
                };

                function applyServerErrors(errors) {
                    let firstKey = null;
                    Object.keys(errors).forEach((key) => {
                        if (firstKey === null) firstKey = key;
                        const id = SERVER_MAP[key];
                        if (id) setErr(document.getElementById(id), errors[key][0]);
                    });
                    if (firstKey && SERVER_MAP[firstKey]) {
                        scrollToFirst(document.getElementById(SERVER_MAP[firstKey]));
                    }
                }

                /* ---------- واتساب + تحميل نسخة ---------- */
                function waText(p) {
                    const L = [];
                    L.push('*طلب تسجيل — هاكاثون السايبر والذكاء الاصطناعي 2026*');
                    L.push('رقم الطلب: ' + p.reference);
                    L.push('نوع المشاركة: ' + p.participationType);
                    L.push('');
                    L.push('— بيانات مقدّم الطلب —');
                    L.push('الاسم: ' + p.applicant.fullName);
                    L.push('البريد: ' + p.applicant.email);
                    L.push('الجوال: ' + p.applicant.phone);
                    L.push('الجامعة: ' + p.applicant.university);
                    L.push('التخصص: ' + p.applicant.major);
                    if (p.applicant.year) L.push('السنة: ' + p.applicant.year);
                    L.push('المهارات: ' + p.applicant.skills);
                    L.push('المسار: ' + p.applicant.track);
                    if (p.applicant.experience) L.push('الخبرة: ' + p.applicant.experience);
                    if (p.applicant.links) L.push('رابط: ' + p.applicant.links);
                    if (p.team) {
                        L.push('');
                        L.push('— الفريق —');
                        L.push('اسم الفريق: ' + p.team.name);
                        L.push('عدد الأعضاء: ' + p.team.size);
                        p.team.members.forEach((m, i) => {
                            L.push(
                                'عضو ' + (i + 2) + ': ' + m.name + ' | ' + m.email +
                                    (m.phone ? ' | ' + m.phone : '') +
                                    (m.role ? ' | ' + m.role : '') +
                                    (m.major ? ' | ' + m.major : '')
                            );
                        });
                    }
                    if (p.project && p.project.idea) {
                        L.push('');
                        L.push('— الفكرة —');
                        L.push(p.project.idea);
                    }
                    return L.join('\n');
                }

                function download(p) {
                    const blob = new Blob([JSON.stringify(p, null, 2)], { type: 'application/json' });
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = 'registration-' + p.reference + '.json';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    setTimeout(() => URL.revokeObjectURL(a.href), 4000);
                }

                /* ---------- المودال ---------- */
                function openModal(payload, success) {
                    $('#okRef').textContent = payload.reference;
                    $('#okTitle').textContent = success ? CONFIG.successTitle : CONFIG.failureTitle;
                    $('#okMsg').textContent = success ? CONFIG.successMessage : CONFIG.failureMessage;

                    const wa = $('#okWa');
                    if (CONFIG.whatsapp) {
                        wa.hidden = false;
                        wa.href = 'https://wa.me/' + CONFIG.whatsapp + '?text=' + encodeURIComponent(waText(payload));
                    } else {
                        wa.hidden = true;
                    }

                    $('#okModal').classList.add('open');
                    document.body.classList.add('is-locked');
                }

                function closeModal() {
                    $('#okModal').classList.remove('open');
                    document.body.classList.remove('is-locked');
                }

                $('#okClose').addEventListener('click', closeModal);
                $('#okModal').addEventListener('click', (e) => {
                    if (e.target.id === 'okModal') closeModal();
                });
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && $('#okModal').classList.contains('open')) closeModal();
                });
                $('#okDownload').addEventListener('click', () => {
                    if (lastPayload) download(lastPayload);
                });

                function refCode() {
                    return (
                        'CAI26-' +
                        Math.random().toString(36).slice(2, 6).toUpperCase() +
                        Math.floor(Math.random() * 90 + 10)
                    );
                }

                /* ---------- الإرسال ---------- */
                f.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    if (!CONFIG.registrationOpen) {
                        toast(CONFIG.messages.registration_closed, true);
                        return;
                    }
                    if (!validate()) return;

                    const payload = buildPayload();
                    payload.reference = refCode();
                    lastPayload = payload;

                    submitBtn.disabled = true;
                    const original = submitBtn.innerHTML;
                    submitBtn.textContent = CONFIG.messages.sending;

                    try {
                        const res = await fetch(CONFIG.endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                Accept: 'application/json',
                                'X-CSRF-TOKEN': CSRF,
                            },
                            body: JSON.stringify(payload),
                        });

                        let data = null;
                        try {
                            data = await res.json();
                        } catch (err) {
                            data = null;
                        }

                        if (!res.ok) {
                            if (res.status === 422 && data && data.errors) {
                                applyServerErrors(data.errors);
                                toast(data.message || 'تحقق من البيانات المدخلة', true);
                                return;
                            }
                            throw new Error('HTTP ' + res.status);
                        }

                        if (data && data.reference) {
                            payload.reference = data.reference;
                            lastPayload = payload;
                        }

                        sent = true;
                        try {
                            localStorage.removeItem(DRAFT_KEY);
                        } catch (err) {
                            /* تجاهل */
                        }
                        f.reset();
                        members.innerHTML = '';
                        setMode('individual');
                        renumber();
                        openModal(payload, true);
                    } catch (err) {
                        console.error(err);
                        toast(CONFIG.messages.send_failed, true);
                        openModal(payload, false);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = original;
                    }
                });

                /* ---------- تشغيل ---------- */
                loadDraft();
                renumber();
                setMode('individual');
            })();

            document.getElementById('yr').textContent = new Date().getFullYear();
        </script>
    </body>
</html>
