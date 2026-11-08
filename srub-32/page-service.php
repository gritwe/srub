<?php
/*
 * Template Name: Страница услуги номеры
 */
get_header();

$project_category = get_post_meta(get_the_ID(), '_service_project_category', true);
$faq_items        = get_post_meta(get_the_ID(), '_service_faq', true);
if (!is_array($faq_items)) $faq_items = [];

// Запрос проектов по категории
$project_args = [
    'post_type'      => 'project',
    'posts_per_page' => 7,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
];
if ($project_category) {
    $project_args['tax_query'] = [[
        'taxonomy' => 'project_category',
        'field'    => 'slug',
        'terms'    => $project_category,
    ]];
}
$projects_query = new WP_Query($project_args);
?>

<main id="main-content" role="main" class="service-page">

        <!-- HERO / ОПИСАНИЕ -->
    <section class="service-hero">
        <div class="container">
            <div class="breadcrumb service-hero__breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
                <span>/</span>
                <a href="<?php echo esc_url(get_permalink(67)); ?>">Услуги</a>
                <span>/</span>
                <span><?php the_title(); ?></span>
            </div>

            <div class="service-hero__inner">
                <!-- H1 на всю ширину -->
                <h1 class="service-hero__title"><?php the_title(); ?></h1>
                
                <!-- Основная сетка: Слева текст, Справа Кнопка + Слайдер -->
                <div class="service-hero__grid">
                    
                    <!-- Левая колонка: Текст -->
                    <div class="service-hero__desc">
                        <?php the_content(); ?>
                    </div>

                    <!-- Правая колонка: Кнопка и Слайдер -->
                    <div class="service-hero__right-col">
                        
                        <!-- Кнопка (теперь она в правой колонке) -->
                        <div class="service-hero__action">
                            <button type="button" class="btn btn--primary service-hero__cta js-open-modal" data-project="<?php the_title_attribute(); ?>">
                                Получить смету бесплатно
                            </button>
                        </div>

                                                <!-- FADE СЛАЙДЕР ПОД КНОПКОЙ -->
                        <?php 
                        $current_page_id = get_the_ID();
                        $slider_images = [];
                        
                        // ЛОГИКА ВЫБОРА КАРТИНОК ПО ID СТРАНИЦЫ
                        if ($current_page_id == 357) { 
                            // === ДИКИЙ СТИЛЬ (ID 357) ===
                            $slider_images = [
                                'img/wild/slider1.jpg',
                                'img/wild/slider2.jpg',
                                'img/wild/slider3.jpg',
                                'img/wild/slider4.jpg',
                                'img/wild/slider5.jpg'
                            ];
                        } elseif ($current_page_id == 359) { 
                            // === ПОД РУБАНОК (ID 359) ===
                            $slider_images = [
                                'img/plane/slider1.jpg',
                                'img/plane/slider2.jpg',
                                'img/plane/slider3.jpg',
                                'img/plane/slider4.jpg'
                            ];
                        }
                        
                        // Выводим слайдер, только если массив картинок не пуст
                        if (!empty($slider_images)): 
                        ?>
                            <div class="hero-fade-slider">
                                <?php foreach ($slider_images as $index => $img_path): ?>
                                    <div class="fade-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/' . $img_path); ?>" 
                                             alt="Пример работы <?php echo $index + 1; ?>" 
                                             loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- СЛАЙДЕР ПРОЕКТОВ -->
    <?php if ($projects_query->have_posts()): ?>
    <section class="section projects-slider-section service-slider-section">
        <div class="container">
            <h2 class="section__title">Примеры наших работ</h2>

            <div class="projects-slider-outer service-slider-outer">
                
                <button class="ps-arrow ps-arrow--prev" type="button" aria-label="Назад">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="ps-arrow ps-arrow--next" type="button" aria-label="Вперёд">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                <div class="projects-slider-wrapper service-slider-wrapper">
                    <div class="projects-slider-track service-slider-track" id="serviceSliderTrack">
                        <?php while ($projects_query->have_posts()): $projects_query->the_post();
                            $price = get_post_meta(get_the_ID(), '_project_price', true);
                            $area  = get_post_meta(get_the_ID(), '_project_area',  true);
                            $price_fmt = '';
                            if ($price) {
                                $price_fmt = is_numeric($price)
                                    ? number_format((float)$price, 0, ' ', ' ') . ' ₽'
                                    : esc_html($price);
                            }
                            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                            if (!$thumb) $thumb = get_template_directory_uri() . '/img/placeholder.jpg';
                        ?>
                        <article class="ps-card service-slide-card">
                            <div class="ps-card__img-wrap">
                                <img src="<?php echo esc_url($thumb); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     width="400" height="300" loading="lazy">
                            </div>
                            <div class="ps-card__body">
                                <h3 class="ps-card__title"><?php the_title(); ?></h3>
                                <?php if ($area): ?>
                                    <p class="ps-card__area"><?php echo esc_html($area); ?> м²</p>
                                <?php endif; ?>
                                <p class="ps-card__desc"><?php echo wp_trim_words(get_the_excerpt(), 12, '...'); ?></p>
                                <?php if ($price_fmt): ?>
                                    <p class="ps-card__price"><?php echo $price_fmt; ?></p>
                                <?php endif; ?>
                                <div class="ps-card__actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn--outline">Подробнее</a>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>

            </div>

            <div class="ps-dots service-slider-dots" id="servicePsDots"></div>

            <div class="projects-slider-section__cta">
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--primary">
                    Смотреть все проекты →
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>


           <!-- БЛОК "СМОТРИТЕ ТАКЖЕ" СО СЛАЙДЕРАМИ -->
    <?php 
    $current_id = get_queried_object_id(); 
    
    // 1. НАСТРОЙКА: Связь ID страниц с путями к папкам с фото
    // Ключ массива = ID страницы, Значение = путь к папке относительно темы
    $service_folders = [
        357 => 'img/wild/',      // Дикая рубка
        359 => 'img/plane/',     // Под рубанок
        369 => 'img/roof/',      // Кровельные работы (проверьте название папки!)
        365 => 'img/fundament/'  // Монтаж фундамента (проверьте название папки!)
    ];

    // 2. Получаем список ID для отображения (все, кроме текущего)
    $all_ids = array_keys($service_folders);
    $ids_to_show = array_diff($all_ids, [$current_id]);

    if (!empty($ids_to_show)): 
    ?>
    <section class="section also-viewed">
        <div class="container">
            <h2 class="section__title">Смотрите также</h2>
            
            <div class="also-viewed__grid">
                <?php 
                // Запрашиваем страницы в нужном порядке
                $other_services = new WP_Query([
                    'post_type'      => 'page',
                    'post_status'    => 'publish',
                    'post__in'       => $ids_to_show,
                    'orderby'        => 'post__in',
                    'posts_per_page' => -1
                ]);

                while ($other_services->have_posts()): $other_services->the_post(); 
                    $page_id = get_the_ID();
                    $folder_path = isset($service_folders[$page_id]) ? $service_folders[$page_id] : '';
                    
                    // Получаем список файлов из папки, если она указана
                    $slides = [];
                    if ($folder_path) {
                        $full_dir = get_template_directory() . '/' . $folder_path;
                        if (is_dir($full_dir)) {
                            $files = scandir($full_dir);
                            foreach ($files as $file) {
                              if ($file === '.' || $file === '..') continue;

                              // Проверяем расширение (регистронезависимо)
                              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                              $allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

                              if (in_array($ext, $allowed_ext)) {
                                  $slides[] = $folder_path . $file;
                              }
                            }
                            sort($slides); // Сортируем по имени файла
                        }
                    }
                ?>
                    <a href="<?php the_permalink(); ?>" class="also-card">
                        <div class="also-card__inner">
                            <h3 class="also-card__title"><?php the_title(); ?></h3>
                            <span class="also-card__arrow">→</span>
                        </div>

                        <!-- FADE СЛАЙДЕР ВНУТРИ КАРТОЧКИ -->
                        <?php if (!empty($slides)): ?>
                            <div class="also-card-slider fade-slider-mini" data-slider-id="<?php echo $page_id; ?>">
                                <?php foreach ($slides as $index => $img_url): ?>
                                    <div class="fade-slide-mini <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/' . $img_url); ?>" 
                                             alt="<?php the_title_attribute(); ?> - фото <?php echo $index + 1; ?>" 
                                             loading="lazy">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <!-- Заглушка, если нет фото -->
                            <div class="also-card-slider no-slides">
                                <span>Нет фото</span>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <section class="reliability-section">
              <h2 class="section-title">Надёжность заложена в каждом венце</h2>
      <div class="container-diag">
        <!-- Левая часть: Текст -->
        <div class="content-col">

          <!-- Пункт 1 -->
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24">
                <path
                  d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                />
              </svg>
            </div>
            <div class="feature-text">
              <h3>Простоит 100 лет</h3>
              <p>
                Хвойная древесина собственной заготовки. Антисептики и пропитки нового поколения.
                Опыт 20 лет подтверждает долговечность.
              </p>
            </div>
          </div>

          <!-- Пункт 2 -->
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24">
                <path
                  d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                />
              </svg>
            </div>
            <div class="feature-text">
              <h3>Гарантия по договору</h3>
              <p>
                Цена и сроки фиксируются в смете. Руководитель лично контролирует каждый этап.
                Еженедельные фотоотчёты о ходе строительства.
              </p>
            </div>
          </div>

          <!-- Пункт 3 -->
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24">
                <path
                  d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                />
              </svg>
            </div>
            <div class="feature-text">
              <h3>Польза для здоровья</h3>
              <p>
                Дерево регулирует влажность и выделяет фитонциды. Микроклимат в деревянном доме
                благоприятно влияет на самочувствие и сон.
              </p>
            </div>
          </div>

          <!-- Пункт 4 -->
          <div class="feature-item">
            <div class="feature-icon">
              <svg viewBox="0 0 24 24">
                <path
                  d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                />
              </svg>
            </div>
            <div class="feature-text">
              <h3>Бесплатный выезд</h3>
              <p>
                Приедем на участок, изучим рельеф и грунт, составим смету без скрытых затрат.
                Владимир и область — бесплатно.
              </p>
            </div>
          </div>
        </div>

        <!-- Правая часть: SVG Диаграмма -->
        <div class="visual-col">
          <!-- ВСТАВЛЕН ВАШ SVG КОД НИЖЕ -->
          <svg viewBox="0 0 600 520" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <radialGradient id="bark" cx="50%" cy="50%" r="50%">
                <stop offset="75%" stop-color="#3d1f08" />
                <stop offset="100%" stop-color="#1e0e04" />
              </radialGradient>
              <radialGradient id="wood" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#c8621a" />
                <stop offset="100%" stop-color="#a06020" />
              </radialGradient>
              <radialGradient id="core" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#7a2e08" />
                <stop offset="100%" stop-color="#a04818" />
              </radialGradient>
              <radialGradient id="pith" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#3a1206" />
                <stop offset="100%" stop-color="#5a2010" />
              </radialGradient>
              <style>
                .txt {
                  font-family:
                    Inter,
                    system-ui,
                    -apple-system,
                    Segoe UI,
                    Roboto,
                    Arial,
                    sans-serif;
                }
              </style>
            </defs>

            <!-- Title -->
            <text
              x="300"
              y="20"
              text-anchor="middle"
              class="txt"
              font-size="15"
              fill="#2c1a08"
              font-weight="600"
            >
              Поперечный срез венца
            </text>

            <!-- Bark -->
            <circle cx="300" cy="245" r="195" fill="url(#bark)" />
            <circle
              cx="300"
              cy="245"
              r="185"
              fill="none"
              stroke="#1a0804"
              stroke-width="1.5"
              opacity="0.6"
            />

            <!-- Cambium -->
            <circle cx="300" cy="245" r="172" fill="#5a3010" />

            <!-- Wood -->
            <circle cx="300" cy="245" r="168" fill="url(#wood)" />

            <!-- rings -->
            <circle
              cx="300"
              cy="245"
              r="150"
              fill="none"
              stroke="#8b4010"
              stroke-width="1.1"
              opacity="0.5"
            />
            <circle
              cx="300"
              cy="245"
              r="132"
              fill="none"
              stroke="#7a3808"
              stroke-width="1"
              opacity="0.45"
            />
            <circle
              cx="300"
              cy="245"
              r="114"
              fill="none"
              stroke="#8b4010"
              stroke-width="1"
              opacity="0.4"
            />
            <circle
              cx="300"
              cy="245"
              r="96"
              fill="none"
              stroke="#6a3008"
              stroke-width="0.9"
              opacity="0.4"
            />

            <!-- Core -->
            <circle cx="300" cy="245" r="62" fill="url(#core)" />
            <circle
              cx="300"
              cy="245"
              r="48"
              fill="none"
              stroke="#5a2008"
              stroke-width="1"
              opacity="0.5"
            />

            <!-- Pith -->
            <circle cx="300" cy="245" r="18" fill="url(#pith)" />

            <!-- Medullary rays -->
            <g opacity="0.18" stroke="#f0d090" stroke-width="0.6">
              <line x1="300" y1="245" x2="300" y2="70" />
              <line x1="300" y1="245" x2="430" y2="120" />
              <line x1="300" y1="245" x2="470" y2="280" />
              <line x1="300" y1="245" x2="380" y2="410" />
              <line x1="300" y1="245" x2="220" y2="410" />
              <line x1="300" y1="245" x2="130" y2="280" />
              <line x1="300" y1="245" x2="170" y2="120" />
            </g>

            <!-- Labels -->
            <g class="txt" font-size="12" fill="#2c1a08">
              <line
                x1="300"
                y1="230"
                x2="335"
                y2="45"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="340" y="45" text-anchor="middle">Сердцевина</text>

              <line
                x1="360"
                y1="240"
                x2="480"
                y2="140"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="450" y="138">Ядро</text>

              <line
                x1="460"
                y1="245"
                x2="510"
                y2="185"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="514" y="182">Заболонь</text>

              <line
                x1="470"
                y1="265"
                x2="520"
                y2="300"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="524" y="305">Камбий</text>

              <line
                x1="120"
                y1="220"
                x2="50"
                y2="200"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="10" y="198" font-size="11">Годичное кольцо</text>

              <line
                x1="190"
                y1="210"
                x2="95"
                y2="250"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="10" y="252" font-size="10">Сердцевинные лучи</text>

              <line
                x1="175"
                y1="370"
                x2="120"
                y2="425"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="30" y="435" font-size="11">Кора, лубяной слой</text>

              <line
                x1="395"
                y1="408"
                x2="430"
                y2="430"
                stroke="#5a3a1a"
                stroke-width="0.8"
                stroke-dasharray="4,2"
              />
              <text x="415" y="445" font-size="11">Кора, пробковый слой</text>
            </g>

            <!-- Diameter -->
            <line x1="105" y1="470" x2="495" y2="470" stroke="#5a3a1a" stroke-width="0.8" />
            <text x="300" y="490" text-anchor="middle" class="txt" font-size="11" fill="#2c1a08">
              Диаметр: 24–32 см
            </text>

            <!-- GOST -->
            <rect
              x="220"
              y="498"
              width="160"
              height="22"
              rx="11"
              ry="11"
              fill="#fff;"
              opacity="0.95"
            />
            <text
              x="300"
              y="513"
              text-anchor="middle"
              class="txt"
              font-size="10"
              fill="#fff"
              font-weight="600"
            >
              Хвоя ГОСТ 8486-86
            </text>
          </svg>
        </div>
      </div>
    </section>

