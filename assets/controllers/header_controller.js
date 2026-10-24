import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.#initDiscPills();
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
}
