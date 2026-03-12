const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  page.on('console', msg => console.log('PAGE LOG:', msg.text()));
  page.on('pageerror', err => console.log('PAGE ERROR:', err.message));
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle2' });
  const navbarStyle = await page.$eval('#navbar', el => el.getAttribute('style'));
  console.log('Navbar inline styles:', navbarStyle);
  const navbarOpacity = await page.$eval('#navbar', el => window.getComputedStyle(el).opacity);
  console.log('Navbar computed opacity:', navbarOpacity);
  const navbarDisplay = await page.$eval('#navbar', el => window.getComputedStyle(el).display);
  console.log('Navbar computed display:', navbarDisplay);
  const navbarZIndex = await page.$eval('#navbar', el => window.getComputedStyle(el).zIndex);
  console.log('Navbar computed zIndex:', navbarZIndex);
  await browser.close();
})();
