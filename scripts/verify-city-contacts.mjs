import { readFileSync } from 'node:fs';
import { basename, join } from 'node:path';

const contacts = JSON.parse(
  readFileSync('ARTIFACTS/launch-hardening/20260617-1555/PROD-CITY-CONTACTS.json', 'utf8'),
);
const failures = [];

function slugFromUrl(url) {
  return url.replace(/\/$/, '').split('/').pop();
}

function sourcePath(record) {
  return join('wp/seniorbolaget-theme/patterns', `stad-${slugFromUrl(record.url)}-page.php`);
}

function digits(value) {
  return value.replace(/\D/g, '');
}

function telHrefs(source) {
  return [...source.matchAll(/href="tel:([^"]+)"/g)].map((match) => digits(match[1]));
}

function mailtoHrefs(source) {
  return [...source.matchAll(/href="mailto:([^"]+)"/gi)].map((match) => match[1].toLowerCase());
}

for (const record of contacts.records) {
  const path = sourcePath(record);
  const source = readFileSync(path, 'utf8');
  const primaryPhoneDigits = digits(record.primaryPhone);
  const telValues = telHrefs(source);
  const mailtoValues = mailtoHrefs(source);
  const firstName = record.contactName?.split(/\s+/)[0];

  if (record.contactName && !source.includes(record.contactName)) {
    failures.push(`${basename(path)}: contact name ${record.contactName} missing`);
  }
  if (firstName && !source.includes(firstName)) {
    failures.push(`${basename(path)}: contact first name ${firstName} missing`);
  }
  if (!telValues.length) failures.push(`${basename(path)}: missing tel: links`);
  if (telValues.some((value) => value !== primaryPhoneDigits)) {
    failures.push(`${basename(path)}: tel: links do not all match ${record.primaryPhone}`);
  }
  if (!source.includes(record.primaryPhone)) {
    failures.push(`${basename(path)}: visible phone ${record.primaryPhone} missing`);
  }
  for (const email of record.primaryEmails) {
    if (!source.toLowerCase().includes(email)) {
      failures.push(`${basename(path)}: visible email ${email} missing`);
    }
  }
  const primaryEmail = record.primaryEmails[0];
  if (primaryEmail && !mailtoValues.includes(primaryEmail)) {
    failures.push(`${basename(path)}: primary mailto ${primaryEmail} missing`);
  }
}

if (failures.length) {
  console.error('City contact lint failed:');
  for (const failure of failures.slice(0, 120)) console.error(`- ${failure}`);
  if (failures.length > 120) console.error(`- ... ${failures.length - 120} more`);
  process.exit(1);
}

console.log('City contact lint passed');
