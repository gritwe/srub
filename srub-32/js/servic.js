document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 0. ЛОГИКА FADE СЛАЙДЕРА В HERO
    // ==========================================
    const fadeSlider = document.querySelector('.hero-fade-slider');
    
    if (fadeSlider) {
        console.log('Слайдер найден!'); // Проверка в консоли браузера (F12)
        const slides = fadeSlider.querySelectorAll('.fade-slide');
        
        if (slides.length > 1) {
            let currentSlide = 0;
            
            setInterval(() => {
                // Убираем класс active у текущего слайда
                slides[currentSlide].classList.remove('active');
                
                // Вычисляем индекс следующего слайда
                currentSlide = (currentSlide + 1) % slides.length;
                
                // Добавляем класс active следующему слайду
                slides[currentSlide].classList.add('active');
            }, 2500); // Интервал 4 секунды
        } else {
            console.log('Слайдов меньше 2, автопереключение отключено.');
        }
    } else {
        console.error('Ошибка: Элемент .hero-fade-slider не найден в HTML!');
    }

    // ==========================================
    // 1. ЛОГИКА СЛАЙДЕРА ПРОЕКТОВ
    // ==========================================
    const section = document.querySelector('.service-slider-section');
    
    if (section) {
        const track = section.querySelector('.service-slider-track');
        const outer = section.querySelector('.service-slider-outer');
        const prevBtn = section.querySelector('.ps-arrow--prev');
        const nextBtn = section.querySelector('.ps-arrow--next');
        const dotsContainer = section.querySelector('.service-slider-dots');

        if (track && outer) {
            let originalSlides = Array.from(track.querySelectorAll('.service-slide-card'));
            
            if (originalSlides.length >= 2) {
                const gap = 24; 
                let slideWidth = 0;
                let currentIndex = 0;
                let isTransitioning = false;
                let autoPlayInterval;
                const clonesCount = 3;

                // Клонирование слайдов для бесконечной прокрутки
                originalSlides.slice(0, clonesCount).forEach(slide => {
                    const clone = slide.cloneNode(true);
                    clone.classList.add('ps-card--clone');
                    track.appendChild(clone);
                });

                originalSlides.slice(-clonesCount).reverse().forEach(slide => {
                    const clone = slide.cloneNode(true);
                    clone.classList.add('ps-card--clone');
                    track.insertBefore(clone, track.firstChild);
                });

                const allSlides = track.querySelectorAll('.service-slide-card');
                const realSlidesCount = originalSlides.length;
                currentIndex = clonesCount;

                const updateDimensions = () => {
                    if(allSlides.length > 0) {
                        slideWidth = allSlides[0].getBoundingClientRect().width + gap;
                        setSliderPosition(currentIndex, false);
                    }
                };

                const setSliderPosition = (index, withTransition = true) => {
                    track.style.transition = withTransition ? 'transform 0.5s ease-in-out' : 'none';
                    const offset = -(index * slideWidth);
                    track.style.transform = `translateX(${offset}px)`;
                    currentIndex = index;
                };

                const handleTransitionEnd = () => {
                    isTransitioning = false;
                    if (currentIndex >= realSlidesCount + clonesCount) {
                        setSliderPosition(currentIndex - realSlidesCount, false);
                    } else if (currentIndex < clonesCount) {
                        setSliderPosition(currentIndex + realSlidesCount, false);
                    }
                    updateDots();
                };

                track.addEventListener('transitionend', handleTransitionEnd);

                const nextSlide = () => {
                    if (isTransitioning) return;
                    isTransitioning = true;
                    setSliderPosition(currentIndex + 1, true);
                    resetAutoPlay();
                };

                const prevSlide = () => {
                    if (isTransitioning) return;
                    isTransitioning = true;
                    setSliderPosition(currentIndex - 1, true);
                    resetAutoPlay();
                };

                if (nextBtn) nextBtn.addEventListener('click', (e) => { e.preventDefault(); nextSlide(); });
                if (prevBtn) prevBtn.addEventListener('click', (e) => { e.preventDefault(); prevSlide(); });

                const createDots = () => {
                    if (!dotsContainer) return;
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < realSlidesCount; i++) {
                        const dot = document.createElement('button');
                        dot.classList.add('ps-dot');
                        dot.addEventListener('click', () => {
                            if (isTransitioning) return;
                            isTransitioning = true;
                            setSliderPosition(i + clonesCount, true);
                            resetAutoPlay();
                        });
                        dotsContainer.appendChild(dot);
                    }
                };

                const updateDots = () => {
                    if (!dotsContainer) return;
                    let virtualIndex = currentIndex - clonesCount;
                    if (virtualIndex < 0) virtualIndex = realSlidesCount - 1;
                    if (virtualIndex >= realSlidesCount) virtualIndex = 0;
                    const dots = dotsContainer.querySelectorAll('.ps-dot');
                    dots.forEach((dot, idx) => {
                        dot.classList.toggle('active', idx === virtualIndex);
                    });
                };

                createDots();
                updateDots();

                const startAutoPlay = () => {
                    clearInterval(autoPlayInterval);
                    autoPlayInterval = setInterval(nextSlide, 5000);
                };
                const resetAutoPlay = () => {
                    clearInterval(autoPlayInterval);
                    startAutoPlay();
                };

                window.addEventListener('resize', updateDimensions);
                setTimeout(() => { updateDimensions(); startAutoPlay(); }, 100);
                outer.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
                outer.addEventListener('mouseleave', startAutoPlay);
            }
        }
    }

    // ==========================================
    // 2. ЛОГИКА МОДАЛЬНОГО ОКНА
    // ==========================================
    const modal = document.getElementById('serviceModal');
    
    if (modal) {
        const openBtns = document.querySelectorAll('.js-open-modal');
        const closeBtn = modal.querySelector('.modal-close');
        const serviceInput = document.getElementById('modalServiceInput');
        const form = document.getElementById('modalServiceForm');
        const messageBox = form.querySelector('.form-message');

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
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
        });

        const phoneInput = form.querySelector('input[type="tel"]');
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

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('.btn--submit');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Отправка...';
            messageBox.textContent = '';

            const formData = new FormData(form);
            formData.append('action', 'srub_contact_form'); 

            if (typeof srubAjax === 'undefined' || !srubAjax.ajax_url) {
                console.error('AJAX URL not defined');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Ошибка';
                return;
            }

            fetch(srubAjax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageBox.textContent = 'Спасибо! Заявка отправлена.';
                    messageBox.style.color = '#27ae60';
                    form.reset();
                    setTimeout(() => {
                        closeModal();
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                        messageBox.textContent = '';
                    }, 2000);
                } else {
                    throw new Error(data.data || 'Ошибка сервера');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageBox.textContent = 'Ошибка. Попробуйте позже.';
                messageBox.style.color = '#e74c3c';
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }

    const miniSliders = document.querySelectorAll('.fade-slider-mini');
    
    miniSliders.forEach((slider) => {
        const slides = slider.querySelectorAll('.fade-slide-mini');
        
        if (slides.length > 1) {
            let currentSlide = 0;
            
            // Каждый слайдер получает свой собственный интервал
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 3500); // Смена каждые 3.5 секунды (чуть быстрее главного)
        }
    });
});