<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\BookingForm;
use App\Http\Controllers\Api\BaseController as BaseController;

class BookingFormApiController extends BaseController
{
    public function store(Request $request)
    {
        $hammam = null;
        $massage = null;
        $checksum = true; // default:true
        $validator = Validator::make($request->all(), [
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'name_surname' => 'required',
            'hammam_package' => 'array',
            'massage_package' => 'array',
            'phone' => 'required',
            'country' => 'required',
            'male_pax' => 'required',
            'female_pax' => 'required',
        ]);
        $validator->sometimes('hammam_package', 'required_without:massage_package', function ($input) {
            return !isset($input->massage_package);
        });
        $validator->sometimes('massage_package', 'required_without:hammam_package', function ($input) {
            return !isset($input->hammam_package);
        });
        if ($request->hammam_package != "") {
            $hammam = implode(' - ', $request->hammam_package);
        }
        if ($request->massage_package != "") {
            $massage =  implode(' - ', $request->massage_package);
        }
        if ($hammam == '' && $massage == '') {
            $checksum = false; // if there are any Hammam or Massage Package and then checksum will be true
        }
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            if (intval(BookingForm::where('reservation_date', $request->reservation_date)->where('reservation_time', $request->reservation_time)->count()) == 0) {
                if ($checksum) {
                    BookingForm::create([
                        'reservation_date' => $request->reservation_date,
                        'reservation_time' => $request->reservation_time,
                        'name_surname' => $request->name_surname,
                        'phone' => $request->phone,
                        'country' => $request->country,
                        'massage_package' => $massage,
                        'hammam_package' => $hammam,
                        'male_pax' => $request->male_pax,
                        'female_pax' => $request->female_pax,
                        'form_status_id' => 1,
                        'answered_time' => null,
                    ]);
                    return response()->json([
                        'code' => 200,
                        'data' => 'We Recieved Your Booking Successfully',
                    ]);
                } else {
                    return response()->json([
                        'code' => 400,
                        'data' => 'You Must Select Minimum One Package From Hammam Or Massage',
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'You Already Have a Booking on that Day/time',
                ]);
            }
        }
    }
}
