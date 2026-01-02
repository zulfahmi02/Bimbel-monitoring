<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Landing Page
        $sitemap .= $this->addUrl(route('landing'), '1.0', 'daily');
        
        // Teacher Pages
        $sitemap .= $this->addUrl(route('teacher.login'), '0.8', 'weekly');
        $sitemap .= $this->addUrl(route('teacher.register'), '0.8', 'weekly');
        
        // Parent Pages
        $sitemap .= $this->addUrl(route('parent.login'), '0.8', 'weekly');
        $sitemap .= $this->addUrl(route('parent.register'), '0.8', 'weekly');
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    private function addUrl($loc, $priority = '0.5', $changefreq = 'monthly')
    {
        $lastmod = now()->toAtomString();
        
        return "<url>
            <loc>{$loc}</loc>
            <lastmod>{$lastmod}</lastmod>
            <changefreq>{$changefreq}</changefreq>
            <priority>{$priority}</priority>
        </url>";
    }
}
