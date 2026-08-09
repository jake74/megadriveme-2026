document.addEventListener('DOMContentLoaded', function () {
  var containers = document.querySelectorAll('.js-random-games');
  var fifteenMinuteBucket = Math.floor(Date.now() / (15 * 60 * 1000));

  if (!containers.length || typeof fetch === 'undefined') {
    return;
  }

  var endpoint = window.dekiruHomeRandom && window.dekiruHomeRandom.endpoint
    ? window.dekiruHomeRandom.endpoint
    : '';

  if (!endpoint) {
    return;
  }

  containers.forEach(function (container) {
    var postType = container.getAttribute('data-post-type');
    var postsPerPage = parseInt(container.getAttribute('data-posts-per-page') || '6', 10);
    var emptyMessage = container.getAttribute('data-empty-message') || 'No games found.';

    if (!postType) {
      return;
    }

    var url = endpoint
      + '?post_type=' + encodeURIComponent(postType)
      + '&posts_per_page=' + encodeURIComponent(postsPerPage)
      + '&_cb=' + encodeURIComponent(fifteenMinuteBucket);

    fetch(url, {
      method: 'GET',
      credentials: 'same-origin'
    })
      .then(function (response) {
        if (!response.ok) {
          throw new Error('Request failed: ' + response.status);
        }
        return response.json();
      })
      .then(function (data) {
        if (data && typeof data.html === 'string' && data.html.trim() !== '') {
          container.innerHTML = data.html;
        } else {
          container.innerHTML = '<p>' + emptyMessage + '</p>';
        }
      })
      .catch(function () {
        container.innerHTML = '<p>' + emptyMessage + '</p>';
      });
  });
});
