import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';

const baseSitemap = process.argv[2] ?? 'https://staging.seniorbolaget.se/sitemap_index.xml';
const limit = Number(process.argv[3] ?? 75);
const outDir = process.argv[4] ?? 'ARTIFACTS/launch-hardening/20260617-1555';
const delayMs = Number(process.argv[5] ?? 350);
const jsonOut = join(outDir, 'staging-crawl-75.json');
const mdOut = join(outDir, 'STAGING-CRAWL-75.md');

async function fetchText(url) {
  const response = await fetch(url, { redirect: 'follow' });
  const text = await response.text();
  return { response, text };
}

function locs(xml) {
  return [...xml.matchAll(/<loc>\s*([^<\s]+)\s*<\/loc>/gi)].map((match) => match[1]);
}

async function sitemapUrls(url, seen = new Set()) {
  if (seen.has(url)) return [];
  seen.add(url);
  const { text } = await fetchText(url);
  const found = locs(text);
  const sitemapLinks = found.filter((loc) => /sitemap.*\.xml/i.test(loc));
  if (!sitemapLinks.length) return found;
  const nested = [];
  for (const sitemap of sitemapLinks) nested.push(...await sitemapUrls(sitemap, seen));
  return nested;
}

async function checkUrl(url) {
  const started = Date.now();
  try {
    let response = await fetch(url, { redirect: 'manual' });
    let retries = 0;
    while (response.status === 429 && retries < 3) {
      const retryAfter = Number(response.headers.get('retry-after') ?? 0);
      const backoff = retryAfter > 0 ? retryAfter * 1000 : 1000 * (retries + 1);
      await sleep(backoff);
      retries += 1;
      response = await fetch(url, { redirect: 'manual' });
    }
    const body = response.status >= 200 && response.status < 300 ? await response.text() : '';
    return {
      url,
      status: response.status,
      redirected: response.status >= 300 && response.status < 400,
      location: response.headers.get('location') ?? '',
      contentType: response.headers.get('content-type') ?? '',
      xRobotsTag: response.headers.get('x-robots-tag') ?? '',
      retries,
      bytes: body.length,
      ms: Date.now() - started,
    };
  } catch (error) {
    return {
      url,
      status: 0,
      redirected: false,
      location: '',
      contentType: '',
      xRobotsTag: '',
      retries: 0,
      bytes: 0,
      ms: Date.now() - started,
      error: error instanceof Error ? error.message : String(error),
    };
  }
}

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

const urls = [...new Set(await sitemapUrls(baseSitemap))]
  .filter((url) => url.startsWith('https://staging.seniorbolaget.se/'))
  .slice(0, limit);

const results = [];
for (const url of urls) {
  results.push(await checkUrl(url));
  await sleep(delayMs);
}

const failures = results.filter((result) => result.status !== 200 || result.redirected);
const report = {
  generatedAt: new Date().toISOString(),
  sitemap: baseSitemap,
  limit,
  checked: results.length,
  failures: failures.length,
  results,
};

mkdirSync(dirname(jsonOut), { recursive: true });
writeFileSync(jsonOut, `${JSON.stringify(report, null, 2)}\n`);

const lines = [
  '# Staging Crawl 75',
  '',
  `Generated: ${report.generatedAt}`,
  `Sitemap: ${baseSitemap}`,
  `Checked: ${results.length}`,
  `Failures: ${failures.length}`,
  '',
  '| Status | URL | ms | Notes |',
  '| --- | --- | ---: | --- |',
  ...results.map((result) => {
    const notes = [
      result.redirected ? `redirect -> ${result.location}` : '',
      result.retries ? `retries: ${result.retries}` : '',
      result.error ?? '',
      result.xRobotsTag ? `x-robots-tag: ${result.xRobotsTag}` : '',
    ].filter(Boolean).join('; ');
    return `| ${result.status} | ${result.url} | ${result.ms} | ${notes} |`;
  }),
  '',
];
writeFileSync(mdOut, lines.join('\n'));

if (failures.length) {
  console.error(`Staging crawl failed: ${failures.length} of ${results.length} URLs were not direct 200 responses.`);
  process.exit(1);
}

console.log(`Staging crawl passed: ${results.length} URLs returned direct 200 responses.`);
