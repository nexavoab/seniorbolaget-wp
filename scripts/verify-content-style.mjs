import { readdirSync, readFileSync, statSync } from 'node:fs';
import { join } from 'node:path';

const roots = [
  'wp/seniorbolaget-theme/patterns',
  'wp/seniorbolaget-theme/templates',
  'wp/seniorbolaget-theme/parts',
];
const extensions = new Set(['.php', '.html']);
const failures = [];

function walk(dir) {
  for (const entry of readdirSync(dir)) {
    const path = join(dir, entry);
    const stat = statSync(path);
    if (stat.isDirectory()) walk(path);
    else if ([...extensions].some((ext) => path.endsWith(ext))) check(path);
  }
}

function stripComments(text) {
  return text
    .replace(/<!--[\s\S]*?-->/g, '')
    .replace(/\/\*[\s\S]*?\*\//g, '')
    .replace(/^\s*\/\/.*$/gm, '');
}

function check(path) {
  const source = stripComments(readFileSync(path, 'utf8'));
  const lines = source.split(/\r?\n/);
  lines.forEach((line, index) => {
    if (line.includes('—')) failures.push(`${path}:${index + 1}: em dash`);
    if (line.includes(' ,')) failures.push(`${path}:${index + 1}: space before comma`);
  });
}

for (const root of roots) walk(root);

if (failures.length) {
  console.error('Content style lint failed:');
  for (const failure of failures.slice(0, 80)) console.error(`- ${failure}`);
  if (failures.length > 80) console.error(`- ... ${failures.length - 80} more`);
  process.exit(1);
}

console.log('Content style lint passed');
