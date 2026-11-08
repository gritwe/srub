<?php get_header(); ?>

<main id="main-content" role="main">
    <!-- 1. Hero Section -->
    <section class="hero" aria-label="Главный экран">
        <div class="hero__bg"></div>
        <div class="container hero__content">
            <h1 class="hero__title">
                Деревянные дома из <br>бревна и бруса во Владимире — <br>фиксированная цена без доплат
            </h1>
            
            <!-- Список преимуществ с новыми иконками -->
            <ul class="hero__features">
                <li class="hero__feature-item">
                    <!-- Иконка Топоров -->
                    <svg class="hero__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 12l-8.5 8.5a2.121 2.121 0 0 1-3-3L11 9"></path>
                        <path d="M16 16l6-6"></path>
                        <path d="M8 8l6-6"></path>
                        <path d="M9 7l1 1"></path>
                        <path d="M14 12l1 1"></path>
                        <path d="M2 22l5-5"></path>
                        <path d="M17 7l5 5"></path>
                    </svg>
                    <span>Собственные плотники</span>
                </li>
                <li class="hero__feature-item">
                    <!-- Иконка Купюр/Денег -->
                    <svg class="hero__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                        <circle cx="12" cy="12" r="2"></circle>
                        <path d="M6 12h.01M18 12h.01"></path>
                    </svg>
                    <span>Выезд на замер бесплатно</span>
                </li>
                <li class="hero__feature-item">
                    <!-- Иконка Часов -->
                    <svg class="hero__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Перезвоним через 15 минут без спама</span>
                </li>
            </ul>

            <div class="hero__actions">
                <!-- Обертка для кнопки и текста под ней -->
                <div class="hero__cta-wrapper">
                    
                    <button type="button" class="btn btn--primary btn--complex js-open-modal">
                        <span class="btn__main-text">Получить смету бесплатно</span>
                    </button>

                    <!-- Текст ПОД кнопкой (Политика конфиденциальности) -->
                    <div class="hero__policy-info">
                        <span>Нажимая на кнопку, я соглашаюсь с 
                            <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
                        </span>
                    </div>
                </div>

                <!-- Вторая кнопка -->
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--ghost">Смотреть проекты →</a>
            </div>

            <div class="hero__stats">
                <!-- Ссылка на проекты -->
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="hero__stat hero__stat--link">
                    <span class="hero__stat-num">300+</span>
                    <span class="hero__stat-label">Построенных домов</span>
                </a>

                <div class="hero__stat">
                    <span class="hero__stat-num">1 месяц</span>
                    <span class="hero__stat-label">Минимальный срок</span>
                </div>
                <div class="hero__stat">
                    <span class="hero__stat-num">0 ₽</span>
                    <span class="hero__stat-label">Выезд для сметы</span>
                </div>
                <div class="hero__stat">
                    <span class="hero__stat-num">5 лет</span>
                    <span class="hero__stat-label">Гарантия по договору</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Types Section -->
        <!-- 2. Types Section -->
    <section class="types section" id="services">
        <div class="container">
            <h2 class="section__title">Срубы ручной рубки под рубанок и в диком стиле</h2>
            <div class="types__grid">
                
                <!-- Карточка 1: Под рубанок -->
                <a href="https://srub-vladimir.ru/houses-under-the-plane/" class="types__card types__link">
                    <div class="types__img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/types/rubl-planed.jpg" alt="Сруб ручной рубки из хвойных пород" class="types__img" width="800" height="600" loading="lazy" decoding="async">
                    </div>
                    <div class="types__text">
                        <h3 class="types__name">Под рубанок</h3>
                        <p class="types__desc">
                            <strong>Обработка бревна «под рубанок»</strong> — это технология подготовки древесины для строительства срубов домов или бань, при которой с бревна снимается тонкий слой древесины для придания ему ровной, гладкой и светлой поверхности. Такой метод позволяет получить эстетичный внешний вид конструкции, упростить сборку и сократить период усадки.<br>
                            <strong>Преимущества:</strong> Бревно имеет более правильную форму, элементы конструкции более плотно прилегают друг к другу. Сокращается период усадки. Упрощается последующая шлифовка сруба.
                        </p>
                    </div>
                </a>

                <!-- Карточка 2: Дикая рубка -->
                <a href="https://srub-vladimir.ru/wild-style-houses/" class="types__card types__link">
                    <div class="types__text">
                        <h3 class="types__name">Дикая рубка</h3>
                        <p class="types__desc">
                            <strong>«Дикая рубка»</strong> (сруб в «диком стиле») — направление частного деревянного домостроения, при котором используются окоренные вручную брёвна. При обработке сохраняется фактура дерева, включая неровности.<br>
                            <strong>Отличительная черта</strong> — края брёвен в перерубах разной длины.<br>
                            <strong>Особенности</strong>: Стены лучше сохраняют тепло. В таком доме нет ничего, что мешало бы «дыханию» древесины. Древесина меньше подвержена растрескиванию, короблению и кручению.
                        </p>
                    </div>
                    <div class="types__img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/types/wild-cut.jpg" alt="Дом из дикой рубки" class="types__img" width="800" height="600" loading="lazy" decoding="async">
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- 3. Projects Slider Section -->
    <section class="section projects-slider-section" aria-label="Наши проекты">
        <div class="container">
            <h2 class="section__title">Наши проекты</h2>

            <div class="projects-slider-outer">
                <div class="projects-slider-wrapper">
                    <div class="projects-slider" id="projectsSlider">
                        <div class="ps-skeleton"></div>
                        <div class="ps-skeleton"></div>
                        <div class="ps-skeleton"></div>
                    </div>
                </div>

                <button class="ps-arrow ps-arrow--prev" aria-label="Назад">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="ps-arrow ps-arrow--next" aria-label="Вперёд">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>

            <div class="projects-slider-section__cta">
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--primary">Смотреть все проекты →</a>
            </div>
        </div>
    </section>

    <!-- 4. Advantages Section -->
    <section class="section advantages" aria-label="Преимущества компании">
        <div class="container">
            <h2 class="section__title">Почему выбирают строительство срубов у нас</h2>
            <div class="advantages__grid">
                <div class="advantages__item advantages__item--1 fade-up">
                    <div class="advantages__top">
                        <div class="advantages__category-wrapper">
                            <span class="advantages__category">ДОЛГОВЕЧНОСТЬ</span>
                            <div class="advantages__divider"></div>
                        </div>
                        <span class="advantages__num">01</span>
                    </div>
                    <h3 class="advantages__heading">Простоит 100 лет</h3>
                    <p class="advantages__text">Используем древесину сосны, наименее подверженную внешним воздействиям. Опираемся на 20 — летний опыт в деревянном домостроении</p>
                </div>
                <div class="advantages__item advantages__item--2 fade-up">
                    <div class="advantages__top">
                        <div class="advantages__category-wrapper">
                            <span class="advantages__category">РАБОТЫ</span>
                            <div class="advantages__divider"></div>
                        </div>
                        <span class="advantages__num">02</span>
                    </div>
                    <h3 class="advantages__heading">Более 300 объектов</h3>
                    <p class="advantages__text">За последние несколько лет сданы в срок и в рамках бюджета. Убедитесь в качестве, посетив один из объектов лично</p>
                </div>
                <div class="advantages__item advantages__item--3 fade-up">
                    <div class="advantages__top">
                        <div class="advantages__category-wrapper">
                            <span class="advantages__category">НАДЕЖНОСТЬ</span>
                            <div class="advantages__divider"></div>
                        </div>
                        <span class="advantages__num">03</span>
                    </div>
                    <h3 class="advantages__heading">Гарантия по договору</h3>
                    <p class="advantages__text">Стоимость и сроки не меняются. Руководитель лично контролирует каждый этап. Регулярно предоставляем отчёты</p>
                </div>
                <div class="advantages__item advantages__item--4 fade-up">
                    <div class="advantages__top">
                        <div class="advantages__category-wrapper">
                            <span class="advantages__category">СЕРВИС</span>
                            <div class="advantages__divider"></div>
                        </div>
                        <span class="advantages__num">04</span>
                    </div>
                    <h3 class="advantages__heading">Бесплатный выезд</h3>
                    <p class="advantages__text">Выезжаем на осмотр объекта в кратчайшие сроки для составления сметы. Даём рекомендации по строительству на вашем участке</p>
                </div>
            </div>
        </div>
    </section>

    <!-- === НОВАЯ СЕКЦИЯ: Случайные Фото === -->
    <?php 
    $home_data = get_home_gallery_data(); 
    if (!empty($home_data['photos'])) : 
    ?>
    <section class="section home-random-gallery">
        <div class="container">
            <h2 class="section__title">Живые фото со стройплощадок</h2>
            
            <div class="home-gallery-grid">
                <?php foreach ($home_data['photos'] as $img_id) : 
                    $img_url = wp_get_attachment_image_url($img_id, 'large');
                    $full_url = wp_get_attachment_url($img_id);
                    if (!$img_url) continue;
                ?>
                    <a href="<?php echo esc_url($full_url); ?>" class="home-gallery-item lightbox-trigger">
                        <img src="<?php echo esc_url($img_url); ?>" alt="Фото объекта" loading="lazy">
                        <div class="home-gallery-overlay">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="home-gallery-cta">
                <a href="<?php echo esc_url($home_data['gallery_link']); ?>" class="btn btn--outline-dark">Смотреть всю галерею →</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="contact" id="contact">
        <div class="container contact__inner">
            <h2 class="contact__title">Хотите посетить площадки и посмотреть весь процесс?</h2>
            
            <div class="contact__body">
                <!-- Левая часть: Текст -->
                <div class="contact__text-block">
                    <p class="contact__text">
                        Оставьте заявку и мы организуем Вам экскурсию по нашим объектам
                    </p>
                </div>
                
                <!-- Правая часть: Форма -->
                <form class="contact__form" id="contactForm">
                    <input class="contact__input" type="text" name="name" placeholder="Имя" autocomplete="name">
                    <input class="contact__input" type="" name="phone" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
                    
                    <!-- Обертка для кнопки и подписи -->
                    <div class="contact__btn-container">
                        <button class="btn btn--submit" type="submit">Оставитить заявку</button>
                        
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
        <span class="conact-policy"> <span class="policy-asterisk">*</span>нажимая на кнопку, я соглашаюсь с 
                            <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
        </span>
    </section>


    <!-- 5. Steps Section -->
    <section class="section steps" aria-label="Этапы работы">
        <div class="container">
            <h2 class="section__title">Этапы строительства деревянного дома</h2>
            <div class="steps__grid">
                <div class="steps__card fade-up">
                    <div class="steps__num">1</div>
                    <div class="steps__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <h3 class="steps__name">Консультация и выезд</h3>
                    <p class="steps__desc">Предварительно обсуждаем стоимость проекта. Приезжаем на участок</p>
                </div>
                <div class="steps__card fade-up">
                    <div class="steps__num">2</div>
                    <div class="steps__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3 class="steps__name">Смета и договор</h3>
                    <p class="steps__desc">Составляем точную смету с фиксированной ценой. Вносится предоплата. Подписываем договор</p>
                </div>
                <div class="steps__card fade-up">
                    <div class="steps__num">3</div>
                    <div class="steps__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <h3 class="steps__name">Строительство</h3>
                    <p class="steps__desc">Работаем по плану с еженедельными фотоотчётами. Поэтапная оплата по факту</p>
                </div>
                <div class="steps__card fade-up">
                    <div class="steps__num">4</div>
                    <div class="steps__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </div>
                    <h3 class="steps__name">Сдача под ключ</h3>
                    <p class="steps__desc">Принимаете готовый дом. Гарантия по договору. Остаёмся на связи после сдачи</p>
                </div>
            </div>
        </div>
    </section>


        <!-- ... конец секции Steps ... -->
    </section>

    <!-- === СЕКЦИЯ: ВИДЕООБЗОРЫ (Новая) === -->
    <?php 
    // Используем ту же функцию, что и для фото, она возвращает и видео тоже
    $home_data = get_home_gallery_data(); 
    
    if (!empty($home_data['videos'])) : 
    ?>
    <section class="section home-video-section">
        <div class="container">
            <h2 class="section__title">Видеоотчеты со строек</h2>
            
            <div class="home-video-grid">
                <?php foreach ($home_data['videos'] as $vid_id) : 
                    $video_url = wp_get_attachment_url($vid_id);
                    // Пытаемся получить превью. Если у видео нет обложки, берем заглушку или первый кадр
                    $poster_url = wp_get_attachment_image_url($vid_id, 'medium_large');
                    
                    if (!$video_url) continue;
                ?>
                    <div class="home-video-item">
                        <video controls preload="metadata" poster="<?php echo esc_url($poster_url ? $poster_url : ''); ?>" playsinline>
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                            Ваш браузер не поддерживает видео.
                        </video>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="home-video-cta">
                <a href="<?php echo esc_url($home_data['gallery_link']); ?>" class="btn btn--outline-dark">Смотреть все видео →</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 6. Contact Section -->
        <section class="contact" id="contact">
        <div class="container contact__inner">
            <h2 class="contact__title">Оставьте заявку прямо сейчас</h2>
            
            <div class="contact__body">
                <!-- Левая часть: Текст -->
                <div class="contact__text-block">
                    <p class="contact__text">
                        Приедем на участок.Познакомимся лично. Составим смету на месте
                    </p>
                </div>
                
                <!-- Правая часть: Форма -->
                <form class="contact__form" id="contactForm">
                    <input class="contact__input" type="text" name="name" placeholder="Имя" autocomplete="name">
                    <input class="contact__input" type="" name="phone" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
                    
                    <!-- Обертка для кнопки и подписи -->
                    <div class="contact__btn-container">
                        <button class="btn btn--submit" type="submit">Получить расчет <span class="policy-asterisk">*</span></button>
                        
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
        <span class="conact-policy">
            <span class="policy-asterisk">*</span>нажимая на кнопку, я соглашаюсь с 
            <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
        </span>
    </section>
