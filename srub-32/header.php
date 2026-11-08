<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="geo.region" content="RU-VLA">
    <meta name="geo.placename" content="Vladimir">
    
    <meta name="google-site-verification" content="FK4EWQnBvH3S-OGaR0HXYvQ5Zw7UgqjfUmIgyYg_1Vs" />

    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">


    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Сруб-Владимир",
        "url": "https://srub-vladimir.ru",
        "logo": "<?php echo get_template_directory_uri(); ?>/img/logo.png",
        "image": "https://srub-vladimir.ru/wp-content/themes/srub-3/img/types/rubl-planed.jpg",
        "description": "Строительство деревянных домов из бревна ручной рубки во Владимире и Владимирской области с 1999 года. Срубы под ключ, гарантия по договору.",
        "telephone": "+7-910-77-88-999",
        "email": "srub.vladim@gmail.com",
        "foundingDate": "1999",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Владимир",
            "addressRegion": "Владимирская область",
            "addressCountry": "RU"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 56.1290,
            "longitude": 40.4066
        },
        "areaServed": [
            "Владимир",
            "Владимирская область",
            "Ковров",
            "Суздаль",
            "Муром",
            "Рязанская область",
            "Московская область",
            "Нижегородская область"
        ],
        "sameAs": [
            "https://t.me/doma_iz_brevna_vo_vladimire",
            "https://www.instagram.com/sruby_vladimir"
        ]
        }
        </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="container header__inner">
        <!-- 1. Логотип (Слева) -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Сруб-Владимир - строительство деревянных домов">
        </a>
        
        <!-- Телефон только в мобильной шапке (справа) -->
        <a href="tel:+79107788999" class="header__phone-mobile">
            +7 (910) 77-88-999
        </a>

        <button id="nav-toggle" class="burger" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="nav" id="nav-menu">
            <?php
            $current_page_id = get_queried_object_id();
            
            function is_menu_active($page_id) {
                global $post;
                if (!$post) return false;
                return is_page($page_id) || (is_singular() && $post->post_parent == $page_id);
            }
            ?>
            
            <!-- УДАЛЕНА ССЫЛКА С ТЕЛЕФОНОМ ДЛЯ ДЕСКТОПА (nav__link--desktop-only) -->

            <!-- Услуги с выпадающим меню -->
            <div class="nav-item nav-item--dropdown">
                <a href="<?php echo esc_url(get_permalink(67)); ?>" class="nav__link <?php echo is_menu_active(67) ? 'nav__link--active' : ''; ?>">
                    Услуги
                    <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo esc_url(get_permalink(359)); ?>">Дома под рубанок</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(357)); ?>">Дикая рубка</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(369)); ?>">Кровельные работы</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(365)); ?>">Монтаж фундамента</a></li>
                </ul>
            </div>

            <!-- Проекты с выпадающим меню -->
            <div class="nav-item nav-item--dropdown">
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="nav__link <?php echo is_menu_active(64) ? 'nav__link--active' : ''; ?>">
                    Наши объекты
                    <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <ul class="dropdown-menu dropdown-menu--wide">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy'   => 'project_category',
                        'hide_empty' => true,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ));
                    
                    if (!is_wp_error($categories) && !empty($categories)) :
                        foreach ($categories as $cat) :
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink(64)); ?>?filter=<?php echo esc_attr($cat->slug); ?>">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                        </li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            <a href="<?php echo esc_url(get_permalink(391)); ?>" class="nav__link">Галерея</a>
            <a href="<?php echo esc_url(get_permalink(47)); ?>" class="nav__link <?php echo is_menu_active(47) ? 'nav__link--active' : ''; ?>">О нас</a>
            <a href="<?php echo esc_url(get_permalink(47)); ?>#reviews" class="nav__link">Отзывы</a>
            <a href="<?php echo esc_url(get_permalink(374)); ?>" class="nav__link">Контакты</a>
        </nav>
    </div>
</header>