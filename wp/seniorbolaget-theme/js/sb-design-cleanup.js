(function seniorbolagetDesignCleanup() {
  'use strict';

  function textOf(element) {
    return (element && element.textContent ? element.textContent : '').replace(/\s+/g, ' ').trim();
  }

  var FORETAG_TRUST_LABELS = [
    '50+ aktiva företagskunder',
    'Svarstid inom 24 h',
    'Faktura 30 dagar',
    'Kollektivavtal'
  ];

  function ensureLogoLinksHome() {
    var candidates = Array.from(document.querySelectorAll('a.sb-logo, .custom-logo-link, .wp-block-site-logo a, header a'));
    var homeHref = window.location.origin + '/';

    candidates.forEach(function(link) {
      var image = link.querySelector('img');
      var label = ((image && image.getAttribute('alt')) || textOf(link) || '').toLowerCase();
      var isLogo = link.classList.contains('sb-logo') ||
        link.classList.contains('custom-logo-link') ||
        Boolean(link.closest('.wp-block-site-logo')) ||
        label.indexOf('seniorbolaget') !== -1;

      if (!isLogo) return;
      if (link.getAttribute('href')) return;

      link.setAttribute('href', homeHref);
      link.setAttribute('aria-label', 'Till startsidan');
    });
  }

  function foretagTrustIconSvg() {
    return [
      '<svg class="sb-foretag-trust-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">',
      '<circle cx="12" cy="12" r="10"></circle>',
      '<path d="m9 12 2 2 4-4"></path>',
      '</svg>'
    ].join('');
  }

  function normalizeForetagTrustBand() {
    Array.from(document.querySelectorAll('div')).forEach(function(row) {
      if (row.getAttribute('data-sb-foretag-trust-fixed') === 'true') return;

      var text = textOf(row);
      if (text.length > 220) return;
      if (!FORETAG_TRUST_LABELS.every(function(label) { return text.indexOf(label) !== -1; })) return;
      if (row.children.length < 6 || row.children.length > 10) return;
      if (window.getComputedStyle(row).display !== 'flex') return;

      row.classList.add('sb-foretag-trust-row');
      row.setAttribute('data-sb-foretag-trust-fixed', 'true');
      row.innerHTML = FORETAG_TRUST_LABELS.map(function(label) {
        return [
          '<span class="sb-foretag-trust-item">',
          foretagTrustIconSvg(),
          '<span class="sb-foretag-trust-label">',
          label,
          '</span>',
          '</span>'
        ].join('');
      }).join('');
    });
  }

  function colorRedHeadingOnDarkSections() {
    Array.from(document.querySelectorAll('h1,h2,h3')).forEach(function(heading) {
      var text = textOf(heading);
      if (!/Få en vacker trädgård/i.test(text)) return;

      var node = heading.parentElement;
      while (node && node !== document.body) {
        var style = window.getComputedStyle(node);
        var background = style.backgroundColor || '';
        if (/rgb\(74,\s*85,\s*104\)|#4a5568/i.test(background) || background !== 'rgba(0, 0, 0, 0)') {
          heading.classList.add('sb-fixed-contrast-heading');
          heading.style.setProperty('color', '#fff', 'important');
          return;
        }
        node = node.parentElement;
      }
    });
  }

  function isBrandRedPaint(value) {
    var raw = String(value || '');
    var match = raw.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?/i);
    if (/#c91c22|#a01519/i.test(raw)) return true;
    if (!match) return false;
    var red = Number(match[1]);
    var green = Number(match[2]);
    var blue = Number(match[3]);
    var alpha = match[4] === undefined ? 1 : Number(match[4]);
    return alpha > 0.05 && red > 150 && green < 70 && blue < 70;
  }

  function redPaintedAncestor(element) {
    var node = element.parentElement;
    var depth = 0;
    while (node && node !== document.body && depth < 5) {
      var style = window.getComputedStyle(node);
      if (isBrandRedPaint(style.backgroundColor) || isBrandRedPaint(style.backgroundImage)) return node;
      node = node.parentElement;
      depth += 1;
    }
    return null;
  }

  function fixRedTextOnRedCards() {
    Array.from(document.querySelectorAll('h1,h2,h3,p,span,strong')).forEach(function(element) {
      var text = textOf(element);
      if (text.length <= 3 || text.length >= 120) return;
      if (!isBrandRedPaint(window.getComputedStyle(element).color)) return;
      if (!redPaintedAncestor(element)) return;

      element.classList.add('sb-fixed-red-card-text');
      element.style.setProperty('color', '#fff', 'important');
    });
  }

  function serviceCardLabel(card) {
    var labelElement = card.querySelector('h3, .sb-svc-name');
    return textOf(labelElement || card)
      .replace(/^\+\s*/, '')
      .replace(/\s+(RUT|ROT)\s+\d+%.*$/i, '')
      .replace(/\s+(Företag|BRF).*$/i, '')
      .trim()
      .toLowerCase();
  }

  function normalizeServiceModalTargets() {
    var expectedTargets = {
      'hemstädning': 'hemstadning',
      'trädgård': 'tradgard',
      'vardagshjälp': 'vardagshjalp',
      'snickeri': 'snickeri'
    };

    Array.from(document.querySelectorAll('.sb-service-card, .sb-svc-card')).forEach(function(card) {
      var expectedTarget = expectedTargets[serviceCardLabel(card)];
      var onclick = card.getAttribute('onclick') || '';
      if (!expectedTarget || !/openServiceModal/i.test(onclick) || onclick.indexOf(expectedTarget) !== -1) return;

      card.setAttribute('data-sb-hotfix-original-onclick', onclick);
      card.setAttribute('onclick', "openServiceModal('" + expectedTarget + "')");
      card.onclick = function(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        if (typeof window.openServiceModal === 'function') {
          window.openServiceModal(expectedTarget);
        }
      };
    });
  }

  function normalizeServiceCards() {
    var cards = Array.from(document.querySelectorAll('.sb-service-card, .sb-svc-card'));

    cards.forEach(function(card) {
      var svg = card.querySelector('svg');
      if (svg) {
        svg.setAttribute('width', '40');
        svg.setAttribute('height', '40');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', '#fff');
        svg.setAttribute('stroke-width', '1.75');
        svg.style.setProperty('width', '40px', 'important');
        svg.style.setProperty('height', '40px', 'important');
        svg.style.setProperty('stroke', '#fff', 'important');
        svg.style.setProperty('color', '#fff', 'important');
      }

      var plus = card.querySelector('.sb-card-plus, .sb-svc-plus');
      if (plus) {
        plus.setAttribute('aria-hidden', 'true');
      }
    });

    var seenVisibleLabels = Object.create(null);
    cards.forEach(function(card) {
      var rect = card.getBoundingClientRect();
      if (rect.width <= 0 || rect.height <= 0) return;

      var label = serviceCardLabel(card);
      if (!label) return;
      if (seenVisibleLabels[label]) {
        card.setAttribute('data-sb-hotfix-hidden-duplicate', 'true');
        card.style.setProperty('display', 'none', 'important');
        return;
      }

      seenVisibleLabels[label] = true;
    });
  }

  function hideCookiePlaceholders() {
    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    var nodes = [];
    var current;
    while ((current = walker.nextNode())) {
      if (/\{(?:vendor_count|title)\}/.test(current.nodeValue || '')) {
        nodes.push(current);
      }
    }

    nodes.forEach(function(node) {
      node.nodeValue = (node.nodeValue || '')
        .replace(/\{vendor_count\}/g, '')
        .replace(/\{title\}/g, '');
    });
  }

  function hideVisiblePlaceholderWarnings() {
    Array.from(document.body.querySelectorAll('*')).forEach(function(element) {
      var text = textOf(element);
      if (!/(PLACEHOLDER|Pris ej verifierat|TODO|FIXME|lorem ipsum)/i.test(text)) return;
      if (text.length > 320) return;

      element.classList.add('sb-hidden-placeholder-text');
      element.style.setProperty('display', 'none', 'important');
    });
  }

  function splitMarkdownTableLine(line) {
    return String(line || '')
      .trim()
      .replace(/^\|/, '')
      .replace(/\|$/, '')
      .split('|')
      .map(function(cell) { return cell.trim(); });
  }

  function isMarkdownTableLine(line) {
    return /^\s*\|.+\|\s*$/.test(String(line || ''));
  }

  function isMarkdownSeparatorLine(line) {
    return /^\s*\|?\s*:?-{2,}:?\s*(?:\|\s*:?-{2,}:?\s*)+\|?\s*$/.test(String(line || ''));
  }

  function markdownLinesFromParagraph(paragraph) {
    return paragraph.innerHTML
      .replace(/<br\s*\/?>/gi, '\n')
      .replace(/&nbsp;/gi, ' ')
      .split(/\n+/)
      .map(function(line) {
        var scratch = document.createElement('textarea');
        scratch.innerHTML = line;
        return scratch.value.replace(/\s+/g, ' ').trim();
      })
      .filter(isMarkdownTableLine);
  }

  function convertPriceMarkdownTables() {
    Array.from(document.querySelectorAll('p')).forEach(function(paragraph) {
      var headerText = textOf(paragraph);
      if (!/^\|\s*Stad\s*\|\s*Timpris/i.test(headerText)) return;
      if (paragraph.getAttribute('data-sb-price-table-converted') === 'true') return;

      var headers = splitMarkdownTableLine(headerText);
      if (headers.length < 2) return;

      var consumedParagraphs = [paragraph];
      var rowLines = [];
      var current = paragraph.nextElementSibling;

      while (current && current.tagName && current.tagName.toLowerCase() === 'p') {
        var lines = markdownLinesFromParagraph(current);
        if (!lines.length) {
          if (rowLines.length) break;
          current = current.nextElementSibling;
          continue;
        }

        consumedParagraphs.push(current);
        lines.forEach(function(line) {
          if (!isMarkdownSeparatorLine(line)) rowLines.push(line);
        });
        current = current.nextElementSibling;
      }

      if (!rowLines.length) return;

      var wrapper = document.createElement('div');
      wrapper.className = 'sb-price-table';

      var table = document.createElement('table');
      var thead = document.createElement('thead');
      var headRow = document.createElement('tr');
      headers.forEach(function(header) {
        var th = document.createElement('th');
        th.textContent = header;
        headRow.appendChild(th);
      });
      thead.appendChild(headRow);
      table.appendChild(thead);

      var tbody = document.createElement('tbody');
      rowLines.forEach(function(line) {
        var cells = splitMarkdownTableLine(line);
        if (cells.length !== headers.length) return;

        var tr = document.createElement('tr');
        cells.forEach(function(cell) {
          var td = document.createElement('td');
          td.textContent = cell;
          tr.appendChild(td);
        });
        tbody.appendChild(tr);
      });

      if (!tbody.children.length) return;

      table.appendChild(tbody);
      wrapper.appendChild(table);
      paragraph.setAttribute('data-sb-price-table-converted', 'true');
      paragraph.parentNode.insertBefore(wrapper, paragraph);
      consumedParagraphs.forEach(function(node) { node.remove(); });
    });
  }

  function buildLocationPlaceholderSvg(city) {
    var safeCity = String(city || 'Seniorbolaget').replace(/[<>&"]/g, '');
    return [
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice">',
      '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">',
      '<stop offset="0%" stop-color="#c91c22"/><stop offset="100%" stop-color="#7f1115"/>',
      '</linearGradient></defs>',
      '<rect width="400" height="300" fill="url(#g)"/>',
      '<circle cx="326" cy="70" r="54" fill="rgba(255,255,255,0.14)"/>',
      '<circle cx="84" cy="230" r="80" fill="rgba(255,255,255,0.10)"/>',
      '<text x="200" y="134" text-anchor="middle" fill="#ffffff" font-family="Inter, Arial, sans-serif" font-size="27" font-weight="800">Seniorbolaget</text>',
      '<text x="200" y="176" text-anchor="middle" fill="rgba(255,255,255,0.88)" font-family="Inter, Arial, sans-serif" font-size="22" font-weight="700">',
      safeCity,
      '</text></svg>'
    ].join('');
  }

  function improveLocationPlaceholders() {
    Array.from(document.querySelectorAll('.team-card img[src^="data:image/svg+xml"]')).forEach(function(image) {
      var card = image.closest('.team-card');
      if (!card || card.getAttribute('data-sb-placeholder-fixed') === 'true') return;

      var city = textOf(card.querySelector('.team-card-city')) || textOf(card).split(' ')[0] || 'Seniorbolaget';
      var svg = buildLocationPlaceholderSvg(city);
      image.src = 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
      image.alt = city + ', Seniorbolaget';
      card.classList.add('sb-location-placeholder-fixed');
      card.setAttribute('data-sb-placeholder-fixed', 'true');
    });
  }

  function run() {
    ensureLogoLinksHome();
    normalizeForetagTrustBand();
    colorRedHeadingOnDarkSections();
    fixRedTextOnRedCards();
    normalizeServiceModalTargets();
    normalizeServiceCards();
    hideCookiePlaceholders();
    hideVisiblePlaceholderWarnings();
    convertPriceMarkdownTables();
    improveLocationPlaceholders();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }

  window.addEventListener('load', run);
})();
