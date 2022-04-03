<?php
class GmapApi {

    private static $apikey = 'AIzaSyCmFA_1v9V7XFu4SSxoePCSVNep9yFIsW0';

    public static function geocodeAddress($address) {
        //valeurs vide par défaut
        $data = array('address' => '', 'lat' => '', 'lng' => '');
        //on formate l'adresse
        $address = str_replace(" ", "+", $address);
        //on fait l'appel à l'API google map pour géocoder cette adresse
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=" . self::$apikey . "&address=$address&sensor=false&region=fr");
        $json = json_decode($json);
        var_dump($json);
        //on enregistre les résultats recherchés
        if ($json->status == 'OK' && count($json->results) > 0) {
            $res = $json->results[0];

            //adresse complète et latitude/longitude
            $data['address'] = $res->formatted_address;
            $data['lat'] = $res->geometry->location->lat;
            $data['lng'] = $res->geometry->location->lng;
        }
        var_dump($data);
        return $data;
    }

    /**
     * Retourne la distance en metre ou kilometre (si $unit = 'k') entre deux latitude et longitude fournit
     */
    public static function distance($lat1, $lng1, $lat2, $lng2, $unit = 'k') {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
        //
        $meter = ($earth_radius * $d);
        if ($unit == 'k') {
            return $meter / 1000;
        }
        return $meter;
    }

    public function geoLoc(string $id) : string {

        $gens = new User((int) $id);
        $adr = urlencode($gens->addFull());
        $curl = curl_init('https://eu1.locationiq.com/v1/search.php?key=pk.59b3ed2db9d2f8857160be9eaeafa19a&q=' . $adr . '&format=json');

        curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER    =>  true,
          CURLOPT_FOLLOWLOCATION    =>  true,
          CURLOPT_MAXREDIRS         =>  10,
          CURLOPT_TIMEOUT           =>  30,
          CURLOPT_CUSTOMREQUEST     =>  'GET',
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo 'cURL Error #:' . $err;
        } else {
          return $response;
        }
    }

}
