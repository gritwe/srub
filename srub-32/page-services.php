<?php
/* Template Name: Услуги */
/* Template Post Type: page */
?>

<?php get_header(); ?>

<main class="services-main">

  <div class="container">
      <ul class="breadcrumb__list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Главная</a></li>
        <li class="breadcrumb__sep">/</li>
        <li>Услуги</li>
      </ul>
      
      <h1 class="services_h1">Услуги по строительству срубов во Владимире</h1>
  </div>

  <section class="svc-section" id="planed-log">
      <div class="container">
        <div class="svc-card-wrapper">
          <div class="svc-grid">
            <div class="svc-image-col">
              <div class="svc-img-box">
                <img src="<?php echo get_template_directory_uri(); ?>/img/service/rubanok.jpg" alt="Дома из рубленного бревна под рубанок" width="600" height="400" loading="eager">
              </div>
            </div>
            <div class="svc-text-col">
              <span class="svc-num">01</span>
              <h2 class="svc-title">Дома из рубленного бревна под рубанок</h2>
              <p class="svc-desc">Идеально гладкая поверхность бревна достигается за счёт снятия тонкого верхнего слоя древесины. Эстетичный вид, меньше подвержен загрязнению и легче в уходе.</p>
              <ul class="svc-list">
                <li><span>Диаметр бревна</span> <b>22–32 см</b></li>
                <li><span>Срок строительства</span> <b>от 2.5 месяцев</b></li>
                <li><span>Стоимость м²</span> <b>от 30 000 ₽</b></li>
              </ul>
              <div class="svc-actions">
                  <button type="button" class="svc-btn js-open-modal" data-project="Рубленное бревно под рубанок">
                      Получить смету
                  </button>
                  <a href="<?php echo esc_url(get_permalink(359)); ?>" class="svc-btn svc-btn--outline">Подробнее</a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

  <section class="svc-section" id="wild-cut">
      <div class="container">
        <div class="svc-card-wrapper">
          <div class="svc-grid">
            <div class="svc-image-col">
              <div class="svc-img-box">
                <img src="<?php echo get_template_directory_uri(); ?>/img/service/wild-cut.jpg" alt="Дома в диком стиле" width="600" height="400" loading="lazy">
              </div>
            </div>
            <div class="svc-text-col">
              <span class="svc-num">02</span>
              <h2 class="svc-title">Дома дикой рубки</h2>
              <p class="svc-desc">Брутальный внутренний и внешний стиль с сохранением всей структуры ствола. Каждое бревно уникально, довольно плотно подгоняется по форме предыдущего.</p>
              <ul class="svc-list">
                <li><span>Диаметр бревна</span> <b>30–40+ см</b></li>
                <li><span>Срок строительства</span> <b>от 3 месяцев</b></li>
                <li><span>Стоимость м²</span> <b>от 35 000 ₽</b></li>
              </ul>
              <div class="svc-actions">
                  <button type="button" class="svc-btn js-open-modal" data-project="Дома дикой рубки">
                      Получить смету
                  </button>
                  <a href="<?php echo esc_url(get_permalink(357)); ?>" class="svc-btn svc-btn--outline">Подробнее</a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

  <section class="svc-cards-section">
    <div class="container">
      <div class="cards-grid">
        
        <div class="svc-card-wrapper svc-small-card">
          <span class="svc-num">03</span>
          <h2 class="svc-title">Кровельные работы</h2>
          <ul class="svc-list">
            <li><span>Срок выполнения</span> <b>от 2 недель</b></li>
            <li><span>Стоимость м²</span> <b>от 2 500 ₽</b></li>
          </ul>
          <div class="svc-actions">
              <button type="button" class="svc-btn js-open-modal" data-project="Кровельные работы">
                  Получить смету
              </button>
              <a href="<?php echo esc_url(get_permalink(369)); ?>" class="svc-btn svc-btn--outline">Подробнее</a>
          </div>
        </div>

        <div class="svc-card-wrapper svc-small-card">
          <span class="svc-num">04</span>
          <h2 class="svc-title">Монтаж фундамента</h2>
          <ul class="svc-list">
            <li><span>Срок выполнения</span> <b>от вида фундамента</b></li>
            <li><span>Стоимость м²</span> <b>договорная</b></li>
          </ul>
          <div class="svc-actions">
              <button type="button" class="svc-btn js-open-modal" data-project="Монтаж фундамента">
                  Получить смету
              </button>
              <a href="<?php echo esc_url(get_permalink(365)); ?>" class="svc-btn svc-btn--outline">Подробнее</a>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

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
                <div class="hero__policy-info">
                        <span>Нажимая на кнопку, я соглашаюсь с 
                            <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
                        </span>
                    </div>
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>


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
    
    <!-- Политика конфиденциальности внизу -->
    <span class="conact-policy">
        <span class="policy-asterisk">*</span>нажимая на кнопку, я соглашаюсь с 
        <a href="/privacy-policy/" target="_blank">политикой конфиденциальности</a>
    </span>
</section>

<!-- 7. FAQ Section -->
    <section class="section faq-section">
<!-- Вопрос 1 -->
<div class="container">
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Можно ли сделать второй этаж или мансарду?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Да, можно построить двухэтажный дом или дом с мансардой. Важно правильно рассчитать нагрузку на фундамент и учесть особенности усадки при проектировании.</p>
        </div>
    </div>
</div>

<!-- Вопрос 2 -->
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Какой тип рубки вы используете?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Мы используем различные виды рубки: «в лапу», «в чашу». Выбор зависит от ваших предпочтений, бюджета и климатических условий региона.</p>
        </div>
    </div>
</div>

<!-- Вопрос 3 -->
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Какие документы вы предоставляете?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Мы заключаем договор подряда, предоставляем смету, акт выполненных работ и гарантийные обязательства. Также можем помочь с оформлением разрешительной документации для строительства.</p>
        </div>
    </div>
</div>

<!-- Вопрос 4 -->
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Есть ли у вас готовые проекты домов?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Да, у нас есть каталог готовых проектов домов и бань разных размеров и конфигураций. Вы можете выбрать подходящий вариант или внести изменения в существующий проект. <a href="<?php echo esc_url(get_permalink(64)); ?>" class="faq-link">Ознакомиться с проектами</a></p>
        </div>
    </div>
</div>

<!-- Вопрос 5 -->
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Какой диаметр бревна выбрать?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Для постоянного проживания рекомендуем бревно диаметром 26–32 см. Для дачного домика достаточно 22–24 см. Чем толще бревно, тем теплее дом, но выше стоимость.</p>
        </div>
    </div>
</div>


<!-- Вопрос 6 -->
<div class="faq-item">
    <button class="faq-question" type="button">
        <span>Нужен ли фундамент под сруб?</span>
        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
    <div class="faq-answer">
        <div class="faq-answer-inner">
            <p>Да, фундамент обязателен. Для срубов подходят ленточный, свайно-винтовой или плитный фундамент. Выбор зависит от типа грунта и этажности дома.</p>
        </div>
    </div>
</div>
</div>
</section>

<?php get_footer(); ?>