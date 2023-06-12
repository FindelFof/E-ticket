<?php

namespace App\Http\Controllers;

use App\Core\UseCases\UserAuthentication\UserAuthenticationUseCase;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserAlreadyExistsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserAuthenticationUseCase $userAuthenticationUseCase;

    public function __construct(UserAuthenticationUseCase $userAuthenticationUseCase)
    {
        $this->userAuthenticationUseCase = $userAuthenticationUseCase;
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="400", description="User already exists"),
     *     @OA\Response(response="500", description="An error occurred during user registration")
     * )
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            $name = $validatedData['name'];
            $email = $validatedData['email'];
            $password = Hash::make($validatedData['password']);

            $user = $this->userAuthenticationUseCase->registerUser($name, $email, $password);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } catch (UserAlreadyExistsException $e) {
            $errorMessage = $e->getMessage();

            return response()->json([
                'message' => $errorMessage,
            ], 400);
        } catch (\Exception $e) {
        }
    }






    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="User authenticated successfully"),
     *     @OA\Response(response="401", description="Unauthorized or Invalid email or password")
     * )
     * @throws InvalidCredentialsException
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $user = $this->userAuthenticationUseCase->authenticateUser($credentials['email'], $credentials['password']);

        if ($user) {
            if ($token = auth()->attempt($credentials)) {
                return $this->respondWithToken($token);
            } else {
                return response()->json(['error' => 'Unauthorized or Invalid email or password'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Get the authenticated User",
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Log the user out (Invalidate the token)",
     *     @OA\Response(response="200", description="Successfully logged out"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="500", description="An error occurred"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refresh a token",
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
