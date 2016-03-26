![travis-ci](https://travis-ci.org/neighborhood999/cyut-courses-crawler.svg?branch=master) [![Coverage Status](https://coveralls.io/repos/github/neighborhood999/cyut-courses-crawler/badge.svg?branch=master)](https://coveralls.io/github/neighborhood999/cyut-courses-crawler?branch=master)

# Cyut Courses Crawler

#### How To Use

`$ git clone https://github.com/neighborhood999/cyut-courses-crawler.git`  
`$ composer install`

### What Teach Use

- [Guzzle / PHP HTTP Client](https://github.com/guzzle/guzzle)
- [Symfony / Dom-Crawler](https://github.com/symfony/dom-crawler)
- [Symfony / Css-Selector](https://github.com/symfony/css-selector)
- [Illuminate / database](https://github.com/illuminate/database)
- [digitalnature / php-ref](https://github.com/digitalnature/php-ref)

`git clone` 並執行 `composer install` 之後，可以透過 `php -S localhost:3000` 執行一個 Server 來查看爬蟲爬取結果。  
`php-ref` 這個 package 是為了可以方便閱讀所爬下來的資訊是否正確。  

![](http://i.imgur.com/icKvlcv.png)

如果要取得其他學院課程資訊，請到 `index.php` 下修改參數就可以取得課程的資料，如果需要將課程資料爬取下來，在 `index.php` 將 `DB` 的註解拿掉，並到 `config/DB.php` 下去撰寫你的程式_（這段程式僅供參考，可以透過自己的方式來儲存到資料庫）_。

### Test
`$ vendor/bin/phpunit`（這個 test 應該不算正確的，不過就先這樣吧哈哈！）
