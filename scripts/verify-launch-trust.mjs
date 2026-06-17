import { readFileSync } from 'node:fs';
import { join } from 'node:path';

const root = process.cwd();

const checks = [
  {
    file: 'wp/seniorbolaget-theme/patterns/hero.php',
    patterns: [/Hemtjänst(?:er)?/i, /Hemtjanst(?:er)?/i],
    reason: 'home hero must use household-services wording, not hemtjanst wording',
  },
  {
    file: 'wp/seniorbolaget-theme/style.css',
    patterns: [/Hemtjänst(?:er)?/i, /Hemtjanst(?:er)?/i],
    reason: 'theme metadata must not describe Seniorbolaget as hemtjanst',
  },
  {
    file: 'seniorbolaget.wordpress.xml',
    patterns: [/Seniorbolaget\s+[\u2013-]\s+Hemtjänst(?:er)?/i, /Seniorbolaget\s+[\u2013-]\s+Hemtjanst(?:er)?/i],
    reason: 'imported SEO title must not describe Seniorbolaget as hemtjanst',
  },
];

const failures = [];

for (const check of checks) {
  const text = readFileSync(join(root, check.file), 'utf8');
  for (const pattern of check.patterns) {
    const match = text.match(pattern);
    if (match) {
      failures.push(`${check.file}: matched ${pattern} (${check.reason})`);
    }
  }
}

if (failures.length) {
  console.error('Launch trust lint failed:');
  for (const failure of failures) console.error(`- ${failure}`);
  process.exit(1);
}

console.log('Launch trust lint passed');
