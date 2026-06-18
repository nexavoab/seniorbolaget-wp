(function seniorbolagetDesignCleanup() {
  'use strict';

  function textOf(element) {
    return (element && element.textContent ? element.textContent : '').replace(/\s+/g, ' ').trim();
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
    return /^\s*\|?\s*:?[-—–]{2,}:?\s*(?:\|\s*:?[-—–]{2,}:?\s*)+\|?\s*$/.test(String(line || ''));
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

  function decodeImageValue(value) {
    try {
      return decodeURIComponent(String(value || ''));
    } catch (error) {
      return String(value || '');
    }
  }

  function buildNeutralServiceSvg(variant) {
    var accent = ['#C91C22', '#3F7D4F', '#D18A24'][variant % 3];
    var foreground = [
      '<path d="M72 162l78-62 78 62" fill="none" stroke="#C91C22" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>',
      '<rect x="92" y="156" width="116" height="74" rx="10" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
      '<rect x="136" y="184" width="28" height="46" rx="4" fill="#EFE2D7"/>',
      '<circle cx="286" cy="166" r="33" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
      '<path d="M286 137v90M256 168c23 3 43-5 60-24M258 190c24 1 44-5 62-22" fill="none" stroke="#3F7D4F" stroke-width="5" stroke-linecap="round"/>'
    ];

    if (variant % 3 === 1) {
      foreground = [
        '<path d="M92 212c34-62 68-88 104-78 32 9 45 43 30 78H92z" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
        '<path d="M128 204c22-38 52-58 90-62M158 218c-2-44 12-78 42-104" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round"/>',
        '<rect x="246" y="134" width="72" height="88" rx="14" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
        '<path d="M262 178h40M282 158v40" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>'
      ];
    } else if (variant % 3 === 2) {
      foreground = [
        '<rect x="82" y="146" width="116" height="78" rx="12" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
        '<path d="M110 178h58M110 200h42" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>',
        '<path d="M248 122l54 54M302 122l-54 54" stroke="#D18A24" stroke-width="12" stroke-linecap="round"/>',
        '<circle cx="275" cy="199" r="28" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
        '<path d="M261 199l10 10 22-24" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>'
      ];
    }

    return [
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Seniorbolaget">',
      '<rect width="400" height="300" fill="#FAF7F2"/>',
      '<circle cx="338" cy="58" r="72" fill="' + accent + '" opacity="0.10"/>',
      '<circle cx="62" cy="252" r="92" fill="#EFE7DC" opacity="0.72"/>',
      '<path d="M0 242c46-16 82-17 130-4 63 17 116 15 178-7 39-14 70-17 92-12v81H0z" fill="#F0E8DD"/>',
      foreground.join(''),
      '</svg>'
    ].join('');
  }

  function neutralServiceImageSrc(index) {
    return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(buildNeutralServiceSvg(index));
  }

  function improveComingSoonImages() {
    var index = 0;
    Array.from(document.querySelectorAll('img')).forEach(function(image) {
      var haystack = [
        image.getAttribute('alt') || '',
        decodeImageValue(image.getAttribute('src') || ''),
        decodeImageValue(image.getAttribute('srcset') || '')
      ].join(' ');

      if (!/(bild\s+kommer\s+snart|foto\s+(kommer|uppdateras)|uppdateras\s+snart)/i.test(haystack)) return;

      image.src = neutralServiceImageSrc(index);
      image.alt = 'Seniorbolaget, hushållsnära tjänster';
      image.removeAttribute('srcset');
      image.classList.add('sb-neutral-service-image');
      image.setAttribute('data-sb-neutral-service-image', 'true');
      index += 1;
    });
  }

  function repairLogoHomeLinks() {
    Array.from(document.querySelectorAll('a.sb-logo')).forEach(function(link) {
      if (!link.getAttribute('href')) {
        link.setAttribute('href', '/');
      }
      if (!link.getAttribute('aria-label')) {
        link.setAttribute('aria-label', 'Seniorbolaget startsida');
      }
    });
  }

  function repairInjectedContactFormLabels() {
    Array.from(document.querySelectorAll('input[type="checkbox"][name="sb_gdpr"]')).forEach(function(input, index) {
      var label = input.closest('label');
      if (label) return;

      var id = input.getAttribute('id') || 'sb-gdpr-consent-' + index;
      input.setAttribute('id', id);

      var sibling = input.nextElementSibling;
      if (sibling && sibling.tagName && sibling.tagName.toLowerCase() === 'span') {
        var replacement = document.createElement('label');
        replacement.setAttribute('for', id);
        replacement.className = sibling.className || '';
        replacement.setAttribute('style', sibling.getAttribute('style') || 'font-size:13px;line-height:1.4;color:#555;');
        while (sibling.firstChild) replacement.appendChild(sibling.firstChild);
        sibling.parentNode.replaceChild(replacement, sibling);
        return;
      }

      if (!input.getAttribute('aria-label')) {
        input.setAttribute('aria-label', 'Jag godkänner behandling av personuppgifter');
      }
    });

    Array.from(document.querySelectorAll('input[name="sb_website"]')).forEach(function(input) {
      input.setAttribute('tabindex', '-1');
      input.setAttribute('aria-hidden', 'true');
      if (input.parentElement) {
        input.parentElement.setAttribute('aria-hidden', 'true');
      }
    });
  }

  function repairCareContextCopy() {
    if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;

    var replacements = [
      [/Privat hemtjänst/g, 'Hemnära stöd'],
      [/Ledsagning/g, 'Praktisk hjälp'],
      [/^Omsorg$/g, 'Vardagshjälp'],
      [/Omsorg • Hemnära stöd • Praktisk hjälp/g, 'Vardagshjälp • Hemnära stöd • Praktisk hjälp'],
      [/omsorg och precision/g, 'omtanke och noggrannhet'],
      [/med omsorg och precision/g, 'med omtanke och noggrannhet'],
      [/vård och omsorg/g, 'service och kundnära arbete'],
      [/hjälpa med medicin/g, 'hjälpa med praktiska vardagsbestyr']
    ];

    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
      acceptNode: function(node) {
        var parent = node.parentElement;
        if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
        return /(Privat hemtjänst|Ledsagning|^Omsorg$|Omsorg • Hemnära stöd • Praktisk hjälp|omsorg och precision|vård och omsorg|hjälpa med medicin)/i.test((node.nodeValue || '').trim()) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
      }
    });
    var nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);

    nodes.forEach(function(node) {
      var value = node.nodeValue || '';
      replacements.forEach(function(pair) {
        value = value.replace(pair[0], pair[1]);
      });
      node.nodeValue = value;
    });
  }

  function repairVisibleContentTypography() {
    if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;

    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
      acceptNode: function(node) {
        var parent = node.parentElement;
        if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
        return /(—|\s,)/.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
      }
    });
    var nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);

    nodes.forEach(function(node) {
      node.nodeValue = (node.nodeValue || '')
        .replace(/^\s*—\s*$/g, '')
        .replace(/\s+—\s+/g, ' ')
        .replace(/\s+,/g, ',');
    });
  }

  function repairContactDuplicateHeading() {
    if (!/\/kontakt\/?$/i.test(window.location.pathname || '')) return;

    Array.from(document.querySelectorAll('main h2, .wp-site-blocks h2')).forEach(function(heading) {
      if (textOf(heading) !== 'Hur kan vi hjälpa dig?') return;
      heading.textContent = 'Välj vad du behöver hjälp med';
      heading.setAttribute('data-sb-contact-heading-repaired', 'true');
    });
  }

  function repair404SwedishText() {
    if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;
    var is404 = document.body.classList.contains('error404') || /404|sidan hittades inte/i.test(document.title || '');
    if (!is404) return;

    var replacements = [
      [/soka istallet/g, 'söka istället'],
      [/Sok/g, 'Sök'],
      [/besok nagon/g, 'besök någon'],
      [/vara populara/g, 'våra populära'],
      [/Hemstadning/g, 'Hemstädning'],
      [/Foretag/g, 'Företag'],
      [/Vardagshjalp/g, 'Vardagshjälp'],
      [/Tillbaka til /g, 'Tillbaka till ']
    ];

    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
      acceptNode: function(node) {
        var parent = node.parentElement;
        if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
        return /(soka istallet|Sok|besok nagon|vara populara|Hemstadning|Foretag|Vardagshjalp|Tillbaka til )/.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
      }
    });
    var nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);

    nodes.forEach(function(node) {
      var value = node.nodeValue || '';
      replacements.forEach(function(pair) {
        value = value.replace(pair[0], pair[1]);
      });
      node.nodeValue = value;
    });
  }

  function run() {
    colorRedHeadingOnDarkSections();
    fixRedTextOnRedCards();
    normalizeServiceModalTargets();
    normalizeServiceCards();
    hideCookiePlaceholders();
    hideVisiblePlaceholderWarnings();
    convertPriceMarkdownTables();
    improveLocationPlaceholders();
    improveComingSoonImages();
    repairLogoHomeLinks();
    repairInjectedContactFormLabels();
    repairCareContextCopy();
    repairVisibleContentTypography();
    repairContactDuplicateHeading();
    repair404SwedishText();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }

  window.addEventListener('load', run);
})();
