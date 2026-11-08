document.addEventListener('DOMContentLoaded', () => {

    /* ─────────────────────────────────────────
       Состояние
    ───────────────────────────────────────── */
    const grid       = document.getElementById('projectsGrid');
    const pagination = document.getElementById('paginationWrapper');

    if (!grid) return;

    let currentFilter = 'all';
    let currentPage   = 1;

    /* ─────────────────────────────────────────
       Отрисовка пагинации
    ───────────────────────────────────────── */
    function renderPagination(maxPages, activePage) {
        if (!pagination) return;

        if (maxPages <= 1) {
            pagination.innerHTML = '';
            return;
        }

        let html = '<nav class="pagination" aria-label="Навигация по страницам"><ul>';

        // Кнопка «назад»
        if (activePage > 1) {
            html += `<li><a class="page-numbers prev" data-page="${activePage - 1}" href="#" aria-label="Предыдущая">&larr;</a></li>`;
        }

        // Номера страниц с ellipsis
        const delta = 2; // сколько страниц показывать вокруг текущей
        for (let i = 1; i <= maxPages; i++) {
            const isEdge   = i === 1 || i === maxPages;
            const isNear   = Math.abs(i - activePage) <= delta;

            if (isEdge || isNear) {
                html += `<li><a class="page-numbers${i === activePage ? ' current' : ''}" data-page="${i}" href="#">${i}</a></li>`;
            } else if (
                (i === activePage - delta - 1 && i > 1) ||
                (i === activePage + delta + 1 && i < maxPages)
            ) {
                html += `<li><span class="page-numbers dots">&hellip;</span></li>`;
            }
        }

        // Кнопка «вперёд»
        if (activePage < maxPages) {
            html += `<li><a class="page-numbers next" data-page="${activePage + 1}" href="#" aria-label="Следующая">&rarr;</a></li>`;
        }

        html += '</ul></nav>';
        pagination.innerHTML = html;

        // Обработчики кликов по пагинации
        pagination.querySelectorAll('[data-page]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                const page = parseInt(a.dataset.page, 10);
                if (page === currentPage) return;
                currentPage = page;
                fetchProjects(currentFilter, currentPage);
            });
        });
    }

    /* ─────────────────────────────────────────
       Переподключение кнопок модалки
       (вызывается после перерисовки грида)
    ───────────────────────────────────────── */
    function reBindModalButtons() {
        const modal      = document.getElementById('orderModal');
        const modalTitle = document.getElementById('modalProjectTitle');
        const modalInput = document.getElementById('modalProjectInput');

        if (!modal) return;

        const openModal = (projectName = '') => {
            if (modalTitle) {
                modalTitle.textContent = projectName
                    ? `Заказать проект: ${projectName}`
                    : 'Заказать строительство дома';
            }
            if (modalInput) modalInput.value = projectName;
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        grid.querySelectorAll('.js-open-modal').forEach(btn => {
            // Чтобы не плодить дубли, клонируем узел
            const fresh = btn.cloneNode(true);
            btn.parentNode.replaceChild(fresh, btn);

            fresh.addEventListener('click', e => {
                e.preventDefault();
                openModal(fresh.dataset.project || '');
            });
        });
    }

    /* ─────────────────────────────────────────
       AJAX-запрос к серверу
    ───────────────────────────────────────── */
    function fetchProjects(category, paged) {
        // Плавное затемнение во время загрузки
        grid.style.opacity     = '0.4';
        grid.style.pointerEvents = 'none';

        if (typeof srubAjax === 'undefined' || !srubAjax.ajax_url) {
            console.error('srubAjax не определён');
            return;
        }

        const formData = new FormData();
        formData.append('action',   'srub_filter_projects');
        formData.append('category', category);
        formData.append('paged',    paged);
        formData.append('nonce',    srubAjax.nonce);

        fetch(srubAjax.ajax_url, { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                grid.style.opacity      = '1';
                grid.style.pointerEvents = '';

                if (!data.success) {
                    grid.innerHTML = '<div class="projects-empty"><p>Ошибка загрузки. Попробуйте обновить страницу.</p></div>';
                    pagination.innerHTML = '';
                    return;
                }

                grid.innerHTML = data.data.html
                    || '<div class="projects-empty"><p>Проектов не найдено.</p></div>';

                renderPagination(data.data.max_pages, paged);
                reBindModalButtons();

                // Мягкий скролл к сетке
                window.scrollTo({
                    top:      grid.getBoundingClientRect().top + window.pageYOffset - 120,
                    behavior: 'smooth',
                });
            })
            .catch(err => {
                console.error('Ошибка AJAX:', err);
                grid.style.opacity      = '1';
                grid.style.pointerEvents = '';
            });
    }

    /* ─────────────────────────────────────────
       Фильтры
    ───────────────────────────────────────── */
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('filter-btn--active'));
            btn.classList.add('filter-btn--active');

            currentFilter = btn.dataset.filter;
            currentPage   = 1;

            fetchProjects(currentFilter, currentPage);
        });
    });

    /* ─────────────────────────────────────────
       Первая загрузка:
       - карточки уже в DOM (PHP-рендер)
       - пагинацию рисуем из переменной переданной через wp_localize_script
    ───────────────────────────────────────── */
    if (typeof srubProjects !== 'undefined' && srubProjects.max_pages > 1) {
        renderPagination(srubProjects.max_pages, 1);
    }

    // Подключаем кнопки модалки на первой загрузке
    reBindModalButtons();

    /* ─────────────────────────────────────────
       Модалка: базовая инициализация
       (закрытие по крестику / оверлею / Escape
        и отправка формы — не зависит от грида)
    ───────────────────────────────────────── */
    (function initModal() {
        const modal    = document.getElementById('orderModal');
        const closeBtn = document.querySelector('.modal-close');

        if (!modal) return;

        const closeModal = () => {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
        });

        /* Маска телефона */
        const modalForm  = document.getElementById('modalContactForm');
        if (!modalForm) return;

        const phoneInput = modalForm.querySelector('input[type="tel"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function () {
                let val = this.value.replace(/\D/g, '');
                if (val.startsWith('7') || val.startsWith('8')) val = val.slice(1);
                if (!val.length) { this.value = ''; return; }

                let formatted = '+7 (';
                if (val.length >= 1) formatted += val.slice(0, 3);
                if (val.length >= 4) formatted += ') ' + val.slice(3, 6);
                if (val.length >= 7) formatted += '-' + val.slice(6, 8);
                if (val.length >= 9) formatted += '-' + val.slice(8, 10);
                this.value = formatted;
            });
        }

        /* Отправка формы */
        modalForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const btn          = modalForm.querySelector('.btn--submit');
            const originalText = btn.textContent;
            const messageBox   = modalForm.querySelector('.form-message');

            const nameVal    = modalForm.querySelector('[name="name"]').value;
            const phoneVal   = modalForm.querySelector('[name="phone"]').value;
            const emailVal   = modalForm.querySelector('[name="email"]').value;
            const projectVal = modalForm.querySelector('[name="project_name"]').value;

            if (!phoneVal && !emailVal) {
                if (messageBox) {
                    messageBox.textContent = 'Укажите телефон или email';
                    messageBox.style.color = 'red';
                }
                return;
            }

            btn.disabled    = true;
            btn.textContent = 'Отправка...';

            const formData = new FormData();
            formData.append('action',          'srub_contact_form');
            formData.append('nonce',           srubAjax.nonce);
            formData.append('name',            nameVal);
            formData.append('phone',           phoneVal);
            formData.append('email',           emailVal);
            formData.append('project_subject', projectVal);

            fetch(srubAjax.ajax_url, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        btn.textContent      = 'Отправлено!';
                        btn.style.background = '#4CAF50';
                        if (messageBox) {
                            messageBox.textContent = 'Спасибо! Мы скоро свяжемся с вами.';
                            messageBox.style.color = 'green';
                        }
                        modalForm.reset();

                        setTimeout(() => {
                            modal.classList.remove('is-active');
                            modal.setAttribute('aria-hidden', 'true');
                            document.body.style.overflow = '';
                            btn.textContent      = originalText;
                            btn.style.background = '';
                            btn.disabled         = false;
                            if (messageBox) messageBox.textContent = '';
                        }, 1500);
                    } else {
                        throw new Error('server error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.textContent = 'Ошибка';
                    if (messageBox) {
                        messageBox.textContent = 'Попробуйте позже';
                        messageBox.style.color = 'red';
                    }
                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.disabled    = false;
                    }, 2000);
                });
        });
    })();

});