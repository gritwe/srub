<?php get_header(); 

if (have_posts()) : while (have_posts()) : the_post();

$area       = get_post_meta(get_the_ID(), '_project_area', true);
$floors     = get_post_meta(get_the_ID(), '_project_floors', true);
$price      = get_post_meta(get_the_ID(), '_project_price', true);
$material   = get_post_meta(get_the_ID(), '_project_material', true);
$roof       = get_post_meta(get_the_ID(), '_project_roof', true);
$faq_items  = get_post_meta(get_the_ID(), '_service_faq', true);
if (!is_array($faq_items)) $faq_items = [];

if (empty($material)) {
    $material = 'Сосна, ⌀26–30см';
}

$cats = get_the_terms(get_the_ID(), 'project_category');
$cat_slug = '';
$cat_name = '';
if ($cats && !is_wp_error($cats) && is_array($cats) && !empty($cats)) {
    $cat_slug = sanitize_text_field($cats[0]->slug);
    $cat_name = sanitize_text_field($cats[0]->name);
}

if ($price) {
    if (is_numeric($price)) {
        $price_formatted = number_format((float)$price, 0, ' ', ' ') . ' ₽';
    } else {
        $price_formatted = esc_html($price);
    }
} else {
    $price_formatted = 'По запросу';
}

// SEO тексты по категории
$seo_title = 'Проект деревянного дома';
$seo_text  = '<p>Мы строим надёжные деревянные дома под ключ с гарантией качества.</p>';

if ($cat_slug === 'wild_rubka') { 
    $seo_title = 'Строительство срубов в диком стиле во Владимире и Владимирской области';
    $seo_text = '<div class="project-desc"><h3 class="cat-title">' . $seo_title . '</h3><p>Дикая рубка — это аутентичный стиль деревянного зодчества, сохраняющий природную форму каждого бревна. Мы строим дома в диком стиле во Владимире и Владимирской области, подчеркивая уникальную текстуру дерева и создавая неповторимый характер здания.</p><p>Такие дома отличаются высокой экологичностью и долговечностью. Каждое бревно подбирается индивидуально, что делает каждый проект единственным в своем роде.</p></div>';
} elseif ($cat_slug === 'rublenoe_rubanok') {
    $seo_title = 'Строительство срубов "под рубанок" во Владимире и Владимирской области';
    $seo_text = '<div class="project-desc"><h3 class="cat-title">' . $seo_title . '</h3><p>Срубы «под рубанок» сочетает в себе надежность ручной рубки и гладкую, эстетичную поверхность стен. Мы предлагаем строительство таких домов во Владимире и области, обеспечивая идеальную геометрию и минимальную усадку.</p><p>Обработка бревна на станке позволяет добиться ровной поверхности, удобной для последующей отделки или эксплуатации без дополнительной шлифовки. Это оптимальный выбор для тех, кто ценит традиционное качество и современный комфорт.</p></div>';
} elseif ($cat_slug === 'bani_iz_brevna') {
    $seo_title = 'Строительство бань из бревна во Владимире и Владимирской области';
    $seo_text = '<div class="project-desc"><h3 class="cat-title">' . $seo_title . '</h3><p>Баня из цельного бревна — это классика русского зодчества, создающая неповторимую атмосферу тепла и здоровья. Мы строим традиционные бани во Владимире и Владимирской области, используя отборную древесину камерной сушки и проверенные технологии рубки.</p><p>Натуральное дерево сохраняет целебные свойства: оно «дышит», регулирует влажность и наполняет парную полезными фитонцидами. Каждая баня проектируется индивидуально с учётом ваших пожеланий по планировке, размеру и стилю отделки.</p><p>Мы берём на себя полный цикл работ: от разработки проекта и закладки фундамента до монтажа печи и финишной отделки.</p></div>';
} elseif ($cat_slug === 'uslugi') {
    $seo_title = 'Комплексное строительство и услуги по срубам во Владимире и области';
    $seo_text = '<div class="project-desc"><h3 class="cat-title">' . $seo_title . '</h3><p>Мы предлагаем полный спектр услуг по возведению и обслуживанию деревянных домов во Владимире и Владимирской области.</p></div>';
} elseif ($cat_slug === 'profiled_log') {
    $seo_title = 'Строительство домов из профилированного бревна во Владимирской области';
    $seo_text = '<div class="project-desc"><h3 class="project-cat">' . $seo_title . '</h3><p>Профилированный брус — оптимальное соотношение цены, скорости возведения и энергоэффективности.</p></div>';
}

