<div class="toast-area" id="toast-area" aria-live="polite"></div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
@livewireScripts
<script>
    (function () {
        // Livewire 3 envoie les paramètres de dispatch() dans event.detail
        // (objet, ou tableau d'un objet selon la version).
        const payload = (e) => Array.isArray(e.detail) ? (e.detail[0] || {}) : (e.detail || {});

        window.addEventListener('close-modal', (e) => {
            const el = document.getElementById(payload(e).id);
            if (!el) return;
            if (window.bootstrap && window.bootstrap.Modal) {
                window.bootstrap.Modal.getOrCreateInstance(el).hide();
            } else {
                const btn = el.querySelector('[data-bs-dismiss="modal"]');
                if (btn) btn.click();
            }
        });

        window.addEventListener('notify', (e) => {
            const { message, type } = payload(e);
            const area = document.getElementById('toast-area');
            if (!area || !message) return;
            const div = document.createElement('div');
            div.className = 'alert alert-' + (type || 'success') + ' alert-dismissible bg-white shadow-sm mb-2';
            div.setAttribute('role', 'alert');
            div.textContent = message;
            const close = document.createElement('a');
            close.className = 'btn-close';
            close.setAttribute('aria-label', 'Fermer');
            close.addEventListener('click', () => div.remove());
            div.appendChild(close);
            area.appendChild(div);
            setTimeout(() => div.remove(), 4000);
        });
    })();
</script>
@stack('scripts')
