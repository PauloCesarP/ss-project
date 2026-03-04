document.addEventListener('DOMContentLoaded', function() {
    // Home Carousel JavaScript
    (function() {
        const scrollContainer = document.getElementById('case-studies-scroll');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const progressBar = document.getElementById('progress-bar');
        
        if (!scrollContainer || !prevBtn || !nextBtn || !progressBar) return;
        
        const cards = scrollContainer.querySelectorAll('.snap-start');
        const totalCards = cards.length;
        let currentIndex = 0;
        
        function updateProgress() {
            const scrollLeft = scrollContainer.scrollLeft;
            const scrollWidth = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            const progress = scrollWidth > 0 ? (scrollLeft / scrollWidth) : 0;
            
            // Move progress bar horizontally (get current width from element)
            const barWidth = progressBar.offsetWidth; // Dynamic width based on viewport
            const containerWidth = progressBar.parentElement.offsetWidth;
            const maxMove = containerWidth - barWidth;
            const currentLeft = maxMove * progress;
            progressBar.style.left = currentLeft + 'px';
            
            // Calculate current index based on closest card to scroll position
            const containerPadding = parseFloat(getComputedStyle(scrollContainer).paddingLeft) || 0;
            let closestIndex = 0;
            let minDistance = Infinity;
            
            cards.forEach((card, index) => {
                const cardLeft = card.offsetLeft - containerPadding;
                const distance = Math.abs(scrollLeft - cardLeft);
                if (distance < minDistance) {
                    minDistance = distance;
                    closestIndex = index;
                }
            });
            
            currentIndex = closestIndex;
            
            // Update button states
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= totalCards - 1;
        }
        
        function scrollToIndex(index) {
            if (index < 0 || index >= totalCards) return;
            currentIndex = index;
            
            // Calculate exact scroll position based on card positions
            if (cards[index]) {
                const targetCard = cards[index];
                const containerPadding = parseFloat(getComputedStyle(scrollContainer).paddingLeft) || 0;
                const targetScrollLeft = targetCard.offsetLeft - containerPadding;
                
                scrollContainer.scrollTo({
                    left: targetScrollLeft,
                    behavior: 'smooth'
                });
            }
            
            // Atualizar imediatamente e também após a animação
            updateProgress();
            setTimeout(updateProgress, 300);
        }
        
        prevBtn.addEventListener('click', () => {
            scrollToIndex(currentIndex - 1);
        });
        
        nextBtn.addEventListener('click', () => {
            scrollToIndex(currentIndex + 1);
        });
        
        scrollContainer.addEventListener('scroll', updateProgress);
        window.addEventListener('resize', updateProgress);
        
        // Initial state
        updateProgress();
    })();
    // End Home Carousel JavaScript


    // Team Carousel JavaScript
    (function() {
        const container = document.getElementById('team-grid-scroll');
        const prevBtn = document.getElementById('team-prev-btn');
        const nextBtn = document.getElementById('team-next-btn');
        const progressBar = document.getElementById('team-progress-bar');
        
        if (!container || !prevBtn || !nextBtn || !progressBar) return;
        
        const cards = container.querySelectorAll('.snap-start');
        const totalCards = cards.length;
        let currentIndex = 0;
        
        function updateProgress() {
            const scrollLeft = container.scrollLeft;
            const scrollWidth = container.scrollWidth - container.clientWidth;
            const progress = scrollWidth > 0 ? (scrollLeft / scrollWidth) : 0;
            
            // Move progress bar horizontally (same as case_studies_carousel)
            const barWidth = progressBar.offsetWidth; // Dynamic width based on viewport (72.483px or 208px)
            const containerWidth = progressBar.parentElement.offsetWidth;
            const maxMove = containerWidth - barWidth;
            const currentLeft = maxMove * progress;
            progressBar.style.left = currentLeft + 'px';
        }
        
        function scrollToIndex(index) {
            if (index < 0 || index >= totalCards) return;
            currentIndex = index;
            
            // Calculate exact scroll position based on card positions
            if (cards[index]) {
                const targetCard = cards[index];
                const containerPadding = parseInt(getComputedStyle(container).paddingLeft) || 0;
                const targetScrollLeft = targetCard.offsetLeft - containerPadding;
                
                container.scrollTo({
                    left: targetScrollLeft,
                    behavior: 'smooth'
                });
            }
            
            // Update immediately and after animation
            updateProgress();
            setTimeout(updateProgress, 300);
        }
        
        prevBtn.addEventListener('click', () => {
            scrollToIndex(currentIndex - 1);
        });
        
        nextBtn.addEventListener('click', () => {
            scrollToIndex(currentIndex + 1);
        });
        
        container.addEventListener('scroll', () => {
            updateProgress();
            
            // Calculate current index based on closest card
            const containerPadding = parseInt(getComputedStyle(container).paddingLeft) || 0;
            const scrollLeft = container.scrollLeft;
            let closestIndex = 0;
            let minDistance = Infinity;
            
            cards.forEach((card, index) => {
                const cardLeft = card.offsetLeft - containerPadding;
                const distance = Math.abs(scrollLeft - cardLeft);
                if (distance < minDistance) {
                    minDistance = distance;
                    closestIndex = index;
                }
            });
            
            currentIndex = closestIndex;
            
            // Update button states
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= totalCards - 1;
        });
        
        window.addEventListener('resize', updateProgress);
        
        // Initial state
        updateProgress();
    })();
    // End Team Carousel JavaScript


    // Case Studies 
    (function() {
        const categoryTabs = document.querySelectorAll('.category-tab');
        const gridContainer = document.getElementById('case-studies-grid');
        const progressBar = document.getElementById('progress-bar');
        const loadMoreBtn = document.getElementById('load-more-btn');
        const loadMoreSpinner = document.getElementById('load-more-spinner');
        let currentTermSlug = 'all';
        
        if (!categoryTabs.length || !gridContainer || !progressBar) return;
        
        // Function to update progress bar position
        function updateProgressBar() {
            const activeTab = document.querySelector('.category-tab.font-bold');
            if (activeTab) {
                const tabRect = activeTab.getBoundingClientRect();
                const containerRect = activeTab.parentElement.getBoundingClientRect();
                const left = tabRect.left - containerRect.left;
                const width = tabRect.width;
                
                progressBar.style.left = left + 'px';
                progressBar.style.width = width + 'px';
            }
        }
        
        // Initialize progress bar position
        updateProgressBar();
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                const termSlug = this.getAttribute('data-term-slug');
                currentTermSlug = termSlug;
                
                // Update active state
                categoryTabs.forEach(t => {
                    t.classList.remove('font-bold', 'text-blue-950');
                    t.classList.add('font-normal', 'text-neutral-600');
                });
                
                this.classList.remove('font-normal', 'text-neutral-600');
                this.classList.add('font-bold', 'text-blue-950');
                
                // Update progress bar position
                updateProgressBar();
                
                // Reset load more button
                if (loadMoreBtn) {
                    loadMoreBtn.setAttribute('data-page', '1');
                }
                
                // Show loading state
                gridContainer.style.opacity = '0.5';
                gridContainer.style.pointerEvents = 'none';
                
                // AJAX Request
                const tabsContainer = document.getElementById('category-tabs');
                const formData = new FormData();
                formData.append('action', 'filter_case_studies');
                formData.append('term_slug', termSlug);
                formData.append('posts_per_page', this.getAttribute('data-posts-per-page'));
                formData.append('source', tabsContainer?.getAttribute('data-source') || 'automatic');
                formData.append('manual_posts', tabsContainer?.getAttribute('data-manual-posts') || '[]');
                formData.append('taxonomy_ids', tabsContainer?.getAttribute('data-taxonomy-ids') || '[]');
                formData.append('nonce', ssAjax.filterNonce);
                
                fetch(ssAjax.ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        gridContainer.innerHTML = data.data.html;
                        
                        // Update pagination container
                        const paginationContainer = document.getElementById('pagination-container');
                        if (paginationContainer) {
                            if (data.data.pagination) {
                                paginationContainer.innerHTML = '<nav class="flex justify-center items-center gap-2" aria-label="Pagination Navigation">' + data.data.pagination + '</nav>';
                            } else {
                                paginationContainer.innerHTML = '';
                            }
                        }
                        
                        // Update load more button visibility and max pages
                        if (loadMoreBtn) {
                            const maxPages = data.data.max_pages || 1;
                            loadMoreBtn.setAttribute('data-max-pages', maxPages);
                            loadMoreBtn.setAttribute('data-page', '1');
                            
                            if (maxPages > 1) {
                                loadMoreBtn.parentElement.style.display = 'block';
                            } else {
                                loadMoreBtn.parentElement.style.display = 'none';
                            }
                        }
                        
                        // Update URL without reload
                        const newUrl = this.getAttribute('href');
                        //window.history.pushState({termSlug: termSlug}, '', newUrl);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    gridContainer.style.opacity = '1';
                    gridContainer.style.pointerEvents = 'auto';
                });
            });
        });
        
        // Handle Load More button
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const currentPage = parseInt(this.getAttribute('data-page'));
                const maxPages = parseInt(this.getAttribute('data-max-pages'));
                const postsPerPage = parseInt(this.getAttribute('data-posts-per-page'));
                const nextPage = currentPage + 1;
                
                if (nextPage > maxPages) {
                    return;
                }
                
                // Show loading state
                const btnText = this.querySelector('span');
                const originalText = btnText.textContent;
                btnText.textContent = 'Loading...';
                loadMoreSpinner.classList.remove('hidden');
                this.disabled = true;
                
                // AJAX Request
                const tabsContainer = document.getElementById('category-tabs');
                const formData = new FormData();
                formData.append('action', 'load_more_case_studies');
                formData.append('term_slug', currentTermSlug);
                formData.append('page', nextPage);
                formData.append('posts_per_page', postsPerPage);
                formData.append('source', tabsContainer?.getAttribute('data-source') || 'automatic');
                formData.append('manual_posts', tabsContainer?.getAttribute('data-manual-posts') || '[]');
                formData.append('taxonomy_ids', tabsContainer?.getAttribute('data-taxonomy-ids') || '[]');
                formData.append('nonce', ssAjax.loadMoreNonce);
                
                fetch(ssAjax.ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append new posts to grid
                        gridContainer.insertAdjacentHTML('beforeend', data.data.html);
                        
                        // Update page number
                        loadMoreBtn.setAttribute('data-page', nextPage);
                        
                        // Hide button if no more pages
                        if (nextPage >= maxPages) {
                            loadMoreBtn.parentElement.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    btnText.textContent = originalText;
                    loadMoreSpinner.classList.add('hidden');
                    loadMoreBtn.disabled = false;
                });
            });
        }
        
        // Handle WordPress Pagination (AJAX)
        document.addEventListener('click', function(e) {
            const paginationLink = e.target.closest('.content nav a');
            if (!paginationLink || !gridContainer) return;
            
            e.preventDefault();
            
            // Extract page number from URL
            const url = new URL(paginationLink.href);
            const page = url.searchParams.get('paged') || url.pathname.match(/page\/(\d+)/)?.[1] || 1;
            
            // Show loading state
            gridContainer.style.opacity = '0.5';
            gridContainer.style.pointerEvents = 'none';
            
            // AJAX Request
            const tabsContainer = document.getElementById('category-tabs');
            const formData = new FormData();
            formData.append('action', 'filter_case_studies');
            formData.append('term_slug', currentTermSlug);
            formData.append('paged', page);
            formData.append('posts_per_page', document.querySelector('.category-tab')?.getAttribute('data-posts-per-page') || 6);
            formData.append('source', tabsContainer?.getAttribute('data-source') || 'automatic');
            formData.append('manual_posts', tabsContainer?.getAttribute('data-manual-posts') || '[]');
            formData.append('taxonomy_ids', tabsContainer?.getAttribute('data-taxonomy-ids') || '[]');
            formData.append('nonce', ssAjax.filterNonce);
            
            fetch(ssAjax.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    gridContainer.innerHTML = data.data.html;
                    
                    // Update pagination container
                    const paginationContainer = document.getElementById('pagination-container');
                    if (paginationContainer) {
                        if (data.data.pagination) {
                            paginationContainer.innerHTML = '<nav class="flex justify-center items-center gap-2" aria-label="Pagination Navigation">' + data.data.pagination + '</nav>';
                        } else {
                            paginationContainer.innerHTML = '';
                        }
                    }
                    
                    // Scroll to top of grid
                    gridContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                gridContainer.style.opacity = '1';
                gridContainer.style.pointerEvents = 'auto';
            });
        });
        
        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.termSlug) {
                const targetTab = document.querySelector(`[data-term-slug="${e.state.termSlug}"]`);
                if (targetTab) {
                    targetTab.click();
                }
            }
        });
    })();
});