// Получаем фото для sidebar (первое фото из галереи или миниатюра)
$gallery_ids = get_post_meta(get_the_ID(), '_project_gallery', true);
$gallery_ids = is_array($gallery_ids) ? $gallery_ids : [];
if (empty($gallery_ids) && has_post_thumbnail()) {
    $gallery_ids = [get_post_thumbnail_id()];
}
$sidebar_thumb = !empty($gallery_ids) ? wp_get_attachment_image_url($gallery_ids[0], 'medium_large') : '';

// Похожие проекты по той же категории
$related_args = [
    'post_type'      => 'project',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'rand',
];
if ($cat_slug) {
    $related_args['tax_query'] = [[
        'taxonomy' => 'project_category',
        'field'    => 'slug',
        'terms'    => $cat_slug,
    ]];
}
$related_query = new WP_Query($related_args);

// Ссылка на все проекты категории
$cat_archive_link = get_term_link($cats[0], 'project_category');
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ul class="breadcrumb__list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></li>
            <li class="breadcrumb__sep">/</li>
            <li><a href="<?php echo esc_url(get_permalink(64)); ?>">Проекты</a></li>
            <li class="breadcrumb__sep">/</li>
            <?php if ($cat_name && !is_wp_error($cats[0])) : ?>
            <li><a href="<?php echo esc_url($cat_archive_link); ?>"><?php echo esc_html($cat_name); ?></a></li>
            <li class="breadcrumb__sep">/</li>
            <?php endif; ?>
            <li><?php the_title(); ?></li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<main class="project-content">
    <div class="container">
        <div class="project-content__inner">

            <!-- LEFT COLUMN -->
            <div class="project-main">
                <p class="project-category"><?php echo esc_html($cat_name); ?></p>
                <h1 class="project-title"><?php the_title(); ?></h1>

                <!-- Meta strip -->
                <div class="project-meta">
                    <div class="project-meta__item">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="2" width="12" height="12" rx="1"/>
                            <path d="M5 11L11 5M11 5H8M11 5v3"/>
                        </svg>
                        <span class="project-meta__label">Площадь</span>
                        <span class="project-meta__value"><?php echo esc_html($area); ?> м²</span>
                    </div>
                    <div class="project-meta__item">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M2 13h12M4 10h8M6 7h4M7 4h2"/>
                        </svg>
                        <span class="project-meta__label">Этажей</span>
                        <span class="project-meta__value"><?php echo esc_html($floors); ?></span>
                    </div>
                    <div class="project-meta__item">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 4h10M3 8h10M3 12h10M5 2v12M11 2v12"/>
                        </svg>
                        <span class="project-meta__label">Материал</span>
                        <span class="project-meta__value"><?php echo esc_html($material); ?></span>
                    </div>
                    <div class="project-meta__item">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                           <path d="M2 14 L8 4 L14 14 Z M5 14 L8 9 L11 14" stroke-linejoin="round"/>
                        </svg>
                        <span class="project-meta__label">Кровля</span>
                        <span class="project-meta__value"><?php echo esc_html($roof ? $roof : '—'); ?></span>
                    </div>
                </div>

                <!-- О проекте -->
                <div class="project-desc">
                    <h3 class="project-desc__title">О проекте</h3>
                    <div class="project-desc__body">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Что входит в стоимость -->
                <div class="project-includes">
                    <h3 class="project-includes__title">Что входит в стоимость</h3>
                    <ul class="project-includes__list">
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Рубка сруба на собственном производстве
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Доставка материала на участок
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Монтаж фундамента под ключ
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Сборка сруба на участке
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Монтаж кровли <?php if ($roof) echo '(' . esc_html($roof) . ')'; ?>
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Установка окон и дверей
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Обработка антисептиком в 2 слоя
                        </li>
                        <li>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 8 6 12 14 4"/></svg>
                            Гарантия и еженедельные фотоотчёты
                        </li>
                    </ul>
                </div>

                <!-- SEO блок -->
                <div class="project-seo">
                    <?php echo wp_kses_post($seo_text); ?>
                </div>

                <!-- Процесс строительства -->
                <div class="project-process">
                    <h3 class="project-process__title">Как мы строим</h3>
                    <div class="process-steps">
                        <div class="process-step">
                            <div class="process-step__num">01</div>
                            <div class="process-step__body">
                                <strong>Выезд и замеры</strong>
                                <p>Бесплатно приезжаем на участок, изучаем грунт и рельеф, составляем смету без скрытых затрат.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="process-step__num">02</div>
                            <div class="process-step__body">
                                <strong>Договор и производство</strong>
                                <p>Фиксируем цену и сроки. Рубим сруб на собственном производстве из выдержанной хвои.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="process-step__num">03</div>
                            <div class="process-step__body">
                                <strong>Фундамент и сборка</strong>
                                <p>Закладываем фундамент, монтируем сруб. Еженедельные фотоотчёты о ходе работ.</p>
                            </div>
                        </div>
                        <div class="process-step">
                            <div class="process-step__num">04</div>
                            <div class="process-step__body">
                                <strong>Сдача под ключ</strong>
                                <p>Кровля, окна, двери, обработка антисептиком. Подписываем акт и передаём ключи.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /project-main -->

            <!-- SIDEBAR -->
            <aside class="project-sidebar">

                <!-- Фото проекта в sidebar -->
                <?php if ($sidebar_thumb) : ?>
                <div class="sidebar-photo">
                    <img src="<?php echo esc_url($sidebar_thumb); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         loading="high" class="sidebar-photo__img">
                </div>
                <?php endif; ?>

                <!-- Цена и CTA -->
                <div class="project-price-block">
                    <p class="project-price-label">Стоимость под ключ</p>
                    <?php if ($price) : ?>
                        <p class="project-price"><?php echo $price_formatted; ?></p>
                    <?php endif; ?>
                    <p class="project-price-note">Включая фундамент, кровлю и отделку</p>
                    
                    <button class="btn btn--white js-open-modal" data-project="<?php the_title_attribute(); ?>">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M14.667 2.667H1.333C0.597 2.667 0 3.264 0 4V12C0 12.736 0.597 13.333 1.333 13.333H14.667C15.403 13.333 16 12.736 16 12V4C16 3.264 15.403 2.667 14.667 2.667ZM14.667 4L8 8.667L1.333 4H14.667ZM1.333 12V5.333L8 10L14.667 5.333V12H1.333Z" fill="currentColor"/>
                        </svg>
                        Оставить заявку
                    </button>

                    <a href="tel:+78001234567" class="btn btn--outline-white sidebar-phone">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M13.3 10.533l-1.8-.2a1.4 1.4 0 00-1.154.4l-1.3 1.3a10.62 10.62 0 01-4.6-4.6l1.307-1.307A1.4 1.4 0 005.667 4.5l-.2-1.8A1.4 1.4 0 004.073 1.4H2.8A1.4 1.4 0 001.4 2.8C1.4 9.327 6.673 14.6 13.2 14.6a1.4 1.4 0 001.4-1.4v-1.267a1.4 1.4 0 00-1.3-1.4z" fill="currentColor"/>
                        </svg>
                        Позвонить
                    </a>
                </div>

                <!-- Характеристики -->
                <div class="project-specs">
                    <h2 class="project-specs__title">Характеристики</h2>
                    <?php if ($area) : ?>
                    <div class="spec-row">
                        <span class="spec-label">Площадь</span>
                        <span class="spec-value"><?php echo esc_html($area); ?> м²</span>
                    </div>
                    <?php endif; ?>
                    <?php if ($floors) : ?>
                    <div class="spec-row">
                        <span class="spec-label">Этажей</span>
                        <span class="spec-value"><?php echo esc_html($floors); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($material) : ?>
                    <div class="spec-row">
                        <span class="spec-label">Материал</span>
                        <span class="spec-value"><?php echo esc_html($material); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($roof) : ?>
                    <div class="spec-row">
                        <span class="spec-label">Кровля</span>
                        <span class="spec-value"><?php echo esc_html($roof); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="spec-row">
                        <span class="spec-label">Гарантия</span>
                        <span class="spec-value">По договору</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Производство</span>
                        <span class="spec-value">Владимир</span>
                    </div>
                </div>

                <!-- Доверие -->
                <div class="sidebar-trust">
                    <div class="trust-item">
                        <strong>20 лет</strong>
                        <span>на рынке деревянного строительства</span>
                    </div>
                    <div class="trust-item">
                        <strong>Бесплатно</strong>
                        <span>выезд на участок и составление сметы</span>
                    </div>
                    <div class="trust-item">
                        <strong>Еженедельно</strong>
                        <span>фотоотчёты о ходе строительства</span>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</main>

