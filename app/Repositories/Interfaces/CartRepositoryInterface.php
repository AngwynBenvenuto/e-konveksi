<?php
namespace App\Repositories\Interfaces;
// use App\Models\Vendor;
// use App\Models\Member;
use App\Repositories\BaseRepositoryInterface;
use App\Models\Product;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;

interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function addToCart(Product $product, int $int, $options = []) : CartItem;
    public function getCartItems() : Collection;
    public function removeToCart(string $rowId);
    public function countItems() : int;
    public function getSubTotal(int $decimals = 2);
    public function getTotal(int $decimals = 2, $shipping = 0.00);
    public function updateQuantityInCart(string $rowId, int $quantity) : CartItem;
    public function findItem(string $rowId) : CartItem;
    public function getTax(int $decimals = 2);
    //public function getShippingFee(Vendor $courier);
    public function clearCart();
    //public function saveCart(Member $customer, $instance = 'default');
    //public function openCart(Member $customer, $instance = 'default');
    public function getCartItemsTransformed() : Collection;
}