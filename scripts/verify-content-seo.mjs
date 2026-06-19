import { readFileSync } from 'node:fs';
import { join } from 'node:path';

const root = process.cwd();
const failures = [];

function read(relativePath) {
  return readFileSync(join(root, relativePath), 'utf8');
}

function requireText(file, text, reason) {
  const source = read(file);
  if (!source.includes(text)) {
    failures.push(`${file}: missing "${text}" (${reason})`);
  }
}

const notFound = 'wp/seniorbolaget-theme/templates/404.html';

requireText(notFound, 'Söka istället?', '404 search heading must preserve Swedish characters');
requireText(notFound, 'Sök på sajten', '404 search label must preserve Swedish characters');
requireText(notFound, 'Besök någon av våra populära sidor', '404 popular-links heading must preserve Swedish characters');
requireText(notFound, 'Hemstädning', '404 popular link text must preserve ä');
requireText(notFound, 'Företag', '404 popular link text must preserve ö');
requireText(notFound, 'Vardagshjälp', '404 popular link text must preserve ä');
requireText(notFound, '<!-- wp:search', '404 page must include a WordPress search block');

if (failures.length) {
  console.error('Content/SEO lint failed:');
  for (const failure of failures) console.error(`- ${failure}`);
  process.exit(1);
}

console.log('Content/SEO lint passed');
