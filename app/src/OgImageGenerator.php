<?php

namespace App\src;

use HeadlessChromium\BrowserFactory;

class OgImageGenerator
{
    public function render(string $html)
    {
        $browser = (new BrowserFactory(config('chrome.binaries')))->createBrowser([
            'windowSize' => [1200, 630],
        ]);

        $page = $browser->createPage();

        $page->setHtml($html);

        return base64_decode($page->screenshot()->getBase64());
    }
}
