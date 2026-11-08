document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // ЛОГИКА МОДАЛЬНОГО ОКНА (ЗАКАЗ УСЛУГИ)
    // ==========================================
    const initModal = () => {
        const modal = document.getElementById('serviceModal');
        if (!modal) return; 

        const openBtns = document.querySelectorAll('.js-open-modal');
        const closeBtn = modal.querySelector('.modal-close');
        const serviceInput = document.getElementById('modalServiceInput');
        const form = document.getElementById('modalServiceForm');
        const messageBox = form ? form.querySelector('.form-message') : null;

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

        const closeModal = () => {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if(messageBox) messageBox.textContent = '';
        };

        openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const serviceName = btn.getAttribute('data-project') || '';
                openModal(serviceName);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        
        modal.addEventListener('click', (e) => { 
            if (e.target === modal) closeModal(); 
        });

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

    };

    // ==========================================
    // ЛОГИКА ЛАЙТБОКСА ГАЛЕРЕИ
    // ==========================================
    const initGalleryLightbox = () => {
        const lightbox = document.getElementById('galleryLightbox');
        if (!lightbox) return;

        const galleryItems = document.querySelectorAll('.js-gallery-item');
        if (galleryItems.length === 0) return;

        const closeBtn = lightbox.querySelector('.gallery-lightbox__close');
        const prevBtn = lightbox.querySelector('.gallery-lightbox__prev');
        const nextBtn = lightbox.querySelector('.gallery-lightbox__next');
        const image = lightbox.querySelector('.gallery-lightbox__image');
        const counter = lightbox.querySelector('.gallery-lightbox__counter');
        const caption = lightbox.querySelector('.gallery-lightbox__caption');

        let currentIndex = 0;
        let imagesData = [];

        // Собираем данные о всех изображениях
        galleryItems.forEach((item, index) => {
            const img = item.querySelector('img');
            if (img) {
                imagesData.push({
                    src: img.src,
                    alt: img.alt
                });
            }

            // Добавляем обработчик клика на элемент галереи
            item.addEventListener('click', () => {
                openLightbox(index);
            });
        });

        const openLightbox = (index) => {
            currentIndex = index;
            updateLightboxContent();
            lightbox.classList.add('is-active');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        const closeLightbox = () => {
            lightbox.classList.remove('is-active');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const updateLightboxContent = () => {
            if (imagesData[currentIndex]) {
                image.src = imagesData[currentIndex].src;
                image.alt = imagesData[currentIndex].alt;
                counter.textContent = `${currentIndex + 1} / ${imagesData.length}`;
                caption.textContent = imagesData[currentIndex].alt;
            }
        };

        const showNext = () => {
            currentIndex = (currentIndex + 1) % imagesData.length;
            updateLightboxContent();
        };

        const showPrev = () => {
            currentIndex = (currentIndex - 1 + imagesData.length) % imagesData.length;
            updateLightboxContent();
        };

        // Обработчики событий
        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (nextBtn) nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            showNext();
        });
        if (prevBtn) prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            showPrev();
        });

        // Закрытие по клику на фон
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.classList.contains('gallery-lightbox__content')) {
                closeLightbox();
            }
        });

        // Навигация с клавиатуры
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('is-active')) return;

            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowRight') {
                showNext();
            } else if (e.key === 'ArrowLeft') {
                showPrev();
            }
        });

        // Свайп для мобильных устройств
        let touchStartX = 0;
        let touchEndX = 0;

        lightbox.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        lightbox.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        const handleSwipe = () => {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    showNext(); // Свайп влево - следующее фото
                } else {
                    showPrev(); // Свайп вправо - предыдущее фото
                }
            }
        };
    };

    // Запускаем обе функции
    initModal();
    initGalleryLightbox();
});