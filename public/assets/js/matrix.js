class AmharicMatrixRain {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        
        this.ctx = this.canvas.getContext('2d');
        
        // Get the parent section's dimensions
        const parent = this.canvas.parentElement;
        this.canvas.width = parent.offsetWidth;
        this.canvas.height = parent.offsetHeight;
        
        // Amharic numbers and some common Amharic letters
        this.amharicChars = [
            '፩', '፪', '፫', '፬', '፭', '፮', '፯', '፰', '፱', '፲',
            'ሀ', 'ለ', 'ሐ', 'መ', 'ሠ', 'ረ', 'ሰ', 'ሸ', 'ቀ', 'በ',
            'ተ', 'ቸ', 'ኀ', 'ነ', 'ኘ', 'አ', 'ከ', 'ኸ', 'ወ', 'ዐ',
            'ዘ', 'ዠ', 'የ', 'ደ', 'ጀ', 'ገ', 'ጠ', 'ጨ', 'ጰ', 'ፀ'
        ];
        
        this.fontSize = 24; // Increased for more spacing
        this.speed = 0.4; // Slower falling speed (was 1, now 0.4)
        this.columnSpacing = 35; // More space between columns
        this.columns = this.canvas.width / this.columnSpacing;
        this.drops = [];
        
        for (let i = 0; i < this.columns; i++) {
            this.drops[i] = Math.random() * -100;
        }
        
        this.animate();
        
        window.addEventListener('resize', () => {
            const parent = this.canvas.parentElement;
            this.canvas.width = parent.offsetWidth;
            this.canvas.height = parent.offsetHeight;
            this.columns = this.canvas.width / this.columnSpacing;
            this.drops = [];
            for (let i = 0; i < this.columns; i++) {
                this.drops[i] = Math.random() * -100;
            }
        });
    }
    
    draw() {
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.ctx.fillStyle = '#00FF41';
        this.ctx.font = this.fontSize + 'px "Noto Sans Ethiopic", "Nyala", "Ethiopia Jiret", sans-serif';
        
        for (let i = 0; i < this.drops.length; i++) {
            const text = this.amharicChars[Math.floor(Math.random() * this.amharicChars.length)];
            this.ctx.fillText(text, i * this.columnSpacing, this.drops[i] * this.fontSize);
            
            if (this.drops[i] * this.fontSize > this.canvas.height && Math.random() > 0.975) {
                this.drops[i] = 0;
            }
            this.drops[i] += this.speed;
        }
    }
    
    animate() {
        this.draw();
        requestAnimationFrame(() => this.animate());
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('matrix-canvas')) {
        new AmharicMatrixRain('matrix-canvas');
    }
    if (document.getElementById('footer-matrix-canvas')) {
        new AmharicMatrixRain('footer-matrix-canvas');
    }
});
