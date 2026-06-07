import './styles/app.scss';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.disc-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.disc-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });
});
