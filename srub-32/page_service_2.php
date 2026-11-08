<?php
/*
 * Template Name: Страница услуги (Галерея из WP)
 */
get_header();

// --- НАЧАЛО ИЗМЕНЕНИЙ: Получаем картинки из Медиатеки WP ---
$gallery_ids = get_post_meta(get_the_ID(), '_service_wp_gallery', true);
$images = [];

if (!empty($gallery_ids) && is_array($gallery_ids)) {
    foreach ($gallery_ids as $id) {
        $src = wp_get_attachment_url($id);
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
        if (empty($alt)) $alt = get_the_title($id);

        if ($src) {
            $images[] = [
                'src' => $src,
                'alt' => $alt
            ];
        }
    }
}
// --- КОНЕЦ ИЗМЕНЕНИЙ ---

$faq_items = get_post_meta(get_the_ID(), '_service_faq', true);
if (!is_array($faq_items)) $faq_items = [];
?>

<main id="main-content" role="main" class="service-page">

    <section class="service-hero">
        <div class="container">
            <!-- Хлебные крошки -->
            <div class="breadcrumb service-hero__breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
                <span>/</span>
                <a href="<?php echo esc_url(get_permalink(67)); ?>">Услуги</a>
                <span>/</span>
                <span><?php the_title(); ?></span>
            </div>

            <div class="service-hero__inner">
                <h1 class="service-hero__title"><?php the_title(); ?></h1>
                
                <div class="service-hero__grid">
                    <!-- Левая колонка: Текст -->
                    <div class="service-hero__desc">
                        <?php the_content(); ?>
                    </div>

                    <!-- Правая колонка: Кнопка + Слайдер (ОСТАЛСЯ БЕЗ ИЗМЕНЕНИЙ) -->
                    <div class="service-hero__right-col">
                        
                        <div class="service-hero__action">
                            <button type="button" class="btn btn--primary service-hero__cta js-open-modal" data-project="<?php the_title_attribute(); ?>">
                                Получить смету бесплатно
                            </button>
                        </div>

                        <!-- FADE СЛАЙДЕР (Работает по старому принципу для ID 357 и 359) -->
                        <?php 
                        $current_page_id = get_the_ID();
                        $slider_images = [];
                        
                        if ($current_page_id == 357) { 
                            $slider_images = [
                                'img/wild/slider1.jpg',
                                'img/wild/slider2.jpg',
                                'img/wild/slider3.jpg',
                                'img/wild/slider4.jpg',
                                'img/wild/slider5.jpg'
                            ];
                        } elseif ($current_page_id == 359) { 
                            $slider_images = [
                                'img/plane/slider1.jpg',
                                'img/plane/slider2.jpg',
                                'img/plane/slider3.jpg',
                                'img/plane/slider4.jpg'
                            ];
                        }
                        
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

    <!-- ГАЛЕРЕЯ РАБОТ (ТЕПЕРЬ БЕРЕТ КАРТИНКИ ИЗ WP МЕДИАТЕКИ) -->
    <?php if (!empty($images)): ?>
    <section class="gallery-section">
        <div class="container">
            <h2 class="section__title">Галерея работ</h2>

            <div class="gallery-grid">
                <?php foreach ($images as $index => $img): ?>
                <div class="gallery-item js-gallery-item" data-index="<?php echo $index; ?>">
                    <img src="<?php echo esc_url($img['src']); ?>"
                         alt="<?php echo esc_attr($img['alt']); ?>"
                         loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php else: ?>
        <!-- Если галерея пуста, можно ничего не выводить или показать сообщение -->
        <!-- <div class="container" style="padding: 40px 0; text-align: center;">
            <p>Галерея для этой услуги пока пуста.</p>
        </div> -->
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


  <section class="stages-section">
    <h2 class="stages-section__title">Этапы работы</h2>
    <div class="stages-grid">
      <div class="stage-card">
        <div class="stage-number">1</div>
        <h3 class="stage-title">Звонок и выезд</h3>
        <p class="stage-description">Бесплатно приедем на участок, оценим объект, обсудим проект и пожелания</p>
      </div>
      <div class="stage-card">
        <div class="stage-number">2</div>
        <h3 class="stage-title">Смета и договор</h3>
        <p class="stage-description">Составляем точную смету с фиксированной ценой. Подписываем договор с гарантиями</p>
      </div>
      <div class="stage-card">
        <div class="stage-number">3</div>
        <h3 class="stage-title">Строительство</h3>
        <p class="stage-description">Работаем по плану с еженедельными фотоотчётами</p>
      </div>
      <div class="stage-card">
        <div class="stage-number">4</div>
        <h3 class="stage-title">Сдача под ключ</h3>
        <p class="stage-description">Принимаете готовую кровлю. Гарантия по договору. Остаёмся на связи после сдачи</p>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const cards = document.querySelectorAll('.stage-card');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });
      cards.forEach(card => observer.observe(card));
    });
  </script>

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

    <!-- FAQ (Остался без изменений) -->
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

<!-- MODAL WINDOW (Остался без изменений) -->
<div id="serviceModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>
        <div class="modal-content">
            <h2 class="modal-title">Заказать расчет сметы</h2>
            <p class="modal-desc">Оставьте заявку, мы свяжемся с вами и подготовим предварительную смету.</p>
            <form class="modal-form" id="modalServiceForm">
                <input type="hidden" name="service_name" id="modalServiceInput" value="">
                <div class="modal-field-group">
                    <label for="modal-name" class="visually-hidden">Ваше имя</label>
                    <input type="text" id="modal-name" name="name" placeholder="Ваше имя" class="modal-input" required autocomplete="name">
                </div>
                <div class="modal-field-group">
                    <label for="modal-phone" class="visually-hidden">Телефон</label>
                    <input type="tel" id="modal-phone" name="phone" placeholder="+7 (___) ___-__-__" class="modal-input" required autocomplete="tel">
                </div>
                <button class="modal-btn" type="submit">Отправить заявку</button>
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

<!-- LIGHTBOX FOR GALLERY -->
<div id="galleryLightbox" class="gallery-lightbox" aria-hidden="true">
    <div class="gallery-lightbox__content">
        <button class="gallery-lightbox__close" aria-label="Закрыть">&times;</button>
        <button class="gallery-lightbox__nav gallery-lightbox__prev" aria-label="Предыдущее фото">&#10094;</button>
        <img src="" alt="" class="gallery-lightbox__image">
        <button class="gallery-lightbox__nav gallery-lightbox__next" aria-label="Следующее фото">&#10095;</button>
        <div class="gallery-lightbox__counter"></div>
        <div class="gallery-lightbox__caption"></div>
    </div>
</div>


<?php get_footer(); ?>