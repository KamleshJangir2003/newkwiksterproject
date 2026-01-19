<?php

namespace App\Http\Controllers;

use App\Mail\AutoInsuranceQuote;
use App\Mail\ContactMail;
use App\Mail\GeneralLiabilityQuote;
use App\Mail\InsuranceBondQuote;
use App\Mail\ReferFriendMail;
use App\Mail\TruckingInsuranceMail;
use App\Mail\TruckingInsuranceQuote;
use App\Mail\WorkerCompensationQuote;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function contactmail(Request $request)
    {
        $contactDetails = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'number' => $request->number,
            'comment' => $request->comment,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new ContactMail($contactDetails));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function truckingmail(Request $request)
    {
        $truckingdetail = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'vin' => $request->vin,
            'email' => $request->email,
            'number' => $request->number,
            'additional' => $request->additional,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new TruckingInsuranceMail($truckingdetail));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function truckingquote(Request $request)
    {
        $trucking = [
            'companyname' => $request->companyname,
            'email' => $request->email,
            'number' => $request->number,
            'dotno' => $request->dotno,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new TruckingInsuranceQuote($trucking));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function workercomp(Request $request)
    {
        $workercomp = [
            'businessname' => $request->businessname,
            'nofemploy' => $request->nofemploy,
            'industryname' => $request->industryname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'payroll' => $request->payroll,
            'email' => $request->email,
            'number' => $request->number,
            'comment' => $request->comment,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new WorkerCompensationQuote($workercomp));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function general(Request $request)
    {
        $general = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'number' => $request->number,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'additional' => $request->additional,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new GeneralLiabilityQuote($general));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function bondquote(Request $request)
    {
        $insurancebond = [
            'bondamount' => $request->bondamount,
            'businessname' => $request->businessname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'number' => $request->number,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'comment' => $request->comment,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new InsuranceBondQuote($insurancebond));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function referfriend(Request $request)
    {
        $refer = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'ffirstname' => $request->ffirstname,
            'flastname' => $request->flastname,
            'email' => $request->email,
            'femail' => $request->femail,
            'fnumber' => $request->fnumber,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new ReferFriendMail($refer));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
    public function autoform(Request $request)
    {
        $autoinsur = [
            'year' => $request->year,
            'make' => $request->make,
            'model' => $request->model,
            'drive' => $request->drive,
            'leased' => $request->leased,
            'distance' => $request->distance,
            'collision' => $request->collision,
            'mileage' => $request->mileage,
            'comprehensive' => $request->comprehensive,
            'year2' => $request->year,
            'make2' => $request->make,
            'model2' => $request->model,
            'drive2' => $request->drive,
            'leased2' => $request->leased,
            'distance2' => $request->distance,
            'collision2' => $request->collision,
            'mileage2' => $request->mileage,
            'comprehensive2' => $request->comprehensive,
            'year3' => $request->year,
            'make3' => $request->make,
            'model3' => $request->model,
            'drive3' => $request->drive,
            'leased3' => $request->leased,
            'distance3' => $request->distance,
            'collision3' => $request->collision,
            'mileage3' => $request->mileage,
            'comprehensive3' => $request->comprehensive,
            'year4' => $request->year,
            'make4' => $request->make,
            'model4' => $request->model,
            'drive4' => $request->drive,
            'leased4' => $request->leased,
            'distance4' => $request->distance,
            'collision4' => $request->collision,
            'mileage4' => $request->mileage,
            'comprehensive4' => $request->comprehensive,
            'drivername' => $request->drivername,
            'gender' => $request->gender,
            'married' => $request->married,
            'dob' => $request->dob,
            'status' => $request->status,
            'drivername2' => $request->drivername,
            'gender2' => $request->gender,
            'married2' => $request->married,
            'dob2' => $request->dob,
            'status2' => $request->status,
            'drivername3' => $request->drivername,
            'gender3' => $request->gender,
            'married3' => $request->married,
            'dob3' => $request->dob,
            'status3' => $request->status,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'email' => $request->email,
            'number' => $request->number,
            'insurancecompany' => $request->insurancecompany,
            'coverage' => $request->coverage,
            'policyexpire' => $request->policyexpire,
            'claim' => $request->claim,
            'ticket' => $request->ticket,
            'coveragedesired' => $request->coveragedesired,
            'comment' => $request->comment,
        ];
        $send = Mail::to('info@kwikinsurances.com')->send(new AutoInsuranceQuote($autoinsur));
        if ($send) {
            return redirect()->back()->with('success', 'Message Sent Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }
}
