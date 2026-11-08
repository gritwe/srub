<?php
/* Template Name: Projects */
get_header();
?>

<section class="filters-bar">
    <h1 class="services_h1">Услуги по строительству срубов во Владимире</h1>

    <div class="container">
        <ul class="breadcrumb__list">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></li>
            <li class="breadcrumb__sep">/</li>
            <li><a href="<?php echo esc_url(get_permalink(67)); ?>">Услуги</a></li>
        </ul>
    </div>

    <div class="container">
        <h1 class="visually-hidden">Деревянные дома во Владимире</h1>
        <div class="filters">
            <button class="filter-btn filter-btn--active" data-filter="all">Все проекты</button>

            <?php
            $categories = get_terms(array(
                'taxonomy'   => 'project_category',
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));

            if (!is_wp_error($categories) && !empty($categories)) :
                foreach ($categories as $cat) :
            ?>
                <button class="filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>">
                    <?php echo esc_html($cat->name); ?>
                </button>
            <?php
                endforeach;
            else :
            ?>
                <button class="filter-btn" data-filter="rublenoe_rubanok">Срубы «Под рубанок»</button>
                <button class="filter-btn" data-filter="wild_rubka">Срубы «Дикая рубка»</button>
                <button class="filter-btn" data-filter="bani_iz_brevna">Срубы «Бани из бревна»</button>
            <?php endif; ?>
        </div>
    </div>
</section>

<main class="projects-main">
    <div class="container">

        <div class="projects-grid" id="projectsGrid">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            // Получаем фильтр из URL
            $filter_category = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : '';

            $args = array(
                'post_type'      => 'project',
                'posts_per_page' => 15,
                'post_status'    => 'publish',
                'paged'          => $paged,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            );
            
            // Добавляем фильтрацию по категории если она указана
            if (!empty($filter_category)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'project_category',
                        'field'    => 'slug',
                        'terms'    => $filter_category,
                    ),
                );
            }
            
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();

                    $area     = get_post_meta(get_the_ID(), '_project_area', true);
                    $floors   = get_post_meta(get_the_ID(), '_project_floors', true);
                    $price    = get_post_meta(get_the_ID(), '_project_price', true);
                    $year     = get_post_meta(get_the_ID(), '_project_year', true);
                    $duration = get_post_meta(get_the_ID(), '_project_duration', true);

                    $cats     = get_the_terms(get_the_ID(), 'project_category');
                    $cat_slug = 'uncategorized';
                    if (!is_wp_error($cats) && !empty($cats)) {
                        $cat_slug = $cats[0]->slug;
                    }

                    $price_formatted = '';
                    if ($price) {
                        $price_formatted = is_numeric($price)
                            ? number_format((float)$price, 0, ' ', ' ') . ' ₽'
                            : esc_html($price);
                    }

                    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                    if (!$thumb) {
                        $thumb = get_template_directory_uri() . '/img/placeholder.jpg';
                    }
            ?>

                <article class="project-card" data-category="<?php echo esc_attr($cat_slug); ?>">
                    <div class="project-card__img-wrap">
                        <img src="<?php echo esc_url($thumb); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             width="400" height="300"
                             loading="lazy" />
                    </div>

                    <div class="project-card__body">
                        <h2 class="project-card__title"><?php the_title(); ?></h2>

                        <p class="project-card__desc"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>

                        <?php if ($price_formatted) : ?>
                            <p class="project-card__price"><?php echo $price_formatted; ?></p>
                        <?php endif; ?>

                        <div class="project-card__actions">
                            <a href="<?php the_permalink(); ?>" class="btn btn--outline">Подробнее</a>
                            <button class="btn btn--primary js-open-modal" data-project="<?php the_title_attribute(); ?>">
                                Заказать звонок
                            </button>
                        </div>
                    </div>
                </article>

            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="projects-empty">
                    <p>Проектов пока нет.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="pagination-wrapper" id="paginationWrapper"></div>

    </div>
</main>

<!-- Модальное окно остается без изменений -->
<div id="orderModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>

        <div class="modal-content">
            <h2 class="contact__title modal-title" id="modalProjectTitle">
                Заказать строительство дома
            </h2>

            <div class="contact__body">
                <p class="contact__text">
                    Укажите Ваши контакты, и наш специалист свяжется с вами в течение часа
                </p>

                <form class="contact__form" id="modalContactForm">
                    <input type="text" name="name" placeholder="Ваше имя" class="contact__input modal-input" required autocomplete="name">
                    <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" class="contact__input modal-input" required>
                    <input type="email" name="email" placeholder="example@mail.ru" class="contact__input modal-input" required>

                    <input type="hidden" name="project_name" id="modalProjectInput" value="">

                    <button class="btn btn--primary btn--submit" type="submit">Заказать звонок</button>
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>