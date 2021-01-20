<?php
namespace App\Http\Controllers;

use App\Models\GazetteAd;
use Goutte\Client;
use Illuminate\Http\Request;

class GazetteFetchController extends Controller
{
    protected $baseUrl = "http://www.gazette.gov.mv/iulaan/page/";

    public function index()
    {
        return view('index');
    }

    public function getNews($page, Client $client) {

        $crawler = $client->request('GET',"{$this->baseUrl}{$page}");

        $rawArray = $crawler->filter('.items-list .items')->each(function($node) {
        
            $link = $node->filter('.read-more')->attr('href');

            $ad['_id'] = $this->getIdFromLink($link);
            $ad['title'] = substr($node->filter('.iulaan-title')->first()->text(), 0, 1023);
            $ad['type'] = $node->filter('.iulaan-type')->first()->text();
            $ad['office'] = $node->filter('.iulaan-office')->first()->text();
            $ad['due'] = $this->getDue($node);
            $ad['link'] = $link;             

            return $ad;
        
        });
        return GazetteAd::insert($rawArray);
    }

    public function getIdFromLink($link) {
        $matches = [];
        preg_match("/\d+$/", $link, $matches);
        return intval(array_pop($matches));
    }

    public function getDue($node) {

        $footerRowAllText = $node->filter('div.col-md-12')->last()->text();
        $footerRowAsArray = preg_split("/[\n,]+/",  $footerRowAllText);
        
        $footerRowCleanedUp = collect($footerRowAsArray)->map(function($item) {
            return trim($item);
        })->filter(function($item) {
            return $item != "";
        });
        
        return $deadLineText = $footerRowCleanedUp->filter(function($item){
            return preg_match("/ސުންގަޑި|Deadline/i", $item);
        })->first();

    }

}