<!-- СЕКЦИЯ: КОНТАКТЫ (Стиль как на главной - темный фон, в строку) -->
<section class="contact contact--services-style" id="contact">
    <div class="container contact__inner">
        <!-- Заголовок такой же, как на главной -->
        <h2 class="contact__title">Заинтересовала услуга?</h2>
        
        <div class="contact__body">
            <!-- Левая часть: Текст -->
            <div class="contact__text-block">
                <p class="contact__text">
                    Оставьте заявку и наш специалист свяжется с вами
                </p>
            </div>
            
            <!-- Правая часть: Форма (в строку) -->
            <form class="contact__form" id="contactFormServices">
                <input class="contact__input" type="text" name="name" placeholder="Имя" autocomplete="name">
                <input class="contact__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
                
                <!-- Обертка для кнопки и подписи -->
                <div class="contact__btn-container">
                    <!-- Белая кнопка, как на главной -->
                    <button class="btn btn--submit" type="submit">Оставить заявку<span class="policy-asterisk">*</span></button>
                    
                    <div class="contact__note">
                        <svg class="contact__note-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Свяжемся с вами в течение 15 минут</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Политика конфиденциальности внизу -->
    <span class="conact-policy">
        <span class="policy-asterisk">*</span>нажимая на кнопку, я соглашаюсь с 
        <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
    </span>
