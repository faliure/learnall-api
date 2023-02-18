<?php

namespace App\Console\Commands\DataImport;

use App\Models\Language;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportDuome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:duome {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap Duome vocabulary pages to import all learnables';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $languages = Language::all();

        foreach ($languages as $from) {
            foreach ($languages as $to) {
                if ($from->isNot($to)) {
                    $this->importDuome($from->code, $to->code);
                }
            }
        }
    }

    protected function importDuome(string $fromCode, string $toCode): void
    {
        $output = database_path("data/duome/{$fromCode}-{$toCode}.json");

        if (file_exists($output) && ! $this->option('force')) {
            return;
        }

        $this->info("Attempting $fromCode > $toCode after cooldown...");

        sleep(random_int(2, 3));

        $words = $this->getWordsNodeList($fromCode, $toCode);

        if (! $words->count()) {
            $this->warn("No learnables found. Skipping.");

            return;
        }

        $items = $this->parseWordsList($words);

        $this->info("Found {$words->count()} learnables. Saving to $output...");

        File::put($output, json_encode($items, JSON_UNESCAPED_UNICODE));
    }

    protected function getWordsNodeList(string $fromCode, string $toCode): DOMNodeList
    {
        $url  = "https://duome.eu/vocabulary/{$fromCode}/{$toCode}/skills";
        $html = file_get_contents($url);

        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_NOERROR);

        $xpath = new DOMXPath($doc);

        return $xpath->query("//div[@id='words']/ul/li[not(@class)]");
    }

    protected function parseWordsList(DOMNodeList $words): array
    {
        $xpath = new DOMXPath($words->item(0)->ownerDocument);

        foreach ($words as $word) {
            $categoryNode     = $xpath->query("*[contains(@class,'work')]", $word)->item(0);
            $metadataNode     = $xpath->query("*[contains(@class,'wA')]", $word)->item(0);
            $partOfSpeechNode = $xpath->query("*[contains(@class,'wP')]", $word)->item(0);

            preg_match(
                '#^(?:\[(.+?)\])?\s*(.+)$#',
                $metadataNode->attributes->getNamedItem('title')->nodeValue,
                $metadata
            );

            $items[] = [
                'category'     => $categoryNode->attributes->getNamedItem('title')->nodeValue,
                'learnable'    => $metadataNode->textContent,
                'normalized'   => trim($metadata[1] ?? '') ?: null,
                'translation'  => trim($metadata[2] ?? '') ?: null,
                'partOfSpeech' => trim($partOfSpeechNode->textContent, '· ') ?: null,
            ];
        }

        return $items;
    }
}
