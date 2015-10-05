<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseTransactions;

    /**
     * Constants
     */
    protected $LOGIN = '/auth/login';

    protected $PRODUCT_INDEX = '/product';
    protected $PRODUCT_CREATE = '/product/create';
    protected $PRODUCT_STORE = '/product';
    protected $PRODUCT_SHOW = '/product/{product}';
    protected $PRODUCT_EDIT = '/product/{product}/edit';
    protected $PRODUCT_UPDATE = '/product/{product}';
    protected $PRODUCT_DELETE = '/product/{product}';

    protected $ACCESS = 200;
    protected $UNAUTHORISED_ACCESS = 403;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
