import { chromium } from 'playwright';

async function testWpAdmin() {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();

  console.log('1. Navigating to http://localhost:8891/wp-admin/ ...');
  try {
    const response = await page.goto('http://localhost:8891/wp-admin/', { waitUntil: 'networkidle', timeout: 15000 });
    console.log('Final URL:', page.url());
    console.log('Page Title:', await page.title());
    console.log('Status Code:', response?.status());
    
    await page.screenshot({ path: 'wp-admin-test-1.png' });
    console.log('Screenshot saved to wp-admin-test-1.png');

    // Check if login form exists
    const userField = await page.$('#user_login');
    const passField = await page.$('#user_pass');
    const submitBtn = await page.$('#wp-submit');

    if (userField && passField) {
      console.log('2. Login form detected! Filling credentials...');
      await userField.fill('admin');
      await passField.fill('mitsa_admin_local');
      console.log('Submitting login form...');
      await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle', timeout: 15000 }),
        submitBtn.click()
      ]);

      console.log('After login URL:', page.url());
      console.log('After login Page Title:', await page.title());
      await page.screenshot({ path: 'wp-admin-test-after-login.png' });
      console.log('Screenshot saved to wp-admin-test-after-login.png');

      const isDashboard = page.url().includes('wp-admin') && (await page.$('#wpbody')) !== null;
      console.log('Is Dashboard loaded successfully?', isDashboard);
    } else {
      console.log('Login form fields NOT found on page! Current HTML body snippet:');
      const bodyText = await page.evaluate(() => document.body.innerText.slice(0, 300));
      console.log(bodyText);
    }
  } catch (err) {
    console.error('Test Error:', err);
  } finally {
    await browser.close();
  }
}

testWpAdmin();
