@extends('User.master')
@section('shop-grid')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ URL::asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <?php if(stripos($_SERVER['REQUEST_URI'], 'shop-grid/')) :?>
                            <span><?php if (count($getProducts) != '0') {
                                echo $getProducts[0]->name;
                            } ?></span>
                            <?php else : ?>
                            <span>Shop</span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">

                        <div class="sidebar__item">
                            <h4>Price</h4>
                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="10" data-max="540">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minamount">
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Latest Products</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">
                                        <?php $count = 1; ?>
                                        @foreach ($getLatestProduct as $row)
                                            <?php
                                                $count++;
                                                $img = '/img/product/' . $row->image1;
                                                $id = '/shop-details/' . $row->id;
                                            ?>
                                            <a href="{{ URL($id) }}" class="latest-product__item">
                                                <div class="latest-product__item__pic small_item">
                                                    <img src="{{ URL::asset($img) }}" alt="">
                                                    <?php if ($row->sales > 0) :?>
                                                    <div class="product__discount__percent">-{{ $row->sales }}%</div>
                                                    <?php endif ?>
                                                </div>
                                                <div class="latest-product__item__text product__discount__item__text text-left">
                                                    <h6>
                                                        <?php if (strlen($row->name) > 25) {
                                                        echo substr($row->name, 0, 25) . '...';
                                                            } 
                                                            else {
                                                                echo $row->name;
                                                                }
                                                            ?>
                                                    </h6>
                                                    <div class="product__item__price text-dark font-weight-bold">
                                                        <?php if ($row->sales > 0) :
                                                            $moneySales = $row['price'] * $row['sales'] / 100;
                                                            $moneySales = $row['price'] - $moneySales;
                                                        ?>
                                                        $<?php echo number_format($moneySales, 2, '.', ''); ?>
                                                        <br>
                                                        <span class="ml-0">$<?php echo number_format($row['price'], 2, '.', ''); ?></span>
                                                        <?php else : ?>
                                                        $<?php echo number_format($row['price'], 2, '.', ''); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php if($count > 3) { ?>
                                                @break
                                            <?php } ?>
                                        @endforeach
                                    </div>
                                    <div class="latest-prdouct__slider__item">
                                        <?php $count = 1; ?>
                                        @foreach ($getLatestProduct as $row)
                                            <?php
                                            $count++;
                                            if ($count < 5) {
                                            ?>
                                            @continue
                                            <?php
                                            }
                                            $img = "/img/product/" . $row->image1;
                                            $id =  '/shop-details/' . $row->id;
                                            ?>
                                            <a href="{{ URL($id) }}" class="latest-product__item">
                                                <div class="latest-product__item__pic small_item">
                                                    <img src="{{ URL::asset($img) }}" alt="">
                                                    <?php if ($row->sales > 0) :?>
                                                    <div class="product__discount__percent">-{{ $row->sales }}%</div>
                                                    <?php endif ?>
                                                </div>
                                                <div class="latest-product__item__text product__discount__item__text text-left">
                                                    <h6><?php if (strlen($row->name) > 25) {
                                                        echo substr($row->name, 0, 25) . '...';
                                                    } else {
                                                        echo $row->name;
                                                    } ?>
                                                    </h6>
                                                    <div class="product__item__price text-dark font-weight-bold">
                                                        <?php if ($row->sales > 0) :
                                                            $moneySales = $row['price'] * $row['sales'] / 100;
                                                            $moneySales = $row['price'] - $moneySales;
                                                        ?>
                                                        $<?php echo number_format($moneySales, 2, '.', ''); ?>
                                                        <br>
                                                        <span class="ml-0">$<?php echo number_format($row['price'], 2, '.', ''); ?></span>
                                                        <?php else : ?>
                                                        $<?php echo number_format($row['price'], 2, '.', ''); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php if($count > 6) { ?>
                                                @break
                                            <?php } ?>
                                        @endforeach
                                    </div>
                                </div>            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Sale Off</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-1.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Raisin’n’nuts</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-2.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Vegetables</span>
                                            <h5><a href="#">Vegetables’package</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-3.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Mixed Fruitss</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-4.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Raisin’n’nuts</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-5.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Raisin’n’nuts</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="img/product/discount/pd-6.jpg">
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <h5><a href="#">Raisin’n’nuts</a></h5>
                                            <div class="product__item__price">$30.00 <span>$36.00</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span><?php echo count($countAllProduct); ?></span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($getProducts as $products)
                            <?php
                            $img = '/img/product/' . $products->image1;
                            $id = '/shop-details/' . $products->product_id;
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ URL::asset($img) }}">
                                        <ul class="product__item__pic__hover">
                                            {{-- <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li> --}}
                                            <li><a onclick="AddCart({{ $products->product_id }})"
                                                    href="javascript:"><i class="fa fa-shopping-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a
                                                href="#">{{ substr($products->product_name, 0, 30) . '...' }}</a>
                                        </h6>
                                        <h5>{{ $products->price }}$</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{ $getProducts->onEachSide(1)->appends(request()->all())->links('vendor.pagination.my-paginate') }}
                </div>
            </div>
        </div>
    </section>
<!-- Product Section End -->
@endsection
