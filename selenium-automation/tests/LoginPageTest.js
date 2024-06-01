const { Builder } = require('selenium-webdriver');
const LoginPage = require('../pages/LoginPage');
const { BASE_URL, VALID_USERNAME, VALID_PASSWORD } = require('../constants/Constants');
const assert = require('assert');

describe('Login Page Tests', function() {
  this.timeout(30000); // Extend default Mocha timeout if needed

  let driver;

  beforeEach(async function() {
    driver = await new Builder().forBrowser('chrome').build();
  });

  afterEach(async function() {
    await driver.quit();
  });

  it('should login with valid credentials', async function() {
    const loginPage = new LoginPage(driver);

    // Navigate to the login page
    await loginPage.navigateTo();

    // Take a screenshot before any interactions
    await loginPage.takeScreenshot('LoginPageTest_before_interaction_valid_login.png');
    
    // Assert that the URL and Page title are correct
    let currentUrl = await driver.getCurrentUrl();
    let initialTitle = await driver.getTitle();
    assert.strictEqual(currentUrl, BASE_URL, `URL should be '${BASE_URL}'`);
    assert.strictEqual(initialTitle, 'Welcome to ChirpOut', `Page title should be 'Welcome to ChirpOut'`);

    // Perform login action
    await loginPage.login(VALID_USERNAME, VALID_PASSWORD);

    // Add assertions for successful login
    let homePageUrl = 'http://localhost:8080/demo/index.php'; // Assuming the home page URL
    let newUrl = await driver.getCurrentUrl();
    assert.strictEqual(newUrl, homePageUrl, 'URL should be the home page URL after login');

    // Take a screenshot after login validation
    await loginPage.takeScreenshot('LoginPageTest_after_interaction_valid_login.png');
  });

  it('should not login with invalid credentials', async function() {
    const loginPage = new LoginPage(driver);

    // Take a screenshot before any interactions
    await loginPage.takeScreenshot('LoginPageTest_before_interaction_invalid_login.png');

    // Navigate to the login page
    await loginPage.navigateTo();

    // Assert that the URL and Page title are correct
    let currentUrl = await driver.getCurrentUrl();
    let initialTitle = await driver.getTitle();
    assert.strictEqual(currentUrl, BASE_URL, `URL should be '${BASE_URL}'`);
    assert.strictEqual(initialTitle, 'Welcome to ChirpOut', `Page title should be 'Welcome to ChirpOut'`);

    // Perform invalid login action
    await loginPage.login('invalid@example.com', 'invalidPassword');

    // Add assertions for failed login
    let newUrl = await driver.getCurrentUrl();
    assert.strictEqual(newUrl, currentUrl, 'URL should remain the login page URL after failed login');
    let newTitle = await driver.getTitle();
    assert.strictEqual(newTitle, initialTitle, `Page title should remain 'Welcome to ChirpOut'`);

    // Take a screenshot after invalid login validation
    await loginPage.takeScreenshot('LoginPageTest_after_interaction_invalid_login.png');
  });
});
