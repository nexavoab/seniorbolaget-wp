(function seniorbolagetDesignCleanup() {
  'use strict';

  function textOf(element) {
    return (element && element.textContent ? element.textContent : '').replace(/\s+/g, ' ').trim();
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