<!-- GALLERY -->
<section class="project-gallery">
    <?php 
    $count = 0;
    foreach ($gallery_ids as $img_id) : 
        $src = wp_get_attachment_image_url($img_id, 'large');
        $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
        $active_class = ($count === 0) ? 'active' : '';
        $loading_attr = ($count === 0) ? 'eager' : 'lazy';
        if (!$src) continue;
    ?>
    <img src="<?php echo esc_url($src); ?>" 
         alt="<?php echo $alt ? esc_attr($alt) : the_title_attribute(['echo' => false]); ?>" 
         class="project-gallery__img <?php echo $active_class; ?>" 
         loading="<?php echo $loading_attr; ?>" />
    <?php $count++; endforeach; 
    
    if ($count > 1): ?>
    <button class="project-gallery__arrow project-gallery__arrow--prev" aria-label="Предыдущее фото">&#10094;</button>
    <button class="project-gallery__arrow project-gallery__arrow--next" aria-label="Следующее фото">&#10095;</button>
    <div class="project-gallery__nav">
        <?php for($i=0; $i<$count; $i++): ?>
        <button class="project-gallery__dot <?php echo ($i===0)?'active':''; ?>" aria-label="Перейти к фото <?php echo $i+1; ?>"></button>
        <?php endfor; ?>
    </div>
    <span class="project-gallery__counter">1 / <?php echo $count; ?></span>
    <?php endif; ?>
