<?php

function srub_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_image_size('project-thumb', 700, 500, true);
}
add_action('after_setup_theme', 'srub_theme_setup');

function srub_vladimir_scripts() {
    // 1. Предварительное подключение к серверу шрифтов (ускоряет загрузку)
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // 2. Подключение шрифтов с display=swap (текст виден сразу)
    wp_enqueue_style(
        'srub-google-fonts',
        'https://fonts.googleapis.com/css2?family=Geologica:wght@400;500&family=Inter:wght@400;600;700&display=swap',
        array(),
        null
    );

    // Получаем время изменения файла style.css, чтобы сбрасывать кэш при правках
    $style_version = file_exists(get_stylesheet_directory() . '/style.css') 
                     ? filemtime(get_stylesheet_directory() . '/style.css') 
                     : '1.0';

    wp_enqueue_style(
        'srub-style',
        get_stylesheet_uri(),
        array('srub-google-fonts'),
        $style_version
    );

    // Основной JS
    wp_enqueue_script(
        'srub-main-js',
        get_template_directory_uri() . '/js/main.js',
        array(),
        file_exists(get_template_directory() . '/js/main.js') ? filemtime(get_template_directory() . '/js/main.js') : '1.0',
        true
    );

    wp_localize_script('srub-main-js', 'srubAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('srub_contact_nonce'),
    ));

    // --- УСЛОВНЫЕ ПОДКЛЮЧЕНИЯ (с динамическими версиями) ---

    if ( is_page(47) ) {
        wp_enqueue_style('srub-about-css', get_template_directory_uri() . '/css/about.css', array('srub-style'), filemtime(get_template_directory() . '/css/about.css'));
        wp_enqueue_script('srub-about-js', get_template_directory_uri() . '/js/about.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/about.js'), true);
    }

    if ( is_post_type_archive('project') || is_page_template('page-projects.php') || ( is_page() && has_term('', 'project_category') ) ) {
        wp_enqueue_style('srub-projects-list-css', get_template_directory_uri() . '/css/projects.css', array('srub-style'), filemtime(get_template_directory() . '/css/projects.css'));
        wp_enqueue_script('srub-projects-list-js', get_template_directory_uri() . '/js/projects.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/projects.js'), true);
        
        global $wp_query;
        wp_localize_script('srub-projects-list-js', 'srubProjects', array(
            'max_pages'   => isset($wp_query->max_num_pages) ? (int) $wp_query->max_num_pages : 1,
            'found_posts' => isset($wp_query->found_posts)   ? (int) $wp_query->found_posts   : 0,
        ));
    }

    if ( is_singular('project') ) {
        wp_enqueue_style('srub-project-single-css', get_template_directory_uri() . '/css/project.css', array('srub-style'), filemtime(get_template_directory() . '/css/project.css'));
        wp_enqueue_script('srub-project-single-js', get_template_directory_uri() . '/js/project.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/project.js'), true);
    }

    if ( is_page_template('page_service_2.php') ) {
        wp_enqueue_style('srub-service-gallery-css', get_template_directory_uri() . '/css/servic.css', array('srub-style'), filemtime(get_template_directory() . '/css/servic.css'));
        wp_enqueue_script('srub-service-gallery-js', get_template_directory_uri() . '/js/servic_2.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/servic_2.js'), true);
    }

    if ( is_page_template('page-service.php') ) {
        wp_enqueue_style('srub-service_2-css', get_template_directory_uri() . '/css/service.css', array('srub-style'), filemtime(get_template_directory() . '/css/service.css'));
        wp_enqueue_script('srub-service_2-js', get_template_directory_uri() . '/js/servic.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/servic.js'), true);
    }

    if ( is_page_template('page-policy.php') ) {
        wp_enqueue_style('policy-style', get_template_directory_uri() . '/css/policy.css', array(), filemtime(get_template_directory() . '/css/policy.css'));
    }

    if ( is_page_template('page-contacts.php') ) {
        wp_enqueue_style('contact-style', get_template_directory_uri() . '/css/contacts.css', array(), filemtime(get_template_directory() . '/css/contacts.css'));
    }

    if ( is_page_template('page-confident.php') ) {
        wp_enqueue_style('policy-style', get_template_directory_uri() . '/css/conf.css', array(), filemtime(get_template_directory() . '/css/conf.css'));
    }

    if ( is_page_template('page-services.php') ) {
        wp_enqueue_style('srub-services-css', get_template_directory_uri() . '/css/services.css', array('srub-style'), filemtime(get_template_directory() . '/css/services.css'));
        wp_enqueue_script('srub-services-js', get_template_directory_uri() . '/js/services.js', array('srub-main-js'), filemtime(get_template_directory() . '/js/services.js'), true);
    }
}
add_action('wp_enqueue_scripts', 'srub_vladimir_scripts');

function srub_remove_default_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_generator');
}
add_action('wp_enqueue_scripts', 'srub_remove_default_styles', 100);

function srub_handle_contact_form() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'srub_contact_nonce' ) ) {
        wp_send_json_error( [ 'message' => 'Ошибка безопасности. Обновите страницу.' ] );
    }

    $name  = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    $phone = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
    
    if ( empty( $name ) || empty( $phone ) ) {
        wp_send_json_error( [ 'message' => 'Заполните имя и телефон' ] );
    }

    $to      = 'srub.vladim@gmail.com';
    $subject = 'Новая заявка с сайта srub-vladimir.ru';
    $message = "Имя: {$name}\nТелефон: {$phone}";
    
    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    $sent = wp_mail( $to, $subject, $message, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'message' => 'Спасибо! Мы свяжемся с вами.' ] );
    } else {
        wp_send_json_success( [ 'message' => 'Заявка принята (техническая проверка).' ] ); 
    }

    wp_die();
}
add_action( 'wp_ajax_nopriv_srub_contact_form', 'srub_handle_contact_form' );
add_action( 'wp_ajax_srub_contact_form',        'srub_handle_contact_form' );

