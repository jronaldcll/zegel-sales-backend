<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;

use App\Repositories\SaleRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Sale Repository class.
     *
     * @var SaleRepository
     */
    public $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->saleRepository = $saleRepository;
    }


    public function index(): JsonResponse
    {
        try {
            $data = $this->saleRepository->getAll();
            return $this->responseSuccess($data, 'Sale List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->saleRepository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Sale List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->saleRepository->searchSale($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Sale List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request): JsonResponse
    {
        try {
            $sale = $this->saleRepository->create($request->all());
            return $this->responseSuccess($sale, 'New Sale Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->saleRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Sale Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Sale Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->saleRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Sale Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Sale Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $sale =  $this->saleRepository->getByID($id);
            if (empty($sale)) {
                return $this->responseError(null, 'Sale Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->saleRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the sale.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($sale, 'Sale Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