</section>

<!-- FAQ -->
<?php if (!empty($faq_items)): ?>
<section class="project-faq">
    <div class="container">
        <h2 class="project-faq__title">Часто задаваемые вопросы</h2>
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

<!-- RELATED PROJECTS -->
<?php if ($related_query->have_posts()): ?>
<section class="related-projects">
    <div class="container">
        <div class="related-projects__head">
            <h2 class="related-projects__title">Похожие проекты</h2>
            <?php if (!is_wp_error($cat_archive_link)): ?>
            <a href="<?php echo esc_url($cat_archive_link); ?>" class="related-projects__all-link">
                Все <?php echo esc_html($cat_name); ?> →
            </a>
            <?php endif; ?>
        </div>
        <div class="related-grid">
            <?php while ($related_query->have_posts()): $related_query->the_post();
                $r_price  = get_post_meta(get_the_ID(), '_project_price', true);
                $r_area   = get_post_meta(get_the_ID(), '_project_area', true);
                $r_floors = get_post_meta(get_the_ID(), '_project_floors', true);
                $r_price_fmt = '';
                if ($r_price) {
                    $r_price_fmt = is_numeric($r_price)
                        ? number_format((float)$r_price, 0, ' ', ' ') . ' ₽'
                        : esc_html($r_price);
                }
                $r_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            ?>
            <article class="project-card">
                <a href="<?php the_permalink(); ?>" class="project-card__link">
                    <div class="project-card__img-wrap">
                        <?php if ($r_thumb): ?>
                        <img src="<?php echo esc_url($r_thumb); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             class="project-card__img" loading="high">
                        <?php endif; ?>
                        <span class="project-card__badge"><?php echo esc_html($cat_name); ?></span>
                    </div>
                    <div class="project-card__body">
                        <h3 class="project-card__title"><?php the_title(); ?></h3>
                        <div class="project-card__meta">
                            <?php if ($r_area): ?><span><?php echo esc_html($r_area); ?> м²</span><?php endif; ?>
                            <?php if ($r_floors): ?><span><?php echo esc_html($r_floors); ?> эт.</span><?php endif; ?>
                        </div>
                        <?php if ($r_price_fmt): ?>
                        <p class="project-card__price"><?php echo $r_price_fmt; ?></p>
                        <?php endif; ?>
                        <span class="project-card__more">Подробнее →</span>
                    </div>
                </a>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="related-projects__cta">
            <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--primary">
                Смотреть все проекты →
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- MODAL -->
<div id="serviceModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>
        <div class="modal-content">
            <h2 class="modal-title" id="modalProjectTitle">
                Заказать строительство дома
            </h2>
            <p class="modal-desc">
                Укажите контакты — специалист свяжется с вами в течение часа
            </p>
            <form class="modal-form" id="modalServiceForm">
                <input type="hidden" name="service_name" id="modalServiceInput" value="">
                <div class="modal-field-group">
                    <input type="text" name="name" placeholder="Ваше имя"
                           class="modal-input" autocomplete="name">
                </div>
                <div class="modal-field-group">
                    <input type="tel" name="phone" placeholder="+7 (___) ___-__-__"
                           class="modal-input" required autocomplete="tel">
                </div>
                <button class="modal-btn" type="submit">Заказать звонок</button>
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>