from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Main page
    page.goto("http://localhost:8080")
    page.screenshot(path="jules-scratch/verification/main_page.png")

    # Settings page
    page.goto("http://localhost:8080/settings.php")
    page.screenshot(path="jules-scratch/verification/settings_page.png")

    # Gallery page
    page.goto("http://localhost:8080/gallery.php")
    page.screenshot(path="jules-scratch/verification/gallery_page.png")

    # Tarhim player page
    page.goto("http://localhost:8080/tarhim.php")
    page.screenshot(path="jules-scratch/verification/tarhim_player_page.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)