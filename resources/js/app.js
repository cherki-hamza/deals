import './bootstrap';
import '../css/app.css';

// Alpine.js
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Alpine Components
Alpine.data('mobileMenu', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    }
}));

Alpine.data('productGallery', () => ({
    activeImage: 0,
    setActive(index) {
        this.activeImage = index;
    }
}));

Alpine.data('countdown', () => ({
    days: 0,
    hours: 0,
    minutes: 0,
    seconds: 0,
    init() {
        // Placeholder for future countdown functionality
    }
}));

// Compare Store
Alpine.store('compare', {
    items: (() => {
        try {
            return JSON.parse(localStorage.getItem('compare_items') || '[]');
        } catch (e) {
            console.error('Error loading compare items:', e);
            return [];
        }
    })(),

    add(id) {
        if (!this.items.includes(id)) {
            this.items.push(id);
            this.save();
        }
    },

    remove(id) {
        this.items = this.items.filter(item => item !== id);
        this.save();
    },

    has(id) {
        return this.items.includes(id);
    },

    toggle(id) {
        if (this.has(id)) {
            this.remove(id);
        } else {
            this.add(id);
        }
    },

    save() {
        localStorage.setItem('compare_items', JSON.stringify(this.items));
    },

    get count() {
        return this.items.length;
    }
});

Alpine.start();
