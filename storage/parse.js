import puppeteer from 'puppeteer';

const getCategoryArticles = async (categoryUrl, maxArticles) => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    await page.goto(categoryUrl);

    let articles = [];
    let previousArticleCount = 0;
    let scrollAttempts = 0;

    while (articles.length < maxArticles && scrollAttempts < 10) {
        await page.evaluate('window.scrollTo(0, document.body.scrollHeight)');
        await new Promise(resolve => setTimeout(resolve, 2000));

        articles = await page.evaluate(() => {
            const articles = [];

            document.querySelectorAll('.article-preview-mixed').forEach((articleElement) => {
                const link = articleElement.querySelector('a').href;
                const title = articleElement.querySelector('.preview-title').innerText;

                articles.push({title, link});
            });

            return articles;
        });

        if (articles.length === previousArticleCount) {
            scrollAttempts++;
        } else {
            previousArticleCount = articles.length;
            scrollAttempts = 0;
        }
    }

    await browser.close();

    return articles.slice(0, maxArticles);
};


(async () => {
    const categoryUrl = process.argv[2];
    const maxArticles = 500; // Указать желаемое количество статей

    try {
        const articles = await getCategoryArticles(categoryUrl, maxArticles);
        console.log(JSON.stringify(articles));
    } catch (error) {
        console.error('Ошибка:', error);
    }
})();
