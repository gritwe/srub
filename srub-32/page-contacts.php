<?php
/* Template Name: Контакты */
get_header();
?>

<main>

    <!-- PAGE HEADER: Хлебные крошки + H1 -->
    <section class="page-header">
        <div class="container">
            <div class="breadcrumb service-hero__breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
                <span>/</span>
                <span>Контакты</span>
            </div>
            <h1 class="page-header__title">Контакты</h1>
        </div>
    </section>

    <!-- CONTACT INFO CARDS -->
    <section class="section contacts-info contacts-info--top">
        <div class="container">
            <div class="contacts-info__grid">

                <div class="contacts-info__card">
                    <div class="contacts-info__icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.99 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.9 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <h3 class="contacts-info__label">Телефон</h3>
                    <a href="tel:+79107788999" class="contacts-info__value contacts-info__value--link">+7 (910) 77-88-999</a>
                </div>

                <div class="contacts-info__card">
                    <div class="contacts-info__icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <h3 class="contacts-info__label">Электронная почта</h3>
                    <a href="mailto:srub.vladim@gmail.com" class="contacts-info__value contacts-info__value--link">srub.vladim@gmail.com</a>
                </div>

                <div class="contacts-info__card">
                    <div class="contacts-info__icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="contacts-info__label">Адрес офиса</h3>
                    <span class="contacts-info__value">г. Владимир,<br>ул. Горького, 63</span>
                </div>

                <div class="contacts-info__card">
                    <div class="contacts-info__icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h3 class="contacts-info__label">Режим работы</h3>
                    <span class="contacts-info__value">Пн – Вс: 09:00–18:00</span>
                </div>

            </div>

            <!-- Мессенджер -->
            <div class="contacts-messengers">
                <span class="contacts-messengers__label">Также пишите нам:</span>
                <div class="contacts-messengers__links">
                    <a href="https://t.me/sruby_vladimir" target="_blank" rel="noopener noreferrer" class="contacts-messenger-btn contacts-messenger-btn--tg">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                        Telegram
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MAP + REGIONS -->
    <section class="section contacts-geo">
        <div class="container">
            <h2 class="section__title">География работ</h2>
            <div class="contacts-geo__inner">

                <div class="contacts-geo__left">
                    <p class="contacts-geo__lead">
                        Основная зона работ — Владимир и Владимирская область. Также выезжаем в Московскую, Рязанскую и Нижегородскую области.
                    </p>
                    <div class="contacts-geo__table">
                        <div class="contacts-geo__row">
                            <div class="contacts-geo__region-name">
                                <span class="contacts-geo__dot"></span>
                                Владимирская область
                            </div>
                            <span class="contacts-geo__count">250+ объектов</span>
                        </div>
                        <div class="contacts-geo__row">
                            <div class="contacts-geo__region-name">
                                <span class="contacts-geo__dot"></span>
                                Московская область
                            </div>
                            <span class="contacts-geo__count">40+ объектов</span>
                        </div>
                        <div class="contacts-geo__row">
                            <div class="contacts-geo__region-name">
                                <span class="contacts-geo__dot"></span>
                                Рязанская область
                            </div>
                            <span class="contacts-geo__count">10 объектов</span>
                        </div>
                        <div class="contacts-geo__row">
                            <div class="contacts-geo__region-name">
                                <span class="contacts-geo__dot"></span>
                                Нижегородская область
                            </div>
                            <span class="contacts-geo__count">12 объектов</span>
                        </div>
                    </div>
                </div>

                <div class="contacts-geo__map">
                    <iframe
                        title="Карта регионов работ"
                        src="https://yandex.ru/map-widget/v1/?ll=40.4167,56.1290&z=6&l=map&pt=40.4167,56.1290,pmrdm1~37.6176,55.7558,pmrdm2~39.7333,54.6299,pmrdm3~43.9816,56.2965,pmrdm4"
                        width="100%"
                        height="400"
                        frameborder="0"
                        allowfullscreen="true"
                        loading="lazy"
                        style="border-radius: 16px; display: block;">
                    </iframe>
                </div>

            </div>
        </div>
    </section>

    <!-- HOW WE WORK BLOCK -->
    <section class="section contacts-process">
        <div class="container">
            <h2 class="section__title">Как проходит первый контакт</h2>
            <div class="contacts-process__grid">
                <div class="contacts-process__step">
                    <div class="contacts-process__num">01</div>
                    <h3 class="contacts-process__name">Оставьте заявку</h3>
                    <p class="contacts-process__desc">Заполните форму или позвоните нам. Перезвоним в течение 15 минут в рабочее время</p>
                </div>
                <div class="contacts-process__step">
                    <div class="contacts-process__num">02</div>
                    <h3 class="contacts-process__name">Выезд на участок</h3>
                    <p class="contacts-process__desc">Приедем бесплатно, осмотрим участок и обсудим детали проекта на месте</p>
                </div>
                <div class="contacts-process__step">
                    <div class="contacts-process__num">03</div>
                    <h3 class="contacts-process__name">Смета и договор</h3>
                    <p class="contacts-process__desc">Составим подробную смету с фиксированной ценой. Подпишем договор с гарантией</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT FORM — точно как на главной -->
    <section class="contact" id="contact">
        <div class="container contact__inner">
            <h2 class="contact__title">Обсудим ваш будущий дом или баню</h2>

            <div class="contact__body">
                <div class="contact__text-block">
                    <p class="contact__text">
                        Бесплатно проконсультируем, рассчитаем стоимость строительства и поможем подобрать оптимальное решение под ваш участок и бюджет
                    </p>
                </div>

                <form class="contact__form" id="contactForm">
                    <input class="contact__input" type="text" name="name" placeholder="Имя" autocomplete="name">
                    <input class="contact__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required autocomplete="tel">

                    <div class="contact__btn-container">
                        <button class="btn btn--submit" type="submit">Получить расчет<span class="policy-asterisk">*</span></button>

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

 <section class="section faq-section">
        <div class="container">
            <h2 class="section__title">Часто задаваемые вопросы</h2>
            
            <div class="faq-list">
                    <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Сколько лет вы занимаетесь строительством срубов?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Мы занимаемся строительством домов и бань из бревна более 10 лет, выполняя проекты различной сложности во Владимирской области и соседних регионах</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли посетить ваше производство?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, по предварительной договорённости вы можете посетить наше производство, посмотреть процесс рубки срубов и используемые материалы</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Заключаете ли вы официальный договор?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, все работы выполняются по официальному договору с фиксированной стоимостью, сроками и гарантийными обязательствами</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли посмотреть построенные вами объекты?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, в нашем портфолио представлены готовые проекты домов и бань, а также фотографии объектов на разных этапах строительства</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Предоставляете ли вы гарантию на работы?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы предоставляем гарантию на выполненные работы и используемые конструктивные решения согласно условиям договора</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Выезжаете ли вы на участок заказчика?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы выезжаем на участок для консультации, оценки условий строительства и подготовки предварительного расчёта</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>В каких регионах вы работаете?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Мы строим дома и бани во Владимирской области, а также работаем в соседних регионах Центральной России</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Как получить расчёт стоимости проекта?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Свяжитесь с нами по телефону или оставьте заявку на сайте, и мы подготовим подробный расчёт стоимости с учётом ваших пожеланий</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>