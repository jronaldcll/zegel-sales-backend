<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class SaleRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    /**
     * Get All Sales.
     *
     * @return collections Array of Sale Collection
     */
    public function getAll(): Paginator
    {
        return $this->user->sales()
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
    }

    /**
     * Get Paginated Sale Data.
     *
     * @param int $pageNo
     * @return collections Array of Sale Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Sale::orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Sale Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Sale Collection
     */
    public function searchSale($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Sale::where('client', 'like', '%' . $keyword . '%')
            ->orWhere('currency', 'like', '%' . $keyword . '%')
            ->orWhere('total', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New Sale.
     *
     * @param array $data
     * @return object Sale Object
     */
    public function create(array $data): Sale
    {
        // dd($data);
        // dump($data);
        // $sales_detail =[
        //     'product' => 'Mouse Gamer genérico',
        //     'description' => 'Mouse Gamer con 6 botones',
        //     'price' => 100,
        //     'qty' => 10,
        // ];
        // \Illuminate\Support\Facades\Log::info($data['sale_detail']);
        // $data['sale_detail'] = $sales_detail;
        $data['user_id'] = $this->user->id;

        return Sale::create($data);
    }

    /**
     * Delete Sale.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $sale = Sale::find($id);
        if (empty($sale)) {
            return false;
        }

        $sale->delete($sale);
        return true;
    }

    /**
     * Get Sale Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Sale|null
    {
        return Sale::with('user')->find($id);
    }

    /**
     * Update Sale By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Sale Object
     */
    public function update(int $id, array $data): Sale|null
    {
        $sale = Sale::find($id);

        if (is_null($sale)) {
            return null;
        }

        // If everything is OK, then update.
        $sale->update($data);

        // Finally return the updated sale.
        return $this->getByID($sale->id);
    }
}
