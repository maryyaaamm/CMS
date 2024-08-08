<?php
// In UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users with counts of active and disapproved posts
        $users = User::withCount([
            'posts as active_posts_count' => function ($query) {
                $query->where('status', 'active')->where('approved', true);
            },
            'posts as disapproved_posts_count' => function ($query) {
                $query->where('approved', false);
            }
        ])->get();

        return view('posts.manageuser', compact('users'));
    }

    public function destroy(User $user)
    {
        // Delete the user from the database
        $user->delete();
        return redirect()->route('posts.manageuser')->with('success', 'User deleted successfully');
    }
}
