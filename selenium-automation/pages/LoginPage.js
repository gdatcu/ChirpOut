const { By, Key, until } = require('selenium-webdriver');
const BasePage = require('./BasePage');


class LoginPage extends BasePage {
  constructor(driver) {
    super(driver);
    this.url = 'http://localhost:8080/chirpout/register.php';
    this.emailField = By.id('emailId');
    this.passwordField = By.id('passwordId');
  }

  async navigateTo() {
    await this.driver.get(this.url);
  }

  async login(email, password) {
    await this.navigateTo();
    let emailField = await this.waitForElement(this.emailField);

    // Log elements properties
    let isDisplayedEmail = await emailField.isDisplayed();
    let isEnabledEmail = await emailField.isEnabled();
    let tagNameEmail = await emailField.getTagName();
    let rectEmail = await emailField.getRect();
    console.log(`Email address field - isDisplayed: ${isDisplayedEmail}, isEnabled: ${isEnabledEmail}, tagName: ${tagNameEmail}, rect: ${JSON.stringify(rectEmail)}`);
    await emailField.sendKeys(email, Key.TAB);

    let passwordField = await this.waitForElement(this.passwordField);
    let isDisplayedPassword = await passwordField.isDisplayed();
    let isEnabledPassword = await passwordField.isEnabled();
    let tagNamePassword = await passwordField.getTagName();
    let rectPassword = await passwordField.getRect();
    console.log(`Password field - isDisplayed: ${isDisplayedPassword}, isEnabled: ${isEnabledPassword}, tagName: ${tagNamePassword}, rect: ${JSON.stringify(rectPassword)}`);
    await passwordField.sendKeys(password, Key.RETURN);
  }
}

module.exports = LoginPage;
