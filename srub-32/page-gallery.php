<?php
/*
Template Name: Галерея работ (Custom)
*/

get_header(); 

// 1. Получаем данные
$gallery_ids_raw = get_post_meta(get_the_ID(), '_custom_gallery_ids', true);
$gallery_ids = [];
if (!empty($gallery_ids_raw)) {
    if (is_array($gallery_ids_raw)) $gallery_ids = $gallery_ids_raw;
    elseif (is_string($gallery_ids_raw)) $gallery_ids = array_filter(explode(',', $gallery_ids_raw));
}
$gallery_ids = array_values(array_filter(array_map('intval', $gallery_ids)));

// ВИДЕО: Теперь получаем массив ID
$video_ids_raw = get_post_meta(get_the_ID(), '_custom_video_ids', true);
$all_video_ids = [];
if (!empty($video_ids_raw)) {
    if (is_array($video_ids_raw)) $all_video_ids = $video_ids_raw;
    elseif (is_string($video_ids_raw)) $all_video_ids = array_filter(explode(',', $video_ids_raw));
}
$all_video_ids = array_values(array_filter(array_map('intval', $all_video_ids)));

// Настройка пагинации видео
$video_per_page = get_post_meta(get_the_ID(), '_custom_videos_per_page', true);
if(empty($video_per_page)) $video_per_page = 3;

// Пагинация видео
$video_paged = (get_query_var('video_paged')) ? get_query_var('video_paged') : 1;
$total_videos = count($all_video_ids);
$total_video_pages = max(1, ceil($total_videos / $video_per_page));
$video_offset = ($video_paged - 1) * $video_per_page;
$current_videos = array_slice($all_video_ids, $video_offset, $video_per_page);

// Пагинация фото (осталась как была)
$photo_per_page = 21; 
$photo_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$total_photos = count($gallery_ids);
$total_photo_pages = max(1, ceil($total_photos / $photo_per_page));
$photo_offset = ($photo_paged - 1) * $photo_per_page;
$current_photos = array_slice($gallery_ids, $photo_offset, $photo_per_page);
?>

