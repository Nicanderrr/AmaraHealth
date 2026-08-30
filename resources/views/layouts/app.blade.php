<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#9F1239">
    <title>{{ $title ?? config('app.name', 'Amara Health') }}</title>
    <meta name="description" content="Amara Health - private sexual health information and support for female tertiary students.">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('themes/helpest/assets/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('themes/helpest/assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('themes/helpest/assets/images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('themes/helpest/assets/images/favicons/site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/custom-animate.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/font-awesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/jarallax.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/jquery.magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/vegas.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/donate.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/services.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/become-volenteer.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/causes.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/counter.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/video.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/team.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/brand.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/testimonial.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/donation.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/faq.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/process.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/sliding-text.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/cta.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/feature.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/why-choose.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/banner.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/module-css/event.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/helpest/assets/css/dark.css') }}">
    <style>
        .app-page-shell .page-header {
            padding-top: 54px;
        }
        body,
        .app-page-shell {
            background:
                radial-gradient(circle at top left, rgba(225, 29, 72, 0.14), transparent 24rem),
                linear-gradient(180deg, #4a0f23 0%, #2a0614 44rem, #fff7fa 44rem, #ffffff 100%);
        }
        .main-menu-three__wrapper,
        .stricky-header.main-menu-three {
            backdrop-filter: blur(16px);
        }
        .main-header-three {
            background: #4a0f23;
        }
        .main-menu-three__top {
            background: #2a0614;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .main-menu-three__wrapper {
            background: rgba(74, 15, 35, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .main-menu-three__contact-list li .text p,
        .main-menu-three__contact-list li .text p a,
        .main-menu-three__contact-list li .icon i,
        .main-menu .main-menu__list > li > a,
        .main-menu-three__top-menu li a {
            color: rgba(255, 255, 255, 0.86);
        }
        .main-menu .main-menu__list > li.current > a,
        .main-menu .main-menu__list > li:hover > a,
        .main-menu-three__top-menu li a:hover {
            color: #fb7185;
        }
        .main-menu-three__logo {
            background: #fff;
            border-radius: 14px;
            padding: 0.45rem 0.65rem;
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.18);
        }
        .thm-btn.is-secondary {
            background: #fff;
            color: #9F1239;
            border: 1px solid rgba(159, 18, 57, 0.18);
        }
        .thm-btn.is-secondary:hover {
            color: #fff;
        }
        .thm-btn {
            background: linear-gradient(135deg, #9F1239 0%, #E11D48 100%);
            border: none;
            color: #fff;
            box-shadow: 0 12px 26px rgba(159, 18, 57, 0.18);
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }
        .thm-btn:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(159, 18, 57, 0.22);
        }
        .thm-btn.thm-btn--sm {
            padding: 0.6rem 1rem;
            border-radius: 999px;
            font-size: 0.92rem;
            line-height: 1;
        }
        .panel-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), #fff7fa);
            border: 1px solid rgba(255, 255, 255, 0.56);
            border-radius: 14px;
            box-shadow: 0 14px 38px rgba(159, 18, 57, 0.08);
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }
        .panel-card:hover {
            border-color: rgba(225, 29, 72, 0.22);
            box-shadow: 0 20px 50px rgba(159, 18, 57, 0.12);
        }
        .form-control.theme-input,
        .form-select.theme-input,
        textarea.theme-input {
            border: 1px solid rgba(15, 23, 42, 0.1);
            border-radius: 10px;
            background: #fff7fa;
            padding: 0.95rem 1rem;
            width: 100%;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }
        .form-control.theme-input:focus,
        .form-select.theme-input:focus,
        textarea.theme-input:focus {
            border-color: rgba(225, 29, 72, 0.5);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.11);
        }
        .theme-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            padding: 0.36rem 0.62rem;
            background: rgba(159, 18, 57, 0.08);
            color: #9F1239;
            font-size: 0.84rem;
            font-weight: 800;
            line-height: 1;
            text-transform: capitalize;
        }
        .alert-accent {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            border: 1px solid rgba(159, 18, 57, 0.16);
            background: linear-gradient(135deg, rgba(255, 241, 245, 0.98), rgba(159, 18, 57, 0.08));
            color: #232323;
            box-shadow: 0 18px 55px rgba(15, 23, 42, 0.08);
        }
        .ug-logo {
            display: block;
            width: auto;
            object-fit: contain;
        }
        .main-menu-three__logo .ug-logo {
            max-width: 74px;
            max-height: 56px;
        }
        .footer-widget-two__about-logo .ug-logo {
            max-width: 86px;
            max-height: 64px;
        }
        .logo-box .ug-logo {
            max-width: 92px;
            max-height: 70px;
        }
        .page-header {
            position: relative;
            overflow: hidden;
            padding: 1.15rem 0 0.95rem;
            background:
                radial-gradient(circle at top left, rgba(251, 113, 133, 0.22), transparent 28%),
                radial-gradient(circle at top right, rgba(225, 29, 72, 0.2), transparent 24%),
                linear-gradient(135deg, #2a0614 0%, #4a0f23 52%, #9f1239 100%);
        }
        .page-header__bg {
            position: absolute;
            inset: 0;
            background-position: center;
            background-size: cover;
            opacity: 0.18;
            mix-blend-mode: luminosity;
        }
        .page-header::after {
            content: "";
            position: absolute;
            inset: auto -10rem -10rem auto;
            width: 22rem;
            height: 22rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.18) 0%, transparent 68%);
            pointer-events: none;
        }
        .page-header__inner {
            position: relative;
            display: grid;
            gap: 1.25rem;
            z-index: 1;
        }
        .page-header__copy {
            max-width: 58rem;
            color: #fff;
        }
        .page-header .thm-breadcrumb li a,
        .page-header .thm-breadcrumb li span {
            color: rgba(255, 255, 255, 0.82);
        }
        .page-header .thm-breadcrumb li + li::before {
            color: rgba(255, 255, 255, 0.72);
        }
        .page-header__eyebrow {
            margin-top: 0.35rem;
            background: rgba(255, 255, 255, 0.08);
            color: #fff1f5;
        }
        .page-header h2 {
            margin: 0.35rem 0 0;
            max-width: 18ch;
            color: #fff;
            font-size: clamp(1.55rem, 2.4vw, 2.7rem);
            line-height: 1.05;
            letter-spacing: 0;
        }
        .page-header p {
            max-width: 48rem;
            margin-top: 0.6rem;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.98rem;
            line-height: 1.65;
        }
        .page-header__metrics {
            display: grid;
            gap: 1rem;
        }
        .page-header--metric-carousel .page-header__inner {
            gap: 1rem;
        }
        .page-header__metrics-carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 0.15rem 0;
            mask-image: linear-gradient(90deg, transparent 0, #000 7%, #000 93%, transparent 100%);
        }
        .page-header__metrics-carousel:hover .page-header__metrics-track,
        .page-header__metrics-carousel:focus-within .page-header__metrics-track {
            animation-play-state: paused;
        }
        .page-header__metrics-track {
            display: flex;
            width: max-content;
            gap: 1rem;
            animation: pageHeaderMetricsCarousel 15s ease-in-out infinite alternate;
        }
        .page-header__metrics-track .page-header__metric {
            flex: 0 0 clamp(230px, 27vw, 340px);
            min-height: 100%;
        }
        .page-header__metric {
            padding: 1rem 1.1rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.42);
            backdrop-filter: blur(14px);
            color: #fff;
        }
        .page-header__metric strong {
            display: block;
            margin-top: 0.2rem;
            font-size: 1.45rem;
        }
        .page-header__metric span {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }
        .page-header__metric p {
            margin: 0.4rem 0 0;
            color: rgba(255, 255, 255, 0.76);
            font-size: 0.92rem;
        }
        @keyframes pageHeaderMetricsCarousel {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(calc(-50% - 0.5rem));
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .page-header__metrics-track {
                animation: none;
            }
        }
        @media (min-width: 992px) {
            .page-header__inner {
                grid-template-columns: minmax(0, 1.45fr) minmax(260px, 0.75fr);
                align-items: end;
            }
            .page-header--metric-carousel .page-header__inner {
                grid-template-columns: minmax(0, 1.45fr) minmax(320px, 0.75fr);
            }
            .page-header--metric-carousel .page-header__metrics-carousel {
                align-self: end;
            }
        }
        .landing-hero {
            position: relative;
            overflow: hidden;
            padding: 7rem 0 5rem;
            background:
                radial-gradient(circle at top left, rgba(251, 113, 133, 0.2), transparent 24%),
                radial-gradient(circle at right center, rgba(225, 29, 72, 0.22), transparent 28%),
                linear-gradient(135deg, #2a0614 0%, #4a0f23 58%, #9f1239 100%);
        }
        .landing-hero.main-slider {
            margin-top: 0;
        }
        .landing-hero .main-slider__sub-title-box {
            justify-content: flex-start;
            margin: 0 0 1.15rem;
        }
        .landing-hero .main-slider__sub-title {
            color: #ffe4ec;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .landing-hero .main-slider__sub-title-shape {
            background-color: #fb7185;
        }
        .landing-hero::before {
            content: "";
            position: absolute;
            inset: auto auto -10rem -8rem;
            width: 20rem;
            height: 20rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.22) 0%, transparent 70%);
            pointer-events: none;
        }
        .landing-hero__image {
            position: absolute;
            inset: 0;
            background-position: center;
            background-size: cover;
            opacity: var(--hero-image-opacity, 0.42);
            transform: scale(1.01);
        }
        .landing-hero__image::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(42, 6, 20, var(--hero-overlay-dark, 0.72)) 0%, rgba(74, 15, 35, var(--hero-overlay-mid, 0.54)) 48%, rgba(159, 18, 57, var(--hero-overlay-soft, 0.32)) 100%),
                linear-gradient(180deg, rgba(42, 6, 20, var(--hero-overlay-soft, 0.32)) 0%, rgba(42, 6, 20, var(--hero-overlay-dark, 0.72)) 100%);
        }
        .landing-hero__inner {
            position: relative;
            z-index: 1;
        }
        .landing-hero__inner--solo {
            max-width: 820px;
        }
        .landing-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #fff1f5;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }
        .landing-hero__eyebrow::before {
            content: "";
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 999px;
            background: #e11d48;
            box-shadow: 0 0 0 6px rgba(225, 29, 72, 0.12);
        }
        .landing-hero__title {
            margin: 1.25rem 0 0;
            max-width: 12.5ch;
            color: #fff;
            font-size: clamp(3rem, 6vw, 5.8rem);
            line-height: 0.95;
            letter-spacing: 0;
        }
        .landing-hero__title span {
            color: #e11d48;
        }
        .landing-hero__text {
            max-width: 38rem;
            margin: 1.1rem 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 1.05rem;
        }
        .landing-hero__actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }
        .landing-hero__panel,
        .info-panel,
        .feature-card,
        .article-card,
        .tracker-card,
        .forum-card,
        .cta-panel {
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.08);
        }
        .landing-hero__panel,
        .info-panel,
        .feature-card,
        .article-card,
        .tracker-card,
        .forum-card,
        .cta-panel {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), #fff7fa);
        }
        .landing-hero__panel {
            padding: 1.25rem;
        }
        .landing-hero__panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .landing-hero__panel-header strong {
            font-size: 1rem;
            color: #9f1239;
        }
        .landing-hero__panel-header span {
            color: #64748b;
            font-size: 0.9rem;
        }
        .landing-hero__stat-grid {
            display: grid;
            gap: 0.9rem;
        }
        .landing-hero__stat {
            padding: 1rem 1.05rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #fff1f5 0%, #fff 100%);
            border: 1px solid rgba(159, 18, 57, 0.08);
        }
        .landing-hero__stat span {
            display: block;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }
        .landing-hero__stat strong {
            display: block;
            margin-top: 0.35rem;
            color: #9f1239;
            font-size: 1.25rem;
        }
        .section-shell {
            padding: 4.5rem 0;
        }
        .section-shell--compact {
            padding: 3rem 0;
        }
        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .section-heading__title {
            margin: 0;
            color: #9f1239;
            font-size: clamp(1.9rem, 3vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
        }
        .section-heading__text {
            max-width: 44rem;
            margin: 0;
            color: #64748b;
        }
        .feature-card {
            position: relative;
            overflow: hidden;
            padding: 1.4rem;
            height: 100%;
            border: 1px solid rgba(159, 18, 57, 0.08);
        }
        .feature-card::before {
            content: "";
            position: absolute;
            inset: auto -4rem -4rem auto;
            width: 10rem;
            height: 10rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.14) 0%, transparent 68%);
            pointer-events: none;
        }
        .feature-card__icon {
            display: inline-grid;
            place-items: center;
            width: 3.6rem;
            height: 3.6rem;
            border-radius: 1rem;
            color: #fff;
            background: linear-gradient(135deg, #9f1239, #e11d48);
            box-shadow: 0 18px 40px -24px rgba(159, 18, 57, 0.9);
        }
        .feature-card__icon i,
        .feature-card__icon span {
            font-size: 1.1rem;
        }
        .feature-card__title {
            margin: 1rem 0 0.55rem;
            color: #9f1239;
            font-size: 1.28rem;
        }
        .feature-card__text {
            margin: 0 0 1rem;
            color: #64748b;
        }
        .feature-card__link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: #9f1239;
            font-weight: 700;
        }
        .feature-card__link:hover {
            color: #e11d48;
        }
        .info-panel {
            padding: 1.5rem;
            border: 1px solid rgba(159, 18, 57, 0.08);
        }
        .info-panel__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: #e11d48;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }
        .info-panel__eyebrow::before {
            content: "";
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 999px;
            background: #9f1239;
        }
        .info-panel__title {
            margin: 0.85rem 0 0;
            color: #9f1239;
            font-size: clamp(1.7rem, 3vw, 2.6rem);
            line-height: 1.02;
        }
        .info-panel__text {
            margin: 0.85rem 0 0;
            color: #64748b;
        }
        .info-panel__list {
            margin: 1.25rem 0 0;
            padding: 0;
            display: grid;
            gap: 0.9rem;
            list-style: none;
        }
        .info-panel__list li {
            display: flex;
            gap: 0.85rem;
            align-items: flex-start;
        }
        .info-panel__list .icon {
            display: inline-grid;
            place-items: center;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: rgba(225, 29, 72, 0.12);
            color: #9f1239;
            flex: 0 0 auto;
        }
        .info-panel__list strong {
            display: block;
            color: #9f1239;
        }
        .info-panel__list p {
            margin: 0.15rem 0 0;
            color: #64748b;
            font-size: 0.95rem;
        }
        .stats-band {
            background: linear-gradient(135deg, #9f1239 0%, #4a0f23 100%);
            color: #fff;
        }
        .site-footer-two,
        .site-footer-three,
        .site-footer-two__top,
        .site-footer-two__bottom {
            background: #2a0614;
        }
        .site-footer-two__content-and-social-box {
            background: linear-gradient(135deg, #9f1239 0%, #4a0f23 100%);
        }
        .site-footer-three {
            margin-top: 0;
        }
        .site-footer-two__content-and-social-box {
            padding: 2rem 1.25rem 2.25rem;
            border-radius: 8px;
        }
        .site-footer-two__content-shape-1,
        .site-footer-two__content-img,
        .site-footer-two__shape-1,
        .site-footer-two__bg {
            display: none;
        }
        .site-footer-two__content-title {
            margin: 0;
            font-size: clamp(1.45rem, 2.4vw, 2.1rem);
            line-height: 1.15;
            letter-spacing: 0;
        }
        .site-footer-two__content-text {
            max-width: 620px;
            margin: 0.55rem auto 1rem;
            line-height: 1.55;
        }
        .site-footer-three .site-footer-two__top {
            margin-top: -1.4rem;
        }
        .site-footer-three .site-footer-two__top-inner {
            padding: 3.5rem 0 2rem;
        }
        .footer-widget-two__about-logo {
            margin-bottom: 0.75rem;
        }
        .footer-widget-two__about-text {
            margin-bottom: 0;
            line-height: 1.55;
        }
        .footer-widget-two__title {
            margin-bottom: 0.85rem;
        }
        .footer-widget-two__services-list li+li,
        .footer-widget-two__contact-list li+li {
            margin-top: 0.45rem;
        }
        .site-footer-two__bottom-inner {
            padding: 1rem 0;
        }
        .site-footer-two__content-title,
        .site-footer-two__content-text,
        .footer-widget-two__title,
        .footer-widget-two__about-text,
        .footer-widget-two__services-list li a,
        .footer-widget-two__contact-list li p,
        .footer-widget-two__contact-list li p a,
        .site-footer-two__copyright-text,
        .site-footer-two__bottom-menu li a {
            color: rgba(255, 255, 255, 0.84);
        }
        .stats-band .section-heading__title,
        .stats-band .section-heading__text {
            color: #fff;
        }
        .stats-band .section-heading__text {
            opacity: 0.82;
        }
        .stat-card {
            padding: 1.25rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
        }
        .stat-card strong {
            display: block;
            font-size: 2rem;
            line-height: 1;
        }
        .stat-card span {
            display: block;
            margin-top: 0.4rem;
            color: rgba(255, 255, 255, 0.78);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }
        .stat-card p {
            margin: 0.55rem 0 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }
        .article-card,
        .forum-card,
        .tracker-card {
            padding: 1.3rem;
            border: 1px solid rgba(159, 18, 57, 0.08);
        }
        .article-card__meta,
        .forum-card__meta,
        .tracker-card__meta {
            display: flex;
            gap: 0.55rem;
            flex-wrap: wrap;
        }
        .article-card__title,
        .forum-card__title,
        .tracker-card__title {
            margin: 1rem 0 0.5rem;
            color: #9f1239;
            font-size: 1.2rem;
            line-height: 1.15;
        }
        .article-card__text,
        .forum-card__text,
        .tracker-card__text {
            margin: 0;
            color: #64748b;
        }
        .article-card__footer,
        .forum-card__footer,
        .tracker-card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        .cta-panel {
            position: relative;
            overflow: hidden;
            padding: 1.6rem;
            background: linear-gradient(135deg, #fff1f5 0%, #fff 100%);
            border: 1px solid rgba(159, 18, 57, 0.08);
        }
        .cta-panel::after {
            content: "";
            position: absolute;
            inset: auto -5rem -5rem auto;
            width: 12rem;
            height: 12rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.18) 0%, transparent 68%);
            pointer-events: none;
        }
        .card-tile {
            display: grid;
            gap: 1rem;
        }
        .care-surface {
            display: grid;
            gap: 1rem;
        }
        .care-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid rgba(159, 18, 57, 0.1);
            border-radius: 12px;
            background: linear-gradient(135deg, #fff 0%, #fff7fa 100%);
            color: inherit;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }
        .care-card:hover {
            color: inherit;
            border-color: rgba(225, 29, 72, 0.28);
            box-shadow: 0 16px 34px rgba(159, 18, 57, 0.1);
            transform: translateY(-1px);
        }
        .care-card__icon {
            display: inline-grid;
            place-items: center;
            width: 2.55rem;
            height: 2.55rem;
            flex: 0 0 auto;
            border-radius: 10px;
            background: #ffe4ec;
            color: #9f1239;
        }
        .care-card__body {
            min-width: 0;
            flex: 1;
        }
        .care-card__body strong,
        .care-card__body span {
            display: block;
        }
        .care-card__body span {
            margin-top: 0.12rem;
            color: #7f4a5d;
            font-size: 0.9rem;
        }
        .care-stat {
            position: relative;
            overflow: hidden;
        }
        .care-stat::after {
            content: "";
            position: absolute;
            inset: auto -2.8rem -3.2rem auto;
            width: 7rem;
            height: 7rem;
            border-radius: 50%;
            background: rgba(225, 29, 72, 0.08);
        }
        .status-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.42rem 0.7rem;
            background: #ffe4ec;
            color: #9f1239;
            font-size: 0.78rem;
            font-weight: 800;
            line-height: 1;
            text-transform: capitalize;
        }
        .content-list {
            display: grid;
            gap: 0.85rem;
        }
        .content-list__item {
            display: block;
            padding: 1rem;
            border: 1px solid rgba(159, 18, 57, 0.1);
            border-radius: 12px;
            background: #fff;
            color: inherit;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }
        .content-list__item:hover {
            color: inherit;
            border-color: rgba(225, 29, 72, 0.25);
            box-shadow: 0 16px 34px rgba(159, 18, 57, 0.1);
            transform: translateY(-1px);
        }
        .library-section {
            background:
                linear-gradient(180deg, rgba(255, 247, 250, 0.7), #fff 34%),
                #fff;
        }
        .library-layout {
            display: grid;
            gap: 1.5rem;
            align-items: start;
        }
        .library-rail {
            display: grid;
            gap: 1rem;
        }
        .library-search,
        .library-filter,
        .library-help,
        .library-lead,
        .library-row,
        .library-empty {
            border: 1px solid rgba(159, 18, 57, 0.1);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 16px 42px rgba(159, 18, 57, 0.07);
        }
        .library-search {
            padding: 1rem;
        }
        .library-search label,
        .library-filter__heading span,
        .library-meta span {
            color: #9f1239;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
        .library-search__field {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-top: 0.75rem;
            padding: 0.8rem 0.9rem;
            border-radius: 8px;
            background: #fff7fa;
            border: 1px solid rgba(159, 18, 57, 0.12);
        }
        .library-search__field input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #2a0614;
        }
        .library-filter {
            padding: 0.75rem;
        }
        .library-filter__heading,
        .library-topic {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .library-filter__heading {
            padding: 0.35rem 0.35rem 0.7rem;
        }
        .library-filter__heading strong,
        .library-topic strong {
            color: #9f1239;
        }
        .library-topic {
            padding: 0.75rem;
            border-radius: 8px;
            color: #5f0f2f;
            font-weight: 750;
            transition: background 0.18s ease, color 0.18s ease;
        }
        .library-topic:hover,
        .library-topic.active {
            color: #9f1239;
            background: #fff1f5;
        }
        .library-help {
            padding: 1rem;
        }
        .library-help p {
            margin: 0.8rem 0;
            color: #64748b;
        }
        .library-help a,
        .library-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: #9f1239;
            font-weight: 800;
        }
        .library-main {
            min-width: 0;
        }
        .library-results-note {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(159, 18, 57, 0.1);
            border-radius: 8px;
            background: #fff7fa;
            color: #5f0f2f;
        }
        .library-results-note a {
            color: #9f1239;
            font-weight: 800;
        }
        .library-lead {
            position: relative;
            overflow: hidden;
            padding: clamp(1.35rem, 3vw, 2.1rem);
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(255, 241, 245, 0.94)),
                radial-gradient(circle at top right, rgba(225, 29, 72, 0.16), transparent 32%);
        }
        .library-lead::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            background: linear-gradient(180deg, #9f1239, #fb7185);
        }
        .library-lead__content {
            max-width: 780px;
        }
        .library-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }
        .library-meta span {
            letter-spacing: 0.1em;
        }
        .library-lead h2 {
            margin: 0.8rem 0 0;
            max-width: 18ch;
            color: #9f1239;
            font-size: clamp(2rem, 4vw, 3.8rem);
            line-height: 1;
            letter-spacing: 0;
        }
        .library-lead p {
            max-width: 680px;
            margin: 1rem 0 1.2rem;
            color: #475569;
            font-size: 1.05rem;
            line-height: 1.7;
        }
        .library-list {
            display: grid;
            gap: 0;
            margin-top: 1rem;
        }
        .library-row {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            border-radius: 0;
            box-shadow: none;
            border-width: 0 0 1px;
            background: #fff;
        }
        .library-row:first-child {
            border-radius: 8px 8px 0 0;
            border-top-width: 1px;
        }
        .library-row:last-child {
            border-radius: 0 0 8px 8px;
        }
        .library-row__date {
            display: grid;
            place-items: center;
            width: 4rem;
            aspect-ratio: 1;
            border-radius: 8px;
            background: #fff1f5;
            color: #9f1239;
        }
        .library-row__date strong {
            display: block;
            font-size: 1.15rem;
            line-height: 1;
        }
        .library-row__date span {
            margin-top: -0.7rem;
            font-size: 0.76rem;
            font-weight: 800;
            text-transform: uppercase;
        }
        .library-row h3 {
            margin: 0.45rem 0 0.35rem;
            color: #5f0f2f;
            font-size: 1.18rem;
            line-height: 1.2;
        }
        .library-row p {
            margin: 0;
            color: #64748b;
            line-height: 1.55;
        }
        .library-row__action {
            display: inline-grid;
            place-items: center;
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 50%;
            background: #fff1f5;
            color: #9f1239;
            transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }
        .library-row:hover .library-row__action {
            background: #9f1239;
            color: #fff;
            transform: translateX(2px);
        }
        .library-empty {
            padding: clamp(1.5rem, 4vw, 3rem);
        }
        .library-empty h2 {
            margin: 1rem 0 0;
            color: #9f1239;
        }
        .library-empty p {
            max-width: 520px;
            margin: 0.8rem 0 1.25rem;
            color: #64748b;
        }
        .article-reader-section {
            background: linear-gradient(180deg, #fff7fa 0%, #fff 18rem);
        }
        .article-reader-layout {
            display: grid;
            gap: 2rem;
            align-items: start;
        }
        .article-reader {
            max-width: 780px;
            color: #253044;
        }
        .article-reader__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            padding-bottom: 1.15rem;
            border-bottom: 1px solid rgba(159, 18, 57, 0.14);
        }
        .article-reader__meta span,
        .article-reader-rail__block span,
        .article-next span {
            color: #9f1239;
            font-size: 0.74rem;
            font-weight: 850;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
        .article-reader__intro {
            margin: 1.5rem 0 2rem;
            padding-left: 1.2rem;
            border-left: 4px solid #e11d48;
        }
        .article-reader__intro p {
            margin: 0;
            color: #5f0f2f;
            font-size: clamp(1.2rem, 2vw, 1.5rem);
            line-height: 1.55;
            font-weight: 700;
        }
        .article-reader__body {
            font-size: 1.08rem;
            line-height: 1.9;
        }
        .article-reader__body p {
            margin: 0 0 1.35rem;
        }
        .article-reader__body p:first-child::first-letter {
            color: #9f1239;
            float: left;
            font-size: 3.7rem;
            line-height: 0.86;
            padding: 0.2rem 0.45rem 0 0;
            font-weight: 850;
        }
        .article-reader-rail {
            display: grid;
            gap: 1rem;
        }
        .article-reader-rail__block {
            padding: 1rem 0 1.15rem;
            border-bottom: 1px solid rgba(159, 18, 57, 0.14);
        }
        .article-reader-rail__block p {
            margin: 0.65rem 0 0;
            color: #64748b;
            line-height: 1.65;
        }
        .article-reader-actions {
            display: grid;
            border-block: 1px solid rgba(159, 18, 57, 0.14);
        }
        .article-reader-actions a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.95rem 0;
            color: #5f0f2f;
            font-weight: 800;
            border-bottom: 1px solid rgba(159, 18, 57, 0.1);
        }
        .article-reader-actions a:last-child {
            border-bottom: 0;
        }
        .article-reader-actions a:hover {
            color: #9f1239;
        }
        .article-next-section {
            padding: 0 0 4.5rem;
            background: #fff;
        }
        .article-next {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(159, 18, 57, 0.14);
        }
        .article-next h2 {
            max-width: 18ch;
            margin: 0.6rem 0 0;
            color: #9f1239;
            font-size: clamp(1.65rem, 3vw, 2.65rem);
            line-height: 1.04;
        }
        .article-next__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: flex-end;
        }
        .soft-divider {
            border-color: rgba(159, 18, 57, 0.1) !important;
        }
        .card-tile.cols-2,
        .card-tile.cols-3,
        .card-tile.cols-4 {
            grid-template-columns: minmax(0, 1fr);
        }
        @media (min-width: 768px) {
            .card-tile.cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .card-tile.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .card-tile.cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .page-header__metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (min-width: 992px) {
            .landing-hero__inner {
                display: grid;
                grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
                gap: 1.5rem;
                align-items: center;
            }
            .landing-hero__inner--solo {
                display: block;
            }
            .page-header__metrics {
                grid-template-columns: 1fr;
            }
            .library-layout {
                grid-template-columns: minmax(240px, 300px) minmax(0, 1fr);
            }
            .library-rail {
                position: sticky;
                top: 110px;
            }
            .article-reader-layout {
                grid-template-columns: minmax(0, 1fr) minmax(230px, 310px);
            }
            .article-reader-rail {
                position: sticky;
                top: 110px;
            }
        }
        .stack-grid {
            display: grid;
            gap: 1.25rem;
        }
        @media (min-width: 992px) {
            .stack-grid.cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .stack-grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .stack-grid.cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
    </style>
    @stack('head')
</head>
<body class="custom-cursor helpest-dark">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="loader js-preloader"><div></div><div></div><div></div></div>

    <div class="page-wrapper">
        <header class="main-header-three">
            <div class="main-menu-three__top">
                <div class="main-menu-three__top-inner">
                    <ul class="list-unstyled main-menu-three__contact-list">
                        <li>
                            <div class="icon"><i class="icon-email"></i></div>
                            <div class="text"><p><a href="mailto:amara@health.test">amara@health.test</a></p></div>
                        </li>
                        <li>
                            <div class="icon"><i class="icon-pin"></i></div>
                            <div class="text"><p>University of Ghana, Legon</p></div>
                        </li>
                    </ul>
                    <div class="main-menu-three__top-right">
                        <ul class="list-unstyled main-menu-three__top-menu">
                            <li>
                                <a href="https://www.ug.edu.gh" class="thm-btn thm-btn--sm is-secondary" style="background:#BE123C;color:#fff;border-color:#BE123C;" onclick="window.location.replace(this.href); return false;">
                                    <span class="thm-btn-text">Exit</span>
                                </a>
                            </li>
                            @guest
                                <li><a href="{{ route('login') }}" class="thm-btn thm-btn--sm"><span class="thm-btn-text">Login</span></a></li>
                                <li><a href="{{ route('register') }}" class="thm-btn thm-btn--sm is-secondary"><span class="thm-btn-text">Register</span></a></li>
                            @endguest
                            @auth
                                @php
                                    $navNotifications = auth()->user()->notifications()->latest()->limit(8)->get();
                                    $navUnreadCount = auth()->user()->notifications()->where('read', false)->count();
                                @endphp
                                <li class="dropdown">
                                    <button class="thm-btn thm-btn--sm is-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="thm-btn-text">
                                            <i class="fas fa-bell"></i>
                                            @if ($navUnreadCount > 0)
                                                {{ $navUnreadCount }}
                                            @endif
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 320px;">
                                        <div class="px-3 py-2 fw-bold border-bottom d-flex justify-content-between align-items-center">
                                            <span>Notifications</span>
                                            @if ($navUnreadCount > 0)
                                                <span class="badge rounded-pill text-bg-warning">{{ $navUnreadCount }}</span>
                                            @endif
                                        </div>
                                        @forelse ($navNotifications as $notification)
                                            <a class="dropdown-item py-2 {{ $notification->read ? '' : 'fw-semibold' }}" href="{{ route('notifications.open', $notification) }}">
                                                <span class="d-block">{{ $notification->title() }}</span>
                                                <span class="d-block text-muted small">{{ $notification->displayMessage() }}</span>
                                                <span class="d-block text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
                                            </a>
                                        @empty
                                            <span class="dropdown-item text-muted py-3">No notifications yet.</span>
                                        @endforelse
                                        @if ($navUnreadCount > 0)
                                            <div class="dropdown-divider my-0"></div>
                                            <form method="post" action="{{ route('notifications.mark-all-read') }}">
                                                @csrf
                                                <button class="dropdown-item text-center py-2" type="submit">Mark all as read</button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                                <li><a href="{{ route('profile.edit') }}" class="thm-btn thm-btn--sm is-secondary"><span class="thm-btn-text">Profile</span></a></li>
                                <li><a href="{{ route('dashboard') }}" class="thm-btn thm-btn--sm"><span class="thm-btn-text">Dashboard</span></a></li>
                                <li>
                                    <form method="post" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="thm-btn thm-btn--sm is-secondary">
                                            <span class="thm-btn-text">Logout</span>
                                        </button>
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
            <nav class="main-menu main-menu-three">
                <div class="main-menu-three__wrapper">
                    <div class="main-menu-three__wrapper-inner">
                        <div class="main-menu-three__left">
                            <div class="main-menu-three__logo">
                                <a href="{{ route('home') }}">
                                    <img class="ug-logo" src="{{ asset('themes/adminhmd/assets/images/brand/university-of-ghana-logo.svg') }}" alt="University of Ghana">
                                </a>
                            </div>
                        </div>
                        <div class="main-menu-three__main-menu-box">
                            <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                            <ul class="main-menu__list">
                                <li class="{{ request()->routeIs('home') ? 'current' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                                <li class="{{ request()->routeIs('articles.*') ? 'current' : '' }}"><a href="{{ route('articles.index') }}">Library</a></li>
                                <li class="{{ request()->routeIs('tracker.*') ? 'current' : '' }}"><a href="{{ route('tracker.index') }}">Tracker</a></li>
                                <li class="{{ request()->routeIs('forum.*') ? 'current' : '' }}"><a href="{{ route('forum.index') }}">Forum</a></li>
                                <li class="{{ request()->routeIs('resources.*') ? 'current' : '' }}"><a href="{{ route('resources.index') }}">Resources</a></li>
                                @auth
                                    <li class="{{ request()->routeIs('consultations.*') ? 'current' : '' }}"><a href="{{ route('consultations.index') }}">Consultations</a></li>
                                @endauth
                            </ul>
                        </div>
                        <div class="main-menu-three__right">
                            <div class="main-menu-three__btn-box">
                                <a href="{{ auth()->check() ? route('consultations.create') : route('register') }}" class="thm-btn">
                                    <span class="thm-btn-text">{{ auth()->check() ? 'New Request' : 'Join Now' }}</span>
                                    <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="app-page-shell">
            @if (session('status'))
                <div class="container mt-4">
                    <div class="alert-accent">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="container mt-4">
                    <div class="alert-accent">
                        <strong>Please fix the highlighted fields.</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="site-footer-two site-footer-three">
            <div class="container">
                <div class="site-footer-two__content-and-social-box">
                    <div class="site-footer-two__content-shape-1">
                        <img src="{{ asset('themes/helpest/assets/images/shapes/site-footer-two-content-shape-1.png') }}" alt="">
                    </div>
                    <div class="site-footer-two__content-img">
                        <img src="{{ asset('themes/helpest/assets/images/resources/site-footer-two-content-img.jpg') }}" alt="">
                    </div>
                    <h3 class="site-footer-two__content-title">Private support for <span>students</span> who need clarity</h3>
                    <p class="site-footer-two__content-text">Use the library, tracker, forum, and consultation tools to prepare for care in a private, calm way.</p>
                    <div class="donate-two__btn-box">
                        <a href="{{ auth()->check() ? route('consultations.create') : route('register') }}" class="thm-btn">
                            <span class="thm-btn-text">{{ auth()->check() ? 'Start Consultation' : 'Create Account' }}</span>
                            <span class="thm-btn-icon-box"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="site-footer-two__top">
                <div class="site-footer-two__bg" style="background-image: url({{ asset('themes/helpest/assets/images/backgrounds/site-footer-two-bg.jpg') }});"></div>
                <div class="site-footer-two__shape-1 float-bob-y">
                    <img src="{{ asset('themes/helpest/assets/images/shapes/site-footer-two-shape-1.png') }}" alt="">
                </div>
                <div class="container">
                    <div class="site-footer-two__top-inner">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                                <div class="footer-widget-two__about">
                                    <div class="footer-widget-two__about-logo">
                                        <a href="{{ route('home') }}"><img class="ug-logo" src="{{ asset('themes/adminhmd/assets/images/brand/university-of-ghana-logo.svg') }}" alt="University of Ghana"></a>
                                    </div>
                                    <p class="footer-widget-two__about-text">Amara Health connects female tertiary students to private information, preparation guidance, and local support.</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                                <div class="footer-widget-two__services">
                                    <h4 class="footer-widget-two__title">Tools</h4>
                                    <ul class="footer-widget-two__services-list list-unstyled">
                                        <li><a href="{{ route('articles.index') }}">Health library</a></li>
                                        <li><a href="{{ route('tracker.index') }}">Cycle tracker</a></li>
                                        <li><a href="{{ route('forum.index') }}">Anonymous forum</a></li>
                                        <li><a href="{{ route('resources.index') }}">Local resources</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                                <div class="footer-widget-two__links">
                                    <h4 class="footer-widget-two__title">Account</h4>
                                    <ul class="footer-widget-two__services-list list-unstyled">
                                        @guest
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                            <li><a href="{{ route('register') }}">Register</a></li>
                                        @endguest
                                        @auth
                                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li><a href="{{ route('consultations.index') }}">Consultations</a></li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                                <div class="footer-widget-two__contact">
                                    <h3 class="footer-widget-two__title">Contact Info</h3>
                                    <ul class="footer-widget-two__contact-list list-unstyled">
                                        <li>
                                            <div class="icon"><span class="icon-call"></span></div>
                                            <p><a href="tel:+233000000000">+233 000 000 000</a></p>
                                        </li>
                                        <li>
                                            <div class="icon"><span class="icon-email"></span></div>
                                            <p><a href="mailto:amara@health.test">amara@health.test</a></p>
                                        </li>
                                        <li>
                                            <div class="icon"><span class="icon-pin"></span></div>
                                            <p>University of Ghana<br>Legon, Accra</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="site-footer-two__bottom">
                    <div class="container">
                        <div class="site-footer-two__bottom-inner">
                            <div class="site-footer-two__copyright">
                                <p class="site-footer-two__copyright-text">Amara Health. Built for private student care.</p>
                            </div>
                            <div class="site-footer-two__bottom-menu-box">
                                <ul class="list-unstyled site-footer-two__bottom-menu">
                                    <li class="{{ request()->routeIs('home') ? 'current' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="{{ request()->routeIs('articles.*') ? 'current' : '' }}"><a href="{{ route('articles.index') }}">Library</a></li>
                                    <li class="{{ request()->routeIs('resources.*') ? 'current' : '' }}"><a href="{{ route('resources.index') }}">Resources</a></li>
                                    <li class="{{ request()->routeIs('forum.*') ? 'current' : '' }}"><a href="{{ route('forum.index') }}">Forum</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>
            <div class="logo-box">
                <a href="{{ route('home') }}" aria-label="University of Ghana logo"><img class="ug-logo" src="{{ asset('themes/adminhmd/assets/images/brand/university-of-ghana-logo.svg') }}" alt="University of Ghana"></a>
            </div>
            <div class="mobile-nav__container"></div>
            <ul class="mobile-nav__contact list-unstyled">
                <li><i class="fa fa-envelope"></i><a href="mailto:amara@health.test">amara@health.test</a></li>
                <li><i class="fas fa-phone"></i><a href="tel:+233000000000">+233 000 000 000</a></li>
            </ul>
        </div>
    </div>

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> Go Back Top</span>
    </a>

    <script src="{{ asset('themes/helpest/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/wNumb.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/wow.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/marquee.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/countdown.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/jquery-sidebar-content.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/aos.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/vegas.min.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/gsap/SplitText.js') }}"></script>
    <script src="{{ asset('themes/helpest/assets/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