function srub_filter_projects() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $paged    = isset($_POST['paged'])    ? max(1, intval($_POST['paged']))          : 1;

    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => 15,
        'post_status'    => 'publish',
        'paged'          => $paged,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    if ( $category && $category !== 'all' ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $query = new WP_Query($args);

    $response = array(
        'html'        => '',
        'max_pages'   => (int) $query->max_num_pages,
        'found_posts' => (int) $query->found_posts,
    );

    if ( $query->have_posts() ) {
        ob_start();

        while ( $query->have_posts() ) : $query->the_post();

            $area     = get_post_meta(get_the_ID(), '_project_area',     true);
            $floors   = get_post_meta(get_the_ID(), '_project_floors',   true);
            $price    = get_post_meta(get_the_ID(), '_project_price',    true);
            $material = get_post_meta(get_the_ID(), '_project_material', true);
            $roof     = get_post_meta(get_the_ID(), '_project_roof',     true);

            if (empty($material)) {
                $material = 'Сосна, ⌀26–30см';
            }

            $cats     = get_the_terms(get_the_ID(), 'project_category');
            $cat_slug = 'uncategorized';
            if ( !is_wp_error($cats) && !empty($cats) ) {
                $cat_slug = $cats[0]->slug;
            }

            $price_formatted = '';
            if ( $price ) {
                $price_formatted = is_numeric($price)
                    ? number_format((float)$price, 0, ' ', ' ') . ' ₽'
                    : esc_html($price);
            }

            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            if ( !$thumb ) {
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

                    <div class="project-card__meta">
                        <?php if ($area): ?>
                        <span class="project-card__meta-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M5 11L11 5M11 5H8M11 5v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php echo esc_html($area); ?> м²
                        </span>
                        <?php endif; ?>

                        <?php if ($floors): ?>
                        <span class="project-card__meta-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 13h12M4 10h8M6 7h4M7 4h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <?php echo esc_html($floors); ?> эт.
                        </span>
                        <?php endif; ?>
                        
                        <?php if ($material): ?>
                        <span class="project-card__meta-item">
                             <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 4h10M3 8h10M3 12h10M5 2v12M11 2v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <?php echo esc_html($material); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <p class="project-card__desc"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>

                    <?php if ($price_formatted): ?>
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

        $response['html'] = ob_get_clean();
    }

    wp_send_json_success($response);
    wp_die();
}
add_action('wp_ajax_nopriv_srub_filter_projects', 'srub_filter_projects');
add_action('wp_ajax_srub_filter_projects',        'srub_filter_projects');

function create_reviews_post_type() {
    $labels = array(
        'name'               => 'Отзывы',
        'singular_name'      => 'Отзыв',
        'menu_name'          => 'Отзывы',
        'add_new'            => 'Добавить отзыв',
        'add_new_item'       => 'Добавить новый отзыв',
        'edit_item'          => 'Редактировать отзыв',
        'new_item'           => 'Новый отзыв',
        'view_item'          => 'Посмотреть отзыв',
        'search_items'       => 'Найти отзывы',
        'not_found'          => 'Отзывов не найдено',
        'not_found_in_trash' => 'В корзине отзывов не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'reviews'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('review', $args);
}
add_action('init', 'create_reviews_post_type');

function add_review_meta_box() {
    add_meta_box(
        'review_settings_box',
        'Настройки отзыва',
        'render_review_meta_box',
        'review',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_review_meta_box');

function render_review_meta_box($post) {
    $source     = get_post_meta($post->ID, 'review_source', true);
    $rating     = get_post_meta($post->ID, 'review_rating', true);
    $date       = get_post_meta($post->ID, 'review_date',   true);
    $saved_tags = get_post_meta($post->ID, 'review_tags_meta', true);

    if (!is_array($saved_tags)) $saved_tags = array();

    $available_tags = array(
        'quality' => 'Качество',
        'speed'   => 'Сроки',
        'price'   => 'Цена',
        'service' => 'Сервис',
        'beauty'  => 'Красота',
    );

    wp_nonce_field('save_review_meta', 'review_meta_nonce');
    ?>

    <style>
        .review-meta-row { margin-bottom: 15px; }
        .review-meta-label { font-weight: 600; display: block; margin-bottom: 5px; font-size: 13px; }
        .review-tag-check { display: flex; align-items: center; margin-bottom: 4px; font-size: 13px; cursor: pointer; }
        .review-tag-check input { margin-right: 8px; }
        .review-input-full { width: 100%; padding: 5px; box-sizing: border-box; }
    </style>

    <div class="review-meta-row">
        <label class="review-meta-label">Источник отзыва:</label>
        <select name="review_source" class="review-input-full">
            <option value="">-- Не выбрано --</option>
            <option value="yandex_1" <?php selected($source, 'yandex_1'); ?>>Яндекс (Профиль 1)</option>
            <option value="yandex_2" <?php selected($source, 'yandex_2'); ?>>Яндекс (Профиль 2)</option>
            <option value="avito"    <?php selected($source, 'avito');    ?>>Avito</option>
        </select>
    </div>

    <div class="review-meta-row">
        <label class="review-meta-label">Оценка (1-5):</label>
        <input type="number" name="review_rating" value="<?php echo esc_attr($rating ? $rating : 5); ?>" min="1" max="5" style="width:60px;">
    </div>

    <div class="review-meta-row">
        <label class="review-meta-label">Дата отзыва:</label>
        <input type="text" id="review_date_input" name="review_date" class="review-input-full" placeholder="ДД.ММ.ГГГГ" value="<?php echo esc_attr($date); ?>">
        <p style="font-size:11px;color:#999;margin:2px 0 0;">Формат: 24.04.2026</p>
    </div>

    <div class="review-meta-row">
        <label class="review-meta-label">Метки (для фильтров):</label>
        <?php foreach ($available_tags as $slug => $name): ?>
            <label class="review-tag-check">
                <input type="checkbox" name="review_tags_meta[]" value="<?php echo esc_attr($slug); ?>"
                    <?php checked(in_array($slug, $saved_tags)); ?>>
                <?php echo esc_html($name); ?>
            </label>
        <?php endforeach; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('review_date_input');
        if (dateInput) {
            dateInput.addEventListener('input', function() {
                let v = this.value.replace(/\D/g, '');
                if (v.length >= 5) {
                    this.value = v.slice(0,2) + '.' + v.slice(2,4) + '.' + v.slice(4,8);
                } else if (v.length >= 3) {
                    this.value = v.slice(0,2) + '.' + v.slice(2);
                } else {
                    this.value = v;
                }
            });
            dateInput.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key) && !['Backspace','Delete','Tab'].includes(e.key)) {
                    e.preventDefault();
                }
            });
        }
    });
    </script>
    <?php
}