<main id="main-content" role="main">
    
    <!-- Hero Section -->
    <section class="hero hero--compact hero--solid-bg" aria-label="Галерея работ">
        <div class="container hero__content">
            <h1 class="hero__title">Галерея наших работ</h1>
            <p class="hero__subtitle">Реальные фотографии и видеоотчеты со строительных площадок.</p>
            <div class="hero__actions">
                <button type="button" class="btn btn--primary js-open-modal" data-project="Расчет по фото из галереи">Рассчитать похожий проект</button>
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--ghost">Каталог проектов →</a>
            </div>
        </div>
    </section>

    <!-- Video Section (СЕТКА + ПАГИНАЦИЯ) -->
    <?php if (!empty($current_videos)) : ?>
    <section class="section video-section">
        <div class="container">
            <h2 class="section__title">Видеообзоры объектов</h2>
            
            <div class="video-grid">
                <?php foreach ($current_videos as $vid_id) : 
                    $video_url = wp_get_attachment_url($vid_id);
                    $poster_url = wp_get_attachment_image_url($vid_id, 'medium_large'); // Превью видео
                ?>
                    <div class="video-item fade-up">
                        <video controls preload="metadata" poster="<?php echo esc_url($poster_url); ?>" playsinline>
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                            Ваш браузер не поддерживает видео.
                        </video>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Пагинация Видео -->
            <?php if ($total_video_pages > 1) : ?>
            <div class="pagination-wrapper video-pagination">
                <?php
                // Ссылки для видео-пагинации используют параметр ?video_paged=
                echo paginate_links(array(
                    'base'         => str_replace(999999999, '%#%', esc_url(add_query_arg('video_paged', 999999999))),
                    'total'        => $total_video_pages,
                    'current'      => max(1, $video_paged),
                    'format'       => '?video_paged=%#%',
                    'type'         => 'list',
                    'prev_next'    => true,
                    'prev_text'    => __('← Назад'),
                    'next_text'    => __('Вперед →'),
                ));
                ?>
            </div>
            <?php endif; ?>

        </div>
    </section>
    <?php endif; ?>

    <!-- Photo Gallery Section -->
    <section class="section gallery-section">
        <div class="container">
            <h2 class="section__title">Фотоотчеты</h2>
            
            <?php if (!empty($current_photos)) : ?>
                <div class="gallery-grid">
                    <?php foreach ($current_photos as $image_id) : 
                        if (!wp_attachment_is_image($image_id)) continue;
                        $full_image_url = wp_get_attachment_url($image_id);
                        $thumb_url = wp_get_attachment_image_url($image_id, 'large'); 
                        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        if(empty($alt_text)) $alt_text = 'Фотография объекта';
                    ?>
                        <div class="gallery-item fade-up">
                            <a href="<?php echo esc_url($full_image_url); ?>" class="gallery-link">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" loading="eager">
                                <div class="gallery-overlay">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Пагинация Фото -->
                <?php if ($total_photo_pages > 1) : ?>
                <div class="pagination-wrapper">
                    <?php
                    echo paginate_links(array(
                        'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'total'        => $total_photo_pages,
                        'current'      => max(1, $photo_paged),
                        'format'       => '?paged=%#%',
                        'type'         => 'list',
                        'prev_next'    => true,
                        'prev_text'    => __('← Назад'),
                        'next_text'    => __('Вперед →'),
                    ));
                    ?>
                </div>
                <?php endif; ?>

            <?php else : ?>
                <div style="text-align: center; padding: 40px 0; background: #fff; border-radius: 12px; border: 1px dashed #ccc;">
                    <p style="font-size: 18px; color: #666;">📷 Фотографии пока не добавлены.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container contact__inner">
            <h2 class="contact__title">Понравился дом на фото?</h2>
            <div class="contact__body">
                <div class="contact__text-block"><p class="contact__text">Оставьте заявку, и мы рассчитаем стоимость аналогичного проекта для вашего участка.</p></div>
                <form class="contact__form" id="contactForm">
                    <input class="contact__input" type="text" name="name" placeholder="Имя" autocomplete="name">
                    <input class="contact__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
                    <div class="contact__btn-container">
                        <button class="btn btn--submit" type="submit">Получить расчет</button>
                        <div class="contact__note"><svg class="contact__note-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span>Свяжемся с вами в течение 15 минут</span></div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq-section" style="background: #FDFBF7;">
        <div class="container">
            <h2 class="section__title">Часто задаваемые вопросы</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" type="button"><span>Можно ли приехать посмотреть ваши объекты?</span><svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                    <div class="faq-answer"><div class="faq-answer-inner"><p>Да, мы можем организовать экскурсию на строящийся или готовый объект в Владимире и области.</p></div></div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" type="button"><span>Фотографии на сайте настоящие?</span><svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                    <div class="faq-answer"><div class="faq-answer-inner"><p>Абсолютно. В этой галерее представлены реальные фото наших строек.</p></div></div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Все объекты в галерее построены вашей компанией?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, в галерее представлены только наши собственные работы, выполненные нашей бригадой на разных этапах строительства</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли увидеть фотографии строительства по этапам?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, многие объекты сфотографированы на разных этапах работ — от изготовления сруба до завершения строительства</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Как часто пополняется галерея новыми объектами?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Мы регулярно добавляем фотографии новых домов, бань и других объектов по мере завершения строительства</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли заказать похожий проект по фотографии из галереи?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, если вам понравился один из представленных объектов, мы можем построить аналогичный проект или адаптировать его под ваши пожелания</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- MODAL WINDOW -->
