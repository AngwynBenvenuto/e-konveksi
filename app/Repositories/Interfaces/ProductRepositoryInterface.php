<?php
namespace App\Repositories\Interfaces;
use App\Repositories\BaseRepositoryInterface;
use App\Models\Product;

interface ProductRepositoryInterface extends BaseRepositoryInterface {
    public function all($columns = array('*'));
    public function newInstance(array $attributes = array());
    public function paginate($perPage = 9);
    public function listProducts($order = 'id', $sort = 'desc', array $columns = array());
    public function createProduct(array $data);
    public function updateProduct(array $data);
    public function findProductById(int $id);
    public function findProductByUrl(string $url);
    public function deleteProduct(Product $product);
    public function removeProduct($id);
    public function destroy($id);
}