<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Doctor;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      
        $user = array();
        $user = Auth::user();
        $doctor = User::where('type', 'doctor')->get();
        $doctorData = Doctor::all();
        //Now return appointment of today together with user data
        $date = now()->format('m/d/y');
        $appointment = Appointments::where('date',$date)->first();

        foreach ($doctorData as $data) {
            foreach ($doctor as $info) {
                if ($data['doc_id'] == $info['id']) {
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                   
                }
            }
        }

        $user['doctor'] = $doctorData;

        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        // Validate incoming inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check matching user
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }

        // Return generated token
        return $user->createToken($request->email)->plainTextToken;
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Validate incoming inputs
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'user',
            'password' => Hash::make($request->password),
        ]);

        $userInfo = UserDetails::create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        return $user;
    }
}
?>
