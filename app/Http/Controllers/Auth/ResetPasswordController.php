<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPasswordToken;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    public function requestCode(RequestPasswordToken $request)
    {
        $user = User::where('email', $request->get('email'))->first();

        $token = PasswordToken::create([
            'user_id' => $user->id,
            'token' => Str::random(6),
            'expires_at' => Carbon::now()->addMinutes(60)
        ]);

        Mail::to($user)->queue(new ResetPasswordMail($token));

        return response()->json([
            'message' => 'The code was sent via email.'
        ], Response::HTTP_CREATED);
    }

    public function verifyCode(Request $request)
    {
        $token = PasswordToken::where('token', $request->get('token'))->firstOrFail();

        if (Carbon::now()->isAfter($token->expires_at)) {
            $token->delete();

            return response()->json([
                'message' => 'Token expired, please try again.'
            ]);
        }

        $jwt = Auth::login($token->user);

        return response()->json([
            'token' => $jwt
        ]);
    }
}
