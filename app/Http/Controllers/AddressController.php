<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Street;
use App\Models\Ward;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::all();
        $selectedCountry = $request->input('country');
        $selectedCity = $request->input('city');
        $selectedDistrict = $request->input('district');
        $selectedWard = $request->input('ward');
        $selectedStreet = $request->input('street');

        $cities = $selectedCountry ? City::where('country_id', $selectedCountry)->get() : [];
        $districts = $selectedCity ? District::where('city_id', $selectedCountry)->get() : [];
        $wards = $selectedDistrict ? Ward::where('district_id', $selectedCountry)->get() : [];
        $streets = $selectedWard ? Street::where('ward_id', $selectedCountry)->get() : [];

        $addressString = '';
        if ($selectedCountry && $selectedCity && $selectedDistrict && $selectedWard && $selectedStreet) {
            $country = Country::find($selectedCountry);
            $city = City::find($selectedCity);
            $district = District::find($selectedDistrict);
            $ward = Ward::find($selectedWard);
            $street = Street::find($selectedStreet);
            $addressString = $street->name . ', ' . $ward->name . ', ' . $district->name . ', ' . $city->name . ', ' . $country->name . '.';
        }

        return view('index', [
            'countries' => $countries,
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards,
            'streets' => $streets,
            'selectedCountry' => $selectedCountry,
            'selectedCity' => $selectedCity,
            'selectedDistrict' => $selectedDistrict,
            'selectedWard' => $selectedWard,
            'selectedStreet' => $selectedStreet,
            'addressString' => $addressString,
        ]);
    }



    public function storeAddress(Request $request)
    {
        $country = Country::firstOrCreate([
            'name' => $request->country_name
        ]);
        $city = City::firstOrCreate([
            'name' => $request->city_name,
            'country_id' => $country->id
        ]);
        $district = District::firstOrCreate([
            'name' => $request->district_name,
            'city_id' => $city->id
        ]);
        $ward = Ward::firstOrCreate([
            'name' => $request->ward_name,
            'district_id' => $district->id
        ]);
        $street = Street::firstOrCreate([
            'name' => $request->street_name,
            'ward_id' => $ward->id
        ]);

        return redirect('/index')->with('success', 'address has been add successfully');
    }
}
