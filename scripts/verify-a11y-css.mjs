import { readFileSync } from 'node:fs';
import { join } from 'node:path';

const css = readFileSync(join(process.cwd(), 'wp/seniorbolaget-theme/style.css'), 'utf8');
const failures = [];

function requireCss(fragment, reason) {
  if (!css.includes(fragment)) failures.push(`${reason}: missing ${fragment}`);
}

requireCss('.entry-content a:not(.wp-block-button__link)', 'content links need a non-color affordance');
requireCss('text-decoration-line: underline !important;', 'links must override inline text-decoration:none where needed');
requireCss('text-underline-offset: 0.18em !important;', 'underlines need readable offset');
requireCss('.service-card a.read-more-link', 'service-card read-more links need explicit non-color affordance');
requireCss('.sb-footer a', 'footer links need explicit non-color affordance');
requireCss('.has-rod-background-color p', 'red sections need stronger paragraph contrast');
requireCss('color: #FFFFFF !important;', 'dark/red backgrounds need white text overrides');

if (failures.length) {
  console.error('A11y CSS lint failed:');
  for (const failure of failures) console.error(`- ${failure}`);
  process.exit(1);
}

console.log('A11y CSS lint passed');
