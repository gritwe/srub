document.addEventListener('DOMContentLoaded', () => {

  const track        = document.getElementById('reviewsTrack');
  const prevBtn      = document.getElementById('prevBtn');
  const nextBtn      = document.getElementById('nextBtn');
  const dotsWrap     = document.getElementById('reviewsDots');
  const noReviewsMsg = document.getElementById('noReviewsMsg');
  const countSpan    = document.getElementById('totalReviewsCount');
  
  const sourceBtns   = document.querySelectorAll('[data-filter-type="source"]');
  const tagBtns      = document.querySelectorAll('[data-filter-type="tag"]');
  const resetBtn     = document.getElementById('resetFiltersBtn');

  if (!track) return;

  let activeSource = 'all';
  let activeTag = null;
  
  let cards = []; 
  let isAnimating = false;
  const transitionSpeed = 500;

  function initCount() {
    const total = track.querySelectorAll('.review-card:not(.clone)').length;
    if (countSpan) countSpan.textContent = total;
  }
  initCount();

  function getVisibleCount() {
    if (window.innerWidth < 768) return 1;
    if (window.innerWidth < 900) return 2;
    return 3;
  }

  function getCardWidth() {
    const card = track.querySelector('.review-card');
    if (!card) return 0;
    return card.offsetWidth + 20; 
  }

  function setupInfiniteLoop() {
    const existingClones = track.querySelectorAll('.clone');
    existingClones.forEach(el => el.remove());

    cards = Array.from(track.querySelectorAll('.review-card:not(.filtered-out)'));
    const visible = getVisibleCount();
    
    if (cards.length <= visible) {
        track.style.transition = 'none';
        track.style.transform = `translateX(0px)`;
        if(prevBtn) prevBtn.style.display = 'none';
        if(nextBtn) nextBtn.style.display = 'none';
        if(dotsWrap) dotsWrap.innerHTML = '';
        return;
    } else {
        if(prevBtn) prevBtn.style.display = 'flex';
        if(nextBtn) nextBtn.style.display = 'flex';
    }

    const clonesStart = cards.slice(0, visible).map(card => {
        const clone = card.cloneNode(true);
        clone.classList.add('clone');
        return clone;
    });
    
    const clonesEnd = cards.slice(-visible).map(card => {
        const clone = card.cloneNode(true);
        clone.classList.add('clone');
        return clone;
    });

    clonesEnd.forEach(clone => track.appendChild(clone));
    clonesStart.reverse().forEach(clone => track.insertBefore(clone, track.firstChild));

    const initialOffset = visible * getCardWidth();
    
    track.style.transition = 'none';
    track.style.transform = `translateX(-${initialOffset}px)`;
    track.dataset.currentIndex = 0;
    
    updateDots();
  }

  function moveCarousel(direction) {
    if (isAnimating) return;
    isAnimating = true;

    const visible = getVisibleCount();
    const cardW = getCardWidth();
    const currentIdx = parseInt(track.dataset.currentIndex || 0);
    const totalRealCards = cards.length;
    
    let nextIdx = currentIdx + direction
    let translateX = -(visible + nextIdx) * cardW;

    track.style.transition = `transform ${transitionSpeed}ms cubic-bezier(0.25, 1, 0.5, 1)`;
    track.style.transform = `translateX(${translateX}px)`;

    track.dataset.currentIndex = nextIdx;

    setTimeout(() => {
        isAnimating = false;
        
        let needsReset = false;
        let resetIdx = 0;
        let resetTransform = '';

        if (nextIdx >= totalRealCards) {
            needsReset = true;
            resetIdx = 0;
            resetTransform = `translateX(-${visible * cardW}px)`;
        }
        
        if (nextIdx < 0) {
            needsReset = true;
            resetIdx = totalRealCards - 1;
            resetTransform = `translateX(-${(visible + totalRealCards - 1) * cardW}px)`;
        }

        if (needsReset) {
            track.style.transition = 'none';
            track.style.transform = resetTransform;
            track.dataset.currentIndex = resetIdx;

            track.offsetHeight; 
        }
        
        updateDots();
    }, transitionSpeed);
  }

  function updateDots() {
      if(!dotsWrap) return;
      const totalRealCards = cards.length;
      if (totalRealCards === 0) {
          dotsWrap.innerHTML = '';
          return;
      }
      
      let html = '';
      for(let i=0; i<totalRealCards; i++) {
          let realIdx = parseInt(track.dataset.currentIndex);
          if (realIdx < 0) realIdx = totalRealCards - 1;
          if (realIdx >= totalRealCards) realIdx = 0;
          
          const isActive = (i === realIdx) ? ' reviews__dot--active' : '';
          html += `<button class="reviews__dot${isActive}" onclick="jumpToSlide(${i})"></button>`;
      }
      dotsWrap.innerHTML = html;
  }

  window.jumpToSlide = function(targetIndex) {
      if (isAnimating) return;
      const currentIdx = parseInt(track.dataset.currentIndex || 0);
      const totalRealCards = cards.length;

      let diff = targetIndex - currentIdx;

      moveCarousel(diff);
  };

  if (prevBtn) prevBtn.addEventListener('click', () => moveCarousel(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => moveCarousel(1));

  let startX = 0;
  track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', e => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) {
        if (diff > 0) moveCarousel(1);
        else moveCarousel(-1);
    }
  }, { passive: true });

  function applyFilters() {
    const originals = Array.from(document.querySelectorAll('.review-card:not(.clone)'));
    
    originals.forEach(card => {
      const cardSource = card.getAttribute('data-source');
      const cardTags = card.getAttribute('data-tags') || '';
      
      const sourceMatch = (activeSource === 'all') || 
                    (cardSource === activeSource) || 
                    (activeSource === 'yandex' && cardSource.startsWith('yandex_'));
      const tagMatch = (!activeTag) || cardTags.includes(activeTag);

      if (sourceMatch && tagMatch) {
        card.classList.remove('filtered-out');
        card.style.display = ''; 
      } else {
        card.classList.add('filtered-out');
        card.style.display = 'none';
      }
    });

    setupInfiniteLoop();
    
    if (resetBtn) {
        resetBtn.style.display = (activeSource !== 'all' || activeTag) ? 'inline-block' : 'none';
    }
    
    const visibleCards = originals.filter(c => !c.classList.contains('filtered-out'));
    if(noReviewsMsg) {
        noReviewsMsg.style.display = visibleCards.length === 0 ? 'block' : 'none';
    }
  }

  sourceBtns.forEach(btn => {
      btn.addEventListener('click', () => {
          sourceBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeSource = btn.getAttribute('data-value');
          applyFilters();
      });
  });

  tagBtns.forEach(btn => {
      btn.addEventListener('click', () => {
          const tagValue = btn.getAttribute('data-value');
          if (activeTag === tagValue) {
              activeTag = null;
              btn.classList.remove('active');
          } else {
              activeTag = tagValue;
              tagBtns.forEach(b => b.classList.remove('active'));
              btn.classList.add('active');
          }
          applyFilters();
      });
  });

  if (resetBtn) {
      resetBtn.addEventListener('click', () => {
          activeSource = 'all';
          activeTag = null;
          sourceBtns.forEach(b => b.classList.remove('active'));
          if(sourceBtns[0]) sourceBtns[0].classList.add('active');
          tagBtns.forEach(b => b.classList.remove('active'));
          applyFilters();
      });
  }

  let resizeTimer;
  window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
          setupInfiniteLoop(); 
      }, 100);
  }, { passive: true });


  setTimeout(() => {
      applyFilters();
  }, 50);

  window.toggleReview = function(btn) {
    const card = btn.closest('.review-card');
    if (!card) return;
    card.classList.toggle('is-expanded');
    const isExpanded = card.classList.contains('is-expanded');
    btn.textContent = isExpanded ? 'Свернуть' : 'Читать полностью';
  };

  const revealTargets = document.querySelectorAll(
    '.history__left, .timeline__item, .principle, .geo__left, .geo__map'
  );
  
  if(revealTargets.length > 0) {
      revealTargets.forEach(el => el.classList.add('fade-up'));
      document.querySelectorAll('.timeline__item').forEach((el, i) => {
        el.style.transitionDelay = `${i * 0.12}s`;
      });
      document.querySelectorAll('.principle').forEach((el, i) => {
        el.style.transitionDelay = `${i * 0.08}s`;
      });

      const observer = new IntersectionObserver(
        entries => entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
          }
        }),
        { threshold: 0.1, rootMargin: '0px 0px -30px 0px' }
      );
      revealTargets.forEach(el => observer.observe(el));
  }

  // Форма
  const form = document.getElementById('contactForm');
  if (form) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const phone = form.querySelector('input[type="tel"]');
      const email = form.querySelector('input[type="email"]');
      const btn   = form.querySelector('.btn--submit');

      if (!phone.value.trim() && !email.value.trim()) {
        [phone, email].forEach(inp => {
          if(inp) {
              inp.style.borderColor = 'rgba(220,80,60,0.7)';
              setTimeout(() => { inp.style.borderColor = ''; }, 2000);
          }
        });
        return;
      }

      btn.textContent  = 'Отправлено ✓';
      btn.style.background = '#4CAF50';
      btn.style.color  = '#fff';
      btn.disabled     = true;
      if(phone) phone.value = '';
      if(email) email.value = '';

      setTimeout(() => {
        btn.textContent  = 'Заказать звонок';
        btn.style.background = '';
        btn.style.color  = '';
        btn.disabled     = false;
      }, 4000);
    });

    const phoneInput = form.querySelector('input[type="tel"]');
    if (phoneInput) {
      phoneInput.addEventListener('input', () => {
        let v = phoneInput.value.replace(/\D/g, '');
        if (v.startsWith('7') || v.startsWith('8')) v = v.slice(1);
        if (!v) { phoneInput.value = ''; return; }
        let f = '+7 (';
        if (v.length >= 1) f += v.slice(0, 3);
        if (v.length >= 4) f += ') ' + v.slice(3, 6);
        if (v.length >= 7) f += '-' + v.slice(6, 8);
        if (v.length >= 9) f += '-' + v.slice(8, 10);
        phoneInput.value = f;
      });
    }
  }

});