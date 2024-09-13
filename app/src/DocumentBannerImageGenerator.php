<?php

namespace App\src;

use HeadlessChromium\BrowserFactory;

class DocumentBannerImageGenerator
{
    public function render(string $html)
    {
        $browser = (new BrowserFactory(config('chrome.binaries')))
            ->createBrowser([
                'windowSize' => [1168, 352],
            ]);

        $page = $browser->createPage();

        $page->setViewport(1168, 352);
        $page->setHtml($html);

        return base64_decode($page->screenshot()->getBase64());
    }
}
