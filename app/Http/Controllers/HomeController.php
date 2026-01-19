<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\popup;
use App\Mail\kwikinsurance;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
      public function load()
    {
        return view('load');
    }
    public function payment()
    {
        return view('makepayment');
    }
    public function trucking()
    {
        return view('trucking');
    }
    public function compensation()
    {
        return view('compensation');
    }
    public function liability()
    {
        return view('liability');
    }
    public function bond()
    {
        return view('bond');
    }
    public function proofinsurance()
    {
        return view('proofinsurance');
    }
    public function freeconsultation()
    {
        return view('freeconsultation');
    }
    public function truckinginsurance()
    {
        return view('truckinginsurance');
    }
    public function liabilityinsurance()
    {
        return view('liabilityinsurance');
    }
    public function autoinsurance()
    {
        return view('autoinsurance');
    }
    public function bondinsurance()
    {
        return view('bondinsurance');
    }
    public function about()
    {
        return view('about');
    }
    public function privacypolicy()
    {
        return view('privacypolicy');
    }
    public function tc()
    {
        return view('tc');
    }
    public function carrierinsurance()
    {
        return view('carrierinsurance');
    }
    public function refer()
    {
        return view('refer');
    }
    public function contact()
    {
        return view('contact');
    }
    public function quotes()
    {
        return view('quotes');
    }
    public function service()
    {
        return view('service');
    }
    public function insurance()
    {
        return view('insurance');
    }
    public function workerscompensation()
    {
        return view('workerscompensation');
    }
    public function agencygallery()
    {
        return view('agencygallery');
    }
    public function autoinsurancequote()
    {
        return view('autoinsurancequote');
    }
    public function onlinerater()
    {
        return view('front.login');
    }
     public function popup_store(Request $req){
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $popup = new popup();
        $popup->name = $req->name;
        $popup->company = $req->company;
        $popup->email = $req->email;
        $popup->phone = $req->phone;
        $popup->message = $req->message;
        $popup->ip = $req->ip();
        $popup->save();

if(empty($req->age)){
    $title = "Contact Form Enquiry";
}else{
    $title = "Load Enquiry";
}
        $maildata = [
            'name'=>$req->name,
            'email'=>$req->email,
            'company_name'=>$req->company,
            'phone'=>$req->phone,
            'message'=>$req->message,
            'age'=>$req->age,
            'title'=>$title,
        ];

        Mail::to('sales@kwikinsurances.com')->send(new kwikinsurance($maildata));

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
    public function generateSitemap()
    {
        // Define the sitemap content
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>' . url('/') . '</loc>
                <lastmod>' . now()->toDateString() . '</lastmod>
                <priority>1.0</priority>
            </url>
            <url>
                <loc>' . url('/about') . '</loc>
                <lastmod>' . now()->toDateString() . '</lastmod>
                <priority>0.8</priority>
            </url>
            <url>
                <loc>' . url('/contact') . '</loc>
                <lastmod>' . now()->toDateString() . '</lastmod>
                <priority>0.8</priority>
            </url>
        </urlset>';

        // Save the sitemap.xml file in the public directory
        $filePath = public_path('sitemap.xml');
        File::put($filePath, $sitemap);

        return response()->json(['message' => 'Sitemap successfully created!', 'path' => $filePath]);
    }
}
