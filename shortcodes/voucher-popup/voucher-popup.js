/**
 * Voucher Popup JavaScript with Swiper.js
 * 
 * Handles the functionality for the voucher motives popup using Swiper.js
 */

class VoucherPopup {
    constructor() {
        this.voucherData = [];
        this.swiper = null;
        
        this.init();
    }
    
    init() {
        this.loadVoucherData();
        this.bindEvents();
    }
    
    loadVoucherData() {
        const dataElement = document.getElementById('voucher-data');
        if (dataElement) {
            try {
                this.voucherData = JSON.parse(dataElement.textContent);
                this.initializeSwiper();
                this.generateVoucherButtons();
            } catch (error) {
                console.error('Error loading voucher data:', error);
            }
        }
    }
    
    initializeSwiper() {
        if (this.voucherData.length === 0) return;
        
        // Create slides
        const swiperWrapper = document.querySelector('.swiper-wrapper');
        if (!swiperWrapper) return;
        
        swiperWrapper.innerHTML = '';
        
        this.voucherData.forEach((voucher, index) => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            slide.innerHTML = `
                <div class="voucher-slide-content">
                    <!-- Front panel -->
                    <div class="voucher-panel voucher-front-panel">
                        <div class="voucher-image-container">
                            <img class="voucher-front-image" src="${voucher.front_image}" alt="${voucher.post_title} - Front" />
                        </div>
                    </div>
                    
                    <!-- Back panel -->
                    <div class="voucher-panel voucher-back-panel">
                        <div class="voucher-image-container">
                            <img class="voucher-back-image" src="${voucher.back_image}" alt="${voucher.post_title} - Back" />
                        </div>
                    </div>
                </div>
            `;
            swiperWrapper.appendChild(slide);
        });
        
        // Initialize Swiper
        this.swiper = new Swiper('.voucher-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: '.voucher-nav-next',
                prevEl: '.voucher-nav-prev',
            },
            on: {
                slideChange: () => {
                    this.updateActiveButton();
                }
            }
        });
    }
    
    generateVoucherButtons() {
        const categoriesContainer = document.querySelector('.voucher-categories');
        if (!categoriesContainer || this.voucherData.length === 0) return;
        
        // Clear existing buttons
        categoriesContainer.innerHTML = '';
        
        // Add buttons for each voucher (using post titles as button labels)
        this.voucherData.forEach((voucher, index) => {
            const button = document.createElement('button');
            button.className = 'voucher-category-btn';
            if (index === 0) {
                button.classList.add('active');
            }
            button.setAttribute('data-index', index);
            button.textContent = voucher.post_title;
            categoriesContainer.appendChild(button);
        });
    }
    
    bindEvents() {
        // Show popup button
        const showVoucherBtn = document.getElementById('budi-show-voucher');
        if (showVoucherBtn) {
            showVoucherBtn.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default link behavior
                this.showPopup();
            });
        }
        
        // Close button
        const closeBtn = document.querySelector('.voucher-popup-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.closePopup());
        }
        
        // Voucher buttons
        const voucherBtns = document.querySelectorAll('.voucher-category-btn');
        voucherBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.selectVoucher(parseInt(e.target.dataset.index));
            });
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('voucher-popup').style.display !== 'none') {
                switch(e.key) {
                    case 'Escape':
                        this.closePopup();
                        break;
                    case 'ArrowLeft':
                        if (this.swiper) this.swiper.slidePrev();
                        break;
                    case 'ArrowRight':
                        if (this.swiper) this.swiper.slideNext();
                        break;
                }
            }
        });
        
        // Click outside to close
        const overlay = document.querySelector('.voucher-popup-overlay');
        if (overlay) {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    this.closePopup();
                }
            });
        }
    }
    
    showPopup() {
        const popup = document.getElementById('voucher-popup');
        if (popup) {
            popup.style.display = 'flex';
            popup.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }
    
    closePopup() {
        const popup = document.getElementById('voucher-popup');
        if (popup) {
            popup.classList.remove('show');
            setTimeout(() => {
                popup.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
    }
    
    selectVoucher(index) {
        if (this.swiper) {
            this.swiper.slideTo(index);
        }
    }
    
    updateActiveButton() {
        if (!this.swiper) return;
        
        const activeIndex = this.swiper.activeIndex;
        
        // Update active button
        document.querySelectorAll('.voucher-category-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        const activeButton = document.querySelector(`[data-index="${activeIndex}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
    }
}

// Initialize popup when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if the popup element exists
    const popupElement = document.getElementById('voucher-popup');
    if (popupElement) {
        new VoucherPopup();
    }
});

// Global function to open popup (can be called from anywhere)
window.openVoucherPopup = function() {
    const popup = document.getElementById('voucher-popup');
    if (popup) {
        popup.style.display = 'flex';
        popup.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
};

// Global function to close popup
window.closeVoucherPopup = function() {
    const popup = document.getElementById('voucher-popup');
    if (popup) {
        popup.classList.remove('show');
        setTimeout(() => {
            popup.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
};