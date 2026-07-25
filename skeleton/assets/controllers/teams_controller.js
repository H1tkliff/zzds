import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.#initToggle();
    }

    #initToggle() {
        this.element.querySelectorAll('.team-featured').forEach((item) => {
            const head = item.querySelector('.tf-head');
            const link = item.querySelector('.tf-link');

            head.setAttribute('aria-expanded', item.classList.contains('is-close') ? 'false' : 'true');

            head.addEventListener('click', () => {
                item.classList.toggle('is-close');
                head.setAttribute('aria-expanded', item.classList.contains('is-close') ? 'false' : 'true');
            });

            link.addEventListener('click', (e) => e.stopPropagation());
        });
    }
}
