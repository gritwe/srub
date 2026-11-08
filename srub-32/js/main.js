document.addEventListener('DOMContentLoaded', () => {

    const initHeader = () => {
        const navMenu = document.getElementById('nav-menu');
        const navToggle = document.getElementById('nav-toggle');
        const header = document.querySelector('.header');
        
        // --- Логика Бургера ---
        if (navToggle && navMenu) {
            navToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                navMenu.classList.toggle('show-menu');
                navToggle.classList.toggle('active');
                document.body.style.overflow = navMenu.classList.contains('show-menu') ? 'hidden' : '';
            });

            // Закрытие при клике вне меню
            document.addEventListener('click', (e) => {
                if (navMenu.classList.contains('show-menu') && 
                    !navMenu.contains(e.target) && 
                    !navToggle.contains(e.target)) {
                    closeMobileMenu();
                }
            });
        }

        const closeMobileMenu = () => {
            if(navMenu) navMenu.classList.remove('show-menu');
            if(navToggle) navToggle.classList.remove('active');
            document.body.style.overflow = '';
        };

        // --- Логика Выпадающих Меню (Умный клик) ---
        const dropdowns = document.querySelectorAll('.nav-item--dropdown');
        
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('.nav__link');
            const href = link.getAttribute('href');

            link.addEventListener('click', function(e) {
                // Работаем только на мобильных (<= 960px)
                if (window.innerWidth <= 960) {
                    e.preventDefault(); // Всегда предотвращаем переход сразу

                    const isOpen = dropdown.classList.contains('open');

                    // Закрываем другие открытые меню
                    dropdowns.forEach(other => {
                        if (other !== dropdown) other.classList.remove('open');
                    });

                    if (isOpen) {
                        // Если уже открыто -> закрываем И переходим по ссылке
                        dropdown.classList.remove('open');
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    } else {
                        // Если закрыто -> просто открываем
                        dropdown.classList.add('open');
                    }
                }
            });
        });

        // Эффект скролла хедера
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) header.classList.add('scrolled');
                else header.classList.remove('scrolled');
            }, { passive: true });
        }
    };



    /**
     * 2. ANIMATIONS (Intersection Observer)
     */
    const initAnimations = () => {
        const fadeEls = document.querySelectorAll(
            '.hero__badge, .hero__title, .hero__sub, .hero__actions, .hero__stats, ' +
            '.section__eyebrow, .section__title, ' +
            '.types__img-wrap, .types__text, ' +
            '.advantages__item, ' +
            '.steps__card, ' +
            '.contact__title, .contact__body'
        );

        if (fadeEls.length === 0) return;

        fadeEls.forEach(el => el.classList.add('fade-up'));

        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );

        fadeEls.forEach(el => revealObserver.observe(el));

        // Каскадная задержка для сеток
        document.querySelectorAll('.steps__grid, .advantages__grid').forEach(grid => {
            [...grid.children].forEach((child, i) => {
                child.style.transitionDelay = `${i * 0.1}s`;
            });
        });
    };

    /**
     * 3. SMOOTH SCROLL FOR ANCHORS
     */
    const initSmoothScroll = () => {
        const header = document.querySelector('.header');
        
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', e => {
                const targetId = link.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const headerHeight = header ? header.offsetHeight : 0;
                    const top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });
    };

    /**
     * 4. PHONE MASK & FORM HANDLING
     */
    const initForms = () => {
        // Универсальная функция маски
        const applyPhoneMask = (input) => {
            if (!input) return;
            
            const formatPhone = (value) => {
                let digits = value.replace(/\D/g, '');
                if (!digits) return '';
                if (['7', '8', '9'].indexOf(digits[0]) > -1) {
                    if (digits[0] === '9') digits = '7' + digits;
                    if (digits[0] === '8') digits = '7' + digits.slice(1);
                    digits = digits.substring(0, 11);
                }
                let formatted = '+7';
                let tail = digits.substring(1);
                if (tail.length > 0) formatted += ' (' + tail.substring(0, 3);
                if (tail.length >= 3) formatted += ') ' + tail.substring(3, 6);
                if (tail.length >= 6) formatted += '-' + tail.substring(6, 8);
                if (tail.length >= 8) formatted += '-' + tail.substring(8, 10);
                return formatted;
            };

            input.addEventListener('input', (e) => {
                const newVal = formatPhone(e.target.value);
                if (newVal !== e.target.value) e.target.value = newVal;
            });

            input.addEventListener('keydown', (e) => {
                if ([46, 8, 9, 27, 13, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 36)) return;
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        };

        // Обработчик отправки формы
        const handleFormSubmit = (form, successCallback) => {
            if (!form) return;
            
            const submitBtn = form.querySelector('button[type="submit"], .btn--submit');
            const originalText = submitBtn ? submitBtn.textContent.trim() : '';
            let isSubmitting = false;

            // Применяем маску к полю телефона в этой форме
            const phoneInput = form.querySelector('input[name="phone"], input[type="tel"]');
            applyPhoneMask(phoneInput);

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (isSubmitting) return;

                if (typeof srubAjax === 'undefined') {
                    alert('Ошибка конфигурации сайта.');
                    return;
                }

                const nameInput = form.querySelector('input[name="name"]');
                const nameVal = nameInput ? nameInput.value.trim() : '';
                const phoneVal = phoneInput ? phoneInput.value.trim() : '';

                if (!nameVal || !phoneVal) {
                    alert('Пожалуйста, заполните имя и телефон');
                    return;
                }
                if (phoneVal.length < 18) {
                    alert('Пожалуйста, введите корректный номер телефона');
                    return;
                }

                isSubmitting = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Отправка...';
                }

                const formData = new FormData();
                formData.append('action', 'srub_contact_form');
                formData.append('name', nameVal);
                formData.append('phone', phoneVal);
                formData.append('nonce', srubAjax.nonce);
                
                // Если есть скрытые поля (например, тема заявки)
                form.querySelectorAll('input[type="hidden"]').forEach(hidden => {
                    formData.append(hidden.name, hidden.value);
                });

                fetch(srubAjax.ajax_url, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (successCallback) successCallback(form);
                        else {
                            alert('Спасибо! Мы свяжемся с вами.');
                            form.reset();
                        }
                    } else {
                        throw new Error(data.data?.message || 'Ошибка');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Ошибка отправки. Попробуйте позже.');
                })
                .finally(() => {
                    isSubmitting = false;
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        };

        // Инициализация основной формы
        const mainForm = document.getElementById('contactForm');
        handleFormSubmit(mainForm);
    };

    /**
     * 5. MODAL LOGIC
     */
    const initModal = () => {
        const modal = document.getElementById('serviceModal');
        if (!modal) return;

        const openBtns = document.querySelectorAll('.js-open-modal');
        const closeBtn = modal.querySelector('.modal-close');
        const serviceInput = document.getElementById('modalServiceInput');
        const form = document.getElementById('modalServiceForm');

        const openModal = (serviceName = '') => {
            if (serviceName && serviceInput) serviceInput.value = serviceName;
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
            const messageBox = form ? form.querySelector('.form-message') : null;
            if(messageBox) messageBox.textContent = '';
        };

        openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(btn.getAttribute('data-project') || btn.getAttribute('data-service') || '');
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
        });

        // Обработка формы внутри модалки
        if (form) {
            // Успешная отправка закрывает модалку
            const onSuccess = () => {
                form.reset();
                const messageBox = form.querySelector('.form-message');
                if(messageBox) {
                    messageBox.textContent = 'Спасибо! Заявка отправлена.';
                    messageBox.style.color = '#27ae60';
                }
                setTimeout(closeModal, 2000);
            };
            
            // Переиспользуем логику форм, но с коллбеком
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            
            // Применяем маску (функция уже объявлена выше, но так как она внутри initForms, 
            // нам нужно либо вынести её глобально, либо продублировать логику. 
            // Для чистоты кода я вызову applyPhoneMask локально здесь снова или просто полагаюсь на то, 
            // что initForms вызовется раньше. Но лучше сделать функцию маски доступной.
            // В данном случае, так как JS выполняется последовательно, initForms уже определил applyPhoneMask? 
            // Нет, она внутри замыкания. Поэтому продублируем простую маску здесь для надежности.
            
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
                if (typeof srubAjax === 'undefined') return;
                
                const formData = new FormData(form);
                formData.append('action', 'srub_contact_form');
                formData.append('nonce', srubAjax.nonce);

                if(submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Отправка...';
                }

                fetch(srubAjax.ajax_url, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if(data.success) onSuccess();
                    else alert('Ошибка сервера');
                })
                .catch(() => alert('Ошибка сети'))
                .finally(() => {
                    if(submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        }
    };

    /**
     * 6. FAQ ACCORDION
     */
    const initFAQ = () => {
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const qBtn = item.querySelector('.faq-question');
            const aBox = item.querySelector('.faq-answer');

            if (qBtn && aBox) {
                qBtn.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Закрываем остальные (аккордеон)
                    faqItems.forEach(other => {
                        if (other !== item && other.classList.contains('active')) {
                            other.classList.remove('active');
                            const otherAns = other.querySelector('.faq-answer');
                            if(otherAns) otherAns.style.maxHeight = null;
                        }
                    });

                    if (isActive) {
                        item.classList.remove('active');
                        aBox.style.maxHeight = null;
                    } else {
                        item.classList.add('active');
                        aBox.style.maxHeight = aBox.scrollHeight + "px";
                    }
                });
            }
        });
    };

    /**
     * 7. PROJECTS SLIDER
     */
        /**
     * 7. PROJECTS SLIDER (ИСПРАВЛЕННАЯ ВЕРСИЯ С КЛОНИРОВАНИЕМ)
     */
    const initSlider = () => {
        const slider = document.getElementById('projectsSlider');
        if (!slider) return;

        const outer = slider.closest('.projects-slider-outer');
        const prevBtn = outer?.querySelector('.ps-arrow--prev');
        const nextBtn = outer?.querySelector('.ps-arrow--next');

        let origCards = []; // Оригинальные данные
        let total = 0;      // Количество оригинальных данных
        let perView = getPerView();
        let cardW = 0;
        
        // Текущий индекс (начинаем с клонов или 0)
        let current = 0; 
        let isAnimating = false;
        let autoTimer = null;
        
        // Drag variables
        let dragDX = 0;
        let startX = 0;
        let isDragging = false;

        function getPerView() {
            if (window.innerWidth <= 640) return 1;
            if (window.innerWidth <= 960) return 2;
            return 3;
        }

        function calcCardW() {
            const card = slider.querySelector('.ps-card');
            if (!card) return 0;
            // Учитываем gap из CSS (обычно 24px или 30px)
            const style = window.getComputedStyle(slider);
            const gap = parseFloat(style.gap) || 24; 
            return card.offsetWidth + gap;
        }

        function renderCard(item) {
            const article = document.createElement('article');
            article.className = 'ps-card';
            // Важно: добавляем data-id, чтобы отличать клоны
            article.dataset.id = item.id; 
            article.innerHTML = `
                <div class="ps-card__img-wrap">
                    <img src="${item.thumb}" alt="${item.title}" width="400" height="300" loading="lazy">
                </div>
                <div class="ps-card__body">
                    <h3 class="ps-card__title">${item.title}</h3>
                    <p class="ps-card__desc">${item.excerpt}</p>
                    ${item.price ? `<p class="ps-card__price">${item.price}</p>` : ''}
                    <div class="ps-card__actions">
                        <a href="${item.url}" class="btn btn--outline">Подробнее</a>
                    </div>
                </div>
            `;
            return article;
        }

        function buildSlider(data) {
            if (!data || data.length === 0) return;
            
            origCards = data;
            total = origCards.length;
            slider.innerHTML = '';
            
            // 1. Рендерим ОРИГИНАЛЬНЫЕ карточки
            origCards.forEach(item => slider.appendChild(renderCard(item)));

            // 2. Рендерим КЛОНЫ (копии первых элементов) в конец
            // Клонируем столько элементов, сколько помещается на экран (perView), 
            // чтобы обеспечить плавный переход назад в начало.
            const clonesCount = Math.min(perView, total); 
            for (let i = 0; i < clonesCount; i++) {
                const cloneItem = origCards[i];
                const cloneNode = renderCard(cloneItem);
                cloneNode.classList.add('ps-card--clone'); // Метка, что это клон
                slider.appendChild(cloneNode);
            }

            cardW = calcCardW();
            
            // Начинаем с первой реальной карточки (индекс 0)
            current = 0;
            setPosition(current, false);
            
            updateArrows();

            if (prevBtn) prevBtn.onclick = () => { prev(); resetAuto(); };
            if (nextBtn) nextBtn.onclick = () => { next(); resetAuto(); };
            
            startAuto();
        }

        function setPosition(index, animate) {
            slider.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
            slider.style.transform = `translateX(-${index * cardW}px)`;
        }

        function updateArrows() {
            // Опционально: можно скрывать стрелки, если слайдов мало
            // Но с клонами лучше оставить всегда активными для бесконечности
        }

        function next() {
            if (isAnimating) return;
            isAnimating = true;
            
            current++;
            setPosition(current, true);

            // Ждем окончания анимации
            const onEnd = () => {
                slider.removeEventListener('transitionend', onEnd);
                isAnimating = false;

                // Если мы дошли до клонов (конец списка)
                if (current >= total) {
                    // Мгновенно (без анимации) прыгаем на реальный старт
                    current = 0;
                    setPosition(current, false);
                }
            };
            slider.addEventListener('transitionend', onEnd);
        }

        function prev() {
            if (isAnimating) return;
            
            // Если мы на самом начале (0), нужно сначала прынуть на клоны в конце
            if (current === 0) {
                current = total; // Прыгаем на позицию клонов
                setPosition(current, false);
                
                // Небольшая задержка, чтобы браузер успел отрисовать прыжок без анимации
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        isAnimating = true;
                        current--;
                        setPosition(current, true);
                        
                        const onEnd = () => {
                            slider.removeEventListener('transitionend', onEnd);
                            isAnimating = false;
                        };
                        slider.addEventListener('transitionend', onEnd);
                    });
                });
            } else {
                isAnimating = true;
                current--;
                setPosition(current, true);
                
                const onEnd = () => {
                    slider.removeEventListener('transitionend', onEnd);
                    isAnimating = false;
                };
                slider.addEventListener('transitionend', onEnd);
            }
        }
        function startAuto() { 
            // Убрали проверку if (total > perView), теперь крутится всегда
            autoTimer = setInterval(next, 4000); 
        }
        function stopAuto() { clearInterval(autoTimer); }
        function resetAuto() { stopAuto(); startAuto(); }

        // --- DRAG LOGIC (Упрощенная и надежная) ---
        slider.addEventListener('mousedown', e => {
            isDragging = true; 
            startX = e.clientX; 
            dragDX = 0;
            slider.style.cursor = 'grabbing';
            stopAuto();
        });

        window.addEventListener('mousemove', e => {
            if (!isDragging) return;
            e.preventDefault(); // Предотвращаем выделение текста
            dragDX = e.clientX - startX;
            // Двигаем слайдер вслед за мышью
            slider.style.transition = 'none';
            slider.style.transform = `translateX(${-(current * cardW) + dragDX}px)`;
        });

        window.addEventListener('mouseup', () => {
            if (!isDragging) return;
            isDragging = false;
            slider.style.cursor = '';

            // Логика свайпа: если протащили больше 50px
            if (dragDX < -50) {
                next();
            } else if (dragDX > 50) {
                prev();
            } else {
                // Возврат на место
                setPosition(current, true);
            }
            resetAuto();
        });

        // Touch events для мобильных
        slider.addEventListener('touchstart', e => {
            startX = e.touches[0].clientX;
            stopAuto();
        }, { passive: true });

        slider.addEventListener('touchmove', e => {
            const touchX = e.touches[0].clientX;
            dragDX = touchX - startX;
            slider.style.transition = 'none';
            slider.style.transform = `translateX(${-(current * cardW) + dragDX}px)`;
        }, { passive: true });

        slider.addEventListener('touchend', e => {
            if (dragDX < -50) next();
            else if (dragDX > 50) prev();
            else setPosition(current, true);
            resetAuto();
        });

        // Resize Handler
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newPer = getPerView();
                if (newPer !== perView) {
                    perView = newPer;
                    // Пересобираем слайдер заново, чтобы обновить количество клонов
                    buildSlider(origCards);
                } else {
                    // Просто обновляем ширину
                    cardW = calcCardW();
                    setPosition(current, false);
                }
            }, 200);
        });

        // Load Data via AJAX
        if (typeof srubAjax !== 'undefined') {
            // Создаём AbortController для принудительного обрыва через 3 сек
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 3000);

            fetch(srubAjax.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'srub_random_slider', nonce: srubAjax.nonce }),
                signal: controller.signal
            })
            .then(r => r.json())
            .then(data => {
                clearTimeout(timeoutId); // Отменяем таймаут при успехе
                if (data.success && Array.isArray(data.data)) {
                    buildSlider(data.data);
                }
            })
            .catch(err => {
                clearTimeout(timeoutId);
                console.warn('Slider load skipped:', err.name === 'AbortError' ? 'Timeout (blocked?)' : err);
                // Слайдер просто не загрузится, но страница НЕ зависнет
            });
        }
    };

    // ==========================================
    // INITIALIZATION
    // ==========================================
    initHeader();
    initAnimations();
    initSmoothScroll();
    initForms();
    initModal();
    initFAQ();
    initSlider();



    
});