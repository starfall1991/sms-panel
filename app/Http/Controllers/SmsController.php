<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmsPostRequest;
use App\Http\Resources\SmsResource;
use App\Models\User;
use App\Notifications\SmsNotification;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SmsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  User  $user
     * @param  SmsPostRequest  $request
     *
     * @return JsonResponse
     */
    public function __invoke(User $user, SmsPostRequest $request): JsonResponse
    {
        $sms = $user->sms()->create([
            'text' => $request->input('text'),
        ]);

        $user->notify(new SmsNotification());

        return (new SmsResource($sms))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
