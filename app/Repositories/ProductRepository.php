<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface {
    protected $product;
	protected $config;
	public function __construct(Product $product) {
		$this->product = $product;
    }

	public function all($columns = array('*')) {}
    public function newInstance($attributes = array()) {}
    public function listProducts($order = 'id', $sort = 'desc', array $columns = array()){}
    public function deleteProduct(Product $product) {}
    public function removeProduct($id) {}
    public function paginate($perPage = 0) {
		$perPage = $perPage ? $perPage : $this->config->get('product.perPage');
		return $this->product->orderBy('id')->paginate($perPage);
	}
	public function createProduct(array $attributes) {}
	public function updateProduct(array $data) {}
	public function findProductByUrl(string $url) {}
	public function findProductById(int $id) {
		try {
            return $this->product->find($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
	}
    public function destroy($id) {}
}