<?php

use App\User;

class ProductAuthTest extends TestCase
{
    /**
     * Test authorization
     *
     * @param User $user
     * @param int $responseType
     */
    private function authTests(User $user, $responseType)
    {
        $this->actingAs($user);

        $product = factory('App\Product')->create();

        $this->get($this->PRODUCT_INDEX)
            ->assertResponseStatus($responseType);

        $this->get($this->PRODUCT_CREATE)
            ->assertResponseStatus($responseType);

        $productData = array_merge($product->toArray(), ['_token' => csrf_token()]);

        $this->post($this->PRODUCT_STORE, $productData)
            ->followRedirects()
            ->assertResponseStatus($responseType);

        $this->get(str_replace('{product}', $product->id, $this->PRODUCT_SHOW))
            ->assertResponseStatus($responseType);

        $this->get(str_replace('{product}', $product->id, $this->PRODUCT_EDIT))
            ->assertResponseStatus($responseType);

        $productData = array_merge($product->toArray(), ['_token' => csrf_token()]);

        $this->put(str_replace('{product}', $product->id, $this->PRODUCT_UPDATE), $productData)
            ->followRedirects()
            ->assertResponseStatus($responseType);

        $this->delete(str_replace('{product}', $product->id, $this->PRODUCT_DELETE), ['_token' => csrf_token()])
            ->followRedirects()
            ->assertResponseStatus($responseType);
    }

    /**
     * Test redirect if user not logged in
     */
    public function testNotLoggedIn()
    {
        $this->visit($this->PRODUCT_INDEX)
            ->seePageIs($this->LOGIN);
    }

    /**
     * Test page access if logged in as admin
     */
    public function testLoggedIn()
    {
        $user = factory('App\User', 'admin')->make();

        $this->actingAs($user);

        $this->visit($this->PRODUCT_INDEX)
            ->seePageIs($this->PRODUCT_INDEX);
    }

    /**
     * Non admin user should not have access
     */
    public function testNotAdmin()
    {
        $user = factory('App\User')->make();

        $this->authTests($user, $this->UNAUTHORISED_ACCESS);
    }

    /**
     * Admin user should have access
     */
    public function testAdmin()
    {
        $user = factory('App\User', 'admin')->make();

        $this->authTests($user, $this->ACCESS);
    }
}