<div id="serviceModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>
        <div class="modal-content">
            <h2 class="modal-title">Заказать расчет сметы</h2>
            <p class="modal-desc">Оставьте заявку, наш специалист перезвонит Вам в течении 15 минут</p>
            <form class="modal-form" id="modalServiceForm">
                <input type="hidden" name="service_name" id="modalServiceInput" value="">
                <div class="modal-field-group"><label for="modal-name" class="visually-hidden">Имя</label><input type="text" id="modal-name" name="name" placeholder="Имя" class="modal-input" required autocomplete="name"></div>
                <div class="modal-field-group"><label for="modal-phone" class="visually-hidden">Телефон</label><input type="tel" id="modal-phone" name="phone" placeholder="+7 (___) ___-__-__" class="modal-input" required autocomplete="tel"></div>
                <button class="modal-btn" type="submit">Отправить заявку</button>
                <div class="hero__policy-info" style="margin-top: 15px; font-size: 12px; color: #999;"><span>Нажимая на кнопку, я соглашаюсь с <a href="/privacy-policy/" target="_blank" style="color: var(--brown);">политикой конфиденциальности</a></span></div>
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

<!-- Lightbox Modal for Gallery -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <button class="lightbox-nav lightbox-prev">&#10094;</button>
    <button class="lightbox-nav lightbox-next">&#10095;</button>
    <img class="lightbox-content" id="lightbox-img" alt="Просмотр фото">
    <div class="lightbox-counter" id="lightbox-counter"></div>
</div>

