class MatrixRain {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        
        this.ctx = this.canvas.getContext('2d');
        
        // Get the parent section's dimensions
        const parent = this.canvas.parentElement;
        this.canvas.width = parent.offsetWidth;
        this.canvas.height = parent.offsetHeight;
        
        // Matrix characters - Amharic Geez numbers and characters
        this.matrixChars = [
            // Geez numbers (1-10)
            '፩', '፪', '፫', '፬', '፭', '፮', '፯', '፰', '፱', '፲',
            // Amharic Geez characters
            'ሀ', 'ለ', 'ሐ', 'መ', 'ሠ', 'ረ', 'ሰ', 'ሸ', 'ቀ', 'በ',
            'ተ', 'ቸ', 'ኀ', 'ነ', 'ኘ', 'አ', 'ከ', 'ኸ', 'ወ', 'ዐ',
            'ዘ', 'ዠ', 'የ', 'ደ', 'ጀ', 'ገ', 'ጠ', 'ጨ', 'ጰ', 'ጸ',
            'ፀ', 'ፈ', 'ፐ', 'ሁ', 'ሊ', 'ሒ', 'ሜ', 'ሤ', 'ሪ', 'ሲ',
            'ሺ', 'ቂ', 'ቢ', 'ቲ', 'ቺ', 'ኂ', 'ኒ', 'ኚ', 'እ', 'ኪ'
        ];
        
        this.fontSize = 18;
        this.speed = 0.8;
        this.columns = this.canvas.width / this.fontSize;
        this.drops = [];
        
        for (let i = 0; i < this.columns; i++) {
            this.drops[i] = Math.random() * -100;
        }
        
        this.animate();
        
        window.addEventListener('resize', () => {
            const parent = this.canvas.parentElement;
            this.canvas.width = parent.offsetWidth;
            this.canvas.height = parent.offsetHeight;
            this.columns = this.canvas.width / this.fontSize;
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
        this.ctx.font = this.fontSize + 'px monospace';
        
        for (let i = 0; i < this.drops.length; i++) {
            const text = this.matrixChars[Math.floor(Math.random() * this.matrixChars.length)];
            this.ctx.fillText(text, i * this.fontSize, this.drops[i] * this.fontSize);
            
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
        new MatrixRain('matrix-canvas');
    }
    if (document.getElementById('footer-matrix-canvas')) {
        new MatrixRain('footer-matrix-canvas');
    }
});
