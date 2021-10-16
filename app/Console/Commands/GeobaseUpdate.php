<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class GeobaseUpdate extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'geobase:update';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Update geobase';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        $countriesCount = \DB::table('countries')->count();
        if ($countriesCount) {
            $this->info('Already generated');
            return;
        }
        */
        $base = storage_path('geonames');
        if (!file_exists($base)) {
            mkdir($base, 0777, true);
            $this->info('Created directory: ' . $base);
        }
        //$this->download('https://download.geonames.org/export/dump/allCountries.zip');
        //$this->download('https://download.geonames.org/export/dump/alternateNamesV2.zip');
        //$this->download('https://download.geonames.org/export/dump/cities15000.zip');
        //$this->unzip('allCountries.zip');
        //$this->unzip('alternateNamesV2.zip');
        //$this->unzip('cities15000.zip');

        $countries = new Collection;

        $fh = fopen($base . '/allCountries.txt', 'r');

        while(false&& !feof($fh)) {
            $line = fgets($fh);
            if (empty($line)) continue;
            $obj = explode("\t", $line);
            /*
            0 - geonameid         : integer id of record in geonames database
            1 - name              : name of geographical point (utf8) varchar(200)
            2 - asciiname         : name of geographical point in plain ascii characters, varchar(200)
            3 - alternatenames    : alternatenames, comma separated, ascii names automatically transliterated, convenience attribute from alternatename table, varchar(10000)
            4 - latitude          : latitude in decimal degrees (wgs84)
            5 - longitude         : longitude in decimal degrees (wgs84)
            6 - feature class     : see http://www.geonames.org/export/codes.html, char(1)
            7 - feature code      : see http://www.geonames.org/export/codes.html, varchar(10)
            8 - country code      : ISO-3166 2-letter country code, 2 characters
            9 - cc2               : alternate country codes, comma separated, ISO-3166 2-letter country code, 200 10 - characters
            11 - admin1 code       : fipscode (subject to change to iso code), see exceptions below, see file admin1Codes.txt for display names of this code; varchar(20)
            12 - admin2 code       : code for the second administrative division, a county in the US, see file admin2Codes.txt; varchar(80) 
            13 - admin3 code       : code for third level administrative division, varchar(20)
            14 - admin4 code       : code for fourth level administrative division, varchar(20)
            15 - population        : bigint (8 byte int) 
            16 - elevation         : in meters, integer
            17 - dem               : digital elevation model, srtm3 or gtopo30, average elevation of 3''x3'' (ca 90mx90m) or 30''x30'' (ca 900mx900m) area in meters, integer. srtm processed by cgiar/ciat.
            18 - timezone          : the iana timezone id (see file timeZone.txt) varchar(40)
            19 - modification date : date of last modification in yyyy-MM-dd format
            */
            if ($obj[6] == 'A' && ($obj[7] == 'PCLI' || $obj[7] == 'PCLS')) {
                //$this->info($obj[8] . ' - ' . $obj[1]);
                $countries->push([
                    'code' => $obj[8],
                    'name' => $obj[1],
                    'geonameid' => $obj[0]
                ]);
            }
            //if ($obj[1] != 'Ukraine') continue;
            //print_r($obj);
            //break;
        }

        fclose($fh);

        //$this->saveCountries($countries);
        $countries = DB::table('countries')->get();
        $this->info('Total countries: ' . $countries->count());

        $cities = new Collection;

        $fh = fopen($base . '/cities15000.txt', 'r');

        while(false&& !feof($fh)) {
            $line = fgets($fh);
            if (empty($line)) continue;
            $obj = explode("\t", $line);
            $country = $countries->where('code', $obj[8])->first();
            if (!$country) continue;

            $cities->push([
                'country_id' => $country->id,
                'name' => $obj[1],
                'geonameid' => $obj[0]
            ]);

            //print_r($obj);
            //break;
        }

        fclose($fh);

        //$this->saveCities($cities);
        $cities = DB::table('cities')->get();
        $this->info('Total cities: ' . $cities->count());

        $langsFilter = [
            'post',
            'iata',
            'icao',
            'faac',
            'fr_1793',
            'abbr',
            'link',
            'wkdt'
        ];

        $countryNames = new Collection;
        $cityNames = new Collection;

        $countriesGeonameids = $countries->pluck('geonameid')->toArray();
        $citiesGeonameids = $cities->pluck('geonameid')->toArray();

        $fh = fopen($base . '/alternateNamesV2.txt', 'r');

        while(!feof($fh)) {
            $line = fgets($fh);
            if (empty($line)) continue;
            $obj = explode("\t", $line);
            /*
            0 - alternateNameId   : the id of this alternate name, int
            1 - geonameid         : geonameId referring to id in table 'geoname', int
            2 - isolanguage       : iso 639 language code 2- or 3-characters; 4-characters 'post' for postal codes and 'iata','icao' and faac for airport codes, fr_1793 for French Revolution names,  abbr for abbreviation, link to a website (mostly to wikipedia), wkdt for the wikidataid, varchar(7)
            3 - alternate name    : alternate name or name variant, varchar(400)
            4 - isPreferredName   : '1', if this alternate name is an official/preferred name
            5 - isShortName       : '1', if this is a short name like 'California' for 'State of California'
            6 - isColloquial      : '1', if this alternate name is a colloquial or slang term. Example: 'Big Apple' for 'New York'.
            7 - isHistoric        : '1', if this alternate name is historic and was used in the past. Example 'Bombay' for 'Mumbai'.
            8 - from          : from period when the name was used
            9 - to        : to period when the name was used
            */
            if (!$obj[2]) continue;
            //if (!$obj[4]) continue;
            if ($obj[6]) continue;
            if ($obj[7]) continue;
            if (strlen($obj[2]) > 3 && strpos($obj[2], '-') == false) continue;
            //if ($obj[2] != 'ru') continue;
            /*
            $country = $countries->where('geonameid', $obj[1])->first();
            if ($country) {
                $countryName = $countryNames->where('geonameid', $obj[1])->where('lang', $obj[2])->first();

                if ($countryName) {
                    if ($countryName['preferred']) continue;
                    if (strlen($countryName['name']) < strlen($obj[3])) continue;
                    $countryNames = $countryNames->filter(function($cn) use ($countryName) {
                        return $cn != $countryName;
                    });
                }

                $countryNames->push([
                    'country_id' => $country->id,
                    'lang' => $obj[2],
                    'name' => $obj[3],
                    'geonameid' => $obj[1],
                    'alternatenameid' => $obj[0],
                    'preferred' => $obj[4] ? true : false
                ]);
            }
            */

            if (!in_array($obj[1], $citiesGeonameids)) continue;

            DB::table('temp_geo_names')->insert([
                'lang' => $obj[2],
                'name' => $obj[3],
                'geonameid' => $obj[1],
                'alternatenameid' => $obj[0],
                'preferred' => $obj[4] ? 1 : 0
            ]);

            //$this->info($obj[3]);

            continue;

            $city = DB::table('cities')->where('geonameid', $obj[1])->first();
            if ($city) {
                $cityName = $cityNames->where('geonameid', $obj[1])->where('lang', $obj[2])->first();

                if ($cityName) {
                    if ($cityName['preferred']) continue;
                    if (strlen($cityName['name']) < strlen($obj[3])) continue;
                    $cityNames = $cityNames->filter(function($cn) use ($cityName) {
                        return $cn != $cityName;
                    });
                }

                $cityNames->push([
                    'city_id' => $city->id,
                    'lang' => $obj[2],
                    'name' => $obj[3],
                    'geonameid' => $obj[1],
                    'alternatenameid' => $obj[0],
                    'preferred' => $obj[4] ? true : false
                ]);

                $this->info($obj[3]);
            }
        }

        fclose($fh);

        //DB::table('temp_geo_names')->whereNotIn('geonameid', $cities->pluck('geonameid'))->delete();
        //DB::table('temp_geo_names')->where('lang', '')->orWhereNull('lang')->delete();

        //$preferred = \DB::table('temp_geo_names')->where('preferred', 1)->get();
        
        //DB::table('temp_geo_names')
        //    ->where('preferred', 0)
        //    ->whereIn('geonameid', $preferred->pluck('geonameid'))
        //    ->delete();

        $preferred = [];

        DB::table('temp_geo_names')->orderBy('alternatenameid')->chunk(100, function($tempGeoNames) use ($preferred) {
            foreach ($tempGeoNames as $tempGeoName) {
                $pref = $tempGeoName->geonameid . '_' . $tempGeoName->lang;
                if (in_array($pref, $preferred)) continue;

                $cityName = DB::table('city_names')->where('geonameid', $tempGeoName->geonameid)->where('lang', $tempGeoName->lang)->first();

                if ($cityName) {
                    if (!$tempGeoName->preferred) {
                        if (strlen($cityName->name) < strlen($tempGeoName->name)) continue;
                    }
                    DB::table('city_names')->where('alternatenameid', $cityName->alternatenameid)->delete();
                }

                $city = DB::table('cities')->where('geonameid', $tempGeoName->geonameid)->first();

                DB::table('city_names')->insert([
                    'city_id' => $city->id,
                    'lang' => $tempGeoName->lang,
                    'name' => $tempGeoName->name,
                    'geonameid' => $tempGeoName->geonameid,
                    'alternatenameid' => $tempGeoName->alternatenameid
                ]);

                if ($tempGeoName->preferred) {
                    $preferred[] = $pref;
                }

                //$this->info($tempGeoName->name);
            }
        });

        //$this->saveCountryNames($countryNames);
        $this->info('Total country alternative names: ' . $countryNames->count());
        //$this->saveCityNames($cityNames);
        //$this->info('Total city alternative names: ' . $cityNames->count());
    }

    private function download($url)
    {
        $base = storage_path('geonames');
        $filename = basename($url);
        $path = $base . '/' . $filename;
        $this->info('Downloading: ' . $url);
        file_put_contents($path . '.tmp', fopen($url, 'rb'));
        rename($path . '.tmp', $path);
        $this->info('Downloaded: ' . $filename);
    }

    private function unzip($filename)
    {
        $base = storage_path('geonames');
        $path = $base . '/' . $filename;
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res) {
            $this->info('Unpacking: ' . $filename);
            $zip->extractTo($base);
            $zip->close();
            @unlink($path);
            $this->info('Unpacked: ' . $filename);
        } else {
            // TODO
        }
        
    }

    /**
     * @param $countries
     */
    private function saveCountries($countries)
    {
        $chunks = $countries->chunk(100);
        foreach ($chunks as $chunk) {
            DB::table('countries')->insert($chunk->toArray());
        }
    }

    /**
     * @param $countryNames
     */
    private function saveCountryNames($countryNames)
    {
        $countryNames = $countryNames->map(function ($cn) {
            unset($cn['preferred']);
            return $cn;
        });
        $chunks = $countryNames->chunk(100);
        foreach ($chunks as $chunk) {
            DB::table('country_names')->insert($chunk->toArray());
        }
    }

    private function saveCities($cities)
    {
        $chunks = $cities->chunk(100);
        foreach ($chunks as $chunk) {
            DB::table('cities')->insert($chunk->toArray());
        }
    }

    private function saveCityNames($cityNames)
    {
        $cityNames = $cityNames->map(function ($cn) {
            unset($cn['preferred']);
            return $cn;
        });
        $chunks = $cityNames->chunk(100);
        foreach ($chunks as $chunk) {
            DB::table('city_names')->insert($chunk->toArray());
        }
    }
}
