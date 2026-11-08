document.addEventListener('DOMContentLoaded', () => {

  // ==========================================
  // 1. АНИМАЦИИ (FADE UP)
  // ==========================================
  const targets = document.querySelectorAll(
    '.svc__img-wrap, .svc__num, .svc__title, .svc__desc, .svc__specs, .svc__btn, .svc-card'
  );

  targets.forEach(el => el.classList.add('fade-up'));

  document.querySelectorAll('.svc-card').forEach((el, i) => {
    el.style.transitionDelay = `${i * 0.12}s`;
  });

  document.querySelectorAll('.svc__specs').forEach(specs => {
    [...specs.querySelectorAll('.svc__spec-row')].forEach((row, i) => {
      row.classList.add('fade-up');
      row.style.transitionDelay = `${i * 0.07}s`;
    });
  });

  const observer = new IntersectionObserver(
    entries => entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    }),
    { threshold: 0.1, rootMargin: '0px 0px -24px 0px' }
  );

  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));


  // ==========================================
  // 2. HEADER SCROLL
  // ==========================================
  const header = document.querySelector('.header');
  const onScroll = () => {
    if(header) {
        header.classList.toggle('scrolled', window.scrollY > 40);
    }
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();


  // ==========================================
  // 3. SMOOTH SCROLL (Якоря)
  // ==========================================
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const targetId = link.getAttribute('href');
      if (targetId === '#') return;
      
      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 80;
        const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });


  // ==========================================
  // 4. MODAL WINDOW & FORM LOGIC
  // ==========================================
  const modal = document.getElementById('serviceModal');
  
  if (modal) {
      const openBtns = document.querySelectorAll('.js-open-modal');
      const closeBtn = modal.querySelector('.modal-close');
      const serviceInput = document.getElementById('modalServiceInput');
      const form = document.getElementById('modalServiceForm');
      const messageBox = form ? form.querySelector('.form-message') : null;

      // Открытие модалки
      const openModal = (serviceName = '') => {
          if (serviceName && serviceInput) {
              serviceInput.value = serviceName;
          }
          modal.classList.add('is-active');
          modal.setAttribute('aria-hidden', 'false');
          document.body.style.overflow = 'hidden';
          
          setTimeout(() => {
              const firstInput = modal.querySelector('input:not([type="hidden"])');
              if(firstInput) firstInput.focus();
          }, 100);
      };

      // Закрытие модалки
      const closeModal = () => {
          modal.classList.remove('is-active');
          modal.setAttribute('aria-hidden', 'true');
          document.body.style.overflow = '';
          if(messageBox) messageBox.textContent = '';
      };

      // Обработчики кнопок открытия
      openBtns.forEach(btn => {
          btn.addEventListener('click', (e) => {
              e.preventDefault();
              const serviceName = btn.getAttribute('data-project') || '';
              openModal(serviceName);
          });
      });

      // Закрытие по крестику, фону и Esc
      if (closeBtn) closeBtn.addEventListener('click', closeModal);
      modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
      document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
      });

      // Маска телефона
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

      // ОТПРАВКА ФОРМЫ
      if (form) {
          form.addEventListener('submit', function(e) {
              e.preventDefault();
              
              const submitBtn = form.querySelector('.btn--submit');
              if(!submitBtn) return;

              const originalText = submitBtn.textContent;
              
              // Блокируем кнопку
              submitBtn.disabled = true;
              submitBtn.textContent = 'Отправка...';
              if(messageBox) {
                  messageBox.textContent = '';
                  messageBox.style.color = '';
              }

              const formData = new FormData(form);
              // ВАЖНО: Добавляем action
              formData.append('action', 'srub_contact_form');
              
              // ВАЖНО: Добавляем nonce из глобальной переменной srubAjax
              if (typeof srubAjax !== 'undefined' && srubAjax.nonce) {
                  formData.append('nonce', srubAjax.nonce);
              } else {
                  console.warn('srubAjax.nonce is missing. Check wp_localize_script in functions.php');
              }

              // Проверка наличия URL
              if (typeof srubAjax === 'undefined' || !srubAjax.ajax_url) {
                  console.error('AJAX URL not defined');
                  if(messageBox) {
                      messageBox.textContent = 'Ошибка конфигурации сайта.';
                      messageBox.style.color = 'red';
                  }
                  submitBtn.disabled = false;
                  submitBtn.textContent = originalText;
                  return;
              }

              fetch(srubAjax.ajax_url, {
                  method: 'POST',
                  body: formData
              })
              .then(response => {
                  // Сначала проверяем статус HTTP
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(data => {
                  if (data.success) {
                      if(messageBox) {
                          messageBox.textContent = data.data.message || 'Спасибо! Заявка отправлена.';
                          messageBox.style.color = '#27ae60';
                      }
                      form.reset();
                      
                      setTimeout(() => {
                          closeModal();
                          submitBtn.disabled = false;
                          submitBtn.textContent = originalText;
                          if(messageBox) messageBox.textContent = '';
                      }, 2500);
                  } else {
                      // Если сервер вернул ошибку (например, неверный nonce)
                      throw new Error(data.data.message || 'Ошибка сервера');
                  }
              })
              .catch(error => {
                  console.error('Fetch Error:', error);
                  if(messageBox) {
                      messageBox.textContent = error.message || 'Произошла ошибка. Попробуйте позже.';
                      messageBox.style.color = '#e74c3c';
                  }
                  submitBtn.disabled = false;
                  submitBtn.textContent = originalText;
              });
          });
      }
  }
});