<style>
/* === HERO SECTION === */
.hero--compact { background-color: var(--green); min-height: auto; padding: 80px 0 60px; position: relative; }
.hero__content { position: relative; z-index: 1; }
.hero__title { font-family: var(--font-display); font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: #ffffff; line-height: 1.1; margin-bottom: 20px; }
.hero__subtitle { color: rgba(255,255,255,0.9); font-size: 18px; max-width: 600px; margin-bottom: 30px; line-height: 1.5; }
.hero__actions { display: flex; gap: 16px; flex-wrap: wrap; }
.hero .btn--primary { background: #ffc800; color: #000; font-weight: 400; padding: 18px 28px; border-radius: 8px; border: none; cursor: pointer; }
.hero .btn--primary:hover { background: #e6b400; }
.hero .btn--ghost { color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 14px 28px; border-radius: 8px; text-decoration: none; }
.hero .btn--ghost:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

/* === VIDEO GRID (НОВОЕ) === */
.video-section { padding-top: 40px; padding-bottom: 20px; }
.video-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* По 3 видео в ряд */
    gap: 24px;
    margin-bottom: 40px;
}

.video-item {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9; /* Стандартное соотношение для видео */
    border-radius: 12px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.video-item video {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover; /* Заполняет блок, обрезая края если нужно */
    display: block;
}

/* === GALLERY === */
.gallery-section { padding-top: 40px; padding-bottom: 40px; }
.gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
.gallery-item { position: relative; width: 100%; aspect-ratio: 4 / 3; border-radius: 12px; overflow: hidden; background: #eee; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s ease; }
.gallery-item:hover { transform: translateY(-5px); }
.gallery-link { display: block; width: 100%; height: 100%; position: relative; z-index: 1; }
.gallery-link img { width: 100% !important; height: 100% !important; object-fit: cover !important; display: block; transition: transform 0.6s ease; }
.gallery-item:hover .gallery-link img { transform: scale(1.05); }
.gallery-overlay { position: absolute; inset: 0; background: rgba(45, 74, 45, 0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; z-index: 2; pointer-events: none; }
.gallery-overlay svg { width: 40px; height: 40px; color: #fff; }
.gallery-item:hover .gallery-overlay { opacity: 1; }

/* === PAGINATION === */
.pagination-wrapper { display: flex; justify-content: center; margin-top: 20px; margin-bottom: 40px; }
.pagination-wrapper ul.page-numbers { display: flex; list-style: none !important; gap: 10px; padding: 0 !important; margin: 0 !important; align-items: center; }
.pagination-wrapper .page-numbers li { margin: 0 !important; }
.page-numbers a, .page-numbers span { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #fff; color: var(--text); border: 1px solid #e0e0e0; text-decoration: none; font-weight: 400; font-size: 15px; transition: all 0.3s ease; }
.page-numbers a:hover { background: var(--green); color: #fff; border-color: var(--green); }
.page-numbers .current { background: var(--green); color: #fff; border-color: var(--green); }
.page-numbers.prev, .page-numbers.next { width: auto; padding: 0 16px; border-radius: 20px; font-size: 13px; }

/* === LIGHTBOX & MODAL STYLES === */
.lightbox { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); opacity: 0; transition: opacity 0.3s ease; }
.lightbox.active { display: block; opacity: 1; }
.lightbox-content { margin: auto; display: block; max-width: 90%; max-height: 85vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 4px; box-shadow: 0 0 30px rgba(0,0,0,0.5); }
.lightbox-close { position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; cursor: pointer; z-index: 10001; line-height: 1; }
.lightbox-nav { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.1); color: #fff; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; font-size: 24px; display: flex; align-items: center; justify-content: center; transition: background 0.3s; z-index: 10001; }
.lightbox-nav:hover { background: rgba(255,255,255,0.3); }
.lightbox-prev { left: 30px; } .lightbox-next { right: 30px; }
.lightbox-counter { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.7); font-family: var(--font-body); font-size: 14px; }

:root { --brown: #5a3e27; --brown-dark: #3d2a1a; --text-muted: #7a6e63; }
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(26, 20, 16, 0.75); backdrop-filter: blur(8px); z-index: 99999; display: flex; justify-content: center; align-items: center; opacity: 0; visibility: hidden; pointer-events: none; transition: opacity 0.3s ease, visibility 0.3s ease; padding: 20px; }
.modal-overlay.is-active { opacity: 1; visibility: visible; pointer-events: auto; }
.modal-window { position: relative; background: #fff; width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); transform: translateY(20px) scale(0.95); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); display: flex; flex-direction: column; border: 1px solid #e0d5c5; }
.modal-overlay.is-active .modal-window { transform: translateY(0) scale(1); }
.modal-close { position: absolute; top: 15px; right: 15px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: transparent; border: none; cursor: pointer; color: var(--text-muted); font-size: 28px; line-height: 1; z-index: 10; transition: color 0.2s, transform 0.2s; padding: 0; }
.modal-close:hover { color: var(--brown); transform: rotate(90deg); }
.modal-content { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 40px 32px; width: 100%; box-sizing: border-box; }
.modal-title { font-family: 'Inter', sans-serif; font-size: 24px; font-weight: 700; color: #3E3630; margin-bottom: 12px; line-height: 1.2; width: 100%; }
.modal-desc { font-size: 15px; color: #6B635B; margin-bottom: 24px; line-height: 1.5; max-width: 90%; }
.modal-form { display: flex !important; flex-direction: column !important; align-items: center; width: 100%; gap: 12px; }
.modal-field-group { width: 100%; display: flex; justify-content: center; }
.modal-input { width: 100%; max-width: 320px; padding: 16px 20px; background-color: #F9F7F2; border: 1px solid #DCCFB8; border-radius: 12px; color: #3E3630; font-size: 16px; transition: all 0.3s ease; text-align: center; }
.modal-input:focus { background-color: #fff; border-color: #5a3e27; outline: none; box-shadow: 0 0 0 4px rgba(90, 62, 39, 0.1); }
.modal-input::placeholder { color: #998C7E; opacity: 1; }
.modal-btn { width: 100%; max-width: 320px; padding: 16px; background-color: #5a3e27; color: #fff; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
.modal-btn:hover { background-color: #3d2a1a; }
.form-message { margin-top: 15px; font-size: 14px; text-align: center; min-height: 20px; }
.visually-hidden { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }

/* Адаптив */
@media (max-width: 960px) { 
    .gallery-grid, .video-grid { grid-template-columns: repeat(2, 1fr); } 
    .hero--compact { padding: 60px 0 40px; }
}
@media (max-width: 600px) { 
    .gallery-grid, .video-grid { grid-template-columns: 1fr; } 
    .hero__title { font-size: 32px; }
    .hero__actions { flex-direction: column; width: 100%; }
    .hero .btn--primary, .hero .btn--ghost { width: 100%; justify-content: center; }
}
.fade-up { opacity: 1!important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. LOGIC FOR SERVICE MODAL ---
    const modal = document.getElementById('serviceModal');
    if (modal) {
        const openBtns = document.querySelectorAll('.js-open-modal');
        const closeBtn = modal.querySelector('.modal-close');
        const serviceInput = document.getElementById('modalServiceInput');
        const form = document.getElementById('modalServiceForm');
        const messageBox = form ? form.querySelector('.form-message') : null;

        const openModal = (serviceName = '') => {
            if (serviceName && serviceInput) serviceInput.value = serviceName;
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                const firstInput = modal.querySelector('input:not([type="hidden"])');
                if(firstInput) firstInput.focus();
            }, 100);
        };

        const closeModal = () => {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if(messageBox) messageBox.textContent = '';
        };

        openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const serviceName = btn.getAttribute('data-project') || '';
                openModal(serviceName);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
        });

        // Phone Mask
        const phoneInput = form ? form.querySelector('input[type="tel"]') : null;
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                if (!x[2] && x[1] !== '') {
                     e.target.value = x[1] === '8' ? '+7' : '+7' + x[1];
                } else {
                     e.target.value = !x[2] ? x[1] : '+7 (' + x[2] + (x[3] ? ') ' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
                }
            });
        }

        // Form Submit
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('.modal-btn');
                if(!submitBtn) return;

                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
                if(messageBox) { messageBox.textContent = ''; messageBox.style.color = ''; }

                const formData = new FormData(form);
                formData.append('action', 'srub_contact_form');
                
                if (typeof srubAjax !== 'undefined' && srubAjax.nonce) {
                    formData.append('nonce', srubAjax.nonce);
                }

                if (typeof srubAjax === 'undefined' || !srubAjax.ajax_url) {
                    console.error('AJAX URL not defined');
                    if(messageBox) { messageBox.textContent = 'Ошибка конфигурации сайта.'; messageBox.style.color = 'red'; }
                    submitBtn.disabled = false; submitBtn.textContent = originalText;
                    return;
                }

                fetch(srubAjax.ajax_url, { method: 'POST', body: formData })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if(messageBox) { messageBox.textContent = data.data.message || 'Спасибо! Заявка отправлена.'; messageBox.style.color = '#27ae60'; }
                        form.reset();
                        setTimeout(() => {
                            closeModal();
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                            if(messageBox) messageBox.textContent = '';
                        }, 2500);
                    } else {
                        throw new Error(data.data.message || 'Ошибка сервера');
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    if(messageBox) { messageBox.textContent = error.message || 'Произошла ошибка. Попробуйте позже.'; messageBox.style.color = '#e74c3c'; }
                    submitBtn.disabled = false; submitBtn.textContent = originalText;
                });
            });
        }
    }

    // --- 2. LOGIC FOR GALLERY LIGHTBOX ---
    const lightbox = document.getElementById('lightbox');
    if(lightbox) {
        const lightboxImg = document.getElementById('lightbox-img');
        const lbCloseBtn = document.querySelector('.lightbox-close');
        const prevBtn = document.querySelector('.lightbox-prev');
        const nextBtn = document.querySelector('.lightbox-next');
        const counter = document.getElementById('lightbox-counter');
        
        const links = Array.from(document.querySelectorAll('.gallery-link'));
        let currentIndex = 0;

        function openLightbox(index) {
            currentIndex = index;
            updateImage();
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateImage() {
            const link = links[currentIndex];
            if(link) {
                lightboxImg.src = link.getAttribute('href');
                counter.textContent = `${currentIndex + 1} / ${links.length}`;
            }
        }

        function nextImage(e) {
            if(e) e.stopPropagation();
            currentIndex = (currentIndex + 1) % links.length;
            updateImage();
        }

        function prevImage(e) {
            if(e) e.stopPropagation();
            currentIndex = (currentIndex - 1 + links.length) % links.length;
            updateImage();
        }

        links.forEach((link, index) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                openLightbox(index);
            });
        });

        if(lbCloseBtn) lbCloseBtn.addEventListener('click', closeLightbox);
        if(nextBtn) nextBtn.addEventListener('click', nextImage);
        if(prevBtn) prevBtn.addEventListener('click', prevImage);

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target === lightboxImg) closeLightbox();
        });

        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
    }
});
</script>

<?php get_footer(); ?>