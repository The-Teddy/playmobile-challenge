<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WebScraping;

class WebScrapingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $retryAfter = 3 * 60;
    /**
     * Create a new job instance.
     */

    public $startingPosition;

    public function __construct($startingPosition)
    {
       $this->startingPosition = $startingPosition;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   

        $url = 'http://www.finep.gov.br/chamadas-publicas/chamadapublica/' . $this->startingPosition;
        $selfUrl = 'http://localhost:3000/notice/finep/' . $this->startingPosition;
        
        $content = file_get_contents($url);
        $string = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

        preg_match_all('/<div class="item_fields page-header">(.+)<\/div>/s', $string, $matches);

        if(!empty($matches[0])) {

            $doc = new \DOMDocument();
            @$doc->loadHTML($matches[0][0]);
                        
            $arrayTitle = $doc->getElementsByTagName("h2");
            $title = trim(preg_replace("/[\r\n]+/", " ", $arrayTitle[0]->nodeValue));


            $arrayDescription = $doc->getElementsByTagName('p');
            $filteredDescription = [];

            foreach($arrayDescription as $item) { 
            
                $endString = substr(trim(preg_replace("/[\r\n]+/", " ", $item->nodeValue)), 0, 50);

                if(preg_match('/Em caso de dúvidas e orientações sobre o edital/', $endString)) {
                break;
                }

                $filteredDescription[] = trim(preg_replace("/[\r\n]+/", " ", $item->nodeValue));
            
            
            }

            $descriptionString = implode(' ', $filteredDescription);

            preg_match_all('/<div class="text">(.+)<\/div>/s', $string, $matchesGroup);
            @$doc->loadHTML($matchesGroup[0][0]);


            $arraySchedule = $doc->getElementsByTagName("div");
            $filteredDates = [];

            foreach($arraySchedule as $item) {

                $schedule = trim(preg_replace("/[\r\n]+/", " ", $item->nodeValue));
                
                if(preg_match('/\d{2}\/\d{2}\/\d{4}/', $schedule)) {
                    $filteredDates[] = $schedule;      
                }   
                
            }

            $getIndexPublicationDate = explode(' ', $filteredDates[0]);
            $getPublicationDate = $getIndexPublicationDate[count($getIndexPublicationDate) - 1];
            $deadlineDate = '';

            if(!preg_match('/Documentos/', $filteredDates[2])) {
                $getIndexDeadlinenDate = explode(' ', $filteredDates[3]);
                $getDeadlineDate = $getIndexDeadlinenDate[count($getIndexDeadlinenDate) - 1];
                $deadlineDate = $getDeadlineDate;
            }
            
            WebScraping::create([
                'type'              => 'notice',
                'id'                => $this->startingPosition,
                'title'             => $title,
                'description'       => $descriptionString,
                'publication'       => $getPublicationDate,
                'deadline'          => $deadlineDate,
                'url'               => $url,
                'self'              => $selfUrl
            ]);
        }
    }
}
