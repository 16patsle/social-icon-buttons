if (navigator.share) {
  window.addEventListener('DOMContentLoaded', () =>
    document.body.classList.add('social-icons-share-supported')
  );
  document.addEventListener('click', (e) => {
    let target = e.target;
    while (target.nodeName === 'svg' || target.nodeName === 'use') {
      target = target.parentNode;
    }
    if (
      target.classList.contains('social-icon-button') &&
      target.classList.contains('share')
    ) {
      navigator.share({
        title: target.dataset.title,
        text: target.dataset.text,
        url: target.dataset.url,
      });
    }
  });
}
