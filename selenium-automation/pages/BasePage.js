const { By, until } = require('selenium-webdriver');
const fs = require('fs');

class BasePage {
  constructor(driver) {
    this.driver = driver;
  }

  async waitForElement(selector, timeout = 10000) {
    await this.driver.wait(until.elementLocated(selector), timeout);
    return await this.driver.findElement(selector);
  }

  async waitForElementVisible(selector, timeout = 10000) {
    let element = await this.waitForElement(selector, timeout);
    await this.driver.wait(until.elementIsVisible(element), timeout);
    return element;
  }

  async waitForElementEnabled(selector, timeout = 10000) {
    let element = await this.waitForElement(selector, timeout);
    await this.driver.wait(async () => {
      return await element.isEnabled();
    }, timeout);
    return element;
  }

  async navigateTo(url) {
    await this.driver.get(url);
  }

  async getCurrentUrl() {
    return await this.driver.getCurrentUrl();
  }

  async getTitle() {
    return await this.driver.getTitle();
  }

  async takeScreenshot(filename) {
    let screenshot = await this.driver.takeScreenshot();
    fs.writeFileSync(filename, screenshot, 'base64');
  }

  // Add more utility methods as needed...
}

module.exports = BasePage;
