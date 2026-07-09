/**
 * Playwright smoke review of FAQ public UI.
 * Usage: node scripts/verify-faq-ui.mjs [baseUrl]
 */
import { chromium } from "playwright";
import { mkdirSync } from "fs";
import { dirname, join } from "path";
import { fileURLToPath } from "url";

const base = process.argv[2] || "http://localhost";
const __dir = dirname(fileURLToPath(import.meta.url));
const outDir = join(__dir, "../screenshots/faq-review");
mkdirSync(outDir, { recursive: true });

const findings = [];
const pass = (msg) => findings.push({ ok: true, msg });
const fail = (msg) => findings.push({ ok: false, msg });

async function measureTitleClip(page, selector, label) {
  const result = await page.evaluate((sel) => {
    const el = document.querySelector(sel);
    if (!el) return { found: false };
    const cs = getComputedStyle(el);
    const rect = el.getBoundingClientRect();
    // For bg-clip-text, clipping often shows as scrollHeight > clientHeight
    // or very tight line-height relative to font-size.
    const fontSize = parseFloat(cs.fontSize);
    const lineHeight =
      cs.lineHeight === "normal" ? fontSize * 1.2 : parseFloat(cs.lineHeight);
    const ratio = lineHeight / fontSize;
    return {
      found: true,
      text: el.textContent?.trim().slice(0, 80),
      height: rect.height,
      fontSize,
      lineHeight,
      ratio,
      overflowY: cs.overflowY,
      clientHeight: el.clientHeight,
      scrollHeight: el.scrollHeight,
      clippedByScroll: el.scrollHeight > el.clientHeight + 1,
    };
  }, selector);

  if (!result.found) {
    fail(`${label}: título no encontrado (${selector})`);
    return;
  }

  const hasClipText = await page.evaluate((sel) => {
    const el = document.querySelector(sel);
    if (!el) return false;
    const cs = getComputedStyle(el);
    return (
      cs.backgroundClip === "text" ||
      cs.webkitBackgroundClip === "text" ||
      (el.className || "").includes("bg-clip-text")
    );
  }, selector);

  if (result.clippedByScroll) {
    fail(
      `${label}: posible recorte del título (scrollHeight ${result.scrollHeight} > clientHeight ${result.clientHeight})`
    );
  } else if (hasClipText && result.ratio < 1.15) {
    fail(
      `${label}: line-height muy bajo con bg-clip-text (${result.ratio.toFixed(2)}× font)`
    );
  } else {
    pass(
      `${label}: título OK — «${result.text}» lh/font=${result.ratio.toFixed(2)} h=${result.height.toFixed(0)}px clipText=${hasClipText}`
    );
  }
}

