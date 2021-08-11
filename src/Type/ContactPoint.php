<?php
namespace Plinct\Soloine\Type;

class ContactPoint {

    public static function sort($data): string {

        foreach ($data as $value) {
            $telephones[] = [
                "number" => $value['telephone'],
                "whatsapp" => $value['whatsapp']
            ];
        }

        $response = [
            "@type"=>"ContactPoint",
            "telephones" => [

            ]
        ];
        return json_encode($response);
    }
}