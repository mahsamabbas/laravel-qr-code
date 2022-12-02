<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Passport;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->getMessageBag(),
                'status' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_OK);
        }
        if (auth()->attempt($request->all())) {
            return response([
                'user' => auth()->user(),
                'access_token' => auth()->user()->createToken('authToken')->accessToken,
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }

        return response([
            'message' => 'This User does not exist',
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'password_confirm' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->getMessageBag(),
                'status' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_OK);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function client(Request $request)
    {
        $client = DB::table('oauth_clients')->first();
        if ($client) {
            return response()->json([
                'client-secret' => $client->secret,
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' =>  'No client registered yet',
                'status' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_OK);
        }
    }
}




























