</main>


    <!-- 7. FAQ Section -->
    <section class="section faq-section">
        <div class="container">
            <h2 class="section__title">Часто задаваемые вопросы</h2>
            
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Сколько стоит дом из сруба?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Стоимость зависит от диаметра бревна, площади дома, типа рубки и комплектации. В среднем дом из сруба под усадку начинается от 1,5–2,5 млн рублей, но точная цена рассчитывается индивидуально по проекту.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 2 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Что входит в стоимость сруба?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Обычно в стоимость входит:</p>
                            <ul style="padding-left: 20px; margin-bottom: 10px;">
                                <li>заготовка и обработка бревна</li>
                                <li>рубка сруба</li>
                                <li>доставка</li>
                                <li>сборка на участке</li>
                            </ul>
                            <p>Фундамент, крыша и отделка чаще всего рассчитываются отдельно, если не указано «под ключ».</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 3 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Сколько садится сруб дома?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Усадка сруба обычно составляет от 6 до 12 месяцев в зависимости от влажности древесины, диаметра бревна и сезона строительства.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 4 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли жить в доме сразу после строительства?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Нет, в большинстве случаев дом из бревна требует усадки. Но можно выполнить временную кровлю и черновые работы, чтобы начать отделку позже.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 7 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Строите ли вы зимой?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, строительство зимой даже предпочтительно, так как древесина меньше подвержена грибку и усадка проходит более равномерно.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 10 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли построить дом по своему проекту?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы работаем как по типовым, так и по индивидуальным проектам заказчика.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 13 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Нужно ли ждать усадку перед отделкой?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, полноценную отделку лучше начинать после основной усадки, обычно через 6–12 месяцев.</p>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 14 -->
                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Работаете ли вы за пределами Владимира?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы строим дома и бани в Владимирской области и соседних регионах.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




<!-- Модальное окно (Скопировано со страницы услуг) -->
<div id="serviceModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-window">
        <button class="modal-close" aria-label="Закрыть">&times;</button>
        
        <div class="modal-content">
            <h2 class="modal-title">Заказать расчет сметы</h2>
            
            <p class="modal-desc">
                Оставьте заявку, наш специалист перезвонит Вам в течении 15 минут
            </p>
            
            <form class="modal-form" id="modalServiceForm">
                <input type="hidden" name="service_name" id="modalServiceInput" value="">

                <div class="modal-field-group">
                    <label for="modal-name" class="visually-hidden">Имя</label>
                    <input type="text" 
                           id="modal-name"
                           name="name" 
                           placeholder="Имя" 
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
                <div class="hero__policy-info" style="margin-top: 10px;">
                    <span>Нажимая на кнопку, я соглашаюсь с 
                        <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
                    </span>
                </div>
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>


<?php get_footer(); ?>