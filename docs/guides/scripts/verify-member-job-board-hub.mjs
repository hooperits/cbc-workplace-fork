/**
 * Playwright review of member Bolsa de Trabajo hub UI.
 * Usage: node scripts/verify-member-job-board-hub.mjs [baseUrl] [email] [password]
 */
import { chromium } from "playwright";
import { mkdirSync } from "fs";
import { dirname, join } from "path";
import { fileURLToPath } from "url";

const base = process.argv[2] || "http://localhost";
const email = process.argv[3] || "demo@iglesia.test";
const password = process.argv[4] || "password";
const __dir = dirname(fileURLToPath(import.meta.url));
const outDir = join(__dir, "../screenshots/member-jb-hub");
mkdirSync(outDir, { recursive: true });

const findings = [];
const pass = (msg) => findings.push({ ok: true, msg });
const fail = (msg) => findings.push({ ok: false, msg });

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage({ viewport: { width: 1280, height: 900 } });

  // —— Login ——
  const loginRes = await page.goto(`${base}/member/login`, {
    waitUntil: "networkidle",
    timeout: 60000,
  });
  if (!loginRes?.ok()) fail(`Login page HTTP ${loginRes?.status()}`);
  else pass(`Login page carga (${loginRes.status()})`);

  // Filament Livewire fields
  const emailSel = page.locator('input[id="data.email"], input[type="email"]').first();
  const passSel = page.locator('input[id="data.password"], input[type="password"]').first();
  await emailSel.fill(email);
  await passSel.fill(password);
  await page.locator('button[type="submit"]').first().click();

  try {
    // Must leave /member/login (regex /member/ alone matches the login URL)
    await page.waitForURL(
      (url) =>
        url.pathname.startsWith("/member") &&
        !url.pathname.includes("/login") &&
        !url.pathname.includes("/register"),
      { timeout: 25000 }
    );
    pass(`Login redirige a ${page.url()}`);
  } catch {
    // Livewire may not change URL immediately — try force navigate after wait
    await page.waitForTimeout(2000);
    if (page.url().includes("/login")) {
      fail(`Login falló (URL: ${page.url()})`);
      await page.screenshot({ path: join(outDir, "login-fail.png"), fullPage: true });
      await browser.close();
      report();
      process.exit(1);
    }
    pass(`Login parece OK (URL: ${page.url()})`);
  }

  await page.waitForLoadState("networkidle");

  if (page.url().includes("email-verification")) {
    fail("Cuenta requiere verificación de email — no se puede revisar el hub");
    await page.screenshot({ path: join(outDir, "email-verify.png"), fullPage: true });
    await browser.close();
    report();
    process.exit(1);
  }

  // Go explicitly to hub
  await page.goto(`${base}/member/bolsa-de-trabajo`, {
    waitUntil: "networkidle",
    timeout: 60000,
  });
  await page.waitForTimeout(800);

  if (page.url().includes("/login")) {
    fail("Sesión no persistió; redirigido a login al abrir el hub");
    await page.screenshot({ path: join(outDir, "session-lost.png"), fullPage: true });
    await browser.close();
    report();
    process.exit(1);
  }

  if (page.url().includes("bolsa-de-trabajo")) pass(`Hub URL: ${page.url()}`);
  else pass(`Hub-ish URL: ${page.url()}`);

  const body = await page.locator("body").innerText();

  // Content checks
  if (body.includes("Busco empleo")) pass('Card "Busco empleo" visible');
  else fail('Card "Busco empleo" no encontrada');

  if (body.includes("Quiero contratar")) pass('Card "Quiero contratar" visible');
  else fail('Card "Quiero contratar" no encontrada');

  if (body.includes("Accesos rápidos") || body.includes("accesos rápidos")) {
    pass("Sección accesos rápidos visible");
  } else {
    fail("Sección accesos rápidos no encontrada");
  }

  // Progress bars (2 expected)
  const progressBars = await page.locator(".ldf-jb-hub .bg-gradient-to-r.h-full, .ldf-jb-hub [style*='width']").count();
  // Simpler: look for progress track containers
  const tracks = await page.locator(".ldf-jb-hub .h-1\\.5").count();
  if (tracks >= 2) pass(`Barras de progreso: ${tracks}`);
  else fail(`Barras de progreso insuficientes: ${tracks}`);

  // Primary CTAs (2 large buttons on cards)
  const primaryCtAs = await page.locator(".ldf-jb-hub a.bg-cyan-600, .ldf-jb-hub a.bg-amber-600").count();
  if (primaryCtAs >= 2) pass(`CTAs primarios de color: ${primaryCtAs}`);
  else fail(`CTAs primarios insuficientes: ${primaryCtAs}`);

  // Colored quick-link icon boxes
  const coloredIcons = await page.locator(".ldf-jb-hub a .rounded-xl.border").count();
  // quick link icons have h-10 w-10 rounded-xl border
  const iconBoxes = await page.locator('.ldf-jb-hub a span.inline-flex.h-10.w-10').count();
  if (iconBoxes >= 4) pass(`Iconos de color en accesos rápidos: ${iconBoxes}`);
  else {
    // fallback count SVGs in quick links section
    const svgs = await page.locator(".ldf-jb-hub section a svg").count();
    if (svgs >= 4) pass(`SVGs en accesos rápidos: ${svgs}`);
    else fail(`Pocos iconos en accesos rápidos (boxes=${iconBoxes}, svgs=${svgs})`);
  }

  // Checklist colored icons (teal/amber/sky boxes)
  const checklistIcons = await page.locator(".ldf-jb-hub ol li span.rounded-lg").count();
  if (checklistIcons >= 4) pass(`Iconos checklist coloreados: ${checklistIcons}`);
  else fail(`Checklist icons: ${checklistIcons}`);

  // Membership pill in topbar
  const pill = page.locator("span").filter({ hasText: /Afiliado|Registrado/i });
  if ((await pill.count()) > 0) pass("Pill Afiliado/Registrado en topbar");
  else fail("Pill de membresía no visible");

  // Status chips (optional depending on member state)
  const chips = await page.locator(".ldf-jb-hub header span.rounded-full, .ldf-jb-hub .rounded-full.border").count();
  if (chips >= 1) pass(`Chips de estado: ${chips}`);
  else pass("Sin chips de estado (ok si no aplica)");

  // Screenshot desktop hub
  await page.screenshot({
    path: join(outDir, "hub-desktop.png"),
    fullPage: true,
  });
  pass(`Screenshot: hub-desktop.png`);

  // Click primary CTA if present and ensure navigation works
  const cta = page.locator(".ldf-jb-hub a.bg-cyan-600").first();
  if ((await cta.count()) > 0) {
    const href = await cta.getAttribute("href");
    if (href && href.length > 1) pass(`CTA candidato href: ${href}`);
    else fail("CTA candidato sin href");
  }

  // Mobile viewport
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto(`${base}/member/bolsa-de-trabajo`, {
    waitUntil: "networkidle",
    timeout: 60000,
  });
  await page.waitForTimeout(400);
  const mobileBody = await page.locator("body").innerText();
  if (mobileBody.includes("Busco empleo") && mobileBody.includes("Quiero contratar")) {
    pass("Hub mobile muestra ambas cards");
  } else {
    fail("Hub mobile incompleto");
  }
  await page.screenshot({
    path: join(outDir, "hub-mobile.png"),
    fullPage: true,
  });
  pass("Screenshot: hub-mobile.png");

  // Quick visual: no horizontal overflow on hub
  const overflow = await page.evaluate(() => {
    const el = document.querySelector(".ldf-jb-hub");
    if (!el) return null;
    return {
      scrollWidth: document.documentElement.scrollWidth,
      clientWidth: document.documentElement.clientWidth,
    };
  });
  if (overflow && overflow.scrollWidth > overflow.clientWidth + 4) {
    fail(`Overflow horizontal (${overflow.scrollWidth} > ${overflow.clientWidth})`);
  } else {
    pass("Sin overflow horizontal notable");
  }

  await browser.close();
  report();
  process.exit(findings.some((f) => !f.ok) ? 1 : 0);

  function report() {
    console.log("\n=== Member Job Board Hub — Playwright Review ===\n");
    let failed = 0;
    for (const f of findings) {
      console.log(`${f.ok ? "PASS" : "FAIL"}  ${f.msg}`);
      if (!f.ok) failed++;
    }
    console.log(
      `\n${findings.length - failed}/${findings.length} checks passed. Screenshots → ${outDir}\n`
    );
  }
})().catch((err) => {
  console.error(err);
  process.exit(1);
});
