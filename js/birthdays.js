document.addEventListener('DOMContentLoaded', function () {
  var root = document.querySelector('.js-birthdays-root');
  var fifteenMinuteBucket = Math.floor(Date.now() / (15 * 60 * 1000));

  if (!root || typeof fetch === 'undefined') {
    return;
  }

  var endpoint = window.dekiruBirthdays && window.dekiruBirthdays.endpoint
    ? window.dekiruBirthdays.endpoint
    : '';

  if (!endpoint) {
    root.innerHTML = '<p>No birthdays found for Mega Drive, Mega CD, or 32X.</p>';
    return;
  }

  var monthsAhead = parseInt(root.getAttribute('data-months-ahead') || '6', 10);

  var url = endpoint
    + '?months_ahead=' + encodeURIComponent(monthsAhead)
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
    .then(function (payload) {
      renderBirthdays(root, payload);
    })
    .catch(function () {
      root.innerHTML = '<p>No birthdays found for Mega Drive, Mega CD, or 32X.</p>';
    });
});

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function renderBirthdays(root, payload) {
  var data = payload && payload.data ? payload.data : null;
  var today = data && data.today ? data.today : { date_label: '', items: [] };
  var future = data && data.future ? data.future : { items: [] };
  var todayItems = Array.isArray(today.items) ? today.items : [];
  var futureItems = Array.isArray(future.items) ? future.items : [];
  var monthGroups = groupFutureItemsByMonth(futureItems);

  if (!todayItems.length && !monthGroups.length) {
    root.innerHTML = '<p>No birthdays found for Mega Drive, Mega CD, or 32X.</p>';
    return;
  }

  var html = '';

  if (todayItems.length) {
    html += '<h2 class="birthdays-today-title">Today\'s Birthdays <span class="birthdays-today-date">'
      + escapeHtml(today.date_label || '')
      + '</span></h2>';

    html += '<div class="birthdays-list todays-birthdays">';
    todayItems.forEach(function (item) {
      var thumbnailHtml = '';
      if (item.has_thumbnail && item.thumbnail_archive_url) {
        thumbnailHtml = '<a href="' + escapeHtml(item.permalink) + '">'
          + '<img src="' + escapeHtml(item.thumbnail_archive_url) + '" alt="' + escapeHtml(item.title) + '" loading="lazy" />'
          + '</a>';
      }

      html += '<article class="birthday-item birthday-item-today ' + escapeHtml(item.post_type) + '">'
        + '<div class="birthday-thumbnail game-cover" data-post-type="' + escapeHtml(item.post_type) + '">'
        + thumbnailHtml
        + '</div>'
        + '<div class="birthday-title">'
        + '<a href="' + escapeHtml(item.permalink) + '">' + item.title + ' (' + escapeHtml(item.birthday_year) + ')</a>'
        + '<span class="birthday-post-type">' + escapeHtml(item.post_type_label) + '</span>'
        + '</div>'
        + '</article>';
    });
    html += '</div>';
  }

  if (monthGroups.length) {
    html += '<div class="birthdays-list js-birthdays-future"></div>';
    html += '<div class="js-birthdays-sentinel" aria-hidden="true"></div>';
  }

  root.innerHTML = html;

  if (monthGroups.length) {
    initMonthByMonthLoader(root, monthGroups);
  }
}

function groupFutureItemsByMonth(futureItems) {
  var groups = [];
  var currentLabel = '';

  futureItems.forEach(function (item) {
    var label = item.month_separator_label || '';

    if (!groups.length || label !== currentLabel) {
      currentLabel = label;
      groups.push({
        label: label,
        items: []
      });
    }

    groups[groups.length - 1].items.push(item);
  });

  return groups;
}

function initMonthByMonthLoader(root, monthGroups) {
  var futureRoot = root.querySelector('.js-birthdays-future');
  var sentinel = root.querySelector('.js-birthdays-sentinel');
  var monthIndex = 0;

  if (!futureRoot) {
    return;
  }

  function loadNextMonth() {
    if (monthIndex >= monthGroups.length) {
      if (sentinel) {
        sentinel.remove();
      }
      return;
    }

    var group = monthGroups[monthIndex];
    futureRoot.insertAdjacentHTML('beforeend', renderMonthGroup(group));
    monthIndex += 1;
  }

  // Render first month immediately.
  loadNextMonth();

  if (!sentinel) {
    return;
  }

  if (typeof IntersectionObserver === 'undefined') {
    while (monthIndex < monthGroups.length) {
      loadNextMonth();
    }
    return;
  }

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        loadNextMonth();

        if (monthIndex >= monthGroups.length) {
          observer.disconnect();
        }
      }
    });
  }, {
    rootMargin: '300px 0px'
  });

  observer.observe(sentinel);
}

function renderMonthGroup(group) {
  var html = '';

  if (group.label) {
    html += '<h2 class="birthdays-month-separator">' + escapeHtml(group.label) + '</h2>';
  }

  group.items.forEach(function (item) {
    if (item.show_date) {
      html += '<div class="birthday-date"><span class="birthday-day-month">' + escapeHtml(item.day_month_label) + '</span></div>';
    }

    var futureThumbnailHtml = '';
    if (item.has_thumbnail && item.thumbnail_future_url) {
      futureThumbnailHtml = '<a href="' + escapeHtml(item.permalink) + '" class="game-cover ' + escapeHtml(item.post_type) + '" data-post-type="' + escapeHtml(item.post_type) + '">'
        + '<img src="' + escapeHtml(item.thumbnail_future_url) + '" alt="' + item.title + '" loading="lazy" />'
        + '</a>';
    } else {
      futureThumbnailHtml = '<div class="no-thumbnail game-cover ' + escapeHtml(item.post_type) + '" data-post-type="' + escapeHtml(item.post_type) + '">'
        + '<span class="no-thumbnail-text">Missing from collection</span>'
        + '</div>';
    }

    html += '<article class="birthday-item ' + escapeHtml(item.post_type) + '">'
      + '<div class="birthday-thumbnail">'
      + futureThumbnailHtml
      + '</div>'
      + '<div class="birthday-title">'
      + '<a href="' + escapeHtml(item.permalink) + '">' + item.title + '</a>'
      + '<span class="birthday-post-type">' + escapeHtml(item.post_type_label) + ' / ' + escapeHtml(item.birthday_year) + '</span>'
      + '</div>'
      + '</article>';
  });

  return html;
}