function save_review_meta_data($post_id) {
    if (!isset($_POST['review_meta_nonce']) || !wp_verify_nonce($_POST['review_meta_nonce'], 'save_review_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['review_source'])) update_post_meta($post_id, 'review_source', sanitize_text_field($_POST['review_source']));
    if (isset($_POST['review_rating'])) update_post_meta($post_id, 'review_rating', intval($_POST['review_rating']));
    if (isset($_POST['review_date']))   update_post_meta($post_id, 'review_date',   sanitize_text_field($_POST['review_date']));

    if (isset($_POST['review_tags_meta'])) {
        $tags = array_map('sanitize_text_field', $_POST['review_tags_meta']);
        update_post_meta($post_id, 'review_tags_meta', $tags);
    } else {
        delete_post_meta($post_id, 'review_tags_meta');
    }
}
add_action('save_post_review', 'save_review_meta_data');

function srub_register_projects_cpt() {
    $labels = array(
        'name'               => 'Проекты домов',
        'singular_name'      => 'Проект',
        'menu_name'          => 'Проекты',
        'add_new'            => 'Добавить проект',
        'add_new_item'       => 'Добавить новый проект',
        'edit_item'          => 'Редактировать проект',
        'new_item'           => 'Новый проект',
        'view_item'          => 'Посмотреть проект',
        'search_items'       => 'Найти проекты',
        'not_found'          => 'Проектов не найдено',
        'not_found_in_trash' => 'В корзине проектов не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'projects'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-admin-home',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('project', $args);

    register_taxonomy('project_category', 'project', array(
        'labels'            => array('name' => 'Категории', 'singular_name' => 'Категория'),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category'),
    ));
}
add_action('init', 'srub_register_projects_cpt');

function srub_create_project_terms() {
    $terms = array(
        'wild_rubka'       => 'Дикая рубка',
        'rublenoe_rubanok' => 'Рубленое под рубанок',
        'bani_iz_brevna'   => 'Срубы «Бани из бревна»',
        'uslugi'           => 'Услуги',
    );

    foreach ($terms as $slug => $name) {
        if (!term_exists($slug, 'project_category')) {
            wp_insert_term($name, 'project_category', array('slug' => $slug));
        }
    }
}
add_action('init', 'srub_create_project_terms', 20);

function srub_remove_default_meta_boxes() {
    remove_meta_box('postexcerpt',      'project', 'normal');
    remove_meta_box('postcustom',       'project', 'normal');
    remove_meta_box('commentsdiv',      'project', 'normal');
    remove_meta_box('commentstatusdiv', 'project', 'normal');
}
add_action('admin_menu', 'srub_remove_default_meta_boxes');

function srub_add_project_meta_boxes() {
    add_meta_box(
        'project_details_box',
        'Настройки проекта',
        'srub_render_project_meta_box',
        'project',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'srub_add_project_meta_boxes');

function srub_render_project_meta_box($post) {
    $price      = get_post_meta($post->ID, '_project_price',      true);
    $area       = get_post_meta($post->ID, '_project_area',       true);
    $floors     = get_post_meta($post->ID, '_project_floors',     true);
    $material   = get_post_meta($post->ID, '_project_material',   true);
    $roof       = get_post_meta($post->ID, '_project_roof',       true);
    
    // НОВОЕ ПОЛЕ: ID изображения плана
    $plan_id    = get_post_meta($post->ID, '_project_plan_image', true);

    wp_nonce_field('save_project_meta', 'project_meta_nonce');
    ?>

    <style>
        .proj-meta-row { margin-bottom: 12px; }
        .proj-meta-label { font-weight: 600; display: block; margin-bottom: 4px; font-size: 13px; color: #333; }
        .proj-input, .proj-select { width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        
        /* Стили для загрузчика плана */
        .plan-upload-wrap { border: 2px dashed #ccc; padding: 15px; text-align: center; background: #f9f9f9; border-radius: 4px; cursor: pointer; transition: 0.2s; }
        .plan-upload-wrap:hover { border-color: #2271b1; background: #f0f6fc; }
        .plan-preview-img { max-width: 100%; height: auto; margin-top: 10px; border-radius: 4px; display: none; }
        .plan-preview-img.active { display: block; }
        .plan-remove-btn { margin-top: 8px; font-size: 12px; color: #d63638; cursor: pointer; text-decoration: underline; display: none; }
        .plan-remove-btn.active { display: inline-block; }
    </style>


    <!-- Старые поля остаются ниже -->
    <div class="proj-meta-row">
        <label class="proj-meta-label">Площадь (м²)</label>
        <input type="text" name="project_area" class="proj-input" value="<?php echo esc_attr($area); ?>">
    </div>
    <div class="proj-meta-row">
        <label class="proj-meta-label">Этажность</label>
        <input type="text" name="project_floors" class="proj-input" value="<?php echo esc_attr($floors); ?>" placeholder="1 + мансарда">
    </div>
    <div class="proj-meta-row">
        <label class="proj-meta-label">Материал стен</label>
        <input type="text" name="project_material" class="proj-input" value="<?php echo esc_attr($material); ?>" placeholder="Сосна ⌀26–30см">
    </div>
    <div class="proj-meta-row">
        <label class="proj-meta-label">Кровля</label>
        <input type="text" name="project_roof" class="proj-input" value="<?php echo esc_attr($roof); ?>" placeholder="Металлочерепица">
    </div>
    
    <div class="proj-meta-row" style="border-top:2px solid #eee;padding-top:10px;margin-top:10px;">
        <label class="proj-meta-label" style="color:#d63638;">💰 Стоимость под ключ (руб)</label>
        <input type="text" name="project_price" class="proj-input" value="<?php echo esc_attr($price); ?>" placeholder="4200000">
    </div>

    <!-- Скрипт для медиазагрузчика плана -->
    <script>
    jQuery(document).ready(function($) {
        var planFrame;
        var planInput = $('#project_plan_image_id');
        var planBtn = $('#plan_upload_btn');
        var planPreview = $('#plan_preview_img');
        var planText = $('#plan_upload_text');
        var planRemove = $('#plan_remove_btn');
        var staticImg = $('#plan_preview_img_static'); // Убираем дубликат если есть

        planBtn.on('click', function(e) {
            e.preventDefault();
            if (planFrame) { planFrame.open(); return; }
            
            planFrame = wp.media({
                title: 'Выберите план проекта',
                button: { text: 'Выбрать план' },
                multiple: false,
                library: { type: 'image' }
            });

            planFrame.on('select', function() {
                var attachment = planFrame.state().get('selection').first().toJSON();
                planInput.val(attachment.id);
                planPreview.attr('src', attachment.url).addClass('active');
                planText.hide();
                planRemove.addClass('active');
                if(staticImg.length) staticImg.remove(); // Удаляем PHP заглушку
            });

            planFrame.open();
        });

        planRemove.on('click', function() {
            planInput.val('');
            planPreview.attr('src', '').removeClass('active');
            planText.show();
            $(this).removeClass('active');
            if(staticImg.length) staticImg.remove();
        });
    });
    </script>
    <?php
}

// 3. Обновленная функция сохранения
function srub_save_project_meta($post_id) {
    if (!isset($_POST['project_meta_nonce']) || !wp_verify_nonce($_POST['project_meta_nonce'], 'save_project_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Сохраняем стандартные поля
    if (isset($_POST['project_price']))    update_post_meta($post_id, '_project_price',    sanitize_text_field($_POST['project_price']));
    if (isset($_POST['project_area']))     update_post_meta($post_id, '_project_area',     sanitize_text_field($_POST['project_area']));
    if (isset($_POST['project_floors']))   update_post_meta($post_id, '_project_floors',   sanitize_text_field($_POST['project_floors']));
    if (isset($_POST['project_material'])) update_post_meta($post_id, '_project_material', sanitize_text_field($_POST['project_material']));
    if (isset($_POST['project_roof']))     update_post_meta($post_id, '_project_roof',     sanitize_text_field($_POST['project_roof']));

}
add_action('save_post_project', 'srub_save_project_meta');


function srub_add_gallery_meta_box() {
    add_meta_box(
        'project_gallery_box',
        '🖼️ Галерея проекта',
        'srub_render_gallery_meta_box',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'srub_add_gallery_meta_box');

function srub_render_gallery_meta_box($post) {
    $gallery_ids = get_post_meta($post->ID, '_project_gallery', true);
    $gallery_ids = is_array($gallery_ids) ? $gallery_ids : array();

    wp_nonce_field('save_project_gallery', 'project_gallery_nonce');
    ?>

    <style>
        .gallery-preview { display:flex;flex-wrap:wrap;gap:10px;margin-bottom:15px; }
        .gallery-item { position:relative;width:100px;height:100px;border:2px solid #ddd;border-radius:4px;overflow:hidden;background:#f9f9f9; }
        .gallery-item img { width:100%;height:100%;object-fit:cover; }
        .gallery-remove { position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#d63638;color:#fff;border:none;border-radius:50%;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center; }
        .gallery-remove:hover { background:#b32d2e; }
        .gallery-actions { margin-top:10px; }
        .gallery-btn { background:#2271b1;color:#fff;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;font-size:13px; }
        .gallery-btn:hover { background:#135e96; }
        .gallery-empty { color:#777;font-style:italic;font-size:13px; }
        #project_gallery_ids { display:none; }
    </style>

    <div class="gallery-preview" id="gallery-preview-<?php echo $post->ID; ?>">
        <?php if (!empty($gallery_ids)): ?>
            <?php foreach ($gallery_ids as $id):
                $img = wp_get_attachment_image_src($id, 'thumbnail');
                if ($img): ?>
                    <div class="gallery-item" data-id="<?php echo esc_attr($id); ?>">
                        <img src="<?php echo esc_url($img[0]); ?>" alt="">
                        <button type="button" class="gallery-remove" title="Удалить">&times;</button>
                    </div>
                <?php endif;
            endforeach; ?>
        <?php else: ?>
            <p class="gallery-empty">Галерея пуста. Добавьте фото.</p>
        <?php endif; ?>
    </div>

    <input type="hidden" name="project_gallery_ids" id="project_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">

    <div class="gallery-actions">
        <button type="button" class="gallery-btn" id="add-gallery-images">+ Добавить фото</button>
        <button type="button" class="gallery-btn" id="clear-gallery" style="background:#777;">✕ Очистить всё</button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const postId  = <?php echo (int) $post->ID; ?>;
        const preview = document.getElementById('gallery-preview-' + postId);
        const input   = document.getElementById('project_gallery_ids');
        const emptyMsg = preview.querySelector('.gallery-empty');

        document.getElementById('add-gallery-images').addEventListener('click', function(e) {
            e.preventDefault();
            const frame = wp.media({
                title:    'Добавить фото в галерею',
                button:   { text: 'Добавить в галерею' },
                multiple: true,
                library:  { type: 'image' },
            });

            frame.on('select', function() {
                const attachments = frame.state().get('selection').toArray();
                let currentIds    = input.value ? input.value.split(',').map(Number) : [];

                attachments.forEach(function(attachment) {
                    const id = attachment.get('id');
                    if (!currentIds.includes(id)) {
                        currentIds.push(id);
                        const item = document.createElement('div');
                        item.className  = 'gallery-item';
                        item.dataset.id = id;
                        item.innerHTML  = `
                            <img src="${attachment.get('sizes').thumbnail?.url || attachment.get('url')}" alt="">
                            <button type="button" class="gallery-remove" title="Удалить">&times;</button>
                        `;
                        if (emptyMsg) emptyMsg.style.display = 'none';
                        preview.appendChild(item);
                    }
                });
                input.value = currentIds.join(',');
            });

            frame.open();
        });

        preview.addEventListener('click', function(e) {
            if (e.target.classList.contains('gallery-remove')) {
                const item = e.target.closest('.gallery-item');
                const id   = item.dataset.id;
                let ids    = input.value ? input.value.split(',').filter(v => v != id) : [];
                input.value = ids.join(',');
                item.remove();
                if (ids.length === 0 && emptyMsg) emptyMsg.style.display = 'block';
            }
        });

        document.getElementById('clear-gallery').addEventListener('click', function() {
            if (confirm('Удалить все фото из галереи?')) {
                input.value     = '';
                preview.innerHTML = '<p class="gallery-empty">Галерея пуста. Добавьте фото.</p>';
            }
        });
    });
    </script>
    <?php
}

function srub_save_project_gallery($post_id) {
    if (!isset($_POST['project_gallery_nonce']) || !wp_verify_nonce($_POST['project_gallery_nonce'], 'save_project_gallery')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (!empty($_POST['project_gallery_ids'])) {
        $ids = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['project_gallery_ids']))));
        update_post_meta($post_id, '_project_gallery', $ids);
    } else {
        delete_post_meta($post_id, '_project_gallery');
    }
}
add_action('save_post_project', 'srub_save_project_gallery');

function srub_clean_review_admin() {
    remove_meta_box('wpseo_meta',         'review', 'normal');
    remove_meta_box('postimagediv',       'review', 'side');
    remove_meta_box('postcustom',         'review', 'normal');
    remove_meta_box('commentsdiv',        'review', 'normal');
    remove_meta_box('commentstatusdiv',   'review', 'normal');
}
add_action('add_meta_boxes', 'srub_clean_review_admin', 100);

// ===== SERVICE PAGE META BOX (FAQ) =====
function srub_add_service_meta_boxes() {
    add_meta_box(
        'service_settings_box',
        '⚙️ Настройки страницы услуги',
        'srub_render_service_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'srub_add_service_meta_boxes');

function srub_render_service_meta_box($post) {
    $template = get_post_meta($post->ID, '_wp_page_template', true);

    $project_category = get_post_meta($post->ID, '_service_project_category', true);
    $faq_items        = get_post_meta($post->ID, '_service_faq', true);
    if (!is_array($faq_items)) $faq_items = [];

    // === НОВОЕ: Получаем ID картинок галереи ===
    $gallery_ids_raw = get_post_meta($post->ID, '_service_wp_gallery', true);
    $gallery_ids = is_array($gallery_ids_raw) ? $gallery_ids_raw : array_filter(explode(',', $gallery_ids_raw));
    // ==========================================

    wp_nonce_field('save_service_meta', 'service_meta_nonce');

    $categories = get_terms(['taxonomy' => 'project_category', 'hide_empty' => false]);
    ?>
    <style>
        .srv-row { margin-bottom: 18px; }
        .srv-label { font-weight: 600; display: block; margin-bottom: 6px; font-size: 13px; }
        .srv-input, .srv-select { width: 100%; padding: 7px 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 13px; }
        
        /* Стили для галереи внутри метабокса */
        .srv-gallery-preview { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:10px; min-height: 50px; border: 1px dashed #ccc; padding: 10px; background: #f9f9f9; }
        .srv-gallery-item { position:relative; width:80px; height:80px; border:1px solid #ddd; background:#fff; overflow:hidden; }
        .srv-gallery-item img { width:100%; height:100%; object-fit:cover; }
        .srv-gallery-remove { position:absolute; top:-5px; right:-5px; width:18px; height:18px; background:#d63638; color:#fff; border:none; border-radius:50%; cursor:pointer; font-size:12px; line-height:16px; text-align:center; }
        .srv-gallery-btn { background:#2271b1; color:#fff; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; font-size:12px; }
        #service_gallery_input { display:none; }

        .faq-item { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; padding: 12px; margin-bottom: 10px; position: relative; }
        .faq-item textarea { width: 100%; box-sizing: border-box; font-size: 13px; padding: 6px; border: 1px solid #ddd; border-radius: 4px; }
        .faq-remove { position: absolute; top: 10px; right: 10px; background: #d63638; color: #fff; border: none; border-radius: 4px; padding: 3px 8px; cursor: pointer; font-size: 12px; }
        .faq-add-btn { background: #2271b1; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    </style>

    <!-- 1. Категория проектов -->
    <div class="srv-row">
        <label class="srv-label">Категория проектов для слайдера:</label>
        <select name="service_project_category" class="srv-select">
            <option value="">— Все проекты (случайные) —</option>
            <?php if (!is_wp_error($categories)) foreach ($categories as $cat): ?>
                <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($project_category, $cat->slug); ?>>
                    <?php echo esc_html($cat->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- 2. НОВАЯ СЕКЦИЯ: Галерея работ -->
    <div class="srv-row">
        <label class="srv-label">️ Галерея работ (для блока "Галерея работ"):</label>
        <div class="srv-gallery-preview" id="srv-gallery-preview-area">
            <?php foreach ($gallery_ids as $id): 
                $img = wp_get_attachment_image_src($id, 'thumbnail');
                if ($img): ?>
                <div class="srv-gallery-item" data-id="<?php echo esc_attr($id); ?>">
                    <img src="<?php echo esc_url($img[0]); ?>" alt="">
                    <button type="button" class="srv-gallery-remove">&times;</button>
                </div>
            <?php endif; endforeach; ?>
            
            <?php if(empty($gallery_ids)) : ?>
                <span style="color:#999; font-size:12px; align-self:center;">Нет выбранных фото</span>
            <?php endif; ?>
        </div>
        <input type="hidden" name="service_wp_gallery" id="service_gallery_input" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
        <button type="button" class="srv-gallery-btn" id="srv-add-photo-btn">+ Выбрать фото</button>
        <p style="font-size:11px; color:#666; margin-top:5px;">Эти фото появятся в блоке "Галерея работ" на странице.</p>
    </div>

    <!-- 3. FAQ -->
    <div class="srv-row">
        <label class="srv-label">FAQ — часто задаваемые вопросы:</label>
        <div id="faq-list">
            <?php foreach ($faq_items as $i => $item): ?>
            <div class="faq-item">
                <button type="button" class="faq-remove">✕</button>
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Вопрос:</label>
                <input type="text" name="service_faq[<?php echo $i; ?>][q]"
                       value="<?php echo esc_attr($item['q'] ?? ''); ?>"
                       class="srv-input" style="margin-bottom:8px;">
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Ответ:</label>
                <textarea name="service_faq[<?php echo $i; ?>][a]" rows="3"><?php echo esc_textarea($item['a'] ?? ''); ?></textarea>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="faq-add-btn" id="faq-add">+ Добавить вопрос</button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ЛОГИКА FAQ (старая) ---
        let idx = <?php echo count($faq_items); ?>;
        const faqAddBtn = document.getElementById('faq-add');
        const faqList = document.getElementById('faq-list');

        if(faqAddBtn) {
            faqAddBtn.addEventListener('click', function() {
                const div  = document.createElement('div');
                div.className = 'faq-item';
                div.innerHTML = `
                    <button type="button" class="faq-remove">✕</button>
                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Вопрос:</label>
                    <input type="text" name="service_faq[${idx}][q]" class="srv-input" style="margin-bottom:8px;">
                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Ответ:</label>
                    <textarea name="service_faq[${idx}][a]" rows="3" style="width:100%;box-sizing:border-box;font-size:13px;padding:6px;border:1px solid #ddd;border-radius:4px;"></textarea>
                `;
                faqList.appendChild(div);
                idx++;
            });
        }

        if(faqList) {
            faqList.addEventListener('click', function(e) {
                if (e.target.classList.contains('faq-remove')) {
                    e.target.closest('.faq-item').remove();
                }
            });
        }

        // --- НОВАЯ ЛОГИКА ДЛЯ ГАЛЕРЕИ УСЛУГ ---
        var servicePhotoFrame;
        var servicePhotoBtn = document.getElementById('srv-add-photo-btn');
        var servicePhotoInput = document.getElementById('service_gallery_input');
        var servicePhotoPreview = document.getElementById('srv-gallery-preview-area');

        if(servicePhotoBtn && servicePhotoInput && servicePhotoPreview) {
            // Удаление фото
            servicePhotoPreview.addEventListener('click', function(e) {
                if (e.target.classList.contains('srv-gallery-remove')) {
                    e.preventDefault();
                    var item = e.target.closest('.srv-gallery-item');
                    var id = item.getAttribute('data-id');
                    item.remove();
                    
                    var ids = servicePhotoInput.value.split(',').filter(function(val) { return val !== id && val !== ''; });
                    servicePhotoInput.value = ids.join(',');

                    if(ids.length === 0) {
                        var hint = document.createElement('span');
                        hint.style.color = '#999';
                        hint.style.fontSize = '12px';
                        hint.style.alignSelf = 'center';
                        hint.innerText = 'Нет выбранных фото';
                        servicePhotoPreview.appendChild(hint);
                    }
                }
            });

            // Добавление фото
            servicePhotoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (servicePhotoFrame) { 
                    servicePhotoFrame.open(); 
                    return; 
                }
                
                servicePhotoFrame = wp.media({ 
                    title: 'Выберите фото для галереи услуги', 
                    button: { text: 'Добавить в галерею' }, 
                    multiple: true, 
                    library: { type: 'image' } 
                });
                
                servicePhotoFrame.on('select', function() {
                    var attachments = servicePhotoFrame.state().get('selection').models;
                    var currentIds = servicePhotoInput.value ? servicePhotoInput.value.split(',').filter(Boolean) : [];
                    
                    // Удаляем подсказку "пусто"
                    var emptyHint = servicePhotoPreview.querySelector('span');
                    if(emptyHint) emptyHint.remove();

                    attachments.forEach(function(att) {
                        var id = att.get('id');
                        if (!currentIds.includes(String(id))) {
                            currentIds.push(id);
                            
                            var div = document.createElement('div');
                            div.className = 'srv-gallery-item'; 
                            div.setAttribute('data-id', id);
                            
                            var thumbUrl = att.get('sizes').thumbnail ? att.get('sizes').thumbnail.url : att.get('url');
                            
                            div.innerHTML = '<img src="'+thumbUrl+'" alt=""><button type="button" class="srv-gallery-remove">&times;</button>';
                            servicePhotoPreview.appendChild(div);
                        }
                    });
                    servicePhotoInput.value = currentIds.join(',');
                });
                
                servicePhotoFrame.open();
            });
        }
    });
    </script>
    <?php
}

function srub_save_service_meta($post_id) {
    if (!isset($_POST['service_meta_nonce']) || !wp_verify_nonce($_POST['service_meta_nonce'], 'save_service_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Сохранение категории
    if (isset($_POST['service_project_category'])) {
        update_post_meta($post_id, '_service_project_category', sanitize_text_field($_POST['service_project_category']));
    }

    // === НОВОЕ: Сохранение галереи ===
    if (isset($_POST['service_wp_gallery'])) {
        $raw = sanitize_text_field($_POST['service_wp_gallery']);
        if (!empty($raw)) {
            $ids = array_map('intval', array_filter(explode(',', $raw)));
            update_post_meta($post_id, '_service_wp_gallery', $ids);
        } else {
            delete_post_meta($post_id, '_service_wp_gallery');
        }
    }
    // ================================

    // Сохранение FAQ
    if (isset($_POST['service_faq']) && is_array($_POST['service_faq'])) {
        $faq = [];
        foreach ($_POST['service_faq'] as $item) {
            $q = sanitize_text_field($item['q'] ?? '');
            $a = sanitize_textarea_field($item['a'] ?? '');
            if ($q || $a) $faq[] = ['q' => $q, 'a' => $a];
        }
        update_post_meta($post_id, '_service_faq', $faq);
    } else {
        delete_post_meta($post_id, '_service_faq');
    }
}
add_action('save_post_page', 'srub_save_service_meta');


/* ==========================================
   КАСТОМНАЯ ГАЛЕРЕЯ И ВИДЕО (ИСПРАВЛЕННАЯ ВЕРСИЯ)
   ========================================== */

function custom_gallery_add_meta_boxes() {
    // Добавляем метабокс только если это нужно, но регистрируем глобально для page
    add_meta_box(
        'custom_page_gallery_box',
        '🖼️ Настройки страницы Галереи',
        'custom_gallery_render_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_gallery_add_meta_boxes');

function custom_gallery_render_meta_box($post) {
    // Проверяем шаблон страницы. Если это НЕ шаблон галереи, можно скрыть содержимое или показать уведомление
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    
    // Раскомментируйте строку ниже, если хотите показывать блок ТОЛЬКО на странице с шаблоном page-gallery.php
    // if ($template !== 'page-gallery.php' && $template !== '') return; 

    // Фото
    $gallery_ids_raw = get_post_meta($post->ID, '_custom_gallery_ids', true);
    $gallery_ids = is_array($gallery_ids_raw) ? $gallery_ids_raw : array_filter(explode(',', $gallery_ids_raw));
    
    // Видео
    $video_ids_raw = get_post_meta($post->ID, '_custom_video_ids', true);
    $video_ids = is_array($video_ids_raw) ? $video_ids_raw : array_filter(explode(',', $video_ids_raw));

    wp_nonce_field('save_custom_gallery_data', 'custom_gallery_nonce');
    ?>
    
    <style>
        .cg-row { margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .cg-label { font-weight: 600; display: block; margin-bottom: 10px; font-size: 14px; color: #23282d; }
        .cg-preview { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; 
            margin-bottom: 15px; 
            min-height: 60px; 
            border: 2px dashed #ccd0d4; 
            padding: 10px; 
            background: #fff; 
            border-radius: 4px; 
        }
        .cg-item { 
            position: relative; 
            width: 120px; 
            height: 80px; 
            border: 1px solid #ccc; 
            background: #000; 
            border-radius: 4px;
            overflow: hidden;
        }
        .cg-item img, .cg-item video { width: 100%; height: 100%; object-fit: cover; display: block; }
        .cg-remove { 
            position: absolute; 
            top: -8px; 
            right: -8px; 
            width: 22px; 
            height: 22px; 
            background: #d63638; 
            color: #fff; 
            border: 2px solid #fff;
            border-radius: 50%; 
            cursor: pointer; 
            font-size: 14px; 
            line-height: 18px; 
            text-align: center; 
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .cg-remove:hover { background: #b32d2e; }
        
        .cg-btn { 
            background: #2271b1; 
            color: #fff; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 13px; 
            transition: background 0.2s;
        }
        .cg-btn:hover { background: #135e96; }
        
        .cg-hint { font-size: 12px; color: #646970; margin-top: 8px; font-style: italic; }
        
        /* Скрываем инпуты, они нужны только для JS */
        #custom_gallery_input, #custom_video_ids_input { display: none; }
    </style>

    <!-- Блок ФОТО -->
    <div class="cg-row">
        <label class="cg-label">1. Фотографии для галереи:</label>
        <div class="cg-preview" id="cg-photo-preview-area">
            <?php foreach ($gallery_ids as $id): 
                $img = wp_get_attachment_image_src($id, 'thumbnail');
                if ($img): ?>
                <div class="cg-item" data-id="<?php echo esc_attr($id); ?>">
                    <img src="<?php echo esc_url($img[0]); ?>" alt="">
                    <button type="button" class="cg-remove" title="Удалить">&times;</button>
                </div>
            <?php endif; endforeach; ?>
            
            <?php if(empty($gallery_ids)) : ?>
                <span style="color:#999; font-size:12px; align-self:center;">Нет выбранных фото</span>
            <?php endif; ?>
        </div>
        <input type="hidden" name="custom_gallery_ids" id="custom_gallery_input" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
        <button type="button" class="cg-btn" id="cg-add-photo-btn">+ Выбрать фото</button>
    </div>

    <!-- Блок ВИДЕО -->
    <div class="cg-row" style="border-bottom:none;">
        <label class="cg-label">2. Видеообзоры (MP4):</label>
        
        <div class="cg-preview" id="cg-video-preview-area">
            <?php if (!empty($video_ids)) : 
                foreach ($video_ids as $id): 
                    $url = wp_get_attachment_url($id);
                    // Пытаемся получить превью. Для видео часто нет thumbnail, поэтому берем сам файл или заглушку
                    $thumb_data = wp_get_attachment_image_src($id, 'thumbnail');
                    $poster_src = $thumb_data ? $thumb_data[0] : ''; 
            ?>
                <div class="cg-item" data-id="<?php echo esc_attr($id); ?>">
                    <video src="<?php echo esc_url($url); ?>" preload="metadata" poster="<?php echo esc_url($poster_src); ?>"></video>
                    <button type="button" class="cg-remove" title="Удалить">&times;</button>
                </div>
            <?php 
                endforeach; 
            else : 
            ?>
                <span style="color:#999; font-size:12px; align-self:center;">Нет добавленных видео</span>
            <?php endif; ?>
        </div>

        <input type="hidden" name="custom_video_ids" id="custom_video_ids_input" value="<?php echo esc_attr(implode(',', $video_ids)); ?>">
        
        <button type="button" class="cg-btn" id="cg-add-video-btn">+ Добавить видео</button>
        
        <p class="cg-hint">Загружайте видео через "Медиафайлы". Поддерживается формат MP4.</p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- ОБЩАЯ ФУНКЦИЯ ДЛЯ УДАЛЕНИЯ ---
        function setupRemoveListener(previewId, inputId) {
            var preview = document.getElementById(previewId);
            var input = document.getElementById(inputId);
            
            if(!preview || !input) return;

            preview.addEventListener('click', function(e) {
                if (e.target.classList.contains('cg-remove')) {
                    e.preventDefault();
                    var item = e.target.closest('.cg-item');
                    var id = item.getAttribute('data-id');
                    
                    // Удаляем визуально
                    item.remove();
                    
                    // Обновляем скрытый инпут
                    var ids = input.value.split(',').filter(function(val) { return val !== id && val !== ''; });
                    input.value = ids.join(',');

                    // Если пусто, добавляем подсказку
                    if(ids.length === 0) {
                        var hint = document.createElement('span');
                        hint.style.color = '#999';
                        hint.style.fontSize = '12px';
                        hint.style.alignSelf = 'center';
                        hint.innerText = previewId.includes('photo') ? 'Нет выбранных фото' : 'Нет добавленных видео';
                        preview.appendChild(hint);
                    }
                }
            });
        }

        // Настраиваем удаление для фото и видео
        setupRemoveListener('cg-photo-preview-area', 'custom_gallery_input');
        setupRemoveListener('cg-video-preview-area', 'custom_video_ids_input');


        // --- ЛОГИКА ДЛЯ ФОТО ---
        var photoFrame;
        var photoBtn = document.getElementById('cg-add-photo-btn');
        var photoInput = document.getElementById('custom_gallery_input');
        var photoPreview = document.getElementById('cg-photo-preview-area');

        if(photoBtn) {
            photoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (photoFrame) { 
                    photoFrame.open(); 
                    return; 
                }
                
                photoFrame = wp.media({ 
                    title: 'Выберите фотографии', 
                    button: { text: 'Добавить в галерею' }, 
                    multiple: true, 
                    library: { type: 'image' } 
                });
                
                photoFrame.on('select', function() {
                    var attachments = photoFrame.state().get('selection').models;
                    var currentIds = photoInput.value ? photoInput.value.split(',').filter(Boolean) : [];
                    
                    // Удаляем подсказку "пусто", если она есть
                    var emptyHint = photoPreview.querySelector('span');
                    if(emptyHint) emptyHint.remove();

                    attachments.forEach(function(att) {
                        var id = att.get('id');
                        if (!currentIds.includes(String(id))) {
                            currentIds.push(id);
                            
                            var div = document.createElement('div');
                            div.className = 'cg-item'; 
                            div.setAttribute('data-id', id);
                            
                            // Безопасное получение URL миниатюры
                            var thumbUrl = att.get('sizes').thumbnail ? att.get('sizes').thumbnail.url : att.get('url');
                            
                            div.innerHTML = '<img src="'+thumbUrl+'" alt=""><button type="button" class="cg-remove">&times;</button>';
                            photoPreview.appendChild(div);
                        }
                    });
                    photoInput.value = currentIds.join(',');
                });
                
                photoFrame.open();
            });
        }


        // --- ЛОГИКА ДЛЯ ВИДЕО ---
        var videoFrame;
        var videoBtn = document.getElementById('cg-add-video-btn');
        var videoInput = document.getElementById('custom_video_ids_input');
        var videoPreview = document.getElementById('cg-video-preview-area');

        if(videoBtn) {
            videoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (videoFrame) { 
                    videoFrame.open(); 
                    return; 
                }
                
                videoFrame = wp.media({ 
                    title: 'Выберите видеофайлы', 
                    button: { text: 'Добавить видео' }, 
                    multiple: true, 
                    library: { type: 'video' } 
                });
                
                videoFrame.on('select', function() {
                    var attachments = videoFrame.state().get('selection').models;
                    var currentIds = videoInput.value ? videoInput.value.split(',').filter(Boolean) : [];
                    
                    // Удаляем подсказку "пусто", если она есть
                    var emptyHint = videoPreview.querySelector('span');
                    if(emptyHint) emptyHint.remove();

                    attachments.forEach(function(att) {
                        var id = att.get('id');
                        if (!currentIds.includes(String(id))) {
                            currentIds.push(id);
                            
                            var div = document.createElement('div');
                            div.className = 'cg-item'; 
                            div.setAttribute('data-id', id);
                            
                            // Для видео лучше брать прямой URL файла
                            var videoUrl = att.get('url');
                            
                            div.innerHTML = '<video src="'+videoUrl+'" preload="metadata"></video><button type="button" class="cg-remove">&times;</button>';
                            videoPreview.appendChild(div);
                        }
                    });
                    videoInput.value = currentIds.join(',');
                });
                
                videoFrame.open();
            });
        }
    });
    </script>
    <?php
}

function custom_gallery_save_meta($post_id) {
    // Проверка nonce
    if (!isset($_POST['custom_gallery_nonce']) || !wp_verify_nonce($_POST['custom_gallery_nonce'], 'save_custom_gallery_data')) {
        return;
    }
    
    // Автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Права доступа
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 1. Сохраняем ID фото
    if (isset($_POST['custom_gallery_ids'])) {
        $raw = sanitize_text_field($_POST['custom_gallery_ids']);
        if (!empty($raw)) {
            $ids = array_map('intval', array_filter(explode(',', $raw)));
            update_post_meta($post_id, '_custom_gallery_ids', $ids);
        } else {
            delete_post_meta($post_id, '_custom_gallery_ids');
        }
    }

    // 2. Сохраняем ID видео
    if (isset($_POST['custom_video_ids'])) {
        $raw = sanitize_text_field($_POST['custom_video_ids']);
        if (!empty($raw)) {
            $ids = array_map('intval', array_filter(explode(',', $raw)));
            update_post_meta($post_id, '_custom_video_ids', $ids);
        } else {
            delete_post_meta($post_id, '_custom_video_ids');
        }
    }
}
add_action('save_post_page', 'custom_gallery_save_meta');

/* ==========================================
   ФУНКЦИИ ДЛЯ ГЛАВНОЙ СТРАНИЦЫ (Галерея и Видео)
   ========================================== */

function get_home_gallery_data() {
    $gallery_page_id = 391; 
    
    // Попытка найти страницу по шаблону автоматически
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-gallery.php' 
    ));
    
    if (!empty($pages)) {
        $gallery_page_id = $pages[0]->ID;
    } else {
        // Запасной вариант: если шаблон не найден, попробуйте указать ID вручную, например 47
        $gallery_page_id = 47; 
    }

    if (!$gallery_page_id) return array('photos' => array(), 'videos' => array());

    // Получаем ID фото
    $photo_ids_raw = get_post_meta($gallery_page_id, '_custom_gallery_ids', true);
    $all_photos = is_array($photo_ids_raw) ? $photo_ids_raw : array_filter(explode(',', $photo_ids_raw));
    
    // Перемешиваем и берем 9 случайных
    if (!empty($all_photos)) {
        shuffle($all_photos);
        $random_photos = array_slice($all_photos, 0, 9);
    } else {
        $random_photos = array();
    }

    // Получаем ID видео (берем первые 3)
    $video_ids_raw = get_post_meta($gallery_page_id, '_custom_video_ids', true);
    $all_videos = is_array($video_ids_raw) ? $video_ids_raw : array_filter(explode(',', $video_ids_raw));
    $recent_videos = array_slice($all_videos, 0, 3);

    return array(
        'photos' => $random_photos,
        'videos' => $recent_videos,
        'gallery_link' => get_permalink($gallery_page_id)
    );
}

// В functions.php

function srub_get_random_projects_ajax() {
    // Проверка nonce для безопасности (опционально, но рекомендуется)
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'srub_contact_nonce' ) ) {
        wp_send_json_error( [ 'message' => 'Ошибка безопасности' ] );
    }

    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => 6, // Количество слайдов
        'post_status'    => 'publish',
        'orderby'        => 'rand', // Случайный порядок
        'no_found_rows'  => true,
    );

    $query = new WP_Query( $args );
    $projects = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            
            $price = get_post_meta( get_the_ID(), '_project_price', true );
            $price_formatted = '';
            if ( $price ) {
                $price_formatted = is_numeric( $price ) 
                    ? number_format( (float)$price, 0, ' ', ' ' ) . ' ₽' 
                    : esc_html( $price );
            }

            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
            if ( ! $thumb ) {
                $thumb = get_template_directory_uri() . '/img/placeholder.jpg';
            }

            $projects[] = array(
                'id'      => get_the_ID(),
                'title'   => get_the_title(),
                'excerpt' => wp_trim_words( get_the_excerpt(), 15, '...' ),
                'price'   => $price_formatted,
                'thumb'   => $thumb,
                'url'     => get_permalink(),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $projects );
    wp_die();
}
add_action( 'wp_ajax_nopriv_srub_random_slider', 'srub_get_random_projects_ajax' );
add_action( 'wp_ajax_srub_random_slider',        'srub_get_random_projects_ajax' );