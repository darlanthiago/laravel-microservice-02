<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Jobs\EvaluationCreated;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function __construct(
        protected Evaluation $repository,
        protected CompanyService $companyService,
    ) {
    }


    /**
     * Display a listing of the resource.
     * @param  string  $company
     * @return \Illuminate\Http\Response
     */
    public function index($company)
    {
        $evaluations = $this->repository->where('company', $company)->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEvaluation $request, string $company)
    {

        $response = $this->companyService->getCompany($company);

        if (!$response->ok()) {

            return response()->json(['message' => 'Company Not Found'], $response->status());
        }

        $evaluation = $this->repository->create($request->validated());

        $company = $response->json();

        EvaluationCreated::dispatch($company['data']['email'])->onQueue('queue_email');

        return new EvaluationResource($evaluation);
    }
}
