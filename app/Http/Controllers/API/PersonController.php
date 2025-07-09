<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StorePersonRequest;
use App\Service\PersonService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckSomething;
use App\Models\Person; // Added this import for the new updatePerson method

class PersonController extends Controller
{
    protected $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function index(Request $request)
    {
        $people = $this->personService->paginated($request->per_page ?? 10);
        return ApiResponse::success($people, 'People fetched successfully');
    }

    public function create()
    {
        return ApiResponse::success(null, 'Create person form data');
    }

    public function store(StorePersonRequest $request)
    {
        $person = $this->personService->store($request);
        return ApiResponse::success($person, 'Person created successfully', 201);
    }

    public function show($id)
    {
        $person = $this->personService->getPerson($id);
        return ApiResponse::success($person, 'Person fetched successfully');
    }

    public function edit($id)
    {
        $person = $this->personService->getPerson($id);
        return ApiResponse::success($person, 'Person fetched successfully');
    }

    public function update(StorePersonRequest $request, $id) 
    {
        $validated = $request->validated();
        $person = $this->personService->updatePerson($id, $validated);
        return ApiResponse::success($person, 'Person updated successfully');
    }

    public function destroy($id)
    {
        $person = $this->personService->deletePerson($id);
        return ApiResponse::success($person, 'Person deleted successfully');
    }

    public function getPersonWithPosts($id)
    {
        $person = $this->personService->getPersonWithPosts($id);
        return ApiResponse::success($person, 'Person with posts fetched successfully');
    }

    public function getAllPeople()
    {
        $people = $this->personService->getAllPeople();
        return ApiResponse::success($people, 'All people fetched successfully');
    }
}
