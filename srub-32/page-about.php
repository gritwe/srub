<?php
/* Template Name: О нас */
get_header(); 
?>

<main>
    <h1 class="visually-hidden">О компании srub-vladimir — Строительство деревянных домов</h1>

    <!-- =========================================
         HERO SECTION
    ========================================== -->
    <section class="hero" aria-label="Главный экран">
        <div class="hero__bg"></div>
        <div class="container hero__content">
            <h1 class="hero__title">
                Деревянные дома от производителя с большим опытом работы
            </h1>
            
            <ul class="hero__features">
                <li class="hero__feature-item">
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
                    <svg class="hero__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                        <circle cx="12" cy="12" r="2"></circle>
                        <path d="M6 12h.01M18 12h.01"></path>
                    </svg>
                    <span>Выезд на замер бесплатно</span>
                </li>
                <li class="hero__feature-item">
                    <svg class="hero__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Перезвоним через 15 минут без спама</span>
                </li>
            </ul>

            <div class="hero__actions">
                <div class="hero__cta-wrapper">
                    <button type="button" class="btn btn--primary btn--complex js-open-modal">
                        <span class="btn__main-text">Получить смету бесплатно</span>
                    </button>
                    <div class="hero__policy-info">
                        <span>Нажимая на кнопку, я соглашаюсь с 
                            <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
                        </span>
                    </div>
                </div>
                <a href="<?php echo esc_url(get_permalink(64)); ?>" class="btn btn--ghost">Смотреть проекты →</a>
            </div>

            <div class="hero__stats">
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

    <!-- =========================================
         HISTORY TIMELINE
    ========================================== -->
    <section class="history section">
        <div class="container history__inner">
            <div class="history__left"> 
                <h2 class="section__title" style="margin-bottom:28px;">Двадцать лет — одно ремесло</h2>
                <p class="history__body">
                    Компания основана в 1999 году. Начинали небольшой бригадой, а теперь мы огромная команда с большим опытом за спиной. К каждого своя специализация: рубка срубов, шлифовка, конопатка, кровельные работы, фундамент. Собственное производство во Владимирской области, позволяет контролировать качество древесины от заготовки до укладки
                </p>
            </div>

            <div class="timeline">
                <div class="timeline__item">
                    <div class="timeline__visuals">
                        <div class="timeline__dot">1</div>
                        <div class="timeline__line"></div>
                    </div>
                    <div class="timeline__content">
                        <span class="timeline__year">1999</span>
                        <h3 class="timeline__event">Основание</h3>
                        <p class="timeline__desc">Первая бригада и объект</p>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__visuals">
                        <div class="timeline__dot">2</div>
                        <div class="timeline__line"></div>
                    </div>
                    <div class="timeline__content">
                        <span class="timeline__year">2012</span>
                        <h3 class="timeline__event">100-й объект</h3>
                        <p class="timeline__desc">Сотый сданный дом</p>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__visuals">
                        <div class="timeline__dot">3</div>
                        <div class="timeline__line"></div>
                    </div>
                    <div class="timeline__content">
                        <span class="timeline__year">2018</span>
                        <h3 class="timeline__event">Расширение географии</h3>
                        <p class="timeline__desc">Московская, Рязанская, Нижегородская область</p>
                    </div>
                </div>
                <div class="timeline__item timeline__item--last">
                    <div class="timeline__visuals">
                        <div class="timeline__dot timeline__dot--active">4</div>
                    </div>
                    <div class="timeline__content">
                        <span class="timeline__year">2026</span>
                        <h3 class="timeline__event">300+ объектов</h3>
                        <p class="timeline__desc">Более трёхсот сданных домов.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================
         PRINCIPLES
    ========================================== -->
    <section class="principles">
        <div class="container">
            <p class="section__eyebrow__2">почему нам доверяют</p>
            <div class="principles__grid">
                <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M20 4.375C11.0237 4.375 3.75 11.65 3.75 20.625C3.75 29.6 11.0237 36.875 20 36.875C28.9737 36.875 36.25 29.6 36.25 20.625C36.25 11.65 28.975 4.375 20 4.375ZM19.8688 33.7838C12.62 33.7838 6.74375 27.9075 6.74375 20.6588C6.74375 13.41 12.62 7.53375 19.8688 7.53375C27.1163 7.53375 32.9938 13.41 32.9938 20.6588C32.9938 27.9075 27.1163 33.7838 19.8688 33.7838ZM23.6625 21.4137H19.9375V15.1237C19.9375 14.4412 19.3838 13.8863 18.7013 13.8863C18.0188 13.8863 17.4637 14.44 17.4637 15.1237V22.65C17.4637 23.3338 18.0175 23.8862 18.7013 23.8862H23.6625C24.3463 23.8862 24.9 23.3338 24.9 22.65C24.9 21.9675 24.3463 21.4137 23.6625 21.4137Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Срок по договору</h3>
                        </div>
                        <p class="principle__desc">Дата сдачи объекта — обязательство, а не ориентир</p>
                    </div>
                </div>
                <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M20 0C8.955 0 0 8.95375 0 20C0 31.0462 8.95375 40 20 40C31.0462 40 40 31.0462 40 20C40 8.95375 31.0462 0 20 0ZM20 37.54C10.35 37.54 2.5 29.65 2.5 20C2.5 10.35 10.35 2.5 20 2.5C29.65 2.5 37.5 10.35 37.5 20C37.5 29.65 29.65 37.54 20 37.54ZM27.9825 12.6825L16.2475 24.49L10.9625 19.2062C10.475 18.7188 9.6825 18.7188 9.19375 19.2062C8.705 19.6938 8.705 20.485 9.19375 20.9737L15.3813 27.1613C15.8688 27.6488 16.6613 27.6488 17.15 27.1613C17.2063 27.105 17.255 27.0437 17.2987 26.98L29.7513 14.45C30.2388 13.9625 30.2388 13.17 29.7513 12.6813C29.2638 12.1925 28.4713 12.195 27.9825 12.6825Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Лучшая цена</h3>
                        </div>
                        <p class="principle__desc">Цена на наши объекты значительно ниже, чем у конкурентов</p>
                    </div>
                </div>
                 <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5024 25.9618C7.96387 23.7806 6.15067 21.2876 5.30003 20C6.15067 18.7123 7.96387 16.2193 10.5024 14.0382C13.1234 11.7864 16.3596 9.99996 20 9.99996C23.6405 9.99996 26.8768 11.7864 29.4977 14.0382C32.0363 16.2193 33.8495 18.7123 34.7002 20C33.8495 21.2876 32.0363 23.7806 29.4977 25.9618C26.8768 28.2136 23.6405 30 20 30C16.3596 30 13.1234 28.2136 10.5024 25.9618ZM20 6.66663C15.2459 6.66663 11.2619 8.99099 8.3302 11.5099C5.3878 14.0379 3.34595 16.896 2.43978 18.283C1.7551 19.3308 1.7551 20.6691 2.43978 21.717C3.34595 23.104 5.3878 25.962 8.3302 28.4901C11.2619 31.009 15.2459 33.3333 20 33.3333C24.7542 33.3333 28.7382 31.009 31.67 28.4901C34.6123 25.962 36.6542 23.104 37.5603 21.717C38.245 20.6691 38.245 19.3308 37.5603 18.283C36.6542 16.896 34.6123 14.0379 31.67 11.5099C28.7382 8.99099 24.7542 6.66663 20 6.66663ZM16.6667 20C16.6667 18.159 18.1592 16.6666 20 16.6666C21.841 16.6666 23.3333 18.159 23.3333 20C23.3333 21.841 21.841 23.3333 20 23.3333C18.1592 23.3333 16.6667 21.841 16.6667 20ZM20 13.3333C16.3182 13.3333 13.3334 16.3181 13.3334 20C13.3334 23.6818 16.3182 26.6666 20 26.6666C23.682 26.6666 26.6667 23.6818 26.6667 20C26.6667 16.3181 23.682 13.3333 20 13.3333Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Личный контроль</h3>
                        </div>
                        <p class="principle__desc">Руководитель лично посещает каждый объект</p>
                    </div>
                </div>
                 <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.33333 15.8333C8.33333 10.1561 13.3499 4.99996 20 4.99996C26.6502 4.99996 31.6667 10.1561 31.6667 15.8333C31.6667 19.4081 29.4795 23.401 26.601 27.1018C24.3262 30.0266 21.7955 32.5548 20 34.324C18.2045 32.5548 15.6738 30.0266 13.3989 27.1018C10.5205 23.401 8.33333 19.4081 8.33333 15.8333ZM20 1.66663C11.6501 1.66663 5 8.17711 5 15.8333C5 20.5918 7.81285 25.349 10.7677 29.1481C13.3248 32.4358 16.199 35.2623 17.9955 37.0288C18.3052 37.3335 18.583 37.6066 18.8215 37.8451C19.134 38.1576 19.558 38.3333 20 38.3333C20.442 38.3333 20.866 38.1576 21.1785 37.8451C21.417 37.6066 21.6948 37.3335 22.0045 37.029C23.8008 35.2623 26.6752 32.4358 29.2323 29.1481C32.1872 25.349 35 20.5918 35 15.8333C35 8.17711 28.3498 1.66663 20 1.66663ZM20 20.8333C22.3012 20.8333 24.1667 18.9678 24.1667 16.6666C24.1667 14.3654 22.3012 12.5 20 12.5C17.6988 12.5 15.8333 14.3654 15.8333 16.6666C15.8333 18.9678 17.6988 20.8333 20 20.8333Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Открытые объекты</h3>
                        </div>
                        <p class="principle__desc">Организуем визит на любой из наших сданных домов</p>
                    </div>
                </div>
                 <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M10.1384 5.3667C9.58843 5.3667 9.13843 5.8167 9.13843 6.3667V33.96C9.13843 34.51 9.58843 34.96 10.1384 34.96H29.8618C30.4118 34.96 30.8618 34.51 30.8618 33.96V11.4567L24.7718 5.3667H10.1384ZM23.1251 7.3667V11.86C23.1251 12.5234 23.6684 13.0667 24.3318 13.0667H28.8618V32.96H11.1384V7.3667H23.1251Z" fill="#E9A564"/><path d="M13.2649 25.62H26.4249V27.2866H13.2649V25.62ZM13.2649 21.4667H26.4249V23.1333H13.2649V21.4667ZM13.2649 17.3167H26.4249V18.9833H13.2649V17.3167Z" fill="#E9A564"/><path d="M15.605 14.7433C16.7096 14.7433 17.605 13.8479 17.605 12.7433C17.605 11.6387 16.7096 10.7433 15.605 10.7433C14.5004 10.7433 13.605 11.6387 13.605 12.7433C13.605 13.8479 14.5004 14.7433 15.605 14.7433Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Гарантия 5 лет</h3>
                        </div>
                        <p class="principle__desc">Гарантийные обязательства закреплены в договоре</p>
                    </div>
                </div>
                 <div class="principle">
                    <div class="principle__content-wrapper">
                        <div class="principle__header">
                            <div class="principle__icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M20 4.375C11.0237 4.375 3.75 11.65 3.75 20.625C3.75 29.6 11.0237 36.875 20 36.875C28.9737 36.875 36.25 29.6 36.25 20.625C36.25 11.65 28.975 4.375 20 4.375ZM19.8688 33.7838C12.62 33.7838 6.74375 27.9075 6.74375 20.6588C6.74375 13.41 12.62 7.53375 19.8688 7.53375C27.1163 7.53375 32.9938 13.41 32.9938 20.6588C32.9938 27.9075 27.1163 33.7838 19.8688 33.7838ZM23.6625 21.4137H19.9375V15.1237C19.9375 14.4412 19.3838 13.8863 18.7013 13.8863C18.0188 13.8863 17.4637 14.44 17.4637 15.1237V22.65C17.4637 23.3338 18.0175 23.8862 18.7013 23.8862H23.6625C24.3463 23.8862 24.9 23.3338 24.9 22.65C24.9 21.9675 24.3463 21.4137 23.6625 21.4137Z" fill="#E9A564"/></svg>
                            </div>
                            <h3 class="principle__name">Своя древесина</h3>
                        </div>
                        <p class="principle__desc">Работаем только с хвойными породами собственной заготовки</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

       <!-- =========================================
         PRODUCTION & FILMSTRIP (INFINITE LOOP)
    ========================================== -->
        <!-- PRODUCTION SECTION -->
    <section class="production-section section">
        <div class="container">
            <!-- Текстовая часть -->
            <div class="production-header">
                <h2 class="section__title" style="margin-bottom: 24px;">Собственное производство с полным циклом работ</h2>
                <div class="production-text">
                    <p>Компания «Сруб Владимир» самостоятельно выполняет полный цикл работ по заготовке и обработке древесины. Для строительства используются качественные хвойные брёвна, которые проходят отбор, окорку и подготовку в соответствии с требованиями технологии ручной рубки.</p>
                    <p>Мы контролируем каждый этап — от заготовки леса до сборки готового сруба на участке заказчика. Это позволяет гарантировать качество материала, точность изготовления и соблюдение сроков строительства.</p>
                </div>
            </div>

            <!-- Слайдер теперь внутри container, чтобы быть одной ширины с текстом -->
            <div class="filmstrip-wrapper">
                <div class="filmstrip-track" id="productionTrack">
                    
                    <!-- Фото (пути к файлам) -->
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/1.jpg" alt="Производство 1"></div>
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/2.jpg" alt="Производство 2"></div>
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/3.jpg" alt="Производство 3"></div>
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/4.jpg" alt="Производство 4"></div>
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/5.jpg" alt="Производство 5"></div>
                    <div class="filmstrip-item"><img src="<?php echo get_template_directory_uri(); ?>/img/about/6.jpg" alt="Производство 6"></div>

                </div>
            </div>
        </div> <!-- Конец container -->
    </section>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('productionTrack');
    if (!track) return;

    // Клонируем содержимое трека, чтобы создать иллюзию бесконечности
    // Нам нужно достаточно копий, чтобы заполнить экран + запас для прокрутки
    const items = Array.from(track.children);
    items.forEach(item => {
        const clone = item.cloneNode(true);
        track.appendChild(clone);
    });
    
    // Еще раз клонируем для плавности на широких экранах
    items.forEach(item => {
        const clone = item.cloneNode(true);
        track.appendChild(clone);
    });

    let scrollPosition = 0;
    let speed = 0.5; // Скорость прокрутки (чем больше число, тем быстрее)
    let isPaused = false;

    // Функция анимации
    function animate() {
        if (!isPaused) {
            scrollPosition += speed;
            
            // Получаем ширину одного оригинального набора элементов
            // Ширина элемента * количество оригинальных элементов
            const itemWidth = items[0].getBoundingClientRect().width;
            const originalSetWidth = itemWidth * items.length;

            // Если прокрутили больше ширины оригинального набора, сбрасываем в 0
            if (scrollPosition >= originalSetWidth) {
                scrollPosition = 0;
            }
            
            track.style.transform = `translateX(-${scrollPosition}px)`;
        }
        
        requestAnimationFrame(animate);
    }

    // Запуск анимации
    requestAnimationFrame(animate);

    // Пауза при наведении мыши
    track.addEventListener('mouseenter', () => {
        isPaused = true;
    });

    track.addEventListener('mouseleave', () => {
        isPaused = false;
    });
});
</script>
    <!-- =========================================
         GEOGRAPHY
    ========================================== -->
    <section class="geo section">
        <div class="container geo__inner">
            <div class="geo__left">
                <h2 class="section__title" style="margin-bottom:20px;">Работаем во многих регионах</h2>
                <p class="geo__lead">
                    Основная зона работ —  Владимир, Владимирская область. Так же Московская, Рязанская, Нижегородская области
                </p>
                <div class="geo__table">
                    <div class="geo__row"><span class="geo__region">Владимирская область</span><span class="geo__count">250+</span></div>
                    <div class="geo__row"><span class="geo__region">Московская область</span><span class="geo__count">40+</span></div>
                    <div class="geo__row"><span class="geo__region">Рязанская область</span><span class="geo__count">10 объектов</span></div>
                    <div class="geo__row"><span class="geo__region">Нижегородская область</span><span class="geo__count">12 объектов</span></div>
                </div>
            </div>
            <div class="geo__map">
                <iframe title="Карта работ" src="https://yandex.ru/map-widget/v1/?ll=40.4167,56.1290&z=6&l=map&pt=40.4167,56.1290,pmrdm1~37.6176,55.7558,pmrdm2~39.7333,54.6299,pmrdm3~43.9816,56.2965,pmrdm4" width="100%" height="400px" frameborder="0" allowfullscreen="true" style="border-radius:16px;" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- =========================================
         CONTACTS INFO (Adapted from Contacts Page)
    ========================================== -->
    <section class="contacts-info section">
        <div class="container">
            <h2 class="section__title">Наши контакты</h2>
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

    <!-- =========================================
         REVIEWS
    ========================================== -->
    <section class="reviews" id="reviews">
        <div class="reviews__header">
            <div class="container reviews__header-inner">
                <div class="reviews__rating">
                    <span class="reviews__score">5</span>
                    <span class="reviews__star">★</span>
                    <span class="reviews__count"><span id="totalReviewsCount">0</span> отзывов</span>
                </div>
                <div class="reviews__sources" id="sourceFilters">
                    <button class="reviews__source-btn active" data-filter-type="source" data-value="all">Все источники</button>
                    <button class="reviews__source-btn" data-filter-type="source" data-value="avito">Avito <span class="badge">5★</span></button>
                    <button class="reviews__source-btn" data-filter-type="source" data-value="yandex">Яндекс <span class="badge">5★</span></button>
                </div>
            </div>
        </div>

        <div class="reviews__tags-bar">
            <div class="container">
                <div class="reviews__tag-list" id="tagFilters">
                    <button class="reviews__tag-btn" data-filter-type="tag" data-value="quality">#качество</button>
                    <button class="reviews__tag-btn" data-filter-type="tag" data-value="speed">#сроки</button>
                    <button class="reviews__tag-btn" data-filter-type="tag" data-value="price">#цена</button>
                    <button class="reviews__tag-btn" data-filter-type="tag" data-value="service">#сервис</button>
                    <button class="reviews__tag-btn" data-filter-type="tag" data-value="beauty">#красота</button>
                    <button class="reviews__reset-btn" id="resetFiltersBtn">✕ Сбросить</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="reviews__carousel-container">
                <button class="reviews__arrow reviews__arrow--prev" id="prevBtn" aria-label="Назад">&#8592;</button>
                
                <div class="reviews__track-outer">
                    <div class="reviews__track" id="reviewsTrack">
                        <?php
                        $args = array(
                            'post_type'      => 'review',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );

                        $reviews_query = new WP_Query($args);

                        if ($reviews_query->have_posts()) :
                            while ($reviews_query->have_posts()) : $reviews_query->the_post();
                                
                                $source     = get_post_meta(get_the_ID(), 'review_source', true);
                                $rating     = get_post_meta(get_the_ID(), 'review_rating', true);
                                $date       = get_post_meta(get_the_ID(), 'review_date', true);
                                $saved_tags = get_post_meta(get_the_ID(), 'review_tags_meta', true);

                                if (!$source) $source = 'yandex_1';
                                if (!$rating) $rating = 5;
                                if (!$date) $date = get_the_date('d.m.Y');

                                $platform_link = '#';
                                $platform_name = 'Яндекс';

                                if ($source === 'avito') {
                                    $platform_link = 'https://www.avito.ru/brands/i19857765/all?src=sharing&sellerId=d88a485ebb89e28548923a5c6a89e77e';
                                    $platform_name = 'Avito';
                                } elseif ($source === 'yandex_1') {
                                    $platform_link = 'https://yandex.ru/profile/162353464872?lang=ru';
                                    $platform_name = 'Яндекс';
                                } elseif ($source === 'yandex_2') {
                                    $platform_link = 'https://yandex.ru/profile/174972127731?lang=ru';
                                    $platform_name = 'Яндекс';
                                }

                                $stars_html = '';
                                for ($i = 1; $i <= 5; $i++) {
                                    $stars_html .= ($i <= intval($rating)) ? '★' : '<span style="color:#ccc;">★</span>';
                                }

                                $first_letter = mb_substr(get_the_title(), 0, 1);
                                $colors = ['#e8a87c', '#7cbce8', '#e8d47c', '#a8e87c', '#d4a8e8'];
                                $bg_color = $colors[array_rand($colors)];

                                $tags_string = '';
                                if (is_array($saved_tags)) {
                                    $tags_string = implode(' ', $saved_tags);
                                }
                        ?>

                        <div class="review-card" data-source="<?php echo esc_attr($source); ?>" data-tags="<?php echo esc_attr($tags_string); ?>">
                            
                            <div class="review-card__header">
                                <div class="review-card__avatar" style="background:<?php echo $bg_color; ?>;">
                                    <?php echo esc_html($first_letter); ?>
                                </div>
                                <div class="review-card__meta">
                                    <div class="review-card__name"><?php the_title(); ?></div>
                                    <div class="review-card__date-source">
                                        <?php echo esc_html($date); ?> · 
                                        <a href="<?php echo esc_url($platform_link); ?>" target="_blank" rel="noopener noreferrer" class="review-card__source-link">
                                            <?php echo esc_html($platform_name); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="review-card__stars"><?php echo $stars_html; ?></div>
                            
                            <div class="review-card__content">
                                <div class="review-card__text">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            
                            <?php 
                                $raw_content = get_the_content();
                                if (strlen(strip_tags($raw_content)) > 200) : 
                            ?>
                                <button class="review-card__toggle" onclick="toggleReview(this)">
                                    Читать полностью
                                </button>
                            <?php endif; ?>
                        </div>

                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <p class="empty-message">Пока нет отзывов.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="reviews__arrow reviews__arrow--next" id="nextBtn" aria-label="Вперёд">&#8594;</button>
            </div>
            
            <div class="reviews__dots" id="reviewsDots"></div>
            <div id="noReviewsMsg" class="empty-message" style="display:none;">По выбранным критериям отзывов не найдено.</div>
        </div>
    </section>

        <section class="contact" id="contact">
        <div class="container contact__inner">
            <h2 class="contact__title">Планируете строительство дома или бани?</h2>
            
            <div class="contact__body">
                <!-- Левая часть: Текст -->
                <div class="contact__text-block">
                    <p class="contact__text">
                        Ответим на вопросы, оценим объем работ, подготовим подробную смету и предложим лучшее решение для вашего проекта
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
                        <span>Где находится ваше производство?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Наше производство находится во Владимирской области, в поселке Золотково Гусь-Хрустального района, где осуществляется заготовка древесины и изготовление срубов</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Сколько объектов вы уже построили?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>За время работы нашей компанией построено более 300 домов, бань и других объектов из бревна</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Какую древесину вы используете?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Для строительства мы используем качественную сосну, которая отличается прочностью, долговечностью и хорошими теплоизоляционными свойствами</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Почему вы работаете именно с сосной?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Сосна обладает высокой прочностью, хорошо сохраняет тепло, устойчива к нагрузкам и создает комфортный микроклимат внутри дома</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Есть ли у вас собственное производство?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы самостоятельно изготавливаем срубы на собственном производстве без привлечения посредников и сторонних подрядчиков</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Какие объекты вы строите?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Мы строим жилые дома, бани, гостевые дома и другие деревянные сооружения из бревна ручной рубки</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Можно ли заказать строительство под ключ?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Да, мы выполняем полный комплекс работ от изготовления сруба и устройства фундамента до монтажа кровли и сдачи объекта заказчику</p>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" type="button">
                        <span>Чем ваша компания отличается от других?</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <p>Мы имеем собственное производство, используем качественную сосну, строим по договору и уже реализовали более 300 объектов различного назначения</p>
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