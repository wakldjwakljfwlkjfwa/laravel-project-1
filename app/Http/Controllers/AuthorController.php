<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index()
    {
        return Author::paginate();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        DB::beginTransaction();

        try {
            $user = User::factory()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $author = Author::create([
                'name' => $validated['name'],
                'user_id' => $user->id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $author;
    }
}
