document.addEventListener('DOMContentLoaded', () => {

  /* =============================================
     GALLERY SLIDER
     ============================================= */
  const imgs    = document.querySelectorAll('.project-gallery__img');
  const dots    = document.querySelectorAll('.project-gallery__dot');
  const prev    = document.querySelector('.project-gallery__arrow--prev');
  const next    = document.querySelector('.project-gallery__arrow--next');
  const counter = document.querySelector('.project-gallery__counter');

  let current = 0;
  const total = imgs.length;

  function setSlide(idx) {
    if (total === 0) return;
    imgs[current].classList.remove('active');
    if (dots[current]) dots[current].classList.remove('active');
    current = (idx + total) % total;
    imgs[current].classList.add('active');
    if (dots[current]) dots[current].classList.add('active');
    if (counter) counter.textContent = `${current + 1} / ${total}`;
  }

  if (prev) prev.addEventListener('click', () => setSlide(current - 1));
  if (next) next.addEventListener('click', () => setSlide(current + 1));
  dots.forEach((dot, i) => dot.addEventListener('click', () => setSlide(i)));

  // Swipe support
  const gallery = document.querySelector('.project-gallery');
  if (gallery && total > 1) {
    let startX = 0;
    gallery.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    gallery.addEventListener('touchend', e => {
      const diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) setSlide(current + (diff > 0 ? 1 : -1));
    }, { passive: true });
  }

  // Keyboard support
  document.addEventListener('keydown', e => {
    const modalActive = document.getElementById('serviceModal')?.classList.contains('is-active');
    if (modalActive) return;
    if (e.key === 'ArrowLeft')  setSlide(current - 1);
    if (e.key === 'ArrowRight') setSlide(current + 1);
  });

  /* =============================================
     MODAL
     ============================================= */
  const modal     = document.getElementById('serviceModal');
  const modalForm = document.getElementById('modalServiceForm');
  const modalInput = document.getElementById('modalServiceInput');
  const modalTitle = document.getElementById('modalProjectTitle');

  if (modal) {
    const openBtns = document.querySelectorAll('.js-open-modal');
    const closeBtn  = document.querySelector('.modal-close');

    const openModal = (projectName = '') => {
      if (modalTitle) {
        modalTitle.textContent = projectName
          ? `Заказать проект: ${projectName}`
          : 'Заказать строительство дома';
      }
      if (modalInput) modalInput.value = projectName;

      modal.classList.add('is-active');
      modal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('modal-open');

      const firstInput = modal.querySelector('input:not([type="hidden"])');
      if (firstInput) setTimeout(() => firstInput.focus(), 120);
    };

    const closeModal = () => {
      modal.classList.remove('is-active');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('modal-open');
    };

    openBtns.forEach(btn => {
      btn.addEventListener('click', e => {
        e.preventDefault();
        openModal(btn.getAttribute('data-project') || '');
      });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', e => {
      if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
    });

    /* =============================================
       FORM SUBMISSION
       ============================================= */
    if (modalForm) {

      // Phone formatting
      const phoneInput = modalForm.querySelector('input[type="tel"]');
      if (phoneInput) {
        phoneInput.addEventListener('input', function () {
          let val = this.value.replace(/\D/g, '');
          if (val.startsWith('7') || val.startsWith('8')) val = val.slice(1);
          if (val.length === 0) { this.value = ''; return; }

          let formatted = '+7 (';
          if (val.length >= 1) formatted += val.slice(0, 3);
          if (val.length >= 4) formatted += ') ' + val.slice(3, 6);
          if (val.length >= 7) formatted += '-' + val.slice(6, 8);
          if (val.length >= 9) formatted += '-' + val.slice(8, 10);
          this.value = formatted;
        });
      }

      modalForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = modalForm.querySelector('.modal-btn');
        const originalText = btn.textContent;

        let messageBox = modalForm.querySelector('.form-message');
        if (!messageBox) {
          messageBox = document.createElement('div');
          messageBox.className = 'form-message';
          modalForm.appendChild(messageBox);
        }

        const nameVal    = (modalForm.querySelector('[name="name"]')?.value || '').trim();
        const phoneVal   = (modalForm.querySelector('[name="phone"]')?.value || '').trim();
        const projectVal = (modalForm.querySelector('[name="service_name"]')?.value || '').trim();

        // Validation
        if (!phoneVal) {
          messageBox.textContent = 'Укажите номер телефона';
          messageBox.style.color = '#e74c3c';
          phoneInput?.focus();
          return;
        }

        btn.disabled = true;
        btn.textContent = 'Отправка...';
        messageBox.textContent = '';

        if (typeof srubAjax === 'undefined' || !srubAjax.ajax_url) {
          console.error('srubAjax not defined');
          btn.disabled = false;
          btn.textContent = originalText;
          messageBox.textContent = 'Ошибка конфигурации. Позвоните нам напрямую.';
          messageBox.style.color = '#e74c3c';
          return;
        }

        const formData = new FormData();
        formData.append('action', 'srub_contact_form');
        formData.append('name', nameVal);
        formData.append('phone', phoneVal);
        formData.append('project_subject', projectVal);

        fetch(srubAjax.ajax_url, {
          method: 'POST',
          body: formData,
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              btn.textContent = 'Отправлено!';
              btn.style.background = '#27ae60';
              modalForm.reset();
              messageBox.textContent = 'Спасибо! Мы свяжемся с вами в течение часа.';
              messageBox.style.color = '#27ae60';

              setTimeout(() => {
                closeModal();
                setTimeout(() => {
                  btn.textContent = originalText;
                  btn.style.background = '';
                  btn.disabled = false;
                  messageBox.textContent = '';
                }, 400);
              }, 2200);
            } else {
              throw new Error(data.data || 'Ошибка сервера');
            }
          })
          .catch(err => {
            console.error(err);
            btn.textContent = 'Ошибка';
            messageBox.textContent = 'Попробуйте позже или позвоните нам';
            messageBox.style.color = '#e74c3c';
            setTimeout(() => {
              btn.textContent = originalText;
              btn.disabled = false;
            }, 3000);
          });
      });
    }
  }

  /* =============================================
     FAQ ACCORDION
     ============================================= */
  document.querySelectorAll('.faq-item__q').forEach(btn => {
    btn.addEventListener('click', () => {
      const item   = btn.closest('.faq-item');
      const answer = item.querySelector('.faq-item__a');
      const isOpen = item.classList.contains('faq-item--open');

      // Close all
      document.querySelectorAll('.faq-item').forEach(el => {
        el.classList.remove('faq-item--open');
        el.querySelector('.faq-item__q').setAttribute('aria-expanded', 'false');
        el.querySelector('.faq-item__a').hidden = true;
      });

      // Open clicked (if was closed)
      if (!isOpen) {
        item.classList.add('faq-item--open');
        btn.setAttribute('aria-expanded', 'true');
        answer.hidden = false;
      }
    });
  });

  /* =============================================
     STICKY HEADER SCROLL
     ============================================= */
  const header = document.getElementById('site-header');
  if (header) {
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
  }

});