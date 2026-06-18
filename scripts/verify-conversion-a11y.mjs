import { readFileSync } from 'node:fs';
import { join } from 'node:path';

const root = process.cwd();

const failures = [];

function read(relativePath) {
  return readFileSync(join(root, relativePath), 'utf8');
}

function requireIncludes(file, needle, reason) {
  const text = read(file);
  if (!text.includes(needle)) {
    failures.push(`${file}: missing ${needle} (${reason})`);
  }
}

function requireLabelPair(file, id, labelText) {
  const text = read(file);
  const labelPattern = new RegExp(`<label\\b[^>]*for=["']${id}["'][^>]*>\\s*${labelText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}`, 'i');
  const controlPattern = new RegExp(`<(input|textarea)\\b[^>]*id=["']${id}["']`, 'i');

  if (!labelPattern.test(text)) {
    failures.push(`${file}: missing label[for="${id}"] for "${labelText}"`);
  }

  if (!controlPattern.test(text)) {
    failures.push(`${file}: missing input/textarea id="${id}"`);
  }
}

requireIncludes(
  'wp/seniorbolaget-theme/parts/header.html',
  '"isLinkHome":true',
  'site logo must explicitly link to the home page'
);

const formFiles = [
  'wp/seniorbolaget-theme/patterns/intresse-anmalan-page.php',
  'wp/seniorbolaget-theme/templates/page-intresse-anmalan.php',
];

for (const file of formFiles) {
  requireLabelPair(file, 'sb-city-search', 'Sök ort');
  requireLabelPair(file, 'sb-area', 'Bostadsyta');
  requireLabelPair(file, 'sb-notes-hemstadning', 'Övrigt');
  requireLabelPair(file, 'sb-notes-tradgard', 'Övrigt');
  requireLabelPair(file, 'sb-description', 'Beskriv uppdraget');
  requireLabelPair(file, 'sb-notes-work', 'Övrigt');
  requireLabelPair(file, 'sb-name', 'Förnamn');
  requireLabelPair(file, 'sb-phone', 'Telefonnummer');
}

if (failures.length) {
  console.error('Conversion accessibility lint failed:');
  for (const failure of failures) console.error(`- ${failure}`);
  process.exit(1);
}

console.log('Conversion accessibility lint passed');
