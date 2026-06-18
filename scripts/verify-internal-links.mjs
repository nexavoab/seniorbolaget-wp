import { readdirSync, readFileSync, statSync } from 'node:fs';
import { join } from 'node:path';

const roots = [
  'wp/seniorbolaget-theme/patterns',
  'wp/seniorbolaget-theme/templates',
  'wp/seniorbolaget-theme/parts',
];
const failures = [];

function walk(dir) {
  for (const entry of readdirSync(dir)) {
    const path = join(dir, entry);
    const stat = statSync(path);
    if (stat.isDirectory()) walk(path);
    else if (path.endsWith('.php') || path.endsWith('.html')) check(path);
  }
}

function needsTrailingSlash(url) {
  if (!url.startsWith('/') || url.startsWith('//') || url === '/') return false;
  if (url.includes('?') || url.includes('#')) return false;
  if (url.endsWith('/')) return false;
  const lastSegment = url.split('/').pop();
  if (lastSegment?.includes('.')) return false;
  return true;
}

function check(path) {
  const source = readFileSync(path, 'utf8');
  const patterns = [
    /\bhref="(\/[^"]*)"/g,
    /"url":"(\/[^"]*)"/g,
  ];
  for (const pattern of patterns) {
    for (const match of source.matchAll(pattern)) {
      if (!needsTrailingSlash(match[1])) continue;
      const line = source.slice(0, match.index).split(/\r?\n/).length;
      failures.push(`${path}:${line}: ${match[1]}`);
    }
  }
}

for (const root of roots) walk(root);

if (failures.length) {
  console.error('Internal link lint failed:');
  for (const failure of failures.slice(0, 80)) console.error(`- ${failure}`);
  if (failures.length > 80) console.error(`- ... ${failures.length - 80} more`);
  process.exit(1);
}

console.log('Internal link lint passed');
