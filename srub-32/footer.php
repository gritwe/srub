<footer class="footer">
    <div class="footer__inner">
      <div class="footer__left" style="display: flex; flex-direction: column; gap: 15px;">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">srub<span>-vladimir</span></a>
        
        <p class="footer__desc" style="font-style: normal; margin: 0;">
          Строительство деревянных домов из бревна ручной рубки<br> во Владимире, во Владимирской области с 1999 года
        </p>
        
        <div class="footer__contacts-block" style="font-style: normal; display: flex; flex-direction: column; gap: 15px;">
          <a href="tel:+79107788999" class="footer__contact">+7 (910) 77-88-999</a>
          <a href="mailto:srub-otdelka-33@yandex.ru" class="footer__contact">srub.vladim@gmail.com</a>
          <a href="https://yandex.ru/profile/162353464872?lang=ru" target="_blank" rel="noopener noreferrer" class="footer__city">
            г. Владимир
          </a>
        </div>
      </div>

      <nav class="footer__nav" aria-label="Меню в подвале">
        <?php 
        $pages = [
            67 => 'Услуги',
            64 => 'Проекты',
            391 => 'Галерея',
            47 => 'О компании',
            374 => 'Контакты'
        ];

        foreach ($pages as $id => $label) : 
            $url = get_permalink($id);
            $active_class = is_page($id) ? 'nav__link--active' : '';
        ?>
            <a href="<?php echo esc_url($url); ?>" class="footer__nav-link <?php echo esc_attr($active_class); ?>">
                <?php echo esc_html($label); ?>
            </a>
        <?php endforeach; ?>
      </nav>
    </div>
    
    <div class="footer__copy">
      <div class="footer__copyright-text">
        © <?php echo date('Y'); ?> srub-vladimir.ru — Все права защищены
      </div>
      <div class="footer__policy-row">
        <a href="/politika-konfidencialnosti" class="footer__policy-link">
          Политика конфиденциальности
        </a>
      </div>
    </div>

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Сруб-Владимир",
        "url": "https://srub-vladimir.ru",
        "logo": "<?php echo get_template_directory_uri(); ?>/img/logo.png",
        "image": "https://srub-vladimir.ru/wp-content/themes/srub-3/img/types/rubl-planed.jpg",
        "description": "Строительство деревянных домов из бревна ручной рубки во Владимире и Владимирской области с 1999 года. Срубы под ключ, гарантия по договору.",
        "telephone": "+7-910-77-88-999",
        "email": "srub.vladim@gmail.com",
        "foundingDate": "1999",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Владимир",
            "addressRegion": "Владимирская область",
            "addressCountry": "RU"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 56.1290,
            "longitude": 40.4066
        },
        "areaServed": [
            "Владимир",
            "Владимирская область",
            "Ковров",
            "Суздаль",
            "Муром",
            "Рязанская область",
            "Московская область",
            "Нижегородская область"
        ],
        "sameAs": [
            "https://t.me/doma_iz_brevna_vo_vladimire",
            "https://www.instagram.com/sruby_vladimir"
        ]
        }
    </script>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    if (!form) return; 

    const phoneInput = form.querySelector('input[type="tel"]');
    const nameInput = form.querySelector('input[type="text"]');

    if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
            let val = e.target.value.replace(/\D/g, '');
            if (val.startsWith('7') || val.startsWith('8')) val = val.slice(1);
            if (val.length === 0) { e.target.value = ''; return; }

            let formatted = '+7 (';
            if (val.length >= 1) formatted += val.slice(0, 3);
            if (val.length >= 4) formatted += ') ' + val.slice(3, 6);
            if (val.length >= 7) formatted += '-' + val.slice(6, 8);
            if (val.length >= 9) formatted += '-' + val.slice(8, 10);

            e.target.value = formatted;
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const name = nameInput ? nameInput.value.trim() : '';
        const phone = phoneInput ? phoneInput.value.trim() : '';
        const btn = form.querySelector('.btn--submit');
        
        if (!btn) return;

        const originalText = btn.textContent;
        btn.textContent = 'Отправка...';
        btn.disabled = true;

        try {
            const response = await fetch('<?php echo get_template_directory_uri(); ?>/send-mail.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ name: name, phone: phone, page_url: window.location.href })
            });

            const result = await response.json();
            
            if (result.success) {
                btn.textContent = '✓ Отправлено!';
                btn.style.background = '#4CAF50';
                btn.style.color = '#fff';
                form.reset();
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.disabled = false;
                }, 3000);
            } else {
                alert(result.message || 'Ошибка отправки');
                btn.textContent = originalText;
                btn.disabled = false;
            }
        } catch (error) {
            console.error(error);
            btn.textContent = originalText;
            btn.disabled = false;
        }
    });
});
</script>


<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Сколько стоит дом из сруба?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Стоимость зависит от диаметра бревна, площади дома, типа рубки и комплектации. В среднем дом из сруба под усадку начинается от 1,5–2,5 млн рублей, но точная цена рассчитывается индивидуально по проекту."
      }
    },
    {
      "@type": "Question",
      "name": "Что входит в стоимость сруба?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Обычно в стоимость входит: заготовка и обработка бревна, рубка сруба, доставка, сборка на участке. Фундамент, крыша и отделка рассчитываются отдельно, если не указано «под ключ»."
      }
    },
    {
      "@type": "Question",
      "name": "Сколько садится сруб дома?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Усадка сруба обычно составляет от 6 до 12 месяцев в зависимости от влажности древесины, диаметра бревна и сезона строительства."
      }
    },
    {
      "@type": "Question",
      "name": "Можно ли жить в доме сразу после строительства?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Нет, в большинстве случаев дом из бревна требует усадки. Но можно выполнить временную кровлю и черновые работы, чтобы начать отделку позже."
      }
    },
    {
      "@type": "Question",
      "name": "Строите ли вы зимой?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Да, строительство зимой даже предпочтительно, так как древесина меньше подвержена грибку и усадка проходит более равномерно."
      }
    },
    {
      "@type": "Question",
      "name": "Можно ли построить дом по своему проекту?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Да, мы работаем как по типовым, так и по индивидуальным проектам заказчика."
      }
    },
    {
      "@type": "Question",
      "name": "Нужно ли ждать усадку перед отделкой?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Да, полноценную отделку лучше начинать после основной усадки, обычно через 6–12 месяцев."
      }
    },
    {
      "@type": "Question",
      "name": "Работаете ли вы за пределами Владимира?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Да, мы строим дома и бани во Владимирской области и соседних регионах: Московской, Рязанской, Нижегородской областях."
      }
    }
  ]
}
</script>
<?php wp_footer(); ?>
</body>
</html>