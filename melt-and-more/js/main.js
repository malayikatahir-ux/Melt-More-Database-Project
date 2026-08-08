// Melt and More Bakery - Main JavaScript

document.addEventListener('DOMContentLoaded', function () {

    // ---- BACK TO TOP ----
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ---- MOBILE MENU ----
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.mobile-nav');
    if (mobileMenuBtn && mobileNav) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileNav.classList.toggle('open');
            mobileMenuBtn.textContent = mobileNav.classList.contains('open') ? '✕' : '☰';
        });
    }

    // ---- TESTIMONIAL SLIDER ----
    const testimonials = [
        {
            text: "Melt and More ka chocolate cake ek dum kamaal tha! Mere birthday pe sab ny taste kiya aur bohat pasand kiya. Malayika ki baking skills zabardast hain!",
            name: "Ayesha Khan",
            avatar: "👩"
        },
        {
            text: "Cupcakes itney fresh aur mazedaar thay! Perfect for my daughter's birthday party. Will definitely order again.",
            name: "Sara Ahmed",
            avatar: "👩‍🦱"
        },
        {
            text: "Red velvet cake ki ek dum alag baat hai. Cream cheese frosting perfect thi. Highly recommended for all occasions!",
            name: "Zara Malik",
            avatar: "👩‍🦳"
        }
    ];

    let currentTestimonial = 0;
    const testimonialText = document.querySelector('.testimonial-text');
    const testimonialName = document.querySelector('.testimonial-name');
    const testimonialAvatar = document.querySelector('.testimonial-avatar-emoji');
    const dots = document.querySelectorAll('.testimonial-dots span');

    function showTestimonial(index) {
        if (!testimonialText) return;
        currentTestimonial = index;
        testimonialText.style.opacity = 0;
        setTimeout(function () {
            testimonialText.textContent = '"' + testimonials[index].text + '"';
            testimonialName.textContent = testimonials[index].name;
            if (testimonialAvatar) testimonialAvatar.textContent = testimonials[index].avatar;
            testimonialText.style.opacity = 1;
            dots.forEach(function (d, i) {
                d.classList.toggle('active', i === index);
            });
        }, 300);
    }

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { showTestimonial(i); });
    });

    // Auto rotate testimonials
    setInterval(function () {
        showTestimonial((currentTestimonial + 1) % testimonials.length);
    }, 5000);

    // ---- NAV ACTIVE STATE ----
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    document.querySelectorAll('.nav-links a').forEach(function (link) {
        const href = link.getAttribute('href');
        if (href && currentPage.includes(href.replace('.php', ''))) {
            link.classList.add('active');
        }
    });

    // ---- SMOOTH SCROLL FOR ANCHOR LINKS ----
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ---- GALLERY SEARCH ----
    const gallerySearch = document.querySelector('.gallery-search');
    const galleryItems = document.querySelectorAll('.gallery-item');
    if (gallerySearch) {
        gallerySearch.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            galleryItems.forEach(function (item) {
                const title = item.querySelector('h4') ? item.querySelector('h4').textContent.toLowerCase() : '';
                item.style.display = title.includes(query) ? '' : 'none';
            });
        });
    }

    // ---- ORDER QUANTITY ----
    document.querySelectorAll('.qty-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = this.parentElement.querySelector('.qty-input');
            if (!input) return;
            let val = parseInt(input.value) || 1;
            if (this.dataset.action === 'plus') val = Math.min(val + 1, 99);
            if (this.dataset.action === 'minus') val = Math.max(val - 1, 1);
            input.value = val;
            updateOrderTotal();
        });
    });

    function updateOrderTotal() {
        let total = 0;
        document.querySelectorAll('.order-item-row').forEach(function (row) {
            const priceEl = row.querySelector('.item-price');
            const qtyEl = row.querySelector('.qty-input');
            const checkEl = row.querySelector('.item-check');
            if (priceEl && qtyEl && checkEl && checkEl.checked) {
                total += parseFloat(priceEl.dataset.price || 0) * parseInt(qtyEl.value || 1);
            }
        });
        const totalEl = document.querySelector('#orderTotal');
        if (totalEl) totalEl.textContent = 'Rs. ' + total.toLocaleString();
    }

    document.querySelectorAll('.item-check').forEach(function (cb) {
        cb.addEventListener('change', updateOrderTotal);
    });

    updateOrderTotal();

    // ---- FADE IN ANIMATION on scroll ----
    const fadeEls = document.querySelectorAll('.fade-in');
    if (fadeEls.length) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15 });
        fadeEls.forEach(function (el) { observer.observe(el); });
    }

    // ---- FORM VALIDATION ----
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.addEventListener('submit', function (e) {
            const name = document.getElementById('customer_name');
            const phone = document.getElementById('customer_phone');
            const email = document.getElementById('customer_email');
            if (name && !name.value.trim()) { alert('Please enter your name'); e.preventDefault(); return; }
            if (phone && !phone.value.trim()) { alert('Please enter your phone number'); e.preventDefault(); return; }
            if (email && !email.value.includes('@')) { alert('Please enter a valid email'); e.preventDefault(); return; }
        });
    }
});
