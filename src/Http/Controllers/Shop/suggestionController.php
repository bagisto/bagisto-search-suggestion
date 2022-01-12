<?php

namespace Webkul\suggestion\Http\Controllers\Shop;


use Webkul\Velocity\Repositories\Product\ProductRepository as VelocityProductRepository;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Product\Type\Configurable;


class suggestionController extends Controller
{
    use DispatchesJobs, ValidatesRequests;
   // protected $image_helper;

    protected $configurables;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;
     /**
     * ProductRepository object of velocity package
     *
     * @var \Webkul\Velocity\Repositories\Product\ProductRepository
     */
    protected $velocityProductRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     /**
     * Index to handle the view loaded with the search results
     *
     * @return \Illuminate\View\View
     */
    
    public function __construct(
        VelocityProductRepository $velocityProductRepository,
        Configurable $configurables
     )
    {   
        $this->_config = request('_config');
        $this->velocityProductRepository = $velocityProductRepository;
        $this->configurables = $configurables;
    }

    public function search()
    {
        $results = $this->velocityProductRepository->searchProductsFromCategory(request()->all());
        $images=[];
        $price=[];
        foreach($results as $key => $result){
            $productcategories[$key]=$result->product->categories;
            $price[$key] = $result->getTypeInstance()->getPriceHtml();
            $images[$key] = productimage()->getGalleryImages($result->product);
        }
        
        return [$results,$price,$images];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }
}