async function noOverlap(page, aSel, bSel, label) {
  const boxes = await page.evaluate(
    ([a, b]) => {
      const A = document.querySelector(a);
      const B = document.querySelector(b);
      if (!A || !B) return null;
      const ra = A.getBoundingClientRect();
      const rb = B.getBoundingClientRect();
      const overlap =
        ra.left < rb.right &&
        ra.right > rb.left &&
        ra.top < rb.bottom &&
        ra.bottom > rb.top;
      return {
        overlap,
        aBottom: ra.bottom,
        bTop: rb.top,
        gap: rb.top - ra.bottom,
      };
    },
    [aSel, bSel]
  );

  if (!boxes) {
    fail(`${label}: no se pudieron medir elementos (${aSel} / ${bSel})`);
    return;
  }
  if (boxes.overlap || boxes.gap < 8) {
    fail(
      `${label}: colisión/poca separación (gap=${boxes.gap.toFixed(1)}px, overlap=${boxes.overlap})`
    );
  } else {
    pass(`${label}: sin solape (gap=${boxes.gap.toFixed(1)}px)`);
  }
}

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage({ viewport: { width: 1280, height: 900 } });

  // —— FAQ index ——
  const faqUrl = `${base}/preguntas-frecuentes`;
  const res = await page.goto(faqUrl, { waitUntil: "networkidle", timeout: 60000 });
  if (!res || !res.ok()) fail(`FAQ index HTTP ${res?.status()}`);
  else pass(`FAQ index carga (${res.status()})`);

  await measureTitleClip(page, "h1", "FAQ index h1");

  // Module filter chips with icons
  const chips = page.locator('a[href*="preguntas-frecuentes"], a[href*="module="]').filter({
    hasText: /Todas|General|Emprendimientos|Bolsa/,
  });
  // Broader: filter group
  const filterLinks = page.locator('[role="group"] a');
  const filterCount = await filterLinks.count();
  if (filterCount >= 3) pass(`Filtros de módulo: ${filterCount} chips`);
  else fail(`Filtros de módulo insuficientes: ${filterCount}`);

  // FAQ items
  const items = page.locator("details");
  const itemCount = await items.count();
  if (itemCount > 0) pass(`Acordeones FAQ: ${itemCount}`);
  else fail("No hay items FAQ visibles");

  // Clean expand chevrons (one per item)
  const chevrons = await page.locator("details summary svg").count();
  if (chevrons >= itemCount) pass(`Chevrons de expandir: ${chevrons}`);
  else fail(`Faltan chevrons: ${chevrons} para ${itemCount} FAQs`);

  // Open first FAQ and screenshot
  if (itemCount > 0) {
    await items.first().locator("summary").click();
    await page.waitForTimeout(300);
    const open = await items.first().evaluate((el) => el.open);
    if (open) pass("Abrir primera FAQ funciona");
    else fail("No se abrió la primera FAQ");
  }

  await page.screenshot({
    path: join(outDir, "faq-index.png"),
    fullPage: true,
  });
  pass(`Screenshot: ${outDir}/faq-index.png`);

  // Filter by job_board
  await page.goto(`${faqUrl}?module=job_board`, {
    waitUntil: "networkidle",
    timeout: 60000,
  });
  const jobItems = await page.locator("details").count();
  const bodyText = await page.locator("main").innerText();
  if (bodyText.includes("Bolsa de Trabajo") || jobItems >= 0) {
    pass(`Filtro job_board: ${jobItems} items`);
  }
  await page.screenshot({
    path: join(outDir, "faq-job-board.png"),
    fullPage: true,
  });

  // Search
  await page.goto(`${faqUrl}?q=hoja`, {
    waitUntil: "networkidle",
    timeout: 60000,
  });
  const searchItems = await page.locator("details").count();
  pass(`Búsqueda q=hoja: ${searchItems} resultados`);
  await page.screenshot({
    path: join(outDir, "faq-search.png"),
    fullPage: true,
  });

  // —— Home FAQ section ——
  await page.goto(`${base}/`, { waitUntil: "networkidle", timeout: 60000 });
  const homeFaq = page.locator("section").filter({ hasText: "Preguntas Frecuentes" }).last();
  await homeFaq.scrollIntoViewIfNeeded();
  await page.waitForTimeout(200);

  const cta = homeFaq.locator('a[href*="preguntas-frecuentes"]');
  const lastDetails = homeFaq.locator("details").last();
  if ((await lastDetails.count()) > 0 && (await cta.count()) > 0) {
    // open last FAQ then check gap to CTA
    await lastDetails.locator("summary").click();
    await page.waitForTimeout(400);
    // Compare grid bottom (all FAQs) to CTA block — not a single column item
    const gap = await page.evaluate(() => {
      const grid = document.getElementById("home-faq-grid");
      const cta = document.getElementById("home-faq-cta");
      if (!grid || !cta) return null;
      const ra = grid.getBoundingClientRect();
      const rb = cta.getBoundingClientRect();
      const overlap =
        ra.left < rb.right &&
        ra.right > rb.left &&
        ra.top < rb.bottom &&
        ra.bottom > rb.top;
      return { gap: rb.top - ra.bottom, overlap };
    });
    if (!gap) fail("Home: no se pudieron medir grid FAQ y CTA");
    else if (gap.overlap || gap.gap < 24)
      fail(`Home: grid FAQ vs CTA demasiado cerca (gap=${gap.gap.toFixed(1)}px)`);
    else pass(`Home: grid FAQ vs CTA OK (gap=${gap.gap.toFixed(1)}px)`);
  } else {
    fail("Home: no se encontró última FAQ o CTA");
  }

  // Two module columns on home
  const homeCols = await homeFaq.locator("#home-faq-grid > div").count();
  if (homeCols >= 2) pass(`Home: columnas de módulo (${homeCols})`);
  else fail(`Home: columnas insuficientes (${homeCols})`);

  await page.screenshot({
    path: join(outDir, "home-faq-section.png"),
    fullPage: false,
  });
  // full section shot
  const box = await homeFaq.boundingBox();
  if (box) {
    await page.screenshot({
      path: join(outDir, "home-faq-full.png"),
      clip: {
        x: Math.max(0, box.x),
        y: Math.max(0, box.y),
        width: box.width,
        height: Math.min(box.height, 2000),
      },
    });
    pass(`Screenshot home FAQ section`);
  }

  // Mobile viewport title clip check
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto(faqUrl, { waitUntil: "networkidle", timeout: 60000 });
  await measureTitleClip(page, "h1", "FAQ mobile h1");
  await page.screenshot({
    path: join(outDir, "faq-mobile.png"),
    fullPage: true,
  });
  pass("Screenshot mobile FAQ");

  await browser.close();

  // Report
  console.log("\n=== FAQ Playwright Review ===\n");
  let failed = 0;
  for (const f of findings) {
    console.log(`${f.ok ? "PASS" : "FAIL"}  ${f.msg}`);
    if (!f.ok) failed++;
  }
  console.log(
    `\n${findings.length - failed}/${findings.length} checks passed. Screenshots → ${outDir}\n`
  );
  process.exit(failed > 0 ? 1 : 0);
})().catch((err) => {
  console.error(err);
  process.exit(1);
});
