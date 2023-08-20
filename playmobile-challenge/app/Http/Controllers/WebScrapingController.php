<?php

namespace App\Http\Controllers;

use App\Models\WebScraping;
use App\Jobs\WebScrapingJob;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;

class WebScrapingController extends Controller
{
  function startScraping() {

      $startingId = request()->sp ? request()->sp : 700;
      $qtdItens = request()->qt   ? request()->qt : 10;
      $i = 0;

      if($startingId < 294) {
        $startingId = 294;
      }

      while ($i < $qtdItens) {

        WebScrapingJob::dispatch($startingId);

        $i++;
        $startingId+=1;
      } 

    return '<h1 style="display: flex; justify-content: center; margin: 200px 0;">Raspagem Iniciada</h1>';
  }

  function index() {

    $data = [];
    $webScraping =  WebScraping::all();
    
    $objectsArray = [];

    foreach ($webScraping as $item) {

      $data ['type'] = $item->type;
      $data ['id']   = $item->id;
      $data ['attributes']['title'] = $item->title;
      $data ['attributes']['description'] = $item->description;
      $data ['attributes']['schedule']['publication'] = $item->publication ;
      $data ['attributes']['schedule']['deadline'] = $item->deadline ;
      $data ['attributes']['source']['url'] = $item->url;
      $data ['attributes']['links']['self'] = $item->self;

      $objectsArray[] = $data;
    }

    return $objectsArray;
  }
  
  function show () {
    
    $webScraping = WebScraping::where('id', request()->id)->first();
    $data = [
      'type'  =>  $webScraping->type,
      'id'  =>  $webScraping->id,
      'attributes'  => [
        'title'   => $webScraping->title,
        'description' => $webScraping->description,
        'schedule'  => [
          'publication' => $webScraping->publication,
          'deadline'    => $webScraping->deadline,
        ],
        'source'      => [
          'url' =>  $webScraping->url
        ],
        'links'       => [
          'self'  =>  $webScraping->self
        ]
      ]
    ];
    return $data;
  }
}
