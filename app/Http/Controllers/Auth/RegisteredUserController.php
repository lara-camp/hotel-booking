<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_image' => 'nullable|image',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id  = 2;

        if($request->profile_image) {
            $profile_image = $request->file('profile_image');
            $profile_image_path = 'profile_images/' . time() . '.' . $profile_image->getClientOriginalExtension();

            // copy the file under public folder >> profile_images
            $profile_image->move(public_path('profile_images'), $profile_image_path);

            // save the file path to db
            $user->profile_image = $profile_image_path;
        }

        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(auth()->user()->getRedirectRoute());
    }
}
