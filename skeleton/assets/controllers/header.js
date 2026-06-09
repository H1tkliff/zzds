import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.#initDiscPills();
        this.#initNavLinks();
    }

    #initDiscPills() {
        const pills = this.element.querySelectorAll('.disc-pill');

        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
            });
        });
    }

    #initNavLinks() {
        const links = this.element.querySelectorAll('.nav-link');

        links.forEach(link => {
            link.addEventListener('click', () => {
                links.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            });
        });
    }
}