</section>


    <!-- FAQ -->
    <?php if (!empty($faq_items)): ?>
    <section class="section service-faq">
        <div class="container">
            <h2 class="section__title">Частые вопросы</h2>
            <div class="faq-list">
                <?php foreach ($faq_items as $i => $item): ?>
                <div class="faq-item<?php echo $i === 0 ? ' faq-item--open' : ''; ?>">
                    <button class="faq-item__q" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                        <span><?php echo esc_html($item['q']); ?></span>
                        <svg class="faq-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="faq-item__a" <?php echo $i === 0 ? '' : 'hidden'; ?>>
                        <div class="faq-item__a-inner">
                            <?php echo nl2br(esc_html($item['a'])); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<!-- MODAL WINDOW -->
<div id="serviceModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>
        
        <div class="modal-content">
            <h2 class="modal-title">Заказать расчет сметы</h2>
            
            <p class="modal-desc">
                Оставьте заявку, мы свяжемся с вами и подготовим предварительную смету.
            </p>
            
            <form class="modal-form" id="modalServiceForm">
                <input type="hidden" name="service_name" id="modalServiceInput" value="">

                <div class="modal-field-group">
                    <label for="modal-name" class="visually-hidden">Ваше имя</label>
                    <input type="text" 
                           id="modal-name"
                           name="name" 
                           placeholder="Ваше имя" 
                           class="modal-input" 
                           required autocomplete="name">
                </div>

                <div class="modal-field-group">
                    <label for="modal-phone" class="visually-hidden">Телефон</label>
                    <input type="tel" 
                           id="modal-phone"
                           name="phone" 
                           placeholder="+7 (___) ___-__-__" 
                           class="modal-input" 
                           required autocomplete="tel">
                </div>

                <button class="modal-btn" type="submit">Отправить заявку</button>
                
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

    <style>
      /* Настройка переменных для цветов */
      :root {
        --bg-section: #f5f0e8; /* Светлый бежевый фон */
        --text: #1a1a1a; /* Темный цвет для заголовков */
        --text-muted: #5c554b; /* Приглушенный коричнево-серый для текста */
        --accent: #f5b487; /* Оранжевый акцент (звезды) */
        --icon-bg: #f7ebd7; /* Фон под иконкой */
      }

      .reliability-section {
        background-color: rgb(240, 233, 217);
        padding: 80px 20px;
        color: var(--text);
      }

      .container-diag {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 60px;
        flex-wrap: wrap;
      }
      
      .content-col {
        flex: 1;
        min-width: 300px;
        max-width: 600px;
      }

      .section-title {
        color: var(--text);
        font-size: 32px;
        font-weight: 500;
        margin-bottom: 40px;
        line-height: 1.2;
        text-align: center;
      }

      .feature-item {
        display: flex;
        gap: 20px;
        margin-bottom: 32px;
        align-items: flex-start;
      }

      .feature-icon {
        width: 40px;
        height: 40px;
        background-color: var(--icon-bg);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      .feature-icon svg {
        width: 20px;
        height: 20px;
        fill: var(--accent);
      }

      .feature-text h3 {
        color: var(--text);
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 8px 0;
      }

      .feature-text p {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
      }

      /* Правая колонка с SVG */
      .visual-col {
        flex: 1;
        min-width: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .visual-col svg {
        width: 100%;
        max-width: 520px;
        height: auto;
        /* Тень для объема, опционально */
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.05));
      }

      /* Адаптив для мобильных */
      @media (max-width: 900px) {
        .container-diag {
          flex-direction: column;
        }
        .content-col,
        .visual-col {
          width: 100%;
          max-width: 100%;
        }
        .section-title {
          text-align: center;
        }
      }
    </style>

<?php get_footer(); ?>