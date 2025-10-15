class NEOLoader {
    constructor() {
        this.initSplashScreen();
        this.initPageLoader();
    }
    
    initSplashScreen() {
        const splashHTML = `
            <div id="splash-screen" class="splash-screen">
                <div class="splash-content">
                    <img src="/assets/images/logo.png" alt="NEO Logo" class="splash-logo">
                    <div class="splash-spinner"></div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('afterbegin', splashHTML);
        
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                if (splash) {
                    splash.classList.add('fade-out');
                    setTimeout(() => splash.remove(), 300);
                }
            }, 400);
        });
    }
    
    initPageLoader() {
        const loaderHTML = `
            <div id="page-loader" class="page-loader" style="display: none;">
                <div class="loader-content">
                    <img src="/assets/images/logo.png" alt="NEO Logo" class="loader-logo">
                    <div class="loader-spinner"></div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', loaderHTML);
    }
    
    static show() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.style.display = 'flex';
        }
    }
    
    static hide() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new NEOLoader();
    
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            NEOLoader.show();
        });
    });
    
    document.querySelectorAll('a').forEach(link => {
        if (link.href && !link.href.includes('#') && !link.target) {
            link.addEventListener('click', (e) => {
                if (!e.ctrlKey && !e.metaKey) {
                    NEOLoader.show();
                }
            });
        }
    });
});
