<?php

namespace App\Http\Controllers\Company;

use App\Services\Interfaces\CompanyServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{    
    public function __construct(
        private readonly CompanyServiceInterface $companyService
    ) {}

    /**
     * Show company users.
     */
    public function index(Company $company)
    {
        $this->authorize('view', $company);

        $users = $company->users()->latest()->paginate(10);

        return view('company.users.index', compact('company', 'users'));
    }

    /**
     * Show invite user form.
     */
    public function create(Company $company)
    {
        $this->authorize('invite', $company);

        return view('company.users.create', compact('company'));
    }

    /**
     * Store invited user.
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('invite', $company);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $this->companyService->inviteUser($company, $validated);

        return redirect()
            ->route('company.users.index', $company)
            ->with('success', 'User invited successfully.');
    }

    /**
     * Activate user via fetch.
     */
    public function activate(Company $company, User $user)
    {
        $this->authorize('manageUsers', $company);

        $this->companyService->activateUser($user);

        return response()->json([
                'success' => true,
                'message' => 'User activated.',
                'user_id' => $user->id,
            ]);
    }

    /**
     * Deactivate user via fetch.
     */
    public function deactivate(Company $company, User $user)
    {
        $this->authorize('manageUsers', $company);

        $this->companyService->deactivateUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User deactivated.',
            'user_id' => $user->id,
        ]);
    }
}
