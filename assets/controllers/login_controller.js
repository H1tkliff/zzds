import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['strengthWrap', 'strengthLabel', 'strengthBar'];

    connect() {
        this.#initCheckboxes();
    }

    switchTab(event) {
        const tab = event.currentTarget.dataset.tab;
        const isLogin = tab === 'login';

        this.element.querySelectorAll('.tab').forEach(t => {
            t.classList.toggle('active', t.dataset.tab === tab);
        });

        this.element.querySelector('#form-login').style.display = isLogin ? 'block' : 'none';
        this.element.querySelector('#form-register').style.display = isLogin ? 'none' : 'block';
    }

    checkStrength(event) {
        const val = event.currentTarget.value;
        const wrap = this.strengthWrapTarget;
        const bars = this.strengthBarTargets;
        const label = this.strengthLabelTarget;

        if (!val) {
            wrap.classList.remove('show');
            return;
        }

        wrap.classList.add('show');

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const cls = score <= 1 ? 'weak' : score <= 2 ? 'medium' : 'strong';
        const labels = { weak: 'Weak', medium: 'Fair', strong: score === 4 ? 'Strong' : 'Good' };
        const colors = { weak: '#ff4444', medium: '#f0a500', strong: '#00c8a0' };

        bars.forEach((bar, i) => {
            bar.className = 'strength-bar';
            if (i < score) bar.classList.add(cls);
        });

        label.textContent = labels[cls];
        label.style.color = colors[cls];
    }

    #initCheckboxes() {
        this.element.querySelectorAll('.check-row').forEach(row => {
            row.addEventListener('click', () => {
                row.querySelector('.check-box').classList.toggle('checked');
            });
        });
    }
}
