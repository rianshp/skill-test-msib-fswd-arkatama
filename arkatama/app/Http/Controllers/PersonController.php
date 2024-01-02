<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;


class PersonController extends Controller
{
    public function store(Request $request)
{
    $data = explode(' ', $request->input('data'));

    $ageIndex = $this->findAgeIndex($data);

    if (count($data) >= 3 && $ageIndex !== null) {
        $name = strtoupper(implode(' ', array_slice($data, 0, $ageIndex)));
        $age = $this->extractAge($data[$ageIndex]);
        $city = $this->extractCity($data, $ageIndex + 1); 

        if ($age !== null && $city !== null) {
            $person = new Person();
            $person->name = $name;
            $person->age = $age;
            $person->city = $city;
            $person->save();

            return response()->json(['message' => 'Data saved successfully'], 200);
        }
    }

    return response()->json(['message' => 'Invalid data format'], 400);
}

private function findAgeIndex($data)
{    
    foreach ($data as $index => $value) {
        if (preg_match('/tahun|\d+/', strtolower($value))) {
            return $index;
        }
    }

    return null;
}

private function extractAge($ageString)
{
    $cleanedAgeString = strtoupper(preg_replace('/[^0-9]/', '', $ageString));
    $age = filter_var($cleanedAgeString, FILTER_SANITIZE_NUMBER_INT);

    if ($age !== false && $age !== '') {
        return $age;
    }

    return null;
}

private function extractCity($data, $startIndex)
{
    $city = '';

    for ($i = $startIndex + 1; $i < count($data); $i++) {
        $word = strtolower($data[$i]);

        if (preg_match('/\d+/', $word) || preg_match('/\d+(tahun|thn|th)/', $word)) {
            break;
        }

        if ($word !== '') {
            $city .= strtoupper($data[$i]) . ' ';
        }
    }

    return trim($city);
}

    


}
